---
categories: [www]
date: 2010-02-11T03:29:17+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=250'
id: 415
modified: 2010-02-11T03:29:17+00:00
name: case-dom-element-insertion-css
tags: [css, dom, style, thoughts]
---

The Case for DOM Element Insertion With CSS
===========================================

CSS provides the "content" property for inserting content into documents, usually before or after elements.  This can be bad if the content inserted is not strictly for presentational purposes, but when it is, it can be a very useful tool for changing a sites appearance with only CSS.

The property can be used to insert strings, images, even counters.  Unfortunately, DOM elements cannot be inserted.  Why would you want to insert DOM elements?  Doesn't that go against the separation of content and presentation even further than the "content" property already allowed?

Ideally, in marking up a document, one should not need to consider presentation at all, only the proper elements to stick a given block of content into.  The CSS would be created separately and form those elements into any appearance desired.  There are a lot of reasons this can't currently be done, including sort order and hierarchy.  Another is the limit of what is available to be styled in the HTML document.

<!--more-->

A lot of CSS techniques require additional markup to work.  Putting wrappers around elements is common.  Standard [sliding doors](http://www.alistapart.com/articles/slidingdoors/) techniques use an element and a sub element: a "li" with an "a" inside for link tabs. [Four-sided drop-shadow techniques](http://www.positioniseverything.net/articles/dropshadows2.html) use a number of extra elements just for the shadow.  Even the [CSS Zen Garden](http://csszengarden.com/) throws in extra divs and wrapper spans just for styling purposes.  Classes and id's also have to be added for targeting purposes.

All of this can force the structure to be changed from its most bare semantic form while designing a site.  You can certainly just wrap everything, id and classify everything to the extreme, and throw in a lot of extra divs so that any design you do won't require a structure change.  But that (except usually for the classes and id's) is not very semantic, makes for a heavy page regardless of how styled it is, and won't even guarantee that you can do everything you need to.  It certainly can make CMS content parsing more challenging as well.

It would be quite nice if these elements could simply be inserted into a purely semantic document, exactly what is needed for a given appearance.  Javascript can insert DOM elements, but Javascript is supposed to be for behavior, not for presentation.  Inserting DOM elements with CSS could certainly be used wrong, but it could be very helpful if used right.  An ability to wrap elements in another element or add empty elements would allow all sorts of possibilities for styling without changing page markup.

Of course, CSS 3 may provide some facilities to handle a lot of the stuff these extra elements are needed for.  Things such as multiple background images, border images, border radiuses, drop shadows, etc, a lot of the techniques needed extra markup could be eliminated.  Still, there will surely be techniques, current or future,  that could benefit from inserted markup even with CSS 3 support.
