---
name: wiki-blog-post-publish
date: 2026-06-05T15:19:59-04:00
categories: [www]
tags: [blog, site, project]
id: 4877
guid: 'https://www.tobymackenzie.com/blog/2026/06/05/wiki-blog-post-publish.md'
---

wiki-blog post publishing
=========================

I switched my [blog away from WordPress](/content/blog/2026/05/26/wordpress-gone) and to my own [wiki-blog](https://github.com/tobymackenzie/wiki-blog.php) software a little over a week ago.  I did so even without an easy way to publish posts, as I had to create the date based folder structure, increment an id, enter formatted dates and other meta-data, and run a rebuild of my static list pages, all manually.  After a fair amount of work, I now have an automated way to do most of this via CLI.
<!--more-->

I just create and enter my post in a markdown file either as `drafts.md` or `{slug}.md`, then run a Symfony console based [`bin/console blog:publish` command](https://github.com/tobymackenzie/wiki-blog.php/blob/v0.0.10/src/Command/PublishPostCommand.php).  This calls a [`Blog->publish()` method](https://github.com/tobymackenzie/wiki-blog.php/blob/v0.0.10/src/Blog.php#L598) where most of the logic happens.  The command asks for category and tags, then it moves the file to the correct directory structure, renames the file if needed to have the proper slug or ID name, generates the YAML meta-data, then commits and pushes it so it will be published somewhere (Github), even if not on my blog yet.  I'm a little nervous about those last two steps, but that's the only way that the auto-generated date will be technically correct.

The main things it doesn't do are build the static files and deploy to my server.  These are not part of my wiki-blog functionality, so this will probably be done via an event dispatcher.  Also, the static build process takes too long, so I need to create something to allow me to only regenerate the post and related files, eg the front page, tag and category lists, date based lists, and previous post (for next post link).  I think that'll take a little while with what I currently have, where it just regenerates everything and checks each file to see if it is modified.  I will likely have to extract some logic from the current code and create a separate code path.

I still have to handle images / media and creating new categories and tags manually.  Those will likely come with other commands, as will running an update on an existing post, which would update the time-stamp and eventually build and deploy.  I also might like a preview before publishing / updating so I can read it and see it generated, abort the publish if I need to go back and edit.  I find it easier to proofread the final generated content.

In doing this, I got to create an autocomplete functionality for Symfony's console `Question` helper.  It allows me to have tab completion when entering categories and tags so I can space OR comma separate them and still complete the later ones.  I will try to blog about this soon, as I think it's fairly neat.

This post will be my first real test of this command.  Here's hoping.
