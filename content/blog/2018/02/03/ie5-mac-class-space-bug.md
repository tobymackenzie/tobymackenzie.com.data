---
categories: [www]
date: 2018-02-03T22:04:52-05:00
date_gmt: 2018-02-04T03:04:52+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1769'
id: 1769
modified: 2018-02-03T22:33:42-05:00
modified_gmt: 2018-02-04T03:33:42+00:00
name: ie5-mac-class-space-bug
tags: [bug, css, html, oldbrowsers, progressiveenhancement, webd]
---

IE 5 Mac class attribute with space bug
=======================================

[Crazy Mac IE 5 bugs](http://old.macedition.com/cb/ie5macbugs/index.html#whitespace) with the HTML class attribute: If you have a space after any class in the attribute, it will treat any CSS class selector that contains that string at its beginning as a match for the element.<!--more-->  For the example:

``` html
<html class="doc foo">
<title>Test</title>
<style>
.doca{
	background: green;
}
.fooa{
	background: blue;
}
.foo{
	color: white;
}
.doca .foo{
	color: orange;
}
</style>
<p>Test</p>
<p class="foo">Foo</p>
```

the background will be green and the text will be white.  The foo element will be orange.   This will be the case if the class is just `doc ` as well.  Without the ` foo` in the class, the background will be white and the text will be black, like in other browsers.  With a space after `foo`, the background will be blue.

If you have a leading space in the class (`class=" doc"`) or it is just a space (`class=" "`), every single class selector in the sheet will match.  For the example, the background would be blue, text white, and foo element orange.

This was causing my site to white-screen in the browser and was very hard to find.  And yes, I'm crazy for even testing in IE 5 today.
