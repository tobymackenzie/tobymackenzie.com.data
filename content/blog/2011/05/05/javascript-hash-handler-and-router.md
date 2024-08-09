---
categories: [www]
comment_count: 2
date: 2011-05-05T08:05:18+00:00
date_gmt: 2011-05-05T08:05:18+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=444'
id: 948
modified: 2019-09-02T01:45:06-04:00
modified_gmt: 2019-09-02T05:45:06+00:00
name: javascript-hash-handler-and-router
tags: [ajax, javacript, routing]
---

Javascript hash handler and router
==================================

At work I did my first fully ajax loaded, from scratch site, Block Bros.  I used jQuery with my own library of "wrapper" classes for loading the ajax and animations between "pages".  I had to write a lot of new stuff though and modify some of my library classes to get everything working smoothly.

<!--more-->

<ins>(Note: site no longer uses this functionality or behaves like this)</ins>

Hash Handler
------------

I had started working on the site as a regular site, so I had already built all the pages with regular URLs.  When moving to an ajax loaded site with bookmarkable links using the popular hash changing technique, I simply used the regular URLs with the hash in front of them, so `whatever.com/about/` became `whatever.com/#/about`.  All the original URLs still work, allowing the site to fully support non-javascript browsers and search engines.  I made a hash handler class to help with this.  It looks like:

``` js
/*-------
©hashHandler
-------- */
__.classes.hashHandler = function(arguments){
		//--required attributes
//->return
		//--optional attributes
		this.elmsContainer = arguments.elmsContainer || null;
		this.onhashchange = arguments.onhashchange || null;
		this.oninit = arguments.oninit || null;
		this.selectorAnchors = arguments.selectorAnchors || "a";
		this.selectorExclude = arguments.selectorExclude || null;
		this.selectorInclude = arguments.selectorInclude || null;

		//--derived attributes
		var fncThis = this;
		//--hashify urls
		if(this.elmsContainer)
			this.hashifyURLs(this.elmsContainer);
		
		//--attach listener for hash change
		if(this.onhashchange)
			$(window).bind("hashchange", function(){
				var url = location.hash || "/";
				fncThis.onhashchange.call(fncThis, url);
			});
		
		if(this.oninit)
			this.oninit.call(fncThis, location.hash);
	}
	__.classes.hashHandler.prototype.hashifyURLs = function(argContainers){
		if(argContainers && argContainers.length > 0){
			var elmsAnchors = argContainers.find(this.selectorAnchors).add(argContainers.filter(this.selectorAnchors));
			if(this.selectorExclude)
				elmsAnchors = elmsAnchors.not(this.selectorExclude);
			else if(this.selectorInclude)
				elmsAnchors = elmsAnchors.filter(this.selectorInclude);
			elmsAnchors.each(function(){
				var elmThis = $(this);
				var currentHref = elmThis.attr("href");
				if(currentHref && currentHref.substring(0,1) == "/")
					elmThis.attr("href", "#"+currentHref);
			});
		}
	}
```

It really just attaches a callback to the windows `hashchange` event and provides a function to "hashify" regular URLs in the manner described above so that the URLs work for non-javascript browsers and search engines without the hash and for browser with javascript using the hash.  Instantiation looks like:

``` js
//--hash handler
__.hashHandler = new __.classes.hashHandler({elmsContainer: $("#navigationl, #maincontent, #logo"), selectorExclude: ".nonhashed"
	, onhashchange: function(argHash){
		var url = argHash;
		if(url.substring(0,1) == "#")
			url = url.substring(1, url.length);
		if(!url)
			url = "/";
		__.router.callRoute({path: url, arguments: {url: url}});
	}
	,oninit: function(argHash){
		if(argHash){
			var fncThis = this;
			setTimeout(function(){fncThis.onhashchange.call(fncThis, argHash);}, 500);
		}
	}
});
```

The `elmsContainer` argument provides elements that will have links "hashified" on page load.  Both callbacks receive the argHash to work with, which is currently unmodified from `location.hash` unless it is empty, in which case it defaults to "/".  The `oninit` callback is very simple and ensures that the `onhashchange` callback is run on page load after a brief delay.  This might be good to have as a default `oninit`.  The `onhashchange` is also rather simple.  It does another simple modification to the hash of removing the "#" if there is one and defaulting it to "/".  Then it uses an instance of my router class, which I will talk about shortly, to run an action using the hash.  This might also be good as a default `onhashchange` if I make a router instance an attribute of this class.  I also might want to figure out a more consistent but still configurable way to modify the hash, like having a callback member function that can be overridden by argument.

