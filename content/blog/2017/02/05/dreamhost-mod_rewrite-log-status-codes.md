---
categories: [www]
comment_count: 1
date: 2017-02-05T01:36:36-05:00
date_gmt: 2017-02-05T06:36:36+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1357'
id: 1357
modified: 2018-10-31T23:14:13-04:00
modified_gmt: 2018-11-01T03:14:13+00:00
name: dreamhost-mod_rewrite-log-status-codes
pings: ['https://www.tobymackenzie.com/blog/2016/01/25/940/', 'https://www.hyperborea.org/journal/2013/05/missing-404-log/']
tags: [apache, dreamhost, host, http, mod_rewrite, problem, status, web]
---

Dreamhost, mod_rewrite, and logged status codes
===============================================

I've done some more testing on the [problem I mentioned before](https://www.tobymackenzie.com/blog/2016/01/25/940/) of all requests showing up as `200`'s in the [Apache](https://httpd.apache.org/) log on my [Dreamhost](http://dreamhost.com/) shared server.  I'm pretty sure it's specific to their `mod_rewrite` module.<!--more-->  I set up a test host with a limited set of files:

- .htaccess

	```
	<IfModule mod_rewrite.c>
		RewriteEngine On
		RewriteRule ^rewrite/?$ rewrite.php [L]
		RewriteRule ^404/?$ 404.php [L]
		RewriteRule ^50[\w]/?$ 50x.php [L]
	</IfModule>
	ErrorDocument 404 /404.html
	```
- 404.html

	``` html
	<toby><br />404
	```
- 404.php

	``` php
	<?php
	header('HTTP/1.0 404 Not Found');
	```
- 50x.php

	``` php
	<?php
	foo();
	```

I threw in the `404.html` just to rule out any problems with a missing `ErrorDocument`.

The following routes yield the following HTTP status codes in Apache logs and the headers shown in`curl` requests:

- `/404`: 200 in logs, 404 in headers
- `/404.php`: 404 in logs, 404 in headers
- `/500`: 200 in logs, 500 in headers
- `/50x`: 200 in logs, 500 in headers
- `/50x.php`: 500 in logs, 500 in headers
- `/rewrite`: 200 in logs, 404 in headers
- `/rewrite.php`: 404 in logs, 404 in headers
- `/z`: 404 in logs, 404 in headers

All the ones where they don't match happen to be the ones that are going through `mod_rewrite`.  They match in all instances where `mod_rewrite` isn't invoked, including the direct invocation of the PHP error scripts, ruling out PHP.  Running the same files locally (when `display_errors = Off`), the codes matched.  They've always matched locally and on the servers I've worked with at work.

All of this leads me to believe that it must be something with the `mod_rewrite` that Dreamhost uses.  I found one other [blog post mentioning the same problem](https://www.hyperborea.org/journal/2013/05/missing-404-log/), plus several other pages that seemed to be related but without enough information to conclusively connect them.  I'm tempted to mention something to support, but it might take some effort to explain and convince them of the problem. Considering how many sites use `mod_rewrite`, I'm not sure why so few people are having / noticing this problem.  Obviously, it has existed since at least 2013.

It would be nice for logging purposes, especially since I use [awstats](http://www.awstats.org/), to be able to see the proper status codes.  As is, I can't really see where errors are or get a good idea of what actual pages people are visiting.  I may be stuck with all `200`'s until I switch to a VPS.

[Update]After discussing with Dreamhost, [the conclusion](/blog/2017/02/25/dreamhost-200-status-log-conclusion/) was that their configuration was "meant to meet the most common webapp and customer requirements" and I should switch to a VPS solution if I want something different.[/Update]
