---
categories: [www]
date: 2014-09-03T00:55:32-05:00
guid: 'http://tobymackenzie.wordpress.com/?p=655'
id: 655
modified: 2016-04-04T21:07:14-05:00
name: backbone-maintain-scroll-position-when-going-back
tags: [code, javacript, spa]
---

Backbone: Maintain scroll position when going back
==================================================

I've been spending a lot of time at work recently working on another phone app.  Like our other apps, we're using [Phone Gap](http://phonegap.com) to build an app with web technologies.  Like one previous app, we're using [Backbone](http://backbonejs.org), adding [Marionette](http://marionettejs.com) to help this time.  Backbone apps are generally SPA's that rerender entire pieces of the HTML document when the underlying data changes.  This can often be basically the entire  content of the document when you change routes.

Because there is no page change, browers don't typically change the scroll position when you visit a new "page".  So when you click a link at the bottom of one page, you may end up at the bottom of the new page you are loading.  It's common to have apps set the scroll position to the top via JavaScript on page change, like `window.scrollTo(0, 0);`.

What happens when hitting the back button varies from browser to browser.  Some, like Chrome, try to remember the scroll position for each fragment identifier (how Backbone handles routes by default), while others, such as Safari, do not.  When they do not, it can be a usability problem working with lists of items.  You might visit the detail page of one item by pressing a link in the list, then go back to the previous page wanting to look at the next one, only to find your place is lost.

<!--more-->

Since the app we are working on has several lists, including one long one, it was important for us to have all browsers maintain the scroll position when going back.  I did not find a ready made solution, but [a Stack Overflow question and its answers](http://stackoverflow.com/questions/11216392/how-to-handle-scroll-position-on-hashchange-in-backbone-js-application) provided most of the pieces to make a decidedly simple solution.  The basic idea was provided in the question, and other bits in the answer.

In this app, I had already been having all of the controller actions that changed the  content go through a single method, `renderView()`.  This made it easy to DRY-ly add some functionality on every page change.  Basically, before every page change occurs, I find the current scroll position and store it in a map with a key that is the current route.  Then I see if the route for the new page already has a saved scroll position.  If so, I scroll to that position.  Otherwise, I scroll to `0, 0` for the normal new page behavior.  To avoid problems with trying to scroll before the new view is rendered and thus possibly before the window is even tall enough, I don't do the scrolling until the view object fires a 'show' event (something Marionette views do when part of a region).  In code, it looks like this:

``` js
var Controller = Marionette.Controller.extend({
	…
	,_currentRoute: undefined
	,_routeScrollPositions: undefined
	,renderView: function(_View, _data){
		var _this = this;

		//--create instance of new view
		var _view = new _View(_data);

		//--get route of new page
		var _newRoute = Backbone.history.fragment;

		//--store old scroll position, scroll to old position if it exists
		if(_newRoute !== _this._currentRoute){
			var _position;
			_this._routeScrollPositions[_this._currentRoute] = window.pageYOffset;
			_this._currentRoute = _newRoute;
			_position = (_this._routeScrollPositions[_newRoute])
				? _this._routeScrollPositions[_newRoute]
				: 0
			;
			_view.once('show', function(){
				window.scrollTo(0, _position);
			});
		}

		//--stick view into <main> region
		_this._regions.main.show(_view);
	}
	…
});
```

*[DRY]: Don't Repeat Yourself
*[SPA]: Single Page Application

[Update 2014-09-04: added some clarifying sentences /]
