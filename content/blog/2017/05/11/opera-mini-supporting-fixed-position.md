---
categories: [www]
date: 2017-05-11T23:44:36-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1477'
id: 1477
modified: 2019-09-17T22:57:09-04:00
name: opera-mini-supporting-fixed-position
tags: [browser, javascript, style, support]
---

Opera Mini now supports fixed position (sometimes)
==================================================

Looks like an update to Opera Mini brought support for `position: fixed` at last <ins>(in high savings mode, or sometimes extreme)</ins>.  I'll finally be able to remove my JS test for it.<!--more-->  Up until the update, Opera Mini would lie about its support of the position, applying it like a position absolute but positioned offset from the viewport when the page first loads.  This could result in content being trapped under elements that would "move" with the viewport in other browsers.

The JS I've been using looks like:

``` js
(function(_global, _doc){
	var _supports = false;
	var _html = _doc.documentElement;
	if(!(_global.operamini && ({}).toString.call(_global.operamini) === '[object OperaMini]')){
		var _el1 = _doc.createElement('div');
		_el1.style.cssText = 'top:0;height:10px;position:fixed;width:100%;';
		if(_el1.style.position === 'fixed' && _el1.getBoundingClientRect){
			var _body = _doc.body;
			var _hasBody = !!_body;
			if(!_hasBody){
				_body = _doc.createElement('body');
				_body.style.cssText = 'height:100%;width:100%;position:absolute;'
				_html.appendChild(_body);
			}
			var _el2 = _el1.cloneNode();
			_el2.style.top = '100%';
			_el2.style.position = 'absolute';
			_el2.appendChild(_el1);
			_body.appendChild(_el2);
			var _container = (++_body.scrollTop === _body.scrollTop && _body) || (++_html.scrollTop === _html.scrollTop && _html);
			_supports = (_container.scrollTop > 0 && _el1.getBoundingClientRect().top === 0)
			_body.removeChild(_el2);
			_container.scrollTop -= _container.scrollTop;
			if(!_hasBody){
				_html.removeChild(_body);
			}
		}
	}
	_html.className += ' ua-' + (_supports ? '' : 'no-') + 'fixed';
})(window, document);
```

I have to have fallback styles without the fixed positioning and use the `ua-fixed` class in my selectors for all styles related to fixed position.

Removing this will make the code easier to work on, remove the need for that blocking JS from my site, and ensure more users get the fixed appearance.

The fallback isn't that great, and I've been meaning to improve it for a while.  I've been thinking of updating how the fixed stuff works as well.

[update]Apparently, "extreme mode" sometimes doesn't support `fixed` and sometimes lies about it, but sometimes doesn't.  Progress.  I haven't figured out the conditions that cause a given set of behavior.[/update]
