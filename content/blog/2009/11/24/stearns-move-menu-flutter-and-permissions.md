---
categories: [www]
comment_count: 2
date: 2009-11-24T11:09:58+00:00
date_gmt: 2009-11-24T11:09:58+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=106'
id: 395
modified: 2009-11-24T11:09:58+00:00
modified_gmt: 2009-11-24T11:09:58+00:00
name: stearns-move-menu-flutter-and-permissions
tags: [cms, design, flutter, permissions, plugins, stearns, webiiclass, wordpress]
---

Stearns: Move, Menu, Flutter and Permissions
============================================

The Move
--------

We finally bought the domain name and hosting account for Stearns, at [stearnshomestead.com](http://stearnshomestead.com).  We were expecting them to want a .org due to their nonprofit status, but I guess they wanted the familiarity of the .com.  They have no company credit card, so Angela had to set up the account and will bill them for a check.  I don't know what they'll do in the future:  They'll probably have to have one of their members do a similar thing.

We moved our Wordpress install from its temporary location in a subfolder of one of Angela's sites to the root of the new site.  There was perhaps a bit of trouble moving the site, but once we figured it out, the install worked perfectly.  To move, we transferred from one site to the other via FTP all site files.  We then used PHPMyAdmin to export the site data as SQL and then import it to the new site (didn't have to use PHPMyAdmin for the new site, as the host has an import function in their control panel).  We then had to update the config file for Wordpress to reference the new database.  Finally, we had to change two URLs in the options table in the database.  Everything now works.

<!--more-->
The Menu and IE
---------------

We borrowed our suckerfish type dropdown menu system from another project Angela had done.  She had put a lot of time into it to make it work with IE6.  Some other class member took that and combined it with our site style to make it work for the new site.  It worked great in non-IE browsers, but unfortunately both IE6 and IE7 had problems with it that made it unusable.

I spent a good bit of time making it work in IE7 and in IE6.  Unfortunately, in IE6, it then expanded the whole menu bar when expanding a submenu and moved the content down to compensate.  I also discovered that, because I had made the whole header height large enough to fit the submenu items, in non-IE browsers links in the regular content within that height weren't clickable.  I had expanded the height because both IE6 and IE7 had a problem where the hover state stopped at the bottom of the header height rather than the bottom of the submenu, making the submenu unusable.

Me and another guy in class messed with it to get it working.  They had gone to floats instead of the absolute positioning that Angela had used, but this messed up IE6.  Reverting to the positinioning plus a little IE6&5 specific javascript (which sets "display:none" in addition to "visibility:invisible" that is used by other browsers) made it work fine in both those browsers.  It was back to the unusable submenus in IE7 though, so we made another javascript section specific to that browser, expanding the height of the header on mouseover and moving it back on mouseout.  We also had to "move" the content below this to its original position so it didn't jump to the bottom of the header height.

Now it works wonderfully in IE 5, 6, 7, & 8, Safari, Chrome, and Firefox.  It is all javascript now, but it could potentially work CSS only in non-IE 7 or less browsers with a single line of CSS.  I may toss that in there and make sure it doesn't bugger anything up, just in case a non-javascript person visits.

Content
-------

Content is one of the bigger items we still have to work on.  Some of our team has been pulling stuff from the brochure and other handouts they gave us and putting it into the appropriate page on the site.  Unfortunately, there isn't a lot of content on those items, so we are going to need more from the people at Stearns.  Hopefully we don't end up getting it and having to put it in all at the last minute.  That wouldn't be hard to accommodate except that the quantity might affect whether we split things into multiple pages or what not.

Rocki has been getting a lot of recipes together for our recipe section.  We still have to work on the functionality of that, but it will probably be the most content filled section, unless they make a lot of news items over time.

Flutter and Permissions
-----------------------

There is a bit of trouble with the whole Flutter thing.  One trouble is that items added in the regular post panel don't appear in the appropriate Flutter panel.  This will need to be fixed or we'll have to do something else.  Hopefully, if there is no normal way of adding the items to the panel, I will look at how the inclusion is determined in the database and run a query to include all appropriate items.

We are also wanting to eliminate their ability to use the standard post panel, only letting them use the Flutter panels.  This way, all related items will be grouped and they won't be able to put in items without the appropriate meta data.  I remember at least one plugin touting an ability to remove the Posts or Pages write panels by user group.  That would be great if it will still allow the Flutter panels to work.  I also have to find which plugin that was and get it to work.

And we wanted to give them limited permission for working with pages.  [Role Scoper](http://agapetry.net/news/introducing-role-scoper/) seems to be the standard plugin for adding more permissions capabilities.  It has a lot of feature, and can add new groups, do user and group specific permissions on a per page, per post, and per category basis, and other such nifty things.  It is also somewhat confusing as well though, and I'm not sure how to get it to do what we want.  One especially hard thing will be to allow them to add new users, but only with certain selectable group options.  The pages, since they can't be categorized, may also pose a difficulty for dealing with en masse.  And I don't think I've found a way to prevent deleting.

I've tried to find a way to remove the HTML tab from the editing interface, so they can't mess up the layout too much, but have had no luck.  [TinyMCE Advanced](http://wordpress.org/extend/plugins/tinymce-advanced/) didn't seem to have this option.  Nor did [Tiny MCE Options Override](http://wordpress.org/extend/plugins/tinymce-options-override/), a plugin that allows customizing the interface per group.  Maybe they'll be fine with the HTML abilities anyways.

Hopefully with a bit of research, we'll be able to make  it easy for them to update while making it hard for them to mess things up.
