---
categories: [computer]
date: 2020-03-16T01:25:42-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=2705'
id: 2705
modified: 2020-03-16T01:48:30-04:00
name: midnight-commander
tags: [app, cli, file-manager]
---

Midnight Commander
==================

I discovered and played with the CLI text based file browser [Midnight Commander](https://midnight-commander.org/) this weekend.<!--more-->  It seems kinda cool; lightweight, fast to operate with the keyboard, but also has mouse support.

It took me a little while to figure out the keyboard controls, and I'm not sure I entirely like the setup, but I made a few changes to the settings to improve things.

- In order to open files normally when hitting return on a file or double clicking, I went to 'Pull Dn > Command > Edit Extension File' and at the very bottom, put:

	```
	default/*
		Open=(open %s &)
		View=
	```
- In 'Pull Dn > Options > Configuration', I disabled 'Use Internal Edit' so that I could easily edit with `vim`.
- In 'Pull Dn > Options > Panel options', I enabled 'Lynx-like motion' for simple left-right arrow key movement into and out of directories.
- In 'Pull Dn > Options > Appearance', I switched to the 'modarcon16-defbg' skin, which is dark with green highlights.

Discovering that I can hit `Esc-{number}` instead of `F{number}` helped out on my laptop keyboard.

I'm playing with disabling 'Command prompt' in 'Pull Dn > Options > Layout',  so I can type the name of a file / folder to jump to it, as well as use some of the `Alt` key commands that on Macs end up being typed special characters on the command prompt.  `Ctrl-o` can be used to quickly switch to a shell in the current directory.  However, it's broken when `mc` is invoked from `fish`, which is my primary shell.

I'm not sure if I'll actually switch away from using the Finder as my primary file manager, but it is cool.  I will play with it some more and possibly add the config to [my dotfiles](https://github.com/tobymackenzie/dotfiles).

I've also read about [ranger](https://github.com/ranger/ranger) as another terminal file manager option.  It uses `vi` keybindings, so I may like it better since I like `vim`.  Will have to try it out another day.
