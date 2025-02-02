---
categories: [www]
date: 2014-09-25T00:22:44-05:00
guid: 'http://tobymackenzie.wordpress.com/?p=662'
id: 662
modified: 2017-05-11T23:23:46-05:00
name: parallax-background-images
tags: [effect, javascript, parallax]
---

Parallax Background Images
==========================

Recently, I made my first foray into the popular parallax on websites fad.  My needs were simple:  I needed to make background images move at a different rate than the content that sat on top of them when scrolling occurred.  This was the first type of parallax I saw on the web and the most intriguing to me.  I figured that there would be a lot of already built libraries to make this easy.  Looking through the parallax libraries though, the most popular ones were quite complex or didn't do what I wanted.  I did find a couple of scripts that just handled the background image parallax, but I had some problems getting them working, and they didn't work with vertically centered images.

In the end, I took ideas from those scripts and some articles to create [my own parallax script](https://github.com/tobymackenzie/Web-ClientBehavior/blob/master/src/ui/ParallaxBackground.js).  With my class library removed, the script would look like the following:
``` js
var ParallaxBackground = function(_opts){
	jQuery.extend(this, _opts);
	if(this.elm){
		this.constructor.window.on('load resize scroll', jQuery.proxy(this._changeHandler, this));
	}
};
ParallaxBackground.window = jQuery(window);
jQuery.extend(ParallaxBackground.prototype, {
	elm: undefined
	,calcType: 'centeredStart'
	,movementRatio: 0.8
	,_changeHandler: function(){
		var _viewportHeight = this.constructor.window.height();
		var _viewportTop = this.constructor.window.scrollTop();
		var _elmHeight = this.elm.outerHeight();
		var _elmTop = this.elm.offset().top;
		var _range = _elmHeight + _viewportHeight;
		var _calcOffset = _elmTop - _viewportHeight;
		var _diff = -((_viewportTop - _calcOffset) - _range);
		var _bgPosition;
		if(_diff > _range){
			_bgPosition = 100;
		}else if(_diff < 0){
			_bgPosition = 0;
		}else{
			_bgPosition = (_diff / _range) * 100;
		}
		switch(this.calcType){
			case 'centered':
				_bgPosition = 50 + (_bgPosition - 50) * this.movementRatio;
			break;
			case 'centeredStart':
				if(typeof this._startOffset === 'undefined'){
					var _startingPosition = this.elm.css('background-position-y');
					if(_startingPosition.indexOf('%') !== -1){
						_startingPosition = parseInt(_startingPosition,10);
					}
					this._startOffset = -1 * (50 + (_bgPosition - 50) * this.movementRatio - _startingPosition);
				}
				_bgPosition = 50 + (_bgPosition - 50) * this.movementRatio + this._startOffset;
			break;
		}

		this.elm.css('background-position', 'center ' + _bgPosition + '%');
	}
	,_startOffset: undefined
});
```

<!--more-->

To use on an element with a class 'elm', you would have CSS something along the lines of:

``` css
.elm{
	background: no-repeat center center;
	background-image: url('/images/bg.jpg');
	/* insert browser prefixes */
	background-size: cover;
}
```

and would instantiate the class something like:

``` js
jQuery(function(){
	var _instance = new ParallaxBackground({elm: jQuery('.elm')});
});
```

What the script does is listen on the `window` object for 'load', 'resize', and 'scroll' events.  When these occur, it does some calculations based upon where the element is relative to the viewport, where the image just touching the top of the viewport is one end of the range and its top touching the bottom of the viewport is the other.  The calculations are used to modify the `background-position-y` of the element to one side or the other of 50%.  The `movementRatio` affects the rate of movement.  The 'centered' `calcType` does a straight calculation around 50%, but this was causing a jump on page load.  The default `calcType`, 'centeredStart', adds an offset so that the initial position is centered, removing the jump with the given CSS.

The math took me a little while to figure out, and the effect seems to become more subtle the narrow the viewport, but it worked well enough for the project I was working on.  <del>That project is not yet live, but I'll link to it when it is as a demonstration.</del>  [The original project is no longer live, and we aren't using it on other sites that I can think of.]
