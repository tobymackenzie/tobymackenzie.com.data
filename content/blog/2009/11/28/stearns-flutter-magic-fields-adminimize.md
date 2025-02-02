---
categories: [www]
comment_count: 9
date: 2009-11-28T00:59:21+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=111'
id: 396
modified: 2009-11-28T00:59:21+00:00
name: stearns-flutter-magic-fields-adminimize
tags: [admin, cms, flutter, magicfields, plugins, stearns, webiiclass, wordpress]
---

Stearns: Flutter now Magic Fields, Adminimize
=============================================

Flutter/Magic Fields
--------------------

[Magic Fields](http://magicfields.org/) is a fork of Flutter that is open source GPL and seems to have more active development going on.  It also seems to be much more streamlined and simplified.  It doesn't have all of the features of Flutter, but I didn't know what those features were anyway and wasn't using them.  I switched to it for these reasons and in hopes that it would fix a problem I'm having.

The problem is that posts created outside of the Flutter write panels do not appear inside of that panels "Manage" pane, nor do posts on write panels that have no custom fields.  Two of the panels had no custom fields, and some items were not added with the write panel at all, so the "manage" panels were not working for us.  I discovered that Flutter associates its custom fields with posts in a particular table, and the "manage" pane only shows items in that table.

Moving to Magic Fields, I thought it might fix this.  They provide a script to move all panels and items from Flutter, which made that easy.  Unfortunately, the plugin still uses the same method of populating the "manage" panes, and so didn't fix my problem at all.

I really just want that pane to have all items from the related category, whether they have populated custom fields or not, whether they were added through the write panel or the posts panel.  I may have to modify the plugin to make this happen.  Otherwise, I will have to somehow craft a script to find unassociated items from a given category, insert a custom field with the relevant name for that type, and then insert the cross-reference row.  That would be a complicated affair and would do nothing for new items created after the script is run.  But I am worried that not having an associated field set in the database will cause problems when those items are displayed.  We'll see what I can manage and have time for.

Adminimize
----------

[This plugin](http://wordpress.org/extend/plugins/adminimize/) was recommended by Kevin Behrens, maker of Role Scoper.  It allows removal of panels and individual items from the admin section based on role/group.  So far, I only have used it to remove the "Add New" pane of the posts section, but I think it will allow me to remove the HTML tab from TinyMCE as well as a few other things to clean up the interface for the Stearns folk.  The easier we make it for them, the better.
