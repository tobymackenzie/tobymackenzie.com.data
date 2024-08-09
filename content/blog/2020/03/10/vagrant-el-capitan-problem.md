---
categories: [computer, www]
date: 2020-03-10T00:58:13-04:00
date_gmt: 2020-03-10T04:58:13+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2696'
id: 2696
modified: 2020-03-12T23:42:56-04:00
modified_gmt: 2020-03-13T03:42:56+00:00
name: vagrant-el-capitan-problem
tags: [mac, osx, problem, software, vagrant]
---

Vagrant on Mac El Capitan problem
=================================

I recently tried to install [vagrant](https://www.vagrantup.com/) on a Mac OS X.11 (El Capitan) machine, but ran into trouble.<!--more-->  It simply wouldn't function.  I traced it back to the embedded version of ruby that it comes with, which kept throwing the error `SIGSEGV (Address boundary error)` even when running directly.

My solution was to symlink a working version of ruby in place of the failing embedded version.  I used [homebrew](https://brew.sh/) to install vagrant, because [macports](https://www.macports.org/) doesn't have it, but macports to install ruby, because I prefer it.  The overall operation went like this on the command line:

``` sh
brew cask install vagrant
sudo port install ruby27
mv /opt/vagrant/embedded/bin/ruby /opt/vagrant/embedded/bin/xruby
ln -nfs /opt/local/bin/ruby2.7 /opt/vagrant/embedded/bin/ruby
```

I renamed the embedded ruby just in case I needed it.  You could probably remove it if you wanted.

Running it this way unfortunately results in a bunch of notices being output when run, making it hard to see the important output, but I haven't found a way around that yet.

I haven't updated vagrant yet, but I imagine I'll have to redo this when I do.
