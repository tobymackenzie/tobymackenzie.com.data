---
categories: [www]
date: 2022-12-15T14:13:10-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3908'
id: 3908
modified: 2022-12-15T14:14:22-05:00
name: playing-github-pages
tags: [build, death, github, php, site, static]
---

Playing with GitHub Pages
=========================

This past weekend, I started playing with [GitHub Pages](https://docs.github.com/en/pages) for the first time.  It took a while to figure out, but was somewhat fun.  I've been interested in it for a while, but was unsure of how to do what I wanted, such as building with PHP, Sass, and Rollup.  Turns out it was fairly easy with GitHub Actions to do most any sort of build steps I want.  It is very interesting for free static site web-hosting.

<!--more-->

Static sites
-------

GitHub Pages is a free static web-hosting service provided by GitHub.  It cannot do any server-side processing like PHP on the live site, but can be tied into (generally) free GitHub Actions to run PHP or other server side languages to build the site, so we don't have to commit build artifacts to our git repos.  As a static site, it cannot have the dynamic capabilities on the server that some sites need, such as e-commerce or user-submitted content.  Those could be handled with JS through third-party services though.  It provides a free domain name of "{username}.github.io", or can be pointed to by any domain we own.

There are many advantages of static sites including:

- fast server responses (just need to serve a file)
- simplified server architecture
- CDN caching options for HTML (not dynamic)
- limited server-side security vulnerabilities (can't run scripts)
- no need to update server-side software
- potentially free hosting

The main driver of my interest, currently, is what happens to my site after I die.  I might be able to get someone to manage my site, but even if they're able to, eventually the server-side software will become so old that, even if it doesn't end up with security vulnerabilities, the host might not want to keep around that old version of PHP or allow that old version of WordPress.  A static site would be less likely to have that sort of problem.  GitHub seems like the least likely service I've seen to drop an account from inactivity, and its free subdomain could become a fallback if my tobymackenzie.com domain expires due to non-payment.

The main limitations of GitHub Pages in particular for me, as static hosting goes, are the lack of redirects and lack of control of HTTP headers.  There is no way to define 30x redirects for given URL paths.  A meta or JS redirect page can be set up for each redirect, but this is cumbersome and limited to only HTML documents.  The headers would be nice to have for doing [security headers](/content/blog/2015/12/21/security-http-headers.md) like `Content-security-policy` and other such headers.  Since I've blogged about them, I'd like my site to have them and have control over them.  These limitations probably mean I won't use this for my primary site, but maybe a mirror, and I also might use it for client sites that don't require server-side processing.

Create Pages site
------

Each user account gets only one user site that has the free "{username}.github.io" domain, but unlimited project sites, which can have custom domains.  Without a custom domain, the project site would be accessed at "{username}.github.io/{projectname}", so not exactly its own site.  The user site is created with a repo, which unfortunately has to be named "{username}.github.io".  Go to "Settings > Pages" to configure it for GitHub Pages.  By default, it will build using Jekyll, converting any markdown files in the repo to HTML. 

Build
------

[To do a custom build](https://docs.github.com/en/pages/getting-started-with-github-pages/configuring-a-publishing-source-for-your-github-pages-site#publishing-with-a-custom-github-actions-workflow), on the Pages config, select a "Build and Deployment" "Source" of "GitHub Actions".  This will give you an option to use one of their action workflows or create your own.  I used [one of their actions as a starting point](https://github.com/actions/starter-workflows/blob/main/pages/jekyll-gh-pages.yml) to learn how it worked, then used it as a template to build my own.  The build is on a Ubuntu virtual machine (other OS's can be chosen) that can do anything a Ubuntu virtual machine can do, if run only for the duration of the build.  An account gets 2000 free minutes of build per month.

Each workflow becomes a YAML file in the `.github/workflows` folder, committed with the project.  It has an `on` setting to define when to run the workflow, where on push of the given branch is the norm for a Pages project.  It has a `jobs` setting to define all tasks of the workflow.  Each task can do things like call a predefined action with `uses` or `run` a command line command.

The starting machine already has PHP, Composer, node js, and various other languages and tools installed by default.  It also has `apt` and `npm` to install other tools.  So it will have access to anything a Ubuntu machine could, and PHP or node builds can run as is.

My workflow ended up looking like this:

``` yaml
name: Build and Deploy GitHub Pages
on:
  #--run whenever pushing to chosen branch
  push:
    branches: ['main']
  #--allow manual run
  workflow_dispatch:
#--permissions to allow deployment
permissions:
  contents: read
  pages: write
  id-token: write
#--prevent previous runs from overwriting latest
concurrency:
  group: "pages"
  cancel-in-progress: true
#--tasks to run
jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - name: Check out project repo
        uses: actions/checkout@v3
      - name: Update system
        run: sudo apt-get update
      - name: Configure GH Pages
        uses: actions/configure-pages@v2
      - name: Validate composer
        run: composer validate --strict
      - name: Cache composer deps to save time on subsequent runs
        id: composer-cache
        uses: actions/cache@v3
        with:
          path: vendor
          key: composer-${{ hashFiles('**/composer.lock') }}
          restore-keys: 'composer-'
      - name: Install PHP deps
        run: 'composer install --no-progress --prefer-dist'
      - name: Install system deps
        run: 'sudo apt install rollup sassc uglifyjs'
      - name: Make dist dir
        run: 'mkdir dist'
      - name: PHP build
        run: php build.php
      - name: Upload GH artifact
        uses: actions/upload-pages-artifact@v1
        with:
          path: ./dist
  deploy:
    environment:
      name: github-pages
      url: ${{ steps.deployment.outputs.page_url }}
    runs-on: ubuntu-latest
    needs: build
    steps:
      - name: Deploy GH Pages
        id: deployment
        uses: actions/deploy-pages@v1
```

where the `build.php` script in the repo does the actual build, using [league/commonmark](https://github.com/thephpleague/commonmark) to convert markdown to HTML, and running the `rollup` and `sassc` commands to build assets.  The comments and `name` fields should largely tell what each part is doing, but roughly, when a push to the "main" branch happens, on a Ubuntu VM, it:

1. checks out the site repo and my main site 
2. validate, load from cache, and install composer components
3. install system dependencies
4. run PHP build script to put files in `dist` folder
5. create artifact (.tar.gz) of `dist` folder
6. deploys the artifact to GitHub Pages

The whole process can take around a minute to run.

It took me a while to get all this figured out, but overall, it is pretty simple and capable.  It can do everything I should need it to without much trouble.  Having the workflow committed to the repo as a YAML file makes it reproducible and easy to change.  And so far it seems quick enough that I won't have problems with the minute limitation.

Fin
----

I will continue to play with this and maybe try some other options.  Cloudflare Pages is another free static hosting provider with free builds.  Their VMs seem more limited, and they seem more likely to eventually drop a dormant site.  But they do allow custom headers and redirects through configuration files.  GitLab also has a Pages service, as well as some others.

If I want a static mirror for my site, I will need to work to make my site more friendly to this and have a build script to create the static distribution.  I will likely want to remove WordPress and replace it with a PHP build using markdown files as a source.  Once I do that, the static build should be fairly straightforward and quick enough for GitHub Actions or alternatives.

I will do more research as to which service is likely to last after I die, or maybe I'll have multiple mirrors going.
