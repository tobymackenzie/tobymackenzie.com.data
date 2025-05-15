---
categories: [computer]
date: 2025-05-15T00:48:34-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4558'
id: 4558
modified: 2025-05-15T00:49:29-04:00
name: mac-15-4-rsync-issues
tags: [mac, problem, rsync, update]
---

Mac: 15.4 rsync issues
======================

After running into some problems with some `rsync` scripts recently, I discovered that in Mac OS 15.4, Apple switched its built-in `rsync` command from standard `rsync` to the BSD project's clone, `openrsync`.  It is apparently not 100% compatible, because my backup and deploy scripts that use it were failing.

<!--more-->

I was running into errors like:

```
… copy_file dfd: openat: Too many open files …
… empty link …
… error: unexpected end of file …
… stat: No such file or directory …
```

that ultimately led to:

```
Backing up … failed.
```

and incomplete backups.

I still haven't gotten all my scripts fully working and am trying to figure out what is wrong with them.  My backup scripts [use hard links for incremental snapshots](/content/blog/2017/11/11/rsync-incremental-snapshots.md) via the `--link-dest` option, which doesn't seem to work as well with `openrsync`.  In particular, I have associated it with the `Too many open files` error on large backups.  I saw some posts suggesting setting a high `ulimit -n`, but that didn't work for me.  I have disabled `link-dest` and just gone with simple sync for those scripts for now, which worked fine.

Also, I did a simple, one file local test of `link-dest` and for some reason I was getting a copy of the file every other run even when it wasn't modified.  I tried backup of the same file using `openrsync` with `cp -l` instead of `link-dest` for rotation and it copied the unmodified file every time with that, so maybe it's just be something with APFS.  Anyway, `link-dest` snapshotting may not be as space efficient as it could be.

Some of my sync scripts ran into the `No such file or directory` or `empty link` errors.  Apparently, `openrsync` won't blindly copy symlinks that have no destination.  I had to remove some pointing to things that no longer existed and hide some from the sync that needed to be there.

Also, based on my search for fixes, `openrsync` may have problems with dirs without trailing slashes in exclude directives. I added trailing slashes to any dir-names in my exclude files.

Regular `rsync` can be installed using Homebrew (`brew install rsync`), which will give a much newer version than MacOS had.  I may go this route to fix some of my regular user scripts.  However, I have some backup scripts that must be run as root (backing up multiple user dirs and other stuff), and I don't want to run "third-party" code with my root user.  So, I may have to do more work to get `link-dest` snapshots working properly for those larger backups.
