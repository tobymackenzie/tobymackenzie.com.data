---
categories: [www]
date: 2017-07-23T01:08:41-05:00
date_gmt: 2017-07-23T06:08:41+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1548'
id: 1548
modified: 2017-08-05T01:19:09-05:00
modified_gmt: 2017-08-05T06:19:09+00:00
name: givecamp-2017-day-2
tags: [development, ecommerce, event, givecamp, web]
---

GiveCamp 2017 day 2
===================

Today was mostly focused on setting up a clone of the client's site, setting up ecommerce and a new theme on it, making the theme responsive, and fixing some issues with the styles and content.

<!--more-->

The client's current ecommerce site had some problems, so they wanted something better.  We went with [WooCommerce](https://woocommerce.com/) because it was recommended by others at GiveCamp.  When I installed it, it replaced the theme and the menu with its own.  I may have clicked something in its setup wizard, but nothing that stood out as implying it would do that.  It took us a little while to figure out what their old theme was and get back to where we were.

Those troubles and theme incompatibilities with WooCommerce led us to create the cloned site and the new theme.  A helper came in to do the clone.  We went with [Twenty Ten](https://wordpress.org/themes/twentyten/) for the theme because we felt a core theme would be likely to work well with WooCommerce and they liked it best of those options.

Twenty Ten wasn't responsive, so I had to add that in.  The main layout wasn't hard to get working decently.  The biggest trouble was with some of the content they had in widgets and the content of some pages not being set up well for becoming responsive, some of it even on the existing site which is generally responsive.  I mostly took the quickest fix, leaving in crappy markup and inline styles in a number of places and using `overflow:auto` for some content trapped in tables on too many pages to fix.

There also were a few content tweaks and moving things around, including on their existing site.  Some of those changes required tweaking the styles on both sites to accommodate.

I did some initial setup for WooCommerce and then the clients and project manager took over.  They have too many products to move from their existing site, which is the reason we will not be launching the new site this weekend.  They will have to launch it later, but their existing site still works.

We lost two of our three developers to other projects early on due to our good positioning on the project.  We had the helper for the cloning and a couple consultants come in for various things.

Also today: rain, photos, missed ice cream, nice sunset, fireworks, AC fixed.

We are well positioned for an easy day tomorrow.  I have nothing that really needs done, but can do some further tweaks to improve the appearance and markup.
