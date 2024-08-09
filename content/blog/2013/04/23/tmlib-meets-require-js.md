---
categories: [www]
date: 2013-04-23T08:48:23+00:00
date_gmt: 2013-04-23T08:48:23+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=525'
id: 525
modified: 2013-04-23T08:48:23+00:00
modified_gmt: 2013-04-23T08:48:23+00:00
name: tmlib-meets-require-js
tags: [javascript, loading, organization, programming, tmlib]
---

TMLib meets Require JS
======================

I've recently been working on reorganizing, cleaning up, and improving [my javascript library, TMLib](https://github.com/tobymackenzie/Web-ClientBehavior).  This has included folder reorganization, source cleanup and normalization, a (so far crappy) [build system](https://github.com/tobymackenzie/Web-ClientBehavior/blob/7d6d5679729f1e2e803c503d29e45206426fb311/build/build.php), adding [unit testing](https://github.com/tobymackenzie/Web-ClientBehavior/tree/master/test), a (mostly still unused) [class system](https://github.com/tobymackenzie/Web-ClientBehavior/blob/55aa09716c05ece9188a578344b0d95a4250ba03/src/core/classes.js#L73), etc.

My most recent effort has been to bring in the use of [Require JS](http://requirejs.org/).  Require is an [AMD](https://github.com/amdjs/amdjs-api/wiki/AMD) implementation, which is an interesting extension of the [module pattern](http://addyosmani.com/resources/essentialjsdesignpatterns/book/#modulepatternjavascript).  It takes the dependency injection part of the module pattern (ie passing variables the module will use as arguments into the function expression) a step further by handling auto loading of those modules with a script loader that will asynchronously load and run all dependencies for a module before running the dependent module, injecting the dependencies as either parameters or assigned variables.  Require does this with names based on file path, sort of like a <abbr title="javascript">JS</abbr> equivalent of [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md).  Require also provides a build process that will combine all required module files into one and minify.  I have not played with this yet, but am hoping it will take over my currently crappy build process.

So far, I've only converted over a small core part of my library, but I really like the direction it is going.  The scoping/dependency wrappers around each module may add some bulk, but will also allow minification of all module dependencies and what not, so it may end up being insignificant in the build, especially since my current build process doesn't involve much minification.  Even if it ends up a bit larger than it could be, the development benefits outweigh that concern for me.  It has also required a change in the way I construct my library pieces.  The early pieces require being constructed in a certain order, and things don't work as well when modules to depend on each other.  But I think it will be really nice when I get the full library converted over and the build process figured out.
