---
categories: [computer, www]
date: 2018-04-13T01:03:22-05:00
date_gmt: 2018-04-13T06:03:22+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1861'
id: 1861
modified: 2018-04-13T01:03:22-05:00
modified_gmt: 2018-04-13T06:03:22+00:00
name: mac-dns-wi-fi-troubles
tags: [dns, internet, mac, problem, wifi]
---

Mac DNS and wi-fi troubles
==========================

After my work laptop was stolen and I switched to an older Mac Mini, my wi-fi internet connection would cut out frequently but somewhat intermittently.<!--more-->  The OS would still show as connected, but nothing would load.  It was very frustrating as a developer.

When cutting out, it would not disconnect from our messaging server properly, so I would still show up as available to others, and messages would get lost.

It was a fresh install of the OS (El Capitan), so I was surprised.  I tried to search for the problem, and tried various fixes, to no avail.  I wrote a shell script to disconnect and reconnect the wi-fi, which would also reestablish the internet connection:

``` sh
#!/bin/sh
networksetup -setairportpower en1 off
networksetup -setairportpower en1 on
```

After some time, I came to realize that it would only cut out when visiting my local development server, something I do frequently.  So I modified my behavior to accommodate, doing local development in batches and disconnecting from messaging beforehand.  This was kind of a pain, and proved particularly difficult for projects with remote scripts or curl calls.

I looked at my Apache server settings and tried tweaking things, but that didn't help.  I also had problems with other local servers.

Just recently, I discovered that I only had the problem when visiting via the domain that my computer was broadcasting over the network.  Macs will broadcast a name, like `tobys-computer.local`, over the local network for various sharing purposes.  We use that to let others in the office see what we're working on.  I used it locally just so I could more easily grab and share the links.  But no more.

I've been using `localhost` or other domains set up in `/etc/hosts`, and haven't had the problem since.  I'm not sure why the problem was occurring, but this solution is sufficient, a very minor inconvenience.  Work is now much easier and less stressful.
