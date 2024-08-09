---
categories: [www]
date: 2018-04-02T23:05:06-05:00
date_gmt: 2018-04-03T04:05:06+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1835'
id: 1835
modified: 2018-04-09T01:27:06-05:00
modified_gmt: 2018-04-09T06:27:06+00:00
name: css-checking-support-for-selectors
tags: [browser, css, selector, support, trick]
---

CSS: checking support for selectors
===================================

[`@supports`](https://developer.mozilla.org/en-US/docs/Web/CSS/@supports) is a good way to apply an entire block of styles only if (modern) browsers support a particular property-value combo.  There is no similar block-level mechanism for selector support.  Selectors are automatically ignored if their values or syntax aren't recognized by the browser, so they basically already do this at the ruleset level.

Except, sometimes you want to apply styles to other elements that don't use the selector, but only if the browser supports the selector.<!--more-->  One way to do this is to add a fake selector to the selector list (ie with a comma) that will not apply to any elements in the document, but has the selector piece you want to test support for.  This works by the same mechanism previously mentioned, because all selectors in a list are ignored if any of them have unrecognized values.  Since `_` is a valid type selector in CSS, but not likely to ever become an actual element, we can base our selector off of that.

So, lets use the currently poorly supported [`:focus-visible` pseudo-element](https://drafts.csswg.org/selectors-4/#the-focus-visible-pseudo) as an example.  Lets say we want to use it to show an outline focus ring on elements for keyboard focus, but not (theoretically) mouse clicks.  We could do something like:

``` css
:focus{
	outline: none;
}
:focus-visible{
	outline: 2px dotted;
}
```

but that would give no focus ring at all to browsers that don't recognize `:focus-visible`.  We can instead do:

``` css
:focus, _:focus-visible{
	outline: none;
}
:focus-visible{
	outline: 2px dotted;
}
```

Now, browsers that don't recognize `:focus-visible` don't have the regular `:focus` outline removed.
