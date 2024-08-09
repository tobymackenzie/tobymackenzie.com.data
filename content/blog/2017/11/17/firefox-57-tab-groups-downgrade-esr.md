---
categories: [www]
comment_count: 1
date: 2017-11-17T02:21:38-05:00
date_gmt: 2017-11-17T07:21:38+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1671'
id: 1671
modified: 2017-11-17T02:35:03-05:00
modified_gmt: 2017-11-17T07:35:03+00:00
name: firefox-57-tab-groups-downgrade-esr
tags: [browser, downgrade, extension, firefox, gui, tabs, web]
---

Firefox 57 and Tab Groups: downgrading to ESR for now
=====================================================

The recent release of Firefox 57 is pretty nice in many ways, but the loss of certain extensions is probably going to keep my primary browser from upgrading until they're updated or suitable replacements are found.

<!--more-->

57 is the first version Firefox has stopped supporting their long-time extension architecture and only supports their [new WebExtension architecture](https://blog.mozilla.org/addons/2015/08/21/the-future-of-developing-firefox-add-ons/), first introduced in 2015.  The new architecture is better in most ways, but also is missing features some plugins need, and requires rebuilding plugins significantly enough that some developers aren't willing to port them, or are still working on them.

All but one of the extensions I've installed is compatible at this point.  Many of them I rarely use and don't care about, but two are the blockers for me: [NoScript](https://noscript.net/) and [Tab Groups](https://addons.mozilla.org/en-US/firefox/addon/tab-groups-panorama/).

NoScript is a security extensions of sorts, blocking all javascript, flash, java, etc by default and allowing domain by domain whitelisting.  It also provides protection from clickjacking, XSS, etc.  It is well known and the developer is committed to porting it.  So soon enough this will be a non-issue.

Tab Groups is both a way of organizing and of visualizing tabs.  It comes from the codebase of a once built-in feature of Firefox called [Panorama](http://www.azarask.in/blog/post/designing-tab-candy/), modified to work as an extension and improved significantly over the years.  Unfortunately, the developer has [decided not to port it](https://web.archive.org/web/20170914192149/http://fasezero.com/).

Considering that I have 600+ tabs in my primary browser at this point, it is pretty much essential.  I've been pushing to reduce that number, but it's continued to grow, and losing a reasonable way to navigate them will just make things worse.

The ability to visually see the tabs as thumbnails in a grid all at once is probably the most important part of it for me.  I use that even when I don't have a lot of tabs (in other profiles) to quickly visualize what I have opened.  Interestingly, the Android version of Firefox has something like this as its tab switching UI, but not the desktop version.  If they would just bring that over as an alternative view of tabs, I'd probably be happy enough.

Alternative extensions are in the works to fill the void, but none that I've seen seem to have anything like the UI of Tab Groups.  They're all waiting on a [feature request for tab hiding](https://bugzilla.mozilla.org/show_bug.cgi?id=1384515) in the WebExtension API to be able to show a single group of tabs at a time.

Until I find something I like, I may be downgrading to [Firefox ESR](https://www.mozilla.org/en-US/firefox/organizations/) (version 52) for my primary browsing, though it is well slower than 56, especially with 600+ tabs.
