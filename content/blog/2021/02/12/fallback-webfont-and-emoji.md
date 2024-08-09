---
categories: [www]
date: 2021-02-12T00:47:51-05:00
date_gmt: 2021-02-12T05:47:51+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3277'
id: 3277
modified: 2021-02-12T19:19:26-05:00
modified_gmt: 2021-02-13T00:19:26+00:00
name: fallback-webfont-and-emoji
tags: [font, performance, problem, web]
---

Fallback webfont and emoji
==========================

Recently I found that browsers will download a fallback webfont (`@font-face`) to try to find an emoji or other missing character.  I was looking at the perf characteristics of my site when I noticed that the browser was downloading a webfont that wasn't being used at all.  After some digging, I found that the browser was going down through the full font stack to try to find an emoji I had added to that page, downloading the webfont on the way.

This is probably not a common setup, but I have a webfont in my font stack down stack from some similar common system fonts, as a fallback just in case.  It uses a nice system font unless it can't find it, in which case it uses the webfont, unless it can't use that, in which case it uses a less desirable system font or the generic font class.<!--more-->  The stack looks like: 

``` css
font-family: meslo, 'Meslo LG S', menlo, 'Menlo Regular', cousine, Consolas, 'Courier New', courier, monospace;
```

where `cousine` is the webfont, with an `@font-face` declaration elsewhere.  I do that for perf reasons, so Apple visitors won't download a webfont, getting a close-enough system font.

I don't normally have emoji on my website, but I had recently added one to my home page because I felt it would punctuate the exclamation "Beltalowda" I had added.  Apparently, Menlo didn't have the emoji in it, so the browser tried each font down the line, going through the webfont, which didn't have it, but still caused the download.  Continuing on, even the generic `monospace` didn't have it, so it ended up on a system fallback, `Apple Color Emoji`.

In order to prevent the download, I'm switching the stack to: 

``` css
font-family: meslo, 'Meslo LG S', menlo, 'Menlo Regular', 'Apple Color Emoji', cousine, Consolas, 'Courier New', courier, monospace;
```

This puts Apple's emoji font before my fallback webfont.  This wouldn't prevent the cousine fallback from working on Apples that don't have Menlo, as Apple Color Emoji doesn't have regular ASCII characters in it, and thus the browser would fall through to `cousine` looking for them.

[update]In a previous version of this post, the new font stack had Segoe and Noto emoji fonts, but those seem to have ASCII characters, and thus, in those systems (generally Microsoft and Android OS's), caused the text to look very different from Meslo.  However, those systems were already downloading cousine for the body text and thus don't download an unused webfont.[/update]
