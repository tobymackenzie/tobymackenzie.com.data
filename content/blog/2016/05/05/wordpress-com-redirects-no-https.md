---
categories: [www]
date: 2016-05-05T23:27:01-05:00
date_gmt: 2016-05-06T04:27:01+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1133'
id: 1133
modified: 2016-05-06T00:28:52-05:00
modified_gmt: 2016-05-06T05:28:52+00:00
name: wordpress-com-redirects-no-https
pings: ['https://www.tobymackenzie.com/blog/2016/04/13/wordpress-rel-canonical-plugin/']
tags: [https, problem, redirect, service, wordpress-com]
---

Wordpress.com redirects don't support HTTPS
===========================================

Gah.  Apparently wordpress.com is discouraging 'https' for self-hosted blogs: Their [redirection service](https://en.support.wordpress.com/site-redirect/) does not allow any protocol but 'http'.  I could swear it did when I first set it up, as I remember typing in my URL with 'https' and I thought I tested it with `curl -I` to make sure it works, but the docs have an explicit note saying:

> Note: Site redirects will only point to a non-ssl ( http:// ) url.

I don't remember seeing it before, but [the wayback machine suggests it was there since 2013](https://web.archive.org/web/20130403211957/http://en.support.wordpress.com/site-redirect/), well before I switched to self-hosted.

<!--more-->

Many sites just redirect 'http' visitors to 'https', limiting the problem to an extra redirect (extra load time and server traffic).  But I do not, because I prefer to support older browsers that do may support modern or any 'https' protocols.  Thus, Google and other search engines are being sent to the 'http' versions of the pages and my "link juice" is going there.  I have [`rel="canonical"` links pointing to the 'https' site](https://www.tobymackenzie.com/blog/2016/04/13/wordpress-rel-canonical-plugin/), but I'm not sure that preserves the "link juice" in the same way.

So I'm paying $13 a year to have my visitors and search engines redirected to the non-canonical versions of my pages, all because wordpress.com can't be bothered to put a single 's' in the `Location` header of their redirect.  This certainly lowers the value proposition of the service.  Perhaps I should give up on supporting older browsers until search engines get their indexes right.  Or perhaps I should just live with the multi-protocol index.
