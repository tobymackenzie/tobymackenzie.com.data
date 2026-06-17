---
name: goodbye-rackspace
date: 2026-06-17T15:14:17-04:00
categories: [www]
tags: [cogneato, server, digital-ocean, move, web]
id: 4879
guid: 'https://www.tobymackenzie.com/blog/2026/06/17/goodbye-rackspace.md'
---

Goodbye, Rackspace
=======

We at Cogneato have finally shut down our servers and other paid services with Rackspace.  It is definitely a relief to be done with that.  It was a six year operation, but a sudden large increase in costs pushed us to get it finished.
<!--more-->

We moved to Rackspace about 10 years ago due to issues with our previous host.  But we had some problems with them and increasing costs, which prompted us to start moving to Digital Ocean at the behest of one of our former devs about six years ago.  We had to do a lot of work on our CMS and site code to get them to work on the newer PHP, Apache, MySQL, etc of the newer server.  As I moved sites over, I built scripts to automate most of the move and made changes to the CMS code to make it easier.  Eventually, we got a much more solid setup there than at Rackspace.

We manage the domains for some of our clients, and those I was able to move myself over time.  Some of our clients from the old servers also left in that period.  Some of the sites were more complicated to move though, and some managed their own domain registration, requiring coordination with them.  Over time, I resolved the problems with moving the complicated sites.

However, a number still remained requiring some decisions and nameserver changes by the clients.  For most of our newer servers, we put sites behind Cloudflare.  It took a while to explain the options: setting up their own Cloudflare to keep managing their DNS, going on our Cloudflare and having to go through us for DNS, or not using Cloudflare and going on a special set of servers.  More importantly, I didn't have recent contact with many of the clients and had to go through my boss, who was focused on other things.  When contact was made, some clients were slow to respond or do anything.

Finally, when Rackspace prices nearly tripled on us, my boss became motivated to get things moving.  He pushed on clients to make it happen, and when I was looped in on the communications, I began pushing to make the move happen as well.  I did what I could when I was waiting on them, but some of them dragged things on for months.  Finally, with a lot of pushing, help, answering questions, and dealing with DNS issues, we made it through the last of them.  It felt really good when I finished the last one and shut things down at Rackspace.

The latest site moves didn't go completely without problems, but the problems were pretty minor.  The biggest direct problem was probably one where, because of switching from a PHP version that had magic quotes enabled to one without, one of our sites with some older custom code had some customer entered values on some 200 orders with `"n"` in place of line breaks.  I had to fix the code and then manually fix the database entries, because there was no easy way to write a query for fixing that when `n` could be an actual character of that field.

There have also been some load problems as I've put more sites on our existing newer servers.  Some of that was due to a lot of bot traffic trying to do things to the older server that didn't have a firewall.  I added some Cloudflare firewall rules that seem to have mostly resolved that.  I'll have to monitor the situation and see if we need to increase the size of some of them or add some more servers.  Even with that, our costs will be dramatically lower overall.

Our newer servers are a bit faster and definitely more secure.  They also have a newer version of our CMS with a lot of new features.  I've already done some work for clients to enable some of these features on their sites.

Also, now that all sites are moved, I will be able to make more upgrades to the newer servers, PHP and MySQL versions, CMS code, dependencies, etc.  I had been limiting how far I went with that in order to simplify the move of sites from the old to current version, but now I don't have that limitation.  Of course, that will be a whole lot of work in itself.  Luckily, I won't have to wait on clients for that, at least until I need to set up new servers with new OS versions.
