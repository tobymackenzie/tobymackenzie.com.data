---
categories: [www]
date: 2015-12-13T04:39:48-05:00
date_gmt: 2015-12-13T09:39:48+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=757'
id: 757
modified: 2020-03-20T01:05:43-04:00
modified_gmt: 2020-03-20T05:05:43+00:00
name: line-mode-progressive-enhancement
tags: [browsers, development, linemode, oldbrowsers, progressiveenhancement, support, web]
---

Line Mode Browser, or progressive enhancement all the way back
==============================================================

Progressive enhancement is a development strategy meant to provide older and / or less capable browsers with a working website while providing the more capable with a rich, full experience.  It is often presented as a set of layers of support, with HTML at its base, then CSS added to that for styles, then JavaScript for advanced behavior.  With this, it's often posited that a well-crafted HTML experience can be used by any browser.  However, for really old browsers from the early web, the new web provides many things that can make pages difficult to read, functionality unusable, or even entire sites inaccessible.

Today, I'm going to go back as far as I reasonably can in terms of browser support, to the second web browser ever made, and the first widely supported one, [Line Mode Browser](https://en.wikipedia.org/wiki/Line_Mode_Browser).  I can't look at the first, [WorldWideWeb](https://en.wikipedia.org/wiki/WorldWideWeb), because it was only made for NextStep and, as far as I can tell, isn't accessible for me to test with.  Line Mode is though.  It was open-source by the [w3c and kept available](http://www.w3.org/LineMode/).  I was able to get it with [MacPorts](http://macports.org/) with the 'libwww' package (run as `www` on the command line).

Line Mode was based on WorldWideWeb, and in fact was less featured, so it is likely to have any issues WorldWideWeb has and more.  I will look at some issues that Line Mode has with modern web pages, and provide some solutions that will improve the abilities of even the oldest browsers to use a page.

<!--more-->

<aside><small>Note: In 2013, an [in-browser simulation of Line Mode](http://line-mode.cern.ch/www/hypertext/WWW/TheProject.html) was created.  It uses the rendering engine of the browser you are using, but uses JavaScript to modify the markup of the page it is displaying to more closely match how Line Mode would display things, so many of these problems will not exist.  You need the actual binary to see them.</small></aside>

HTTPS everywhere (it's supported)
---------------------------------

### Problem

[HTTPS](https://en.wikipedia.org/wiki/HTTPS), the protocol for encrypting web traffic, wasn't created until 1994 and even then took a while to be formally specified.  Line Mode and other early browsers don't support it at all.  They simply won't be able to load sites that are only available over HTTPS.  They will not be able to access any content at all.  Line Mode just displays nothing, freezes, or exits.

Banks, eCommerce, and other sites with "sensitive" information have long used HTTPS, but calls have been increasing for its use elsewhere.  "HTTPS everywhere" is becoming a common mantra.  The idea is that governments / others can track what users are viewing or even inject / rewrite content when using HTTP.  It is common for HTTPS sites to do a 301 redirect to HTTPS when accessed over HTTP.

For non-"sensitive" activities, it might be a bit heavy handed to block older browsers.  [Wikipedia, for example, forces HTTPS](http://blog.wikimedia.org/2015/06/12/securing-wikimedia-sites-with-https/), and will not load on old browsers (even ones that do support HTTPS but not new enough hashing algorithms).  It's a bit disappointing that such a significant general source of information wouldn't be accessible at all to some browsers.

### Solution

If you want to support non-HTTPS capable browsers, you have to provide HTTP access.  This means either not redirecting to HTTPS or providing an HTTP capable subdomain (though users would have to know about this).  <del>You can tell modern browsers to use HTTPS without a 301 redirect using HSTS.  It's sort of like a more powerful 301 redirect for modern browsers, but is ignored by non-supporting browsers.</del>  [HSTS](https://en.wikipedia.org/wiki/HTTP_Strict_Transport_Security) will tell modern browsers to use your HTTPS site, but only after they've visited it once.

<ins>JavaScript can be used to force a redirect to HTTPS by checking if the browser can successfully make a connection, thus progressively enhancing.  See \[my newer post about this\](/content/blog/2019/09/30/forcing-https-progressive-enhancement.md) for details.  Modern browsers will end up at the HTTPS site, while early browsers like Line Mode, which don't understand JavaScript, will get HTTP.</ins>

If desired, you can put a message on all pages when browsing over HTTP (for instance, by checking `$_SERVER['HTTPS'] !== 'on'` in PHP) that tells them they are visiting the insecure version of the page and pointing them to the secure version.  That way you users can still access it, but are informed about the option of security if they want it.

Generic elements
----------------

Tags that browsers do not understand are treated as what I will call generic elements.  In essence, they are treated like a `<div>` or `<span>`, with their text content displayed generically.  This is one of the biggest helps to progressive enhancement, because old browsers will still get text content even if it isn't displayed in the way newer browsers handle it.  New elements are set up to take advantage of this, having a fallback that displays in browsers that don't understand the element.  For instance, in the `<video>` element, you can provide text content to, say, provide a link to the video for non-supporting browsers.  This is great, but some elements weren't designed in this way or have special considerations.

### `<script>` and `<style>`

#### Problem

These elements are, like anything else, treated as generic elements by browsers that do not understand them.  As with other generic elements, text inside them will be displayed to older browsers.  In this case, though, the JS and CSS are not meant for human consumption.  Some modern pages are filled with effectively gobbledygook in Line Mode, making it hard to read the rest of the page.

#### Solution

The spec provides us with a solution: HTML comments.  You simply put an opening comment immediately after the opening tag, a line break before your content, then a line break and closing comment immediately before the closing tag.  It requires sending 7-9 extra bytes per tag, relatively minor to support old browsers.

``` html
&lt;style&gt;&lt;!--
body{ background: red; }
--&gt;&lt;/style&gt;
```

### `<img>`

#### Problem
The `<img>` tag was [implemented in 1993](https://web.archive.org/web/20091106020732/http://diveintomark.org/archives/2009/11/02/why-do-we-have-an-img-element) as a self closing tag.  It provides an `alt` attribute for browsers that don't support showing images to show as text instead.  This works great when supported, but the problem is that browsers must explicitly support the tag.  For browsers created before then or just not implementing the element, `<img>` is just an empty tag, and nothing displays.

#### Solution

A good option for general use is to make your text content work as if the image wasn't there.  If the image is superfluous and you would already have an empty `alt` attribute, this probably means doing nothing special.  If the image is important and would have an `alt` attribute, just work that text into surrounding text.  Then, if that makes the `alt` redundant, just use empty `alt` attributes.

A solution I've been considering for lazy loading images would involve using a link where the image will go with text content representing the alt attribute, an href pointing to the image, and and `data-` attributes for other settings.  I would then use JS  to replace this with an `<img>`.  This way, any old browser that doesn't [cut the mustard](http://responsivenews.co.uk/post/18948466399/cutting-the-mustard#page-94), many of which are on slower hardware, would just get text.  Newer browsers can load the images only when needed, like when they approach being visible in the viewport.  The HTML for this might look something like:

``` html
&lt;a class=&quot;lazyImage&quot; href=&quot;/image.jpg&quot; data-width=&quot;800&quot; data-height=&quot;400&quot;&gt;The image&lt;/a&gt;
```

The width and height `data` attributes might be used by the JS as quickly as possible to apply sizing to the element to prevent reflows when the image is loaded.  It might even calculate the aspect ratio and use `padding-bottom` to preserve it if the viewport is narrower than the width.

### Forms

#### Problem

Forms didn't exist in the early web.  In non-supporting browsers, you will not be able to use forms, and their content will display as generic elements.  `<input>` will not display, but all `<label>`, `<option>`, and `<textarea>` (with value) will.  In Line Mode, this looks very confusing, having all of the usually short snippets of text output effectively as lists.

### Solution

There isn't really a good solution to this problem for these very old browsers.  I think the best that can be done is to have an introductory paragraph to the form that includes mention of alternatives to submitting the form, such as an email address or phone number to send to.  This is definitely one of those things that any real effort to fix would break progressive enhancement support for browsers that people actually use.

Analytics
---------

### Problem

Most [web analytics](https://en.wikipedia.org/wiki/Web_analytics) these days is done with JS that sends information about visitors' actions to the analytics server.  Google Analytics, for instance, does all of its information collection with JS by default and will collect absolutely no information about visitors that don't run their script.  If you only use analytics that only uses JavaScript to track page views, you will never know how many non-JavaScript users are using your site.

Some JS analytics systems, including Google Analytics, provide a fallback that uses an `<img>` tag inside of a `<noscript>` tag.  For browsers like Line Mode that don't load images, however, even this fallback doesn't send any information.  These analytics systems simply cannot track Line Mode and other very old or text only visitors.

### Solution

The only way to track CLI and very old browser usage is with server-side analytics.  These can work by looking through server logs or by running code that stores data when the server processes each request.  [Awstats](http://awstats.org/) is the one I'm using.  Line Mode appears as `W3CLineMode/5.4.0 libwww/5.4.0`.

Server-side analytics can't get a lot of information that JS running on the client can, so you may want to continue using the JS analytics for the kind of information it can provide.  Server-side analytics also records bot visits, but the software I've used separates those visits (at least the ones it detects) from regular user visits.  I think an ideal situation would be something that marries JS and server-side by using some sort of identifier in both to match visitors.

However, the numbers of people using these browsers are most likely so low that it isn't worth much effort to track unless you want to know that information.  With any analytics solution, they track what they track, which for JS with image fallback solutions isn't the number of CLI or very old browsers visiting.

White-space
-----------

### Problem

In Line Mode, unlike in modern browsers, white-space matters.  In fact, it is essentially all that matters for the visual structure of the text.  All elements are inline.  Actual line break characters are all that make something appear as a 'block'.  Indentation shows.  Many pages will have large empty spaces between content, content indented pretty far in and seemingly randomly, content jammed together that shouldn't be, line-breaks where they shouldn't be, and things on the same line that shouldn't be.  This all can make pages very hard to read and the structure and association of content confusing.

### Solution

Solving this problem would require either:

- hand coding all HTML and indenting it for browser readability rather than code readabilty
- implementing a complex algorithm to essentially replace each span of white-space with a single space, then add line breaks after each closing tag of a block level element, possibly stick some indentation before `<blockquote>`, and possibly some other things I haven't thought of, except that everything in `<pre>` tags would need to be skipped and any self closing `<li>` or other tags would need special handling.  This would be sort of like implementing part of what a modern text browser does.

Considering:

- virtually no-one uses browsers with this problem
- the amount of effort it would take to fix
- the fact that the content is accessible even if not the most usable on affected browsers

I don't really think it's worth the effort to solve, unless a trustworthy and reliable third party library can do it for you.  It's just interesting to note when thinking about how the modern web looks to the first browsers.  The only advantage this could offer newer browsers is [shaving some bytes off of page weight](http://perfectionkills.com/experimenting-with-html-minifier/).  Perhaps [the "html-minifier"](https://github.com/kangax/html-minifier) could be modified to support this.

Conclusion
----------

Approximately nobody is visiting sites with Line Mode or its contemporaries for real use.  It's unlikely that anyone will be stuck on a computer that cannot install a newer browser.  The incentive is low for putting much or any effort into fixing things for these browsers.  However, as with many things in progressive enhancement, some of these fixes will have benefits for more modern browsers.  And if you want to be able to say that your progressively enhanced site truly can be used by any browser, well, that takes a little bit of extra effort.
