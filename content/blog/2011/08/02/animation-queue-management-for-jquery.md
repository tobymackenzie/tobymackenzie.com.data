---
categories: [www]
date: 2011-08-02T07:13:39+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=449'
id: 449
modified: 2018-06-10T02:55:55-05:00
name: animation-queue-management-for-jquery
tags: [animation, javascript, jquery, queue]
---

Animation queue management for jQuery
=====================================

[jQuery](http://jquery.com/) makes it fairly easy to animate DOM elements. Animating a single-step animation on one or more elements is simple with the call of the [`animate`](http://api.jquery.com/animate/) method. Multi-step animations can be more complex because animations are run asynchronously, meaning that they will start running when called but the script will continue onto the next step before the animation is done. For these, jQuery has the ability to queue steps. jQuery automatically queues multiple steps on a single object and dequeues as each completes, so you don't have to worry about managing things and setting up callbacks. But for more complex animations where multiple elements are animated at different times or other functionality must be performed after an animation step, there is no automatic queuing.

A common practice for simple queuing is to use the "complete" parameter of the animate method or of other similar asynchronous methods that is a callback to be run when the animation is finished. This works nicely when there are a few steps. It becomes more unwieldy though the more steps you add. That is where [`queue`](http://api.jquery.com/queue/) comes in, allowing for adding of as many steps as you want without having to nest in callback after callback.

<!--more-->

The `queue` method is used to set up a queue for any object. The automatic queueing of steps for a single element uses this method with an auto `dequeue` added for each step. Any `queue` with the name "fx" will have this auto-dequeue behavior. For complex animations, we need to manage the dequeuing ourselves, so we must use a different name. Since the complex animations are not tied to any particular element, we can attach it to a generic object, even an empty one, like:

``` js
var queue = jQuery({});
```

We can then queue steps on this object like:

``` js
var queue = jQuery({}); 
queue.queue("ourName", ourCallback1); 
queue.queue("ourName", ourCallback2);
```

and start them going with:

``` js
queue.dequeue();
```

Of note, since we are manually managing our queue, each callback must run `queue.dequeue()` at the end or the animation will stop.

To make this easier, I created a wrapper class of sorts for the `queue` method, as part of my codebase library.  It looks like this:

``` js
var __AnimationQueue = function(arguments){
		if(typeof arguments == "undefined") arguments = {};
		//--optional variables
		this.name = arguments.name || "tmlib";
		this.autoDequeue = arguments.autoDequeue || false;
		
		//--derived variables
		this.objQueue = jQuery({});
	}
	jQuery.extend(__AnimationQueue.prototype, {
		queue: function(arguments){
			var fncThis = this;
			var fncName = arguments.name || this.name;
			var fncCallback = arguments.callback || arguments; //-arguments is (assumed) the callback if not set explicitely
			var fncAutoDequeue = (typeof arguments.autoDequeue != "undefined")? arguments.autoDequeue: fncThis.autoDequeue;
			var fncQueueCallback = (fncAutoDequeue)
				?function(){
						var fncArguments = arguments;
						var internalThis = this;
						fncCallback.apply(internalThis, fncArguments);
						fncThis.dequeue();
					}
				:fncCallback
			;
			this.objQueue.queue(fncName, fncQueueCallback);
		}
		,dequeue: function(arguments){
			if(typeof arguments != "undefined")
				var fncName = arguments.name || arguments;
			else
				var fncName = this.name;
			this.objQueue.dequeue(fncName);
		}
		,unshift: function(arguments){
			if(typeof arguments != "undefined"){
				var fncCallback = arguments.callback || arguments;
				var fncName = arguments.name || this.name;
			}
			if(typeof fncCallback == "undefined" || !fncCallback) return false;
//->return
			var fncQueue = this.objQueue.queue(fncName);
			fncQueue.unshift(fncCallback);
		}
		,clearQueue: function(arguments){
			if(typeof arguments != "undefined")
				var fncName = arguments.name || arguments;
			else
				var fncName = this.name;
			this.objQueue.clearQueue(fncName);
		}
	});
```

It creates the empty object to queue on and handles calling the queue related methods on that object, also making sure to use a name other than "fx" unless overridden.  It can work like:

``` js
var ourQueue =  new __AnimationQueue();
ourQueue.queue(function(){
	// animation step one
	ourQueue.dequeue();
}
ourQueue.queue(function(){
	// animation step two
	ourQueue.dequeue();
}
ourQueue.queue(function(){
	// animation step three
	ourQueue.dequeue();
}
if(needStepFour){
	ourQueue.queue(function(){
		// animation step four
		ourQueue.dequeue();
	}
}
ourQueue.dequeue();
```

Much cleaner and easier to manage than many nested callbacks.

I first used this on the Block Bros site.  The site <del>has</del> <ins>had</ins> multiple objects managing animations of different pieces and of pulling in content via ajax for multiple areas.  I was able to coordinate animations and ajax calls between objects, being able to have one object run its steps and then dequeue the queue of another object so everything was run in proper order when it needed to be.  The site took a lot of development time, but it was made much easier with queueing.

[Update]My current revision of this can be seen on GitHub as [my AnimationQueue class](https://github.com/tobymackenzie/Web-ClientBehavior/blob/master/src/fx/AnimationQueue.js).[/Update]
