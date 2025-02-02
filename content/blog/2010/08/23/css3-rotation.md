---
categories: [www]
comment_count: 1
date: 2010-08-23T07:33:33+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=380'
id: 437
modified: 2016-05-04T22:50:41-05:00
name: css3-rotation
tags: [css3, rotation]
---

CSS3: Rotation
==============

Continuing my adoption of new CSS3 capabilities, I've built my first site using rotation.  CSS3 allows rotation of elements with the [`transform: rotate();`](http://www.w3.org/TR/css3-2d-transforms/#transform-functions) declaration.  It is as simple as giving a value between the rotate parenthesis with a number and the unit `deg`.  Positive values go clockwise, negative values counter-clockwise.  I don't think any browsers yet support the CSS3 spec `transform` property, so you must use the vendor-specific hack prefixed properties `-moz-transform`, `-webkit-transform`, and `-o-transform`.  There is in fact a CSS3 proposed [`rotation` property](http://www.w3.org/TR/css3-box/#rotating), but I believe that has no current support at all.

Then, there is IE.  For IE, the [matrix filter](http://msdn.microsoft.com/en-us/library/ms533014%28VS.85%29.aspx) must be used.  It, unfortunately, does not allow for nice degree values to be used and instead uses four numbers derived by some confusing math.  I could not get Microsoft's example script working, but I found [this matrix rotation calculator](http://www.boogdesign.com/examples/transforms/matrix-calculator.html) to calculate the values and create the declarations.  It shows that a similar matrix transformation is available in the `transform` property, but the value is more confusing, so I just used the `rotate` transformation for transform capable browsers.  So for IE I must go to the calculator for every degree value of rotation I want to have.  Somewhat of a pain, but at least it works.

The site I built is for Amy's Shoes.  <s>The new version has not yet gone live, but I'll link to it once it has</s> <ins>\[We no longer run this site\]</ins>.  The design utilized a lot of rotation, with many different elements rotated in different orientations.  It also needed to be able to handle some dynamic and AJAXed content.  I ran into a number of issues while building the site that are worth mentioning.

<!--more-->
Position
--------

IE does not seem to be able to rotate anything that isn't absolutely positioned.  For the sake of keeping everything similar across browsers, this means all rotated elements must be absolutely positioned.  This is a major limitation to what you can do with the rotation, since rotation has no height or width in its containing element.  Rotating a main content block means you will most likely have to make the layout fixed width and height.

To get some pieces below other expandable pieces with different rotation, I placed them inside the piece that went above them, then positioned them to the appropriate position below the content and applied another rotate to them relative to the rotation of the above piece (the container).  This only works for fixed height elements.  I found I sometimes had to give some extra padding to the container or the bottom of parts of the below piece would get cut off where they went out of the rotation of the container.

Also of note, IE positioned the rotated elements differently than other browsers ([this post suggests that the point of rotation is different and the padding is handled differently](http://www.boogdesign.com/b2evo/index.php/2009/09/04/element-rotation-ie-matrix-filter?blog=2)).  I served up different stylesheets for each version of IE to fix the positioning.  IE8 was mostly the same as other browsers, but IE7 and 6 required a number of changes.

IE 6 and 7 could not deal with rotated elements positioned partly off the right edge of the screen.  For IE 7 I just moved them in a bit.  For IE 6, I had some very strange behavior where the elements that would otherwise be up against the right edge were not positioning properly at all, so I ended up positioning against the left edge of the screen instead.  I'm not sure what the issue was there.

Form Elements
-------------

Both IE and Opera had some issues with rotated form elements.  The biggest problem was with text inputs.  In all versions of IE I develop for (6-8), the text cursor and places users had to click to position the cursor in the input were where they would have been if they were not rotated, making it nearly impossible to click to position the cursor or to select content in the element.  In Opera, rotated text elements displayed every input character as one particularly character, sort of like a password field with something other than bullets.  For one field, it was "open parenthesis" characters, for another it was something else.  The rotated inputs didn't look perfect and had some usability issues in other browsers as well, so I made them all unrotated.  Take note that rotating and then unrotating elements does not fix the problem so the whole container will have to be unrotated for IE, while you can just unrotate the inputs and any necessary surrounding content in other browsers.

The other element I had trouble with was the select menu.  It was an issue in IE 6 & 7, where the menus were unrotated.  In IE 6 in particular, it was positioned in a completely different place.  I had to leave the whole container unrotated for those browsers again.  In IE 8, the menu is somewhat harder to get to drop down by mouse, but still usable, so I left it, and it worked just fine in other browsers.

Other Issues
------------

There were a lot of other smaller issues I ran into while building the site, but I don't remember most of them.  The rendering quality isn't perfect in all browsers.  In IE, rotated elements, especially ones with small text, become somewhat blurry, making it more difficult to read.  That obviously could be a huge issue for viewers with poor eyesight, for whom you'd have allow larger text sizes.  It seems especially blurry in IE 8 for whatever reason.  Also note that rotated text in Firefox seems to render along a jaggedy baseline, making it look less neat and slightly harder to read.  I also had some issues in IE 6 and 7 because of the lack of `display: inline-block` of positioning some elements with backgrounds that were the width of their content, causing a lot of elements to end up unrotated in those browsers.  It is worth mentioning that the layout, because most everything was only slightly rotated, looks just fine without rotation applied at all, just not with the same visual affect. [Update]see [this post for a follow up about the text issues](/content/2010/10/20/css3-text-rotation-rendering-problems.md)]

Conclusion
----------

Rotated elements can be a pain to deal with and even cause a number of usability issues given the current state of things.  But it is currently possible to pull off a site with CSS rotation and create a unique and interesting design.  Images can be used for rotation effects, but they have their own issues, as I experience with the dropdown menus on the [Akron Art Museum site](http://akronartmuseum.org/) (<s>which will soon be updated to my widened and markup updated version</s> <ins>a more recent design doesn't have rotation</ins>).  Also keep in mind that if you only need `90°` rotation, [snook describes a different method](http://snook.ca/archives/html_and_css/css-text-rotation) that seems to not have so many issues.
