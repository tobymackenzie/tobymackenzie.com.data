---
categories: [www]
date: 2014-01-03T02:08:21-05:00
guid: 'http://tobymackenzie.wordpress.com/?p=560'
id: 560
modified: 2014-01-03T02:08:21-05:00
name: css-position-absolute-with-auto-values
tags: [css]
---

CSS: Position absolute with auto values
=======================================

I have been using 'position: absolute' for a long time for a lot of things, such as drop down menus, pop ups, decorations, and things that need animating, yet I never realized what using 'auto' for one of the coordinates (eg 'left' or 'top') meant and how useful this could be.  I had thought it was the same as '0', but it simply means (in all browsers I test in, including IE 7) that the element will be where it was for that coordinate as if it were statically positioned.  This is very simple, but very useful in certain circumstances and probably would've saved me a lot of work in the past.  I have spent a lot of time getting things positioned properly below items when both are variable height or below fixed height items when I need the positioning parent to be a parent container so that other attributes (such as width and left) can be based on that container.

As an example of where this could be useful, I was recently working on something similar to the grid with slide down details on [Zoraab](http://www.zoraab.com/collections/mens-socks) (I'm linking to this because the one I worked on is not live yet and we used it as an example for ideas).  It has a grid of items with a variable number of columns.  The details slide down below their item when the item is clicked, but they are the full width of the entire grid.  I spent some time setting up JavaScript to calculate the 'top' the item needed to be at to be below it's containing item while using the entire grid as a positioning parent so I could have the details be at the left of the grid and 100% of its width.  It worked fine, except when switching from one item to another that is below it.  Then the top would be off (because it was calculated when the other item was open) and the item would be overlapping items below it.  I was going to spend more time working on a JavaScript fix, but then I discovered how the 'auto' value works (Zoraab uses it, should've looked at that earlier).  With it, I still get the 'left' and 'width' from the grid container, but the top is right where it is in the markup, below the clickable part of the item.
