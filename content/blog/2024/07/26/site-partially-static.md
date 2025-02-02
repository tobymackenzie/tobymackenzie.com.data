---
categories: [www]
date: 2024-07-26T14:59:00-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4393'
id: 4393
modified: 2024-07-26T15:14:05-04:00
name: site-partially-static
tags: [apache, change, site, static]
---

Site partially static
=====================

I am pleased to say that most of the non-blog parts of my site are now served from static files.  I have been working toward making a static version of my site for a while.  I have created a [PHP static web task](https://github.com/tobymackenzie/static-web-tasks.php) that can crawl a site and turn the responses into an Apache friendly directory structure.  Those pages now can be served extra fast, without going through PHP, and could be served on a free static host if I wanted.  To go static, I not only had to write the code to build the static files, but also had to modify my site code to have the desired output when called from that context and modify my Apache configuration to respond correctly and add some headers that were being added by PHP before.

<!--more-->

Why
----

Performance and server simplicity are automatic benefits of static sites.  Basically any web server can run them, and they don't have to take time to fire up an interpreter, run some code, and grab some data for each request.  There are even many free static hosts like Github Pages, Cloudflare Pages, Digital Ocean, Netlify, etc.  And on a paid VPS, the load a static site puts on the server is minimal, allowing for a cheaper server.

I've been thinking about what will happen to my site in the future.  After I die, certainly, but also as I get older and may not want to deal with keeping things up to date.  With a VPS, I have to keep the server OS and software up to date at the least for security reasons.  And as I update PHP, MySQL, etc, I will at some point need to update my code to deal with breaking changes.  A static site gets rid of this problem and should work as long as the web works.  My needs to update will be limited, and when I'm unable or gone, it will be easier for someone else to do so if they want to.

Code
------

I had been preparing for at least a partially static site for a while.  I had begun eliminating things from the templates that varied per request in the code and taking it into account for new features, such as moving some redirect code to JS and implementing some date-based messages in JS instead of being done server side.  This somewhat simplified the templates and related code, though it did add some weight to my JS download.

I spent a fair amount of time building my static web task and associated [web crawler](https://github.com/tobymackenzie/web-crawler.php), and I modified them several times to deal with issues I discovered in making them work on my site.  The [code needed in my site repo](https://github.com/tobymackenzie/tobymackenzie.com.site/blob/e899d910e1edf7756a98595b0a5aff4c6896653a/src/PublicApp/Service/Build.php#L260C39-L336) is fairly short, mostly setting up configuration, building a list of the page paths that need to be built, and getting responses for those requests through Symfony's kernel, since that part of my site is built using Symfony, then grabbing the content and necessary headers in a callback for the static web task to use.  To ensure the proper domain, I had to set the context host for Symfony's router, like:

``` php
$this->router->getContext()->setHost('www.tobymackenzie.com');
```

and then pass the host and https request headers to the 6th argument of Symfony's `Request::create()` like:

``` php
$request = Request::create($path, 'GET', [], [], [], [
	'HTTP_HOST'=> $host,
	'HTTPS'=> 'on',
]);
```

which was then passed to `$kernel->handle()`.  Those are probably the main things of note for the actual building code.

I did also have to modify the template / controller code in a few places to make sure the output is for my production domain and version of the site.  To make this easier, I put a static property and method on my `Build` class that contains the build code, so that in other places in PHP, I can just check `Build::isBuilding()` to change what happens for the build output.  One example: For my robots.txt, I output a disallow all for the dev version of my site, but want to have my production version that allows bots on the static version of that file (yes, I build my robots.txt through PHP).

Apache conf
--------

My Apache configuration (mostly via htaccess) needed some changing to accommodate the static versions of the pages.  The biggest part of this was ensuring that Apache served page nodes with the path format I want and is used by my Symfony routes, meaning without a trailing slash like '/about', and redirect the trailing slash version of paths, eg '/about/', to that.  To make this work best, I output my page nodes at their desired path with a trailing `.html` so that Apache would give the right MIME type, then used `mod_rewrite` to serve the right file.  `mod_rewrite` was also used to redirect to the proper canonical path.  My resulting directory structure from my static web task looks something like:

```
about.html
dir.html
dir
	/sub-path.html
	/sub-path-2.html
index.html
web-dev.html
```

The Apache conf code to force the canonical version of the path looks like:

``` conf
<IfModule mod_rewrite.c>
	RewriteEngine On
	# home special handling
	RewriteRule ^/?index(\.html)?/?$ / [END,QSA,R]
	# no trailing slash
	RewriteCond %{REQUEST_FILENAME}\.html -f
	RewriteRule ^(.*)/$ /$1 [END,QSA,R]
	# no .html
	RewriteCond %{REQUEST_FILENAME} -f
	RewriteRule ^(.+)\.html$ /$1 [END,QSA,R]
```

A separate rule is required for the home page `index.html` since it's handled slightly different.  For the others, there are `-f` tests on the `%{REQUEST_FILENAME}` to only do the redirect if needed.

I use Apache's `<If>` directive to turn off the `DirectorySlash` setting when there is a file for the given requested page node.  Otherwise, in my example directory structure above, a request for '/dir' would redirect to '/dir/' instead of showing the `dir.html` file.  That looks like:

``` conf
	<If "-d '%{REQUEST_FILENAME}' && -f '%{REQUEST_FILENAME}\.html'">
		DirectorySlash Off
	</If>
```

The bit to do the rewrite that shows the pages checks if the `%{REQUEST_FILENAME}` with `.html` appended points to a file (`-f`), and if so, serves that up without sending a redirect.

``` conf
	RewriteCond %{REQUEST_FILENAME}\.html -f
	RewriteRule ^ %{REQUEST_URI}.html [END]
```

Since parts of my site, such as the blog, still go through PHP, I follow that up with the conf that serves files directly and sends all other requests to a `.php` file.  That looks like:

``` conf
	#--serve existing files directly
	RewriteCond %{REQUEST_FILENAME} -f [OR]
	#--show dir index files
	RewriteCond %{REQUEST_FILENAME}/index.html -f [OR]
	RewriteCond %{REQUEST_FILENAME}/index\.php -f
	RewriteRule ^ - [L]

	##===serve wordpress for appropriate urls
	RewriteRule ^blog _/wp/index.php [END]
	##===all other routes go through symfony
	RewriteRule ^ /index.php [L]
</IfModule>
```

That all took a while to put together, but does exactly what I want, allowing me to serve my static files when they exist at the routes I want and otherwise do the previous PHP behavior.

In doing this move, I also had to move various response header configuration to Apache that was previously handled through Symfony.  One change was ensuring the proper charset was added to responses.  With default Apache settings, it wasn't setting this for some responses, and special characters were showing wrong.  Conf looks like:

``` conf
AddDefaultCharset utf-8
AddCharset utf-8 .css .js .md .svg .xhtml
```

For some security and other headers, I used the `Header` directive with the `setifempty` option to allow PHP to override these when applicable.  I use an expression syntax to ensure the ones that should only be served with HTML, aren't served for other responses, looking like `"expr=%{CONTENT_TYPE} =~ /html/"`.  The most complex one was the `Content-Security-Policy` (CSP) header that prevents modern browsers from loading assets that aren't from whitelisted sources.  WordPress injects lots of stuff in both the front-end and admin area.  For ease, I just don't send a CSP for any of those paths.  I also have slightly different requirements for some example files.  I again used Apache's `<If>` and related directives to handle different paths differently.  That looks like:

``` conf
<If "%{REQUEST_URI} =~ m#^/?_/wp/wp-admin#i || %{REQUEST_URI} =~ m#^/?blog/#i || %{REQUEST_URI} =~ m#^/?_/wp/index\.php#i">
	#-# do nothing
</If>
<ElseIf "%{REQUEST_URI} =~ m#^/?examples/#i">
	Header setifempty Content-Security-Policy "default-src 'self' 'unsafe-inline' data:" "expr=%{CONTENT_TYPE} =~ /html/"
</ElseIf>
<Else>
	Header setifempty Content-Security-Policy "default-src 'self' data:; frame-src 'self' www.youtube.com;block-all-mixed-content" "expr=%{CONTENT_TYPE} =~ /html/"
</Else>
```

Finally, I was sending custom `Cache-Control` headers for many pages to allow some short term cacheing for them.  I had to enable this for all HTML / XHTML pages through Apache, like:

``` conf
<IfModule mod_expires.c>
	ExpiresActive on
	ExpiresByType text/html 'access plus 10 minutes'
	ExpiresByType application/xhtml+xml 'access plus 10 minutes'
</IfModule>
```

So
------

Now my non-blog pages are served quickly without going through PHP.  The simple structure may one day allow me to serve the site, or even just a mirror of it, for free from a static hosting provider.

The only real annoyance with this setup is that I have to remember to run the build script before deploying if I've made changes to page content or templates.  I may have to automate it, but it's slow enough, maybe 5-10 seconds, that I wouldn't want it to happen for every deploy, such as for CSS and JS changes or composer dependency updates.

I still want to make my blog static.  That will probably be a lot of work and require moving off of WordPress.  I would have to build my own software to manage that, though I don't think it would be too hard to add the basic page display functionality to my [wiki-site](https://github.com/tobymackenzie/wiki-site.symf) repo that is used for my non-blog pages.  I will definitely lose some functionality moving from WordPress, and especially if I go full static.  Without server side code running, I won't be able to do a blog search, but I can just go through Google / DuckDuckGo like I do for my regular pages.  I wouldn't be able to support pingbacks unless I use a third party service.  But those are trade-offs I will likely be fine with at some point.
