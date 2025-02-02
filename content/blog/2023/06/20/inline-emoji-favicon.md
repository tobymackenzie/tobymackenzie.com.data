---
categories: [www]
date: 2023-06-20T13:51:34-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4063'
id: 4063
modified: 2023-07-31T00:14:48-04:00
name: inline-emoji-favicon
tags: [html, icons, performance, web]
---

Inline emoji favicon
====================

On a simple one-page site, I wanted as much as possible to be inline in the single document request.  I didn't have a favicon, and I didn't want browsers to make that extra request.  I considered just adding an empty file, as I've done sometimes in the past, but that would still be an extra request.  So I looked up if it could be inlined.  It can be done, with a [data URL](https://developer.mozilla.org/en-US/docs/web/http/basics_of_http/data_urls).  And using an SVG format, an emoji can be used for a cheap actual icon.

<!--more-->

I found both solutions in a [CSS-Tricks article](https://css-tricks.com/emoji-as-a-favicon/) based on a Lea Verou idea.  We can make the `href` attribute of our icon `<link>` into a data URL that contains an SVG.  It can be plain-text for easier reading and creation, but needs some HTML encoding to work as an attribute.  A `<text>` element can be used to insert the emoji, with some attributes to position and size it nicely.  A `sizes="any"` attribute can help ensure browsers use it in place of any sized icon, since it can be scaled infinitely.

The end result looks like:

``` html
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>✌️</text></svg>" sizes="any" />
```

That does work for me in my tests, but some places say that more of those characters should be escaped.  To pass the w3c's validation, I had to use:

``` html
<link rel="icon" href="data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20viewBox=%220%200%20100%20100%22%3E%3Ctext%20y=%22.9em%22%20font-size=%2290%22%3E✌️%3C/text%3E%3C/svg%3E" sizes="any" />
```

Luckily, the icon character is the only thing that generally needs to be changed.

It should work nicely in all modern browsers that show favicons.
