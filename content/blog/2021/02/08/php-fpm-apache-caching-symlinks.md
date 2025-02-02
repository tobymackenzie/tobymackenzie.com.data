---
categories: [www]
date: 2021-02-08T01:13:57-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3263'
id: 3263
modified: 2021-02-08T01:13:57-05:00
name: php-fpm-apache-caching-symlinks
tags: [php, problem, symlink]
---

PHP-FPM / Apache caching symlinks
=================================

At Cogneato, we use symlinks to point the web server to different versions of our software for websites.  Sometimes, especially on our Ubuntu server, which uses PHP-FPM to serve PHP files through Apache, I was noticing problems caused by scripts being loaded from the previous symlink destination when I changed to the new one.  There seems to be some sort of caching going on.  The solution was to restart PHP-FPM and Apache after switching the symlinks.  On Ubuntu, this looks like: 

``` sh
ln -s /path/to/new-version /path/to/software-link \
&& sudo service php7.2-fpm restart \
&& sudo service apache2 graceful
```

where the `7.2` is the version of PHP being used.  Haven't noticed the problem since.
