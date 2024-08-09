---
categories: [www]
date: 2019-03-22T02:16:30-04:00
date_gmt: 2019-03-22T06:16:30+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2261'
id: 2261
modified: 2019-03-23T01:54:20-04:00
modified_gmt: 2019-03-23T05:54:20+00:00
name: symfony-console-free-up-default-shortcuts
tags: [cli, console, symfony]
---

Symfony console: Freeing up default short options
=================================================

I like [Symfony's console component](https://symfony.com/doc/current/components/console.html), and use it for much of my command line scripting these days.  One thing I dislike is that it takes use of some short option characters for itself.  The built in handling of verbosity with `-v` is nice and is fairly common in the CLI world, but some, like `-h` and `-n`, are more varied in use and would be desirable to have for various purposes in my own commands.  I decided to remove these defaults in my own console app recently, and will describe how to do so.

<!--more-->

Symfony defines the default options in the `Application` class within the `getDefaultInputDefinition()` method.  Because of the way the options defined in here are merged into the options of every command loaded by the application, they cannot be overridden by the command itself.  So we have to override this method in our own subclass of `Application`, returning just the options we want.

The `InputOption` class is immutable, so we can't just call `parent()` and modify the options.  I just copied the definition and changed what I wanted.  You could alternatively call the parent and completely replace the specific options you want.

That handles allowing commands to declare these options, but they can't actually use them yet.  That is because their functionality is hard coded in two methods, `doRun()` (for `-h` and `-V`) and `configureIO()` (for the rest).  It isn't possible to use any of the parent functionality, so we again must copy the methods entirely and replace the bits we want to change.

Because Symfony declares the `$defaultCommand` property referenced in `doRun()` as `private`, we must redeclare that property in our overridden class and everything that touches it.  That means the property `$singleCommand` as well as the two functions `getCommandName()` and `setDefaultCommand()`.  So, copy all of these over to our class as well.

You then would replace the Symfony `use` statement in your console script with this namespace, like:

``` php
#!/usr/bin/env php
<?php
use My\Console\Application;

$loader = require_once(__DIR__ . '/vendor/autoload.php');
$app = new Application();
//… load commands
$app->run();
```

I started putting the code for `Application` in this post, but it was too huge.  You can see [what it looks like at the time of writing](https://github.com/tobymackenzie/sy-console/blob/7a0a0c70ab665e34b9c6185a8b268842c783ebca/src/Application.php#L35-L179) in my [sy-console repo](https://github.com/tobymackenzie/sy-console).

Note that if you're using the Symfony framework, you would use `Symfony\Bundle\FrameworkBundle\Console\Application` as `Base`.

This is very heavy just to free up a few option shortcuts.  My modified version of the necessary Symfony project code took about 144 lines with a few comments in there.  Not only is that a lot of code to port over, but I will have to maintain it, and any changes to the main project will have to be manually ported.

But, for a general purpose console component, those option shortcuts are useful.  It will simplify some naming in commands I am working on, and will mean more freedom when creating future commands.  So, I think it is worth it for me.

The Symfony project could've split some of this stuff out and done some other things differently to make changing these options easier.  That would, of course, lead to more code and more complexity.  The way it is built presumably matches their goals.  With others' open source projects, you get pre-built functionality, but then often have to live with their choices or do a lot of work to change them.
