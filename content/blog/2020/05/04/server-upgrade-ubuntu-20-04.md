---
categories: [www]
date: 2020-05-04T02:09:59-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=2842'
id: 2842
modified: 2020-05-04T02:09:59-04:00
name: server-upgrade-ubuntu-20-04
tags: [linux, server, ubuntu, upgrade]
---

Server upgrade: Ubuntu 20.04
============================

I upgraded my server from Ubuntu 18.04 to 20.04 this weekend.<!--more-->  I largely followed [this guide](https://www.cyberciti.biz/faq/upgrade-ubuntu-18-04-to-20-04-lts-using-command-line/) and looked at the [release notes](https://wiki.ubuntu.com/FocalFossa/ReleaseNotes).  The process took about 40 minutes on my live server, but 2-3 hours on my dev virtual machine.  The longer time for the VM was in part because:

- my local computer and network are slower than on my server
- I wasn't paying close attention the several times the process was stopped to ask questions
- I had to figure out how to deal with some conflicts with my changes to configuration files

The upgrade took maybe 500-700 MB of data transfer.

The process, done from my local terminal, began with:

``` sh
ssh tobymackenzie.com
sudo su
apt update
apt upgrade
apt --purge autoremove
reboot
```

to make sure everything was updated.  It already was on my live server, since I have [`unattended-upgrades`](http://manpages.ubuntu.com/manpages/focal/man8/unattended-upgrade.8.html) running.

The actual upgrade is done with:

``` sh
ssh tobymackenzie.com
sudo su
do-release-upgrade || do-release-upgrade -d
```

which will guide you through the upgrade and ask a few questions.  If you have modified configuration files that conflict with changes made, it will have you decide how to handle it.  You can look at the diff, and decide between using your version, their version, attempt to merge automatically (this failed for me), or dropping to a shell and manually editing the file.

At the end, it will ask you to reboot.  You can either let it do the reboot, or you will have to.  Once you reboot, you can ssh in once more to verify things are correct.  To check you're version is updated, you can run:

``` sh
ssh tobymackenzie.com
lsb_release -a
```

I had no pressing need to upgrade, but wanted to get it out of the way.  It may help with LetsEncrypt complaining that my HTTPS certificate was being renewed with the deprecated version 1 API.  `certbot` went from version 0.23 to 0.40.  The upgrade also may have added TLS 1.3, which will be important as that takes over HTTPS connections.  And it brought [PHP 7.4](https://www.php.net/releases/7_4_0.php), up from 7.2, which brings some new niceties and keeps me up to date, at the least.

I can't say for sure, but my server may be running with a little less processor load and responding a bit snappier.  Though it is now running awfully close to the 1GB of memory my VPS has.  I didn't monitor those things closely enough before to say for sure that they've changed though.
