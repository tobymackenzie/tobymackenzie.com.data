---
categories: [www]
comment_count: 1
date: 2010-05-21T04:54:31+00:00
date_gmt: 2010-05-21T04:54:31+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=308'
id: 308
modified: 2010-05-21T04:54:31+00:00
modified_gmt: 2010-05-21T04:54:31+00:00
name: javascript-closures-scope-and-arrays
tags: [closures, functions, javascript]
---

Javascript: Closures, Scope, and Arrays
=======================================

[Closures](http://en.wikipedia.org/wiki/Closure_%28computer_science%29) are used quite frequently in Javascript for tasks such as adding event listeners or setting timeouts on function calls.  Closures are where a function is passed as a parameter to a function call from another function, and variables from the calling function must be used inside the parameter function.  Dealing with scope in closures can be difficult, and I've spent a lot of time figuring issues with them out.

An early issue I ran into with scope, and a common one, is the loss of scope of the "this" keyword in the closed function.  For example, you might want to do a setInterval that references the object that created it.  To do so, you can simply create a variable pointing to "this" and then use that in the closed function, like:

```
class.prototype.thefunction = function(){
	var fncThis = this;
	setInterval(function(){ fncThis.doSomething(); }, 1000);
}
```

This is also a common problem with event listeners, where "this" might be hoped to point to the element the listener is related to, but doesn't.

Recently, I ran into a closure problem while revamping the menu script we use at [Cogneato](http://cogneato.com) for suckerfish menus from the old MM functions to something more capable. <!--more--> I was writing a function to add listener events to each menu item to handle the dropdown.  I was storing the elements in an array and looping through it to add the listeners, which called a function created within that loop that would act on another element within it.  Variables declared in the scope of the calling function can be used within the closure function, such as in the above "this" example, or the following:

```
class.prototype.thefunction = function(){
	var element1 = document.getElementById("element1");
	var element2 = document.getElementById("element2");
	var closurefunction = function(){
		element2.style.visibility="hidden";
	}
	element1.addEventListener("click", closurefunction, false);
}
```

However, this doesn't work within a loop.  "element2" would be set to something different each time through the loop.  The closures for every event listener would then use the last "element2" rather than the one set when the closure function was created and assigned.

It took me a while to figure out how to deal with this.  I read a number of articles and posts about closures or other options, and also talked to one of our back-end developers at Cogneato.  Finally, I found a very elegant solution.  I declare a second function as the return value from my closure function, and pass the desired calling function variable(s) twice (I don't understand what the second one does, but it works).  So a loop might look like this:

```
class.prototype.thefunction = function(argElementArray){
	for(i=0; i < argElementArray.length; ++i){
		var element1 = argElementArray["element1"];
		var element2 = argElementArray["element2"];
		var closurefunction = function(element2){
			return function(){
				element2.style.visibility="hidden";
			}
		}(element2);
		element1.addEventListener("click", closurefunction, false);
	}
}
```

I was able to make an improved version of our menu script that gets the menu item and submenu elements based on configuration variables of the classnames and then adds listeners, rather than using inline event listener attributes for each item like we had before.  Adding dropdown menus is much easier now, though it still sometimes requires tinkering for differing menu structures.
