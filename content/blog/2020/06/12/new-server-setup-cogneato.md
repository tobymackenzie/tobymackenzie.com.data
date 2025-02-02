---
categories: [www]
date: 2020-06-12T03:01:12-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=2892'
id: 2892
modified: 2020-06-13T02:30:32-04:00
name: new-server-setup-cogneato
tags: [ansible, cloudflare, cogneato, digital-ocean, linux, php, server, upgrade]
---

New server setup at Cogneato
============================

I'm kind of excited that we moved the first site onto a new server setup at Cogneato.  I had worked off and on on the setup for months before we finally went forward with it.  It brings a new OS, new host, new software, and a number of other changes to our previous setup.

<!--more-->

The site we started with is [rockinhouston.com](https://rockinhouston.com), in part because it was having speed issues on the old server and in part because it's a simple site with less features and code needing to be updated to work with the new software / setup.

I used [vagrant](https://www.vagrantup.com/) and [ansible](https://www.ansible.com/) to create and test a reproducible setup locally.  Previously we just set it up on the live server as we went.  I based it off of [what I built for my own site](https://github.com/tobymackenzie/server-tobymackenzie.com/).  This was my first professional use of those tools.  It should make it easier to test changes in the future and to deploy more servers when needed.  It also makes the setup easier to take in, being able to look over a set of config files instead of browsing around a server.

We chose Ubuntu (18.04) instead of the CentOS of our previous servers, because of the ease of upgrading major versions and because me and the other main dev are more familiar with it outside of Cogneato.  I used our CentOS server setup as a guide and had to tweak some things in the setup and our tools for Ubuntu's folder structure, software, etc.

The new OS brings security and feature updates, and many new software packages, such as:

- Apache 2.4 instead of 2.2: brings HTTP2, easier config for some things
- PHP 7.2 instead of 5: brings speed, security, short array syntax, null coalesce operator, etc
- A node / npm version much greater than 0.x: can actually install packages

PHP provided the biggest challenge of the changes.  Old parts of our CMS software and custom site code were dependent on the old PHP features [register_globals](https://www.php.net/manual/en/security.globals.php) and [magic quotes](https://www.php.net/manual/en/security.magicquotes.php), as well as the [mysql API](https://www.php.net/manual/en/book.mysql.php).  We created polyfills of sorts for the globals and mysql, and modified CMS code to work properly without them.  That took a fair amount of dev time on its own.  Each site that is migrated will need to have its code vetted.  We used those old features less and less as time went on, so newer sites shouldn't have problems.  Some really old sites just won't be able to be migrated at all and will have to be kept on a special old server or rebuilt completely.

I didn't go with Ubuntu 20.04 in part because I had done much of the ansible part before it was even released, and in part because PHP 7.4, MySQL 8, and other updates were causing too many problems for our CMS and other software.  There's still three more years of 18.04 support, so we have time to figure those issues out.

We went with a new host, [Digital Ocean](https://www.digitalocean.com/) for the cheap price, features and flexibility, and the familiarity the other main dev has with it.  Our previous servers are on [Rackspace](https://www.rackspace.com/).  I've considered moving my own site to DO.

We also made use of [Cloudflare](https://www.cloudflare.com/) in place of a load balancer.  It seems cool.  It was very easy to set up. Punching in a domain, it automatically detected DNS settings, then had us point to their nameservers from the registrar. It required almost no changes on the server.  It brought us free HTTPS and proxy caching.  It was free for our needs.  It has a lot of features I haven't explored yet.

The site is running noticeably faster than on the old server, though it's currently by itself instead of shared with many sites.  Hopefully we will get to move more sites over soon, though we still have to make changes to our CMS for some newer sites and features to work on the new setup.  Once we get all the sites we intend to move switched, we can drop support for PHP 5, which will ease support 7.4 and newer [Symfony](https://symfony.com/) and other software versions, and remove or clean up some old cruft.

I had fun and learned a lot with this project.  I will likely take some of what I learned back to my own server setup.
