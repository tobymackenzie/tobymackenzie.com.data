---
categories: [www]
date: 2023-03-01T23:05:54-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3963'
id: 3963
modified: 2023-03-01T23:07:24-05:00
name: upgraded-symfony-4-4-to-5-4
tags: [symfony, upgrade, web]
---

Upgraded Symfony 4.4 to 5.4
===========================

I've [upgraded my website to Symfony 5.4 from 4.4](https://github.com/tobymackenzie/tobymackenzie.site/commit/5f37fc54ad23b99d9f7ab73e964a68ad53c6952c).  I've continued on without [Symfony Flex](https://symfony.com/doc/current/setup/flex.html), as I had [when updating from 3.4 to 4.4](/content/blog/2019/06/07/upgrade-symfony-3-to-4.md).  The procedure was fairly similar to that, fixing any Symfony 4 deprecations and then updating the composer version constraints, fixing anything broken after that.  I also switched from requiring the `symfony/symfony` repo to requiring individual components.  It went fairly smoothly, aside from needing to fix a few things after the `composer update`.

<!--more-->

Symfony components
--------

I switched from depending on `symfony/symfony` to depending on the individual components I need.  Symfony recommends this now and it can save significantly on composer install / update times.  As such, it can help with the upgrade process in general.	The only weird thing with this was that, since I was no longer specifying some sub-dependencies, they were going up to 5.x before I had upgraded to it, showing some irrelevant deprecation warnings.

To determine what dependencies to put in place of the mono-repo, I looked at [the 4.4 composer.json file](https://github.com/symfony/symfony/blob/4.4/composer.json), particularly at these sections:

- `require`
- `require-dev`
- `autoload-dev`

The composer changes I needed can roughly be seen in [this commit](https://github.com/tobymackenzie/tobymackenzie.site/commit/342e7f8d2b036e6494fa79cbbb5f574524003fdb).	In `require`, the main ones I needed to add were:

- `"symfony/framework-bundle": "^4.4"`
- `"symfony/console": "^4.4"`
- `"symfony/security-bundle": "^4.4"`
- `"symfony/twig-bundle": "^4.4"`

I also needed to add a `conflict` section like:

``` json
"conflict": {
	"symfony/symfony": "*"
}
```

to force it to replace `symfony/symfony` in the vendor folder.

If using `symfony/var-dumper`, the `autoload-dev` file path for it must be changed to `"vendor/symfony/var-dumper/Resources/functions/dump.php"`.

I had to add some others over time, but those were the main ones my simple site needed immediately.

Onwards and upwards
-----

Moving to 5.4 was roughly as simple as in [Symfony's upgrade docs](https://symfony.com/doc/4.4/setup/upgrade_major.html) (excluding section 3, which is flex related), basically fixing deprecations and then changing the versions in composer.json.  I did have to fix a few issues afterward though.  The deprecations will show in Symfony's web profiler using `symfony/web-profiler-bundle` and in PHPUnit tests with `symfony/phpunit-bridge`.  They may also show in the PHP or Apache error log if settings allow it.

As I said above, since switching to independent Symfony components, some of the dependencies that were not specified directly ended up going to 5.x versions before I switched my project.  This resulted in some deprecations that were within Symfony / third-party code that I could do nothing about.  So I fixed all the deprecations in my own code, and when I did the upgrade, the others were fixed by the upgraded third-party versions.

Some of the deprecations I had to fix were:

- `Symfony\Component\Debug\Exception\FlattenException` was switched to `Symfony\Component\ErrorHandler\Exception\FlattenException`, changed in my `use` statements
- `Symfony\Component\HttpKernel\Event\FilterResponseEvent` was switched to `Symfony\Component\HttpKernel\Event\ResponseEvent`, used as the typehint for an `onKernelResponse()` event I had
- `kernel.root_dir` was removed, so I used a PHP constant in my bootstrap file and then set the parameter `kernel.root_dir: !php/const TJM\SyWeb\APP_DIR` in my `config.yml` so I wouldn't have to change it elsewhere
- in my dev routing, where I had a route to make viewing errors easier, I changed `resource: "@TwigBundle/Resources/config/routing/errors.xml"` to `resource: "@FrameworkBundle/Resources/config/routing/errors.xml"`
- added `return 0;` to `execute()` methods of commands
- `new Process()` became `Process::fromShellCommandline()`
- custom error controller config was moved from `twig` to `framework` config, eg:

	``` yaml
	framework:
	+  error_controller: 'PublicApp\Controller\MetaController::exceptionAction'
	twig:
	-  exception_controller: 'PublicApp\Controller\MetaController::exceptionAction'
	+  exception_controller: null
	```

- some methods required specifying return types

To do the actual upgrade, in `composer.json`, I changed all of the `"^4"` or `"^4.4"` for the symfony namespaced packages to `"^5.4"`, changed the `twig/twig` version to `"2.13|^3.0.4"`, and then did `composer update`.  It worked fine for me.

I'm glad that the upgrade went so smoothly and I have the newer features and longer maintained dependencies.  It might be more work to upgrade a more complex application than my simple website.  Most third-party packages are not as good about giving deprecations for everything and following semver as the Symfony project.  But it should be doable just working through each issue, one at a time.
