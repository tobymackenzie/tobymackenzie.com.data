---
categories: [www]
date: 2025-10-24T15:47:19-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4678'
id: 4678
modified: 2025-10-24T15:47:19-04:00
name: ghosts-js
tags: [holiday, javascript, project]
---

Ghosts.js
=========

A few years back, to make my site more festive for Hallowe'en, I made a script to have ghosts move around my web-page.  I based it on [my snow script](/content/blog/2018/12/26/website-snow-script.md) for winter / Christmas, using the basic structure, reducing the number of moving objects, and changing their movement to look better for ghosts.  I meant to post about it.  This year I decided to break it out into its own Github repo, which led to me refining it and cleaning it up somewhat.  See the [ghosts.js repo](https://github.com/tobymackenzie/ghosts.js) and the [ghosts.js demo](https://tobymackenzie.github.io/ghosts.js/).

<!--more-->

I used a ghost emoji to keep the size minimal.  I went with a DOM based approach for this, which seemed to have the best performance over SVG and canvas.  I move the ghost elements around the screen by adjusting their left and top CSS position at about 12 frames per second off of `requestAnimationFrame()` to limit CPU usage.  I have an x and y speed that changes by a random amount each frame and goes to a configured max speed.  This is based on my snow script but can go upward as well as downward and was tweaked to look closer to how ghost movements in some video games look, slow and eerie.

I determine the number of ghosts to show based on screen size, a much smaller number than the snow script has, probably two to five.  There is a `countFactor` option that can be modified to adjust this number.  Added beyond what my snow script did, the ghosts have a click event with a CSS animation and JS alert.

The project has a `ghosts.js` file to create and manage the ghosts and a `ghosts.css` file to style them and their container.  I load them only around Hallowe'en with something like:

``` js
var date = new Date();
if(date.getMonth() === 9 && date.getDate() > 20){
	import('./lib/ghosts.js/ghosts.js');
}
```

Mine is more complicated though, using some abstractions and build tools.  To use, download the project code and load the JS and CSS files by whatever means you like into your site.
