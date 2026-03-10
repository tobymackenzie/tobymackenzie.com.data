---
categories: [www]
date: 2026-03-10T16:00:26-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4792'
id: 4792
modified: 2026-03-10T16:02:12-04:00
name: rollup-strip-plugin-for-dev
tags: [build, development, js, module, tool]
---

Rollup Strip plugin for dev code
================================

I use [JavaScript modules](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules) to organize my JS code.  I use [Rollup.js](https://rollupjs.org/) to package and minify these for distribution to reduce HTTP requests and transfer size, and to provide support for older browsers.  So in development I'm using the modules directly and in production I'm using the built files.  I was looking for a good way to have some extra code in for development purposes, but removing it for production.  This could be used for a lot of things, including testing some code that runs on certain dates for dates other than the current one.  I didn't find a way to do this built in to Rollup, but there is [an official plugin called Strip](https://github.com/rollup/plugins/tree/master/packages/strip) that allows removing specific [labelled statements](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/label).

<!--more-->

Labelled statements are not often used, and I only vaguely remembered even hearing about them.  They look like:

``` js
foo: {
	doSomething();
}
```

and can be used with `break` or `continue`.  But they will run when encountered in code regardless, as if they weren't wrapped, and thus can be used to wrap and group any code segment.

With the Strip plugin, we can put code in defined labels and have it run when loaded directly, but get removed on build.  For my date related example, I might have a module called `getNow.js`, used anywhere that does something based on the current date, that looks like:

``` js
var now = new Date();
dev: {
	var parm;
	if(window.URLSearchParams && (parm = new URLSearchParams(location.search)) && parm.has('now')){
		now = parm.get('now');
		if(now.length === 8){
			var y = now.substr(0, 4);
			var m = now.substr(4, 2) - 1;
			var d = now.substr(6, 2);
		}else{
			var y = (new Date()).getFullYear();
			var m = now.substr(0, 2) - 1;
			var d = now.substr(2, 2);
		}
		now = new Date(y, m, d, 0, 0, 0)
	}
}
export default now;
```

The stuff inside of the `dev` label allows me to stick a date in the query parameters of any URL and get the behavior for that date.  That is a lot of extra weight to send to a production site though, where we don't need or want it.  So we can install the Strip plugin by adding it to our package.json dev dependencies:

``` json
{
	"devDependencies": {
		"@rollup/plugin-strip": "^2"
	},
}
```

After installing that with our package manager of choice, we can add it with some configuration when invoking Rollup, like:

``` sh
rollup dev.js --output.format iife --plugin './src/PublicApp/node_modules/@rollup/plugin-strip={labels: ["dev"]}' | uglifyjs --compress --mangle > prod.js
```

It can also be added in a `rollup.config.js`, but I'm not using that for my simple builds.

Then by changing what file we load in our template, we can run the dev code in the development environment and have it removed in the production environment.  Nice.  Makes me much more willing to add dev code sprinkled through my code base.
