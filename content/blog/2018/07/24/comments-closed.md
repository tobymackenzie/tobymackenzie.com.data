---
categories: [www]
comment_count: 2
date: 2018-07-24T00:50:46-05:00
date_gmt: 2018-07-24T05:50:46+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1967'
id: 1967
modified: 2018-08-07T21:12:18-05:00
modified_gmt: 2018-08-08T02:12:18+00:00
name: comments-closed
pings: ['https://indieweb.org/webmention', 'https://www.tobymackenzie.com/blog/2018/08/07/1993/']
tags: [blog, comment, communication, indieweb, site, web]
---

Comments closed
===============

I have decided to disable comments on my blog, but leave pingbacks / trackbacks enabled.<!--more-->  I haven't gotten any legitimate looking comments in years, but plenty of spam.  I'd rather eliminate that problem and promote the [IndieWeb](https://indieweb.org/) idea of responses and back and forth happening between individual websites rather than posting directly to someone else's site.

I unchecked "Allow people to post comments on new articles" in the discussion settings, leaving "Allow link notifications from other blogs (pingbacks and trackbacks) on new articles" checked.  Wordpress handles the actual setting on a per post basis, so this will only affect new posts.

I also checked "Automatically close comments on articles older than 1 days"<ins>, but it closed pingbacks, so I instead [set the `comment_status` to closed](https://www.tobymackenzie.com/blog/2018/08/07/1993/) in the database</ins>.  <del>I'm hoping this doesn't also close pingbacks.  It doesn't set them to closed in the database, so it must perform a time comparison on each load.  I may instead just set them all to closed at some point with a database query and then turn off the time check to simplify things.</del>

Turning off comments may allow me to disable Akismet.  Pingbacks / trackbacks can get spam too, but I don't think I've had that for a long time.  If I do get spam, I have it set to require moderation anyway.

At some point, I'd like to implement [webmentions](https://indieweb.org/webmention), but for now I'll have to live with the pingback / trackback system.
