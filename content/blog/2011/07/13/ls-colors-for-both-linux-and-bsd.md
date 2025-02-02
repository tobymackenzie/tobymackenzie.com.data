---
categories: [computer]
date: 2011-07-13T23:25:56-05:00
guid: 'http://cosmicosmo.ath.cx/log/?p=297'
id: 297
modified: 2022-11-09T21:00:14-05:00
name: ls-colors-for-both-linux-and-bsd
tags: [bash, configuration]
---

ls colors for both linux and bsd
================================

``ls` can have nice colors enabled to differentiate between file types easily, but the parameter is different between the BSD version (uses `--color`) and the GNU Linux version (uses `-G`).  I have been setting up a "bash_profile", among other things, to be shared between my users on all the POSIX computers I use.  Some are Linux, some BSD based.  I use Bash on both, and I wanted the colors from <code>ls</code> to be used on both with the shared "bash_profile" file.  I couldn't find anyone else's solution for this, so I figured one out myself and will post it in case others want the same versatility.  I simply test `ls` with one of the parameters and see if it throws an error.  I then can set my aliases with the appropriate parameter.  I do it like so:`

``` bash
ls --color > /dev/null 2>&1
if [ $? -eq 0 ]; then
	alias l="ls -F --color"
	alias ll="ls -lh --color"
else
	alias l="ls -FG"
	alias ll="ls -lhG"
fi
```
