---
categories: [www]
date: 2018-01-06T19:39:53-05:00
date_gmt: 2018-01-07T00:39:53+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1736'
id: 1736
modified: 2022-10-30T19:12:08-04:00
modified_gmt: 2022-10-30T23:12:08+00:00
name: css-inner-border-grid-list-grid-layout
pings: ['https://css-tricks.com/snippets/css/a-guide-to-flexbox/', 'https://www.tobymackenzie.com/blog/2014/06/30/css-inner-border-grid-list/']
tags: [css, grid, layout]
---

CSS: inner border grid list with grid layout
============================================

A couple years ago, I wrote a [post titled "CSS: Inner Border Grid List"](https://www.tobymackenzie.com/blog/2014/06/30/css-inner-border-grid-list/) about solutions to a problem I was having.  The post is not about [CSS grid layout](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Grid_Layout), but recent interest in the post leads me to believe people are visiting expecting it to be.  In the interest of serving those visitors, I decided to create a solution using the [now well supported spec](https://caniuse.com/#feat=css-grid).

<!--more-->

The problem was to create a wrapped grid of items where they have borders between each item but not between the items and the outside of the grid.  There should only be a single border thickness between items.

It was pretty easy to implement with grid.  Four property lines are specific to grid across three break-points.  Using only grid properties, I didn't need to use `@supports` or the like to block anything from non-supporting browsers.

I implemented a [flexbox](https://css-tricks.com/snippets/css/a-guide-to-flexbox/) fallback for supporting browsers.  I did not put in the extra effort for pre-flexbox browsers as I had before.  They just get full-width boxes.  It would be possible to use my [positioned technique](https://www.tobymackenzie.com//examples/css/innerBorderWrappedGrid/positioned-n.php) for them, but it would be more verbose.

I'm using `flex-basis` for setting the width in the flex solution, since older browsers will ignore it.  A [bug in IE 11-](https://github.com/philipwalton/flexbugs#flexbug-7) results in the boxes being wider than they should be, pushing an item into the next row and leaving empty space on the right.  As a dirty fix, I used `-ms-flex-positive: 1` (its equivalent of `flex-grow`) to make the items fill in empty space.  It isn't exactly the same effect, but looks better than doing nothing.

[See the demo](https://www.tobymackenzie.com/examples/css/innerBorderWrappedGrid/grid-negativeMargin-fallback.php).  Distilled code below:

### CSS

``` css
*{
	box-sizing: border-box;
}
.box{
	border-bottom: 3px dotted black;
	padding: 1em;
}
.boxes{
	margin-bottom: -3px;
}
.boxesWrap{
	overflow: hidden;
}
@media screen and (min-width: 38em){
	.box{
		border-right: 3px dotted black;
		flex: 0 1 50%;
		-ms-flex-positive: 1;
	}
	.boxes{
		display: flex;
		display: grid;
		flex-wrap: wrap;
		grid-template-columns: repeat(2, 1fr);
		margin-right: -3px;
	}
}
@media screen and (min-width: 48em){
	.box{
		flex-basis: 33.33%;
	}
	.boxes{
		grid-template-columns: repeat(3, 1fr);
	}
}
@media screen and (min-width: 60em){
	.box{
		flex-basis: 25%;
	}
	.boxes{
		grid-template-columns: repeat(4, 1fr);
	}
}
```

### HTML

``` html
<div class="boxesWrap">
	<div class="boxes">
		<div class="box">Lorem ipsum</div>
		<div class="box">Dolor sit amet nonummy</div>
		<div class="box"><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p></div>
		<div class="box"><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p>></div>
		<div class="box"><p>Amet</p><p>Lorem ipsum sit dolor</p></div>
		<div class="box"><p>Amet</p><p>Lorem ipsum sit dolor</p><p>Amet</p><p>Lorem ipsum sit dolor</p><p>Amet</p><p>Lorem ipsum sit dolor</p><p>Amet</p></div>
		<div class="box"><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Amet</p><p>Lorem ipsum sit dolor</p><p>Amet</p><p>Lorem ipsum sit dolor</p></div>
	</div>
</div>
```
