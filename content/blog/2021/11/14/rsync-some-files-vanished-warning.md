---
categories: [computer, www]
date: 2021-11-14T16:05:32-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3551'
id: 3551
modified: 2021-11-14T16:06:41-05:00
name: rsync-some-files-vanished-warning
tags: [fix, problem, rsync, script]
---

Rsync and dealing with "some files vanished" warning
====================================================

I use `rsync` for backups, site deployments, and other purposes where I need to sync two folders.  It took a little while to figure out, but has been great for those purposes since.  Every once in a while, though, I run into issues with it.  Recently, I set up an `rsync` script to back up most of the files on my entire computer.  Since this takes a while and the computer is actively running during the backup, things can change while it is still running.  This can lead to some errors like "rsync warning: some files vanished before they could be transferred".  Even though this is a warning, and the sync works perfectly fine, it returns a non-zero exit code.  This caused my script to stop and thus the rest of the backup activity didn't finish.

I looked for an option or simple solution to allow it to go on without complaining.<!--more-->  There is no option to the command, but there is [an official solution to the problem](https://git.samba.org/?p=rsync.git;a=blob_plain;f=support/rsync-no-vanished;hb=HEAD), a series of `bash` commands to trap that particular exit code.  To make it easier to use in my script, I turned it into a function, which looks like:

``` bash
_sync() {
	set -o pipefail
	local prefix=''
	if [ -x "$(command -v caffeinate)" ]; then
		prefix='caffeinate'
	fi
	$prefix rsync "${@}" 2>&1 | (egrep -v "^(file has vanished: |rsync warning: some files vanished before they could be transferred)" || true)
	local r=$?
	if [[ $r == 24 ]]; then
		r=0
	fi
	return $r
}
```

and can be used in place of `rsync` anywhere after it's defined in the script.  This might look like:

``` bash
_sync -av --delete --link-dest='../_latest' sourcePath desetPath
```

My new Mac (2020 Macbook Air) kept sleeping the disk or something when I left it to go by itself during the sync.  Macs have the `caffeinate` command to prevent the computer from going into various or any sleep states.  Putting it before `rsync` ensured that it continued running without interruption from sleep.

This worked just fine for my backup script.
