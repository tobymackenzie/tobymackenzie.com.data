---
categories: [www]
date: 2010-02-01T12:53:53+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=198'
id: 409
modified: 2010-02-01T12:53:53+00:00
name: php-functions-array-as-argument
tags: [functions, php, programming]
---

PHP Functions: Array as Argument
================================

A while back, I wrote about using the [JSONesque literal value parameters](https://tobymackenzie.com/blog/2009/11/17/javascript-literal-value-function-parameters/) in Javascript, like jQuery does.  This allows arguments to be passed: with names, in no particular order, all being optional.  I set it up so that multiple arguments could be used as well, allowing for existing functions to still work or people who prefer that syntax to have it.  I will now write about something similar for PHP.

In PHP, it is not quite as elegant, but almost.  An array with key-value pairs is passed as the single argument for named argument mode.  So you could call like this:

```
testFunction(array("arg1"=>"value1","arg3"=>"value3","argCallback"=>"testCallback"));
```

or with regular arguments:

```
testFunction("value1",null,"value3","testCallback");
```
<!--more-->

The testFunction is defined like:

```
function testFunction($argArrayOr1=null, $arg2=null, $arg3=null, $argCallback=null){
	$default1 = "the default";
	if(func_num_args() == 1 && is_array($argArrayOr1)):
		$var1 = ($argArrayOr1['arg1'])?$argArrayOr1['arg1']: $default1;
		$var2 = ($argArrayOr1['arg2'])?$argArrayOr1['arg2']: null;
		$var3 = ($argArrayOr1['arg3'])?$argArrayOr1['arg3']: null;
		$varCallback = ($argArrayOr1['argCallback'])?$argArrayOr1['argCallback']: null;
	else:
		$var1 = ($argArrayOr1)?$argArrayOr1: $default1;
		$var2 = ($arg2)?$arg2: null;
		$var3 = ($arg3)?$arg3: null;
		$varCallback = ($argCallback)?$argCallback: null;
	endif;
	
	// example handling of variables
	echo "var1={$var1}<br /> var2={$var2}<br /> var3={$var3}<br /> ";
	if(is_callable($varCallback))
		$varCallback();
}
```

This one allows even a single regular parameter to be passed if it is not an array, or no parameters.  It also still works with callbacks (see [call\_user\_func](http://php.net/manual/en/function.call-user-func.php)).  I define the defaults separately so they are in one place: they of course must be within the function so that argument can be left out in the array.

I haven't done this in actual use yet, but probably will soon.  I'll probably just bypass the allowance for regular argument syntax.  Wordpress uses a GET-like syntax for some functions, which might be a bit more elegant, but I'm not sure how they do this, if there is a performance hit for parsing, if it can handle all argument types (like objects).
