---
categories: [computer]
date: 2007-06-16T00:37:16-05:00
date_gmt: 2007-06-16T05:37:16+00:00
guid: 'http://cosmicosmo.ath.cx/log/2007/06/16/mac-drive-troubles-now-using-ubuntu/'
id: 149
modified: 2019-04-21T01:53:24-04:00
modified_gmt: 2019-04-21T05:53:24+00:00
name: mac-drive-troubles-now-using-ubuntu
tags: [server]
---

mac drive troubles; now using ubuntu
====================================

A few weeks ago, I came home and my iBook crashed.  One app after another gave me the spinning beachball of death, until I could do nothing but move the beachball.  I restarted, and no startup disk was recognized.  I restarted several times to no avail.  Finally I shut down and then started it up.  It booted, but then all the apps quickly started crashing again.

I booted using a Techtool 4.0.1 disk.  It was ridiculously slow.  The volume structes test took 8 hours, and told me I had a problem and needed to rebuild the structures.  I told it to do its thing.  It took another 8 hours.  Rebooting after that, my disk was no longer found again.  I gave up on the problem then, and decided to install linux so I could get my server up and running as quickly as possible (see below).

Later, I got a new version of Techtool from my mom that was on a thumb drive.  It allowed me to do much more, such as run disk utility and a terminal window.  Disk utility could not fix the disk though and I couldn't access it with terminal.  I ran its test of the volume structures.  It was crazily faster than the other one, taking perhaps 10 minutes for the test.  It went so fast I felt hopeful it could fix it.  It said there was a problem.  I fixed it and ran the test again, but unfortunately it said there was the same problem as before, a directory node missing or something like that.  I tried fixing and retesting a couple more times, but it gave the same problem every time.

I can access the files from linux, but have had no luck writing to the drive.  I imagine the old version of Techtool, as it was from the early days of OS X, did not know how to properly handle the current volume structures, so it messed them up.  I think I will need to reformat the drive and reinstall everything.  Luckily, after my previous drive problems, I have been backing up most everything weekly.  I shouldn't lose anything, though I do want to look through the drive before I erase it just to make sure.  I also want to try to find a way to only reformat the partition affected, so I don't lose my linux setup or any of its data.  I'm not sure how to do that for HFS+ without buying another utility.

Linux
-----

I had burned a Gentoo and Ubuntu CD a couple of years back to mess around with.  I never got either installed then, but this time it was more necessary.  I tried installing the Gentoo.  The installation is not directly guided at all; I had to open up a webpage (luckily the internet was no problem to get working) in one terminal window (no gui) and carry out the steps from the instructions in another.  I was going along alright, but some of the choices were a little confusing.  I came to the point where I had to compile my kernel, and decided I was spending too much time with Gentoo.  Ubuntu was supposed to be quick and easy to install, and this was only to be temporary anyway.

Ubuntu provided a guided, GUI install that was fairly easy.  The only problem I had was choosing the (prebuilt) kernel, as the default one didn't work.  I got that up and running, and it started up easily with a GUI and the internet working just fine.  It was the desktop version, though, so no server stuff was installed.  I was able to install apache2 with the package manager, but could not find php 5.  I had converted all of my site stuff to mysqli, so I needed php 5:  I certainly wasn't going to go through my files and change all the pertinent lines for a temporary server.  Searching the web, I found php 5 available for the Edgy and some other versions of Ubuntu.  I was confused as to what those different versions were, at first thinking each one was of a progressively more unstable branch.  I changed my repositories that I was getting packages from to one that had php 5, after figuring out how to do that.  It wouldn't let me install because it said there were some dependency problems.  By this time I figured the different word versions of the OS were actually newer and newer revisions, like Jaguar and Tiger for OS X.  So I figured if I installed the entire new version with the package manager, then all the dependencies should be met.  It took quite some time to download and install all those files, and it gave some errors before completing.  At that point, things like the GUI started breaking.  I tried hard to fix the problem, including manually removing some package files, but it kept giving me errors.

I got the GUI back up and running just so I could burn another CD of a new version of the OS.  I figured that then all the dependencies should be met no problem.  I downloaded not quite the newest version though, as the newest couple of versions didn't seem to mention the need mysqli in their depository (I now think mysqli is installed automatically with the mysql php extension in these versions).  I downloaded the server version so that I could hopefully have a server running right from install.  It took me some time to find a program that would let me burn a CD, but I finally got it burned.

Installing was about as easy as with the Desktop version, save for one screen where I had to manually select to install the web server, which I skipped the first two times through.  To my delight, after the install, not only was an apache 2 server up and running, but so was a MySQL server, and PHP 5 with mysqli was already installed.  After figuring out how to mount UFS (that took some time as well), I copied my site files over to the linux partition and easily got my site running.

Unfortunately, the server version wasn't set up out of the box for my own regular use.  It had no GUI at all.  I used the package manager to install KDE, as KDE seems to have more applications that come with it.  It took a good bit of time to set that up so it would actually work.  It didn't just work like it had when the desktop version was installed; it took some messing around with configuration files.  When I finally got that working, it still was not working fully properly; I still have a desktop that is bigger than my actual screen, so I have to drag the mouse to the sides and move it to see the rest.  This is very annoying to work with.  I also have no sound.  Other than that, though, it works just fine.

Linux seems to work quite nicely.  It has plenty of good applications available, of course for free.  I was able to work with all my important Excel files in OpenOffice with the only problem being that if I made changes, I had to save them in the OpenOffice format.  I was surprised that the Control-enter functions worked.  After downloading several extensions, I've been able to get firefox to work mostly the way I want for browsing.  Safari still works better in some ways as I had it set up, but there are a lot of cool things that can be done with firefox extensions that can't be done in Safari.  Kate is a very nice text editor, though unfortunately I've not been able to find anything with live PHP previews like Taco Edit.  It of course has desktop paging, which I never got working nicely in OS X.  App launching has been a problem though.  I'm used to Butler.  Linux has Katapult, but it is not nearly as good and is very slow.  File browsing is quite nice for the most part.  The image browsing capabilities of Konquerer far exceed those of the Finder.  I miss the Next-like columns view though.