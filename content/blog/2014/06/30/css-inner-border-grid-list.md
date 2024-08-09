---
categories: [www]
comment_count: 1
date: 2014-06-30T01:12:15-05:00
date_gmt: 2014-06-30T06:12:15+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=629'
id: 629
modified: 2020-07-22T20:44:33-04:00
modified_gmt: 2020-07-23T00:44:33+00:00
name: css-inner-border-grid-list
tags: [css, style, technique]
---

CSS: Inner Border Grid List
===========================

[note]This post is not about the grid layout spec, but I have [created a solution using it](/blog/2018/01/06/css-inner-border-grid-list-grid-layout/) to solve the same problem this post is solving.[/note]

Many of the recent designs at [Cogneato](http://cogneato.com) have had a responsive grid list of items that have a border between them.  By grid I'm meaning like an image or product grid where the items flow horizontally and then wrap and are all the same width.  By inner border I'm meaning a border around each item except the edges that don't touch another item.  <del>See a more complicated example that uses sub-grids.</del>  My solutions thus far haven't been ideal.  But I recently thought of and found some solutions that, when combined, make for a better option.

The biggest difficulty with this type of situation can be getting the items on the same row to be the same height so that all borders meet up.  I have been either requiring a fixed height for the items or using JavaScript to equalize the heights on a given row (which of course has to be rerun upon screen resize).  The fixed height option means content creators are forced to limit how much content they put in each item or it will be clipped.  There is also the potential for extra whitespace when there is less content.  Considering the JavaScript option, I definitely try to avoid having the presentation depend on JavaScript.  It is a potential performance issue as it has to continuously poll for browser resize and update the height when it changes.

position: absolute
------------------

Every time I build this sort of thing, I desire a better solution, but have limited time, and settle on my previous solutions.  When doing the most recent site with this sort of grid, I theorized a solution taking advantage of a few other tricks, and later implemented it in my off time.  The most important was my relatively recent discovery of [how `position: absolute` with `auto` works](/2014/01/03/css-position-absolute-with-auto-values/).

<!--more-->

The basic idea is to have some elements or pseudo elements in specific grid items form the borders for an entire row or column.  They do this by using the grid container as a positioning parent so they can go from edge to edge, but using `auto` to have the position along the other axis relative to the item.  With this, there only needs to be one item per row and one item per column to hold the borders.  This requires specific targeting with `nth-child()` or special classes set in the markup.

There are a couple of caveats with this approach.  One is that the items themselves will not be the same height (unless you use flexbox), so if they need to be this will not work.  This was not a problem for my use case.  Also, the borders will go the full height of the container for all columns, regardless of whether or not there are items in that column in the bottom row.

I have not implemented this yet on any actual sites, but I have made [an example of the positioned technique](https://www.tobymackenzie.com/examples/css/innerBorderWrappedGrid/positioned-n.php) that goes up to four columns.  I will provide an abbreviated example that goes to two columns below.

### CSS

``` css
*{
	box-sizing: border-box;
}
.box{
	border-top: 3px dotted black;
	padding: 1em 0;
}
.box-n-1{
	border-top: 0;
}
@media screen and (min-width: 38em){
	.box{
		border: 0;
		float: left;
		padding: 0;
		width: 50%;
	}
	.boxContent{
		overflow: hidden;
		padding: 1em;
	}
	.boxes{
		overflow: hidden;
		position: relative;
	}
	.box-n-2:after{
		border-left: 3px dotted black;
		content: ' ';
		height: 100%;
		position: absolute;
		top: 0;
		width: 1px;
		z-index: 10;
	}
	.box-n-1:before{
		display: none;
	}
	.box-n-odd{
		clear: left;
	}
	.box-n-odd:before{
		border-top: 3px dotted black;
		content: ' ';
		height: 1px;
		position: absolute;
		right: 0;
		width: 100%;
		z-index: 10;
	}
}
```

### HTML

```html
<div class="boxesWrap">
	<div class="boxes">
		<div class="box box-n-1 box-n-odd">
			<div class="boxContent">Lorem ipsum</div>
		</div>
		<div class="box box-n-2 box-n-even">
			<div class="boxContent">Dolor sit amet nonummy</div>
		</div>
		<div class="box box-n-3 box-n-odd">
			<div class="boxContent"><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p></div>
		</div>
		<div class="box box-n-4 box-n-even">
			<div class="boxContent"><p>Amet</p><p>Lorem ipsum sit dolor</p></div>
		</div>
	</div>
</div>
```

I also made [a flexbox example of the same technique](https://www.tobymackenzie.com/examples/css/innerBorderWrappedGrid/flex-positioned-n.php) to demonstrate this same technique with the items having equal heights on the same row.  This version has more limited browser support, requiring flexbox with `flex-wrap` support.

Flexbox
-------

Looking at the flexbox example above, you may have realized that since the item heights are equalized, we could just put borders on the items themselves and they would connect from item to item.  We could target specific items like in the positioning examples to put the borders in the right places, as in this [flexbox with nth-child example](https://www.tobymackenzie.com/examples/css/innerBorderWrappedGrid/flex-n.php).

We could simplify the CSS significantly by using a little negative margin magic with `overflow: hidden` on the container to hide borders on some items.  I found the basics of this idea [on a CodePen](http://codepen.io/dalgard/pen/Dbnus) that I had to modify slightly to get working with percentage based widths.  See my [flexbox example using negative margins](/examples/css/innerBorderWrappedGrid/flex-negativeMargin.php).  Using the same markup as the previous example, the following CSS will work similarly.  Since it is less verbose, I've provide the three and four column CSS as well.

### CSS

``` css
*{
	box-sizing: border-box;
}
.box{
	border-top: 3px dotted black;
	padding: 1em 0;
}
.box-n-1{
	border-top: 0;
}
@media screen and (min-width: 38em){
	.box{
		border: 0;
		border-bottom: 3px dotted black;
		border-right: 3px dotted black;
		flex: 0 1 50%;
		padding: 1em;
	}
	.boxContent{
		overflow: hidden;
	}
	.boxes{
		display: flex;
		flex-wrap: wrap;
		margin: 0 -3px -3px 0;
		position: relative;
	}
	.boxesWrap{
		overflow: hidden;
	}
}
@media screen and (min-width: 48em){
	.box{
		flex-basis: 33.33%;
	}
}
@media screen and (min-width: 60em){
	.box{
		flex-basis: 25%;
	}
}
```

Note that in these two examples, the border doesn't extend down into the last row for columns that have no items there, and the first doesn't even have borders between the missing items and the items above them.  And, of course, this only works in newer versions of browsers.  Firefox just got `flex-wrap` support in version 28.  IE 10- don't support `flex-wrap` either.

Combined
--------

In order to support both newer and older browsers, the above techniques can be combined.  The older browsers will get slightly different behavior, but they will be close enough.  I added some extra elements in this case to support IE 7, which doesn't support `:before` or `:after`.  I used [modernizr](http://modernizr.com/download/#-flexbox-cssclasses-testprop-testallprops-domprefixes-cssclassprefix:ua!) to easily detect flexbox support and provide appropriate styles to non-supporting browsers.  I also used conditional comments to give IE 8- the two column version, allowing me to give them a more desktop appropriate appearance while doing mobile first.  I'm not sure how I will do it on the site I'm working on.

You can look at [the full combined example](https://www.tobymackenzie.com/examples/css/innerBorderWrappedGrid/flex-negativeMargin-fallback-positioned.php) or look at an abbreviated version below.

### CSS

``` css
	*{
		box-sizing: border-box;
	}

	/*--mobile first */
	.box{
		border-top: 3px dotted black;
		padding: 1em;
	}
	.box-n-1{
		border-top: 0;
	}

	/*--flex */
	@media screen and (min-width: 38em){
		.box{
			border: 0;
			border-bottom: 3px dotted black;
			border-right: 3px dotted black;
			flex: 0 1 50%;
		}
		.boxContent{
			overflow: hidden;
		}
		.boxes{
			display: flex;
			flex-wrap: wrap;
			margin: 0 -3px -3px 0;
			max-width: none;
			position: relative;
		}
		.boxesWrap{
			overflow: hidden;
		}
	}
	@media screen and (min-width: 48em){
		.box{
			flex-basis: 33.33%;
		}
	}
	@media screen and (min-width: 60em){
		.box{
			flex-basis: 25%;
		}
	}

	/*--fallback */
	@media screen and (min-width: 38em){
		html.ua-no-flexbox .box{
			border: 0;
			float: left;
			padding: 0;
			width: 50%;
		}
		html.ua-no-flexbox .boxContent{
			/*overflow: hidden;*/
			padding: 1em;
		}
		html.ua-no-flexbox .boxes{
			overflow: hidden;
			/*position: relative;*/
		}
		html.ua-no-flexbox .box-n-2 .boxAfter{
			border-left: 3px dotted black;
			content: ' ';
			height: 100%;
			position: absolute;
			top: 0;
			width: 1px;
			z-index: 10;
		}
		html.ua-no-flexbox .box-n-1 .boxBefore{
			display: none;
		}
		html.ua-no-flexbox .box-n-odd{
			clear: left;
		}
		html.ua-no-flexbox .box-n-odd .boxBefore{
			border-top: 3px dotted black;
			content: ' ';
			height: 1px;
			position: absolute;
			right: 0;
			width: 100%;
			z-index: 10;
		}
	}
```

### IE 8- CSS

``` css
.box{
	border: 0;
	float: left;
	padding: 0;
	width: 50%;
}
.boxContent{
	overflow: hidden;
	padding: 1em;
}
.boxes{
	overflow: hidden;
	position: relative;
}
.box-n-2 .boxAfter{
	border-left: 3px dotted black;
	content: ' ';
	height: 100%;
	position: absolute;
	top: 0;
	width: 1px;
	z-index: 10;
}
.box-n-1 .boxBefore{
	display: none;
}
.box-n-odd{
	clear: left;
}
.box-n-odd .boxBefore{
	border-top: 3px dotted black;
	content: ' ';
	height: 1px;
	position: absolute;
	right: 0;
	width: 100%;
	z-index: 10;
}
```

### HTML

``` html
<div class="boxesWrap">
	<div class="boxes">
		<div class="box box-n-1 box-n-odd">
			<div class="boxBefore"></div>
			<div class="boxContent">Lorem ipsum</div>
			<div class="boxAfter"></div>
		</div>
		<div class="box box-n-2 box-n-even">
			<div class="boxBefore"></div>
			<div class="boxContent">Dolor sit amet nonummy</div>
			<div class="boxAfter"></div>
		</div>
		<div class="box box-n-3 box-n-odd">
			<div class="boxBefore"></div>
			<div class="boxContent"><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p><p>Nonummy ipsoem lorem sit amet nonummy</p></div>
			<div class="boxAfter"></div>
		</div>
		<div class="box box-n-4 box-n-even">
			<div class="boxBefore"></div>
			<div class="boxContent"><p>Amet</p><p>Lorem ipsum sit dolor</p></div>
			<div class="boxAfter"></div>
		</div>
	</div>
</div>
```
