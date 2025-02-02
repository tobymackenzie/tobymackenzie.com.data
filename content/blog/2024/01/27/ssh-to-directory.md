---
categories: [computer, www]
date: 2024-01-27T15:36:36-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=4232'
id: 4232
modified: 2024-01-27T15:36:36-05:00
name: ssh-to-directory
tags: [configuration, ssh]
---

SSH to directory
================

I have been using SSH configuration a lot to make short hostname aliases for sites I SSH into frequently, but I recently figured out how to use it to change to a certain directory by default when logging in.  At work, our sites each have their own user with their own site project directory.  Most of the time when I log in, I want to go to the project directory instead of the default, the home directory.  I `cd`ed manually each time for a long time, but decided to look up a better option, and found [a config option on ServerFault](https://serverfault.com/a/1045158).

<!--more-->

The `RemoteCommand` configuration setting is run on the server when SSHing in.  I use this to `cd`, and then invoke the login shell to actually log in.  I use the `RequestTTY force` setting to ensure an interactive terminal is used.  In `~/.ssh/confg`, I would have something like this:

```
Host t tobymackenzie.com
	RemoteCommand cd /var/www/tobymackenzie.com && $SHELL -l
	RequestTTY yes
```

Then to log in, I would do `ssh me@t`.  I'd end up in my desired directory instead of the user's home folder.

I could also login using `screen` if available, to make it easier to disconnect long running processes, by using a value like this:

```
RemoteCommand cd /var/www/tobymackenzie.com && (which screen && screen -qR || $SHELL -l)
```

Makes logging in to do quick tasks faster and easier.
