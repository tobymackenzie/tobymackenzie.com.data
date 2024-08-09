---
categories: [computer]
date: 2019-05-26T02:14:52-04:00
date_gmt: 2019-05-26T06:14:52+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2345'
id: 2345
modified: 2019-05-31T23:07:19-04:00
modified_gmt: 2019-06-01T03:07:19+00:00
name: simple-shell-calculator
tags: [math, shell]
---

Simple shell calculator
=======================

I've made myself a simple command line calculator using `bc`.<!--more-->  Since I almost always have a terminal open on my computer, it's quicker to use than opening [SpeedCrunch](http://speedcrunch.org/), a calculator app that I've liked for a long time but that has gotten kind of slow to launch.

My `c` calculator is just a shell function that handles piping the calculation into `bc`, ensures we get a reasonable number of decimal places if needed, and stores the result in an environment variable so it can be used in further calculations.

In bash, it looks like:

``` sh
function c(){
	result=`echo $* | bc -l`
	if [ ! -z $result ]; then
		C=$result
		echo $C
		export C
	fi
}
```

I normally use fish though, where it looks like:

``` fish
function c
	set result (echo $argv | bc -l)
	if test -n "$result"
		set -gx C (echo $argv | bc -l)
		echo $C
	end
end
```

It can be used like `c 3 + 36 / 3.5` or `c "$C ^ 3 + 3 * 2"`.  Some things have to be quoted because they would otherwise have special meaning in the shell.

`bc` doesn't have the same built in functions with the same names that SpeedCrunch does, so it may not fully replace the app's use.  It does allow defining custom functions, so I may eventually add `define` calls to the front of the piped value with the functions I want, but that would take some work.

I've also played with using PHP with its `-r` flag, since it does have [many math functions](https://www.php.net/manual/en/ref.math.php), usually with the same names as SpeedCrunch, and a full programming language that I'm used to to boot.  This can be done by changing the calculation line to ``result=`php -r "echo ${*};"` ``.  This works fairly well, but does have its own problems, such as `^` having different behavior, and the risk of being able to run non-math code that can mutate the file system, etc in a context where that may not be expected or desired.
