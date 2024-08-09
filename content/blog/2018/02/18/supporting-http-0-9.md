---
categories: [toby]
comment_count: 1
date: 2018-02-18T03:46:16-05:00
date_gmt: 2018-02-18T08:46:16+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1788'
id: 1788
modified: 2024-02-08T21:00:13-05:00
modified_gmt: 2024-02-09T02:00:13+00:00
name: supporting-http-0-9
tags: [browsers, oldbrowsers, progressiveenhancement, server, site, support]
---

Supporting HTTP 0.9
===================

I recently added support for [HTTP 0.9](https://hpbn.co/brief-history-of-http/#http-09-the-one-line-protocol) to my site.  I have access to no browsers that use that protocol, and it's highly unlikely that anybody is visiting sites with one.  Why support it then?  It's not that hard (for me), and it fits with the [progressive enhancement](https://en.wikipedia.org/wiki/Progressive_enhancement) related concept that all browsers should be able to use the most basic functionality of a website that they are capable of.

<!--more-->

HTTP 0.9 is the retroactively applied version number for the original HTTP protocol.  It is extremely simple, with no headers.  The browser simply sends a request for `GET` followed by the path, and the server responds with text.  It was the protocol of the web until the [formal spec HTTP 1.0](https://tools.ietf.org/html/rfc1945) came out in 1996.

Many modern servers such as Apache and Nginx still support it because it is so simple.  The main difficulty in supporting it is that it doesn't include a `Host` header, used by servers with virtual hosts to determine which site is being accessed.  Because of this, only one site can be served to 0.9 per IP.  So no luck for people on shared hosting, unless you somehow manage to be the default host.

In Apache, the first virtual host is the default.  When loading a folder of conf files with a glob, like `Include sites-enabled/*.conf`, it's common to add `000-` to the beginning of the default host file's name to make it the first.  So that's what I did, causing requests to my IP or any domains without vhosts to be handled by my regular site.

Software such as WordPress can be confused if there is no `HTTP_HOST` set.  I was able to handle this in my htaccess by adding something like:

```
RewriteCond %{HTTP_HOST} ^$
RewriteRule ^ - [E=HTTP_HOST:www.tobymackenzie.com]
```
which sets the environment variable.

Because SSL wasn't even a thing when this protocol was being used, your site must be able to be accessed over `http://`.  If you force `https://` with a redirect regardless of host, you would just send a redirect to a 0.9 request.  You can add a condition to that redirect to ensure it isn't one of these old browsers, producing something like:

```
RewriteCond %{HTTP_HOST} ^.+$
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R,QSA]
```

though some less old browsers will still have problems.

If you force a canonical domain for any domains not matching a particular one, 0.9 requests will again just get a redirect.  You'll want to add the same condition, for something like:

```
RewriteCond %{HTTP_HOST} ^.+$
RewriteCond %{HTTP_HOST} !^www\.tobymackenzie\.com
RewriteRule ^ https://www.tobymackenzie.com%{REQUEST_URI} [L,R,QSA]
```

In my case, I don't force HTTPS and serve multiple domains from the same virtual host, so things were done a little differently.  I had to do a few other things specific to my setup and code that I won't go into here.

The easiest way to test 0.9 support is using `telnet`.  Run `telnet tobymackenzie.com 80` in a terminal, then type `GET /` and return.  Whatever it responds with is going to be what an HTTP 0.9 (as well as some early HTTP 1.0) browser would receive.  <ins>Now netcat is more common, which can be used like `echo 'GET /' | nc -c tobymackenzie.com 80`</ins>
