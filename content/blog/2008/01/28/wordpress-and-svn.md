---
categories: [www]
date: 2008-01-28T11:31:18-05:00
guid: 'http://cosmicosmo.ath.cx/log/2008/01/28/wordpress-and-svn/'
id: 163
modified: 2016-04-30T02:12:09-05:00
name: wordpress-and-svn
tags: [server, wordpress]
---

Wordpress and SVN
=================

I've been thinking about it for a while, but I finally decided to use subversion to update my wordpress instead of the download, copy over to server, copy in all old files method.  Details on using SVN with wordpress can be found on [Wordpress.org](http://codex.wordpress.org/Installing/Updating_WordPress_with_Subversion).

Since it was my first time, I had to do an initial install so that all the subversion tracking data would be there.  The command for installation, which would be used for a new install, was just a simple one line thing with the url of the install and a few flags.  Then I had to copy over my htaccess, wp-config, and wp-content, all simple and easy.

Because this brought me up to date, I was unable to try the update type commands.  But it seems extremely easy, just a one line command again, plus the web based upgrade script.

This should make my upgrading much faster and easier, and so lessen the delay between upgrades.

[Update 09/01/10]The steps, which I should have included before:
$ cd blogpath
# for trunk versions you can simply update
$ svn up
# OR for full point revisions, you must use the switch command to change versions
$ svn sw http://svn.automattic.com/wordpress/tags/2.7/ . 
[browser]updgrade.php

[/update]

[Update 2/13]I've now done an update via subversion.  It was in fact extremely easy, just one simple command line command followed by the upgrade.php script.  Everything works fine, no copying and moving files and what not, although a backup is a good idea.[/update]
