---
categories: [www]
date: 2019-04-05T02:13:03-04:00
date_gmt: 2019-04-05T06:13:03+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2290'
id: 2290
modified: 2019-04-05T02:13:03-04:00
modified_gmt: 2019-04-05T06:13:03+00:00
name: dreamcompute-disruption-incident
tags: [customer, dreamcompute, dreamhost, host, problem, server, site, support, vps]
---

DreamCompute disruption incident
================================

My server and site were down for about 16 hours from Tuesday evening (≈18:08) to Wednesday morning (≈10:36).  This was due to a significant problem that occurred due to [an upgrade to the Ceph system running Dreamcompute](https://mobile.twitter.com/dhstatus/status/1113104151934722048).  Numerous people were affected, based on Twitter posts, and we still have little information about what happened.

<!--more-->

Discovery
---------

I was completely unaware of the planned upgrade.  Tuesday evening, I attempted to upload a file to my server before leaving work.  It failed.  I `ssh`ed in to see what was going on, only to have every command return nothing more than an I/O error.  Loading my site, the home page worked fine (PHP, Symfony, and filesystem only), but my blog pages returned 404 errors (WordPress with database access).

When I got home, I `ssh`ed in, to the same affect.  At first I thought maybe a recent site deployment somehow went terribly wrong.  Then I wondered if I got hacked and the hacker threw in something to prevent my CLI use.  I attempted to reboot, but via CLI, but don't think that did anything.  I logged into Dreamhost's panel, but didn't see anything unusual.  I logged into the DreamCompute panel.  Also nothing unusual.

Down
----

I hard rebooted from the DreamCompute panel.  The server came back up according to the panel, but the console there just had a bunch of errors.  I could no longer ping the server, `ssh`, anything.  I rebooted again and tried hard stopping and starting, to no avail.

I then looked at Dreamhost's Twitter and [Dreamhost Status](https://www.dreamhoststatus.com/), and saw messages about the upgrade and what they described as "degraded performance" and "connectivity issues".  I saw others complaining of down sites.

I put in a ticket mentioning that my server was down, probably related to the issue mentioned on Dreamhost Status.  I then left it at that and moved on to the plans I had made for the evening.

As bed time approached, I had not received a response to my ticket, and very little information was available from Dreamhost Status or Twitter.  I tried rebooting again.  I [tweeted about the issue](https://mobile.twitter.com/macybot/status/1113316733417414656).  I looked at some other VPS options, but wasn't feeling like tackling all that when it was already bed time.  I didn't sleep well thinking about it, but eventually fell asleep.

Up
--

When I awoke in the morning, the site was still down and there still was no response to my ticket, but there was a [tweet about a fix being pushed](https://mobile.twitter.com/dhstatus/status/1113441870137438209) and a similar message on Dreamhost Status.  As I ate breakfast, I tried a soft reboot from the panel.  This time, when it came up, I was able to ping and `ssh`.

The web and database server wouldn't come up, and I soon discovered it was because the file system was mounted read only.  Researching showed that this was probably a safety measure responding to the recent trauma.  I tried a few things, eventually finding the command `sudo fsck.ext4 /dev/vda1`.  You're not supposed to do this to a mounted drive, but whatever.  I said yes to everything it wanted to fix, then rebooted.

And it worked.  Everything was back up.  Yay.

I did some quick investigation, looking at `dmesg` and other places, but didn't really find anything useful.  I sent another support message saying my server was back up, but I would like to know if things are resolved, what happened, and what they will do to prevent this in the future.  Then I left for work.

Dreamhost's Response
--------------------

There was very little info provided by Dreamhost on Twitter and Dreamhost Status during the incident.  They basically put out 4 tweets saying they were investigating an issue, identified it, and then "pushed out a fix" before I got my first direct response in a tweet, basically with the same content as the general "fix" tweet.  The Dreamhost Status site had basically the same info as the tweets.

I received the first response to my ticket around lunchtime.  It basically said what the tweets said, plus expressing "regret" and thanking me for my "continued patience".

I got another response overnight.  It expressed "sincerest apologies" and let me know that the issue was resolved and my VPS instance was loading.  Of course, they appreciated my patience again.

I got a third message this past evening, with a little more information.  It reiterated that "DreamCompute underwent planned maintenance to upgrade Ceph".  The problem was then summarized as "we started to see disruptions in the communication between some virtual machines and their storage backends".  They assured me they had tested the update before implementing, and hadn't seen the issue at that point.  To reassure me that things might be better in the future, they said they will "be spending some time determining the reasons behind that".  They apologized by saying "We apologize" and expanding on "service outages like this are not acceptable".  And of course, they appreciated my patience.

They reached out to many of the affected customers on Twitter that day, telling them to file tickets, or saying they expedited their tickets.  Some were still complaining of being down not long ago.

Dreamhost Status still shows the upgrade in progress and "partial service disruption" extant.  We'll see what they do for us as things settle.
