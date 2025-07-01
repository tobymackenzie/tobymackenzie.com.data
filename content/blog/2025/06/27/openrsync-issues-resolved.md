---
categories: [computer]
date: 2025-06-27T17:07:45-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4591'
id: 4591
modified: 2025-06-27T17:07:45-04:00
name: openrsync-issues-resolved
tags: [fix, mac, problem, rsync]
---

Openrsync issues resolved (I hope)
==================================

I think I have finally worked through and fixed [the issues caused by Mac OS 15.4 switching from rsync to openrsync](/content/blog/2025/05/15/mac-15-4-rsync-issues.md).  With the switch, many of my backup and other rsync scripts broke, throwing errors and not finishing the sync.  As of that last post, I had gotten things mostly working, but had to disable incremental snapshotting and still sometimes had failures that I had to deal with.

Some of the errors I've had include:

```
… copy_file dfd: openat: Too many open files …
… empty link …
… error: unexpected end of file …
… No such file or directory …
… opendir … failed: Interrupted system call …
```

For `Too many open files`, I had to reduce the file count in my really gigantic backups.  Instead of backup up the entire `/Users` directory, I made a loop to do each user separately.  I also excluded various cache directories and the like that have lots of files that aren't important for a backup.  It took searching and repeated runs to find and add enough such folders to the list.  These include:

```
rsync … \
--exclude '.brew' \
--exclude '.cache' \
--exclude '.node-gyp' \
--exclude '.npm' \
--exclude '.pnpm-store' \
--exclude '.sass-cache' \
--exclude 'node_modules' \
--exclude 'Data/Library/Caches/' \
--exclude '/Library/Application Support/Adobe/Fireworks CS6' \
--exclude '/Library/Application Support/Amazon Music' \
--exclude '/Library/Application Support/Firefox/Profiles/*/storage' \
--exclude '/Library/Application Support/Chromium/*/Service Worker/CacheStorage' \
--exclude '/Library/Metadata/CoreSpotlight' \
--exclude '/Library/Caches' \
--exclude '/Library/Cookies' \
--exclude '/Library/Logs' \
…
```

For `unexpected end of file`, I had to add the `--inplace` option.  I think this has some risks to it.  The man page mentions possible issues with hard links:  Not sure if that relates to the `--link-dest` option and if it may cause overwrites of previous snapshots or anything like that.  But I needed it for the incremental snapshots to work at all.

For `Interrupted system call`, there were certain folders, mostly in user library folders, that I found I needed to exclude.  The error message unfortunately gave no hint to where the error happened in the filesystem, so I had to do a time consuming process to find the problem files.  I excluded large folders until things worked and then added back items within those until I had added back what wasn't causing the error, up to the amount of time I was willing to spend going deeper or when I was dealing with folders whose content didn't matter for backup.  I don't remember all of them, but I believe they included:

```
rsync … \
--exclude '/Applications' \
--exclude '/Library/Application Support/iTerm2' \
--exclude '/Library/Containers/com.apple.Safari/Data/Library/Caches' \
--exclude '/Previously Relocated Items*' \
…
```

As mentioned in the previous post, for `empty link`, I had to remove or exclude symlinks that weren't pointing anywhere.  Some of those were for stuff that does point to something when shared with a virtual machine, which had to be excluded.  Others were simply links whose originals must've been removed at some point or whatever, and could be removed without issue.

For many use cases, using the homebrew version of rsync (`brew install rsync`) will be the normal version and not have these issues.  But I don't want to run homebrew stuff with my root user, and I need to use the root user to broadly back up all of my users' data at once.

I'm not sure why Apple had to switch to openrsync, and I'm not sure why openrsync has so many troubles that regular rsync doesn't.  It took up a fair amount of my time and frustration to get things fully working again.  But I'm glad I seem to have solved the issues.
