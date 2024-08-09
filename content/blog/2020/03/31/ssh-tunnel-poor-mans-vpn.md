---
categories: [computer, www]
date: 2020-03-31T10:41:14-04:00
date_gmt: 2020-03-31T14:41:14+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2761'
id: 2761
modified: 2020-03-31T10:41:14-04:00
modified_gmt: 2020-03-31T14:41:14+00:00
name: ssh-tunnel-poor-mans-vpn
tags: [proxy, ssh, vpn, web]
---

SSH tunnel as "poor mans" VPN
=============================

A few web servers that I've needed to access for work have blocked my connection when connecting via tethering to my phone internet (T-Mobile).  To get around this, I used an SSH tunnel as a [SOCKS proxy](https://en.wikipedia.org/wiki/SOCKS) for my web traffic.<!--more-->  It's sort of like a VPN, but with a much simpler setup, only needing a normal SSH connection to a remote server and a simple setting change in the browser.

[This article](https://ma.ttias.be/socks-proxy-linux-ssh-bypass-content-filters/) covers the procedure in detail.  Basically, you would add `-CqND 8888` to the `ssh` command you would normally run on the command line to connect to the server.  `8888` is the example local port you will use, and can be any port you want, except it will require administrative permissions to be a "reserved" port.  The command will look something like:

``` sh
ssh -CqND 8888 user@example.com
```

This one liner sets up the proxy.  Then, you tell your browser to use it.  In Firefox, this is done in the "Network Settings" pane by going to "Settings > General > Network Settings", and pressing the "Settings…" button.  In the "Configure Proxy Access" section of the pane, select "Manual Proxy Configuration".  Set the "SOCKS Host" field to "localhost" and the adjacent "Port" field to `8888` or whatever port you used in the SSH command.

While the proxy is running, all your web traffic from the configured browser routes through your server, and the end servers you connect to will see your traffic as coming from that middle server instead of your own IP.  This was sufficient to allow me to access the servers I needed to for work.

When you are done using your proxy, hit `ctrl-c` on the command line where you started it to kill it, then switch off proxy access in the browser to go back to normal.

I was having a problem with the proxy connection (and other SSH sessions) timing out quickly when tethering on my phone.  Adding this setting to your `~/.ssh/config` helps prevent this:

```
Host *
	ServerAliveInterval 60
```

at the expense of causing a little bit more chatter through the network: It would cause a packet to be sent to the server after 60 seconds to make sure the connection is still alive.
