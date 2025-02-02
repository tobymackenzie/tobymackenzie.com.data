---
categories: [computer]
date: 2005-10-15T08:49:45-04:00
guid: 'http://cosmicosmo.ath.cx/log/2005/10/15/boot-to-console/'
id: 73
modified: 2005-11-26T06:34:05-04:00
name: boot-to-console
---

Boot to console
===============

I'm working on getting my computer to boot to a text console at startup instead of GUI.  I had done this with previous versions of OS X, but never got around to it since installing Tiger.  I really just want to figure out how to do it, but I could save some memory and a little bit of CPU time, and add to the coolity of startup by getting this to work.

In /etc/ttys, near the top, there are two lines that say console followed by some stuff.  I commented out the second and uncommented the first.  I have the verbose flag set as well (sudo nvram boot-args="-v"), twice actually, but this doesn't work once I change the line in ttys.  I get the starting mac os x progress bar, which goes on forever instead.  If I hit command-V to boot to verbose at startup, I can get to console.  I read someone say that the progress bar screen is simply covering up the console, so I will look into disabling it.  I don't want to have to hold down command-V every time I restart, with penalty of having to hard-restart again if I forget.

For some reason, logging into >console doesn't work in Tiger.  I simply get an error message, then have 30 seconds or so to sit and wait till the login window reappears.

I should update this once I figure more out.

[Update:]I renamed /usr/libexec/WaitingForLoginWindow.  Now boot goes through verbose startup direct to a console login prompt, which often has some additional startup messages after it.  Thus startup is fine now.  I got a startaqua script gathered from macosxhints.com that allows me to start up the regular mac interface.  See http://www.macosxhints.com/article.php?story=20030716220410216 for the script and other instructions/discussions relating to this modification.  The script must be run by root.
