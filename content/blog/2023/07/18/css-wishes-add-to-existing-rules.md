---
categories: [ideas, www]
date: 2023-07-18T14:12:09-04:00
date_gmt: 2023-07-18T18:12:09+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=4092'
id: 4092
modified: 2023-07-18T14:12:54-04:00
modified_gmt: 2023-07-18T18:12:54+00:00
name: css-wishes-add-to-existing-rules
pings: ['https://www.tobymackenzie.com/blog/2023/02/25/css-wishlist/']
tags: [css, wants]
---

CSS wishes: add to existing rules
=================================

Some months ago, I wrote a [2023 CSS wishlist](https://www.tobymackenzie.com/blog/2023/02/25/css-wishlist/) for things I'd like to see in the spec.  Among them was the desire to be able to add to existing CSS values.  This would be particularly useful for multi-value properties like `transition` and `transform`, although it would also be cool to be able to add to existing numeric values, like `2em` more padding than this would otherwise have.  There would be difficulties implementing this as described in that post though.  I've thought of some other possible options that may be less problematic.

<!--more-->

A problem with a multi-value property like `transition` is that we might have rules affecting the same element in different parts of our code that animates different properties.  For example, we might have a rule somewhere that animates the opacity on hover for `<a>`, like:

``` css
a:focus, a:hover{
	opacity: 0.8;
	transition: opacity: 0.2s;
}
```

Somewhere else, we may have a rule for a `emph` class that animates the scale a bit, like:

``` css
.emph:focus, .emph:hover{
	transform: scale(1.2);
	transition: transform 0.2s;
}
```

We wouldn't want adding the `emph` class on an `<a>` to remove the `opacity` animation.  I had proposed some syntax like:

``` css
.emph:focus, .emph:hover{
	transform: scale(1.2);
	+transition: transform 0.2s;
}
```

However, this would require a completely new type of handling logic by the browser.  All existing properties are simply set for that rule and then either override or don't the existing value for an element.  In order to avoid this in this case, we could make a special syntax that is sort of a pseudo-property.  Since `:` is already used to mark the end of a property name, we could use parenthesis, which I don't believe have current use in a property name.  So we could have something like:

``` css
.emph:focus, .emph:hover{
	transform: scale(1.2);
	transition(transform): 0.2s;
}
```

This makes `transition-property`, which is the longhand of that property part of a `transition` shorthand, sort of a shorthand itself for the property it affects.  So any `transition(transform)` would follow the normal cascade rules, overriding all previous settings for the `transform` transition.  The pseudo-ness would eliminate the need to create hundreds of separate `transition-property-` properties to cover all possible property values.

For multi-value properties like `background`, where there isn't really a named sub-property of sorts to affect, we could have numeric index pseudos for the normally sequential values.  For example:

``` css
body{
	background: green, url('/bg.jpg') center center no-repeat;
}
```

could be equivalent to:

``` css
body{
	background(1): green;
	background(2): url('/bg.jpg') center center no-repeat;
}
```

The `2` background could be overridden elsewhere in the CSS without overriding or having to restate the `green` background.

I had also said it would be nice to be able to add a numeric value to an existing numeric value.  For example, we might want to add additional padding to the top of an element where we want to stick an absolutely positioned pseudo-element and make space for it, as a generic class that won't otherwise remove the existing padding of the element it is added to.  With our new syntax, we could use the numeric pseudo-property to reference an index of a pseudo-padding, where once attached to an element, all pseudo-paddings would be added together.  Index `1` would be the normal padding that the regular `padding` property refers to, and index `2` plus would be for the new pseudos.  Example:

``` css
.box{
	background: green;
	padding: 2em;
}
.callout{
	padding-top(2): 1.5em;
}
.callout:before{
	color: red; content: '!!!'; left: 0.5em; position: absolute; top: 0.5em;
}
```

This would again avoid having to have a totally different cascade model for some properties, so any `padding-top(2)` that wins the cascade would be applied for that `2` slot of the padding.  Obviously, there would still have to be coordination in the site's styles to avoid overriding other `padding-top`s in the same site, but it allows us to use the same `callout` class on a:

``` css
.aside{
	border: 1px solid;
	padding: 1em;
}
```

getting the desired overall padding without having to make separate `.box.callout` and `.aside.callout` and manually calculating what that value should be (`3.5em` and `2.5em` respectively).

This wish would still be complicated to implement, and I imagine at this point the amount of work would be seen as too much compared to the value for the browser makers.  But it would certainly be nice for developers and allow HTML creators to add classes with less worry about whether the CSS creators had thought about their use in that context, while reducing repetition and CSS file size.
