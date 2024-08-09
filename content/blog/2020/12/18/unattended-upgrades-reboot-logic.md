---
categories: [computer, www]
date: 2020-12-18T02:09:16-05:00
date_gmt: 2020-12-18T07:09:16+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3176'
id: 3176
modified: 2020-12-18T15:07:11-05:00
modified_gmt: 2020-12-18T20:07:11+00:00
name: unattended-upgrades-reboot-logic
tags: [linux, packagemanager, problem, ubuntu]
---

Custom logic for unattended upgrades reboot
===========================================

The Ubuntu / Debian `unattended-upgrades` package has an option to automatically reboot as needed when it upgrades packages.  It will do this without user input, at a chosen time.  However, it doesn't allow for any conditions beyond need and time.  I found a need for more nuance recently, so I had to disable the built-in functionality and set up my own script on a cron job.

<!--more-->

Cogneato's CMS has a newsletter system that allows scheduling sends at any time.  Each recipient email is spaced out over time to limit problems with mail servers getting flagged for spam.  A site can have thousands of recipients, so it can take a while.  We recently found a newsletter had stopped mid-send, and soon realized that the server had rebooted due to the unattended upgrade reboot happening during its send.  It doesn't have a good way to automatically restart, so I looked for a solution to stop reboot if it was sending.

I couldn't find a built in way to have it run any sort of test condition for whether the automatic reboot option runs.  So I disabled it in `/etc/apt/apt.conf.d/50unattended-upgrades` with:

```
Unattended-Upgrade::Automatic-Reboot "false";
```

I created a simple shell script at `/root/bin/up-reboot` looking like:

``` sh
#!/usr/bin/env bash
load=`cat /proc/loadavg | awk '{print $1}'`
if [ -f /var/run/reboot-required ] && (( $(echo "${load} < 0.2" | bc -l) )) && (( $(ps aux | grep 'newsletter-script' | wc -l) < 2 )) ; then
        /sbin/shutdown -r +2
fi
```

and set `chmod 700` on the file to make it executable by root.  The `load` variable grabs the 1 minute load average from `/proc/loadavg`, with a high value being a proxy for the heavy newsletter script running.  It would also be a proxy for a lot of unexpected visitors hitting the server at that time, in which case we'd also likely not want to reboot.

The next line has three tests.  The first checks for the existance of a `/var/run/reboot-required` file, which is put there when Ubuntu / Debian are in need of a reboot.  The second checks that the load average is less than a particular value.  I couldn't figure out how to compare decimal numbers in bash directly, so I used `bc`, a math command.  The third checks to see if our newsletter script is running, by counting the number of times it appears in the running processes list.  It will always appear at least once since our `grep` command will appear in there.

If those conditions are true (need reboot, low load average, email script not running), then the next line will tell the server to restart in two minutes.  I gave two minutes in the off chance that someone is logged in in the middle of the night:  They would get a notice and have a chance to finish what they're doing or cancel the reboot.  I found that `/sbin` isn't in the `$PATH` for root's cron jobs, so I needed to specify the full path for the command.

I edited root's crontab (`sudo crontab -e`) and told it to run the script at, for example, 2:54 AM every night, like:

```
54 2 * * * test -x /root/bin/up-reboot && /root/bin/up-reboot &> /dev/null
```

It has the test to see if the script is executable, so that cron won't fail just in case it isn't for some reason.  I direct the output of the script to nowhere (`&> /dev/null`) because `shutdown` has some output, and cron would otherwise send an email (if enabled) every time the reboot is run.

It took me a little while to get it working and verified, because I had to wait for the reboot to be required several times to deal with mistakes, but it did work as desired.  That `0.2` might need to be adjusted as the server takes on more sites and / or traffic though.
