---
categories: [www]
comment_count: 25
date: 2010-07-06T07:24:59+00:00
date_gmt: 2010-07-06T07:24:59+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=348'
id: 433
modified: 2020-01-16T20:38:13-05:00
modified_gmt: 2020-01-17T01:38:13+00:00
name: css-ie-shadows-and-rounded-corners
pings: ['http://www.htmlremix.com/css/curved-corner-border-radius-cross-browser']
tags: [css, css3, htc, ie, style]
---

CSS: IE Shadows and Rounded Corners With HTC
=============================================

[Update Synopsis] I've improved color support, now working for hex, rgb, and rgba at the beginning or end, re-added Nick's text-shadow support while giving it the same color support as box-shadow, and added an `-ms-` prefix to target <abbr title="Internet Explorer">IE</abbr> for these properties with.  I've made a [simple example page](http://webd.tobymackenzie.com/examples/css/iecss3htc/) and you can find the [file for download](http://code.google.com/p/box-shadow/issues/detail?id=1) in this Google Groups thread. [/Update]

At [Cogneato](http://cogneato.com) we use a lot of drop-shadows on elements in our designs, and a number of sites use rounded corners as well.  In the past, images had to be used for shadows and rounded corners, using a variety of techniques and often adding to page weight and requiring new images be made for site changes.  But CSS 2 and 3 introduced properties `text-shadow`, `box-shadow`, and `border-radius` to handle these display niceties without images.  These have slowly gained support among browsers, and now, with vendor specific versions, are supported by the most used non-IE browsers.  But IE still offers no support for them up to version 8.

HTC's (basically javascript that can be attached to CSS selectors in IE) have been used to handle a number of IE issues, and [Remiz Rahnas](http://www.htmlremix.com/css/curved-corner-border-radius-cross-browser) created one to support these CSS properties.  It has been updated by [Nick Fetchak](http://www.fetchak.com/ie-css3/) and moved to [Google Code](http://code.google.com/p/box-shadow/).  It allows you to add `behavior: url('ie-css3.htc');` to any elements with those properties and the properties are automatically applied in IE.  It works rather well, though it does still have some issues.  For instance, on sites with fading and other animations like the one I started using this on at Cogneato, the shadows don't fade or move with the rest of the content.

Another issue I had with the script is its handling of the color attributes of the `box-shadow` property.  If you place the color attribute before the unit declarations like I do (ie `box-shadow: #123456 5px 5px 5px;`), the htc doesn't work at all.  This was easy to change in the htc to get working.  It uses regex, so I just removed the `^` character, which denotes the beginning of a string, so the regex could be matched anywhere in the property.

It also happens that the htc doesn't support color for shadows.<!--more-->  The site I was working on uses a white shadow on a page.  I was hoping to not use images for that, so I modified the htc to handle white as well.  Now if the color is not black and in hex notation, the shadow will be color, otherwise it will be black.  For the color shadows, I am using a regular `div` rather than `v:roundrect`, so it won't support rounding either, though it didn't look like it did originally anyway.  I added an allowance for an IE vendor specific property, `-ie-box-shadow` in case you need to have different values than for other browsers (such as for rgba).  I set the opacity to a fixed lower number to make it look better.  If I can figure out a way to parse rgba values while still handling hex values, I can use those to set the opacity [now added].  Incidentally, it was Safari that made me use images for the white shadow:  It seems to have troubles with large shadows.

Since I couldn't find a way to add my changes on Google Code and Nick Fetchak didn't respond to an email, I will post my version here (I will update it if I figure out the color changes).  Wordpress.com doesn't allow for non-media files to be uploaded, so I will paste the whole thing (see [google code update page](http://code.google.com/p/box-shadow/issues/detail?id=1) for downloadable version):

``` htc
--Do not remove this if you are using--
Original Author: Remiz Rahnas
Original Author URL: http://www.htmlremix.com
Published date: 2008/09/24

Changes by Nick Fetchak:
- IE8 standards mode compatibility
- VML elements now positioned behind original box rather than inside of it - should be less prone to breakage
- Added partial support for 'box-shadow' style
- Checks for VML support before doing anything
- Updates VML element size and position via timer and also via window resize event
- lots of other small things
Published date : 2010/03/14
http://fetchak.com/ie-css3

Thanks to TheBrightLines.com (http://www.thebrightlines.com/2009/12/03/using-ies-filter-in-a-cross-browser-way) for enlightening me about the DropShadow filter

Changes by toby mackenzie
- Removed "^" form shadow regular expression so colors at beginning don't prevent it from working
- Added color and alpha support
- Add ie box-shadow property to override others (-ms-box-shadow)
Published date: 2010/07/18
http://tobymackenzie.com

<public:attach event="ondocumentready" onevent="ondocumentready('v08vnSVo78t4JfjH')" />
<script type="text/javascript">

timer_length = 200; // Milliseconds
border_opacity = false; // Use opacity on borders of rounded-corner elements? Note: This causes antialiasing issues


// supportsVml() borrowed from http://stackoverflow.com/questions/654112/how-do-you-detect-support-for-vml-or-svg-in-a-browser
function supportsVml() {
	if (typeof supportsVml.supported == "undefined") {
		var a = document.body.appendChild(document.createElement('div'));
		a.innerHTML = '<v:shape id="vml_flag1" adj="1" />';
		var b = a.firstChild;
		b.style.behavior = "url(#default#VML)";
		supportsVml.supported = b ? typeof b.adj == "object": true;
		a.parentNode.removeChild(a);
	}
	return supportsVml.supported
}


// findPos() borrowed from http://www.quirksmode.org/js/findpos.html
function findPos(obj) {
	var curleft = curtop = 0;

	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}

	return({
		'x': curleft,
		'y': curtop
	});
}

function rgbtohex(r,g,b) {return "#"+ntohex(r)+ntohex(g)+ntohex(b)}
function ntohex(n) {
	n=parseInt(n); if (n==0 || isNaN(n)) return "00";
	n=Math.max(0,n); n=Math.min(n,255); N=Math.round(n);
	return "0123456789abcdef".charAt((n-n%16)/16) + "0123456789abcdef".charAt(n%16);
}

function createBoxShadow(element, vml_parent) {
	var style = element.currentStyle['-ms-box-shadow'] || element.currentStyle['box-shadow'] || element.currentStyle['-moz-box-shadow'] || element.currentStyle['-webkit-box-shadow'] || '';
	var regexSize = /(#[0-9a-fA-F]{3,6})? *(d+)p?x? +(d+)p?x? +(d+)p?x?/;
	var testSize = regexSize.exec(style);
	if (!testSize) { return(false); }
	
	shadowcolor = "#000000";
	tmpopacity = 0.5;
	if(testSize[1]){
			shadowcolor = testSize[1];
	}else{
		var regexColorHex = /(#[0-9a-fA-F]*)/;
		var testColorHex = regexColorHex.exec(style);
		if(testColorHex){
			shadowcolor = testColorHex[1];
		}else{
			var regexColorRGBA = /brgba?((d+)s*,s*(d+)s*,s*(d+)s*,?s*(0?.?d*))/;
			var testColorRGBA = regexColorRGBA.exec(style);
			if(testColorRGBA){
				shadowcolor = rgbtohex(testColorRGBA[1], testColorRGBA[2], testColorRGBA[3]);
				if(testColorRGBA[4])
					tmpopacity = testColorRGBA[4];
			}
		}
	}
	if(shadowcolor == '#000')
		shadowcolor = '#000000';

	
	var shadow = document.createElement('v:roundrect');
	
	shadow.userAttrs = {
		'x': parseInt(testSize[2] || 0),
		'y': parseInt(testSize[3] || 0),
		'radius': parseInt(testSize[4] || 0) / 2,
		'color': shadowcolor,
		'opacity': tmpopacity
	};
	shadow.position_offset = {
		'y': (0 - vml_parent.pos_ieCSS3.y - shadow.userAttrs.radius + shadow.userAttrs.y),
		'x': (0 - vml_parent.pos_ieCSS3.x - shadow.userAttrs.radius + shadow.userAttrs.x)
	};
	shadow.size_offset = {
		'width': 0,
		'height': 0
	};
	shadow.arcsize = (isNaN(element.arcSize))? 0: element.arcSize;
	shadow.stroked = false;
	shadow.style.display = 'block';
	shadow.style.position = 'absolute';
	shadow.style.top = (element.pos_ieCSS3.y + shadow.position_offset.y) +'px';
	shadow.style.left = (element.pos_ieCSS3.x + shadow.position_offset.x) +'px';
	shadow.style.width = element.offsetWidth +'px';
	shadow.style.height = element.offsetHeight +'px';
	shadow.style.antialias = true;
	shadow.style.borderWidth = 0;
	shadow.fillcolor = shadow.userAttrs.color;
	shadow.className = 'vml_box_shadow';
	shadow.style.zIndex = element.zIndex - 1;
//	shadow.style.filter = 'progid:DXImageTransform.Microsoft.Blur(Add=0,Direction=225,Strength=10)';
	shadow.style.filter = 'progid:DXImageTransform.Microsoft.Blur(pixelRadius='+ shadow.userAttrs.radius +',makeShadow='+((shadow.userAttrs.color == '#000000')?'true':'false')+',shadowOpacity='+shadow.userAttrs.opacity +')';
	if(shadow.userAttrs.color != '#000000'){
		shadow.style.filter += ' progid:DXImageTransform.Microsoft.Alpha(Opacity='+(shadow.userAttrs.opacity*100)+')';
	}

	element.parentNode.appendChild(shadow);
	//element.parentNode.insertBefore(shadow, element.element);

	// For window resizing
	element.vml.push(shadow);

	return(true);
}

function createBorderRect(element, vml_parent) {
	if (isNaN(element.borderRadius)) { return(false); }

	element.style.background = 'transparent';
	element.style.borderColor = 'transparent';

	var rect = document.createElement('v:roundrect');
	rect.position_offset = {
		'y': (0.5 * element.strokeWeight) - vml_parent.pos_ieCSS3.y,
		'x': (0.5 * element.strokeWeight) - vml_parent.pos_ieCSS3.x
	};
	rect.size_offset = {
		'width': 0 - element.strokeWeight,
		'height': 0 - element.strokeWeight
	};
	rect.arcsize = element.arcSize;
	rect.strokeColor = element.strokeColor;
	rect.strokeWeight = element.strokeWeight +'px';
	rect.stroked = element.stroked;
	rect.className = 'vml_border_radius';
	rect.style.display = 'block';
	rect.style.position = 'absolute';
	rect.style.top = (element.pos_ieCSS3.y + rect.position_offset.y) +'px';
	rect.style.left = (element.pos_ieCSS3.x + rect.position_offset.x) +'px';
	rect.style.width = (element.offsetWidth + rect.size_offset.width) +'px';
	rect.style.height = (element.offsetHeight + rect.size_offset.height) +'px';
	rect.style.antialias = true;
	rect.style.zIndex = element.zIndex - 1;

	if (border_opacity && (element.opacity < 1)) {
		rect.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(Opacity='+ parseFloat(element.opacity * 100) +')';
	}

	var fill = document.createElement('v:fill');
	fill.color = element.fillColor;
	fill.src = element.fillSrc;
	fill.className = 'vml_border_radius_fill';
	fill.type = 'tile';
	fill.opacity = element.opacity;

	// Hack: IE6 doesn't support transparent borders, use padding to offset original element
	isIE6 = /msie|MSIE 6/.test(navigator.userAgent);
	if (isIE6 && (element.strokeWeight > 0)) {
		element.style.borderStyle = 'none';
		element.style.paddingTop = parseInt(element.currentStyle.paddingTop || 0) + element.strokeWeight;
		element.style.paddingBottom = parseInt(element.currentStyle.paddingBottom || 0) + element.strokeWeight;
	}

	rect.appendChild(fill);
	element.parentNode.appendChild(rect);
	//element.parentNode.insertBefore(rect, element.element);

	// For window resizing
	element.vml.push(rect);

	return(true);
}

function createTextShadow(element, vml_parent) {
	this.textShadow = this.currentStyle['-ms-text-shadow'] || this.currentStyle['text-shadow'];
	if (!element.textShadow) { return(false); }
	var style = element.textShadow;

	var regexSize = /(#[0-9a-fA-F]{3,6})? *(d+)p?x? +(d+)p?x? +(d+)p?x?/;
	var testSize = regexSize.exec(style);

	shadowcolor = "#000000";
	opacity = 0.75;
	if(testSize[1]){
			shadowcolor = testSize[1];
	}else{
		var regexColorHex = /(#[0-9a-fA-F]*)/;
		var testColorHex = regexColorHex.exec(style);
		if(testColorHex){
			shadowcolor = testColorHex[1];
		}else{
			var regexColorRGBA = /brgba?((d+)s*,s*(d+)s*,s*(d+)s*,?s*(0?.?d*))/;
			var testColorRGBA = regexColorRGBA.exec(style);
			if(testColorRGBA){
				shadowcolor = rgbtohex(testColorRGBA[1], testColorRGBA[2], testColorRGBA[3]);
				if(testColorRGBA[4])
					opacity = testColorRGBA[4];
			}
		}
	}
	if(shadowcolor == '#000')
		shadowcolor = '#000000';

	//var shadow = document.createElement('span');
	var shadow = element.cloneNode(true);
	var radius = parseInt(testSize[4] || 0);
	shadow.userAttrs = {
		'x': parseInt(testSize[2] || 0),// - (radius),
		'y': parseInt(testSize[3] || 0),// - (radius),
		'radius': radius,// / 2,
		'color': shadowcolor,
		'opacity': opacity
	};
	shadow.position_offset = {
		'y': (0 - vml_parent.pos_ieCSS3.y + shadow.userAttrs.y),
		'x': (0 - vml_parent.pos_ieCSS3.x + shadow.userAttrs.x)
	};
	shadow.size_offset = {
		'width': 0,
		'height': 0
	};
	shadow.style.color = shadow.userAttrs.color;
	shadow.style.position = 'absolute';
	shadow.style.top = (element.pos_ieCSS3.y + shadow.position_offset.y) +'px';
	shadow.style.left = (element.pos_ieCSS3.x + shadow.position_offset.x) +'px';
	shadow.style.antialias = true;
	shadow.style.behavior = null;
	shadow.className = 'ieCSS3_text_shadow';
	shadow.innerHTML = element.innerHTML;
	// For some reason it only looks right with opacity at 75%
/*	shadow.style.filter = '
		progid:DXImageTransform.Microsoft.Alpha(Opacity='+(shadow.userAttrs.opacity*100)+')
		progid:DXImageTransform.Microsoft.Blur(pixelRadius='+ 100 +',makeShadow=false,shadowOpacity=100)
	';
*/
//	shadow.style.filter = 'progid:DXImageTransform.Microsoft.Blur(pixelRadius='+ shadow.userAttrs.radius +',makeShadow='+((shadow.userAttrs.color == '#000000')?'true':'false')+',shadowOpacity='+shadow.userAttrs.opacity +')';
shadow.style.filter = 'progid:DXImageTransform.Microsoft.Blur(pixelRadius='+shadow.userAttrs.radius+')';
	shadow.style.filter += ' progid:DXImageTransform.Microsoft.Alpha(Opacity='+(shadow.userAttrs.opacity*100)+')';

	var clone = element.cloneNode(true);
	clone.position_offset = {
		'y': (0 - vml_parent.pos_ieCSS3.y),
		'x': (0 - vml_parent.pos_ieCSS3.x)
	};
	clone.size_offset = {
		'width': 0,
		'height': 0
	};
	clone.style.behavior = null;
	clone.style.position = 'absolute';
	clone.style.top = (element.pos_ieCSS3.y + clone.position_offset.y) +'px';
	clone.style.left = (element.pos_ieCSS3.x + clone.position_offset.x) +'px';
	clone.className = 'ieCSS3_text_shadow';


	element.parentNode.appendChild(shadow);
	element.parentNode.appendChild(clone);

	element.style.visibility = 'hidden';

	// For window resizing
	element.vml.push(clone);
	element.vml.push(shadow);

	return(true);
}

function ondocumentready(classID) {
	if (!supportsVml()) { return(false); }

  if (this.className.match(classID)) { return(false); }
	this.className = this.className.concat(' ', classID);

	// Add a namespace for VML (IE8 requires it)
	if (!document.namespaces.v) { document.namespaces.add("v", "urn:schemas-microsoft-com:vml"); }

	// Check to see if we've run once before on this page
	if (typeof(window.ieCSS3) == 'undefined') {
		// Create global ieCSS3 object
		window.ieCSS3 = {
			'vmlified_elements': new Array(),
			'update_timer': setInterval(updatePositionAndSize, timer_length)
		};

		if (typeof(window.onresize) == 'function') { window.ieCSS3.previous_onresize = window.onresize; }

		// Attach window resize event
		window.onresize = updatePositionAndSize;
	}


	// These attrs are for the script and have no meaning to the browser:
	this.borderRadius = parseInt(this.currentStyle['-ms-border-radius'] ||
	                             this.currentStyle['border-radius'] ||
	                             this.currentStyle['-moz-border-radius'] ||
	                             this.currentStyle['-webkit-border-radius'] ||
	                             this.currentStyle['-khtml-border-radius']);
	this.arcSize = Math.min(this.borderRadius / Math.min(this.offsetWidth, this.offsetHeight), 1);
	this.fillColor = this.currentStyle.backgroundColor;
	this.fillSrc = this.currentStyle.backgroundImage.replace(/^url("(.+)")$/, '$1');
	this.strokeColor = this.currentStyle.borderColor;
	this.strokeWeight = parseInt(this.currentStyle.borderWidth);
	this.stroked = 'true';
	if (isNaN(this.strokeWeight) || (this.strokeWeight == 0)) {
		this.strokeWeight = 0;
		this.strokeColor = fillColor;
		this.stroked = 'false';
	}
	this.opacity = parseFloat(this.currentStyle.opacity || 1);

	this.element.vml = new Array();
	this.zIndex = parseInt(this.currentStyle.zIndex);
	if (isNaN(this.zIndex)) { this.zIndex = 0; }

	// Find which element provides position:relative for the target element (default to BODY)
	vml_parent = this;
	var limit = 100, i = 0;
	do {
		vml_parent = vml_parent.parentElement;
		i++;
		if (i >= limit) { return(false); }
	} while ((typeof(vml_parent) != 'undefined') && (vml_parent.currentStyle.position != 'relative') && (vml_parent.tagName != 'BODY'));

	vml_parent.pos_ieCSS3 = findPos(vml_parent);
	this.pos_ieCSS3 = findPos(this);

	var rv1 = createBoxShadow(this, vml_parent);
	var rv2 = createBorderRect(this, vml_parent);
	var rv3 = createTextShadow(this, vml_parent);
	if (rv1 || rv2 || rv3) { window.ieCSS3.vmlified_elements.push(this.element); }

	if (typeof(vml_parent.document.ieCSS3_stylesheet) == 'undefined') {
		vml_parent.document.ieCSS3_stylesheet = vml_parent.document.createStyleSheet();
		vml_parent.document.ieCSS3_stylesheet.addRule("v\:roundrect", "behavior: url(#default#VML)");
		vml_parent.document.ieCSS3_stylesheet.addRule("v\:fill", "behavior: url(#default#VML)");
		// Compatibility with IE7.js
		vml_parent.document.ieCSS3_stylesheet.ie7 = true;
	}
}

function updatePositionAndSize() {
	if (typeof(window.ieCSS3.vmlified_elements) != 'object') { return(false); }

	for (var i in window.ieCSS3.vmlified_elements) {
		var el = window.ieCSS3.vmlified_elements[i];

		if (typeof(el.vml) != 'object') { continue; }

		for (var z in el.vml) {
			//var parent_pos = findPos(el.vml[z].parentNode);
			var new_pos = findPos(el);
			new_pos.x = (new_pos.x + el.vml[z].position_offset.x) + 'px';
			new_pos.y = (new_pos.y + el.vml[z].position_offset.y) + 'px';
			if (el.vml[z].style.left != new_pos.x) { el.vml[z].style.left = new_pos.x; }
			if (el.vml[z].style.top != new_pos.y) { el.vml[z].style.top = new_pos.y; }

			var new_size = {
				'width': parseInt(el.offsetWidth + el.vml[z].size_offset.width),
				'height': parseInt(el.offsetHeight + el.vml[z].size_offset.height)
			}
			if (el.vml[z].offsetWidth != new_size.width) { el.vml[z].style.width = new_size.width +'px'; }
			if (el.vml[z].offsetHeight != new_size.height) { el.vml[z].style.height = new_size.height +'px'; }
		}
	}

	if (event && (event.type == 'resize') && typeof(window.ieCSS3.previous_onresize) == 'function') { window.ieCSS3.previous_onresize(); }
}
</script>
```

[Update 7/12/2010] Modified regex to more properly handle colors at end.  I've now posted this file in [response to an "issue" on the google code site](http://code.google.com/p/box-shadow/issues/detail?id=1), so you can download it rather than copying and pasting. [/update]

[Update 7/18/2010] Alright, I've gone and added `rgb` and `rgba` support to this.  It was quite a challenge with the regex, for me at least, and took me a while.  The `rgba` allows setting of the opacity in addition to the color.  Note that I also changed the check for `-ie-box-shadow` to `-ms-box-shadow` to more closely match the example of  `-ms-filter`.  The more of CSS3 IE can be made to support, the better, even if it does require JavaScript.[/Update]

[Update 7/22/2010] I somehow was using an older version of the script as my starting point, which was missing some updates Nick Fetchak made in March.  The major thing was he had `text-shadow` support.  So I did my best at merging my changes in with his, while adding `rgba` support to the `text-shadow`'s as well.  I hopefully haven't messed up some functionality of anything in so doing.  It took longer than anticipated and I didn't test some circumstances, such as dynamic content.  Also, I used some of my conventions, such as browser prefix `-ms-` over `iecss3-`.  The `text-shadow` still looks different from other browsers because of oddities with the blur filter, but fixing that will have to wait for another day.  [/Update]

[Update 12/30/2010] Removed large unnecessary commented out block that was a near duplicate of the `createBoxShadow` function, not sure why that was there. [/Update]

[Update 2/9/2011] Created a [simple example](http://webd.tobymackenzie.com/examples/css/iecss3htc/) [/update]

[Update 2/12/2011] Fixed rounding of box-shadow corners [/update]
