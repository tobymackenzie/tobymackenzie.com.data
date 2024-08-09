---
categories: [www]
date: 2011-04-20T04:01:52+00:00
date_gmt: 2011-04-20T04:01:52+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=437'
id: 446
modified: 2024-08-01T23:41:45-04:00
modified_gmt: 2024-08-02T03:41:45+00:00
name: my-javascript-practices
tags: [javascript, practices]
---

My Javascript Practices
=======================

It has been quite some time since I've posted anything, but I certainly haven't stopped building websites. One thing I like to find out from other developers is how they do things so I can compare them with what I do and take anything that I like of theirs better, so I'm going to share some of my current practices. I'll start with javascript, since I just built a javascript heavy site and want to share some more specific javascript stuff in later posts.

Base Library
------------

To begin with, I use a namespace to store all of my javascript variables/objects in. This doesn't pollute the "global" window object with many variables and drastically reduces the possibility of collisions with other libraries. Since javascript has no actual namespaces, but it does allow for generic objects and the ability to add arbitrary attributes and functions to them, I just create an object and add everything to it. I use `__` because it is small and quick to type, can't really be given any meaning based on the name, and probably won't be used by someone else.

The only other thing I put in the global namespace is the base object type I instantiate that variable with. I did this as an object so I could conceivably create multiple instances and so that I could declare it later in the file and have all of the site specific code at the top. I call it tmlib since it is my library. So a bare instantiation might look like this:

``` js
if(typeof __ === 'undefined') var __ = new tmlib;
__.cfg.whatever = "whatever";
__.scrOnload = function(){
	doSiteSpecificSomething();
}
/*----------
©tmlib
---------*/
function tmlib(){
		this.classes = {};
		this.lib = {};
		this.cfg = {};
	}
	tmlib.prototype.addListeners = function(argElements, argEvent, argFunction, argBubble){
		var fncBubble = (argBubble)?argBubble : false;
		if(!__.lib.isArray(argElements)) argElements = new Array(argElements);
		for(var i = 0; i < argElements.length; ++i){
			var forElement = argElements[i];
			if(forElement.attachEvent)
				forElement.attachEvent("on"+argEvent, argFunction);
			else
				forElement.addEventListener(argEvent, argFunction, fncBubble);
		}
	}
/*--init */
__.addListeners(window, "load", __.scrOnload, false);
```

<!--more-->

I threw in my cross browser event listener attacher because the site specific instantiation of everything is done on window load. If I'm using jQuery, I use its functionality for this instead. So at the top of the file I instantiate `tmlib` into `__` if it hasn't been, set up configuration, do the site specific stuff in `scrOnload`, then I'd define all my classes, define the base tmlib, and finally add the listener for `scrOnload` to the `load` event of `window`.

Notice the classes, lib, and cfg (config) attributes created as objects. I put all of my classes into `__.classes`, library type functions into `__.lib`, and global type configuration values into `__.cfg`. I started without the `lib` so most of my functions aren't in it currently, like with `addListeners`, but I'm trying to move them in slowly over time. I haven't been making much use of `cfg`, mostly finding it easier to pass configuration type items directly as parameters to objects when I instantiate them in `scrOnload`. For small sites scripts it can be easy to read through this way, but for more complex scripts it can be hard. Also, when values are used multiple times, it is better and DRYer to just put them in `cfg`.

Variables
---------

I often like to prefix my variables with their scope so that I know where they are from or where they are intended to be used.  These prefixes are usually three letters, like `fnc`: created inside a function, `arg`: passed as an argument to a function, `scr`: for use in a script in a global sense, `for` or `lop`: for a loop.  On a related note, I'll often set `var fncThis = this;` in an object method to use `this` from inside a callback function, denoting that it is the `this` from the calling function.  I recently started storing other function variables in a `localvariables` object to make it easier to pass them to another function or back to itself. This also eliminates the need to put `var` before each: Remember, declaring variables without `var` puts them in `window`, which can lead to collisions and give unexpected results.

I also often do the more common prefixing of variable type.  I will do this after the scope prefix if I want both.  Variables in `this` or `localvariables` or the like are already scoped, so I almost always give these a type prefix.  Some common prefixes are: `elm`: an element; `elms`: an array or jQuery object of one or more elements; `class`: a string html/css class; `selector`: a string element selector for jquery; `on`: callback to be used when certain events occur; `callback`: a general callback; `html`: string of html for creating elements with jQuery to add to the DOM.

Functions
---------

As I said, all of my functions are added to `__` directly or to `__.lib`. I use these standalone functions for simple things that won't need to store data and generally won't need other functions to be grouped with them. The only other thing to add about functions is that I really like [passing arguments as objects using object literal notation](/2009/11/17/javascript-literal-value-function-parameters/), which I wrote about before. I will recap and mention my current practices here though, since this becomes very important for my classes. When there is a probability of being more than two arguments to a function, I pass them as a single object instead. This allows the arguments to be named, passed in any order, and omitted in any order. So I might declare a function like:

``` js
__.functionName = function(arguments){
	var localvariables = {};
	localvariables.argument1 = arguments.argument1 || null;
	if(!localvariables.argument1) return false;
//->return localvariables.argument2 = (arguments.argument2)? arguments.argument1: "defaultvalue";
}
```

