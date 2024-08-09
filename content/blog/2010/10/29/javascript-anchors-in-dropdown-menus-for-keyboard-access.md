---
categories: [www]
date: 2010-10-29T22:54:36+00:00
date_gmt: 2010-10-29T22:54:36+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=412'
id: 442
modified: 2010-10-29T22:54:36+00:00
modified_gmt: 2010-10-29T22:54:36+00:00
name: javascript-anchors-in-dropdown-menus-for-keyboard-access
tags: [accessibility, javascript, menu]
---

Javascript: Anchors in Dropdown Menus for Keyboard Access
=========================================================

My boss at work doesn't like the top-level items that have submenus in our two-level menus to be links.  In most of the sites we build, there is really no page for the top-level items to link to.  Having a duplicated link to the first item or just a worthless value could be confusing, especially for both bots and screenreaders.  But with no anchors, the submenus are inaccessible via the keyboard, as browsers generally only provide keyboard navigation to anchors, inputs, and buttons.  As I prefer to keep my hands on the keyboard most of the time, I was disappointed with this characteristic of the menu system I built.

While building a vertical menu where the submenu drops down directly below the top-level items, I realized a solution to this issue.  Anchors with no "href" attribute are fully valid, but they are interpreted much like spans and don't receive keyboard focus or perform any actions on activation (barring event handlers of course).  To a non-javascript agent, they are basically the same as the spans I would normally wrap around my top-level items.  But for javascript users, I can simply add an href attribute to turn them into keyboard accessible items that can then activate the submenus.  I use a worthless but descriptive value to tell users what the items do if they read their status bar.  I prevent the default action anyway, but I still use a javascript qualifier to be sure and to describe the action, so the href looks like: "javascript://openMenu();".  This would do nothing if somehow the onclick event handler were not run.  Like a good little javascripter, I attach event listeners programatically, of course.  With [jQuery](http://jquery.com/), this would look something like:

```
elmsMenus.find("."+classTopitem).attr("href","javascript://openmenu();");
```

When I have time, I will have to update the horizontal menu that we use on many sites.  In my vertical menu, I shall not that non-javascript users can still access the menus, because the default CSS displays them as opened.  This is not the case for my horizontal menu script.  I have yet to find a solution for this that will fit my bosses desires.
