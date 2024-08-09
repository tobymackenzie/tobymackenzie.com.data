---
categories: [www]
date: 2013-03-24T21:37:11+00:00
date_gmt: 2013-03-24T21:37:11+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=522'
id: 522
modified: 2013-03-24T21:37:11+00:00
modified_gmt: 2013-03-24T21:37:11+00:00
name: javascript-callable-namespaces-and-other-namespacing-options
tags: [fundamental, javascript, library, namespace]
---

JavaScript: Callable namespaces and other namespacing options
=============================================================

It is a good practice to not pollute the global "namespace" (ie `window` in browsers) when creating JavaScript code, especially if it is to be reusable, to avoid collisions with other bits of code that may be used on a page.  It is common to use objects as namespaces.  You can say `window.myLibrary = {}` and then add whatever you want to that object with confidence of no collisions with other libraries as long as `myLibrary` isn't taken.  Larger libraries will often have a namespacing function that will manage the creation of these namespaces, allowing them to be accessed if they already exist or created and then accesed if not, and easily handling multiple levels of depth.  A simple example may look like the following:

```
namespace = function(_namespace, _scope){
	if(!_scope){
		_scope = window;
	}
	var _currentScope = _scope;
	var _identifiers = _namespace.split('.');
	for(var _i = 0; _i < _identifiers.length; ++_i){
		var _identifier = _identifiers[_i];
		if(!_currentScope[_identifier]){
			_currentScope[_identifier] = {};
		}
		_currentScope = _currentScope[_identifier];
	}
	return _currentScope;
}
```

Then you can do something like:

```
ns = namespace('myLibrary.mySubNameSpace');
jQuery.extend(ns, {
	'component1': function(){}
	,'component2': function(){}
});
```

I've been doing the more manual approach for [my library](https://github.com/tobymackenzie/Web-ClientBehavior), but have been desiring for a while to get more organized and streamline repetition by adding my own namespace function.  I got to thinking about doing more with the namespace objects, so that they can perform operations on themselves once created.  For example, they might be able to create and return sub-namespaces as well as easily extend themselves.

<!--more-->

Callable namespaces
-------------------

One option for this is to make each namespace a function instead of an object.  You can still attach properties to functions, since they are themselves objects, but you can of course call them to have them perform some logic.  So you might be able to do things like:

```
myLibrary = namespace('myLibrary');
ns = myLibrary('subNameSpace');
ns({
	'component1': function(){}
	,'component2': function(){}
});
```

The implementation I came up with is something like this:

```
var namespace = function(_namespace, _scope, _extend){
	//--_scope defaults to _deps_globals
	if(!_scope){
		_scope = window;
	}
	//--start our current scope as _scope
	var _currentScope = _scope;

	if(typeof _namespace == 'string'){
		var i, _identifier, _identifierKey;
		//--split _namespace into identifiers on separator
		var _identifiers = _namespace.split(namespace.separator);
		//--go through all identifiers
		for(i = 0; i < _identifiers.length; ++i){
			_identifierKey = _identifiers[i];
			//--if current key is not defined, define it
			if(!_currentScope[_identifierKey]){
				//--key will be a new function, defined in a scoping function so it can hold a reference to itself
				_identifier = (function(){
					var _localPiece = function(){
						//--call handler with the namespace as 'this'
						return namespace.handler.apply(_localPiece, arguments);
					}
					return _localPiece;
				})();
				_currentScope[_identifierKey] = _identifier;
			}
			//--set current scope to new scope
			_currentScope = _currentScope[_identifierKey];
		}
	}
	if(_extend){
		if(_extend instanceof Array){
			for(i = 0; i < _extend.length; ++i){
				namespace(_extend[i], _currentScope);
			}
		}else{
			jQuery.extend(_currentScope, _extend);
		}
	}
	return _currentScope;
}

namespace.separator = '.';
namespace.handler = function(){
	var args = arguments;
	//--if no arguments, return an array of keys
	if(args.length == 0){
		var _key;
		var _keys = [];
		for(_key in this){
			_keys.push(_key);
		}
		return _keys;
	}else{
		switch(typeof args[0]){
			case 'string':
				var _extend = args[1] || false;
				return namespace(args[0], this, _extend)
			break;
			case 'object':
				return jQuery.extend(this, args[0]);
			break;
		}
	}
}
```

This is approximately the implementation that I committed.  The nice thing about the function option is that it doesn't take up any namespace keys.  Also, calling a namespace directly gives a feeling of unambiguously acting on or with the namespace.  There were some things I didn't like about it though.  One is that even though I kept the function small by having it call an external handler, it is probably still larger in memory than an object with a function attached via prototype.  It also sort of requires all functionality to be contained within a single handler function, with logic branching to handle different options.  And it cannot (in a cross browser way) allow for testing with `instanceof` to see if an object is a namespace (ie (myLibrary.subNamespace instanceof Namespace)).

