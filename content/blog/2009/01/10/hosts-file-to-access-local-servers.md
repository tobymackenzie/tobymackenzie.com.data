---
categories: [www]
date: 2009-01-10T04:11:26-05:00
date_gmt: 2009-01-10T09:11:26+00:00
guid: 'http://cosmicosmo.ath.cx/log/?p=211'
id: 211
modified: 2016-04-30T02:12:09-05:00
modified_gmt: 2016-04-30T07:12:09+00:00
name: hosts-file-to-access-local-servers
tags: [network, server]
---

hosts file to access local servers
==================================

Ever since I had to change to a Speedstream router instead of my old 2wire (constant and still somewhat present connectivity difficulties), I had been unable to login in to my Wordpress install locally.  This was because the Speedstream redirected traffic calling the external URL or IP from inside to itself rather than forwarding the request to the server, and because Wordpress requires a single fixed URL reference in its database that it automatically redirects to.

I worked hard trying to get the router itself to not do this, but instead the problem was fixable on my computer itself: the hosts file, as I found on [this post](http://codex.wordpress.org/User:Westi/Hosting_WordPress_Behind_NAT).   You simply edit the hosts file:

`$ sudo vi /etc/hosts`

and then place an entry like "accessURL externalURL" for another machine, ie:

`tobysServer.local cosmicosmo.ath.cx`

or modify a localhost line for a local machine (haven't tried this yet):

`127.0.0.1       localhost`

becomes:

`127.0.0.1       localhost        cosmicosmo.ath.cx`

Or possibly you could just do as for another machine and access by the LAN address rather than localhost (haven't tried this either, just speculation).

This was very quick and easy to do and works like a charm.  I haven't seen what happens if my WAN network access goes down with this method: I imagine it would cause problems accessing any part of the site.

One problem I've already found with Wordpress and this method is that many links don't work because they contain the full URL.  Examples include the Preview button and the all post links.  You must copy the link and past it, replacing the hostname bit.  But all the admin links work, at least the ones I've tried.  Tag autocompletion doesn't seem to be working either, but I'm not sure if that is a browser compatibility problem with this new 2.7 version or a plugin (simple tags) conflict.
