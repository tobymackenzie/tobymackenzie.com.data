---
categories: [www]
comment_count: 2
date: 2013-07-07T23:56:26-05:00
date_gmt: 2013-07-08T04:56:26+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=540'
id: 540
modified: 2020-11-26T21:11:00-05:00
modified_gmt: 2020-11-27T02:11:00+00:00
name: responsive-turn-image-maps-into-selects
tags: [javascript, responsive]
---

Responsive: Turn Image Maps Into Selects
========================================

I've been doing quite a few responsive sites since I first started into them.  I like doing them.  They are fun to build, requiring new techniques and a different way of thinking to handle different situations.  I like the concept and I like looking at the sites.  One recent fun thing was dealing with an image map.  Scaling the image and coordinates would be a pain and very expensive.  An alternative option is to replace the image with a select drop down when the screen is too small for the image.

Breakpoint detection
--------------------

I don't remember where I found this method of dealing with breakpoints in JavaScript, but I've been setting the line height on the html tag with media queries and reading it with JavaScript to determine which breakpoint I'm in.  This works with the 'em' based breakpoints I use.  I convert the numbers to more descriptive names, such as 'small', 'medium', and 'large'.  It looks something like this:

<!--more-->

``` html
<style>
	html{
		line-height: 100;
	}
	@media screen and (max-width: 66em){
		html{
			line-height: 66;
		}
	}
	@media screen and (max-width: 50em){
		html{
			line-height: 50;
		}
	}
	@media screen and (max-width: 40em){
		html{
			line-height: 40;
		}
	}
	@media screen and (max-width: 30em){
		html{
			line-height: 530;
		}
	}
</style>
<script>
	var $window = jQuery(window);
	var $html = jQuery('html');
	var _getBreakPoint = function(){
		var _return;
		var _screenWidth = $html.width();
		var _lineHeight = $html.css('line-height')
		//--handle browsers that convert values to 'px'
		if(_lineHeight.indexOf('px') > -1){
			_lineHeight = parseInt(_lineHeight) / 10;
		}
		if(_lineHeight > 66){
			_return = 'large';
		}else if(_lineHeight > 48){
			_return = 'medium';
		}
		}else{
			_return = 'small';
		}
		return _return;
	};
	var _currentBreakPoint;
	var _resizeTimeout;
	var _resizeHandlers = [];
	var _handleResize = function(){
		var _newBreakPoint = _getBreakPoint();
		var _handlerLength = _resizeHandlers.length;
		if(_newBreakPoint !== _currentBreakPoint){
			for(var _i; _i < _handlerLength; ++_i){
				_resizeHandlers[_i](_newBreakPoint, _currentBreakPoint);
			}
			_currentBreakPoint = _newBreakPoint;
		}
	}
	$window.on('resize', function(){
		clearTimeout(_resizeTimeout);
		_resizeTimeout = setTimeout(_handleResize, 150);
	});
	_handleResize();
</script>
```

I can then have behavior that handles when window changing to a different breakpoint size.

Converting the map to a select
------------------------------

Since I develop for wide view port first, I deliver the image map with the page from the server.  The select doesn't exist:  I build it with JavaScript only if needed.  So I add a handler to my breakpoint switch monitor from above.  It either hides the image and shows the select or vice versa, depending on the breakpoint, and if the select hasn't been created yet, it does that.  To do so, it goes through all the area elements in the map and turns each into an option for the select. This looks something like:

``` html
<script>
	//==contacts
	var $contactMap = jQuery('.contactMap');
	if($contactMap.length){
		var $contactSelect = null;
		var _createContactMenu = function(){
			var $contactMapAreas = $contactMap.find('area');
			$contactSelect = jQuery('<select name="contactRegions"><option value="">--Select a state to view its regional contact(s)</option></select>');
			$contactMapAreas.each(function(){
				var $this = jQuery(this);
				var _href = $this.attr('href');
				var _state = $this.attr('title');
				$contactSelect.append(jQuery('<option value="' + _href + '">' + _state + '</option>'));
			});
			$contactSelect.on('change', function(){
				var $this = jQuery(this);
				var _val = $this.val();
				if(_val){
					window.location = _val;
				}
			});
		}
		_resizeHandlers.push(function(_newBreakPoint, _currentBreakPoint){
			if(_newBreakPoint !== _currentBreakPoint){
				switch(_newBreakPoint){
					case 'small':
						if($contactSelect === null){
							_createContactMenu();
							$contactMap.after($contactSelect);
						}
						$contactMap.hide();
						$contactSelect.show();
					break;
					default:
						$contactMap.show();
						if($contactSelect !== null){
							$contactSelect.hide();
						}
					break;
				}
			}
		});
	}
</script>
```

Conclusion
----------

I think this solution worked well for the this site.  The image map was a map of states in the USA, which would get too tiny if shrunk down for a mobile screen, and each map area was easily converted into text.  As I do more of these sites, I will continue to find more techniques and refine them.

[Update]This was made for the Elastikote contact page, but is no longer in use.[/Update]
