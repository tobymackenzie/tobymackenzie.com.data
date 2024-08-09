---
categories: [www]
comment_count: 1
date: 2009-11-17T12:39:23+00:00
date_gmt: 2009-11-17T12:39:23+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=96'
id: 393
modified: 2017-03-26T20:34:29-05:00
modified_gmt: 2017-03-27T01:34:29+00:00
name: javascript-literal-value-function-parameters
tags: [functions, javascript]
---

Javascript: Literal value function parameters
=============================================

I've been messing around with Javascript a bit lately, creating an AJAX object just now, doing stuff for school as well.  One of my classes is very much focused on Javascript.  I've noticed JQuery and some other examples making use of a single JSONesque (javascript literal values, of which JSON is a subset) parameter for functions to allow many parameters to be entered.  They are all potentially optional and can be in no particular order.  Seems wonderful, especially for Javascript, where there's no overloading of functions.  This is sort of what I thought Objective C would allow, since it requires naming of all variables.  Unfortunately, objective C requires them to be named as well as in the exact order, and none can be missing unless they're optional and at the end, so it is really just a pain there.  But in Javascript, this method does indeed allow what I want.  So you do have to know the exact parameter names, but don't have to remember order, and can just as easily not put in parameters if the function will operate without.

It's rather simple to handle.  I was even able to modify an already in use function to use one literal value parameter or the many that it originally used, simply by checking the `arguments.length` function property to see if it is one, and populating the appropriate variables if so.  So to handle the properties, they are appended to the argument and accessed by the key in dot notation.  Example function:

``` js
function ExampleFunction(argJson){
	document.write("Key1 = " + argJson.key1);
	document.write("Key2 = " + argJson.key2);
}
```

<!--more-->

and to call:

``` js
ExampleFunction({ Key1: "something1", Key2: true });
```

Functions can also be passed for callbacks and the like, so it doesn't seem to limit anything that you could pass as normal parameters.

To allow the choosability of literal value or regular arguments, the function could be something like:

``` js
function ExampleFunction(argJsonOr1, arg2, arg3){
	if(arguments.length == 1){
		var var1 = (argJsonOr1.arg1!==undefined)?argJsonOr1.arg1 : null;
		var var2 = (argJsonOr1.arg2!==undefined)?argJsonOr1.arg2 : null;
		var var3 = argJsonOr1.arg3 || null;
	}
	else{
		var var1 = (argJsonOr1!==undefined)?argJsonOr1 : null;
		var var2 = (arg2!==undefined)?arg2 : null;
		var var3 = arg3 || null;
	}
	document.write("var1 = " + var1);
	document.write("var2 = " + var2);
	document.write("var3 = " + var3);
}
ExampleFunction({arg1:false, arg2:156, arg3:"Red pantaloons"});
ExampleFunction(false, 156, "Red pantaloons");
```

and then called either with the literal value syntax or regular arguments.

[Update 12/7/2009] My bad, I hadn't noticed that I put the literal value syntax for both the regular value assignment and regular argument assignment.  Fixed. [/update]

[Update 8/25/2010] I have been using literal values for arguments to both regular functions and object constructors a lot now, and without the handling for non literal value arguments.  I use them almost always unless are only one or two parameters and little possibility of adding more.  For objects, the arguments are given the same name as the object attributes.  It then looks something like:

``` js
namespace.Object = function(arguments){
	this.argument1name = arguments.argument1name || null;
	this.namearg2 = arguments.namearg2 || null;
}
```

I updated the `if` question for two arguments to compare them to undefined.  Just checking the condition `(arguments.name)` will not allow for values of `""`, `0`, or `false`, making that check not very good for booleans (though 'null' will still evaluate as `== false` in a condition check) and possibly troublesome for numeric values.  I checked one (arg3) with a shorter version of the old way giving equivalent results.  That could also allow for more than two possible values, like `= arg1 || arg2/10 || null`.  Added sample calls for testing purposes. [/update]
