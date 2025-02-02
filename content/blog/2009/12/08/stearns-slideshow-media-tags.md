---
categories: [www]
comment_count: 2
date: 2009-12-08T09:58:55+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=121'
id: 398
modified: 2009-12-08T09:58:55+00:00
name: stearns-slideshow-media-tags
tags: [images, media, plugins, stearns, webiiclass, wordpress]
---

Stearns: Slideshow, Media Tags
==============================

We wanted an image slideshow for our sidebar.  I looked at some of the plugins available for doing this, but none looked to be exactly what we wanted, nor did they look very simple.  I've worked with jQuery before with various image things, so I used it to build my own slideshow (building it in OO added to the development time, but it should be fairly versatile now).  Then I had to get the appropriate images from Wordpress to work with my javascript, which was quite a bit of work as well.

We want the images to easily be updatable by Stearns.  I don't know why I was dead-set on having them be able to use the media library, but I was.  They could FTP files into a folder, which would be much easier for me.  But they might not even know how to do this, and letting them handle everything through the wordpress interface is preferable.  They'd have to crop and size them properly.  The images in the folder also wouldn't have captions.  So I pressed on.

I thought perhaps I could have them update a gallery on a particular page, after having thought the gallery function wass very neat.  But it seems there is no way to add items from the media library to a gallery for a page (not in regular wordpress anyway) and I'm not sure that the "delete" link does what I want for removing items from the gallery (and I'm not willing to try).

<!--more-->

I also thought of tagging items somehow for the slideshow.  The media library by default provides no fields that aren't output into the display HTML, so there is no way by default to tag items.  That's where a plugin came in: [Media Tags](http://wordpress.org/extend/plugins/media-tags/).  It just adds a tag field for media items.  It allows multiple, though not as elegantly as the regular posts tags, and it also has functions for working with the metadata in both templates and posts.

Media Tags is not that well documented in some respects.  You use: ```
get_attachments_by_media_tags('media_tags=slideshow')
```
to get items with the tag "slideshow".  They are output as an array, and it took me a while to figure out how to work with this array.  Luckily, print_r() helped me find what data was being pulled.  This is a list of all items in the array with a few comments:

- ID
- post\_author (id)
- post\_date (like 2009-12-02 16:08:08)
- post\_date\_gmt
- post\_content
- post\_title
- post\_excerpt
- post\_status
- comment\_status
- ping\_status
- post\_password
- post\_name
- to\_ping
- pinged
- post\_modified
- post\_modified\_gmt
- post\_content\_filtered
- post\_parent
- guid (contains url to full-size image)
- post\_type (always "attachment")
- post\_mime\_type
- comment\_count

The list is a bit long, but it may be helpful to some using the plugin.  So, I was now able to tag some of the images and output them into my sidebar.  My javascript uses an array of the images, popping in the next and removing the old, so I had to pass the list into an array in script tags.  I also displayed the first image just with PHP/HTML in case non-javascript users view the site.

Another trouble was with the image sizes.  The URL from the array used above is to the full size image only, which is too big for our sidebar.  They also can be variable size, which I found can be a problem for the way my javascript works.  Just figuring out how to get the URL to the thumbnail took me awhile.  I used:

```
$forURLArray = wp_get_attachment_image_src($itemID 'thumbnail')
```

to grab an array containing the URL, and then:

```
$forURLArray[0]
```

to access the URL.  This gave me the added benefit of a width in position 1 and a height in position 2, which I had originally foregone with them not existing in the Media Tags array.

The thumbnails are unfortunately too small for the sidebar.  In my Wordpress.com blog (this one), it seems that appending "?w=200" produces a 200 pixel wide image dynamically (presumably).  This does not work at all with a regular Wordpress install.  I looked all over for information on this feature, but couldn't find it.  I even tried to find what plugins, Wordpress.com uses, so I might find one that does that and install it on Stearns, but evidently Wordpress.com doesn't use plugins at all, and those features are built in (to all MU installs, I wonder?).

So no resize luck.  There is TimThumb, a php resize script, but that would be yet another thing to install and figure out.  We could consider upping the size of the "thumbnail" images or reducing the "medium" images, as I'm not sure those are even used currently elsewhere, but I'm also not sure if Wordpress will update these for all media or what.  If it doesn't, then it won't help us really, unless there is a way to force it to do this update.

Anyway, I haven't talked this over with the rest of the group, so I will see what they think.  They may be fine with no captions and FTP for Stearns
