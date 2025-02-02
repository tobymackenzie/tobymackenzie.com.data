---
categories: [computer, www]
date: 2021-08-13T23:37:42-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=3483'
id: 3483
modified: 2021-08-13T23:37:42-04:00
name: firefox-weird-rendering-high-contrast-mode
tags: [firefox, problem, solution, webd]
---

Firefox: Weird rendering with high contrast mode
================================================

I figured out why Firefox 91+ seemed to break some CSS rendering for me (as [I blogged about a few weeks back](/content/blog/2021/07/24/3459.md)):  high contrast mode.  I've used the accessibility setting "Increase Contrast" on Mac OS for some time to make it easier to see some interface elements.  Apparently, via [Firefox 91 release notes](https://www.mozilla.org/en-US/firefox/91.0/releasenotes/), "Firefox now automatically enables High Contrast Mode when 'Increase Contrast' is checked on MacOS".

<!--more-->

The browser's high contrast mode is very extreme, switching most everything to black text on white background, using the standard blue / purple for links, removing shadows, widening borders and changing their colors, various things like that.  It can make some things unusable, especially form fields, where they sometimes have no borders.  It also doesn't take into account if dark mode is enabled, though it could be manually switched to white on black.  This feature is not something I like or want normally, and is terrible for web development.

I had trouble finding out about this for some time.  Google didn't help, but I finally searched Twitter and found [this tweet](https://twitter.com/dyzurnyklasowy/status/1426163633386573824).  Assuming we want to keep the OS contrast as is, disabling this mode can be done in the preferences.  Under "Fonts and Colors", there is a "Colors…" button.  In the popup, change the "Override the colors…" drop-down to "Never".
