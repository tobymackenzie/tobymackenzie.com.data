---
categories: [www]
date: 2014-05-21T02:04:47-05:00
date_gmt: 2014-05-21T07:04:47+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=609'
id: 609
modified: 2017-03-26T20:29:31-05:00
modified_gmt: 2017-03-27T01:29:31+00:00
name: symfony-console
tags: [cli, console, project, symfony]
---

Symfony Console
===============

This passed weekend, I released a github project called [sy-console](https://github.com/tobymackenzie/sy-console).  It is a starting point for building command line applications that takes the [symfony console component](http://symfony.com/doc/current/components/console/index.html) and adds symfony's [dependency injection](http://symfony.com/doc/current/components/dependency_injection/index.html), [configuration handling](http://symfony.com/doc/current/components/config/index.html), plus some other niceties like automatically adding commands from configured directories.  If you don't want those features, you can use the console component directly, but if you do, this takes some of the pain out of setting those up.

Background
----------

I spend a fair amount of time doing things on the command line.  I've made plenty of command line scripts, mostly in bash.  Bash is kind of a pain to work with for anything beyond simple command running scripts.  The control structures are a bit limited and have a hard to remember syntax.  Data structures are very limited.  There's no such thing as object orientation.  Working with [Symfony](http://symfony.com), I really liked the console component, how easy it was to add commands to `app/console`, how easy it was to work with arguments, how configuration and services were shared between commands, how it was PHP.  I've been wanting to use the component for standalone CLI apps for a while now, but was struggling to find how to make it work independently from a full blown [Symfony Standard Edition](https://github.com/symfony/symfony-standard) install.  I finally found enough resources to get me started and had the requisite free time.

<!--more-->

At work, I made an app for doing a lot command line operations I do frequently.  It is called 'cgbin' and works sort of like `app/console` where the second argument is a command and then all other arguments are arguments to the command.  So, for example, to ssh into the site 'aam', I could run `cg ssh aam`.  To perform an initial site setup for that same site, I could run `cg sitesetup aam`.  Having this application makes doing these frequent tasks a lot easier.  But working on the app, which is several bash scripts and some text configuration and data files, isn't as easy as I would like.

- `cg` is a big switch that runs other shell scripts depending on the 'command' argument
- Each script has to `source` a configuration file
- The data for sites is a text file with a line per site and tab separated values that I use `awk` to extract
- scripts have to call `cg` commands a lot to get bits of data.

It would be great to:

- have commands separated into file and have them automatically loaded into the app
- have configuration in a YAML file
- have data in a more advanced structure, like an SQLite database.  I could then more easily work with it, add fields, relate and normalize data, etc.
- use service objects 
- have the more advanced programming abilities of PHP, such as object orientation, namespaces, and advanced data structures

That's where the Symfony console component comes in.  I could write all of this stuff in straight PHP (or JavaScript with node.js or whatever), but Symfony's components provide a lot that I won't have to deal with.

Development
-----------

I went through a lot of troubles figuring out how to automatically load commands and to work with the dependency injection and configuration components.  I tried several different tacks and duplicated some Symfony code.  I will probably write up a separate post about dependency injection and configuration, but the most important thing I discovered was that if you want to do dependency injection, you probably want to use the [dependency injection component's loaders](http://symfony.com/doc/current/components/dependency_injection/introduction.html#setting-up-the-container-with-configuration-files) for configuration rather than using the configuration module directly.

Some of the resources that helped me (other than those already mentioned):

- [how to add all command classes from a directory](http://stackoverflow.com/questions/21281291/instantiating-all-classes-in-directory/22411420#22411420)
- [helpful console component tutorial](http://gnugat.github.io/2014/04/09/sf2-console-component-by-example.html)
- [helpful dependency injection tutorial on working with the service container and loading configuration](http://gnugat.github.io/2014/01/29/sf2-di-component-by-example.html)
- [creating an extension class for component configuration](http://symfony.com/doc/current/cookbook/bundles/extension.html#creating-an-extension-class) and [registering it](http://symfony.com/doc/current/cookbook/bundles/extension.html#manually-registering-an-extension-class)

Usage
-----

Like most Symfony projects these days, you start with [composer](https://getcomposer.org/), putting sy-console as a dependency.  You'll create an application similar to [how you would with the symfony component alone](http://symfony.com/doc/current/components/console/introduction.html#creating-a-basic-command), but using the sy-console 'Application' class and passing it configuration as an argument.

``` php
#!/usr/bin/env php
<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use TJMComponentConsoleApplication;

$app = new Application(__DIR__ . DIRECTORY_SEPARATOR . 'config.yml');
$app->run();
```

In the config file, you can set parameters, do imports, and configure services just like you would with a Symfony Standard app (although without a few of the niceties, like bundle path aliases).  There is a 'tjm_console' key for configuring the app itself.  This is where you set the name, version, and commands.

```
parameters:
 foo: bar
 paths.class: 'FooComponentServicePaths'
 paths.settings:
  foo: '/foo/bar'
  bar: '/bar/foo'
 test.class: 'FooComponentServiceTest'

services:
 paths:
  class: %paths.class%
  arguments: ['@service_container', %paths.settings%]
 test:
  class: %test.class%

tjm_console:
 name: Test
 version: '1.0'
 rootNamespace: foo ## will alias all 'foo:' commands to the same names without the 'foo:'.  This is primarily to make commands easy to access but allow the same commands to be separated by namespace in another app
 commands:
  'FooComponentCommand': '/Foo/src/Command' ## loads all commands in 'FooComponentCommand' namespace from '/Foo/src/Command' folder
  'FooComponentOtherOtherCommand': '/Foo/src/Other/OtherCommand.php' ## loads single command class 'FooComponentOtherOtherCommand' from file '/Foo/src/Other/OtherCommand.php'
  0: 'FooComponentOtherOther2Command' ## loads single command class 'FooComponentOtherOther2Command' via autoloading
```

The commands key is an associative array, with the key being the namespace and the value being the folder or file path.  If the key is numeric, then the value will be the namespaced class name of the command, and it will use the autoloader to load the class.  This may be confusing, so I may swap them, but that is how it is currently.

Future
------

This project is brand new and doesn't have much time into it.  I haven't even gotten it working for an actual project.  It will probably see some significant refinement and possibly significant interface changes as I work on the remake of 'cgbin'.  Some of the things I may try to do as I work on 'cgbin':

- finalize interfaces at a reasonable, easy to use place
- make sure I am using all that makes sense from the components I'm using, and that I'm using all components that make sense
- get unit testing in place so I can make sure changes don't break things
- re-add support for passing a configuration array to Application (this was removed when I went to using the dependency injection for configuration, but I think I can make it work)
- make sure 'bundles' of commands and services for this play nice when used in Symfony Standard Edition and vice versa

I want to play with it for some other things too.  It is too heavy for small scripts, and I don't have anything as big as 'cgbin' for my own uses, but I will at least experiment.
