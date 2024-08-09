---
categories: [computer, www]
date: 2024-02-09T22:50:11-05:00
date_gmt: 2024-02-10T03:50:11+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=4244'
id: 4244
modified: 2024-02-09T22:59:14-05:00
modified_gmt: 2024-02-10T03:59:14+00:00
name: vim-terminal-mode-config
tags: [configuration, text, vim]
---

Vim terminal mode config
========================

Vim has a couple ways to run terminal commands from the editor.  From ex command mode, `:!` will allow running a single command before breaking back to Vim, while `:term` will open a new terminal window within Vim, by default in a split, to run as many commands as you want.  There are several settings in [my `vimrc`](https://github.com/tobymackenzie/dotfiles/blob/1f1a6eca88631b64f464c71aad6dc461d816b072/vim/vimrc) that I add to make working with these terminal modes easier and nicer.  I will share some of them below.

<!--more-->

Quicker access
------

I've been using the leader key, which I have set to space, plus another character to make frequent or more verbose commands / tasks quicker and easier.  `:!` and `:term` are just long enough to make me want a quicker key for, so I've used `t` and `T` with leader to access them respectively.  That looks like this:

``` vim
nnoremap <leader>t :!
nnoremap <leader>T :tab term<cr>
```

in my `~/.vimrc`.

Shell aliases
--------

With GUI Vim (eg MacVim / gVim), CLI aliases and other Bash shell settings don't work from the `!` shell by default.  Vim uses a `$BASH_ENV` variable to define a file that will be loaded for Bash configuration for that shell.  That looks like:

``` vim
let $BASH_ENV = "~/.vim/bashenv"
```

in my `~/.vimrc`.  In that `bashenv` file, which is Bash syntax like a `.bashrc`, we must run `shopt -s expand_aliases` to force it to support aliases for Vim.  We also need `PS1='>'` in there so that Bash believes we're interactive, and then load my regular `.bashrc`.  That looks like this in my `~/.vim/bashenv` file:

``` bash
PS1='>'
shopt -s expand_aliases
source ~/.bashrc
```

Now all my aliases and some other settings work fine.

Output colors
------

The output of `!` commands by default doesn't support colors in GUI Vim.  When running commands that force output colors, they will instead output the strings that represent the colors, making the output hard to read.  In Vim newer than `9.0.0100`, we can set a `guioptions` option of `!` to run those commands in a temporary terminal window shown at the bottom of the screen, supporting colors.  In my `~/.vimrc`, I have:

``` vim
if has('patch-9.0.0100') && has('gui')
	set guioptions+=!
endif
```

Now colors show fine, including in `less` or the like.  The only problem I've noticed is that sometimes an extra `<return>` press is required when it otherwise wouldn't be.  I've read that more significant problems can crop up with this option set, but that may be in older versions of Vim.

Colors are not an issue in CLI Vim, as it actually breaks out to the calling terminal, and thus has all of its capabilities.

`:term` normal mode
------

The `:term` terminal, to match Vim's interface, has a Normal mode to edit the current line or copy previous output.  It is accessed by pressing `<C-\><C-n>`.  Since that is not easy to remember and I want something quicker, I have mapped pressing escape twice to do the same thing.  That is not something I commonly do in the terminal normally, so it hasn't caused me problems.  That is done in my `~/.vimrc` like:

``` vim
tnoremap <esc><esc> <C-\><C-n>
```

This only works from insert mode and beeps otherwise, which is a minor annoyance that I don't run into often.  I don't use Normal mode in the terminal often in general though.  The quicker access is just nice on the occasion that I need it.

`:term` line numbers
------

In Vim, I normally have line numbers enabled for editing text files.  They are not useful and are actually annoying in a terminal window, so I disable them with an `autocmd`.  The event they are attached to is `TerminalOpen`.  I have this in my `~/.vimrc`:

``` vim
augroup TJMTermNoNum
	autocmd!
	autocmd TerminalOpen * set nonu nornu
augroup END
```

Open in current Vim instance
-------

When opening a file from the Vim terminal to be opened in Vim, by default, it will open a new instance of Vim.  This can be annoying if working in a single project and trying to keep things together.  Vim provides special escape sequences from its terminal to communicate with it.  Those can be used to tell that instance to open the specified file.  We can add something like:

``` bash
thisvim() { echo -e "\033]51;[\"drop\", \"$1\"]\007" ; }
[[ -n "${VIM_TERMINAL}" ]] && alias vim=thisvim
```

to our Bash config to override the `vim` command when inside a Vim terminal.  I have an [`ot` command](https://github.com/tobymackenzie/dotfiles/blob/1f1a6eca88631b64f464c71aad6dc461d816b072/bin/o) that I use for opening files in GUI Vim, so I put my solution in there.  I also tend to use tabs in Vim, which would require `tab drop` instead.  To support passing multiple files, I did it as a loop, which required using a function.  So the relevant part of my shell command looks like:

``` bash
if [[ -n $VIM_TERMINAL ]] && [[ -n "${@:2}" ]]; then
	for var in "${@:2}"; do
		printf '\033]51;["call", "Tapi_OpenInTab", ["'$var'"]]\07'
	done
	exit 0
else
	open
endif
```

which is in among some logic determining if we want to be using Vim to open the file(s).  That requires the loop function that I mentioned to be in my `~/.vimrc`, which looks like:

``` vim
fun! Tapi_OpenInTab(bufnum, arglist)
	echo "opening " . a:arglist[0]
	for fn in a:arglist
		execute 'tab drop ' . fn
	endfor
endfun
```

The function needed the `Tapi_` prefix to work.  Apparently it's a security feature to prevent arbitrary functions being called from the terminal.
