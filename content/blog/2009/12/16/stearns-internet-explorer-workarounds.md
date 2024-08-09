---
categories: [www]
date: 2009-12-16T09:20:03+00:00
date_gmt: 2009-12-16T09:20:03+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=128'
id: 400
modified: 2009-12-16T09:20:03+00:00
modified_gmt: 2009-12-16T09:20:03+00:00
name: stearns-internet-explorer-workarounds
tags: [ie, javascript, problem, stearns, style]
---

Stearns: Internet Explorer workarounds
======================================

We've had to do a bit of work to get our site working properly in IE, mostly version 6.  I've recently started using a conditional stylesheet just for IE6 on my own site, like:

```
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url')?>/styleIE6.css" />
<![endif]-->
```

and we did the same for Stearns.

Box Model
---------

One issue we dealt with for IE6 in the conditional stylesheet was box model issues.  IE6 handles margins, padding, and borders differently than other browsers, so we compensated for this in some places.  One big issue was with our floated columns:  The third would float below the second on some wide pages.

<!--more-->
Background Image
----------------

We also had a strange issue with some little icons we put next to our headers.  We use a background image set inside space left by padding to put the icons in (a random icon, no less, with PHP assigned classes).  IE6 added the padding, but not the icon.  We had to assign a height of 1% to the header to get the images to display, a very strange workaround for sure.  Spent a while till I found that solution [here](http://www.webcredible.co.uk/user-friendly-resources/css/internet-explorer.shtml).

Menu
----

We also used some conditions in javascript to get our dropdown menu to work:

```
var isIE = /MSIE (d+.d+);/.test(navigator.userAgent);
var IEVersion = new Number(RegExp.$1);
if(IEVersion < 7){ forIE6andBefore}
if(IEVersion == 7){ forIE7}
```

This was found at [this site](http://www.javascriptkit.com/javatutors/navigator.shtml), and I'm not quite sure how it works, but it does.

For other browsers, we set the visibility of a div to hidden to hide a menu, but for IE7 we had to use "display:none".

For IE6, we had a number of problems, such as the menu items not being able to be clicked.  We had to set the height of the header block the menu is in to something big enough to accommodate the height of all items while simultaneously setting the margin of the content below to a negative value to move it back up.
