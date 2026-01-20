---
categories: [www]
date: 2025-12-04T14:15:41-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=4708'
id: 4708
modified: 2026-01-20T13:53:05-05:00
name: project-website-theme-switcher
tags: [js, project, site, theme, web]
---

Project: Website theme switcher
===============================

I finally made a theme switcher for my website.  Ever since I saw the [CSS Zen Garden](https://www.csszengarden.com/), I loved the idea of using the same markup with completely different appearances. This led to a desire to have multiple themes and an ability to switch them on my own site.  Early on I didn't have the ability, and later I didn't have the energy or time, or decide on the way I wanted to do it.  There are performance and complexity considerations, as well as needing to make decent themes other than the default one.  My eventual desire to have a static-friendly site complicated the performance aspect as well.

Some browsers have a built in way to change to `alternate stylesheet`s, but they stupidly download all of them even when they're not being used.  I'm not doing that.  So JS or a server-side cookie solution are needed, and the latter won't work for static sites.  I try to minimize the JS on my site and didn't want something heavy or complex, especially if it were loading before page render.

Recently, I had the energy and decided on a simple, lightweight JS way to do it.  I decided to start it even without real alternative themes.<!--more-->  I started it as a separate GitHub project called [theme-switch.js](https://github.com/tobymackenzie/theme-switch.js).  The concept is fairly simple.  A very lightweight script is loaded early, hopefully pre-render to minimize re-layout, that checks a stored value, and if set, changes a stylesheet URL based on a file name structure built from that value.  The rest can be heavier and loaded separately later.  This just sets up a form with the configured theme options that sets the stored value if changed and then runs the function from the pre-render script.

For the purposes of this post, I will share a minimal implementation of this concept, with some aspects and features from my full project removed for simplicity.  These include a JS module structure, ability for a "none" theme option, and ability to load different JS for different themes.

The HTML for this implementation has a `link` stylesheet tag with the default theme that will load if no theme is selected and in no-js situations.  It then has a script tag that isn't `async` or `defer` to ensure it is run early.  It can be inlined for speed if desired.  It has another script tag that can be deferred.  The HTML looks something like:

``` html
<!doctype html>
<title>Hello</title>
<link rel="stylesheet" src="/_themes/default.css" />
<script src="/_js/pre.js"></script>
<h1>Hello world</h1>
…
<script defer src="/_js/post.js"></script>
```

The pre JS file creates and runs a function that checks a `localStorage` value.  If set, it finds the appropriate stylesheet `link` via a selector and changes its `src`.  Cookies could be used for really old browser support.  The function is set on `window` so that the later script can call it.  `pre.js` looks something like:

``` js
(function(){
	window.tjmSetTheme = function(theme){
		if(theme){
			// modify selector if you have other stylesheets before the one you want for your theme
			var styleEl = document.querySelector('link[rel="stylesheet"]');
			if(styleEl){
				// path structure for themes set up here
				styleEl.href = '/_themes/' + theme + '.css';
			}
		}
	};
	var theme = (window.localStorage && localStorage.getItem('tjm-theme'));
	if(theme){
		tjmSetTheme(theme);
	}
})();
```

The post JS file injects a button into the page that can pop up a `<dialog>` with a form to select a theme.  A map of themes is set up in the `themes` object, where the key is the filename (without `.css`) and the value is the option displayed in the `<select>`.  The first option is considered the default and will unset the `localStorage` if chosen.  The others will set `localStorage` to the key string.  For simplicity for the user, I do this on change of the `<select>`.  A `<div>` can be used as a fallback for older browsers, not shown here for simplicity.  `post.js` looks something like:

``` js
(function(){
	if(window.localStorage && window.HTMLDialogElement){
		// configure themes
		var themes = {
			default: 'Theme 1',
			theme2: 'Theme 2',
			theme3: 'Theme 3',
		};
		// set up button. add wherever it should go
		var btnEl = document.createElement('button');
		btnEl.classList.add('themeSwitchBtn');
		btnEl.innerHTML = 'Switch Theme';
		document.body.appendChild(btnEl);

		// manage dialog
		var dialogEl, selectEl;
		btnEl.addEventListener('click', function(){
			// create on first click
			if(!dialogEl){
				dialogEl = document.createElement('dialog');
				dialogEl.closedBy = 'any';
				dialogEl.classList.add('themeSwitchDialog');

				// set up form
				var formEl = document.createElement('form');
				formEl.classList.add('themeForm');
				formEl.innerHTML = '<label>Switch theme</label> <select><select>';
				dialogEl.appendChild(formEl);
				selectEl = formEl.querySelector('select');
				var opts = '';
				for(var i in themes){
					if(themes.hasOwnProperty(i)){
						var opt = themes[i];
						var optEl = document.createElement('option');
						if(i === theme){
							optEl.selected = true;
						}
						optEl.value = i;
						optEl.innerHTML = opt;
						selectEl.appendChild(optEl);
					}
				}
				selectEl.addEventListener('change', setTheme);
				formEl.addEventListener('submit', setTheme);

				// add close button
				var closeEl = document.createElement('button');
				closeEl.classList.add('closeBtn');
				closeEl.innerHTML = 'Close dialog';
				closeEl.setAttribute('type', 'button');
				closeEl.addEventListener('click', function(){
					dialogEl.close();
				});
				dialogEl.appendChild(closeEl);

				document.body.appendChild(dialogEl);
			}
			dialogEl.showModal();
		});
		function setTheme(){
			var val = selectEl.value;
			if(val === 'default'){
				localStorage.removeItem('tjm-theme');
			}else{
				localStorage.setItem('tjm-theme', val);
			}
			window.tjmSetTheme(val);
		};
	}
})();
```

My site has had a fallback theme for really old browsers for years, so I started with that and the default as options.  However, I was able to quickly throw together a very simple version of a "stark" black and white theme idea I had to make a third.  I will try to add more themes in the future, and polish up the "stark" theme.

[See a demo](https://tobymackenzie.github.io/theme-switch.js/) of the full version in action, or use the button near the nav button on this site.

I think this came out pretty cool and I'm really glad to have made it.  It was fun and adds something of interest to my site.
