---
date: 2026-09-15T16:31:16-04:00
categories: [computer]
tags: [cli]
id: 4888
name: tmux
guid: 'https://www.tobymackenzie.com/blog/2026/09/15/tmux.md'
---

tmux
====

I have started to experiment with using [`tmux`](https://en.wikipedia.org/wiki/Tmux) recently.  It is a terminal multiplexer, sort of like a tiling window manager / tab bar that runs purely in the terminal.  It has decent mouse support, so it is not that different than using a GUI terminal with tabs, plus panes.  And it works and gives me roughly the same config and interface across platforms and terminal apps, including pure terminals like [kmscon](https://en.wikipedia.org/wiki/Kmscon) and potentially on remote servers.  I have been moving toward a lighter weight, simpler, more terminal heavy, dotfiles friendly setup, and this fits into that.  I spent entirely too much time getting my `tmux` configuration to my liking.
<!--more-->

I had played with [`screen`](https://en.wikipedia.org/wiki/GNU_Screen), an older alternative, a little in the past.  I like that `screen` is installed by default on Macs and most Linux distros, but it isn't as easy to work with or configure nicely, especially the quite old version that Macs have.  I will most likely just use screen on remote servers where I don't want to (or can't) install extra software, but for local use I may try using `tmux` for managing my terminals instead of GUI tabs going forward.

Install
-------

`tmux` is in package managers for most distros and Termux, and homebrew for Mac, as "tmux".  It can be installed with one of:

```
brew install tmux
sudo apt install tmux
sudo dnf install tmux
pkg install tmux
```

or whatever package manager the OS has.

Config
------

Most of the default interaction with `tmux` (as well as screen) are done by key bindings that involve hitting a key combo called the prefix, followed by another key.  By default, the prefix is `Control-b`.  That's a little hard to press, so most people change this.  I made two, one on each side of the keyboard.  I used control keys that I don't use that often for their normal terminal functions, because `tmux` overrides this and they have to be pressed twice to send the key as normal to the terminal.  My config for this looks, in `~/.config/tmux/tmux.conf`, is like:

```
set -g prefix C-f
bind C-f send-prefix
set -g prefix2 C-l
bind C-l send-prefix -2
```

To see the keys available to use, look at the man page (`man tmux`) or run `tmux list-keys -N` (the `-N` option improves the format and shows only the normal keybindings).

Since `vim` is my preferred editor, I had to turn on the `vim` mode keys with:

```
set -g mode-keys vi
```

This only affects copy mode and command mode, but is still nice.  Though it benefits from a few additional key bindings:

```
bind -T copy-mode-vi v send -X begin-selection
bind -T copy-mode-vi y send -X copy-pipe
```

Speaking of copy, to copy to the OS clipboard:

```
set -s set-clipboard external
```

To help ensure the proper clipboard is used for `copy-pipe`, I run an external script with something like:

```
run-shell -E '. ${DOTFILES:-~/.dotfiles}/sh/env.sh && tmux set -g copy-command "$(getcopy)"'
```

The loading of my dotfiles environment and passing through a shell is done because `tmux` doesn't necessarily make the environment available in the config, especially if loading `tmux` directly in a terminal rather than starting it from a shell.  I want the `$PATH` to have the folder where `getcopy` is.  That `getcopy` script looks something like:

``` sh
#!/bin/sh
if [ "$(uname)" = 'Darwin' ]; then
	echo 'pbcopy'
elif [ -n "$XDG_CURRENT_DESKTOP" ]; then
	if command -v 'wl-copy' > /dev/null; then
		echo 'wl-copy'
	elif command -v 'xsel' > /dev/null; then
		echo 'xsel -i'
	elif command -v 'xclip' > /dev/null; then
		echo 'xclip -selection clipboard -i'
	fi
fi
```

though that hasn't been thoroughly tested in varying situations.

On copy mode, it normally copies when releasing the mouse on a drag.  I find this difficult to use, so I disable that with:

```
unbind -T copy-mode-vi MouseDragEnd1Pane
```

I set the base indexes at 1 to make switching windows and panes via keyboard commands easier, like:

```
set -g base-index 1
setw -g pane-base-index 1
```

I also have altered the default appearance quite a bit.  Moving the status bar to the top is done with:

```
set -g status-position top
```

Color / style is done with a `bg=green,fg=black` type setup, which can also have comma separated attributes added, like `bold` or `italics`.  These can be set on any `-style` settings directly, or as part of `-format` settings by putting them in an escape `#[]` block, which changes the style for following text.  I wanted to set my colors differently depending on if the terminal supported 256 colors or not, so I used variables, which were a little difficult to use.  On settings with variables, I had to use `set -gF` instead of `set -g`, which also required putting `##` for any escapes that need to be dynamic.  My color conf looks something like:

```
%if "#{>=,e|#{$TJMTCOLORS},256}"
	set -g @c1Alt "black"
	set -g @c1 "green"
	set -g @c1Emph "colour47"
%else
	set -g @c1Alt "black"
	set -g @c1 "green"
	set -g @c1Emph "brightgreen"
%endif
```

That `$TJMTCOLORS` is an environment variable set to `tput colors` in my `env.sh`.  The custom "options" must all be `@` prefixed.

Then some examples using them look like:

```
set -gF status-style "bg=##{?client_prefix,#{@c1Emph},#{@c1}},fg=#{@c1Alt}"
set -gF window-style "bg=#{@c0DimAlt},fg=#{@c0Dim}"
set -gF window-active-style "bg=#{@c0Alt},fg=#{@c0}"
```

My other settings and [full config](https://github.com/tobymackenzie/dotfiles/blob/fea2b1dc4783210caf421a7e148f56029dfd2deb/tmux/tmux.conf) can be found in [my dotfiles](https://github.com/tobymackenzie/dotfiles).  The man page is pretty good at describing most things about the config options.

With all this use of the control key, I decided to finally switch my caps lock key to work as control.  For Mac, go to "System Settings > Keyboard > Keyboard Shortcuts… > Modifier Keys" and set "Caps Lock key" to "^ Control".  For kmscon, put `xkb-options=ctrl:nocaps`in `/etc/kmscon/kmscon.conf`.

Also of note, many modern terminals automatically handle scrolling in alt screens like `less`.  When I enabled `tmux`, this stopped working.  I had to set my `--mouse` in my `LESS` environment variable, eg `LESS="--mouse"` to get its own mouse capability working.  This isn't nearly as smooth or as smart as the terminal's though.

So far
------

I have switched some of my terminals to open with `tmux` directly instead of a normal shell.  I'm still getting used to the setup and remembering which keys to use for that versus `vim`, the surrounding GUI (if applicable), etc.  I like how the mouse works with `tmux` itself, switching panes and windows (working like tabs) and, with the pane border enabled, there are even buttons to zoom / unzoom and close panes.

I may see if there's more I can do with the mouse and with other bindings to make my usage easier.  I will probably tweak my color scheme, as the top bars might be a bit bright.  Also, I have some stuff set to `bold`, which in kmscon and some other terminals, is handled as `bright` instead.  `brightblack` is much different than `black`.  Will probably want to handle that differently.

My biggest disappointment so far is with the scrolling, especially of alt screens.  It isn't as smooth or nice as the capable GUI terminal apps' own abilities, even with `--mouse` enabled for `less`.  And for `ssh` I'd have to do the same thing for each remote.  That can also send a lot more traffic over the network from what I've read.

I also have had problems with selecting text with the mouse.  The copy mode won't work directly with a mouse drag in `less` with mouse mode enabled, for instance.  On Mac, I can use `fn+drag` to grab text with the terminal's own selection, but that takes more effort than just dragging.

So for now I'm just using `tmux` in some places to get a feel for if the advantages outweigh the (mostly mouse related) disadvantages.
