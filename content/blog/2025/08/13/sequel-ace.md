---
categories: [computer, www]
date: 2025-08-13T15:46:05-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4631'
id: 4631
modified: 2025-08-13T15:46:05-04:00
name: sequel-ace
tags: [app, database, development, mysql]
---

Sequel Ace
==========

I finally moved from Sequel Pro to [Sequel Ace](https://github.com/Sequel-Ace/Sequel-Ace).  Sequel Pro hasn't been updated in years.  It mostly worked but did have some annoying problems.  During a recent OS and app reinstall, I found that Sequel Pro was no longer available on Homebrew, so I went for Sequel Ace, a fork that is still maintained.  It is very similar but improved.  I like it.

<!--more-->

Sequel Pro and Ace are both open source GUIs for working with MySQL databases.  They can show query results in a grid sort of like an Excel file.  I had experimented with using the [command line](/content/blog/2024/06/24/readable-query-output-in-mysql-cli.md) for database operations, but it is just too hard and slow to read large amounts of data and navigate through it frequently.  The GUI also makes quick changes to a displayed set of data a lot easier.

I don't remember choosing Sequel Pro whenever I first did, but one reason I would've is that it allows MySQL connections through SSH, so that I can lock down the server more.  That was done at Cogneato even before I got there and I've done the same for my servers when I moved to VPSs.

When Sequel Pro stopped getting updates I looked a bit at other options.  I had seen Sequel Ace was a fork and possible successor a while back, but wasn't sure if I could trust it.  At this point it definitely has developer movement behind it and it's available on Homebrew.  Not having Pro available anymore pushed me over the edge.

I wasn't able to copy my settings from Pro since I hadn't exported them before the switch, but if I were planning it, I could've exported and then imported.  At least Ace has roughly the same interface for configuring connections.  One issue I ran into:  Ace has more locked down local file access, so I had to add my ssh config and public key in the preferences.

Ace looks a lot like Pro but a little more refined.  My biggest issue with Pro was fixed in Ace:  Crashing when closing tabs or windows.  Also fixed:  In Pro I wasn't able to make some changes to my saved queries.  I'm sure there are others I don't remember.

A new feature (or at least I don't remember it in Pro) is an ability to add a "trigger" for a saved query, where typing configured characters and then pressing tab will convert to a saved query.  This speeds up running frequently run queries a lot if I can remember my triggers.  Accessing them is slow otherwise.  There is also dark mode support and some polishing to the interface.  Looks like there are some speed and a few other minor improvements here and there, some things I haven't used.

Sequel Ace is pretty much Sequel Pro with some fixes, improvements, and continued development.  I kinda wish now I had jumped over sooner, but it's hard to know where things are going when an open source project just dies.  Hopefully Sequel Ace keeps going.
