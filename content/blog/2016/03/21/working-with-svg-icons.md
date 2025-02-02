---
categories: [www]
date: 2016-03-21T00:41:55-05:00
guid: 'http://tobymackenzie.name/log/?p=349'
id: 349
modified: 2016-04-30T02:12:09-05:00
name: working-with-svg-icons
tags: [icons, svg, webd]
---

Working with SVG Icons
======================

At Cogneato, we've been using icon fonts for at least a couple years now.  We recently started using SVG icons for a new part of our CMS that allows clients to pick icons from large collections for use in their content.  Working with SVG's is a bit different than with icon fonts, so I created some helper code to make it easy to get them in place, have proper accessibility, and 

I like icon fonts fairly well, but there are some advantages to using SVG icons.  For us, we were wanting to allow clients to pick from a large selection of icons from within our CMS.  Requiring downloads of giant icon sets so they could have a large selection but only show a few on a page would be very bandwidth inefficient, and managing loading the set(s) a particular client wanted to use would be complicated.  Unless they use a lot on a single site, cherry-picking each icon should use less bandwidth.  This is easy to do with SVG's.

There are many ways to use SVG's, but when you need to be able to change colors based on context as we do, inlining SVG elements is the only (practical[^1]) way.  With them, you can use `fill: currentColor;` to use the text color of the container, which we need.  Many SVG tutorials [use SVG sprite-sheets](https://css-tricks.com/svg-sprites-use-better-icon-fonts/) and then inline spartan SVG elements that contain little other than the `<use>` element to reference icons from the sheet, saving size for repeated icons and [potentially allowing the sprite-sheet to be cached](https://css-tricks.com/svg-use-with-external-reference-take-2/).  However, sheets have the same bandwidth management issues as the icon fonts.  So I went with direct DOM insertion.

<!--more-->

Server-Side
-----------

Our icon fonts could be added by simply adding classes to elements.  Inserting SVG content manually would be way too impractical in so many ways, so we needed something more advanced.  Our CMS has a PHP widget system, so I made a widget that takes a set and name of an icon font, grabs the file from a defined location, transforms it for document use, and outputs it into the document.  The transform part is to:

