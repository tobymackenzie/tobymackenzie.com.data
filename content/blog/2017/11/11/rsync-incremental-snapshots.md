---
categories: [computer, www]
date: 2017-11-11T02:15:19-05:00
date_gmt: 2017-11-11T07:15:19+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1666'
id: 1666
modified: 2022-02-13T22:19:51-05:00
modified_gmt: 2022-02-14T03:19:51+00:00
name: rsync-incremental-snapshots
tags: [backup, rsync, script]
---

Rsync incremental snapshots
===========================

I have been using `rsync` for backup and other things for a long time.  It has a `link-dest` option that allows doing incremental snapshots similar to [Time Machine on Macs](https://en.wikipedia.org/wiki/Time_Machine_(macOS)).

<!--more-->

With this method, each backup is a separate folder with a full snapshot of the source folder.  However, only the changed files from the last backup are transferred and take up additional disk space.  This is done using hard links, allowing any backup folder to be deleted without affecting the others.

Here is a simple bash script based on scripts that I use:

```
#!/bin/sh
DATE=`date +%Y%m%d-%H%M%S`
rsync -e ssh --rsync-path='sudo rsync' -aPvx --delete \
--link-dest='../_latest' --modify-window=10 $1 $2/tmp-$DATE \
&& mv $2/tmp-$DATE $2/$DATE \
&& ln -nfs $2/$DATE $2/_latest
```

It takes two arguments, a source and destination, which are much the same as the `rsync` arguments except that the destination will have each backup in a folder with a date stamp name.  `_latest` will symlink to the latest.  It's set up for the source to be remote and to run via `sudo` on the remote so it will have root privileges.  If you don't want that, you can remove the `-e ssh --rsync-path='sudo rsync'` part.

Running would look like:

```
myscript foo@tobymackenzie.com:~/important-files/ backups/important-files
```

[rsnapshot](http://rsnapshot.org/) does something like this on a cron-like schedule, removing snapshots after a certain number.  It is more of a computer wide setup though, with a configuration file and daemon.
