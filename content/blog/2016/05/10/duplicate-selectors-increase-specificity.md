---
categories: [www]
comment_count: 1
date: 2016-05-10T02:08:19-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1139'
id: 1139
modified: 2016-05-10T02:08:19-05:00
name: duplicate-selectors-increase-specificity
tags: [css, specificity, technique, trick]
---

Duplicate selectors: Increase specificity without being more specific
=====================================================================

CSS has a concept of [specificity](https://developer.mozilla.org/en-US/docs/Web/CSS/Specificity) wherein more "specific" selectors take precedence over less specific.  Sometimes specificity rules cause a set of property values to be applied while another is desired.  This can result in the developer increasing specificity on the desired set to outweigh the other set.  When I've needed extra specificity, I've often use an 'html' class on the `<html>` element or a 'body' class on the `<body>` element.  The downsides of are it:

- is more specific, as in precise, meaning the selector won't match in a document without those helper classes.
- has a performance penalty for needing to check a(nother) parent element of the target element.
- only allows one more unit of specificity at the class level for each parent used.

Today (yesterday), I found a better way that can add any amount of class level specificity (weight) without being more specific (precise), thanks to [CSS Wizardry](http://csswizardry.com/2014/07/hacks-for-dealing-with-specificity/#safely-increasing-specificity).  I've been doing this CSS thing for a while, but I hadn't realized `.foo.foo` would match `<div class="foo">`.  In essence, you can duplicate a selector and chain it onto itself to create an equivalent selector, but with double the specificity.  You can duplicate it as many times as needed to get the desired specificity, e.g. `.foo.foo.foo.foo` to override `.foo.foo.foo`, without requiring any parent selectors.  Besides the benefits already mentioned, it could be seen as more explicit in its purpose than using parent elements, because there is no other reason to do it.  I will have to start using this.
