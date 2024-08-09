---
categories: [www]
comment_count: 1
date: 2015-04-22T00:51:54-05:00
date_gmt: 2015-04-22T05:51:54+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=682'
id: 682
modified: 2018-08-03T18:37:44-05:00
modified_gmt: 2018-08-03T23:37:44+00:00
name: load-balancers-and-https
tags: [https, loadbalancer, php, server, symfony]
---

Load Balancers and HTTPS
========================

Until recently, I had no experience working with sites behind load balancers.  [Cogneato](http://cogneato.com) has been moving its sites to [Rackspace](http://www.rackspace.com/) virtual servers for flexibility, among other things.  One of their recommendations that we took was to put our web server behind a load balancer.  Even though we haven't needed multiple nodes behind it yet, it makes it easier to upgrade the server behind it without needing to change IPs in DNS and will allow us to easily pop up another node when it is needed.

This arrangement has gone relatively smoothly except a few issues.  The biggest ones have had to do with our HTTPS sites.  We run both HTTP and HTTPS sites on the same server.  We put the certificates on the load balancer, so traffic goes from the load balancer to the web server over HTTP.  Both Apache and code see the request as HTTP as standard methods are concerned.  I will discuss some of the problems we had and solutions I found.

<!--more-->

mod_rewrite
-----------

It is common to force at least the pages that need to be secure to go over HTTPS by sending a redirect from the HTTP version of the URL to the HTTPS, often using Apache's 'mod_rewrite'.  With this move, we decided the HTTPS sites would just do this for all request for simplicity.  A common rewrite rule for this might be:

```
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,QSA]
```

Since, behind the load balancer, the request comes to Apache over HTTP, HTTPS will not be 'on'.  This rule would then cause an infinite redirect loop to the HTTPS URL, since the condition would never be met.  What are we to do?  Load balancers often add additional headers to the request to provide the web server with info about the original request.  `X-Forwarded-Proto` is often sent holding the protocol string.  So we can change our rule to look like:

```
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,QSA]
```

Another important 'mod_rewrite' issue is with domain aliases (where alternative domains redirect to a canonical one).  These redirects are commonly done with rewrite rules like:

```
RewriteCond %{HTTP_HOST} ^www.example.com/?$
RewriteCond %{HTTPS}s ^on(s)|
RewriteRule ^(.*)$ http%1://example.com/$1 [R=301,L,QSA]
```

or:

```
RewriteCond %{HTTP_HOST} !^example.com
RewriteCond %{HTTPS}s ^on(s)|
RewriteRule ^(.*)$ http%1://example.com/$1 [R=301,L,QSA]
```

The example rules handle either protocol.  When doing HTTPS only, you'd want to remove the middle line and replace the `%1` with just `s`.

We only get SSL certificates for the canonical domain.  Visiting any of the aliases over HTTPS will give an error about an invalid certificate, since the client is doing its handshake with the load balancer and the certificate is for a different domain.  This cannot be fixed (that I know of), but visiting with the aliases over HTTP should properly redirect.  The important thing here is that you must have your rules redirecting to the canonical URL before the one forcing HTTPS (if done with `%{HTTP_HOST}%{REQUEST_URI}`).  Otherwise, it will redirect to the alias over HTTPS, giving the invalid certificate error.

PHP
---

In PHP, it is common to look at `$_SERVER['HTTPS']` to determine if the request is using that protocol.  It will normally be 'on' if so, but behind a load balancer, it won't be by default.  The same header we used for 'mod_rewrite' also makes its way into `$_SERVER` as `$_SERVER['HTTP_X_FORWARDED_PROTO']`.  It will either be 'http' or 'https'.

Since our CMS software runs on servers both behind and not behind load balancers, we need to be able to handle both possibilities, so a test would look like:

``` php
if($_SERVER["HTTPS"] || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] === 'https')){
	// do something for HTTPS protocol
}
```

However, simpler solution that requires no code changes would be to set the environment variable in the Apache configuration, as [this StackOverflow answer suggests](http://stackoverflow.com/a/20217694/1139122).  This can be placed in the 'httpd.conf':

```
SetEnvIf X-Forwarded-Proto https HTTPS=on
```

and `$_SERVER['https']` will once again work normally.

mod_dir
-------

Apache's 'mod_dir' serves directory indexes ('index.html', 'index.php', etc.).  It will also do redirection to add a slash to URLs pointing to a directory without the slash.  This is necessary for the directory index to work.  If the configured `ServerName` doesn't specify a protocol, this redirect will use whatever protocol the request is, which, when behind a load balancer, is HTTP.  Normally, this wouldn't be a significant problem, because the rewrite rule enforcing HTTPS would send another redirect with the proper protocol.  However, to save the extra request-response cycle, specifying the protocol in the `ServerName` causes the redirection to use that protocol:

```
ServerName https://example.com
```

AJAX calls are another reason to do this, because the redirection to HTTP will cause the AJAX call to be blocked by an HTTPS page.  This is how I noticed the problem at all:  on [Akron Art Museum](https://akronartmuseum.org/), pages loaded after the first are done via AJAX in browsers that support the [history API](http://diveintohtml5.info/history.html).  Some of them (the ones that point to directories without slashes) stopped working after the server switch.  Many of the links are stored in the database and would not be easy to replace with a query.  [This StackOverflow answer](http://stackoverflow.com/a/23121307/1139122) led me in the right direction.

Symfony
-------

With Symfony 2, you can specify what protocol a given route should be.  If it isn't that protocol, Symfony will redirect to the proper one.  However, behind the load balancer, Symfony thinks the protocol is HTTP (even with the `SetEnvIf` trick for some reason), and will cause an infinite redirect loop.  The Symfony docs have a [cookbook on handling protocols behind load balancers](http://symfony.com/doc/current/cookbook/request/load_balancer_reverse_proxy.html).  In your configuration, you can set a trusted proxy to the internal IP of the load balancer:

```
framework:
	trusted_proxies: [10.1.1.1]
```

or, with older versions, just tell it to generally trust whatever proxy headers it gets:

```
framework:
	trust_proxy_headers: true
```

Symfony will then use the `X-Forwarded-*` headers instead of the normal `$_SERVER` values.  Unfortunately, our CMS is stuck on the '2.0.x' branch, which apparently is too old for even the latter option.  Since we are now enforcing the entire domain to be HTTPS if the site is at all, I just removed the route requirements entirely.

TL;DR
-----

### httpd.conf

```
# tell PHP the proper protocol for all sites
SetEnvIf X-Forwarded-Proto https HTTPS=on
<VirtualHost *:80>
	# tell 'mod_dir' the proper protocol for slash-adding redirects on HTTPS sites
	ServerName https://example.com
	ServerAlias www.example.com
	# …
	<IfModule mod_rewrite.c>
		# force server aliases to canonical domain and protocol before the general HTTPS force below
		RewriteCond %{HTTP_HOST} ^www.example.com/?$
		RewriteRule ^(.*)$ https://example.com/$1 [R=301,L,QSA]

		RewriteCond %{HTTP_HOST} !^example.com
		RewriteRule ^(.*)$ https://example.com/$1 [R=301,L,QSA]

		# force HTTPS
		RewriteCond %{HTTP:X-Forwarded-Proto} !https
		RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,QSA]
	</IfModule>
</VirtualHost>
```

### *.php

``` php
// the `SetEnvIf` from httpd.conf should make `$_SERVER["HTTPS"]` behave as expected, but the following works regardless of its existence
if($_SERVER["HTTPS"] || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] === 'https')){
	// do something for HTTPS protocol
}
```

### Symfony config.yml

```
# tell Symfony to trust `X-Forwarded-Proto` and other 'X-Forwarded' headers from the given load balancer IP(s)
framework:
	trusted_proxies: [10.1.1.1]
```
