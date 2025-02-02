---
categories: [www]
date: 2021-03-18T00:31:09-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=3345'
id: 3345
modified: 2021-03-18T00:31:09-04:00
name: es-module-bare-specifiers-via-response-rewrite
tags: [build, development, javascript, module, packagemanager, server, web]
---

JS: ES Modules and Node bare specifiers via response rewrite
============================================================

I've been playing with JS lately, including ES modules and building with [Rollup](https://rollupjs.org/), [Babel](https://babeljs.io/), and [Terser](https://terser.org/), along with other accessories.  One thing I'm disappointed with of ES modules in the Nodejs ecosystem is dealing with third party imports.  Using the "bare" specifiers that Node expects works fine in that environment and thus tools running in it (possibly needing helpers), but they don't work at all directly in the browser.  This is discussed in [this post by Jake Archibold](https://jakearchibald.com/2017/es-modules-in-browsers/#bare-import-specifiers-arent-currently-supported), for instance.

[Import maps](https://wicg.github.io/import-maps/) are one solution in the works, but that requires explicitly mapping every dependency, which could get complicated fast when dependencies have dependencies.  It also is only in draft stage and [only works in Blink based browsers currently](https://caniuse.com/?search=importmap).

I eventually gave in to the idea of having server code rewrite the paths in the js file responses to point to a symlinked `node_modules` folder, similar to what is mentioned in [this post by the Polymer project](https://www.polymer-project.org/blog/2018-02-26-3.0-preview-paths-and-names).  I created [a PHP test server for one of my projects that does this](https://github.com/tobymackenzie/spaify.web/blob/9bb450f897c22d0b19d51ea055b0c6666503170b/tests/_inc.php#L3-L75).

<!--more-->

That project handles all requests through PHP, but we could make a more limited solution that just serve the JS file requests.  In Apache we could create a rewrite rule like:

```
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteRule \.[m]?js$ /_js.php [END]
</IfModule>
```

to push js requests through `_js.php`.  That file could look like:

``` php
<?php
//--get requested path without any querystring
$path = explode('?', $_SERVER['REQUEST_URI'])[0];

//--get real path to file
$projectPath = realpath(__DIR__);
$fullPath = realpath($projectPath . $path);

//--make sure we have a file, it is a js file, and it is in our desired root
if(
	$fullPath
	&& preg_match('/\.[m]?js$/', $fullPath)
	&& substr($fullPath, 0, strlen($projectPath)) === $projectPath
){
	//--send js mime type
	header("Content-Type: application/javascript");

	//--grab file content, replace bare module paths
	$content = file_get_contents($fullPath);
	$content = preg_replace('/(import.*from\s+[\'"])([\w@])/', '$1/node_modules/$2', $content);
	$content = preg_replace('/(import\s+[\'"])([\w@])/', '$1/node_modules/$2', $content);

	//--handle modules without js extension
	foreach([
		'foo'=> '@foo/foo/src/main.js'
	] as $bare=> $modulePath){
		$content = preg_replace("/(import.*['\"]\/node_modules\/){$bare}(['\"])/", "\$1{$modulePath}\$2", $content);
	}

	//--send
	echo $content;
}else{
	//--otherwise send 404
	http_response_code(404);
	echo "404 Not found";
}
```

We do have to manually map all the paths for modules that don't have a file extension, but this should be fewer files than we'd need for import maps.  `$projectPath` is used with `realpath()` as a check to make sure no URL trickery is being done to pull in files outside of the project, and would have to be adjusted to include the `node_modules` parent if symlinked from there into the webroot.  The 404 page should probably be improved if it could be seen by end users.

My primary interest in loading ES modules from the `node_modules` folder is during development / testing.  I've gotten used to not having to build JS for dev while using [Require.js](https://requirejs.org/).  Now that I'm switching to ES modules for personal projects, I want to maintain the same quick workflow.  This allows me to do that, albeit with some extra work and limitations.

I'm working on a JS version of this server script, which would make more sense for my JS specific projects.  Learning a lot about how to do things in Node that come easy for me in PHP land.

Maybe when import maps get a little further along and perhaps get some regex or wildcard features or tool support to build them from a Rollup config, I will look into switching to them.
