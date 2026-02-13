---
categories: [www]
date: 2018-12-26T01:45:42-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=2171'
id: 2171
modified: 2026-02-13T12:35:44-05:00
name: website-snow-script
tags: [animation, canvas, javascript, site, snow]
---

Website Snow Script
===================

I finally built a snow animation for my site to celebrate Christmas.<!--more-->  I had used third party scripts in the past, but had been wanting to build my own.

I wanted to find a pure CSS method, but couldn't figure out a reasonable way to make that happen, so gave in and used JavaScript.

I struggled somewhat with the performance of it.  Using [canvas](https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API), I couldn't get a 60 FPS `requestAnimationFrame()` animation to use less than maybe 30-40% CPU on my Core 2 Duo, even just drawing a single circle in the same place repeatedly.  I ended up lowering the frame rate significantly, to around 12 FPS, to get CPU usage low enough that I was comfortable using it for this non-essential animation.  It is a little less smooth than I would like though.

I tried some other options than canvas to try to help with performance, such as HTML elements for the flakes or SVG.  They performed really well with a tiny number of elements but became worse as I added more.  The SVG ended up using only a little more CPU for the flake counts I wanted.  I might've been able to get them lower than canvas by grouping flakes together or some other techniques.  Perhaps something to try for next year.

I have made a [demo](https://www.tobymackenzie.com/examples/www/snow/) and have the source code on Github for [the snow modules](https://github.com/tobymackenzie/site-tobymackenzie.com/tree/ccb72acceba16b1e6bfe2fd407e4d8e0b4ab2989/src/PublicApp/scripts/modules/snow) and [script to load them](https://github.com/tobymackenzie/site-tobymackenzie.com/blob/ccb72acceba16b1e6bfe2fd407e4d8e0b4ab2989/src/PublicApp/scripts/christmas.js) as part of my site's codebase.  There are also a [small amount of styles](https://github.com/tobymackenzie/site-tobymackenzie.com/blob/ccb72acceba16b1e6bfe2fd407e4d8e0b4ab2989/src/PublicApp/styles/builds/christmas.scss).  <del>I may eventually extract it into its own library.</del>  I have finally released this [as its own repo](https://github.com/tobymackenzie/snow.js/) ([demo](https://tobymackenzie.github.io/snow.js/)).
