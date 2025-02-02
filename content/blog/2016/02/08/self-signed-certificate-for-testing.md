---
categories: [www]
date: 2016-02-08T02:32:07-05:00
guid: 'https://tobymackenzie.wordpress.com/?p=958'
id: 958
modified: 2016-04-04T22:24:13-05:00
name: self-signed-certificate-for-testing
tags: [certificate, development, https, local, selfsigned, ssl]
---

Self-signed certificate for testing
===================================

In playing with service workers, I set up a self-signed SSL certificate for my local development environment.  I used [instructions from debian.org](https://wiki.debian.org/Self-Signed_Certificate).  It was very simple, since I didn't need the security involved with a real operating site.  Creating the certs took a single command:

```
openssl req -new -x509 -days 365 -nodes -out /path/to/server/config/certs/sitename.pem -keyout /path/to/server/config/certs/sitename.key
```

You then just need to set things up in the server configuration (Apache in my case).  `mod_ssl` must be installed and enabled, which looks something like:
```
LoadModule ssl_module modules/mod_ssl.so
```

<!--more-->

in `/etc/apache2/httpd.conf` or wherever your configuration is.  The server must be told to listen on port 443, like:

```
<IfModule mod_ssl.c>
	NameVirtualHost *:443
	Listen 443
</IfModule>
```

A virtual host must be created that has the same configuration as the HTTP virtual host, but with the port changed to 443 and 3 lines to enable the SSL certificate.  One way to keep things <abbr title="Don't repeat yourself">DRY</abbr> is to move the stuff that's inside the virtual host into another file and include that in both virtual hosts:

```
<VirtualHost *:80>
	Include conf/site-partials/sitename.conf
</VirtualHost>
<VirtualHost *:443>
	Include conf/site-partials/sitename.conf
	SSLEngine On
	SSLCertificateFile "/path/to/server/config/certs/sitename.pem"
	SSLCertificateKeyFile "/path/to/server/config/certs/sitename.key"
</VirtualHost>
```

Restart Apache, and you will now be able to visit your virtual host over HTTPS.  As with any self-signed cert, you will have to bypass a security warning, but that will be fine enough for testing purposes.
