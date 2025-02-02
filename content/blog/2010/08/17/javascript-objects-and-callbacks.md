---
categories: [www]
date: 2010-08-17T04:08:54+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=370'
id: 435
modified: 2017-02-22T23:38:34-05:00
name: javascript-objects-and-callbacks
pings: ['https://tobymackenzie.com/blog/2010/05/21/javascript-closures-scope-and-arrays/']
tags: [callbacks, javascript, objects, todo]
---

Javascript: Objects and Callbacks
=================================

I've been doing my JavaScript coding directly in objects. Before I had been doing them without objects, then modifying them if I had time, but now that I have experience with JS objects, it is much nicer to do the OO straight off. When making objects that are versatile, allowing multiple instances, it is often necessary to be able to perform different operations for different instances. As an example, you might create a single class to handle auto-suggest type functionality, and want it to do different things when you choose one of its suggestions or cancel for different instances of its use. In JS, you could either create forks in the parent class for each possible behavior and use a test to determine which behavior is appropriate, or you could create a callback on instance instantiation or in a function call. The callback method can be very versatile and clean, allowing you to leave alone the core class and modify the calling class or global call.

<!--more-->

You could do something like:

``` js
function myobject(arguments){
		this.element = arguments.element;
		this.callback = arguments.callback;
		
		this.attachevent();
	}
	myobject.prototype.attachevent = function(){
		var fncThis = this;
		this.element.addEventListener("click", function(){
			// do something for all instances
			// run instance specific callback
			fncThis.callback();
		}
	}
var instance1 = new myobject({element: element1, callback: function(){ // do something for this instance only }});
var instance2 = new myobject({element: element2, callback: function(){ // do something for this instance only }});
```

[As mentioned before](https://tobymackenzie.com/blog/2010/05/21/javascript-closures-scope-and-arrays/), there are scoping issues with callbacks in JS. For the above callback functions, `this` would refer to `window`, so you could not access any member variables of the object. To provide the proper `this`, we can use the `call` (or `apply` if you prefer) methods, with the first argument being the object. The subsequent arguments to `call` are arguments passed from the point of call to the callback function, so the second argument is the first to the called function and so on. And to access variables from the scope of the callback creation, we can use local variables from that scope within the callback, such as the `fncThis` mentioned in my previous article to access another object.

So, putting this together, you could do something like this:

``` html
<!DOCTYPE html>
<html>
<head>
<script>
window.onload = function(){
	var myobject2instance = new myobject2({element: document.getElementById("element2"), attribute: 1});
}
function myobject2(arguments){
		this.element = arguments.element;
		this.attribute = arguments.attribute;
		
		var fncThis = this;
		this.myobject1 = new myobject1({element: document.getElementById("element1"), attribute: 10, callback: function(argValue){
				var attribute = 20;
				alert("Value passed as argument on call: "+argValue);
				alert("Value of attribute of calling object: "+this.attribute);
				alert("Value of attribute of object creating the instance: "+fncThis.attribute);
				alert("Value of local attribute, for good measure: "+attribute);
			}
		});
	}
function myobject1(arguments){
		this.element = arguments.element;
		this.callback = arguments.callback;
		this.attribute = arguments.attribute;
		
		this.attachevent();
	}
	myobject1.prototype.attachevent = function(){
		var fncThis = this;
		fncThis.element.addEventListener("click", function(){
			// do something for all instances
			var inlistenerValue = fncThis.attribute * 10;
			// run instance specific callback
			fncThis.callback.call(fncThis, inlistenerValue);
		}, false);
	}
</script>
</head>
<body>
<div id="element1">Element 1</div>
<div id="element2">Element 2</div>
</body>
</html>
```

Using this method, you can create single classes to easily handle many needs with instance specific functionality that has access to the data you need to make it all work.
