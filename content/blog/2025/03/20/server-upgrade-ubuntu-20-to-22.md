---
categories: [computer, www]
date: 2025-03-20T00:49:16-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4527'
id: 4527
modified: 2025-03-20T00:49:16-04:00
name: server-upgrade-ubuntu-20-to-22
tags: [os, server, site, ubuntu, upgrade, web]
---

Server upgraded from Ubuntu 20.04 to 22.04
==========================================

My server was on Ubuntu 20.04, but due to the end-of-life of that LTS version next month, I have upgraded to 22.04.  My server is [managed with Vagrant / Ansible](https://github.com/tobymackenzie/tobymackenzie.srv).  My plan had been to do a new local VM on the newer version, get it working properly with Ansible, then set up a new server with it and migrate over.  However, since [Ubuntu isn't releasing an official Vagrant box for 24.04 and beyond](https://discourse.ubuntu.com/t/ubuntu-24-04-lts-noble-numbat-release-notes/39890#p-99950-vagrant), I don't think it makes sense to take that path.  I may move over to Debian or look into Vagrant alternatives, but to get this done before EOL, I decided to just try a `do-release-upgrade` to upgrade the existing server in place.

<!--more-->

I tested it first locally, which worked alright, although my local setup doesn't have everything the live server does.  Then I crossed my fingers and ran the same procedure (with a few fixes) over SSH on the live server.  I think I only had a few minutes of actual downtime and things seem to be working fine, though some things, like Certbot renewals and Unattended-Upgrades, still haven't done their thing yet.

The procedure for the upgrade is basically as [Ubuntu's instructions](https://documentation.ubuntu.com/server/how-to/software/upgrade-your-release/index.html) say, but because of my setup, I had a few more things to do.  For the basic upgrade, I started by ensuring all packages of the then current OS were updated by running:

``` sh
sudo apt update && sudo apt upgrade -y
```

with my `sudo` capable user.  Since this did something, I had to reboot with `sudo reboot` before doing the OS upgrade.  Once I logged back in, the OS upgrade was then done by running:

``` sh
sudo iptables -I INPUT -p tcp --dport 1022 -j ACCEPT && sudo do-release-upgrade
```

The `iptables` bit was just in case my SSH connection broke during the upgrade, as Ubuntu automatically creates a fallback server on that port.  The actual upgrade is done by the `do-release-upgrade` part, which is an interactive process that has some prompts for anything that comes up, mainly due to changes made to configuration files.  So I had to be there watching it the whole time, waiting until it stopped moving for the next prompt.

The config files (stuff in `/etc`) that I had to deal with interactively were:

- mime.types
- sudoers
- apt/apt.conf.d/50unattended-upgrades
- ssh/sshd_config
- logrotate.d/apache2

I took the updated Ubuntu version of the MIME file since I had only modified it to add some that weren't there in 20, and those seemed to have been added since.  The others, I kept my version.  I'm hoping that there was nothing important from upstream that I needed, but I haven't noticed any problems yet.

Note: I ran the upgrade in `screen` just in case I needed to reconnect, but I didn't and `screen` made things a little confusing at the end of the upgrade process, so I'm not sure I'd recommend it for a `screen` novice like me.

At the end of the upgrade process, the script asked if I wanted it to reboot for me.  I said no because in my local testing, I found one more config change I needed to make, and it makes for less downtime if I do it before rebooting.  I'm using PHP FPM for running PHP on my site, and had modified the conf file at `/etc/apache2/conf-enabled/php7.4-fpm.conf`.  The new OS version puts a 8.1 file in `conf-available`, but doesn't enable it or try to do anything with the 7.4 conf file.  For expediency, I just modified the 7.4 file to use the 8.1 FPM server.  I did this with `sed`, like:

``` sh
sudo sed -i 's/7\.4/8.1/g' /etc/apache2/conf-enabled/php7.4-fpm.conf
sudo sed -i 's/php7/php8/g' /etc/apache2/conf-enabled/php7.4-fpm.conf
```

I then did the reboot to load the new OS myself, with `sudo reboot`.  After the reboot, I noticed that the wrong Apache MPM was running, which prevented HTTP/2 from working.  I fixed this with:

``` sh
sudo a2dismod php8.1 \
&& sudo a2dismod mpm_prefork \
&& sudo a2enmod mpm_event \
&& sudo systemctl restart apache2
```

All seems well.  My sites are all working.  I'll watch for any issues with any other services over the next few days and fix if any issues crop up.  It all went easier than I expected, other than the time and a bit of stress while it was running.

With the LTS 22.04, I can probably leave it like this for another two years.  But my Ansible won't work right and I can't easily rebuild the local VMs if I need to.  So I'm going to have to consider what I want to do there.  I'll take a look at:  if I want to switch to Debian, which still has Vagrant boxes; if I can trust a third party Vagrant box of 24.04 and it's similar enough to Digital Ocean's droplets; or if I want to use different tools there entirely.  I'm having trouble finding something that works similarly enough to my Vagrant setup.

Now that the server is upgraded and the PHP version is 8.1, I will be able to update the Symfony version my site uses to 6 or beyond.  I haven't had issues with the previous updates and hopefully this is much the same.
