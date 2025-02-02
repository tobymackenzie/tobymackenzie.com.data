---
categories: [www]
date: 2016-07-20T00:48:38-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1186'
id: 1186
modified: 2016-07-20T00:48:38-05:00
name: quick-regex-strip-html-tags
tags: [html, manipulation, php, regex, string]
---

Quick regex to strip html tags
==============================

Recently, I needed to strip some HTML tags from some data.  The goal was to make a field in a database that was a WYSIWYG text area into plain text content that could go inside a link.  I did it using a simple regex of `/<\/?[^>]+>/` to find the tags so I could replace them with an empty string.  In PHP, this looked like:

``` php
$string = preg_replace('/<\/?[^>]+>/', '', $string);
```

This is perhaps a naïve implementation, but it served my purposes fine.  Of course, I had totally forgotten about [PHP's built in `strip_tags()` function](http://php.net/manual/en/function.strip-tags.php), but on comparing it, it also seems to not do exactly what I want.  For instance, it seems to get rid of the content of `<a>` tags.
