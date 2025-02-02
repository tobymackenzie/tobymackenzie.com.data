---
categories: [www]
date: 2023-12-10T21:47:34-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=4193'
id: 4193
modified: 2023-12-10T21:49:48-05:00
name: apache-php-fpm-and-primary-script-unknown
pings: ['https://www.tobymackenzie.com/blog/2020/04/24/fastcgi-primary-script-unknown/']
tags: [apache, fastcgi, log, php, problem]
---

Apache PHP FPM and “Primary Script Unknown”
===============================================

A while back, I [wrote about dealing with the Apache / FastCGI error 'Primary script unknown'](https://www.tobymackenzie.com/blog/2020/04/24/fastcgi-primary-script-unknown/) when trying to access non-existent PHP files.  Bots often do this trying to test for vulnerabilities, and it can fill up error logs and be annoying to look through.  In that post, I fixed the problem through mod_rewrite and a `RewriteCond`.  For PHP 2.4+, there is a more broad and likely more efficient solution using the [`<If>`](https://httpd.apache.org/docs/2.4/mod/core.html#if) directive.  It will work for all virtual hosts on a server.

<!--more-->

When setting up Apache as a web server and adding PHP support, there will generally be a `SetHandler` directive somewhere in the Apache configuration (usually somewhere in `/etc/apache2` or `/etc/httpd`) that sends requests for PHP files to a special handler.  On Ubuntu, this would be in `/etc/apache2/conf-enabled/php8.1-fpm.conf` if using PHP FPM, or `/etc/apache2/mods-enabled/php8.1.conf` if using `mod_php`.  Adding the `<If>` would look something like this:

``` conf
<IfModule !mod_php8.c>
<IfModule proxy_fcgi_module>
	<FilesMatch ".+\.ph(ar|p|ps|tml)$">
		<If "-f %{REQUEST_FILENAME}">
			SetHandler "proxy:unix:/run/php/php8.1-fpm.sock|fcgi://localhost"
		</If>
	</FilesMatch>
</IfModule>
</IfModule>
```

for PHP FPM.  For `mod_php`:

``` conf
<FilesMatch ".+\.ph(ar|p|tml)$">
	<If "-f %{REQUEST_FILENAME}">
		SetHandler application/x-httpd-php
	</If>
</FilesMatch>
```

These will simply not set the special PHP handler for the request if the file doesn't exist.  If you have a `RewriteRule` common for CMS's like:

``` conf
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteRule ^index\.php$ - [L]
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule . /index.php [L]
</IfModule>
```

requests for matching URLs will still go through `index.php` as normal, as the rewrite will change the request to a file that does exist.

No more worthless 'Primary script unknown' errors to need to parse through when looking at logs.
