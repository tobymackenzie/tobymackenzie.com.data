---
categories: [www]
date: 2020-02-14T01:19:34-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=2643'
id: 2643
modified: 2020-02-14T01:19:34-05:00
name: php-fallback-for-old-constructor-style
tags: [fallback, old, php]
---

PHP: Fallback for old constructor style
=======================================

In versions of PHP before 5, constructors were functions with the same name as their class.  PHP 5 introduced the `__construct()` unified name, and has deprecated the old style in PHP 7.  Cogneato still has code remnants from long ago, with the old style.  I recently worked on improving the compatibility of our old code with PHP 7.<!--more-->  To remove deprecation warnings, I switched all of the old style constructors that I could find in our CMS code to the new style.  There were still many places calling these methods though, mainly where you would now call `parent::__construct()`.  To safely handle the risk that I missed fixing any or that client code still has such calls, I made a fallback using `__call()`.  It looks something like:

```
class ParentClass{
	public function __call($method, $args){
		if(isset($this)){
				if($this instanceof $method && is_callable(Array($this, $method . '::__construct'))){
						return call_user_func_array(Array($this, $method . '::__construct'), $args);
				}
		}
		$trace = debug_backtrace();
		$trace = array_shift($trace);
		throw new \Error("Call to undefined method " . get_class($this) . "::{$method}() from {$trace['file']}:{$trace['line']}");
	}
}
```

This should safely call the correct parent method if it exists, and for other undefined methods, throw a reasonable exception.
