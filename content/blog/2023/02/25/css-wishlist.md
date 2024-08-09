---
categories: [www]
comment_count: 2
date: 2023-02-25T13:20:37-05:00
date_gmt: 2023-02-25T18:20:37+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3961'
id: 3961
modified: 2023-07-18T14:16:10-04:00
modified_gmt: 2023-07-18T18:16:10+00:00
name: css-wishlist
pings: ['https://meyerweb.com/eric/thoughts/2023/02/08/css-wish-list-2023/']
tags: [css, thoughts, wants]
---

CSS Wishlist
============

After reading [Eric Meyer's](https://meyerweb.com/eric/thoughts/2023/02/08/css-wish-list-2023/) and [Dave Rupert's recent CSS Wishlist](https://daverupert.com/2023/01/css-wishlist-2023/), I decided to make my own.  Working with CSS for many years, I have come across many things I'd like to see.  Many have come about or improved since then, but there are still things I come across that I'd like to see.  I agree with many of Eric and Dave's items, and put them in my own list if I had more to say about them or especially want them.  Here is the list of what I could come up with:

<!--more-->

Generated pseudo elements
---------------

### N generated pseudo elements

I have long wanted more than just `:before` and `:after` generated pseudo elements.  It has become less necessary as CSS has become more advanced, but would still simplify some things greatly and limit the number of decorative empty elements added to documents for some effects.  Long ago, it would have greatly simplified things like image-based drop shadows and curved borders.  It still would be useful for things like:

- bordered arrow attached to an element in addition to other stuff
- multiple CSS shapes attached to an element
- various decorative elements with different opacities, filters, blend modes, positioning, sizing, etc
- animation of different pseudos differently
- possibly allow for multiple stylesheets to not overwrite each others pseudos

Some of these can be done with magic from multiple backgrounds, `background-size`, `background-position`, etc, but it is much more complicated to implement that way.  Adding extra elements to the DOM makes the CSS more tied to the HTML.

As to syntax, I might suggest something like:

``` css
div:before(name){}
```

where `name` can be any string and would generate a new pseudo if the name hasn't been used before, or set settings for an existing pseudo if it has.  `name` could also be limited to being an integer, which would give us an order to appear in the DOM, but then would be easier to have clashes between multiple stylesheets.  With the string name, it would likely have to be added to the DOM in the order they appear in the stylesheets.  However, I expect many of the use cases of these pseudos would have them absolutely or fixed position, limiting the importance of the order.

Another option that would be based off the current syntax and has probably been tried by many of us who've been doing CSS for a while is simply allowing pseudos of pseudos, like:

``` css
div:before:before{}
```

But this would likely imply a nested hierarchy that would make many of the desired capabilities more difficult, eg positioning based on the parent element rather than the parent pseudo, separate filtering, opacity, blend modes, animations, etc.  It would also be more difficult and verbose to manage beyond a certain point.

I believe CSS3 once had something like this in the works, but it was scrapped, and I couldn't find any info on it.

### Generated pseudo wrapper element(s)

Related to the above, it would be great to be able to have a pseudo element that wraps an element.  It is quite common for me to have wrapper elements just for styling purposes.  In fact, I'd say this is more common a need than internal elements.  These wrappers are again just tying the DOM structure to the CSS.

I guess a syntax for this could be like:

``` css
div::wrap{}
```

If we want multiple, it could be like:

``` css
div::wrap(name){}
```

In this case, name might more likely have to be an indexed integer, though, as the nesting makes the order much more important in this case.  I think these psuedo-wrappers would probably be done as inner wraps (inside the element, wrapping all its contents), as I think that would be easier to implement and easier to work with.

I think these additional pseudo capabilities would help a good bit in allowing more advanced source-independent major styling and theming like [CSS Zen Garden](https://www.csszengarden.com/) dreamed we could.

Explicit specificity
-----

CSS specificity, determining which of conflicting property values applies to a given element, is determined based on [an algorithm determined by the matching selector](https://developer.mozilla.org/en-US/docs/Web/CSS/Specificity).  This is implied specificity.  It was created based on the thought that certain types of selectors should outweigh others and more of them should outweigh less of them.  We now have [`:where()`](https://developer.mozilla.org/en-US/docs/Web/CSS/:where) to limit this effect, but it just removes the specificity of its content to 0, same as `*`, so we would still need to add more to the selector to ensure our styles have some specificity at all.  It would be really nice to have something to say that this rule or these rules have specificity of `1-0`, like a class, or whatever we want, ignoring the specificity that is implied by the selectors.

I think this is more useful for a set of selectors that I want to be a particular specificity, like `1-1` for a sheet of general rules and `1-0-1` for some utility overrides.  I could see this looking something like:

``` css
@specificity 1-1{
	div{ color: red; }
}
```

or even:

``` css
@specificity 1-1;
```

at the top of a sheet like `@charset` that would define the specificity of all rules in that sheet.

Or, at the least, if we added special selectors that match like `*` but have a specificity of an element, class, id, or greater, we could more easily adjust the specificity of a `:where()` selector, eg:

``` css
:element:where(.foo){} /* 1 */
:class:where(a){} /* 1-0 */
:id:where(.bar){} /* 1-0-0 */
```

though I suppose these could be approximated with:

``` css
:not(aaa):where(.foo){} /* 1 */
:not(.a):where(a){} /* 1-0 */
:not(#a):where(.bar){} /* 1-0-0 */
```

Nested selectors
---------

Nested selectors from SASS and other preprocessers can make sheets less verbose and are probably the main thing they can do easily that prevent me from moving from SCSS to plain CSS in some cases or something like PHP or Twig when I need logic, etc.  It would be nice to have one less dependency.  Something like this:

``` scss
.foo{
	color: blue;
	.bar{
		color: red;
	}
	@media (min-width: 20em){
		color: green;
	}
}
```

would be hard to implement in PHP / Twig.  I hear nesting is [in the works in CSS Nesting 1](https://www.w3.org/TR/css-nesting-1/) though, so it may be the most likely of my list to make it.

Rule-set includes or selector aliases
------

Another feature that preprocessers provide is being able to include already defined rules into an existing set of rules, provided by extends and mixins in SASS.  It makes it easier to add certain style features to a set of elements without having to repeat a set of properties or add to a list of selectors in another location.  There would be various ways to do this.  One would be a special rule-set type that would then be able to be included with a special syntax, like:

``` css
+foo{
	color: red;
}
.foo{
	+include: foo;
}
```

Or perhaps we could just have a way to alias one selector to another, so that all elements with the given selector will act as if they have the alias selector.  This could make it easier to add all styles from media queries, `@supports`, different spots in files, etc.  That might look like:

``` css
@alias .foo, .bar;
.foo{
	color: green;
}
.bar{
	background: red;
}
```

wherein all `.foo` would get the same styles as `.bar`, such as a red background, assuming nothing more specific beats it.  I'm guessing it would be easiest to implement as having the specificity of the to of the alias, `.bar` in this case.

Coloring SVG image backgrounds, etc
-------

It is easy to color SVGs that are embedded into the HTML of a document using CSS, but not so with SVGs added as a CSS background, `<img>` element, or even an `xlink` in an embedded SVG.  All that is available there is using `filter` with `hue-rotate()` and the like.  That is not easy to do in general and I've found it difficult to get to some colors from others.

It would be great to be able to set `fill` and have it apply to the SVG in these cases automatically.  It would be very helpful especially in theming to not need to stick the SVG markup in the document.

Add to value of some properties
------

It would be nice in some cases to be able to add another value to multi-value CSS properties, rather than needing to define the whole existing list plus the new value.  I come across this most frequently for `transition` and `transform`, but it could be useful for other properties as well, like with multiple backgrounds or filters.  I want to be able to isolate different effects and be able to apply them to elements independently without having to pay as much attention to what's already there.

Implementation of this would be complicated of course, since it is quite different from the current logic where a property in a selector simply replaces those its precedence wins out over.  I might suggest something like one of the following for syntax:

``` css
div{
	+transition: opacity 0.2s;
	transition+: left 1s;
	transition: + height 0.5s;
}
```

I've also occasionally wanted to be able to modify existing numeric or the like values.  Like if this selector is matched, add `2em` to the top padding that would otherwise be there.  This might be even more difficult to implement though, considering varying units and multiple additions.  I guess it would have to become an implied `calc()`.

[More thoughts on this idea](/blog/2023/07/18/css-wishes-add-to-existing-rules/)

`viewport` rule
-------

I think it's high time that browsers treat modern-looking HTML documents as responsive by default.  Desktop browsers essentially do this, but mobile browsers don't, shrinking content if it doesn't have a `<meta name="viewport">` tag.  If it's got an HTML 5 doctype and doesn't have fixed pixel `<body>` or `<html>`, it probably should be seen as having a viewport value of something like `initial-scale=1,width=device-width` by default.  Anyway, this seems like it should be a concern of the stylesheet rather than the document, and so it should probably be made into an at rule at the top of the CSS document, like:

``` css
@viewport initial-scale=1,width=device-width;
```

I suppose the last declaration would have to win.  Once this is implemented, some years later we may be able to remove the `<meta>` and have slightly lighter page weight for our documents.

Screen-reader only
----

This is probably the most commonly implemented hack still extant on the web.  It is usually 5+ CSS properties to hide text content visually but have it read by screen readers / assistive technology.  Undoing it for focus, etc., requires undoing all those properties.  It is usually used to provide extra information for users who may not be able to see the document and thus may miss some information otherwise provided visually.  It seems to me like it would be better for screen readers to know that this is what the author intended and for authors to be able to easily do and undo this without side effects.  It could be as simple as a `display` property value, like:

``` css
.foo{ display: assistive; }
```

`attr()` everywhere
---------

For values coming from a CMS, it would be nice to be able to use attribute values in more than just `content`.  I've often had colors or background images based on settings in the CMS.  Nowadays we can put a `style` attribute with various CSS properties, but that is harder to manage.

Cascading Behavior Sheets
--------

This is not actually CSS, but I think it would benefit future CSS development by helping to reduce the urge to add behavior to it.  I recently opined that there should be [a declarative equivalent of JS like CSS](/blog/2022/11/23/idea-declarative-alternative-to-js/).  I would love to see this, and the sooner the better.

Alternate stylesheets
-----

As someone who lived with a 5GB monthly transfer limit for a time, I am sensitive to downloading unused kilobytes for websites.  HTML has long had a way to specify [alternate stylesheets](https://developer.mozilla.org/en-US/docs/Web/CSS/Alternative_style_sheets) that aren't applied normally but can be switched to either with built in browser functionality (eg Firefox, Opera, iCab) or with plugins or JS.  The problem is that browsers download all of these stylesheets, even in the very likely case that the user doesn't switch to them.  And that's what I want changed.  I will not use alternate stylesheets if they cause extra transfer without being used (aside from the bytes for the `<link>`s, of course).  I don't think they should.  A brief moment to download the new sheet when switching is not unreasonable to save many bytes of transfer.

Etc.
------

I know there are many other things I have come across while building sites that I couldn't think of.  I've been in this long enough that I largely just accept such shortcomings of CSS, work with what I have, and mostly forget about them as I move onto the next project.

But I will say in general that I think CSS, moving forward, should have some focus on making it easier to make nice designs with less hacks, and to make things progressively enhanced, accessible, and performant.  Those goals should be the easy path when possible.  In achieving the designs that designers prescribe, the solution that best achieves these and other best practice goals should be the simplest and most straightforward, and things that cause problems in them should take more effort.

[More CSS wishes](/blog/2023/03/04/more-css-wishes/)
