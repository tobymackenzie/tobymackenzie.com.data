---
categories: [computer, www]
date: 2021-09-10T13:34:43-04:00
date_gmt: 2021-09-10T17:34:43+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3502'
id: 3502
modified: 2021-09-10T13:36:08-04:00
modified_gmt: 2021-09-10T17:36:08+00:00
name: swap-file-composer-memory-problems
tags: [composer, development, packagemanager, php, problem]
---

Swap file for composer out of memory problems
=============================================

PHP's defacto package manager, [composer](https://getcomposer.org/), has long required large amounts of memory to do updates for larger projects, often more than servers or virtual machines have.  The script will die with an out of memory error, or more recently, the simple message "Killed", and do no work in these situations.  The normal procedure is to develop locally, deploy local lock file (`composer.lock`) to the server, and run `composer install` instead of `update`.  But I've recently moved to doing most of my development in VMs, so I have had to work around this problem to get things installed or updated.  A swap file is the solution for Linux machines [provided in the official docs](https://getcomposer.org/doc/articles/troubleshooting.md#memory-limit-errors) and expanded in [a StackOverflow answer](https://stackoverflow.com/a/34998803/1139122).

<!--more-->

Based on those sources and others, I've created a single shell command string to create a swap file, run composer, and then remove the swap file, so it can be run standalone.  This does require being able to `sudo`.  The command for a development machine looks like:

``` sh
sudo fallocate -l 2G _swapfile && sudo chmod 600 _swapfile \
&& sudo mkswap _swapfile && sudo swapon _swapfile \
&& php -d memory_limit=-1 `which composer` update \
&& sudo swapoff _swapfile && sudo rm -f _swapfile
```

For a production machine, I would add in some composer and, if applicable, Symfony options, making it look like:

``` sh
sudo fallocate -l 2G _swapfile && sudo chmod 600 _swapfile \
&& sudo mkswap _swapfile && sudo swapon _swapfile \
&& export COMPOSER_DISCARD_CHANGES=1 && export SYMFONY_ENV='prod' \
&& php -d memory_limit=-1 `which composer` update --no-dev \
&& sudo swapoff _swapfile && sudo rm -f _swapfile
```

This allows composer to do its work, though perhaps a bit more slowly than normal.

In the future, I may just make a permanent swap file on each machine that needs it, so that I don't require the site administrator to have `sudo` capabilities.  The StackOverflow answer discusses how to do this, basically putting a line in `/etc/fstab`.