Object with one or more functions
---------------------------------

Making each namespace an instance of an object would allow `instanceof` test to be done.  You could add a single function that would be similar to the above `handler` function.  If you don't mind clobbering multiple sub-namesspace names, it could also allow adding as many separate functions as you're willing to clobber.  An example (untested) implementation may look like:

```
Namespace = function(_namespace, _scope, _extend){
	if(!(this instanceof Namespace)){
		//--_scope defaults to _deps_globals
		if(!_scope){
			_scope = window;
		}
		//--start our current scope as _scope
		var _currentScope = _scope;

		if(typeof _namespace == 'string'){
			var i, _identifier, _identifierKey;
			//--split _namespace into identifiers on separator
			var _identifiers = _namespace.split(Namespace.separator);
			//--go through all identifiers
			for(i = 0; i < _identifiers.length; ++i){
				_identifierKey = _identifiers[i];
				//--if current key is not defined, define it
				if(!_currentScope[_identifierKey]){
					_currentScope[_identifierKey] = new Namespace();
				}
				//--set current scope to new scope
				_currentScope = _currentScope[_identifierKey];
			}
		}
		if(_extend){
			if(_extend instanceof Array){
				for(i = 0; i < _extend.length; ++i){
					namespace(_extend[i], _currentScope);
				}
			}else{
				jQuery.extend(_currentScope, _extend);
			}
		}
		return _currentScope;
	}
};
Namespace.separator = '.';
Namespace.prototype.ns = function(){
	var args = arguments;
	//--if no arguments, return an array of keys
	if(args.length == 0){
		var _key;
		var _keys = [];
		for(_key in this){
			_keys.push(_key);
		}
		return _keys;
	}else{
		switch(typeof args[0]){
			case 'string':
				var _extend = args[1] || false;
				return namespace(args[0], this, _extend)
			break;
			case 'object':
				return jQuery.extend(this, args[0]);
			break;
		}
	}
};
```

Use would look like:

```
myLibrary = Namespace('myLibrary');
ns = myLibrary.ns('subNameSpace');
ns.ns({
	'component1': function(){}
	,'component2': function(){}
});
```

Object with helper object
-------------------------

This option would be like the previous one except that it would allow for multiple separate functions while still only clobbering one sub-namespace key.  An (untested) implementation might look like:

```
NamespaceHelper = function(_ns){
	this.ns = _ns;
}
jQuery.extend(NamespaceHelper.prototype, {
	'extend': function(_object){
		return jQuery.extend(this, _object);
	}
	,'keys': function(){
		var _key;
		var _keys = [];
		for(_key in this){
			_keys.push(_key);
		}
		return _keys;
	}
	,'namespace': function(_namespace, _extend){
		return Namespace(_namespace, this, _extend);
	}
})

Namespace = function(_namespace, _scope, _extend){
	if(this instanceof Namespace){
		this.ns = new NamespaceHelper(this);
	}else{
		//--_scope defaults to _deps_globals
		if(!_scope){
			_scope = window;
		}
		//--start our current scope as _scope
		var _currentScope = _scope;

		if(typeof _namespace == 'string'){
			var i, _identifier, _identifierKey;
			//--split _namespace into identifiers on separator
			var _identifiers = _namespace.split(Namespace.separator);
			//--go through all identifiers
			for(i = 0; i < _identifiers.length; ++i){
				_identifierKey = _identifiers[i];
				//--if current key is not defined, define it
				if(!_currentScope[_identifierKey]){
					_currentScope[_identifierKey] = new Namespace();
				}
				//--set current scope to new scope
				_currentScope = _currentScope[_identifierKey];
			}
		}
		if(_extend){
			if(_extend instanceof Array){
				for(i = 0; i < _extend.length; ++i){
					namespace(_extend[i], _currentScope);
				}
			}else{
				jQuery.extend(_currentScope, _extend);
			}
		}
		return _currentScope;
	}
};
Namespace.separator = '.';
```

Use would look like:

```
myLibrary = Namespace('myLibrary');
ns = myLibrary.ns.namespace('subNameSpace');
ns.ns.extend({
	'component1': function(){}
	,'component2': function(){}
});
```

Conclustion
-----------

I like the idea of the namespace being able to perform operations on itself.  I'm still not sure which I will ultimately go with for my library, but for right now it is the callable method.  I like the cleanness of being able to call it directly and do something.
