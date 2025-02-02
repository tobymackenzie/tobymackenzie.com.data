---
categories: [www]
date: 2010-06-28T08:44:28+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=332'
id: 430
modified: 2019-10-17T22:32:48-04:00
name: david-hawkins-jquery-image-reflections
tags: [cogneato, javascript, jquery, reflection]
---

David Hawkins: JQuery Image Reflections
=======================================

The design of the gallery portion of the David Hawkins site I'm working on at [Cogneato](http://cogneato.com) called for a reflection of the current image below that image.  This could have been done by making reflections for each image in an image editor and then adding them to a separate field in the CMS.  That would have been a pain and would require (most likely) us to be involved for each image added.

Luckily, since this site was already going to be using jQuery, I was able to find a [jQuery plugin](http://www.digitalia.be/software/reflectionjs-for-jquery) that handles the reflections automatically on page load.  People without javascript just won't get reflections.  It works in modern browsers and IE 6-8.  It is less than 2kB, which would be much smaller than even a single separate reflection image, though the now-more-bloated 72kB jQuery might ruin size benefits if we weren't using it already.  And as far as adding images to the site, the reflection is added automatically, well worth it.

Because of the design of the site, I had to modify the script somewhat to make it work properly.  One issue was that I had a border around my images.<!--more-->  The original script, version 1.03, adds the element with position static, which is hard to make work with borders.  I changed it to position absolutely.  I had to add a margin to the container and position relatively (I did this in CSS, though it could be done by the script), and a border pixel width parameter to the script to offset the reflection properly (this could probably be figured in the script).  The border parameter has been giving me troubles and doesn't end up being the same as the actual border setting, nor does it necessarily work the same in all browsers.

The design also called for the reflection to be slightly offset from the image, so I added a parameter for that as well.  The parameter, like for the border, is an integer that is a pixel dimension.

One final change I had to make was due to the fact that the gallery is loaded through AJAX:  I add reflections to images in containers set to `display: none`.  IE then sees the images as having no height, and thus gives the reflections no height.  A comment by Albin Larsson on the plugin site suggested adding a new image element and grabbing the height from that, so I added that to my version as well.

My updated version of the script is not perfect and has issues (some mentioned aboved), and since I'm still working on the site, I may improve it further.  Still, I will post it here for those who may find it useful (it has an MIT license, so this should be okay).  I'd simply post the changes I made, but I don't remember where all of them were.  If the plugin author updates his script, you'll have to find where the changes were and figure out how to get them into his new version.  Note also that this was cleaned up from the version in use, so I could have made a mistake somewhere.

``` js
/*
	reflection.js for jQuery v1.03.tm1
	(c) 2006-2009 Christophe Beyls <http://www.digitalia.be>
	MIT-style license.
	
	modified by toby mackenzie: position absolute, border friendly, offset, handling hidden images in IE
*/
(function(a){a.fn.extend({reflect:function(b){b=a.extend({height:1/3,opacity:0.5,border:0,offset:0},b);return this.unreflect().each(function(){var c=this;if(/^img$/i.test(c.tagName)){function d(){ni=new Image();ni.src=c.src;var g=c.width||ni.width,f=c.height||ni.height;var l,i,m,h,k;i=Math.floor((b.height>1)?Math.min(f,b.height):f*b.height);if(a.browser.msie){l=a("<div />").addClass("reflectionwrap").css({width:g,height:i,overflow:"hidden"})[0]; }else{l=a("<canvas />")[0];if(!l.getContext){return}h=l.getContext("2d");try{a(l).attr({width:g,height:i});h.save();h.translate(0,f-1);h.scale(1,-1);h.drawImage(c,0,0,g,f);h.restore();h.globalCompositeOperation="destination-out";k=h.createLinearGradient(0,0,0,i);k.addColorStop(0,"rgba(255, 255, 255, "+(1-b.opacity)+")");k.addColorStop(1,"rgba(255, 255, 255, 1.0)");h.fillStyle=k;h.rect(0,0,g,i);h.fill()}catch(j){return}}a(l).css({display:"block",position:"absolute",top:f+b.border+1+b.offset,left:b.border});m=a(/^a$/i.test(c.parentNode.tagName)?"<span />":"<div />").insertAfter(c).append([c,l])[0];m.className=c.className;a.data(c,"reflected",m.style.cssText=c.style.cssText);c.style.cssText="display: block;";c.className="reflected";if(a.browser.msie){$(c).parent(".image").children(".reflectionwrap").append("<img />").children("img").attr("src",c.src).css({width:g,height:f,filter:"flipv progid:DXImageTransform.Microsoft.Alpha(opacity="+(b.opacity*100)+", style=1, finishOpacity=0, startx=0, starty=0, finishx=0, finishy="+(i/f*100)+")"})}}if(c.complete){d()}else{a(c).load(d)}}})},unreflect:function(){return this.unbind("load").each(function(){var c=this,b=a.data(this,"reflected"),d;if(b!==undefined){d=c.parentNode;c.className=d.className;c.style.cssText=b;a.removeData(c,"reflected");d.parentNode.replaceChild(c,d)}})}})})(jQuery);

// AUTOLOAD CODE BLOCK (MAY BE CHANGED OR REMOVED)
/*
jQuery(function($) {
	$("img.reflect").reflect({});
});
*/
```
