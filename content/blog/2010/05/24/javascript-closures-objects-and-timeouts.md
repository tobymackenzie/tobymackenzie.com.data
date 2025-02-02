---
categories: [www]
date: 2010-05-24T06:11:35+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=313'
id: 313
modified: 2010-05-24T06:11:35+00:00
name: javascript-closures-objects-and-timeouts
tags: [closures, javascript, oo, timeouts]
---

Javascript: Closures, Objects, and Timeouts
===========================================

I recently discussed [two issues with closures in Javascript](https://tobymackenzie.com/blog/2010/05/21/javascript-closures-scope-and-arrays/).  I continued to improve my menu script by fixing some IE issues, then I moved everything into objects.  By moving to objects, I ran into another issue that was basically a combination of the two issues discussed in the previous article.  I did not immediately realize this however, for whatever reason, and spent some time figuring it out.

The issue was with setting a timeout that calls a method of the object the timeout is set within.  The method is attached to "this", but "this" changes scope in a "setTimeout" call ("this" becomes "window").  To pass the appropriate "this", we create a variable pointing to this and then pass it to an anonymous function that returns another anonymous function which uses are pointer to "this" to call the desired method.  Since my "setInterval" was attached to an event listener, it also had to be placed inside of the double anonymous function.  It looked something like this:

```
class.prototype.functionName = function(argElement){
	var fncThis = this;
	var callback = function(fncThis){
		return function(){
			fncThis.timeout = setTimeout(function(fncThis){ return function(){fncThis.classMethod(); };}(fncThis) ,750);
		};
	}(fncThis);
	argElement.addListenerEvent("touch", callbackMouseout, false);
}
```

This was the only major issue I had putting my code into objects.  The last time I had tried something similar, I had given up dealing with the timeouts, but this time I had more experience.  Now I have nice, reusable OO classes for suckerfish menus, etc.
