---
categories: [www]
date: 2019-10-08T02:00:33-04:00
date_gmt: 2019-10-08T06:00:33+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2535'
id: 2535
modified: 2019-10-08T02:00:33-04:00
modified_gmt: 2019-10-08T06:00:33+00:00
name: dark-theme-for-my-site
tags: [color, dark, site, theme, tmcom]
---

Dark theme for my site
======================

This weekend, I implemented a dark theme for my site.<!--more-->  I'm referring to using the `prefers-color-scheme: dark` media query browsers have recently added to allow websites to better fit into the "dark modes" added to OS's in recent years.  I usually prefer dark color themes and have been taking advantage of "dark mode" where I can.  I usually find them easier on the eyes (as in eye strain).  I've wished sites supported it and have wanted to do it for my site since I saw the media query support added.  Some free time and [an article by Jeremy Keith](https://adactio.com/journal/15941) gave me the push to finally make it happen.

I basically started by swapping foreground and background colors in the main content and other areas where the background is normally white on my site.  I then tweaked some other colors to fit better with that change.  I later subdued the colors a bit based on what I've read about dark themes.  I will probably tweak it some more over time.

You can see the related commits to my git repo: [ed5b585](https://github.com/tobymackenzie/site-tobymackenzie.com/commit/ed5b585fc1b831cc333ca263badf7498bbf150c8), [2cb9614](https://github.com/tobymackenzie/site-tobymackenzie.com/commit/2cb9614f15ca29205166b0b5fdf2913040c4bbff), and [501cec1](https://github.com/tobymackenzie/site-tobymackenzie.com/commit/501cec1e93afb7949ea3a1b23b4b59c2baad86cf).

To test while developing, Firefox has an `about:config` option, [`ui.systemUsesDarkTheme`](https://stackoverflow.com/a/56757527/1139122), which must be added as an integer and set to `1` to see dark theme.  Not as nice as an option in developer tools, but it does the trick, especially since my primary computer's OS (Mac 10.11) doesn't have a dark mode.  I also turned this on for my regular browser profile for personal preference.

I hope more sites (and apps) support this so my phone (Android 10 has dark mode) will be easier on my eyes.  I often just invert the screen colors on my laptop to get a light on dark theme, but it also inverts images and shadows and has other problems.

It would also be nice for this media query in browsers to support other values, such as `high-contrast` and `grayscale`.  And maybe a browser interface to select preferences.
