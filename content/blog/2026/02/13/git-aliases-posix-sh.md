---
categories: [computer]
date: 2026-02-13T13:59:32-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=4771'
id: 4771
modified: 2026-02-13T13:59:32-05:00
name: git-aliases-posix-sh
tags: [configuration, git, linux, posix, problem, sh]
---

Git aliases and POSIX sh
========================

An interesting problem I encountered when moving to use Linux more is that git aliases are often run in POSIX `sh` instead of the terminal in use, such as `bash` or `zsh`.  A few of my aliases are complex enough to require running an external shell command, ie using `!`.  Some of those have complex comparisons or verify with the user what they are doing.  I had long used some bashisms to simplify these, and didn't have problems on my Mac, which uses `bash` as the `sh` implementation, but had problems in Ubuntu, which uses `dash`.

<!--more-->

As I've done more development on a Ubuntu machine, I ran into some of my aliases throwing errors.  I ignored them for a bit, but then decided to look into it.  It took me a little bit to figure out what the actual problem was.  Ubuntu uses `dash` for `sh`, which doesn't have those bashisms I was using and is close to POSIX `sh`.  So I had to rewrite some of them to be POSIX compatible.

One such difference is that POSIX doesn't have the fancy `[[ ]]` version of `test`, which provides some more advanced comparison and other features.  String comparisons like:

``` ini
[alias]
	do = !"[[ \"$(git rev-parse HEAD 2> /dev/null)" != 'HEAD' ]] && git log || echo 'no commits'"
```

become the very similar:

``` ini
[alias]
	do = !"[ \"$(git rev-parse HEAD 2> /dev/null)" != 'HEAD' ] && git log || echo 'no commits'"
```

If the comparison were equality rather than inequality, `==` would become `=`.  This is actually a bit shorter, so it makes sense to use here.  However, the simple regex comparisons allowed by `=~` in that `test` format are not in POSIX and more complicated to implement.  POSIX does provide some regex abilities though, such as the `"${foo#[Yy]}" to remove the `Y` or `y` from the beginning of a string variable `$foo`.  So if we want to see if a string is yes-like, `[[ \"$tmp\" =~ ^[Yy] ]]` becomes `[ \"$tmp\" != \"${tmp#[Yy]}\" ]`, a trick to see if the modified string is different than the unmodified string.

Another difference is that the `read` command, used to get user input, doesn't take the `-p` option, used to print a prompt before the input.  We have to use `printf` instead.  So this:

``` ini
[alias]
	dothething = "!read -r -p \"Do you really want to do the thing?: \" tmp && ([[ \"$tmp\" =~ ^[Yy] ]] && dothething) || echo 'cancelling'"
```

becomes the slightly more verbose:

``` ini
[alias]
	dothething = "!printf '%s' \"Do you really want to do the thing?: \" && read -r tmp && ([ \"$tmp\" != \"${tmp#[Yy]}\" ] && dothething) || echo 'cancelling'"
```

POSIX doesn't have as many string parameter expansion abilities.  With `bash`, we can get the second and later arguments to a script / alias with `${@:2}`, but with POSIX, we have to use the `shift` command, which modifies the arguments list for the rest of the script.  So the simpler:

``` ini
[alias]
	vt = !"git tag \"v$1\" \"${@:2}\""
```

could become:

``` ini
[alias]
	vt = !"shift $(( $# > 0 ? $# : 0 )) && git tag \"v$1\" \"$@\""
```

The ternary thing is so that we don't error out when no arguments are provided.

I also found POSIX to be a bit more persnickety about parenthesis, though I think the way I had them was a bit more confusing anyway.

Now my aliases work in Ubuntu fine.  Using Linux more, I am probably going to go through the rest of [my dotfiles](https://github.com/tobymackenzie/dotfiles) scripts and aliases to make them more POSIX friendly.  I would not generally be using `dash` or the like as my regular shell, but may occasionally find myself there or going through other software that uses them.  It's good to be more compatible, at least when the costs aren't too high.  I might not do so for more complex things where it becomes very verbose, for instance.
