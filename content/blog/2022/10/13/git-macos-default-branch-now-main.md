---
categories: [computer, www]
date: 2022-10-13T15:06:02-04:00
date_gmt: 2022-10-13T19:06:02+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3848'
id: 3848
modified: 2022-10-13T15:20:09-04:00
modified_gmt: 2022-10-13T19:20:09+00:00
name: git-macos-default-branch-now-main
tags: [change, development, git, mac]
---

git: MacOS default branch now "main"?
=====================================

At some point recently, `git init` on my Mac has started to default to the branch name "main".  It did this for a repo I created today, but not for one created August 29th, so maybe Apple made a change in an update sometime between then and now.  I haven't been able to find anything about the change on the web though.

<!--more-->

I'm running MacOS 12.6 with the OS supplied git 3.7.0.  I have no `init.defaultBranch` in my ".gitconfig".  If I run `git config --show-origin --get init.defaultBranch`, I get:

```
file:/Library/Developer/CommandLineTools/usr/share/git-core/gitconfig	main
```

So that implies a change in the command line tools supplied by Apple.  I have git 3.7.3 on my Fedora install, and it still defaults to "master".

The dev community in general has been moving to "main" to avoid some negative connotations of "master".  The word "main" makes sense for what that branch is, especially for newbies.  I've been considering moving, but waiting for it to officially change with the git project.  However, if my built in `git` uses "main", I might as well use it, at least for new projects.  I'll probably still wait for it to change upstream before I move my existing projects.  And then I'll have to figure out how renaming branches works with Github and Packagist, and perhaps Composer.
