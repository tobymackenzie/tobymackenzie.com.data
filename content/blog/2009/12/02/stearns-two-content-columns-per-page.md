---
categories: [www]
comment_count: 2
date: 2009-12-02T07:46:25+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=114'
id: 397
modified: 2009-12-02T07:46:25+00:00
name: stearns-two-content-columns-per-page
tags: [admin, cms, layout, magicfields, stearns, webiiclass, wordpress]
---

Stearns: Two Content Columns Per Page
=====================================

Our layout has some pages with a three column layout and some pages with only two columns.  The left column is always the same, but the other two will have one or two columns based on individual page content.  For a while, we've had the third column on the home page and an empty third column on other pages, but we ran into troubles when we wanted to add the third column content to the other pages.

The columns use float to get their positioning and can't be inside each other or the text from one would flow under the other.  A few options came to mind.  We tried closing template divs and opening others in the HTML editor of the page content: this did not work for us, somehow removing the background that was supplied by a wrapper.  It would be trouble for Stearns anyway.  We also tried removing the container for the center column from the template and putting one div into two column pages, two into three column pages.  This gave some difficulties with the editor, would require the divs on every page, and would be difficult for Stearns and us to work with.

<!--more-->

The CMS-like strategy would be to have a separate field for the right column and output the correct structure in the template.  Unfortunately, only tiny editing boxes are provided for custom fields, and they don't handle shortcodes (for images and galleries, etc) and don't allow the TinyMCE editor for handling HTML or adding images.  So we made use of the already installed Magic Fields plugin.  It allows a multi-line text field for a custom write panel, complete with TinyMCE.  It doesn't have the image adding button though unless you go to fullscreen mode, but that is a minor setback.

With MagicFields, all of our already created pages (that is pretty much all pages for the site) do not have the field or show up in the pane.  Rather than go through running the special script like I used for the [same problem with posts](https://tobymackenzie.com/blog/2009/11/28/stearns-flutter-magic-fields-adminimize/), I enabled the "Prompt when editing a Post not created with Custom Write Panel" option in Magic Fields' preferences.  When we open pages without a right column, a pre-open page asks us if we want to assign it to a write panel or not:  We can change them over as we go.

The other problem, once we got CSS set up to handle a wider column, was to get the page template to output a right column only if the page has content for it, and to set an appropriate class on the middle column to set an appropriate width.  It took me a while to get it working correctly.  I was attempting to figure out how to determine if the custom field was empty with Magic Fields' get() function for a while, but couldn't get that to work.  Instead, I used the [get\_post\_meta()](http://codex.wordpress.org/Function_Reference/get_post_meta) function of Wordpress to pull the raw field content into a variable:

```
$variable = trim(get_post_meta(get_the_ID(), 'fieldName', true));
```

then used that in if statements to both set the proper class on the middle column and to display the right column if necessary, ie:

```
if(!empty($variable)) displayRightColumn();
```

Works just fine.  I don't like being dependent on the plugin for every page, but at this point, we are fairly well dependent for all posts anyway, so there's probably no turning back now.
