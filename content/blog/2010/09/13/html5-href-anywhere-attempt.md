---
categories: [www]
date: 2010-09-13T07:33:39+00:00
date_gmt: 2010-09-13T07:33:39+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=392'
id: 439
modified: 2024-08-01T12:11:26-04:00
modified_gmt: 2024-08-01T16:11:26+00:00
name: html5-href-anywhere-attempt
tags: [html5, links, spec]
---

HTML5 href Anywhere Attempt
==============================

XHTML 2 was going to allow use of the `href` attribute on any element, allowing for block level anchors and eliminating repetition of the same anchor in some cases or unnecessary additional tags in others.  This really made sense, since the `<a>` tag is just a span, but the only span with an added ability of linking to somewhere else.  There is really no special semantic meaning to the `<a>`, and all links on a page could be found in parsing by finding tags with the `href`.	In the early days of the development of HTML 5, the "href anywhere" approach was discussed, and I was excited thinking it was going to be part of HTML 5.  At the time, that was the most interesting thing about HTML 5 to me.  But "href anywhere" would mean all previous browsers would not be able to see links at all (besides for the ones put in `<a>` tags for some reason), so the idea was scrapped.  Instead, the HTML 5 creators took advantage of an against-spec ability that current browsers already had:  [block level anchors](http://html5doctor.com/block-level-links-in-html-5/).  Browsers at least back to IE 6 will happily make "flow content" placed in an `<a>` tag into a link.

I was somewhat unhappy that we had to kowtow to current browsers by preventing such a wonderful ability as href's on any tag, but the backwards compatibility thing is huge in real world development (though I would have just done some server side browser sniffing to output the `<a>`'s in appropriate places for incompatible browsers) and the solution handles most use cases, though with a bit of extra markup.	Over time, I began thinking that perhaps I could just use `<a>`'s in place of any tags that have no semantic meaning (ie `<div>` and `<span>`), only using `href` when required and thus have `href` available most anywhere.<!--more-->  It fit in with a seeming idea of some folk who don't like the new HTML 5 "semantic" elements, ie that there need only be one element whose attributes define its semantics in each instance.  The spec allows `<a>`'s with no `href`, and I saw nothing in the spec specifically prohibiting nested `<a>`'s, so I thought I'd give it a try.  I made this quick example (note that I would use the proper HTML 5 `<header>`, `<footer>`, etc elements in real use, but this was just for a quick test):

``` html
<!DOCTYPE html>
<html>
<head>
<title>Anchors Everywhere</title>
<style>
.block{
	display: block;
}
a{
	/*text-decoration: none;*/
}
.textlink{
}
#header{
	background: red;
}
#sidebar{
	float: right;
	background: yellow;
}
#maincontent{
	float: left;
	background: #ccc;
}
#footer{
	clear: both;
	background: blue;
}
</style>
</head>
<body>
<a id="pagewrap" class="block">
	<a id="header" class="block">
		<h1>Anchors Everywhere Take 1</h1>
	</a>
	<a id="sidebar" class="block">
		<ul>
			<li><a class="textlink" href="#1">Page 1</a></li>
			<li><a class="textlink" href="#2">Page 2</a></li>
			<li><a class="textlink" href="#3">Page 3</a></li>
			<li><a class="textlink" href="#4">Page 4</a></li>
			<li><a class="textlink" href="#5">Page 5</a></li>
			<li><a class="textlink" href="#6">Page 6</a></li>
		</ul>
	</a>
	<a id="maincontent" class="block">
		<h1>This is the main content part</h1>
		<p>This is some main content.</p>
		<p>This is another paragraph <a class="textlink" href="#link">with a link</a>.</p>
	</a>
	<a id="footer" class="block">
		This is the footer
	</a>
</a>
</body>
</html>
```

To my dismay, the sidebar failed to take style in any browser.	Firebug showed a very strange nesting arrangement with the anchors there that made no sense based on the markup.  I went to the [W3C validator](http://validator.w3.org/) for some guidance.  It told me of errors such as "An a start tag seen with already an active a element" and "End tag a violates nesting rules".  I went back to the [HTML 5 spec for `<a>`](http://www.whatwg.org/specs/web-apps/current-work/multipage/text-level-semantics.html#the-a-element) and discovered a hint that `<a>`'s can't be nested.	It says, in an example box rather than spec proper, "The a element may be wrapped around entire paragraphs, lists, tables, and so forth, even entire sections, so long as there is no interactive content within (e.g. buttons or other links)."  So I guess nested anchors aren't allowed, nor buttons or the like, in anchors.  Since both the spec and all current browsers dislike nested anchors, my attempted "href anywhere" would be severely limited in application.  Any `<div>` should be able to contain a child link, so it would be a bad idea to use it on div's until a child link was placed in them.  Many span's don't contain a link, so an hrefless `<a>` could be used for those, but then they'd have to be removed if a child link was needed.  That makes it not seem worth the effort on those either.	Shucks.  Worth a try, but I guess I'm foiled again by old browsers.
