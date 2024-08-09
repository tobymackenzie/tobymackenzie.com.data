---
categories: [www]
date: 2014-05-05T00:57:58-05:00
date_gmt: 2014-05-05T05:57:58+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=603'
id: 603
modified: 2014-05-05T00:57:58-05:00
modified_gmt: 2014-05-05T05:57:58+00:00
name: the-happs-2
tags: [dotfiles, fish, happs, shell, zsh]
---

The Happs
=========

Shell Games
-----------

I have been toying with some shell alternatives to bash; [fish](http://fishshell.com/) and [zsh](http://zsh.sourceforge.net/).  Auto-suggestions were the main draw, though there are other features as well that are nice to have.  I especially like the auto-suggestions functionality that fish provides.  I have tried to get similar behavior in zsh, but haven't been able to get something going that doesn't have problems of some sort.  Another feature I like is implicit `cd`, where you can change to a directory simply by typing its path.

zsh is really configurable and also mostly bash compatible, so I can use the same config files for both.  fish requires its own syntax, so I must use separate config files.  zsh is also more commonly installed than fish.  For these reasons, I would like to move to zsh, but the auto-suggestion problems have led me to go with fish for now.

Dotfiles
--------

My shell experiments have led me to release [my dotfiles](https://github.com/tobymackenzie/dotfiles) as open source.  I had previously had a much simpler dotfiles setup that I never released openly.  My new dotfiles project was mostly written from scratch, with a much more advanced setup script and file organization.  I'm maintaining as close to the same configuration as possible between bash, zsh, and fish, and attempt to deal with differences between Linux and Mac OS X.

I have a `dotfiles` script for setting things up.  It symlinks all the relevant files into the home folder.  I wrote it in PHP since I know it well and can do OO stuff in it.  I have the actual dotfiles plus files they include/reference separated into folders by application / shell.  Each folder has a 'dotfiles.json' file that defines which files are to be symlinked into the home folder (or other path, if necessary), so that I can have other files mixed in with the dotfiles without the install script paying them any attention.

Looking at some other peoples' dotfiles, I have improved and added some new functions, aliases, and other features.  For instance, I found some neat `git log` functions that gave some really nice output and modified them to my liking (see [my vcs.sh](https://github.com/tobymackenzie/dotfiles/blob/master/sh/commands/vcs.sh)).  There were a bunch of other neat things I've found but haven't added.

I put a lot more time into this than I wanted, but am happy with the results.  It has brought some improvements to my shell experience and made it easier to share this experience across devices.  I still have places I have to log into that I can't install my dotfiles (namely the servers at work), but for my computers and my server, it has been really nice.

I would like to do something similar with other configuration that isn't "dotfiles", such as for Sublime Text and other desktop application.  I just have to figure out a good way to do it in an organized fashion.  I'm not sure if I'd want that mixed in with my dotfiles or if I'd want a separate repo.  Not sure if I'd want a repo per OS either, maybe with a shared repo for things on multiple OS's.
