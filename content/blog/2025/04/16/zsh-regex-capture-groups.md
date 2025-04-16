---
categories: [computer]
date: 2025-04-16T16:13:40-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4545'
id: 4545
modified: 2025-04-16T16:13:40-04:00
name: zsh-regex-capture-groups
tags: [cli, regex, zsh]
---

ZSH regex capture groups
========================

In writing a script for the ZSH shell, I wanted to extract some bits from a string.  I looked for a regex solution, using capture groups.  I could not figure out how to do it with `sed` but I found that the `[[ ]]` format of the `test` command allows this with the `=~` operator.  If the test returns true, values are stored in a `$match` array and can be accessed like `$match[1]` and so on.

<!--more-->

In my use case, I was trying to improve on ZSH's `run-help` function.  Some of its results say things like:

```
See the section `ZLE BUILTINS' in zshzle(1).
```

Why not just show that section of that manpage directly?  So I wanted to check if the output was of that format, and if so, extract the section and manpage bits and use them to show the information I would be looking for.  After a bit of experimenting I ended up with the regex test looking like:

``` zsh
[[ "$var" =~ "See the section \`([^']+)' in ([^\(]+)" ]]
```

and the capture groups were accessed like:

``` zsh
man -P "${PAGER:-less} -Ip '${match[1]}'" "$match[2]"
```

The overall script I created using it ended up something like: 

``` zsh
autoload -Uz run-help
function h(){
	if [ -z "$HELPDIR" ]; then
		local HELPDIR="/usr/share/zsh/${ZSH_VERSION}/help"
	fi
	s="$@"
	out=`\run-help "$s" 2> /dev/null`
	if [[ "$out" =~ "See the section \`([^']+)' in ([^\(]+)" ]]; then
		man -P "${PAGER:-less} -Ip '${match[1]}'" "$match[2]"
	else
		\run-help $s
	fi
}
```

The `=~` matching also works similarly in Bash, but there the array is called `$BASH_REMATCH` instead of `$match`.
