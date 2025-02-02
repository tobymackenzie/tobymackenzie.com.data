---
categories: [computer, www]
date: 2023-09-14T15:58:26-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4141'
id: 4141
modified: 2023-09-14T15:58:26-04:00
name: homebrew-composer-2-6-x-failing
tags: [composer, homebrew, php, problem]
---

Homebrew `composer` 2.6.x failing
=================================

For some reason, the Homebrew version of `composer` hasn't been working recently, either 2.6.1 or 2.6.2.  So I've manually grabbed the phar from getcomposer.org and replaced the file it was getting.  I'm running the latest MacOS and up to date Homebrew, PHP, and Composer on an Intel Macbook Air.  When I would run `composer`, I would get an exception<!--more--> like:

```
PHP Fatal error:  Uncaught PharException: phar "/opt/brew/Cellar/composer/2.6.1/bin/composer" SHA512 signature could not be verified: broken signature in /opt/brew/Cellar/composer/2.6.1/bin/composer:28
```

That implies some issue with the signature check that verifies the phar is the code it's supposed to be.  I'm not sure why it wouldn't be matching because [the brew formula](https://github.com/Homebrew/homebrew-core/blob/4f1a8ed3b372acf1ecec3a1869b35d0cfd2ea84e/Formula/c/composer.rb) seems to use the same URL as I use below, but I just needed to have Composer work.

So I went to [Composer's download page](https://getcomposer.org/download/), got the link for the manual install, and stuck it into place.  I ran this:

``` sh
rm /opt/brew/Cellar/composer/2.6.2/bin/composer
curl -o /opt/brew/Cellar/composer/2.6.2/bin/composer https://getcomposer.org/download/2.6.2/composer.phar
chmod a+x /opt/brew/Cellar/composer/2.6.2/bin/composer
ln -nfs /opt/brew/Cellar/composer/2.6.2/bin/composer /opt/brew/bin/composer
```

Note that my install location is non-standard for Intel, but has worked fine for Composer previously and still works fine for everything else.  That put the current version from their website into place and made it executable.  To verify the file checksum, I copied from the site and ran:

``` sh
php -r "if(hash_file('sha256', '/opt/brew/Cellar/composer/2.6.2/bin/composer') === '88c84d4a53fcf1c27d6762e1d5d6b70d57c6dc9d2e2314fd09dbf86bf61e1aef'){ echo 'hash matches'; } else echo 'hash does not match';"
```

That said the hash matches.  When run `composer`, I no longer get an error.  I will try again with regular `brew upgrade` when the next version is released, and if it works, I'll use that.  Otherwise, I'll continue with the direct download method.
