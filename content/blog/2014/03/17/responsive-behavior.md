---
categories: [www]
date: 2014-03-17T02:11:33-05:00
guid: 'http://tobymackenzie.wordpress.com/?p=582'
id: 582
modified: 2017-10-19T23:24:02-05:00
name: responsive-behavior
tags: [behavior, javacript, responsive]
---

Responsive Behavior
===================

Styles (ie CSS) are the primary focus when it comes to making a site responsive, but the behavior (ie JavaScript) must also be able to react differently to different circumstances.  A site might have a horizontal navigation with drop-down menus for wider viewports, but a simple vertical slide open and closed navigation for narrow viewports.  The site must not only be able to change the styles that make those menus look right but also the script that drives the behavior.  Some behavior might even need to manipulate that DOM to function properly, such as sliding banners with inserted navigation.  The DOM will need to be changed one way for certain viewport sizes and those changes reverted, and possibly other changes made, when switching to different viewport sizes.

One might contend that most viewers won't be switching their viewport dimensions, but window resizing does happen, text can be resized (for 'em' breakpoints), and mobile devices can be rotated.  The site should not break when this happens.  Also, even without changes, the correct behavior must be run.

For dealing with this, I have created a [ResponsiveHandler class](https://github.com/tobymackenzie/Web-ClientBehavior/blob/master/src/ua/ResponsiveHandler.js) that listens for resizing of the window and fires an event when changing breakpoints.  For each behavior that needs it, I listen for this event and run the appropriate construction and destruction depending on what the new and old breakpoints are/were.  Behaviors can also simply use the class to determine which breakpoint the site is currently in and act accordingly.

<!--more-->

Example Setup
---------------

Before I provide an example, I should note that I use 'em's for my breakpoints.  This allows sites to respond appropriately even when users resize their text.  I also do desktop first.  To accurately determine what the width of the viewport is in the same 'em's that are used by CSS for the breakpoints, I have been relying on CSS media queries to set a property that I can then check in JavaScript to determine where I'm at.  I've been using `line-height` on the  element so I can get a value from all CSS capable browsers and not affect the layout of the site (by setting a proper `line-height` on ).  I am considering using a different property to store names, like [this trick using `content` or `font-family`](http://css-tricks.com/making-sass-talk-to-javascript-with-json/), but haven't moved to that yet, so my example will still use the `line-height`.

The base setup for using the ResponsiveHandler will involve setting the breakpoints in CSS and using those same breakpoints as configuration when instantiating the ResponsiveHandler.  This may look something like this:

### Requisite CSS

```CSS
html{ /* for non-media query supporting browsers, represents wvp (wide viewport) */
	line-height: 100;
}
@media screen and (max-width: 52em){ /* represents mvp (medium viewport) */
	html{
		line-height: 52;
	}
}
@media screen and (max-width: 38em){ /* represents nvp (narrow viewport) */
	html{
		line-height: 38;
	}
}
```

### ResponsiveHandler

```js
define('responsiveHandler', ['tmlib/ua/ResponsiveHandler'], function(ResponsiveHandler){
	return new ResponsiveHandler({
		breakpoints: {
			nvp: 38
			,mpv: 52
			,wvp: 100
		}
	})
});
```

Construct and Destroy
--------------------

When we need completely different behavior for different breakpoints, we can use constructors and destructors to enable and disable behavior appropriately.  For most of my classes, I have been giving them `activate` and `deactivate` methods that enable/reenable and disable functionality, attach and remove listeners, changing the DOM, etc.  They leave properties that should remain intact alone.  jQuery plugins will generally have a `destroy` method that can be called to run all destruction.

I will demonstrate using the popular jQuery plugin, [Cycle2](http://jquery.malsup.com/cycle2/).  In this example, we will have the cycle plugin active for medium and wide viewports, but just show the first banner for narrow viewports.  We will insert navigation for the banners when they are active.

### Our HTML

```html
…
<div class="bannerContainer">
	<ul class="bannerList">
		<li class="bannerItem n-1">
			<img alt="" class="bannerImage" img="/banners/1.jpg" />
			<div class="bannerText">The first banner</div>
		</li>
		<li class="bannerItem">
			<img alt="" class="bannerImage" img="/banners/2.jpg" />
			<div class="bannerText">The second banner</div>
		</li>
	</ul>
</div>
```

### Some CSS

```css
.bannerList{
	position: relative;
}
@media screen and (max-width: 38em){
	.bannerItem{
		display: none;
	}
	.bannerItem.n-1{
		display: block;
	}
}

```

### Our JavaScript

```js
define('banners', ['jquery', 'cycle2', 'responsiveHandler'], function(jQuery, cycle2, responsiveHandler){
	var bannerContainers;
	var init = function(resizeData){
		if(!bannerContainers){
			bannerContainers = jQuery('.bannerContainer');
		}
		if(bannerContainers.length){
			bannerContainers.each(function(){
				var bannerContainer = jQuery(this);

				//--will be cacheing some data on container
				var nav = bannerContainer.data('bannerNav');

				//--handle breakpoint changes if needed
				if(resizeData.lastBreakPoint !== 'nvp' && resizeData.breakPoint === 'nvp'){
					//--when changing to nvp from another breakpoint, we want to destroy the cycle2 behavior and detach the nav
					nav.detach();
					bannerList.cycle('destroy');
				}else if(resizeData.breakPoint !== 'nvp' && (resizeData.lastBreakPoint === 'nvp' || !resizeData.lastBreakPoint)){
					//--when changing to mvp or wvp from nvp or on initial load, set up and run cycle plugin

					var bannerList = bannerContainer.data('bannerList');
					var navList = bannerContainer.data('bannerNavList');
					var bannerSettings = bannerContainer.data('bannerSettings');

					//---find banner container if not found yet
					if(!bannerContainer){
						bannerList = bannerContainer.find('.bannerList');
						bannerContainer.data('bannerList', bannerList);
					}

					//---create banner nav if not created yet
					if(!nav){
						nav = jQuery('<div class="bannerNav">');

						navList = jQuery('<ul class="bannerNavList">');

						nav.append(navList);

						bannerContainer
							.data('bannerNav', bannerNav)
							.data('bannerNavList', bannerNavList)
						;
					}

					//---create cycle2 settings map if not created yet
					if(!bannerSettings){
						bannerSettings = {
							fx: 'fade'
							,pager: navList
							,pagerTemplate: '<li class="bannerNavItem n-{{slideNum}}"><a class="bannerNavLink" href="#{{slideNum}}"><span class="index">{{slideNum}}</span></a></li>'
							,slides: '.bannerItem'
							,sync: false
						}
						bannerContainer.data('bannerSettings', bannerSettings);
					}

					//---attach nav and construct
					bannerContainer.append(nav);
					bannerList.cycle(bannerSettings);
				}
			});
		}
	};

	//--run init both on page load and on breakpoint change
	jQuery(function(){
		init({breakpoint: responsiveHandler.determineBreakPoint()});
	});
	responsiveHandler.sub('change', init);
});
```

Note that I wrote this code for this post, and it has not been directly tested, but is based on code I've written for actual sites.

Behavior Modification
---------------------

Some of my newer behavioral classes have been using ResonsiveHandler to determine the current breakpoint as behavior is run to branch to breakpoint appropriate behavior.  An example of this might be having a navigation object leave the same listeners in place regardless of breakpoint but then performing different animations for narrow viewport than other viewports.  To be brief (since this post is quite long already), a listener for top menu items might look like:

```js
…
	var _this = this;
	this.container.on('click mousenter', '.topNavItem', function(){
		var topNavItem = jQuery(this);
		var subNavList = topNavItem.find('.subNavList');
		if(_this.responsiveHandler.getBreakPoint() === 'nvp'){
			subNavList.slideToggle();
		}else{
			clearTimeout(_this.timeout);
			subNavList.show();
		}
	});
	this.container.on('mouseleave', '.topNavItem', function(){
		if(_this.responsiveHandler.getBreakPoint() !== 'nvp'){
			var topNavItem = jQuery(this);
			var subNavList = topNavItem.find('.subNavList');
			_this.timeout = setTimeout(function(){
				subNavList.hide();
			}, _this.delay);
		}
	});
…
```

Conclusion
----------

As I do more and more responsive sites, I have ran into more different situations requiring different solutions.  I've also continued to improve my techniques for dealing with previously encountered problems.  I had to deal with changing behavior early on in building responsive sites and have come up with solutions as needed.  I haven't developed as many techniques for responding with behavior as I have with styles, and I think that is true of the development community as a whole as well.  I think as responsiveness becomes more ingrained in our development practices, we will refine the ways we deal with behavior issues and standardize common techniques in best practices and libraries.
