---
categories: [www]
date: 2017-08-09T00:31:37-05:00
date_gmt: 2017-08-09T05:31:37+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1573'
id: 1573
modified: 2017-08-09T01:08:03-05:00
modified_gmt: 2017-08-09T06:08:03+00:00
name: change-git-commit
tags: [change, development, git, history, versioning]
---

Change git commit
=================

To edit a git commit somewhere before the last one, use rebase with the commit hash (via [StackOverflow answer](https://stackoverflow.com/a/1186549/1139122)):

<!--more-->

``` sh
git rebase -i 'a8feIp2X^'
```

If the commit is the first, you must use the `--root` option (via [another StackOverflow answer](https://stackoverflow.com/a/14630424/1139122)), like:

``` sh
git rebase -i --root
```

Change `pick` to `edit` on the commit you want to edit.  You will be taken back to that point in the commit history.  Edit the file(s) you want changed and commit them with the `--amend` option, eg:

``` sh
git commit -a --amend
```

if you want to commit all files.  Then run:

``` sh
git rebase --continue
```

to get back to the "present" in git history (or to the next commit if you chose to edit multiple).

If the commit to change is instead the most recent one, you can omit the `rebase` commands and just edit the files and `--amend`.

History will now be rewritten.  If you have a remote branch already with the changed commit, you will have to force push to get your changes on the remote:

``` sh
git push -f
```

Note that any other repos that have cloned that remote will get a warning about the history being rewritten, and will have to force pull:

``` sh
git pull -f
```

so force pushing is not to be taken lightly.  You should only rewrite history on a remote if the change is something critical that cannot be anywhere in the commit history, like a password, or if you're the only one who's cloned the repo so far.

I've done this a handful of times and had to look it up every time, so now I'll have it on my own site.
