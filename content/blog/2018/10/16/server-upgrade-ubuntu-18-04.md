---
categories: [www]
comment_count: 1
date: 2018-10-16T02:14:46-04:00
date_gmt: 2018-10-16T06:14:46+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2080'
id: 2080
modified: 2020-05-02T01:49:02-04:00
modified_gmt: 2020-05-02T05:49:02+00:00
name: server-upgrade-ubuntu-18-04
tags: [apache, http2, php, server, site, symfony, tmcom, ubuntu, upgrade]
---

Server upgrade: Ubuntu 18.04
============================

I've finally updated my server to Ubuntu 18.04 using `do-release-upgrade`.<!--more-->  It took some time to run the upgrade, modify and test [my ansible configuration](https://github.com/tobymackenzie/server-tobymackenzie.com/) to work properly, and fix various issues.  Things seem to be working fine now.  There aren't really any noticeable differences so far, but I do have new software version and am one step closer to http 2 and Symfony 4.

I was hoping with the upgraded version of Apache that I'd have http 2 enabled, but it isn't enabled by default.  It looks like it might require some work to get working, such as using php-fpm instead of mod_php.  I will have to look at the implications of that.

I get a new version of PHP (7.2), which will finally allow me to use Symfony 4.  I was disappointed that they required PHP 7.1 five months before stable Ubuntu even had it.  I thought some of the changes to Symfony 4 looked cool even as they were being [discussed leading up to its release](https://symfony.com/blog/symfony-4-a-new-way-to-develop-applications), particularly the directory structure and other simplifications.  It does seem a bit confusing though with flex, especially updating an existing project.
