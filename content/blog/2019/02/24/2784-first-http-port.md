---
categories: [www]
date: 2019-02-24T03:29:48-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=2223'
id: 2223
modified: 2024-02-08T21:01:27-05:00
name: 2784-first-http-port
pings: ['https://www.tobymackenzie.com/blog/2018/02/18/supporting-http-0-9/']
tags: [apache, dreamcompute, old, oldbrowsers, progressiveenhancement, server, site, web]
---

2784, the first HTTP port
=========================

Looking at a page discussing [the code of the first web browser (WorldWideWeb)](https://worldwideweb.cern.ch/code/), I noticed a line designating port 2784 as `OLD_TCP_PORT`.  After looking into it a bit more, I determined that this was the port used for the web until port 80 was officially designated in January of 1992.<!--more-->  That same month, presumably shortly before that designation, Tim Berners-Lee sent [an email to the www-talk mail list with protocol notes](http://lists.w3.org/Archives/Public/www-talk/1992JanFeb/0000.html), including this line:

> During development, the default HTTP TCP port number is 2784 -- this will change when an official port number is allocated.

Since my site [already supports HTTP 0.9](https://www.tobymackenzie.com/blog/2018/02/18/supporting-http-0-9/) (the original HTTP), I figured I might as well also support the original port.  To do so, all I needed to do was tell Apache to use that port for my main site, and open up my firewalls.

Apache configuration
------------

For Apache, I first had to tell it to listen for the port in general.  That is as simple as adding the line:

```
Listen 2784
```

to the configuration.  On Ubuntu, that can be done in `/etc/apache2/ports.conf`.  I then added the port to the site's non-SSL virtual host.  Multiple port rules can be added separated by spaces, so it looks like:

```
<VirtualHost *:80 *:2784>
```

Note: it should be non-SSL because SSL didn't exist at the time of this port's use.

The virtual host must also be able to respond to HTTP 0.9 requests, which WorldWideWeb would've used.  To summarize [my post on setting that up](/content/blog/2018/02/18/supporting-http-0-9.md), the desired virtual host must be the first configured, rewrites to force a canonical domain and HTTPS must be bypassable if no `Host` header is sent, and application code might require setting the `HTTP_HOST` server environment variable to the canonical value when none is set.

<ins>If you have a `%p` in your `LogFormat` directives, that should be changed to `%{local}p` to log the actual port used.  This is not standard, but I have that, along with `%V`, to show me more about what the client requested.</ins>

Firewall setup
--------------

I use `ufw` for my server's firewall, so I needed to have it allow connections to that port.  I use [ansible](https://www.ansible.com/) to configure this, but it should be doable on the command line with:

```
sudo ufw allow 2784/tcp
```

In getting this change working, I discovered that DreamCompute servers also have a configurable network level firewall.  Ports can be [added via the DreamCompute dashboard](https://help.dreamhost.com/hc/en-us/articles/215912838-Configuring-security-groups#Add_rule)).  I added two rules looking like:

```
Ingress 	IPv4 	TCP 	2784 	0.0.0.0/0 	- 	
Ingress 	IPv6 	TCP 	2784 	::/0 	- 
```

Using
-------

After configuring the server and firewall, I was able to successfully visit my site over port 2784.  With the way my server is set up, visiting <http:></http:> with a modern browser (in this case, any that support HTTP 1.0), it will get redirected to port 80, and then to HTTPS if the browser supports it.

To verify that it will actually respond with the regular site responses for HTTP 0.9 requests, `telnet` can be used.  Run `telnet tobymackenzie.com 2784` on the command line and then type `GET /`, followed by return.  If all is well, this will show the HTML of the requested page.  <ins>Now netcat is more common, which can be used like `echo 'GET /' | nc -c tobymackenzie.com 2784`</ins>

I don't have a copy of WorldWideWeb, let alone an early version from before the port was changed.  Likely, no one does.  But in theory, if someone does, my site should be accessible to it.  Progressive enhancement.
