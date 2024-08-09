---
categories: [www]
date: 2019-09-30T00:35:49-04:00
date_gmt: 2019-09-30T04:35:49+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2528'
id: 2528
modified: 2019-09-30T00:35:49-04:00
modified_gmt: 2019-09-30T04:35:49+00:00
name: forcing-https-progressive-enhancement
tags: [https, progressiveenhancement, site, web]
---

Forcing HTTPS and progressive enhancement
=========================================

In the interest of progressive enhancement, my site doesn't force browsers to connect over HTTPS unless they demonstrate support for it.<!--more-->  Instead of redirecting all HTTP requests at the server level, it has the client try to connect to HTTPS and only redirects if the connection succeeds.  This allows old browsers to connect, while new browsers connect securely.

The earliest browsers didn't support HTTPS at all.  An increasing number of old browsers don't support modern HTTPS certificates, protocols, ciphers, etc.  [Mozilla's "Intermediate" server configuration](https://ssl-config.mozilla.org/#server=apache&config=intermediate), recommended for most use cases, doesn't support IE versions less than 11, Safari < 9, Firefox < 27, and Android < 4.4.2, for example.  The "Old" version increases support, but still doesn't allow all browsers, and may decrease security or speed in modern browsers.

If a browser visits your HTTPS URL and can't connect, it will not display any of your site's content, just an error message.  Thus, they will be unable to visit your site at all (at least with that browser).

It is common to force HTTPS to ensure users have secure connections and tell search engines to display HTTPS URL's.  The most common way to do this is to just have the server send a 301 redirect to the HTTPS version of a URL for all HTTP requests.  In Apache, this might look like:

```
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,QSA]
```

This would force browsers that don't support your HTTPS to request it and fail, with no ability to see the HTTP version of the site.  Some more advanced configurations will try to detect and only redirect supporting user agents, but user agent sniffing is difficult and a moving target at best.  It is likely to result in a lot of effort, configuration, and false positives or negatives.

The only way to be sure a browser can connect via HTTPS is to make an actual connection.  The only way to do this and then redirect the page to HTTPS, that I know of, is using JavaScript.  For HTTP requests, my site adds a script tag to the page `<head>` with an HTTPS URL.  The script reloads the page, replacing the `http:` with `https:` in the current URL.  If the browser can't connect via HTTPS, it won't load the script, and thus won't redirect.  I haven't seen any problems caused by the request failing for the blocking script.

The lightweight script I have created looks like:

``` js
if('location' in window && location.protocol === 'http:'){
	location.replace('https' + location.href.slice(4));
}
```

It verifies that the browser supports the `location` interface and the request is over HTTP (just in case the server sends it for an HTTPS document), then tells the browser to reload with the modified URL.

To load the script, my HTML document contains something like:

``` php
<!doctype html>
<!--…-->
<head>
<!--…-->
<?php if((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'off') || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'http')){ ?>
	<script src="https://<?=$_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST']?>/force-https.js" type="application/javascript"></script>
<?php } ?>
<!--…-->
```

The PHP `if` condition causes the script tag to only be output if the request is for the HTTP page, ensuring that its performance hit doesn't occur for HTTPS visitors.  The `type` attribute prevents the script from loading in some really old browsers that it can cause troubles with.

I have considered using a dialog to verify the user actually wants HTTPS, and a cookie to not show the dialog again, but it seemed a bit excessive when they likely want to be secure if they are able to.

I had tried using [HSTS](https://en.wikipedia.org/wiki/HTTP_Strict_Transport_Security) headers to force HTTPS for modern browsers without requiring JavaScript, but it didn't work as desired.  Also, some time in the future, when early HSTS supporting browsers no longer support then modern HTTPS, it would result in those browsers not being able to visit the site, so it wouldn't be a proper way to progressively enhance to HTTPS even if it did work.
