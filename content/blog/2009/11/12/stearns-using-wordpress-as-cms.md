---
categories: [www]
date: 2009-11-12T09:54:32+00:00
date_gmt: 2009-11-12T09:54:32+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=92'
id: 391
modified: 2009-11-12T09:54:32+00:00
modified_gmt: 2009-11-12T09:54:32+00:00
name: stearns-using-wordpress-as-cms
tags: [cms, plugins, research, stearns, webiiclass, wordpress]
---

Stearns: Using Wordpress as CMS
===============================

I mentioned my concerns of using Wordpress as a CMS in a [previous post](https://tobymackenzie.com/blog/2009/09/30/wordpress-as-cms/), but now it is getting to be the time to find solutions to our problems.  We have installed a test wordpress site and have begun working on it.  The style is still bare, but I am looking at functionality issues.  I used those links from the previous post plus some other sites found on Google to find potential solutions.  I haven't made any final decisions yet on what should work for us, but I'll document some of my considerations

Events and Recipes
------------------

One issue we will have is needing custom data fields for the events and the recipes.  Wordpress has [custom fields built in](http://codex.wordpress.org/Using_Custom_Fields), but it would be best if the fields could be there automatically, without them having to add them and get the names exactly right each time.

[Flutter](http://flutter.freshout.us/) is one plugin solution that looks nice.  It allows custom write panels to be created in the admin section, so that events or recipes could be managed and added separately from the normal posts.  It allows custom fields to be defined for each panel as well.  It even allows data types to be defined, so dates for the events could be entered easily.  It does have some issues, such as some bugginess and rumored slowness when post numbers get high.  This did sell me on the custom write panel idea though.
<!--more-->

A similar plugin is [More Fields](http://labs.dagensskiva.com/plugins/more-fields/).  It is a lot simpler than Flutter, but when I installed it, it had some sort of error adding a field, so I uninstalled it. [This plugin](http://wordpress.org/extend/plugins/custom-field-template/) allows custom fields and has some neat functionality, but they apply to all posts.

The [Wordpress Filters](http://wordpress.org/extend/plugins/wordpress-filter/) plugin seems to allow for validation of custom fields, which would be helpful for the dates.  I don't know if we'll need this or not.

There is also [Pod CMS](http://pods.uproot.us/).  This looks very powerful, has great reviews, and seems well updated, unlike those other plugins.  It allows very custom data types by storing its data separately from Wordpresses.  I'm a little concerned about that, as I'm not sure if it will be searchable with other content and I'm not sure if I want to become so dependent on the plugin.  If we remove the plugin, those items will not be posts and will effectively not exist.  I'll have to do more research.  I will have to read more and experiment with this.  I could see it being useful for myself or other projects for sure.

There is also the possibility of writing my own.  Wordpress allows admin panels to be added by using the functions.php file in the theme folder.  [This guy](http://wefunction.com/2009/10/revisited-creating-custom-write-panels-in-wordpress/) gives a good description of how to do it.  It will take some time for sure, but hopefully not terribly long.  I'd have to do it separately for each panel too.  But this would allow complete control over the panels and would hopefully eliminate the potential for bugs.  I will probably give it a try even if it will not be used for the site:  The knowledge could be very useful if I continue to use Wordpress for CMS purposes.

Event Sorting
-------------

Another important issue is that we will need to be able to sort the events by a custom field, date.  We will need to be able to show upcoming events on the homepage and an events page.  [This guy](http://www.bumpershine.com/2009/02/17/the-upcoming-event-calendar-a-meta-data-driven-wordpress-event-calendar-for-bloggers.html) already did something similar for band events and provides good info.  He uses the Flutter for his data and the Wordpress [query\_posts](http://codex.wordpress.org/Template_Tags/query_posts) function to sort.  Unfortunately, that function only works for "The Loop", which means only one set of posts can be gotten with it.  Our homepage will have multiple.  So the much more complicated [wp\_query object](http://codex.wordpress.org/Function_Reference/WP_Query) will need to be used.  I don't think there's a way around that.  I've not used it before, so I'll need to do some reading and experimentation.  Sorting shouldn't be hard this way though.

Admin Section Permissions and Limits
------------------------------------

We would like our clients to be able to edit some of the information on pages, but not be able to totally muck things up.  Wordpress has built in [role functionality](http://codex.wordpress.org/Roles_and_Capabilities) that we will use to limit their access, but we want more limiting capabilities.  The [Role Scoper](http://agapetry.net/news/introducing-role-scoper/) plugin looks like it should be great for that.  I haven't looked too in depth into it.  It's well touted and seems to have lots of features, including per group limits and per page limits, which we want.

We would like to remove the HTML tab from the TinyMCE editor so that they can't muck things up too bad on the pages they can edit.  I couldn't find too much information on a definitive way to do it.  The [TinyMCE Advanced](http://wordpress.org/extend/plugins/tinymce-advanced/) plugin adds many more button possibilities and customizability to the editor, so it may allow the tab to be removed.  There is also the [WP-CMS Post Control](http://wordpress.org/extend/plugins/wp-cms-post-control/) plugin, which touts complete control over the write panel.  This may have the desired ability.

Another admin section plugin that would be nice is the [Dashboard Editor](http://wordpress.org/extend/plugins/wordpress-dashboard-editor/screenshots/), if only it were up to date.  It allows parts of the dashboard to be removed so we don't have the excess junk showing for them that they won't use.  There are some other similar plugins, but I can't find one new enough.

Search Control
--------------

We will probably want a site search on our front page.  By default, Wordpress only searches posts with its search box, but the [Search Everything](http://wordpress.org/extend/plugins/search-everything/) plugin expands the search to include pages, and allows control over what exactly is searched.

I only think the above plugin applies to the standard search widget, though. We also will need a recipe search box, and possibly an events search as well.  I don't know much about Wordpress's search boxes, but if there is just one basic search functionality, we may need something to allow for our other search boxes to work.  There is the [WP Custom Fields Search](http://wordpress.org/extend/plugins/wp-custom-fields-search/) plugin, that allows custom search forms to be built.  It allows multiple fields per form, but I'm not sure if it allows multiple forms overall.  We don't need the multiple fields at all.  The plugin probably won't be used, but is worth keeping in mind.

Others
------

I noticed a previous class used [cForms](http://www.deliciousdays.com/cforms-plugin/), another plugin, to handle a form on the [cuyahoga dogs](http://cuyahogadogs.com) site.  We had no plans for a contact form that I know of, but we did discuss the possibility of having some of their forms on the website, and web submission would be nice.  I don't know if the plugin can capture the form data into the database or if it sends out emails.

Also, since our theme will be using drop down menus, we've been looking for a good option.  Nadia found [this option](http://www.tjkdesign.com/articles/keyboard_friendly_dropdown_menu/default.asp), which boasts CSS only support in modern browsers and IE5/6 support with a bit of javascript.  There is also [this](http://www.lostincleveland.com/gwsite/) that I believe our instructor had done at one point, which boasts similar support except for maybe not IE5.  Nadia and Dan were the ones checking these out, so I don't know what issues they had, but I think they were having some kind of trouble with them.  I noticed the [Multi-Level Navigation](http://pixopoint.com/products/multi-level-navigation/) plugin is supposed to offer similar support and advanced abilities, but would be able to be built right in the admin section.  The other ones would be hard coded, so they wouldn't change if, for some reason, the pages were renamed or deleted.

Conclusion
----------

Sorry for the long, long post, but I think this will serve as a useful reference for me as I do further research on how to accomplish what we need or would like for this site.
