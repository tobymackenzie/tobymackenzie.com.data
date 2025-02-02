---
categories: [ideas, www]
comment_count: 1
date: 2016-01-12T04:00:05-05:00
guid: 'https://tobymackenzie.wordpress.com/?p=811'
id: 811
modified: 2016-01-12T04:00:05-05:00
name: local-proxy-remote-hosting-personal-site
tags: [cache, hosting, indieweb, selfhosting]
---

Ideas: Local + Proxy Remote Hosting for Personal Site
=====================================================

Hosting your personal website on a computer at your home puts extra indie in [indieweb](http://indiewebcamp.com/).  You truly control all of your data.  I did this for several years.  I did this with a very modest setup, serving from a mobile home using an iBook G3 800 with Windstream DSL internet.  Performance obviously wasn't the same as a web host would've provided.  Of course, it helped a lot that I didn't have much traffic.  But I still had a lot of downtime, for a number of reasons:

- **Dynamic IPs**: most consumer level internet service plans do not have a static IP, and change occasionally.  I used [DynDNS](http://dyndns.org/) to accomodate this, but it still led to downtime between the time that the IP changed to the time the daemon was run, DynDNS updated its records, and the DNS propagated.
- **Internet outages**: consumer level plans definitely don't have the robust connection that a web host has.  This was especially true at my mobile home, where perhaps old wiring led to fairly frequent outages, especially on windy days.
- **Power outages**: hosting companies have backup power.  Most homes do not.  My power went out from the electric company at least several times while I was hosting, but also went out whenever I had to turn off the power to work on something electrical.  My server would stay on because it was a laptop, but not the router.  A UPS is a reasonably priced option for reducing or eliminating this problem though.
- **Computer / router issues, updates, etc**: Any reboots, shutdowns, or stopping of server daemons will mean your site is down, which could be needed for updates or various problems.  Web hosts usually have robust servers, and if they're managing them, they're usually very good about keeping them up and doing updates quickly and during down-times.

My idea to mitigate performance and downtime problems would be to use a reverse proxy, such as [varnish](https://www.varnish-cache.org/), running on a remote web host, with your DNS pointing at it.  It would be configured to go to your home server's IP for content.  You'd have to set up a daemon to contact the remote server and update this when it changes.  Public pages would be set with long cache times so that they would be available if your home server goes down.  The application(s) on the server would then have to be set up to send a PURGE request when pages were updated.  Or perhaps, if the proxy allows, you could use whatever maxage times you want but have the proxy store the cached responses indefinitely and server them if the home server can't be reached even if the maxage has been passed.

This idea is not without its problems.  For instance:

- **Security of connection between servers**: If your site is using SSL, the connection between the servers would also have to be over SSL or the SSL used between the client and remote server would be virtually worthless.  Without SSL between the two, a man in the middle could easily eavesdrop on the traffic or divert all traffic to their own server.  Because of the changing IP address, the home server would have to use a self-signed certificate possibly increasing the risk of a man in the middle attack between the two servers and at the least requiring the remote server to accept that cert from any IP that it considers your home server.
- **Non-cacheable requests would always need the home server**: Private pages like admin pages as well as any mutating (POST, etc.) requests, would always have the same performance and robustness issues as the home server.  Most importantly for many personal sites, webmentions / pingbacks / trackbacks / comment submissions would fail if the home server went down.  So would any other form submissions.  To deal with this, you'd probably have to do some programming on the remote server to have it queue these requests and give it an appropriate generic response for the request.  For admin and logged in user activity, you could build the client side of your app to operate as you desire in offline mode.

And, as is always the case with serving from home, server and home network configuration, security, maintenance, etc. is all on you.  There isn't really a "managed" option available.  You'll have to get everything working, apply updates, deal with server and network problems, etc.  In a home environment, security also includes physical access to the device.
