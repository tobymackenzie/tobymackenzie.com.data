---
categories: [computer, www]
date: 2021-09-07T00:12:53-04:00
date_gmt: 2021-09-07T04:12:53+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3495'
id: 3495
modified: 2021-09-07T00:12:53-04:00
modified_gmt: 2021-09-07T04:12:53+00:00
name: unprivileged-homebrew-install-2021-edition
tags: [homebrew, packagemanager]
---

Unprivileged Homebrew install, 2021 edition
===========================================

On my new MacBook, I've been isolating responsibilities into separate user accounts.  This includes an unprivileged "manager" account for installing most global third-party software, and a few development accounts for different purposes.  I use [Homebrew](https://brew.sh/) to install some dev related software, but my [old Homebrew setup](/blog/2020/04/15/homebrew-install-without-root/) didn't work with this conceptually, nor with the more locked down privileges of newer Mac OS versions.  I didn't want to give Homebrew or its packages admin or root privileges, so I have adapted Homebrew's [untar anywhere](https://docs.brew.sh/Installation#untar-anywhere) method to install a globally available Homebrew using the unprivileged manager account, only requiring a privileged account briefly.  I've also used untar anywhere for a per-account Homebrew install to allow each dev account to have custom versions of any desired packages, with no privileged account required.

<!--more-->

Global
------

Requiring admin privileges only to set up the directory in a global location, I have installed Homebrew for global usage in `/opt/brew` and managed by my unprivileged manager account.  The software is opt-in per account, requiring each  user to add it to their path if they want to use it, so there won't be surprises.  Since `/opt` is owned by root, we have to create the `brew` folder with an admin user, then assign it to the desired manager user, which we'll give username "manageruser".  As admin, we run:

``` sh
sudo mkdir /opt/brew
sudo chown manageruser /opt/brew
```

Then as manageruser, we install Homebrew and add it to our path (command is assuming the now Mac default `zsh` shell):

``` sh
curl -L https://github.com/Homebrew/brew/tarball/master | tar xz --strip 1 -C /opt/brew
echo 'export PATH="$PATH:/opt/brew/bin"' >> ~/.zshrc'
```

After opening a new terminal or running `source ~/.zshrc`, we can now run `brew` and install the software we want.  The untar anywhere method has a caveat that some packages may not work properly at a different location than `/usr/local/bin`, but I haven't had any problems with this.  The only packages I've run into problems with in an unprivileged account are casks, some of which require root.  `vagrant` and `virtualbox` are examples, and I just used the installer from their websites for them.

For each user that we want to use this software with, we can run:

``` sh
echo 'export PATH="$PATH:/opt/brew/bin"' >> ~/.zshrc'
```

as is done above.

I tried to put my install directory at `/opt/homebrew`, as is used on the new M1 Macs, but Homebrew doesn't allow installing Intel software at that location.  I had to rename the folder and change my path.

Note that if we don't have admin privileges at all and can't get an admin to set up `/opt/brew` for us, we can install to someplace like `/Users/Shared/brew` and have other users add that to their path instead.

Per user
--------

Each user can create their own install of Homebrew in their home folder without any admin privileges at all.  Each can then have their own versions of software as needed.  For example, for my work at Cogneato, I need older version of `sass` and `node` than I use for my own site.  I install into `~/.brew`.

We install Homebrew using the untar anywhere method much like above, and add it to our path:

``` sh
mkdir ~/.brew && curl -L https://github.com/Homebrew/brew/tarball/master | tar xz --strip 1 -C ~/.brew
echo 'export PATH="$PATH:~/.brew/bin:/opt/brew/bin"' >> ~/.zshrc'
```

Once we open a new terminal window or run `source ~/.zshrc`, we can run `brew` to install whatever packages we want.  Note that I have the global Homebrew path after the user one.  If it were reversed, not only would the global packages take precedence, but so would the global `brew` command, which then wouldn't install in the desired location (or at all).

As with the global install, I haven't had problems with regular packages, but the Homebrew people warn of potential problems with using a non-standard install location.  Casks sometimes require root, though, and thus won't work without admin privileges.  They also may not install in the user folder, and thus won't work well for a multi-user setup.
