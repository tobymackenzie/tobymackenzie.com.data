---
categories: [www]
comment_count: 1
date: 2010-01-15T06:59:12+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=165'
id: 407
modified: 2010-01-15T06:59:12+00:00
name: new-wordpress-com-theme
tags: [theme, wordpress]
---

New Wordpress.com Theme
=======================

I searched through every 2-column theme with widget support in Wordpress.com's repository (there were 58) in an attempt to improve the appearance of my blog.  The main problems with the old one were that levels of headers weren't differentiated well enough (the second level ones looked like first level) and the code blocks weren't separated from other content well enough.  I couldn't find one template that I was fully happy with.  Every one had something I didn't like, and very few even had both good code block separation and good header differentiation.

This theme (Neat!) is one of the few that did well enough with those issues and overall for me to choose.  It has nice distinct code blocks and I can easily tell the difference between headers.  I'm not big on the colors or the header (though that's configurable).  It removed my tabs for pages, but that was no biggie.  A few other minor issues.  I may stick with it for my tenure at Wordpress.com.

<!--more-->

However, I'm considering moving my blog to my own site.  The only reason it has remained here is because Wordpress.com seems to drive traffic to it with its search functionality.  But I can't do my own styles, can't add plugins, I can't add adverts (which my freelance buddy [Jason](http://redgraffix.com) has suggested), I can't do a lot of things I could do with a full install.  So I may move, but I've got to clean up my site a bit before I do that.

A note on code blocks
---------------------

I've been using "``" blocks for my code, as that would be the semantically correct choice.  However, I've recently discovered the benefit of using "```
```" blocks with Wordpress:  Wordpress messes up the parsing of double line breaks in "code" blocks, putting in paragraphs, while in "pre"s, the white space is left alone and handle by the browser.  There may be some other issues as well.

So I've added a "pre" around my "code" block in the only place I've found where this was an issue.  "Pre"s do have a problem of having no line-wrap though, so long lines will stick out of code blocks and into areas that don't belong, or, like with this theme, under something so that they are invisible.  In this theme, you can't read or copy long lines by themselves in "pre"s, but they do copy fine with multiple lines.

In my own theme, I'd be able to style my own code blocks, and add a plugin such as [CodeKeeper](http://www.jmjtwin.co.cc/download-codekeeper-free-wordpress-code-block-plugin/comment-page-1/) (haven't tried it) that automatically escape character entities and appropriately handle line breaks.  Some such plugins even add line numbering and syntax highlighting.

Of course, I already have been converting less-than and greater-than symbols before pasting them into code blocks, and could potentially insert a bunch of "&lt;br /&gt;" tags in there in place of line breaks so that I can use "code" blocks with no worries of mangling by the Wordpress parser.
