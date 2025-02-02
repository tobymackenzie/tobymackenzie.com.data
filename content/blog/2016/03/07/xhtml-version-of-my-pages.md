---
categories: [www]
date: 2016-03-07T02:47:12-05:00
guid: 'https://tobymackenzie.wordpress.com/?p=985'
id: 985
modified: 2019-01-20T14:26:29-05:00
name: xhtml-version-of-my-pages
tags: [formats, site, symfony, xhtml]
---

XHTML version of my pages
=========================

Continuing in the interest of [providing multiple file formats for my web pages](https://tobymackenzie.com/blog/2015/09/18/websites-in-multiple-file-formats/), I now have [my home page available in XHTML5](https://www.tobymackenzie.com/index.xhtml) format.  URL's just need `.xhtml` tacked on the end, except for the home page, which needs `index.xhtml`.  This makes use of [Symfony's `_format` URL parameter](http://symfony.com/doc/current/book/routing.html#book-routing-format-param).

<!--more-->

I already generally write my HTML in XHTML format anyways, so I only needed needed to make a few minor changes to my markup to make things work.  I already had closings for all of my tags (like `</li>` for every `<li>` and a slash at the end of self-closing tags, like `<meta />`).  Most of my attributes had values, but I did have to add them for `async` and `defer` on a `<script>` tag, like `<script async="async" defer="defer"…>`.  I had to add `xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"` on the `<html>` element.  I had to remove any `<noscript>` elements (these cannot be used in XHTML because browsers don't know how to handle them in XML).  Finally, I had to change the comments around inline script tag content to look like:

``` html
<script><!--//--><![CDATA[//><!--
//--><!]]></script>
```

See [this Drupal discussion](https://www.drupal.org/node/672954#comment-3460304) for a bit of information on the comment thing.

I just used the same template for HTML and XHTML, so I used conditionals to wrap anything that differed between the two.  The Symfony `Request` object has a `getRequestFormat()` method that will return the `_format` string.  In Twig templates, that is accessed with `app.request.requestFormat`, so I can do things like:

``` html
<html lang="en"{% if app.request.requestFormat == 'xhtml' %} xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"{% endif %}>
```

and:

``` html
{% if app.request.requestFormat != 'xhtml' %}<noscript>…</noscript>{% endif %}
```

One other thing that has to be done for this to work with Symfony is set up the proper mime-type, like:

```
framework:
 request:
  formats:
   xhtml: 'application/xhtml+xml'
```

My controllers are set up to render templates named based on the `_format`, like:

``` php
	public function myAction(Request $request){
		return $this->renderPage('MyBundle:folder:template.' . $request->getRequestFormat() . '.twig');
	}
```

I generally just symlink the '.xhtml' one to the '.html' one.
