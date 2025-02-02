---
categories: [www]
comment_count: 1
date: 2010-10-20T02:40:36+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=404'
id: 441
modified: 2016-04-04T21:09:38-05:00
name: css3-text-rotation-rendering-problems
tags: [css, css3, problem, rotation]
---

CSS3: Text Rotation Rendering Problems
======================================

As mentioned in [another post on css rotation](https://tobymackenzie.com/blog/2010/08/23/css3-rotation/), I had some issues with rotating text.  On the Amy's Shoes site, <s>now live</s> <ins>\[no longer our design\]</ins>, I use [`transform:rotate();`](http://www.w3.org/TR/css3-2d-transforms/#transform-functions) for CSS3 capable browsers and the [matrix filter](http://msdn.microsoft.com/en-us/library/ms533014%28VS.85%29.aspx) for <abbr title="Internet Explorer">IE</abbr> to rotate various elements.

In IE, I had noticed that the text was somewhat blurry when rotated, especially for smaller font-sizes.  I hadn't noticed, though, that the rotated text also rendered poorly in Firefox for Windows and Safari for Windows.  They render the text with messed up kerning and letter positioning, so that it can become illegible on smaller text and even have overlapping letters.  Not in Opera in Chrome, just those browsers.  I test Firefox and Safari on Mac only, since rendering of most things is exactly the same.  Evidently not the case with rotated font rendering though, and I will have to keep this in mind and test the new CSS3 features more thoroughly.

Because of this issue, I made my first ever style sheet targeting an entire operating system (Windows), since the rotation was not working on so many Windows browsers.  The stylesheet simply removes the rotation on the main body text and repositions things slightly so that the layout still works.  We were considering doing image replacement for the menu and button text on Windows as well, but haven't gone that far yet, as the larger text doesn't look nearly as bad.  The rendering is also slightly messed up on Firefox for Mac, but not too bad to use.

We're not sure why the rendering is so bad on those Windows browsers.  For IE, it is likely the way it handles the matrix filter.  For Safari and Firefox, it may have something to do with the way Windows deals with fonts compared to how Mac does.  Maybe Chrome and Opera somehow bypass the rendering issue.  I don't know what's up, but this and the other issues mentioned in the previous article suggest that, unfortunately, rotation of text is still not to the point where it can be indiscriminately used, and is best used in a way where the unrotated version still works fine, because that will need to be done for some browsers.
