---
categories: [www]
date: 2011-11-30T06:22:00+00:00
date_gmt: 2011-11-30T06:22:00+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=464'
id: 464
modified: 2017-03-29T21:25:21-05:00
modified_gmt: 2017-03-30T02:25:21+00:00
name: jquery-ui-droppable-and-handling-multiple-draggable-types-per-droppable
tags: [javascript, jquery, jqueryui]
---

JQuery UI Droppable and Handling Multiple Draggable Types per Droppable
=======================================================================

JQuery UI [Draggable](http://jqueryui.com/demos/draggable/) and [Droppable](http://jqueryui.com/demos/droppable/) make it fairly easy to implement <abbr title="drag and drop">dragondrop</abbr> on a web page.  There are some things that are not easy to do with it though.  One example is having a droppable accept multiple types of draggables with different responses depending on type, especially when added at different times (for instance, being attached by separate objects/scripts).  The way JQuery UI is set up, only one droppable behavior set can be attached to an element, so doing 

``` js
element.droppable({accept: ".type1",...});
element.droppable({accept: ".type2",...});
```

simply replaces the ".type1" options with the ".type2" options.

In a recent project, I needed multiple draggable types per droppable, so I created an object class to handle adding a new "accept" type and associated events to an element that is already a droppable.  I do this using [duck punching](http://www.ericdelabar.com/2008/05/metaprogramming-javascript.html) to overwrite the original event callbacks.  The wrapper callback checks the draggable element to see if it matches the new "accept" value.  If so, it runs the new callback, otherwise it runs the original callback.  Every time a new set of droppable options is applied, a new wrapper callback is created that calls the previous, so that no functionality is lost.  Perhaps not as efficient as a single function with an if/switch tree, but that would not be feasible for this use case.

<!--more-->

I created this as an object that can be stored and reused for a single droppable, but it can also be used like a function except that it needs the new keyword in front of it.  I do this by checking if the element is already a droppable, doing the duck punching and "accept" concatenating only if necessary.  It is called much like `.droppable()` except that it is passed the element ("element" parameter) instead of as a member function of the jQuery element container.  So it can be used like:

``` js
var element = $(".droppable");
new __HandlerDroppable({element: element, accepts: ".draggable1", drop: function(){ alert("draggable1 dropped"); }});
new __HandlerDroppable({element: element, accepts: ".draggable2", drop: function(){ alert("draggable2 dropped"); }});
```

The code for the object is as follows:

``` js
var __HandlerDroppable = function(args){
		this.element = args.element || null;
		this.arrOptionsEvent = args.arrOptionsEvent || [
			"activate"
			,"create"
			,"deactivate"
			,"drop"
			,"over"
			,"out"
		];
		this.add(args);
	}
	$.extend(__HandlerDroppable.prototype, {
		add: function(args){
			if(!args.element)
				args.element = this.element;
			//--if already a droppable, add applicable old settings to new
			if(args.element.hasClass("ui-droppable")){
				//-#must punch first to keep accept intact
				for(var i=0; i < this.arrOptionsEvent.length; ++i){
					this.punchOption(this.arrOptionsEvent[i], args);
				}
				this.concatenateOption("accept", args);
				this.concatenateOption("activeClass", args, " ");
				this.concatenateOption("hoverClass", args, " ");
			}
			args.element.droppable(args);
		}
		,concatenateOption: function(argName, argsObject, argJoinWith){
			if(typeof argJoinWith == "undefined") var argJoinWith = ",";
			var lclOption = argsObject.element.droppable("option", argName);
			if(lclOption){
				if(argsObject[argName])
					argsObject[argName] += argJoinWith;
				argsObject[argName] += lclOption;
			}
		}
		,punchOption: function(argName, argsObject){
			var lclOldOption = argsObject.element.droppable("option", argName);
			if(lclOldOption){
				if(argsObject[argName]){
					var lclNewOption = argsObject[argName];
					var lclSelector = argsObject["accept"];
					argsObject[argName] = function(argEvent, argUI){
						if(argUI.draggable.is(lclSelector))
							return lclNewOption.apply(this, arguments);
						else
							return lclOldOption.apply(this, arguments);
					}
				}else{
					argsObject[argName] = lclOldOption;
				}
			}
		}
	});
```

[2015-12-14: cleanup and simplification /]