I used the [jQuery hashchange plugin](http://benalman.com/projects/jquery-hashchange-plugin/) to allow binding to the hash change event even in browsers that don't natively support it (it simply polls the hash in those browsers).

Router
------

I wanted an easy way to define what to do for a given hash when it changes, so I decided to make a router like the ones that are popular in server side frameworks.  My router class looks like:

``` js
/*-------
©router
-------- */
__.classes.router = function(arguments){
		//--required attributes
		//--optional attributes
		this.boot = arguments.boot || null;
		this.currentRoot = arguments.currentRoot || "null";
		
		//--derived attributes
		this.routes = [];
		this.actions = [];
		
		//--do something
	}
	__.classes.router.prototype.addAction = function(arguments){
		var fncName = arguments.name;
		var fncCallback = arguments.callback;
		this.actions[fncName] = fncCallback;
	}
/*
@param action (function): action to be performed by callroute for this route
@param name: name for access by callroute
@param path (optional): path regex to check
*/
	__.classes.router.prototype.addRoute = function(arguments){
		var fncName = arguments.name;
		var fncArguments = arguments;
		this.routes[fncName] = fncArguments;
	}
	__.classes.router.prototype.callRoute = function(arguments){
		var localvars = {};
		if(typeof arguments == "string"){
			localvars.name = arguments;
		}else{
			localvars = arguments;
		}
		if(typeof localvars.scope == "undefined")
			localvars.scope = this;
		if(typeof localvars.arguments == "undefined")
			localvars.arguments = {};

		if(typeof localvars.name != "undefined"){
			localvars.arguments.route = this.routes[localvars.name];
			this.actions[this.routes[localvars.name].action].call(localvars.scope, localvars.arguments);
		}else{
			this.callRouteForPath(localvars);
		}
	}
	__.classes.router.prototype.callRouteForPath = function(arguments){
		var localvars = arguments;
		if(typeof localvars.path == "undefined")
			return false;
//->return
		if(typeof localvars.scope == "undefined")
			localvars.scope = this;
		if(typeof localvars.arguments == "undefined")
			localvars.arguments = {};

		var fncRoute = this.routeLookup(localvars.path);
		if(fncRoute){
			localvars.arguments.route = fncRoute;
			if(fncRoute.path.exec){
				localvars.arguments.matches = fncRoute.path.exec(localvars.path);
				if(typeof fncRoute.matches != "undefined"){
					for(var key in fncRoute.matches){
						if(fncRoute.matches.hasOwnProperty(key))
							localvars.arguments.matches[key] = localvars.arguments.matches[fncRoute.matches[key]];

					}
				}
			}
			this.actions[fncRoute.action].call(localvars.scope, localvars.arguments)
		}
	}
	__.classes.router.prototype.routeLookup = function(argPath){
		var fncReturn = false;
		for(var key in this.routes){
			var route = this.routes[key];
			if(this.routes.hasOwnProperty(key) && typeof route.path != "undefined"){
				if(typeof route.path == "string"){
					if(route.path == argPath || route.path+"/" == argPath || route.path == argPath+"/"){
						fncReturn = route;
						break;
					}
				}else{ //-assumed a regex
					if(argPath.match(route.path)){
						fncReturn = route;
						break;
					}
				}
			}
		}
		return fncReturn;
	}
```

It provides methods to add path definitions and actions and to call a route based on name or path, plus a helper function to look up a route based on a path.  Actions are defined with a name and a callback like:

``` js
__.router.addAction({name: "loadPage", callback: function(arguments){
	//--do something
}});
```

The name will be referenced in the route definition, so you can have different routes call different actions.    For Block Bros, I started using multiple actions but ended up using one since so much of the stuff was the same or nearly for the different routes.  In the callback, `arguments` contains a `route` member that is a pointer to the current route.  If the route is a regex with defined matches, `arguments` also contains a `matches` member array of the values from the matches to the route.  An example definition of a route with a regex and matches is:

``` js
__.router.addRoute({
	name: "productsitem"
	,path: /\/(products)\/([0-9]+)\/([0-9]+)\/?/
	,matches: {section: 1, catid: 2, unid: 3}
	,action: "loadPage"
	,boot: {pagetype: "editoritem", contentfor: "description", hasImageNavigation: true, editornum: 1}
});
```

Each route requires a `name` to identify it by and an `action` to perform when calling this route.  The path is required to call paths using a route, which is the case for working with hashes, but the router could be used to simply associate names with actions as well.  Boot is used to pass some fixed values with this route.  The path in this case is a regex to match the path passed to the `callRoute` method to.  It contains several character groups that are pulled into the `matches` passed to the action based on their numeric position from the start of the regex (first match is 1, second match is 2).  If the `matches` of the route is defined, the `matches` passed to the `action` is also populated with named members defined by the route `matches` where the named member is matched to the positional number.

Routes can also be defined for a simple string name to be matched directly against (the router allows for an optional trailing slash for these automatically).  An example:

``` js
__.router.addRoute({
	name: "home"
	,path: "/"
	,action: "loadPage"
	,boot: {pagetype: "editorlist", contentfor: "description", editornum: 4}
});
```

Like in other routing systems, the route paths are evaluated sequentially as defined, so define a route with the path `/\/(products)\/([0-9]+)\/([0-9]+)\/?/` before `/\/(products)\/([0-9]+)\/?/` to ensure they both work.

The router must, of course, be instantiated before any of these actions and routes are added to it.  Instantiation might look like:

``` js
__.router = new __.classes.router({boot: {
	elmNavigationBar: $("#navigationbar")
	,ajaxURLLoader: new __.classes.pagerAjax({/*...*/})
	,fncBasicLoadURL: function(argURL){
		//--do something with url
	}
}});
```

The router really does not require any parameters.  `boot` is used to define any custom stuff to be used with the actions.  This example shows an element that might be accessed from with the actions so it can be cached.  There is an ajax pager object (defined elsewhere) to use for loading ajax data.  I also add functions that will be used by multiple actions here to keep things DRY, prefixed with `fnc`.  All of these can be accessed with `this.boot` from within actions.

Conclusion
----------

My hashHandler class allows me to quickly and easily bind to the hashchange event and convert URLs from standard to hashified for javascript users, allowing them to have bookmarkable pages that work with the history from an AJAX only site while still allowing the site to function like normal for non-javascript users and bots.  My router class allows easy attaching of functionality to handle differing paths.  With regex capabilities and an ability to grab pieces of the path for use in the action functionality, I can do most anything I would need to.  These classes helped organize the Block Bros project much better when I created them.
