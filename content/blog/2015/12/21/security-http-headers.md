---
categories: [www]
comment_count: 1
date: 2015-12-21T04:22:59-05:00
guid: 'https://tobymackenzie.wordpress.com/?p=795'
id: 795
modified: 2018-07-12T20:27:39-05:00
name: security-http-headers
tags: [development, headers, http, security, symfony]
---

Security HTTP Headers
=====================

I've been working on the HTTP headers my site sends recently.  I had been working on performance / cache related headers, but after seeing mention of [a security header scanner](https://securityheaders.io/) built by [Scott Helme](https://scotthelme.co.uk/), I decided to spend a little time implementing security related headers on [my site](https://www.tobymackenzie.com).  I don't really know these headers that well, so I added the headers it suggested and mostly went with the recommended values. I did read up a bit on what they mean though and modified the `Content-Security-Policy` as I saw fit.

I added most of the headers using a [Symfony reponse event listener](http://php-and-symfony.matthiasnoback.nl/2011/10/symfony2-create-a-response-filter-and-set-extra-response-headers/).  This handles all of my HTML responses without sending the headers for other responses, where they aren't necessary.  The exception is the `X-Content-Type-Options`, which should be set for all responses.  I set that in Apache configuration.

<!--more-->

The event listener wrapper looks like this:

``` php
<?php
namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
class SecurityHeadersListener{
	protected $env;
	public function __construct($env){
		$this->env = $env;
	}
	public function onKernelResponse(FilterResponseEvent $event){
		$request = $event->getRequest();
		if($request->getRequestFormat() === 'html' || $request->getRequestFormat() === 'xhtml'){
			$headers = $event->getResponse()->headers;
			//-! set headers here
		}
	}
}
```

It is loaded in configuration and attached as a listener like:

``` yaml
# app/config/services.yml
services:
 app.headers_listener:
  class: AppBundle\Listener\SecurityHeadersListener
  arguments: ['%kernel.environment%']
  tags:
   - {name: kernel.event_listener, event: kernel.response}
```

I will discuss how I set up each header a bit.  and the code for it a bit.

`Content-Security-Policy`
----------------

This is the most complicated one.  It is the most likely to vary from page to page.  It tells the browser where it's safe to use assets (scripts, styles, images, etc.) from.  I added the site's own domain and my stats domain, from which I load scripts, styles, and images.

I also had to add `unsafe-inline` to allow inline script tags.  I currently use them for some stuff I want to happen before DOM rendering and to load my stats scripts.  I intend eventually to do some mustard cutting, even if I move some of that to external scripts.  More advanced and secure solutions are to provide a nonce or hash to only allow matching scripts to run.  That will take a good bit of effort to implement though, so I'll probably be with `unsafe-inline` for a while.

The header value I'm sending looks like:

```
default-src 'unsafe-inline' www.example.com stats.example.com
```

which is set by this code in the event listener:

``` php
$cspHeader = ($this->env === 'dev') ? 'Content-Security-Policy-Report-Only' : 'Content-Security-Policy';
if(!$headers->has($cspHeader)){
	$headers->set($cspHeader, "default-src 'unsafe-inline' {$request->server->get('HTTP_HOST')} stats.example.com");
}
```

Note that I use the `Content-Security-Policy-Report-Only` header for the `dev` environment.  This tells the browser to report what it would block (shown in the error console) but still load everything, making it slightly easier during development.

Note also that I am checking if the header has already been set and only setting it if not.  This allows the controller to set a different value if a given page needs a different policy.  I do the same thing for all of these headers.

See [Scott Helme's description of `Content-Security-Policy`](https://scotthelme.co.uk/content-security-policy-an-introduction/) for a good description of the header.

`X-Frame-Options`
----------------

This simple header tells the browser what domain can load the given asset in an iframe.  I honestly would probably be happy if somebody put my pages in an iframe, but iframes can be used in [clickjacking attacks](http://www.troyhunt.com/2013/05/clickjack-attack-hidden-threat-right-in.html), thus posing a security threat.

The header value I'm sending looks like `X-Frame-Options: sameorigin`, which tells the browser that pages on the domain of the URL can have iframes of it.  I'm setting this with this code in the event listener:

``` php
if(!$headers->has('X-Frame-Options')){
	$headers->set('X-Frame-Options', 'sameorigin');
}
```

In theory, if you wanted specific other domains deemed safe to be able to put your pages in iframes, you could do something like:

``` php
if(!$headers->has('X-Frame-Options')){
	$safeDomains = ['example.com', 'example2.com'];
	if(in_array($request->server->get('HTTP_HOST'), $safeDomains)){
		$origin = $request->server->get('HTTP_HOST');
	}else{
		$origin = 'sameorigin';
	}
	$headers->set('X-Frame-Options', $origin);
}
```

See [Scott Helme's description of `X-Frame-Options`](https://scotthelme.co.uk/hardening-your-http-response-headers/#x-frame-options).

`X-Xss-Protection`
----------------

This one tells the browser (IE and Chrome) to enable their built-in XSS protection and to block loading of the site if an XSS attack is detected.  Since these browsers enable their XSS protection by default and I trust their default decision of how to handle discovered attacks, I kinda feel sending this is uneccessary, but I added it anyway to get my 'A+' grade with the scanner.

I'm sending the value `1; mode=block` using the following code in the event listener:

``` php
if(!$headers->has('X-Xss-Protection')){
	$headers->set('X-Xss-Protection', '1; mode=block');
}
```

See [Scott Helme's brief description of `X-Xss-Protection`](https://scotthelme.co.uk/hardening-your-http-response-headers/#x-xss-protection)

`X-Content-Type-Options`
----------------

This header tells the browser (IE and Chrome) to always use the mime-type set by the `Content-Type` header rather than trying to detect the mime-type based on its content in certain circumstances.  This capability could be used with malicious user uploaded content to cause an image or something to be rendered as HTML (possibly with script tags and run on the site's domain) or to force downloads of executables or something.

I'm sending the value `nosniff` and have set this in Apache configuration like:

```
Header always set X-Content-Type-Options 'nosniff'
```

See [Scott Holme's brief description of `X-Content-Type-Options`](https://scotthelme.co.uk/hardening-your-http-response-headers/#x-content-type-options) or [another post with more details on the problem](https://htaccess.wordpress.com/2009/09/22/x-content-type-options-nosniff-header/).

Coda
----

I do not have any ability for users to upload or edit content, or really do anything that mutates anything on the server.  As such, these headers probably aren't really necessary for my site.  However, they could help in the event of my site getting hacked.  Obviously, if a hacker could get write access to my PHP files or htaccess and knew to replace or remove the headers, they wouldn't matter anyway, but it's one more layer of protection.  Also, as a developer, I want my site following what "best practices" it can.
