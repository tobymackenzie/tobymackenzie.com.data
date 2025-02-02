---
categories: [computer]
date: 2020-04-13T03:00:36-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=2791'
id: 2791
modified: 2021-09-02T23:43:16-04:00
name: color-shell-prompt-for-available-colors
tags: [cli, color, shell, style]
---

Color shell prompt for available colors
=======================================

I wanted to make my command line shell prompt to be more noticeable and nicer with some color. I wanted to take advantage of 256 colors when available, but fall back to a simpler color scheme when only 8 colors are available, and to no colors if none are available.

<!--more-->

The `tput colors` command will return a numeric value that can then be used in conditions.  So, basically, I set the prompt, and then wrap it in a color set based on the condition that matches that number of colors.

Since I have configuration for bash, fish, and zsh all in [my dotfiles](https://github.com/tobymackenzie/dotfiles), I had to figure out how to do this for all three, which each do things a little differently.

For the three shells:

Bash
-----

In bash, you set the special `PS1` variable to the value you want the prompt to contain.  It has special escape characters that can get replaced with variable values each time the prompt is rendered.

We use `tput setab` with a color number to set the background, and `tput setaf` for the foreground.  These color numbers are from a special set.  I found [a nice chart](https://en.wikipedia.org/wiki/File:Xterm_color_chart.png) to list them all and choose.  I wanted a green, and a nice one happened to be [the number 42](https://en.wikipedia.org/wiki/42_(number)#The_Hitchhiker's_Guide_to_the_Galaxy), so I went with that for the 256 color set.

``` bash
PS1="[\u:\W]>"
tputColors="$(tput colors 2> /dev/null || echo 2)"
if [ $tputColors -gt 2 ]; then
	if [ $tputColors -gt 8 ]; then
		tputFG="\[$(tput setab 42)$(tput setaf 0)\]"
	else
		tputFG="\[$(tput setab 2)$(tput setaf 7)\]"
	fi
	tputReset="\[$(tput sgr0)\]"
	PS1="${tputFG}${PS1}${tputReset}"
fi
export PS1="$PS1 "
```

Fish
----

Fish has its own syntax and you put the prompt into the special `fish_prompt` function that gets run each time the prompt is rendered.  It has a nice `set_color` method where named colors or hex values can be used.  The `-b` option sets the background.

``` fish
function fish_prompt
	set tputColors (tput colors 2> /dev/null; or echo 2)
	if test "$tputColors" -gt 8
		set_color black -b 00d787
	else if test "$tputColors" -gt 2
		set_color white -b green
	end
	echo -n '['
	echo -n -s "$USER"
	echo -n ':'
	echo -n (basename $PWD)
	echo -n ']>'
	set_color normal
	echo -n ' '
end
```

Zsh
---

Zsh is  similar to bash, except zsh has a special syntax for grabbing any of the standard 8 color palette by name, and its own escape characters for the prompt variable values.

``` zsh
autoload -U colors && colors
PS1="[%n:%1d]>"
tputColors="$(tput colors 2> /dev/null || echo 2)"
if [ $tputColors -gt 2 ]; then
	if [ $tputColors -gt 8 ]; then
		tputFG="%{$(tput setab 42)$(tput setaf 0)%}"
	else
		tputFG="%{$bg[green]%}%{$fg[white]%}"
	fi
	tputReset="%{$reset_color%}"
	PS1="${tputFG}${PS1}${tputReset}"
fi
export PS1="$PS1 "
```

Result
------

My prompt text is pretty simple, looking like `[user:directory]> `.  In actual use, this looks like:

![256 color prompt with nicer green background](https://www.tobymackenzie.com/_/wp-content/uploads/2020/04/Screen-Shot-2020-04-13-at-02.56.15.png)

or:

![8 color prompt with green background](https://www.tobymackenzie.com/_/wp-content/uploads/2020/04/Screen-Shot-2020-04-13-at-02.06.59.png)

or:

![2 color prompt with no special colors](https://www.tobymackenzie.com/_/wp-content/uploads/2020/04/Screen-Shot-2020-04-13-at-02.54.59.png)