The argument names when passed in this way are always passed in with the same name as used in the local version. I do the assignment thing to ensure that all variables have a default value, so I don't have to worry about that later. I use the syntax like with `argument1` when the argument default is `null` or `false` or can't be. I have to use the syntax like with `argument2` when the argument defaults to a value but can be something that evaluates to false, like `0`, `false`, "", or `null`, since for these it would still get assigned the OR part with the `argument1` type syntax. For arguments that are required, since they will be set to something falsey, I can just check if NOT them is true and return from the function if that is the case. I've started marking all of my premature returns from functions with a comment to make them easier to find. I still prefer them over nested `if`s which can get very complicated quickly.

When there are only one or two arguments, I always prefix them with `arg` so I know where they are coming from, and will still often make a local version if they are to be modified so I always have access to that original value.

Classes
-------

I use classes both to store instance variables for easy use through a collection of functionality and to easily allow multiple instances of the same set of functionality with different attributes. I add my classes to the `classes` object of the instantiated `__`. I don't use any of the special class declaration wrappers, rather just standard javascript prototype creation. The wrappers can allow some neat functionality easily and emulate the more standard class type declarations rather than the prototypical sort of javascript, but I just wanted something simple and lightweight. I'll provide an example of how I do this. In javascript, objects are functions and functions are objects if you run them with the `new` keyword. The function is essentially the constructor. Attributes can be initialized in the `constructor` or added anywhere from inside or outside the class. I might declare a class like:

``` js
__.classes.className = function(arguments){
		//--required attributes
		this.argument1 = arguments.argument1 || null;
		if(!this.argument1) return false;
//->return

		//--optional attributes
		this.boot = arguments.boot || null;
		this.arguments2 = arguments.arguments2 || "defaultvalue";

		//--derived attributes this.value1 = this.arguments1 + 3;

		//--do init stuff
		this.init();
	}
```

I define all of my attributes first and then do any init functionality. If a required attribute is not passed (or valid or useable), I return `false`, which will become the value of the instance instead of an object and can be tested from the outside code.

I try to make sure that most values (such as class names, selectors, numbers) are not hard coded and are declared in the constructor, changeable by argument if possible.  I try to add `on` callback parameters, like `oninit` and `onswitch` for as much as possible so the class can easily be modified for site specific functionality without bloating the main class.  I also have the `boot` attribute, passed in as an object if needed, to store various additional attributes not needed by the class proper but to be used in any callbacks.

Class methods are added to the `prototype` attribute of the object: This automatically adds them to all instances while creating only one instance in memory of the method function object. One might declared like this:

``` js
__.classes.className.prototype.functionName = function(arg1){
	doSomething(arg1);
}
```

The objects are then instantiated in `scrOnload` or somewhere else and stored in the "global" part of the `__` namespace like:

``` js
__.objectInstance = new __.classes.className({argument1: "foo", argument2: 3, argument3: document.getElementById("theid")});
```

Comments
--------

I don't do Extreme Programming type practices of writing all functionality in comments first and in fact don't tend to put in too many comments.  Well named items and simple functionality often don't need explaining.  I do like to put comments for anything that might be confusing in the future though.  I try to remember to put comment blocks above class declarations and functions to illuminate their arguments (possible arguments, types, default values, purpose and notes).  I currently do this like:

``` js
@param argument1Name (type:defaultValue): purpose/notes
@param argument2Name (type || type:defaultValue): purpose/notes
```

which is kind of a blend of some other notation and my own, but I don't much like it and would like to find a good standard to work with.  My classes have a comment above them as seen in my class declaration example.  I put a "©" them so I can easily find them, though this might not be easy enough to type in Windows or Linux.  In the class file I have a larger comment section at the top with a description, the parameters, instantiation information, required CSS, etc.

I use comments to denote sections:  I often use `//--sectionname` but am also considering `/*--sectionname */` to distinguish them from my functionality start points and notes, which are `//--description` for major ones and `//-` for sub ones.  I use `//->return` aligned to the left for premature returns from functions to make them easy to find.  I use `//-!` for things that need to be changed.  I put `//-@url/description` to note that I got the code or inspiration for it from somewhere else.

Files
-----

I would really like to use something that automatically "compiles" my javascript by putting code from multiple files into one and then minifying it, but I haven't gotten around to finding one of those and setting it up, and at work anyway it would require additional steps and training for some of the less skilled people who have to edit the scripts. I currently store all of my code in a git repository folder, a separate file for each class and most of the library functions piled into a few files. I manually copy and paste the code I need for a particular site into that sites javascript file(s). I always put the "tmlib" stuff in my base scripts file ("/scripts/scripts.js" at work). I also will often put all of the functionality there. I'll use separate files if the functionality is only on a small part of the site and is a fair amount of code, otherwise I can just keep it in one HTTP request and test if certain elements exist or if it is a certain page (I currently assign each page an id on the "html" element like page_pagename, so I can just see if a particular one exists). All of this is not currently minified, since it has to be editable and I have no automatic process to edit and minify.

I am a big fan of jQuery and like the way it works as compared to other similar libraries. Many of my classes are sets of functionality using jQuery. I'll almost always create a class instead of just doing things directly in the window load function so that I can reuse the code easily on the same site and other sites, plus store attributes and break functionality out into methods. Still, jQuery is somewhat large and getting larger, and even though I hotlink to jQuery's CDN version which will be much more common to be in browser caches, it still won't always be, especially for mobile browsers, where it is especially an issue. So many of my simpler classes that don't require animation are written without it to make for much smaller total script size. For instance, I do my dropdown menus without it because they are not animated and are on many sites that have no or little other scripting. In my `lib` and sometimes in `classes` I have some cognates of jquery functionality, like the `addListeners` above and an ajax class.
