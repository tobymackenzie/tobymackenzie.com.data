---
categories: [computer, www]
date: 2024-03-31T00:43:51-04:00
date_gmt: 2024-03-31T04:43:51+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=4290'
id: 4290
modified: 2024-03-31T23:38:18-04:00
modified_gmt: 2024-04-01T03:38:18+00:00
name: xz-backdoor
tags: [development, homebrew, mac, opensource, php, problem, security]
---

xz backdoor
===========

Reading this weekend about a backdoor introduced to the open source `xz` project.  It doesn't appear to affect my Ubuntu servers, so I had assumed it wasn't relevant to me.  However, the homebrew version on my Mac was "vulnerable".  It sounds like the exploit would only work on some versions of Linux, but if it does work on Macs, that could be bad.  I do a lot of stuff on this computer, including banking, email, coding, etc.  They know about it backdooring `ssh`, but if there's something they don't yet know about, it might be a problem.

I have a Fedora install as well.  I haven't checked it yet, but Fedora is usually on the bleeding edge, so if it's on there, I'll probably wipe and reinstall.  I've been considering anyway.  Luckily, I don't do anything important on there.

Even if it didn't actually do anything bad on the Mac, it may have done something.  I had noticed some weeks or months ago (I can't remember when) that running PHP on the command line was going slow.  Running anything would take a minimum of about five seconds, including something simple like `php -r 'echo "hello\n";'`.  I know when I had been making scripts in the past they hadn't been taking long at all.  I did some searches on the web for anybody mentioning something like that and couldn't find anything.  So I kinda just figured maybe it had something to do with the new opcode / whatever cacheing newer versions do or something, like it takes some initial setup that the server can reuse but not the command line.  I assumed I was stuck with it and even started moving some scripts to `bash` partly because of it.  When I downgraded `xz` via homebrew though, I decided to test it.  `time` says the simple `php -r` line took 0.092 seconds.  Nice and snappy.  So maybe `xz` was doing some checks to see if the device was exploitable.  It was in the dependency graph of PHP through `curl` and `gd`.  Can't say for sure that it just sped up though and if the `xz` change was what caused it.

I'm glad my scripts finally run quickly again, but hope that nothing was exploited here.  I'll keep an eye on the web to see if anything comes up about Macs being exploitable, and if so I'll probably reinstall the OS to be safe.

Note: If you have used homewbrew to install PHP, curl, or anything else that might depend on `xz`, run `brew update; brew upgrade` to be safe.  The dangers of being on the bleeding edge I guess.
