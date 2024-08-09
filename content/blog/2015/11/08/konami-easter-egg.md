---
categories: [www]
comment_count: 1
date: 2015-11-08T02:35:25-05:00
date_gmt: 2015-11-08T07:35:25+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=709'
id: 709
modified: 2016-10-13T08:35:11-05:00
modified_gmt: 2016-10-13T13:35:11+00:00
name: konami-easter-egg
tags: [development, easteregg, javascript, web]
---

Konami easter egg
=================

What web developer's site is complete without an easter egg?  Until today, [mine](https://www.tobymackenzie.com) didn't have one, but I had long wanted something.  Since I was struggling to make forward progress on what I had actually wanted to work on this weekend, and had just been reminded of the [Konami Code](https://en.wikipedia.org/wiki/Konami_Code), I decided it was finally time to add one.  I had seen a friend do [a key sequence easter egg](https://github.com/jonknapp/squarerecordsakron.com/blob/master/js/tee-hee-hee.js) on [a site he built](http://www.squarerecordsakron.com/) a while back, which had put the idea in my head.  The Konami Code sequence has been used on several websites already ([Digg](http://digg.com) and [Vogue](http://www.vogue.co.uk/) are two examples I could get to work), so why not mine?

A simple Konami Code script:

<!--more-->

``` js
(function(_d){
	var _current = 0;
	var _keys = [38,38,40,40,37,39,37,39,66,65];
	var _addListener = _d.addEventListener || _d.attachEvent;
	var _eventName = (_d.addEventListener) ? 'keyup' : 'onkeyup';
	_addListener.call(_d, _eventName, function(_event){
		var _key =  _event.which || _event.keyCode;
		if(_key === _keys[_current]){
			if(_current === 9){
				location.href = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
				_current = 0;
			}else{
				++_current;
			}
		}else{
			if(!(_current <= 2 && _key === 38)){
				_current = 0;
			}
		}
	}, false);
}(document));
```

We simply attach a `keydown` event listener to `document` that compares each keypress to a value in an array.  As each keypress matches, we increment the index we are comparing to.  If the key doesn't match the value at the index, we start back at 0 (unless we are in the first two presses, since we want this to work no matter what keys are pressed beforehand).  If the keypress matches on the last index, we do our desired easter egg thing and then reset the count to 0 so it can happen again (although that is irrelevant if, like in this example, you send them to another page).

This wasn't that hard to put together and has very good browser support (back to IE 5 in emulation testing).  According to [the `keydown` docs on MDN](https://developer.mozilla.org/en-US/docs/Web/Events/keydown), `which` and `keyCode` are deprecated, but their replacements are not widely implemented and would require a separate sequence array, since they use strings instead of integer codes.  I will stick with this implementation for now.

This can be done generically if you are doing multiple sequences:

``` js
(function(_d){
	// class KeySequencer
	var KeySequencer = function(_keys, _callback){
		var _current = 0;
		var _last = _keys.length;
		var _firstKey = _keys[0];
		var _firstKeyRepeats = 0;
		for(var _i = 0; _i < _last; ++_i){
			if(_keys[_i] === _firstKey){
				++_firstKeyRepeats;
			}else{
				break;
			}
		}
		--_last;
		KeySequencer.addListener.call(_d, KeySequencer.eventName, function(_event){
			var _key =  _event.which || _event.keyCode;
			if(_key === _keys[_current]){
				if(_current === _last){
					_callback();
					_current = 0;
				}else{
					++_current;
				}
			}else{
				if(!(_current <= _firstKeyRepeats && _key === _firstKey)){
					_current = 0;
				}
			}
		}, false);
	};
	KeySequencer.addListener = _d.addEventListener || _d.attachEvent;
	KeySequencer.eventName = (_d.addEventListener) ? 'keyup' : 'onkeyup';

	// instances
	var _konamiSequencer = new KeySequencer([38,38,40,40,37,39,37,39,66,65], function(){
		alert('konami');
	});
	var _homeSequencer = new KeySequencer([72,79,77,69], function(){
		alert('home');
	});
}(document));
```

I have some other ideas for easter eggs, but they will have to wait until I make more progress on some more important things.
