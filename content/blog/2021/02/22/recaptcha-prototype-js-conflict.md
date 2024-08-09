---
categories: [www]
date: 2021-02-22T23:18:46-05:00
date_gmt: 2021-02-23T04:18:46+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3300'
id: 3300
modified: 2021-02-22T23:18:46-05:00
modified_gmt: 2021-02-23T04:18:46+00:00
name: recaptcha-prototype-js-conflict
tags: [captcha, javascript, problem]
---

Recaptcha and prototype.js conflict
===================================

One of Cogneato's clients noticed that Recaptcha wasn't working on their site.  The checkbox wouldn't check at all.  I noticed that there was an error like "Unexpected token in JSON at position 0" in the browser's console log.  Since this was one of our really old sites, I figured it might have some sort of inadequate polyfill for `JSON.parse()`.  I saw that the site was using [Prototype.js](http://prototypejs.org/), so I looked through the script to see if it was overriding that method, but it wasn't.  That did put me on the right track, though, to find [the Stackoverflow answer](https://stackoverflow.com/a/64808781/1139122) that solved it for me.

Prototype was overriding the now browser standard `reduce()` method of `Array.prototype` with its own, incompatible functionality.  The solution was simply to remove that method from the "prototype.js" file.  We weren't using the special Prototype functionality anywhere, so this didn't cause a problem.  If we were, we'd probably have to [duck punch](http://ericdelabar.com/2008/05/metaprogramming-javascript.html) the browser's functionality to handle both method signatures.
