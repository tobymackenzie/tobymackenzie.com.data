---
categories: [www]
date: 2022-04-01T21:41:55-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=3710'
id: 3710
modified: 2022-04-01T21:50:47-04:00
name: april-fools
tags: [easteregg, holiday, site]
---

April Fools
===========

I have made my first (I believe) April fools feature for my website.  On April 1st, the page will spin around 360° on load and every time the user clicks.  It's a quick script I threw together this evening after deciding I wanted to finally do something for the day, as a number of websites do such things.  It didn't come together as smoothly as I hoped, which made me all the more determined to get something in place before the end of the day.

<!--more-->

The JS script that does the work looks like:

``` js
console.log('april fools');
var doAnimation = !(window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches);
if(doAnimation){
	var $el = document.querySelector('html');
	var rotated = true;
	$el.style.position = 'relative';
	$el.style.transition += ' transform 0.5s ease';
	$el.style.transformOrigin = 'center';
	$el.style.transform += ' rotate(360deg)';
}
document.addEventListener('click', function(){
	console.log('april fools');
	if(doAnimation){
		$el.style.transform = $el.style.transform.replace(
			/rotate\([\w]+\)/, 
			'rotate(' + (rotated ? '0' : '360') + 'deg)'
		);
		rotated = !rotated;
	}
});
```

To ensure this happens automatically on April Fools Day, I have something like this:

``` js
var now = new Date();
if(now.getMonth() === 3 && now.getDate() === 1){
	loadJS('/_assets/scripts/aprilFools.js');
}
```

in my main script file.  The `loadJS` is basically [Filament Group's loadJS script](https://github.com/filamentgroup/loadJS/blob/master/loadJS.js).

I was originally going to have it switch between upside down and right side up, but had trouble getting this working.  For some reason, having opacity set to something other than one on the rotated page caused the content to disappear.  Also, having the page upside down caused the scroll bars to disappear, causing a large usability issue.

For the few of you that visit in the next few hours, April Fools.  To the rest, see you next year.
