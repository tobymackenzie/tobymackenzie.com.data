---
categories: [www]
date: 2018-10-30T01:56:53-04:00
date_gmt: 2018-10-30T05:56:53+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2105'
id: 2105
modified: 2019-08-27T23:18:58-04:00
modified_gmt: 2019-08-28T03:18:58+00:00
name: h2-ubuntu-18-apache-php
pings: ['https://www.tobymackenzie.com/blog/2018/10/16/server-upgrade-ubuntu-18-04/']
tags: [apache, http, http2, performance, php, server, site, web]
---

HTTP 2 on Ubuntu 18.04 with Apache and PHP
==========================================

I recently got [h2 (HTTP 2.0)](https://en.wikipedia.org/wiki/HTTP/2) running on my server.<!--more-->  The new protocol should speed up page loads on my website.  I've been wanting to get H2 going for a while, but was reluctant to use a third party repo on Ubuntu 16.04.  That was one of the reasons I [upgraded to 18.04 recently](https://www.tobymackenzie.com/blog/2018/10/16/server-upgrade-ubuntu-18-04/), and I'm glad I'm finally taking advantage of it.

I couldn't find detailed instructions of what all needed to be done on 18.04 with Apache and PHP to make this happen, but pieced it together from various sites, such as [this one with 'php-fpm'](https://www.server-world.info/en/note?os=Ubuntu_18.04&p=httpd&f=13) and [this with 'mpm_event'](https://stackoverflow.com/a/51431377/1139122).  I guess neither 'mpm_prefork' nor 'mod_php' work with h2, and have to be replaced with alternatives.

The overview of what I needed to do was:

- Replace 'mpm_prefork' with 'mpm_event'
- Enable 'mod_http2'
- Specify `h2` in the `Protocols` Apache directive
- Replace 'mod_php' with 'php-fpm' / 'proxy_fcgi'

I use [Ansible](https://www.ansible.com/) to configure my server, and you can see the relevant [configuration changes in this commit](https://github.com/tobymackenzie/server-tobymackenzie.com/commit/b89c7386a23b5a81a6ad620b99c49fa1c69f1d1a).  Via command line, that would look something like:

``` sh
sudo su
apt remove libapache2-mod-php  ## assuming it is installed
apt install php-fpm
a2dismod mpm_prefork php7.2
a2enmod http2 mpm_event proxy_fcgi
a2enconf php7.2-fpm
echo 'Protocols h2 h2c http/1.1' >> /etc/apache2/apache2.conf
service apache2 stop && service apache2 start  ## `graceful` / `restart` seem to fail when changing mpm
```

It took a little while to figure out, but each change didn't take long to apply.  It is running nicely now.
