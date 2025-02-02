---
categories: [www]
date: 2019-11-23T01:44:45-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=2572'
id: 2572
modified: 2019-11-23T01:46:56-05:00
name: letsencrypt-shared-web-root-all-domains
tags: [certbot, https, letsencrypt]
---

Letsencrypt: Shared verification web-root for all domains
=========================================================

I use [Letsencrypt](https://letsencrypt.org/) with [certbot](https://certbot.eff.org/) for the HTTPS certificates of my personal sites.  I use the `certonly` method to allow full control over my server configuration.  This means specifying one or more web-roots for each certificate.<!--more-->  This can get tedious when using one cert for multiple domains that each have their own web-root (such as related subdomains).  For a while, I've been wanting to set up one folder used by all domains for verification.  I finally implemented this idea.

[Apache's `Alias` directive](http://httpd.apache.org/docs/2.4/mod/mod_alias.html#Alias) is perfect for this use case.  It allows pointing all URL paths beginning with a specified path part to be served from a specified file path, rather than the normal web-root.  So, we can create the folder that certbot will use:

``` sh
sudo mkdir -p /var/www/letsencrypt
sudo chgrp www-data /var/www/letsencrypt
sudo chmod 2750 /var/www/letsencrypt
```

Note that `www-data` is the default Apache user for Ubuntu.  Your server's may be different.

In our Apache configuration, outside of any virtual host if we want it to be used for all sites, we can add the `Alias` and `Directory` directives:

``` conf
Alias "/.well-known/acme-challenge/" "/var/www/letsencrypt/.well-known/acme-challenge/"
<Directory /var/www/letsencrypt/.well-known/acme-challenge/>
	AllowOverride None
	Options FollowSymLinks
	Require all granted
</Directory>
```

This will, of course, require restarting Apache (eg `sudo apachectl graceful`).

We will also need to have certbot use this directory, so we can run it like:

``` sh
certbot certonly --webroot --webroot-path /var/www/letsencrypt/ --agree-tos --cert-name tobymackenzie -m admin@tobymackenzie.com -d tobymackenzie.com -d www.tobymackenzie.com -d sub1.tobymackenzie.com -d sub2.tobymackenzie.com
```

If some of those domains have different web-roots than others, we won't have to worry about configuring them.  Makes it simpler.
