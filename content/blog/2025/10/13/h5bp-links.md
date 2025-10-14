---
categories: [www]
date: 2025-10-13T20:45:32-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4667'
id: 4667
modified: 2025-10-13T20:45:32-04:00
name: h5bp-links
tags: [html5, links, problem]
---

h5bp links
==========

Earlier in my career, I looked to the [HTML5 boilerplate](https://github.com/h5bp/html5-boilerplate) for ideas on how to set up websites.  I just grabbed bits I liked and modified them as needed.  For a time they had shortened links off of the h5bp.com domain that redirected to descriptions of why certain choices were made.  But eventually, the person maintaining that domain let it lapse and someone else bought it.<!--more-->  Some time before that happened, they had switched to direct links, as done in [this commit](https://github.com/h5bp/html5-boilerplate/commit/697fa65).  But I still had some of those links in comments in some of my own code.  I had to look through all my projects to find and replace them, lest someone be led to the wrong, possibly nefarious, place.

The main one I had was a link in my print stylesheet about this code: 

``` css
@print{
	thead{ display: table-header-group; }
}
```

That is only really relevant for very old browsers, possibly just IE 5.5 and 6, and only for printing multi-page tables to copy the head on each page, but I left it in for progressive enhancement thoroughness.  When I went to check their replacement link, I found it itself no longer existed.  I had to go to archive.org, back to 2018, where I found [the page with that info](https://web.archive.org/web/20180815150934/http://css-discuss.incutio.com/wiki/Printing_Tables).

I'm glad I no longer have those bad links in my code, but I'm sure there are plenty of those links out there still.  Github search shows [57.1k files with that domain](https://github.com/search?q=h5bp.com&type=code).  I'm sure the new owners of the domain appreciate the recognition.
