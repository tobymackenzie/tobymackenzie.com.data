---
categories: [www]
date: 2023-04-25T23:46:37-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4008'
id: 4008
modified: 2023-04-25T23:46:37-04:00
name: dreamcompute-account-cancelled
tags: [dreamcompute, dreamhost, problem, server, vps]
---

DreamCompute account cancelled
==============================

I have finally shut down my DreamCompute server on Dreamhost after [my recent four day downtime incident](/content/blog/2023/04/12/goodbye-dreamhost-hello-digital-ocean.md).  I was waiting on a client to move her DNS to the new server, but the old one was having more problems in the interim.<!--more-->  I couldn't load the site or even get a response from Apache.  I couldn't SSH in, getting permission denied, which implies that the SSH server was running but there was something wrong with it.  All I could do is restart from the DreamCompute panel, which didn't help.  I'm not sure if it was a problem inside the virtual machine, or outside (ie my problem or DreamCompute's), but that coupled with me coming up on the next billing cycle made up my mind to shut down even though my client hadn't switched over yet.

This server was up since 2017, and allowed me to work on a virtual machine host set up with Ansible with my own personal needs, as opposed to what I do at work.  It helped me learn a lot and informed my switching to Ansible at work and a number of other things about server setup.  The server worked nicely until a few years ago when it went down for a couple days due to a DreamCompute issue.  Two more similar incidents without much info from Dreamhost, plus a lack of development and focus on the product, led me to move to Digital Ocean, which I've used at work, and has much better administrative features.

For some reason, Dreamhost charged me almost double the rate for this last billing period.  I had spun up a new server a couple times and created some snapshots, but those were all shut down within the four day period of that most recent outage incident.  If they don't charge me anything more, I'll let it slide.  Otherwise, I'm going to bring file a ticket.

I only have a single domain registration left with them, and I'm trying to transfer it out.  Can't seem to get my access code.  Talked to support, and they said they have filed a ticket with eNom (their registrar service provider), but it's taking a while.

Hopefully my client gets around to switching over the DNS before someone spins up another VM at that IP, assuming she still wants the site.  I had given her today as a deadline to do it anyway, and she hasn't been very responsive about it.
