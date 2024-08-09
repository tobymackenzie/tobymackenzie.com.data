---
categories: [computer]
date: 2017-04-30T07:58:22-05:00
date_gmt: 2017-04-30T12:58:22+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1463'
id: 1463
modified: 2021-04-03T01:11:57-04:00
modified_gmt: 2021-04-03T05:11:57+00:00
name: el-capitan-macports-update
pings: ['https://www.tobymackenzie.com/blog/2017/01/04/mac-update-snow-leopard-capitan/', 'https://www.tobymackenzie.com/blog/2017/04/12/1447/']
tags: [macports, packagemanager, problem, update]
---

El Capitan Macports update
==========================

Finally updated [Macports](https://www.macports.org/) on my system after [updating my OS](https://www.tobymackenzie.com/blog/2017/01/04/mac-update-snow-leopard-capitan/) in December.<!--more-->  Macports itself only works with the OS version it was installed for, but enough of the ports worked as is to allow me to develop locally.  Except, apparently, I hadn't tried to build styles on this machine, because [SASS](http://sass-lang.com/) wasn't working.

Macports is kind of a pain to update for a new OS.  It has to be downloaded from the website rather than updating itself like many softwares these days.  The update process is a series of steps from their website, including `curl`ing a script, rather than something built into the software.  All ports have to be uninstalled and then reinstalled.

Some of my ports didn't install at all because they are obsolete.  Macports now seems to enforce specifying version numbers on packages, so the bare package name is for a particular version that may be obsolete.  For example, 'npm' means a version of `npm` 2.x, obsolete.  'npm2' means the most recent version of `npm` 2.  'npm4' means the most recent version of `npm`.  They can't just have the bare name mean the "stable" version and numbers mean other versions like they used to.  I guess I can see some advantages to that, but it's a pain when for most of the packages I just want latest stable and have to look up which version to get and might not know the difference between the versions.

Several other pieces of software have to be updated separately from the OS as well to get Macports working.  XCode has to be updated.  XCode command line tools has to be updated separately from XCode.  Java has to be installed (apparently `node` requires it through a dependency).  Each has their own agreement to read.  XCode tools have to be installed via a command line command.  Java has to be downloaded from the web.  For Java, a prompt came up telling me it needed to be installed while running the port update script, but the script didn't wait for me to install Java, just going on its merry way and not installing the depending ports.

I'm not even sure I have everything reinstalled.  I'm quite sure that I didn't do the ruby update right, because I'm now using the OS supplied version rather than the Macports one.  The software that was the main impetus for doing this whole update now.  Oh well, to figure out another time.

Doing this all [over my phone's network](https://www.tobymackenzie.com/blog/2017/04/12/1447/) emphasized how much needs to be downloaded over the internet for these updates.  Locally running software packages don't have the size concerns of the web and can find themselves being quite large.
