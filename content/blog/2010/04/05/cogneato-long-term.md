---
categories: [www]
date: 2010-04-05T02:52:32+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=294'
id: 425
modified: 2010-04-05T02:52:32+00:00
name: cogneato-long-term
tags: [cogneato, job, web]
---

Cogneato: Long Term?
====================

Well, it seems like [my job at Cogneato](https://tobymackenzie.com/blog/2010/03/13/cogneato-a-new-job/) is likely to end up long term.  Cogneato seems to be doing rather well this year, so Ron the owner thinks he will be able to keep me on long term.  He is setting me up as the front end developer, as he finds me to be fast at the task.  I take designs he's done in Fireworks, slice them up, and convert them into HTML and CSS.  I've done quite a few now, plus a few other things such as some set up on the CMS that will drive a couple of the sites.

I get to do the sites in modern HTML and CSS.  I've only used a few tables for layout purposes (stuff I couldn't figure out how to do cross browser without them), get to use PNG's for transparency, and have been using the HTML 5 doctype.  So far, every site has been at least somewhat different than the others, and most of them have required me to figure out something new.  Some of the designs are fairly fancy.  I find myself using a lot of extra divs/spans for appearance purposes only.  It has been quite enjoyable.  I test sites in Safari and Firefox (the newest versions) plus IE 6, 7, and 8.  IE always gives me troubles.  For IE 6 I am able to give them a simpler styled site, I just have to make sure it works, so I usually hide PNG's and some other hard to deal-with elements.  IE 7 usually isn't too bad, and IE 8 usually works or mostly works with no special effort.

One site gave me a lot of trouble:  DG Bar Ranch.  It had a lot of the difficult things going on at once:  drop shadows, gradients, boxes with variable height and width, a changeable part of the background image, z-index issues, all sorts of things.  I took longer on that site than probably most of the others combined.  The drop down menu's caused me a fair amount of difficulty.  I also had issues making the body background, composed of three separate repeating images, repeat properly while staying where they were supposed to.  I couldn't get the "position: absolute" to expand to the width of the body in all instances, but rather the width of the viewport, so I used "position: fixed" for one of them.  I then, for IE 7, had to create two special divs to allow a background gradient fixed to the bottom to slide over a background image.  The site isn't up yet, but I can link to it when it's up.

Anyway, I like the job and am glad it seems I will be staying on long term.  I will try to post on some of the techniques I've learned along the way.
