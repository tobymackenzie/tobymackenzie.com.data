---
categories: [computer, www]
date: 2021-12-07T15:22:52-05:00
date_gmt: 2021-12-07T20:22:52+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3570'
id: 3570
modified: 2021-12-07T15:22:52-05:00
modified_gmt: 2021-12-07T20:22:52+00:00
name: git-info-alias
tags: [git]
---

Git info alias
==============

I do a lot of management of work and personal projects with `git`.  I've been making shell and gitconfig aliases to make things that I do often quicker or to store logic of things that I won't remember easily.  One recent one that I really like is a `git info` (or `g i`) alias that shows `status` and a number of other bits of information about the repository quickly with one command.  I've been using it in place of `status` most of the time.

<!--more-->

My gitconfig (`~/.gitconfig`) in [my dotfiles](https://github.com/tobymackenzie/dotfiles) contains something like:

```
[alias]
	info = !"cd -- ${GIT_PREFIX:-.} && ( \
		echo '==stat' && git status -sb ; \
		[[ $(git rev-parse HEAD 2> /dev/null) != 'HEAD' ]] && echo '==branches' && (git for-each-ref --color --format='%(color:red)%(HEAD) %(color:reset)%(refname:lstrip=-1)%(color:reset);%(color:green)%(committerdate:format:%y%m%d-%H%M)%(color:reset);%(if)%(push)%(then)[%(color:red)%(upstream:lstrip=-2)%(if)%(upstream:track)%(then) %(color:reset)%(upstream:track)%(end)%(color:reset)] %(end)%(subject)' --sort -committerdate refs/heads/ | column -t -s ';') ; \
		[[ $(git remote -v) ]] && echo '==remotes' && git branch -r --color && git remote -v ; \
		[[ $(git rev-parse HEAD 2> /dev/null) != 'HEAD' ]] && echo '==commits' && git --no-pager log --date=format:'%y%m%d-%H%M' --pretty=format:'%C(green)%cd: %C(reset)%s %C(bold brightblue)<%an> %C(brightyellow)%h %C(reset)' -5 --color && echo '' ; \
		[[ $(git stash list) ]] && echo '==stashes' && git stash list --color --pretty=format:'%C(yellow)%gd %C(green)%cs%C(reset): %<(70,trunc)%gs' ; \
		[[ $(git tag -l) ]] && echo '==tags' && (git for-each-ref --color --count 5 --sort -creatordate --format='%(color:bold green)%(refname:short)%(color:no-bold brightyellow) %(if)%(*objectname)%(then)%(*objectname:short)%(else)%(objectname:short)%(end)%(color:reset) %(creatordate:short)' refs/tags) ; \
		[[ $(git submodule status) ]] && echo '==submodules' && git submodule status \
		) | less -FrSX"
	i = info
```

This shows the short `status` and then several other sections only if they have any information.  The other sections are: branches, remotes, commits, stashes, tags, and submodules.  The output might look something like:

[![`git info` command shows basic info about git repo](https://www.tobymackenzie.com/_/wp-content/uploads/2021/12/Screen-Shot-2021-12-07-at-15.03.29-1024x771.png)](https://www.tobymackenzie.com/_/wp-content/uploads/2021/12/Screen-Shot-2021-12-07-at-15.03.29.png)

This provides most of the basic info about the current state of the repo that I often need at a glance.

I spent some time getting things formatted as I wanted, with the balance of conciseness and verbosity to my liking.  I will likely tweak it further as I use it more.