- remove the XML document stuff
- [handle accessibility](https://gist.github.com/davidhund/564331193e1085208d7e#gistcomment-1587234)
- [set an appropriate width and height](https://sarasoueidan.com/blog/svg-style-inheritance-and-FOUSVG/)
- ensure the `id` is unique
- set any other desired attributes

I have made a simplified version of this for this post:

``` php
<?php
use DomDocument;
use Exception;

class IconRenderer{
	$uniqueCounter = 0;
	$svgPath = '/path/to/svg/icons';
	public function getUniqueId(){
		return ++$this->uniqueCounter;
	}
	public function renderSVG($opts){
		$opts = array_merge(Array(
			'ariaVisible'=> null
			,'attr'=> null
			,'classes'=> 'icon-svg'
			,'content'=> null
			,'height'=> null
			,'name'=> null
			,'output'=> 'html'
			,'title'=> null
			,'width'=> 32
		), $opts);

		//--grab and parse SVG document
		if(isset($opts['content'])){
			$dom = new DomDocument(($opts['content']));
		}elseif(isset($opts['name'])){
			$path = $this->svgPath . $opts['name'] . '.svg';
			if(file_exists($path)){
				$dom = new DomDocument();
				$dom->load($path);
			}else{
				throw new Exception("Icon {$opts['name']} not found.");
			}
		}else{
			throw new Exception("renderSVG() requires either 'content' or a 'name'.");
		}
		$root = $dom->documentElement;

		//--set `id` as passed or generate a unique id
		if(!isset($opts['id'])){
			$opts['id'] = ($root->hasAttribute('id') ? $root->getAttribute('id') : 'svg-') . $this->getUniqueId();
		}
		if($opts['id']){
			$root->setAttribute('id', $opts['id']);
		}

		//--set dimensions
		if(isset($opts['width'])){
			if($opts['width'] === false){
				$root->removeAttribute('width');
			}else{
				//--if no explicit height, determine height based on determined aspect ratio
				if(!isset($opts['height'])){
					//--determine aspect ratio
					if($root->hasAttribute('viewBox')){
						$viewBox = explode(' ', $root->getAttribute('viewBox'));
						$oldWidth = $viewBox[0] - $viewBox[2];
						$oldHeight = $viewBox[1] - $viewBox[3];
					}elseif($root->hasAttribute('width') && $root->hasAttribute('height')){
						$oldWidth = (int) preg_replace('/[\w]+/', '', $root->getAttribute('width'));
						$oldHeight = (int) preg_replace('/[\w]+/', '', $root->getAttribute('height'));
					}

					if(isset($oldWidth)){
						$opts['height'] = $opts['width'] * $oldHeight / $oldWidth;
					}
				}
				$root->setAttribute('width', $opts['width']);
			}
		}
		if(isset($opts['height'])){
			if($opts['height'] === false){
				$root->removeAttribute('height');
			}else{
				$root->setAttribute('height', $opts['height']);
			}
		}

		//--add, remove, or replace title based on 'title' option
		$titleElm = null;
		foreach($root->getElementsByTagName('title') as $loopTitleElm){
			if($loopTitleElm->parentNode === $root){
				$titleElm = $loopTitleElm;
			}
		}
		if(isset($opts['title'])){
			//--if we have a title element and the option is false, remove it
			if($opts['title'] === false){
				if($titleElm){
					$root->removeChild($titleElm);
					$titleElm = null;
				}
			//--if we have a title, set or add the element + value
			}else{
				if(!isset($opts['ariaVisible'])){
					$opts['ariaVisible'] = true;
				}
				if($titleElm){
					//--if we have a title, remove its contents
					while(isset($titleElm->firstChild)){
						$titleElm->removeChild($titleElm->firstChild);
					}
				}else{
					//--otherwise, create a new element
					$titleElm = $dom->createElement('title');
					$root->appendChild($titleElm);
				}
				$titleElm->appendChild($dom->createTextNode($opts['title']));
			}
		}elseif($titleElm){
			//--if we have a title element but no title option is passed and 'ariaVisible' isn't set, assume we want 'ariaVisible'
			if(!isset($opts['ariaVisible'])){
				$opts['ariaVisible'] = true;
			//--remove title element if `ariaVisible` is false
			}elseif($opts['ariaVisible'] === false){
				$root->removeChild($titleElm);
				$titleElm = null;
			}
		}

		//--set aria-stuff / role based on 'ariaVisible' option
		if($opts['ariaVisible']){
			$root->removeAttribute('aria-hidden');
			if(!$root->hasAttribute('role')){
				$root->setAttribute('role', 'img');
			}
			if($titleElm && !$root->hasAttribute('aria-labeledby')){
				$root->setAttribute('aria-labeledby', $opts['id'] . '-title');
				$titleElm->setAttribute('id', $opts['id'] . '-title');
			}
		}else{
			$root->setAttribute('aria-hidden', 'true');
		}

		//--set attributes
		if($opts['attr']){
			foreach($opts['attr'] as $attr=> $value){
				$root->setAttribute($attr, $value);
			}
		}

		//--set classes on svg
		if($opts['classes']){
			$root->setAttribute('class', $opts['classes']);
		}

		//--output svg
		$output = $dom->saveXML();

		//--if outputting into HTMLâ€¦
		if($opts['output'] === 'html'){
			//--remove xml declaration
			$output = preg_replace('/^<\?xml[ \w="\.-]+\?>\s?/', '', $output);
			//--remove doctype
			$output = preg_replace('/<!.*>\s?/', '', $output);
		}

		return $output;
	}
}
```

This could then be used like:

``` php
<?php
$iconRenderer = new IconRenderer();
?>
<a href="/map"><?=$iconRenderer->renderSVG(Array('ariaVisible'=> false, 'name'=> 'entypo/map'))?> Map</a>
â€¦
<a href="https://facebook.com"><?=$iconRenderer->renderSVG(Array('name'=> 'entypo/facebook', 'title'=> 'Facebook'))?></a>
```

Client-Side
-----------

Since we generate some content client-side, such as buttons for Javascript widgets, I built a Javascript loader to grab the icons from a server-side route that runs the icon through the server-side render helper.  A simplified solution might have a script at /svg-icon.php:

``` php
<?php
//--quick and dirty clean up of GET data
if(isset($_GET['content'])){
	throw new Exception("Can't pass 'content' from client.");
}
$data = Array();
foreach($_GET as $key=> $value){
	if(is_array($value)){
		foreach($value as $subKey=> $subValue){
			$value[$subKey] = htmlspecialchars($subValue);
		}
		$data[$key] = $value;
	}else{
		$data[$key] = htmlspecialchars($value);
	}
}
if(strpos($data['name'], '..') !== false){
	throw new Exception("Can't have '..' in client-provided SVG path.");
}

//--render
$iconRenderer = new IconRenderer();
echo $iconRenderer->renderSVG($data);
```

The Javascript helper that could use this might look like:

``` js
var SVGHelper = {
	load: function(_opts){
		if(typeof _opts !== 'object'){
			_opts = {
				name: _opts
			};
		}
		return jQuery.ajax({
			data: _opts
			,url: this.url
		});
	}
	,loadInto: function(_opts, _elm){
		var _promise = this.load(_opts);
		_promise.then(function(_result){
			if(_result){
				_elm.html('').append(jQuery(_result));
			}
		});
		return _promise;
	}
	,url: '/svg-icon.php'
};
```

which could be used like:

``` js
var _carousel = jQuery('.carousel')
var _nextButton = jQuery('<button class="carouselNextButton">');
SVGHelper
	.loadInto(['name'=> 'entypo/arrow-with-circle-right', 'title'=> 'Next'], _nextButton)
	.then(function(){
		_carousel.append(_nextButton);
	})
;
```

Styles
------

For general purposes, I apply the following styles, which:

- make the icon the text color of its container
- make the icon `inline-block` to be inline with text and easy to work with
- make the icon `1em` square to match the font size of the container
- fix a Safari bug

``` css
.icon-svg{
	color: inherit;
	display: inline-block;
	height: 1em;
	width: 1em;
	fill: currentColor;
}
```

In many places, we have the icon fill a generic container that can contain icons, images, or other media-type content.  To make it fill the container, I use styles like:

``` css
.mediaContainer .icon-svg{
	height: auto;
	max-height: 100%; //-@ fix safari bug http://stackoverflow.com/a/12631326
	width: 100%;
}
```

[^1]: I found [an article with some techniques to change colors of background SVG's](http://codepen.io/noahblon/post/coloring-svgs-in-css-background-images), but they all have their issues and won't work with `currentColor`.
