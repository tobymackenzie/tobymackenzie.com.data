---
categories: [www]
date: 2025-10-31T16:37:54-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4686'
id: 4686
modified: 2025-10-31T16:37:54-04:00
name: updated-to-symfony-6-4
tags: [symfony, upgrade]
---

Updated to Symfony 6.4
======================

Since [updating my server](/content/blog/2025/03/20/server-upgrade-ubuntu-20-to-22.md) earlier in the year, and thus moving to PHP 8, I would've been able to update to Symfony 6.  I didn't get around to it until today, though.  I've been fixing deprecations in my code mostly as they appear (in profiler, console, logs, or automated tests) so I didn't have a lot to do this time.  I changed `^5.4` to `^6.4` in my `composer.json` and then had to adjust a few minor things in config.  Some of those took longer than they should've though.

<!--more-->

The biggest other thing I needed to fix was making a version of the "twig" service public, as it is now private by default.  I access that for my blog, which is run by WordPress but uses the templates from Symfony / Twig to render the content.  Since I no longer have a working version of that locally, I found out about the problem on the live server and had my blog throwing a 503 error for 10+ minutes while I figured out a solution.  The solution was to add a service alias with a different name in my `services.yml`, like:

``` yml
services:
  templates:
    alias: twig
    public: true
```

and then replace the service name in the place it was called.

The other issues were mostly related to dev and testing stuff.  I removed an `autoload-dev` call that I had for `var-dumper`, which looked like:

``` json
{
	"autoload-dev": {
		"files": ["vendor/symfony/var-dumper/Resources/functions/dump.php"]
	}
}	
```

because it happens automatically from the package and I was getting a warning.  It looks like this should've been the case for a long time though, so I'm not sure why I had that there.

In Symfony config for some PHPUnit tests, I had to change `storage_id: session.storage.mock_file` to `storage_factory_id: session.storage.mock_file`.  I think that may have been changed earlier, but I had a workaround in place that stopped working with 6.

Other than that, like I said, I had been fixing deprecations as they were found, so I'm not sure what they were.  Some of my sub-dependencies had already jumped to Symfony 6 since moving to PHP 8, so I was getting some deprecations in Symfony's code, and had to look at where they were coming from to figure out that I could ignore them.

I think Symfony has gotten better with the deprecations and other procedures since the more complicated [move from 3 to 4](/content/blog/2023/03/01/upgraded-symfony-4-4-to-5-4.md).  I'm still running without [Symfony Flex](https://symfony.com/doc/current/setup/flex.html), so some of the docs aren't helpful and a few things are missed that may happen automatically with Flex, but I've been able to figure out what I've needed to do.
