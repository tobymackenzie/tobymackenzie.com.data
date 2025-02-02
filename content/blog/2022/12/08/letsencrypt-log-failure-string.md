---
categories: [www]
date: 2022-12-08T23:35:35-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3904'
id: 3904
modified: 2022-12-08T23:35:35-05:00
name: letsencrypt-log-failure-string
tags: [letsencrypt, log]
---

Letsencrypt log failure string
==============================

After being unsure for a while of what to look for in the Certbot / Letsencrypt log that is pertinent, as in useful to look for under normal circumstances, I finally had a renewal fail and figured it out.  The string "(failure)" will appear if a renewal fails, and will be on the same line as the name of the cert.<!--more-->  So a simple 

``` sh
sudo less -p "\(failure\)" /var/log/letsencrypt/letsencrypt.log
``` 

will tell if any renewals have failed.  Of course, I also got an email, which is much is much simpler to monitor, but I also get those some time after I change the domains on a cert.
