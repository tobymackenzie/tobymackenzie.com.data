---
categories: [computer, www]
date: 2020-04-15T01:51:02-04:00
date_gmt: 2020-04-15T05:51:02+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2800'
id: 2800
modified: 2021-09-07T00:29:16-04:00
modified_gmt: 2021-09-07T04:29:16+00:00
name: homebrew-install-without-root
tags: [homebrew, packagemanager, permissions]
---

Homebrew install.sh without root
================================

[Update]The following method no longer seems to work due to changes in the `install.sh` script as well as locked down permissions in newer OS versions.  Because of this and changes to my general setup, I have a [new Homebrew setup](/content/blog/2021/09/07/unprivileged-homebrew-install-2021-edition.md) that uses Homebrew's [untar anywhere](https://docs.brew.sh/Installation#untar-anywhere) method.[/Update]

I installed [Homebrew](https://brew.sh/), a Mac package manager, recently on my main computer.<!--more-->  I use [macports](https://www.macports.org/) for most of my package management needs, but brew just has many packages macports doesn't.  Anyway, homebrew installs packages as your user instead of the root permissions most package managers use.  Except when installing itself, which uses root to set some permissions.  If it needs to, that is.  I didn't want to give the install script root if I didn't need to.

To make it not need to, you basically have to have permissions to write to the `/usr/local` and `/usr/local/bin` directories before running it.  Assuming you are an administrator user, you can give the `admin` group ownership of directories, and then give the group write access to those directories.  This will require root, but you can then run the install script without needing to enter your root password.  With the current recommended install method, this would look like:

``` sh
sudo chgrp admin /usr/local /usr/local/bin
sudo chmod g+w /usr/local /usr/local/bin
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install.sh)"
```

You should probably verify that the last line is still the [recommended install method](https://brew.sh/#information).

If you can't run as root at all, you can try their [untar anywhere](https://docs.brew.sh/Installation#untar-anywhere) method of installation.  I haven't tried it though, and I've read it can cause problems for some packages.

<ins>Note: All bets are off with casks. `vagrant`, for example, requires root at the package level, and I haven't figured out a way around this.  If you're worried about the cask phishing your password, `sudo` anything so you've already entered your password before running `brew`, eg `sudo printf 'now brew\\n--------\\n' &amp;&amp; brew upgrade`.</ins>
