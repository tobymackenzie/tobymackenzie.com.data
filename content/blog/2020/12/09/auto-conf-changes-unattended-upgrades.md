---
categories: [computer, www]
date: 2020-12-09T03:02:23-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3159'
id: 3159
modified: 2020-12-17T01:54:23-05:00
name: auto-conf-changes-unattended-upgrades
tags: [hosting, linux, packagemanager, problem, ubuntu]
---

Automatically deal with conf changes using unattended-upgrades
==============================================================

For Ubuntu servers, I use the `unattended-upgrades` package to automate keeping the system and packages up to date.  I recently noticed some of Cogneato's servers showing packages needing to be updated for multiple days.  When I looked in `unattended-upgrades.log` (in folder `/var/log/unattended-upgrades/`), I found the message "WARNING Package something has conffile prompt and needs to be upgraded manually".  Basically, there was a change to a configuration file and it didn't know how to handle it.

<!--more-->

Wanting to ensure that the server would continue to update even if we were on vacation or didn't notice the problem for a while or whatever, I looked up what could be done to have it handle these types of updates automatically.  I found two useful `dpkg` options that could be added to the `unattended-upgrades` configuration to tell it how to handle the situation:

- `--force-confdef` tells it to apply the new changes if we haven't modified the conf file in question.  This just seems to make a lot of sense: if we aren't managing it, let the OS maintainers continue to do so.
- `--force-confold` tells it to keep the old file if we have modified it.  Thus, if we're managing it, we continue to do so.  This will only be a problem if there's some serious problem with the existing config, like a security issue, and we don't notice because it's automated, or if there's a breaking change in the software for the old config syntax or options and the software breaks.

With both, we ensure that it will be able to move forward with the package updates regardless of the conf situation.  This can be added to the `/etc/apt/apt.conf.d/50unattended-upgrades` file as:

```
Dpgk::Options {
	"--force-confdef";
	"--force-confold";
}
```

This worked, and I added it to my own server configuration.
