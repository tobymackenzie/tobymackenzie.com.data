---
categories: [www]
date: 2016-03-29T02:29:43-04:00
guid: 'https://tobymackenzie.wordpress.com/?p=1012'
id: 1012
modified: 2017-04-27T21:36:31-05:00
name: web-manifest-first
tags: [app, html, manifest, web]
---

Web app manifest, first go
==========================

I've added a basic [web app manifest to my site](https://www.tobymackenzie.com/app-manifest.json).  I have not experimented with the results, but I did run it through a [web manifest validator](https://manifest-validator.appspot.com/) mostly to success.  I used the [MDN guide](https://developer.mozilla.org/en-US/docs/Web/Manifest) and the [HTML5 doctor article]( http://html5doctor.com/web-manifest-specification/) for help.  I also read some of [the in-progress spec](https://w3c.github.io/manifest/), though it seemed more implementer-friendly.  The content of my manifest is currently (prettified):

``` json
{
	"background_color": "#4e784e"
	,"display": "browser"
	,"icons": [
		{
			"sizes": "64x64"
			,"src": "favicon.gif"
			,"type": "image\/gif"
		}
	]
	,"lang": "en-US"
	,"name": "Toby Mackenzie\u0027s site"
	,"scope": "\/"
	,"short_name": "\u003Ctoby\u003E"
	,"start_url": "\/"
	,"theme_color": "#4e784e"
}
```

I'm just using Symfony's [JsonResponse object](http://symfony.com/doc/current/components/http_foundation/introduction.html#creating-a-json-response) to render a PHP array.

This is one more thing that I really shouldn't've put time into until my site is more fleshed out, but it seemed cool and simple to add.
