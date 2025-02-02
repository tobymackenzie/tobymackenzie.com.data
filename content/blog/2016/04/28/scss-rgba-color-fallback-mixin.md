---
categories: [www]
date: 2016-04-28T23:04:50-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1103'
id: 1103
modified: 2016-04-28T23:04:50-05:00
name: scss-rgba-color-fallback-mixin
pings: ['https://www.tobymackenzie.com/blog/2014/04/11/scss-rem-fallback-mixin/']
tags: [color, mixin, progressiveenhancement, scss]
---

SCSS rgba color fallback mixin
==============================

[Browser support for `rgba` colors](http://caniuse.com/#feat=css3-colors) is very wide, basically working in everything but IE8- and really old browsers.  In the name of progressive enhancement, it's still good to give those browsers a fallback, the simplest being the solid version of the same color.  This can be done by putting the property twice, once with a solid value and once with an `rgba` value.  The non-supporting browsers will take the solid color and ignore the `rgba`, while the supporting browsers will take both, with the `rgba` overriding.  As an example: `color: #fff; color: rgba(1, 1, 1, 0.6);`.

To that end, I created a mixin to do this automatically, similar to [my `remFallback` mixin](https://www.tobymackenzie.com/blog/2014/04/11/scss-rem-fallback-mixin/): 

<!--more-->

``` scss
@mixin colorFallback($property, $values){
	$normal: ();
	$rgba: ();
	@each $value in $values{
		@if type-of($value) == 'color' and alpha($value) != 1{
			$normal: append(rgba($value, 1), $normal);
		}@else{
			$normal: append($value, $normal);
		}
		$rgba: append($value, $rgba);
	}
	@if $normal == $rgba {
		#{$property}: $normal;
	} @else {
		#{$property}: $normal;
		#{$property}: $rgba;
	}
}
```

It takes a property as the first argument and its value(s) as the second argument.  It will go through each value and only modify ones that are colors and have an alpha value that isn't one.  It will output the property twice only if there is a color needing alpha, so it is theoretically safe to use on any property-value pair.

It can be used like:

``` scss
.foo{
	// single value
	@include colorFallback('background', rgba(0, 0, 0, 0.6));
	// multiple values, some not colors
	@include colorFallback('border', 2px solid rgba(255, 255, 255, 0.8));
	// non-color value
	@include colorFallback('border-radius', 5px);
	// non-alpha color value
	@include colorFallback('color', #fff);
}
```

which should compile to:

``` css
.foo{
	background: #000;
	background: rgba(0, 0, 0, 0.6);
	border: 2px solid #fff;
	border: 2px solid rgba(255, 255, 255, 0.8);
	border-radius: 5px;
	color: #fff;
}
```
