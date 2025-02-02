---
categories: [www]
date: 2020-03-10T01:41:07-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=2698'
id: 2698
modified: 2020-03-10T01:41:07-04:00
name: php-zend_mm_heap-corrupted-error
tags: [php, problem]
---

PHP zend_mm_heap corrupted error
================================

We were getting errors on our server where certain pages or even sites would occasionally or frequently show errors for no apparent reason.<!--more-->  We would see a "Service Unavailable" message, which is the error shown by our load balancer, so we thought it might be a problem there.  We also weren't getting errors in our site Apache error logs, making us think it wasn't getting to our web server and bolstering this thought.  Pointing DNS directly at the web server seemed to help in some cases, but others gave "Connection Reset" errors.  So that wasn't it.

We also thought it might have something to do with some server load issues.  We did quite a few things to improve our site performance and reduce server load, which sometimes seemed like it helped, but ultimately didn't resolve the issue.

We set up a cron job to restart Apache a couple times a day, because it seemed to clear up temporarily after a restart.  But it only helped sometimes and didn't fix all cases.

We found that disabling gzip on responses going through PHP seemed to help.  That wasn't good for site performance, and didn't fix all cases.

We thought maybe the issue had started around November 1st, 2019, when our PHP install was automatically upgraded for [a security fix](https://www.redhat.com/archives/rhsa-announce/2019-October/msg00092.html).  We wouldn't easily be able to update to a newer version of PHP, and were concerned about reverting a security update and PHP version on a live server.

We discussed the issue with [Rackspace](https://www.rackspace.com/), our hosting provider, who led us to notice that a segmentation fault was happening, with frequent `zend_mm_heap corrupted` errors showing in the main Apache error log.  We have custom log files for each site, so we don't normally look in the main log, which wouldn't usually have anything but restarting messages.  Their suggestion was to upgrade PHP versions, but as I mentioned, we weren't able to do that quickly.

Searching for the zend issue, we found [a StackOverflow thread](https://stackoverflow.com/questions/2247977/what-does-zend-mm-heap-corrupted-mean) that led us to our solution.  There were quite a few solutions floated in that thread, and we tried many of them, such as these `php.ini` settings:

- `output_buffering=32768`
- `zend.enable_gc=0`

Those seemed to help sometimes, but the errors came back.  Ultimately, what worked for us was this ini setting:

``` ini
opcache.fast_shutdown=0
```

But, on CentOS, that had no effect in the main `php.ini`.  We realized that we had to change the setting that was in `/etc/php.d/opcache.ini`.  After restarting Apache, the error stopped completely.  Just like that, a couple months stress, relieved, with one line.

In our quest, we found [a likely related PHP bug](https://bugs.php.net/bug.php?id=65590) and [zend optimizer bug](https://github.com/zendtech/ZendOptimizerPlus/issues/146).
