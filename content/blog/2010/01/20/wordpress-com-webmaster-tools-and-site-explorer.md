---
categories: [www]
date: 2010-01-20T02:30:18+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=186'
id: 186
modified: 2010-01-20T02:30:18+00:00
name: wordpress-com-webmaster-tools-and-site-explorer
tags: [search, service, wordpress, wordpress-com]
---

Wordpress.com: Webmaster Tools and Site Explorer
================================================

I've been using Google's [Webmaster Tools](https://www.google.com/webmasters/tools/) and more recently Yahoo's [Site Explorer](https://siteexplorer.search.yahoo.com/) for my other sites.  They allow me to see crawl errors, keywords and some query ranking info, crawl statistics, and some other search engine related info as well as set some settings for how these engines handle my sites.

Because of the way these sites validate ownership of submitted sites (an uploaded file or a meta tag), I didn't think I'd be able to use them with Wordpress.com.  However, with a little searching, I found [this page](http://en.support.wordpress.com/webmaster-tools/), which says how to do it.  In fact, had I payed more attention when exploring the admin section of my account, I might have noticed that the capability is built into the "Tools" page.

You just submit the URL like for other sites, then choose to validate with the meta tag.  Copy the meta tag and paste it into a specified field in that "Tools" page.  "Save Changes" and then press the validate button on Google or Yahoo.

This worked instantly on Google.  For some reason, Yahoo is just saying "Failed".  Since it says it may take 24 hours to validate, I guess I'll have to wait.  You'd figure a message other than failed would be used to say that it hasn't been validated yet, but I've looked at the source of the page and verified the meta tag was there.

[Update 1/24/10] Finally Yahoo has validated by retrying.  I had done this a few times spaced out after the initial setup, but it had just failed.  I'm not sure why it finally worked. [update]
