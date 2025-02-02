---
categories: [www]
date: 2023-03-04T21:05:25-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3971'
id: 3971
modified: 2023-03-04T21:05:25-05:00
name: more-css-wishes
pings: ['https://www.tobymackenzie.com/blog/2023/02/25/css-wishlist/']
tags: [css, thoughts, wants]
---

More CSS Wishes
===============

After reading through a few more CSS wishlists, such as [Chris Coyier's](https://chriscoyier.net/2022/12/21/things-css-could-still-use-heading-into-2023/) and [Ahmad Shadeed's](https://ishadeed.com/article/css-wishlist-2023/), I have come up with some more wishes I have for CSS, in addition to those I brought up in [my recent CSS Wishlist post](https://www.tobymackenzie.com/blog/2023/02/25/css-wishlist/).

<!--more-->

A11y and CSS
------

I saw an article about the newish `display: content` removing the target elements from the accessibility tree, thus messing up the experience for screen readers and other assistive technology.  `display: content` was created precisely to preserve our proper structure while allowing more advanced visual styling.  I've read plenty of other similar issues, including with other `display` values and `order` and `content` properties.

I generally feel that the document structure should be defined in HTML, because that is the simplest place to manage it and that is what HTML is for.  But regardless, as I mentioned in my last wishlist, I think browsers should do what makes it the easiest for authors to do what they want while giving the best experience to their users.  If it is believed that the accessibility tree should be changed by CSS, like with `order`, then it should do that, but that should be documented in the spec and easy to understand for authors.  It should take more effort to do things wrong than to do things right.

Really, we could use a focus of the standards movement on accessibility, etc to standardize the important things between different browsers and screen readers and make things more logical and sane for authors.

Position anchoring to a specified parent element
-----

Currently, positioning an element with `absolute`, `fixed`, or `sticky` are all positioned based on an automatically determined parent element, which may not be the desired parent element.  Positioning of `absolute` uses the nearest parent element that is "positioned" (not the default `position: static`) or has other special properties like `transform`, `filter`, or `perspective`.  `fixed` is positioned relative to the viewport, except when those special properties are used.  `sticky` is the most difficult to work with, always using its DOM parent as its positioning parent.  That makes it depend much more on source order than it ought to.

Often, we want to be able to specify some of those special properties on elements without affecting child positioning, or in general to explicitly specify which element is the positioning parent, particularly for `fixed`.  It would be nice to have a property like:

``` css
.child{
	position-parent: .grandparent;
}
```

so that it would position based on `.grandparent` instead of an intermediate `.parent` regardless of the styles that element has.  If the selector doesn't match any parent elements, it could probably either use the normal positioning parent or the document.

For `fixed` or `sticky`, we might want the more logical:

``` css
.foo{
	position-parent: html;
}
```

I'm even fine with it not being able to apply filters and transforms on the child if that isn't possible in a performant way.  Just as long as we don't have to change around our source order.  And this seems to be the most logical default parent for `sticky` in normal circumstances anyway.

I could see some more powerful things being done if we could position relative to a sibling or the like, but I'm not sure that can be specified unambiguously and performantly.

Vertical alignment
-----

The vertical alignment situation has improvement particularly at the layout level, but I still run into issues particularly with text alignment level.  Differences with fonts, SVGs, alignment of elements with text in the same parent, I sometimes have to put in hacks like magic `margin-top: 0.1em`, or pseudo-elements with their own alignment, to make things look right.  It'd be nice if I didn't.  I'm not sure how though.  Perhaps if fonts and SVGs and images could have some better embedded alignment information.

Animating to `auto` height
------

It would be useful to animate a height from 0 to `auto`, as in hide some content, then slide down to reveal it when something happens.  It has to be hacked currently with `max-height` (which has issues) or `grid-template-rows`, which I didn't know about until Chris's article, or using JS.

Auto-growing textareas
------

It would be nice if `<textarea>`s and possibly even `<input>` that are text-like could expand to fit the content they hold, either only when focused or all the time, expanding or shrinking live as the user types.  I would kinda prefer this to be the default if no fixed width / height is set or something like that, but it would be nice if it were at least settable with a property.

Regions
------

There was a [CSS Regions spec](https://drafts.csswg.org/css-regions-1/) a while back that had some interest and momentum, but then died out.  It allowed overflowing content to flow into other elements.  I didn't like that it required potentially empty elements to make the regions.  I think it would be nice if it could flow into CSS Grid named regions that could be empty.  If that can't be done for because we need actual elements, if we get the infinite generated pseudo-elements I asked for in the last post, perhaps we could push into those.  It might be nice for doing some advanced layouts, especially for print.

Float into css columns
-----

A while back I needed to stick a floated image into some text that was columnized using CSS columns.  It didn't work, just pushing the columnated text over instead.  Being able to do this would be useful.

Iframes sized to content
-------

The newish `aspect-ratio` is great for `<iframe>`s, and probably make sense in a lot of cases.  But sometimes, we want the `<iframe>` to be the height of the content.  This can currently be done with JS, but it would be nice if it could be just a setting, whether in CSS or an HTML property.

Single line comments
------

It would be nice to have the `//` single line comments of Sass, JS, et al.  Simpler to add and remove.

Better support of what we have
---------

We have a lot of good stuff.  Some of it's new enough that it's not fully supported in current browsers, and hopefully that will get better supported.  There also are occasional cross-browser differences that I run across with newer properties that cause visual or usability problems.  It would be nice to get any bugs fixed, off-spec behavior changed to spec, and any non-specced behavior that causes problems agreed upon, specced, and implemented.  If any specs aren't fully agreed upon and cause problems as specced, perhaps they should be reviewed.
