---
categories: [www]
date: 2026-04-08T15:25:55-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4842'
id: 4842
modified: 2026-04-08T15:25:55-04:00
name: css-naked-day
tags: [css, holiday, html, web]
---

CSS Naked Day
=============

I have decided to participate in [CSS Naked Day](https://css-naked-day.org/) this year.<!--more-->  I had heard of it before but hadn't put in the effort to do it.  The premise is to remove all CSS from a website to show what the plain HTML of the site can do.  Since I've worked to ensure my site works in CLI browsers and also fall back well in GUI browsers and really old browsers, I'm pleased with how it looks.

I'm using some JavaScript that turns off stylesheets using my [theme switch script](https://github.com/tobymackenzie/theme-switch.js).  This makes for a fairly small added amount of data transfer for the feature (like 72 bytes minzipped).  The added code can be seen in [this commit](https://github.com/tobymackenzie/tobymackenzie.com.site/commit/a5b127d1a1bd00cf6d571f4b38100a07ac4a6664).  JS is the only way to do CSS Naked Day on a static site, unless I do a separate deploy just for that day and then revert.  It also has the advantage that while the "day" is much longer than 24 hours because it applies to every time zone in the world, this can be applied based on the local date.

Now that it's built into the site's code, it should happen automatically as long as my site is live.
