---
categories: [www]
comment_count: 4
date: 2014-04-11T01:46:36-05:00
guid: 'http://tobymackenzie.wordpress.com/?p=587'
id: 587
modified: 2024-06-05T22:54:09-04:00
name: scss-rem-fallback-mixin
tags: [css, mixin, preprocessing, sass, style]
---

SCSS rem fallback mixin, my take
================================

The `rem` CSS unit allows you to base your font sizes off of the user's configured font size, but not be affected by parent elements like `em`s are. Older browsers don't support `rem`s though, so it's good to provide a fallback in `px` for them by defining the property with a `px` value, then a `rem` value. Old browsers take the `px` value, then see they don't know how to handle the `rem` value and ignore it. New browsers take the `px` value, then override it with the `rem` value.

There are a number of [SCSS](http://sass-lang.com/) mixins out there for making rem fallbacks automatically by passing in a property and some values and having it automatically output both versions of the property. I started with the [css-tricks one](http://css-tricks.com/snippets/css/less-mixin-for-rem-font-sizing/). None of the ones I found, though, worked exactly as I wanted. I wanted to be able to work with any property values. I wanted:

- unitless number values (other than 0) to be treated as `px` values
- `px` or `rem` values to be converted to the other unit
- values with other units or non-numbers to be output as is (`auto`, `none`, `url`, etc)

<!--more-->

This would allow things like:

``` scss
a{
	@include remFallback(background, url('foo.jpeg') 1em 24);
	@include remFallback(margin, 0 auto 10px 1em);
}
```

CSS output:

``` css
a{
	background: url('foo.jpeg') 1em 24px;
	background: url('foo.jpeg') 1em 2.4rem;
	margin: 0 auto 10px 1em;
	margin: 0 auto 1rem 1em;
}
```

making it much more versatile. Hugo Giraudel made a [nice version](http://hugogiraudel.com/2013/03/18/the-ultimate-px-rem-mixin/) closer to what I wanted. I took that and modified it to be closer still. It seems to work for any case except for values with commas (such as multiple backgrounds). It can be found in [my html boilerplate](https://github.com/tobymackenzie/html-boilerplate/blob/5941cf79053e5fe27c5b54d190742d5496f58487/src/styles/mixins/units.scss#L17-L70). Currently, it looks like:

``` scss
/*
Variable: fontSizes.root
'px' font size on root (html) element (with units removed).  Browser default is 16px.  Used to determine sizes for remFallback function.

-@ based on http://css-tricks.com/snippets/css/less-mixin-for-rem-font-sizing/
*/
$fontSizes: () !default;
$fontSizes: map-merge((root: 16), $fontSizes);
/*
Mixin: remFallback
Output a property with pixel values for non 'rem' supporting browsers followed by the 'rem' equivalent for rem support browsers.  Can't currently accept values with comma separation, like multiple backgrounds or the like.

-@ based on http://hugogiraudel.com/2013/03/18/ultimate-rem-mixin/
*/

@mixin remFallback($property, $values) {
	$px: ();
	$rem: ();

	@each $value in $values{
		//--get unit or 'nan' if the value isn't a number
		// $unit: if(type-of($value) == 'number', unit($value), 'nan');
		$unit: 'nan';
		@if type-of($value) == 'number'{
			@if unitless($value){
				$unit: 'unitless';
			}@else{
				$unit: unit($value);
			}
		}

		//--unitless numbers are added as if they are in pix
		@if $unit == 'unitless' and $value != 0{
			$px : append($px, $value + px);
			$rem: append($rem, ($value / map-get($fontSizes, root) + rem));
		//--px or rem get added to their list and then converted to the other unit
		}@else if $unit == 'px' or $unit == 'rem'{
			$unitlessVal: stripUnit($value);
			@if $unit == 'px'{
				$px : append($px, $value);
				$rem: append($rem, ($unitlessVal / map-get($fontSizes, root) + rem));
			}@else if $unit == 'rem'{
				$px : append($px,($unitlessVal * map-get($fontSizes, root) + px));
				$rem: append($rem, $value);
			}
		//--all other units get appended directly
		}@else{
			$px : append($px , $value);
			$rem: append($rem, $value);
		}
	}

	@if $px == $rem {
		#{$property}: $px;
	} @else {
		#{$property}: $px;
		#{$property}: $rem;
	}
}

/*
Mixin: stripUnit
Strip the unit from a value that has a unit

-@ based on http://css-tricks.com/snippets/css/less-mixin-for-rem-font-sizing/
*/
@function stripUnit($num) {
	@return $num / ($num * 0 + 1);
}
```
