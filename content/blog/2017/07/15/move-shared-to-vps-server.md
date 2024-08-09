---
categories: [www]
comment_count: 1
date: 2017-07-15T00:56:09-05:00
date_gmt: 2017-07-15T05:56:09+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1532'
id: 1532
modified: 2017-07-15T16:21:01-05:00
modified_gmt: 2017-07-15T21:21:01+00:00
name: move-shared-to-vps-server
tags: [dreamcompute, dreamhost, move, provision, server, shared, vps]
---

Move: Shared to VPS server
==========================

Alright.  After much effort, I have moved my site from [Dreamhost](https://www.dreamhost.com/r.cgi?568062) shared hosting to their [DreamCompute](https://www.dreamhost.com/cloud/computing/) (unmanaged VPS).  I now have my own (virtual) server to do with as I please.<!--more-->  I stayed on shared for a while in part because there's a certain humbleness to it, as well as work and cost.  Costs have dropped even below shared though, and the benefits finally drew me over.  Now I can install whatever I want, run a reverse proxy, run a node js server, use provisioning tools, all sorts of things.

The bulk of the time was spent learning [Ansible](https://www.ansible.com/), [Vagrant](https://vagrantup.com/), and [certbot](https://certbot.eff.org/) / [LetsEncrypt](https://letsencrypt.org/).  Learning Ansible took way longer than it would've taken me to just set things up manually on the server, but now I can easily get back to where I am on a new or hacked server, as well as make changes from yaml files.  Vagrant will allow me to test server level changes locally before implementing, and site level changes locally in the same environment as my server.

It also took some time figuring out the Dreamhost and DNS part of the move.  I moved sub-domains and other domains well before I moved my primary one, figuring out how to make it go as smoothly as possible.  Unfortunately, the primary domain switch didn't go as smooth as I would've liked, and my site was down for probably a couple hours.

Dreamhost creates 'A' DNS records for sites your hosting with them that you can't touch.  You can add additional 'A' records for the same domains, though.  Doing this worked fine for my non-primary domains, allowing me to leave the shared account running while the DNS propagated to the new server.  In theory, this would mean 0 down time.

For my primary domain, it didn't work like that.  It actually switched briefly, but then switched back.  I had to completely cancel my shared hosting account before it switched and stayed.  This included deleting all hosted sites, mysql databases, and users, and then click a scary looking link 'close account / end all hosting'.  This really just cancelled the shared account.  It took me a while to figure this all out, and I also waited for a while hoping the DNS would propagate back.

I probably should've just asked support what I had to do before I started.

The move took a lot of time and was stressful at times, but I'm glad it happened.  I will try to write more about what I did and learned along the way.
