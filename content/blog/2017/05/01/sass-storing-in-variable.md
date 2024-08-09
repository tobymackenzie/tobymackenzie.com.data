---
categories: [www]
date: 2017-05-01T23:00:17-05:00
date_gmt: 2017-05-02T04:00:17+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1467'
id: 1467
modified: 2017-05-01T23:00:17-05:00
modified_gmt: 2017-05-02T04:00:17+00:00
name: sass-storing-in-variable
pings: ['https://www.tobymackenzie.com/blog/2016/05/10/duplicate-selectors-increase-specificity/']
tags: [sass, selector, trick]
---

SASS: Storing `&` in variable
=============================

Apparently in SASS you can [store the current selector in a variable](https://medium.com/@jakobud/how-to-do-sass-grandparent-selectors-b8666dcaf961), eg `a{ $a: &; }`.  Useful for dealing with some limitations of `&` without having to repeat selectors.

<!--more-->

I've run into the example that Jake Wilson did, where something like:

``` scss
.foo{
	&Bar{
		color: blue;
		&:hover .fooBiz{
			color: red;
		}
	}
}
```

could by <abbr title="don't repeat yourself">DRY</abbr>er as something like:

``` scss
.foo{
	$l1: &;
	&Bar{
		color: blue;
		&:hover #{$l1}Biz{
			color: red;
		}
	}
}
```

I could also see it being used for the trick of [duplicating selectors to increase specificy](https://www.tobymackenzie.com/blog/2016/05/10/duplicate-selectors-increase-specificity/), eg:

``` scss
.foo{
	$l1: &;
	&#{$l1}{
		color: red;
	}
}
```

Neat.
