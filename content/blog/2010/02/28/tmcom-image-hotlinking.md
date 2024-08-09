---
categories: [www]
date: 2010-02-28T11:31:16+00:00
date_gmt: 2010-02-28T11:31:16+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=273'
id: 422
modified: 2024-06-25T15:26:45-04:00
modified_gmt: 2024-06-25T19:26:45+00:00
name: tmcom-image-hotlinking
tags: [hotlinking, htaccess, mod_rewrite]
---

TMCom: Image Hotlinking
=======================

I've had a site pulling one particular image from my site.  It gives no referrer and the user agent "Mozilla/4.0 (compatible; MSIE 6.0)".  It has the IP 76.73.76.130.  I wasn't sure what it was at first, and figured it might just go away.  But it hasn't and is asking for the image a few times a day, 93718 bytes each request.  Not a huge bandwidth pull, but annoying.

The image is a picture of an album cover for a site that I had built for the band I was once in, [The Yars](http://myspace.com/yarsband/).  The site is being "syndicated" on my site for portfolio purposes. <!--http://tobymackenzie.com/portfolio/siteRepository/yars/-->

I finally tracked down the site that is pulling the image: mpcodex.com (multiple sites are hosted from that IP).  I'm not totally sure what the site is about, but it really had nothing related to the yars, other than that an empty image box (can't see it, but it still seems to pull from my server) and the phrase "Yars CD Release" will show up with a search for "Yars".  Clicking on the image goes to mp3logy.net, which pulls the image from my site as well, but sends the IP and other info from the visitor, not the host.

This doesn't seem that important to me, so I decided to prevent mpcodex from pulling the image.  I know that I could do [something more advanced](http://wiki.dreamhost.com/Preventing_hotlinking) to prevent hotlinking in general, but that hasn't been a problem yet and I don't want to worry about missing image search engines.  I'm just blocking that IP from that particular image using my .htaccess file with mod_rewrite:

```
# block mp3codex.com
RewriteCond %{REMOTE_ADDR} 76.73.76.130
RewriteRule ^portfolio/siteRepository/yars/images/general/2.jpg$ - [F]
```

This took me much longer to set up than it should have, partly because my test server (my iBook) and my production server seemed to be handling things differently.  I could have just used a "Deny" rule to block the IP altogether, and probably would be fine since it's undoubtedly just a web host that would not have human visitors anyway, but I'd rather be safe for now.

I'll watch this to make sure it actually works and that I don't have any more problems.  If I do, I'll figure out what to do then.
