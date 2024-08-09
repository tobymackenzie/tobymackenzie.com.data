---
categories: [www]
date: 2014-07-11T02:37:55-05:00
date_gmt: 2014-07-11T07:37:55+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=639'
id: 639
modified: 2016-04-04T21:08:35-05:00
modified_gmt: 2016-04-05T02:08:35+00:00
name: composer-scripts-and-extra-from-non-root-package
tags: [composer, project, symfony]
---

Working with Composer 'scripts' and 'extra' from Non-Root Package
=================================================================

The goal of my [Symfony StandardEditionBundle](https://github.com/tobymackenzie/symfony-StandardEditionBundle) is to capture as much of the logic and configuration of the [Symfony Standard Edition](https://github.com/symfony/symfony-standard) as possible to make it easy to upgrade between versions with as little modification to the in place application as possible.  Among things I wanted to try to get into the bundle was as much as possible of the [composer configuration file](https://github.com/symfony/symfony-standard/blob/master/composer.json).  It contains a ['scripts'](https://getcomposer.org/doc/articles/scripts.md) key of scripts or functions from packages that are supposed to be run upon install / update by composer to set up the application (for instance, one script walks you through creating the 'parameters.yml' configuration file).  There is also an 'extra' key used as configuration for these scripts.

Scripts
-------

Composer only allows the 'scripts' to be defined in the root 'composer.json', ie the one in your application.  The idea is that scripts will only run that the owner has explicitly given permission to, and thus trust.  This prevented me from putting them directly in my bundle's 'composer.json', as they would be ignored.  My solution was to create functions in my bundle that run the 'scripts' from Symfony Standard Edition and can be placed in the root application's 'composer.json'.  This way, the application wouldn't have to change those scripts unless Symfony Standard added 'scripts' for more events (since they are specified with the composer event they are to be run for).

<!--more-->

I created [a class to hold my 'scripts' functionality](https://github.com/tobymackenzie/symfony-StandardEditionBundle/blob/2.3.x/Composer/ScriptHandler.php) as static methods to be called by composer (since composer needs to be able to run them via a single string identifier).

```php
<?php
namespace TJMBundleStandardEditionBundleComposer;

use ComposerScriptEvent;

class ScriptHandler{
	protected static $symfonyStandardPostInstallCommands = Array(
		"IncenteevParameterHandlerScriptHandler::buildParameters"
		,"SensioBundleDistributionBundleComposerScriptHandler::buildBootstrap"
		,"SensioBundleDistributionBundleComposerScriptHandler::clearCache"
		,"SensioBundleDistributionBundleComposerScriptHandler::installAssets"
		,"SensioBundleDistributionBundleComposerScriptHandler::installRequirementsFile"
	);
	protected static $symfonyStandardPostUpdateCommands = Array(
		"IncenteevParameterHandlerScriptHandler::buildParameters"
		,"SensioBundleDistributionBundleComposerScriptHandler::buildBootstrap"
		,"SensioBundleDistributionBundleComposerScriptHandler::clearCache"
		,"SensioBundleDistributionBundleComposerScriptHandler::installAssets"
		,"SensioBundleDistributionBundleComposerScriptHandler::installRequirementsFile"
	);
	public static function runSymfonyStandardPostInstallCommands(Event $event){
		self::runCommands(self::$symfonyStandardPostInstallCommands, $event);
	}
	public static function runSymfonyStandardPostUpdateCommands(Event $event){
		self::runCommands(self::$symfonyStandardPostUpdateCommands, $event);
	}
	public static function runCommands($commands, Event $event){
		//…
		//--call commands from Symfony Standard Edition
		foreach($commands as $command){
			forward_static_call($command, $event);
		}
	}
}
```

Basically, I have an array of methods for each event that I loop through and run, passing on composer's `Event` so that they will work as expected.  I tried and failed to find some way to go through composer for this, as this doesn't handle any of the other 'scripts' types that composer handles, such as files and functions.  I'll just have to deal with that if the Symfony developers add those other types.

Extras
------

The next problem I ran into was that the 'extra' I put into my bundle's 'composer.json' wasn't making it into the 'extra' used by those commands.  Composer docs don't say that 'extra' is root only like 'scripts' is.  Any package can specify 'extra', but there is no merging into the root package's:  The data for each package is stored with that package only.

At first I just put the 'extra' in the root package and figured that it would have to be updated every time Symfony Standard changed it.  But with some exploration of composer code and massive `var_dump()`s, and [a bit of help from composer developer stof](https://github.com/composer/composer/issues/3097), I was able to get my package's 'extra' and merge it into the data passed with the `CommandEvent`.

```php
//--merge 'extra' from this package into root 'extra' before passing on to other commands
$thisExtra = null;
foreach($event->getComposer()->getRepositoryManager()->getLocalRepository()->findPackages('tjm/symfony-standard-edition-bundle') as $package){
	if($package instanceof ComposerPackageCompletePackage){
		$thisExtra = $package->getExtra();
		break;
	}
}
$rootPackage = $event->getComposer()->getPackage();
$rootExtra = $rootPackage->getExtra();
$extra = array_merge($thisExtra, $rootExtra);
$rootPackage->setExtra($extra);
```

It was not the most straightforward thing to figure out, but the basic idea is that I have to find my package where it is stored, get its 'extra', and then replace the 'extra' in the root package with both merged together.  The `CommandEvent` luckily has access to the `Composer` instance, which stores all data for a run of composer.  The packages used by the application are stored in the local repository of composer's `RepositoryManager`.  The local repository has a `findPackages()` method that takes a package name (there is also a `findPackage()`, but I wasn't able to get it to work).  For my package, there was an `AliasPackage` and a `CompletePackage`, the latter being the real one, so I looped through to grab it.

With access to my package and to the root package, I was able to get both 'extra' and merge them.  I made sure that the root package values overrode my bundle's.  I was pleased that the composer packages have a `setExtra()` method, having battled with things in Symfony that have values that are immutable from the outside.

Learning Composer
--------

During this process, I had to look through composer's code base.  I had never done this before.  I learned a lot about a subset of how composer works.  This is often the case when I run into problems with third-party libraries.  I normally have no reason to delve into them, because they just work.  When they don't and I need to figure out a way to make them, I have to do some debugging, searching, learning.  Even though this delving into code can take a lot of time and is frustrating while I'm trying to fix problems, I often learn a lot from it both about how the library works and about different ways to do things that I might find useful for my own code.
