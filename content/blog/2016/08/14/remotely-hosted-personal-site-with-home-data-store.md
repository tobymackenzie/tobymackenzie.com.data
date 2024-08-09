---
categories: [ideas, ideas, www]
date: 2016-08-14T13:43:08-05:00
date_gmt: 2016-08-14T18:43:08+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1213'
id: 1213
modified: 2022-03-08T20:57:26-05:00
modified_gmt: 2022-03-09T01:57:26+00:00
name: remotely-hosted-personal-site-with-home-data-store
pings: ['https://www.tobymackenzie.com/blog/2016/01/12/local-proxy-remote-hosting-personal-site/']
tags: [data, home, indieweb, security, server, site, web]
---

Ideas: Remotely hosted personal site with home data store that syncs as client
==============================================================================

This idea is based on my [Local + Proxy Remote Hosting for Personal Site](https://www.tobymackenzie.com/blog/2016/01/12/local-proxy-remote-hosting-personal-site/) idea, but attempts to mitigate some of its problems further.

<!--more-->

In this setup, the website (most appropriate for personal [indieweb](https://indieweb.org/) type sites) will still have a remotely hosted and a home hosted component.  The home server will be the single source of truth for data, but will not be remotely accessible.  The remote server will have the full code and data to run the website and will handle all visitor request directly, using copies of the data from the home server.  CUD changes can be done on the remote server, but they will be marked as 'unverified' or some-such.  The home server can have a cron task or manually run script to make a request to the remote server, which will transfer changes between the two.  The change request may also be run after each change is done on the home server, or after a certain interval following an update to batch send them.  Some sort of key based system would be used to authenticate both ends.

This setup provides the advantages of serving from home, but removes some of the problems.

- Downtime: The local + proxy setup was theorized mainly to eliminate the downtime problems of a home server.  This takes it further by not needing the home server for CUD requests.
- Speed: We won't need to make a request to the home server for any requests to the remote server, and will have all of the network and server speed of a hosted server.  The home server could be a laptop or raspberry pi without affecting site speed.
- Dynamic DNS: We won't need dynamic DNS or an expensive static IP at home.
- Security: We won't have to open a port to our home server.  The remote will not have to know anything about the home server other than its authentication credentials.  We will have the SSL of our remote for any HTTP requests.
- Setup: Setup should be easier without needing to open ports, keep a dynamic IP updated or set up a static IP, and secure the incoming connection to the home server.

Transfer could be done over a simple HTTPS request or even SSH.  If the remote is compromised or the connection is MiTM'ed, theoretically the only dangers to the home server beyond regular client dangers is that the CUD changes to data could be tampered with.  Version control or other techniques can be used to mitigate this problem.  If the compromise is detected, the server can be replaced with a new one, with fresh data and code from the home server.

With this setup, the "home" server could even theoretically be a laptop that you take with you and update from wherever you are.  There would no longer be a need for it to be running constantly or coming from a single location.  Of course, using a laptop, you'd want to be especially careful with your backup plan, to reduce the risk of compromise on the home end.

*[CUD]: Create Update Delete
*[MiTM]: Man in the Middle
