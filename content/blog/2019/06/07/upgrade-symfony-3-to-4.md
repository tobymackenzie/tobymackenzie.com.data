---
categories: [www]
date: 2019-06-07T00:02:55-04:00
date_gmt: 2019-06-07T04:02:55+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2370'
id: 2370
modified: 2019-11-02T19:03:02-04:00
modified_gmt: 2019-11-02T23:03:02+00:00
name: upgrade-symfony-3-to-4
tags: [symfony, upgrade, web]
---

Upgrade Symfony 3 to 4 without Flex
===================================

I've upgraded my site from Symfony version 3 to 4, without using [Symfony Flex](https://symfony.com/doc/current/setup/flex.html).  I didn't upgrade so much for new features, but mainly to be up to date, especially with Symfony 5 not far off.

<!--more-->

Symfony provides some upgrade instructions in a [general major version upgrade](https://symfony.com/doc/4.3/setup/upgrade_major.html) and a ['symfony/symfony' upgrade guide](https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.0.md).  They push for major changes to directory structure and switching to Flex.  They also don't seem to mention how to deal with certain things from [standard edition](https://github.com/symfony/symfony-standard).

I wanted a minimal upgrade path that didn't require major changes from what I have.  I didn't really want to switch to Flex.  So I upped the Symfony version and then worked my way through the problems I encountered until everything worked.  You can see the changes in my commits [b970081](https://github.com/tobymackenzie/site-tobymackenzie.com/commit/b970081be6dbd932df43e009c05a7b891734caa9), and some tweaks in [81ba8bb](https://github.com/tobymackenzie/site-tobymackenzie.com/commit/81ba8bb08112e59e369dc1b6087ad18f3e5a22d8) and [0a2e1cc](https://github.com/tobymackenzie/site-tobymackenzie.com/commit/0a2e1ccf5c232cba242615bfee6d593bab67c935).

My project isn't exactly the same as standard edition, but it is similar enough that the required changes should be similar.  I will describe them below.

Deprecations
------------

Before upgrading to Symfony 4, you will want to remove all deprecation notices.  Symfony has a really nice version system of marking all backward-incompatible changes as deprecated in the final point version before the next major version.  It shows notices for these deprecations in the toolbar in Symfony's dev environment, and in phpunit when using [`symfony/phpunit-bridge`](https://github.com/symfony/phpunit-bridge).

So, as described in [Symfony's guide](https://symfony.com/doc/current/setup/upgrade_major.html#upgrade-major-symfony-deprecations), you would make sure you are on 3.4, and then visit pages in dev environment and / or run your unit tests.  The notices will hopefully give a good clue as to what needs fixed.  Fix them all, and you should be ready for the update.

Dependencies
------------

[Composer](https://getcomposer.org/) is used to manage dependencies in a Symfony project.  Changing the version that it installs is as simple as changing the version constraints of the desired package(s) in `composer.json` and then running `composer update`.  In this case, you would update the constraints for `"symfony/symfony"` and `"symfony/phpunit-bridge"` to `"^4"`.

### Conflicts

Of course, if the new version(s) conflict with other dependency constraints, composer will throw an error.  Upgrade `"symfony/swiftmailer-bundle"` to `"^3.1"` if installed.  You must remove the dependencies `"sensio/distribution-bundle"` and `"sensio/generator-bundle"`, because they don't work with Symfony 4.

With bundles dependencies removed, they must also be remove from the kernel, normally at `app/AppKernel.php`.  Remove the following lines:

- `$bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();`
- `$bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();`

These bundles are also used for some scripts run by composer after install / update.  Back in `composer.json`, replace the following lines:

``` json
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installRequirementsFile",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::prepareDeploymentTarget"
```

with:

``` json
"bin/console cache:clear --env prod",
"bin/console cache:clear",
"bin/console assets:install --symlink --relative web"
```

These do basically the same thing as two of those lines, and the other ones are no longer relevant.

Back in `composer.json`, if you have platform config of `"php": "5.6"`, remove that.  Symfony 4 requires PHP >= 7.1.

Service loading
---------------

The latest version of standard edition already explicitly pulls in `AppBundle` classes as services (with some `autoconfigure` magic), but if your bundles do not, they will need to.  Commands, at the least, no longer are loaded automatically.  You will want something like this in your `app/config/service.yml`:

``` yaml
services:
  _defaults:
    autoconfigure: true
    autowire: true
    public: false
  AppBundle\:
    exclude: '%kernel.project_dir%/src/AppBundle/{Entity,Repository,Resources,Tests}'
    resource: '%kernel.project_dir%/src/AppBundle/*'
  AppBundle\Controller\:
    resource: '%kernel.project_dir%/src/AppBundle/*'
    tags: ['controller.service_arguments']
```

Etc
---

### Router

You probably won't encounter this, but the upgrade to Symfony 4 brought me a headache with a change to the regex handling in the routing component.  I had a poorly formed requirement for the `host` of some routes that worked in Symfony 3, but not 4.  It took me quite a while to track down what the problem was.  I had to change a regex like `(^[0-9\.]+$)|(^.*:.*:.*$)` to `^[0-9\.]+|.*:.*:.*$`.

### Server

If you use `server:run` or `server:start`, add `"public-dir": "web"` under the `extra` key in `composer.json`.

### Cleanup

In `composer.json`, you can remove all of the `symfony-` lines in the `extra` section, because they were used by removed bundles.

In `app.php` and `app_dev.php`, you can remove the line that includes `bootstrap.php.cache`, because that is no longer generated.  You can also remove any lines like:

- `$kernel->loadClassCache();`
- `$loader = new ApcClassLoader('sf2', $loader);`

Finish
------

You should now be able to run `composer update`, and hopefully in a matter of minutes you will have a working Symfony 4 app.

Of course, if you have dependencies or use features beyond what my site or standard edition use, you may encounter other issues.  Hopefully, any error messages will lead you in the right direction.
