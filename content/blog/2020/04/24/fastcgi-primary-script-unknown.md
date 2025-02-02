---
categories: [www]
comment_count: 1
date: 2020-04-24T00:51:42-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=2816'
id: 2816
modified: 2020-04-24T00:51:42-04:00
name: fastcgi-primary-script-unknown
tags: [apache, fastcgi, log, php, problem]
---

FastCGI and "Primary Script Unknown"
====================================

If you're routing requests for script file names through [FastCGI](https://en.wikipedia.org/wiki/FastCGI), and don't have some rule to catch requests for unknown scripts, you might find errors like:

```
Got error 'Primary script unknown\n'
``` 
in your error log.<!--more-->  In this common way to setup FastCGI, the web server will be using some rule such as:

``` conf
<FilesMatch ".+\.php$">
		SetHandler "proxy:unix:/run/php/php7.2-fpm.sock|fcgi://localhost"
</FilesMatch>
```

to tell it to route requests ending in `.php` through FastCGI, sending the filepath from the web root.  If there is no file there, though, FastCGI will throw an error, which may end up in the server logs, and may show up as `File not found` to the visitor.  Usually, when you're running a CMS or the like, it will have something like:

``` conf
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteRule ^index\.php$ - [L]
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule . /index.php [L]
</IfModule>
```

to rewrite these requests, so they don't end up as non-existent script paths when sent to FastCGI.  But if you don't have something like that, then you might find this error.

Assuming you don't want what is basically a 404 in your error logs, and do want a normal 404 sent to the visitor, you can set up a catch-all 404 response for such requests using "mod_rewrite" (if using Apache), which would look something like:

``` conf
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule \.php$ - [END,R=404]
</IfModule>
```

That will catch these requests to non-existent PHP files, throw a standard 404, and not touch FastCGI.
