---
categories: [www]
date: 2014-05-27T00:54:41-05:00
date_gmt: 2014-05-27T05:54:41+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=618'
id: 618
modified: 2024-08-01T12:43:52-04:00
modified_gmt: 2024-08-01T16:43:52+00:00
name: notes-on-using-php-class-with-statics-for-configuration
tags: [configuration, oo, php, project, static, symfony]
---

Notes on Using PHP Class With Statics for Configuration
=======================================================

I will be talking about using namespaced PHP classes with static properties for configuration.  Since my use was in relation to [Symfony](http://symfony.com), it is important to note that the [Config component](http://symfony.com/doc/current/components/config/introduction.html) should be used for everything possible, but that it can't be used before it is instantiated.

Reasons to use namespaced static class properties for configuration:

- A class can be defined in a file.  When that file is included from elsewhere, the class is defined.
- Once a class is defined, it is accessible anywhere after that point, regardless of scope.  Like a superglobal.
- Statics are variables set on a class rather than on an instance and can be accessed directly from the class.  This means no variables outside of the class need to be set to work with the variables.  Like a superglobal singleton.
- Statics are not static and can be modified just like any other variables.
- Static methods can control access and provide other behaviors you may want for working with your configuration.
- Namespaces help prevent collisions of class names by essentially adding characters to a class name that make it less likely to be used elsewhere.  With [psr-0](http://www.php-fig.org/psr/psr-0/) / [psr-4](http://www.php-fig.org/psr/psr-4/) autoloaders, the namespaces should be well controlled.
- Variables can't be namespaced, so classes (or constants or functions) are the only way to take advantage of their benefits.
- Using constants and functions inside of a namespace is similar to static properties and methods of a class, except the constants are immutable and have limited data types, and there aren't the niceties like `self` for the functions.
- Being in PHP (as opposed to some config file format) allows use of `__DIR__` (my primary need was for storing paths, and it wouldn't be ideal to have to put in the full filesystem paths to things), string concatenation and other operations, and any other PHP behavior or values desired.

<!--more-->

I did some work on some of [my Symfony stuff](https://github.com/tobymackenzie/Symfony-Initial) this weekend.  In that project, I have some configuration that is used before the autoloader is loaded and before the AppKernel is created (hence the inability to use the Config component).  The config includes some path information, the environment name, and whether the app is in debug mode or not.  I had been using a global variable, but had my qualms with that, so I decided to move away from it.  For the reasons listed above, I decided to move to static class properties.

Since I wanted my configuration before the autoloader is created and didn't want to directly reference a path to something installed with [composer](https://getcomposer.org/), I needed it to be defined in a file easily accessible by the entry points to my application.  Since the configuration was used by [my component](https://github.com/tobymackenzie/Symfony-Shared) as well though, and the component shouldn't be dependent on the app defining a class, I wanted it defined there.  So I defined it in both.

Why both?  Isn't this WET?  And won't this cause a PHP error for redefining a class?  For the why, as hinted above, I don't want my component breaking (totally) if nothing is defined outside the component.  So when I reference the class in the component, it will always be there, even if it doesn't have the right data.  And as to the WETness, the class needs only the bare minimum to not break the component, which isn't much (especially since I don't reference this class directly, which I will get to).

To understand why there is no error, you must understand something about how autoloaders work.  Autoloaders load the file containing a class the first time that class is used.  Once a class is defined, it is defined, and future uses of that class will no longer trigger the autoloader to load the class file.  So if I define the class in that configuration file, any later uses will not trigger the autoloader, and thus the version in my component will never be loaded.

You can look at [the app version](https://github.com/tobymackenzie/Symfony-Initial/blob/e14bf6056de1a42e5d7dab3187c60a5eb92b4dcd/app/config/InitConfig.php)* and [the component version](https://github.com/tobymackenzie/Symfony-Shared/blob/8af25264e7617e57de806f2b66e76705ad055a35/Component/InitConfig.php)* that were discussed above.

Another thing I wanted for my configuration class was some behavior to work with the configuration, such as the ability to have paths be relative to other paths and the default value for the debug mode setting to be based on the environment.  I wanted this to be defined in the component so it could be updated with the component.  Because my config class from above is loaded before the autoloader, I couldn't (properly) have it extend from a class in the component.  So I created another class that extends from the other (app) one.  This is also the class that is referenced within the component and by everything after the autoloader is loaded.

This is where an interesting thing about statics and classes in PHPs come into play.  Mutation of statics of a class happens to all parents / children of that class.  With the following example:

``` php
class Foo{
    public static $val;
}
class Bar extends Foo{}

Foo::$val = 'one';
Bar::$val = 'two';
```

the value for both classes is set on both assignments.  So at the end of that, `Foo::$val === Bar::$val` and `Foo:$val === 'two'` and `Bar::$val === 'two'`.  Because of this, setting a value on my parent config class will affect the value on the child, so using the child in the component will give the proper values.

You can look at [the child class](https://github.com/tobymackenzie/Symfony-Shared/blob/8af25264e7617e57de806f2b66e76705ad055a35/Component/Config.php) * that was discussed above.

Since my use is Symfony and Symfony has its own ways for working with configuration, once Symfony's stuff is set up, the component would ideally migrate the static class configuration to a more appropriate location, such as parameters or a service, and uses beyond that point should reference the new location.  I haven't done this yet for the paths.

<small>\* I reference specific commit hashes because I am likely going to make major changes to the way things are set up now.</small>
