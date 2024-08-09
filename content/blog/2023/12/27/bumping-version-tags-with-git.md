---
categories: [computer, www]
date: 2023-12-27T17:17:05-05:00
date_gmt: 2023-12-27T22:17:05+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=4215'
id: 4215
modified: 2024-07-15T21:55:32-04:00
modified_gmt: 2024-07-16T01:55:32+00:00
name: bumping-version-tags-with-git
tags: [configuration, git, script]
---

Bumping version tags with git
=============================

It is common to use git tags to manage software version numbers.  Such tags are often done with a "v" followed by the version, eg "v1.2.3".  I decided I wanted to make managing these a little easier, so I made a git alias to make a new tag with the next version for me.

<!--more-->

I looked at various Stackoverflow and other posts for ways to manage this.  I found some nice looking git alias options that seemed to make a lot of sense.  They mostly did what I wanted, but I had to tweak them a bit to get something that I liked well and to handle the multiple parts of the version with one command.

My alias can be called as `git bump ` followed by one, two or three dots, or string `patch`, `minor`, or `major` to tell it which part of the version string to bump.  With version `1.2.3`:

- `.` or `patch` will make the version `1.2.4`
- `..` or `minor` will make the version `1.3.0`
- `...` or `major` will make the version `2.0.0`

The naming and version format follows [Semantic Versioning](https://semver.org/) conventions.  I'm not supporting extension like "rc" and "beta" because those would be hard, it's much less obvious what to do, and I don't use them on the small projects I work on anyway.

Git aliases can be put in `~/.gitconfig` (create it if it doesn't exist).  For this functionality, I added something like:

``` ini
[alias]
	versionbump = !"cd -- ${GIT_PREFIX:-.} && V=$(git tag --sort=-version:refname --list \"v[0-9]*\" | head -n 1) \
		&& if [ -z \"$V\" ]; then V='v0.0.0'; fi \
		&& if [ \"$1\" == '.' ] || [ \"$1\" == 'patch' ]; then \
				awkV='{OFS=\".\"; $NF+=1; print $0}'; \
			elif [ \"$1\" == '..' ] || [ \"$1\" == 'minor' ]; then \
				awkV='{OFS=\".\"; $2+=1; $3=0; print $0}'; \
			elif [ \"$1\" == '...' ] || [ \"$1\" == 'major' ]; then \
				awkV='{OFS=\".\"; $1+=1; $2=0; $3=0; print \"v\"$0}'; \
			else echo 'No version specified.  Specify one of patch, minor, or major.'; exit 1; \
		fi \
		&& if [ -z \"$awkV\" ]; then exit 1; else newV=$(echo $V | awk -F. \"$awkV\"); fi \
		&& read -r -p \"Do you want to tag with version ${newV}?: \" tmp \
		&& ([[ $tmp =~ ^[Yy] ]] && git tag \"${newV}\" \"${@:2}\") && echo \"Tagged version ${newV}\" \
		|| exit 1 #"
	bump = !git versionbump
	vb = !git versionbump
```

I did `versionbump` as the full name to be explicit, plus some shorter aliases to make it quick to type.  I use the `!` to run a full shell command, as I have too much going on for a straight alias.  Note my implementation depends on running in `bash` / `zsh`, and requires some common POSIX utilities such as `head` and `awk`.

The `GIT_PREFIX` part ensures this works even when specifying a different git repo.  The `git tag` part gives a list of version formatted tags and sorts them by version (the `version:refname` part ensures they are properly sorted as version strings).  The `head -n 1` gives us the first one only.  The first `if` sets the version to `0.0.0` if there isn't a version set yet.  The nested `if` structure that follows uses the argument to determine which version piece to bump, and sets the appropriate `awk` command in a variable.  `awk` does the actual string manipulation on the current version.  The next couple lines run that and then verify with the user that the version string looks right (typing anything but a "y" or "Y" cancels the bump.  If yes, then a `git tag` command is run to actually do the tagging.  The trailing `#` is needed to prevent arguments from being appended.

I like it.  Makes managing versions a lot easier for me.
