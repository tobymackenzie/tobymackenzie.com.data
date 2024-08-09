---
categories: [www]
date: 2023-04-12T01:26:13-04:00
date_gmt: 2023-04-12T05:26:13+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3999'
id: 3999
modified: 2023-04-12T01:26:13-04:00
modified_gmt: 2023-04-12T05:26:13+00:00
name: goodbye-dreamhost-hello-digital-ocean
tags: [digital-ocean, dreamcompute, dreamhost, host, problem, server, support, vps]
---

Goodbye Dreamhost, hello Digital Ocean
======================================

My server, and with it my blog, a client site, and other web properties, was down for four days.  I put in a support ticket and didn't get a response until the fourth day.  I've been with Dreamhost since 2009, and using DreamCompute since 2017, but I don't think the product gets nearly the focus that their shared / managed stuff does.  I use Digital Ocean at work, and it has been a much more polished and solid product for unmanaged VPS.  That is where my site is now hosted.

<!--more-->

Apparently, DreamCompute had some sort of glitch last Friday.  I found myself unable to SSH into my server when I wanted to.  My sites were down intermittently.  I wasn't sure what was going on, if a DDoS was happening or the server was hacked or what.  I decided to log into DreamCompute's admin panel and check it out.  Their dashboard doesn't provide much info.  I "paused" it to see if that would interrupt whatever was happening.  But when I went to unpause, it got stuck "Resuming", and stayed there for four days.

Pressing the "Unpause" button again just gave an error.  So did pretty much anything else I could try.  Over time, I tried just about everything, including detaching the volume (disk) to create a new VPS instance, even the risky move of deleting the instance, but got errors and couldn't get anything working.  One problem was that my volume was 40GB, and DreamCompute has a limit of 100GB per account (without paying more than double my VPS cost to increase it).  I couldn't detach the existing volume and couldn't directly clone it.  I could create a snapshot, but then to attach it to an instance, I had to create a volume from it, which brought me up to 120GB, causing an error.  So I was just stuck and couldn't do anything without support.

I put in a support ticket Friday and got no response.  I waited and waited while trying everything I could.  On Monday, I tried a follow-up support chat, but after a half hour of waiting with no response, I closed it and sent a ticket with info on what I had tried.  Finally, late afternoon Tuesday, I got a response mentioning the glitch on Friday, "a brief issue with the scheduling of DreamCompute tasks", and saying that he got it unpaused for me and verified it was available.  He said that my ticket was "sorted into a support queue that doesn't have that many support agents monitoring it", presumably based on the DreamCompute category I selected.  So I was finally able to get in and get data, but by that point I had already started to move away.

Four days is a long time for a site to be down.  Unable to do anything with Dreamhost, over the weekend I set up a Digital Ocean account to at least get my site up temporarily.  With [my Ansible based server code](https://github.com/tobymackenzie/tobymackenzie.srv) and local copies of the site code, I was able to get the server set up and part of my site running fairly quickly, with just a few updates to work properly with the new host.  Unfortunately, my backup system was missing some data (create tables for all database tables, some images, several days of data), so I just set my blog to throw a 503 error until I could get that sorted.

When my server came back up, I was able to update my backup script to get the rest of the data I was missing and copy it over.  I've copied the more important of my sites and will do the rest later.  I will decommission the old server once a client changes their DNS to the new server.

Dreamhost was my first hosting company back in 2009 and all I've used for my personal stuff since then (aside from a site I was still self-hosting for a while).  Their shared hosting was really good for what they offered for the price, with SSH, PHP, MySQL, "unlimited" subdomains and transfer and disk space, access to Apache logs, a control panel to manage things.  I also appreciated their dedication to free speech, the environment, and other shared mores.  And at the time they had a funny newsletter.

I started wanting more than shared could offer though, and after noticing [Apache logs showing the wrong status codes](/blog/2017/02/05/dreamhost-mod_rewrite-log-status-codes/), I decided to move over to their newish unmanaged VPS solution, DreamCompute.  It was cheaper than shared at the time and did what I wanted it to, keeping me on it for almost six years.

At the time, they were talking about it on their newsletter / blog and adding new features.  That tapered off, though, and it hasn't gotten much focus for years now.  The DreamCompute admin panel was very spartan and limited, which at the time seemed fine, but hasn't been noticeably improved, and is not nearly as nice or capable as Digital Ocean's.  There were two multi-day outages in the past with limited response from Dreamhost that almost got me to leave.  This third strike finally did it.  DreamCompute seems to be just a tiny, mostly ignored side-project for them, and it has many much more polished and featured competitors.

So, thanks Dreamhost for many good years, but it's time for me to move on.
