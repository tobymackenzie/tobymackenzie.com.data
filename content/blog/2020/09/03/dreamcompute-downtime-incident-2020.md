---
categories: [www]
date: 2020-09-03T02:10:06-04:00
date_gmt: 2020-09-03T06:10:06+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3020'
id: 3020
modified: 2020-09-03T02:12:13-04:00
modified_gmt: 2020-09-03T06:12:13+00:00
name: dreamcompute-downtime-incident-2020
tags: [dreamcompute, dreamhost, host, problem, server, site, vps]
---

DreamCompute downtime incident 2020
===================================

There was another DreamCompute incident leading to downtime of my site / server.<!--more-->  Not nearly as bad as [the incident last year](/blog/2019/04/05/dreamcompute-disruption-incident/), but still, my site was affected for what was likely a few hours.  It was intermittently down entirely, and then for a while DNS requests from the server weren't working, breaking OSCP stapling among other things.

I first noticed it being down around 2130.  I was trying to visit my site, probably just to check out visitor stats, but it wouldn't load.  I tried another domain, then tried to SSH, but no luck.

I checked [Dreamhost Status](https://www.dreamhoststatus.com/), which said some maintenance was going on.  I looked on twitter and saw a post saying [maintenance was taking longer than expected](https://twitter.com/dhstatus/status/1301326609958359040).  I hadn't known there was going to be maintenance in the first place, but since this was similar to last years incident, I figured the maintenance was the cause of my problems.

I checked the server in the DreamCompute admin panel, but it didn't show anything wrong.  I tried to connect both to the web server and via SSH off and on until I finally made it through after 10-20 minutes.

I started checking out the state of the server.  The uptime was longer than the incident, so it hadn't been restarted.  Things largely seemed fine.  I saw some gaps in the access logs, and though gaps aren't unusual for my low traffic site, there was a 40 minute gap around the incident time-frame.

A few minutes into investigation, the SSH connection broke, as did web access, and they kept going in and out.  I also noticed that I wasn't able to visit in my main browser even when I could SSH and `curl`.  After looking at the site error logs and attempting some pings and `curl` from the server, I realized that there was a DNS problem and OSCP stapling was failing.  My quick and dirty solution was to disable it.  I was able to connect over HTTPS in other browsers, but my main browser still was failing.  It must've cached something about the failed requests.

During this time, I noticed [a tweet acknowledging the incident](https://twitter.com/dhstatus/status/1301343042213801984) by saying they were "investigating an issue resulting in degraded performance on specific customer DreamCompute instances."  Not much info, much like last time.

After testing `ping` and `curl` occasionally from the server for a while and getting failures to resolve, and still occasionally losing connection to the server, I decided to just give up for the moment, as there was nothing I could do, and go do some other things.  When I came back around 0100, it was finally back to normal, other than an occasional hiccup in connection.  I re-enabled OSCP stapling, and it was good.  But, that was not really something I wanted to deal with tonight.
