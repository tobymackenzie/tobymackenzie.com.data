---
categories: [www]
date: 2018-03-14T23:58:26-05:00
date_gmt: 2018-03-15T04:58:26+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1809'
id: 1809
modified: 2018-04-02T22:44:34-05:00
modified_gmt: 2018-04-03T03:44:34+00:00
name: first-play-es-modules-rollup-webpack
tags: [build, development, javascript, method, module, site, web]
---

First play with ES modules, rollup, webpack
===========================================

I played with [ES modules](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/export), [rollup](https://rollupjs.org/), and [webpack](https://webpack.js.org/) on my site for the first time over the weekend.<!--more-->  My site barely has any javascript, so it was an easy way to wade into it.

ES modules seem pretty nice in many ways.  Finally, javascript has a built in way to bring in dependencies, with the synchronicity of loading sorted and each with their own scope.  It's annoying though that importing can't be done conditionally / dynamically.  For something like that, I'd have to  insert `<script>` elements into the DOM dynamically.  I think [something is in the works](http://2ality.com/2017/01/import-operator.html) though.

It was easy to split the main js of my site into a main entry point, two tiny modules, and some helper modules.  This should make it easier to add more functionality in the future.

I tried both webpack and rollup to convert my modules to more widely compatible regular scripts, running their command line interfaces without any config file to keep things simple.  Rollup with [uglify](https://github.com/mishoo/UglifyJS2) made for about 500 byte smaller files and seemed a little easier to understand, so I went with that.  My build script has an option to run either though, so I can switch later if I find I want webpack's features.

In my template, I output a `<script type="module">` in dev environment and a regular `<script>` in prod.  This allows me to develop without having to compile anything; then I can compile when I'm ready to deploy to production.  That allows for the same rapid workflow I use at Cogneato using [require js](http://www.requirejs.org/), but without the extra module loader script and theoretically with easier setup and configuration, though my site is a little too simplistic to extrapolate to what I do at work.
