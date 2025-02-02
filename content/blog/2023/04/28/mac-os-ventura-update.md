---
categories: [computer, www]
date: 2023-04-28T16:03:19-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4013'
id: 4013
modified: 2023-04-28T16:03:19-04:00
name: mac-os-ventura-update
tags: [homebrew, mac, os, ssh, upgrade]
---

Mac OS 13 Ventura update
========================

I recently updated to Mac OS version 13 (Ventura).  It mostly went smoothly, but there were a few issues of note, including an SSH key problem.

<!--more-->

One of the first things I noticed after the update was an app called "FreeForm" automatically added to the dock.  It does sound slightly interesting, but I haven't tried it yet, and have removed it from the dock.  Advertising of sorts I guess.

The System Settings app was completely changed to be more like the iOS equivalent.  It is kind of nice to have a sidebar for selecting which setting pane we're in so we don't have to go back to a main list to change every time.  Things have been moved around quite a bit, so it's not always easy to find things.  Luckily, the search seems to be improved to more accurately find what we're looking for.  There are some new settings that weren't there before, though also some have been removed.  My mom uses  an automatic boot / shutdown schedule, but that has now been removed and can only be accessed via command-line.  She couldn't get that to work, so her computer is stuck on a particular schedule.

As with all full version updates, I, as a developer, needed to upgrade homebrew.  This seemed to be simpler than in the best.  I was able to update the XCode tools directly from system update.  Then I just ran `brew update` and everything was good.

Also as a developer, I quickly noticed that I couldn't log in to some old servers via SSH.  Apparently, the new Mac version ships with a new OpenSSH version, which doesn't support RSA keys generated with the SHA-1 algorithm by default.  The solution was to [enable it in SSH config](https://superuser.com/a/1749370), like:

```
Host old.com
	HostkeyAlgorithms +ssh-rsa
	PubkeyAcceptedAlgorithms +ssh-rsa
```

In general, it would be good to upgrade to a newer key with a more secure algorithm.  However, I need to get into some servers that don't seem to support newer algorithms.  Anyway, I would have to get into them once with the old algorithm to update the authorized keys regardless.

I think a few bugs from the past were fixed or improved.  I haven't had problems with software update freezing while "Checking for updates", for instance.  I've had fewer problems with switching users.

Other than those, I think most things are largely the same before.  Or I can't remember at this point and have worked around any other problems.
