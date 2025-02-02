---
categories: [www]
date: 2009-09-15T04:54:14+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=17'
id: 363
modified: 2009-09-15T04:54:14+00:00
name: full-wordpress-blog
tags: [layout, style, webiiclass, wordpress]
---

Full Wordpress Blog
===================

We set up the full version of Wordpress (from [wordpress.org](http://wordpress.org/)) for learning how to work with it.  Mine can be found [here](http://lostincleveland.com/wptoby/).  I've already had experience working with the full version of wordpress (I've used it for years on my own site), but I haven't gotten too far working with the themes.  I've taken this opportunity to make a theme nearly from scratch.  I've used the Sandbox theme, deleting all CSS but leaving the html/php templates.  I've considered modifying those as well, as I don't like everything about them and I may need to to get the site to work as desired.

Anyway, I've created a semi-fluid centered layout there using absolute positioning within a div.  I've been wanting to do something like this to allow the navigation and other non-main content to be placed at the bottom of the page structurally but still where I want it for appearance.

It works fairly nicely, though it still has some problems.  For instance, padding on any of the absolutely positioned boxes expands them and messes up the layout.  Any padding must be done on sub-elements.  Borders on any of the main blocks don't work either, and can cause layout problems.  And since the side columns are absolutely positioned and take up no height, I need a min-height to ensure all of their content doesn't float out of their box.  I hope to continue working on the theme to correct these problems, and may use something similar for my own website.

I recently (re)read about elastic layouts.  I find the idea to be good for usability:  The whole site scales when the text size changes.  So I've considered changing the theme to work completely based on em's for sizing, except I'd have to use a workaround for the full image header.  Strangely though it seems most newer browsers can scale any site almost as if they were already elastic:  With the aforementioned theme, IE 7, Firefox 3.5, and Safari 4 scale the whole page, including the header image and pixel width sidebars, down or up just fine and even maintain line lengths through part of the scaling.  Currently the page is 100% width unless the browser goes wider than its max-width, so I'd try to keep that if going to em's.

The theme hasn't been tested in IE 6 yet, since I don't think I have a copy:  I may have to use a virtual version or another computer.  I imagine it will fail miserably there.  I haven't yet delved into the conditional stylesheets, but I may add one just for IE 6 if the site doesn't work well with it.

I can't figure out how to apply this theme to this wordpress.com blog.  It seems like it may cost money to do.  I'll have to investigate further.  I may end up moving this blog for the class over there, maybe converting this into a personal blog.
