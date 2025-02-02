---
categories: [www]
date: 2012-04-13T07:18:59+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=478'
id: 478
modified: 2017-02-24T01:00:45-05:00
name: using-symfony-alongside-an-existing-system
tags: [cogneato, compatability, framework, php, symfony]
---

Using Symfony alongside an existing system
==========================================

At [Cogneato](http://cogneato.com) we've had a CMS that has been built up over more than a decade.  We started working on a completely new system a while back to have a new and more powerful interface, add new features, and get rid of a lot of the cruft that the old system had from being developed over such a long period by many developers with different styles.  We decided to use [Doctrine](http://www.doctrine-project.org) as an ORM and [Symfony](http://symfony.com) as a framework for our back end.

We have maybe 200 sites running on various versions of our old system though, and we need to be able to add the new system's features without having to completely redo them.  We needed a way to be able to leave all the current stuff in place and pull in the Symfony stuff to the existing files with a simple include.

<!--more-->

How our old system works is there is a PHP file for each 'route', which we call an 'index' file.  This file sets up some settings for a particular page, including defining a 'content' file that holds the content for the main content area of a page, and then includes a 'skeleton' file.  The skeleton pulls in an include file that sets up our old system stuff, then renders the skeleton of the site that is on every page, pulling the 'content' file into the proper place.

It took me a while to find an easy way to include the Symfony stuff in a way that got us most of its capabilities without affecting the old stuff.  My solution is probably a bit overboard, but it works.  First off, we had to use the PHP rendering engine instead of [Twig](http://twig.sensiolabs.org/) so we could remain compatible with the existing PHP files.  Then I made a 'bridge' include file to be pulled in from our 'skeleton' that is similar to 'app.php', except that instead of going through Symfony's routing system, it uses Request::create to directly create a request.  The request always uses one particular route that in turn uses one particular controller action.  This action sets up some stuff for the old pages and then renders a special view file.  This view file pulls in the old skeleton again, bypassing the include of the 'bridge' this time and now going on to output the page content mostly as it has without Symfony involved, except now it is being rendered as a view and returned through the controller.

This is somewhat complicated and probably not the most efficient way of doing it, but it gives us access to everything we'd have access to in a regular PHP template file and offers the potential for caching and other features provided by Symfony when used in its standard fashion.  The various relevant files are shown in a stripped down form below.

Skeleton file
-------------

``` php
<?php
if(!isset($DOCUMENT_ROOT)){
	$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
}
require_once($DOCUMENT_ROOT . "/pathToOldSystemBaseInclude.php");
//--checks if the $view and $app of Symfony's PHP templating system are set.  if not we need to include the bridge
if(!(isset($view) && isset($app))){
	//--sets up some global variables for use in symfony action or elsewhere
	if(!isset($cgGlobals))
		$cgGlobals = Array();
	$cgGlobals = array_merge($cgGlobals, Array(
		"isThroughSkeleton"=> true
		,"pathSkeleton"=> __FILE__
	));
	//--bring in the bridge
	require_once($DOCUMENT_ROOT."/pathToBridgeFile.php");
	//--note this exit.  we must exit here from this load of the skeleton because everything after this will be loaded by the second run through of this file and when we come back here Symfony will already have run and done its render from the action and what not
	exit();
}
?>
<!DOCTYPE html>
…
```

Bridge
------

``` php
<?php
require_once(__DIR__."/../app/config/bootstrap.php");
require_once __DIR__.'/../app/bootstrap.php.cache';
require_once $_SERVER["DOCUMENT_ROOT"].'/../symfony/app/AppKernel.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$kernel = new AppKernel('dev', false);
$request = Request::create(
	//--use our route, append the request uri so it is unique for cacheing
	'/_old_system_pull_in_old_skeleton'.$_SERVER["REQUEST_URI"]
	,'GET'
	,$_GET
	,$_COOKIE
	,$_FILES
	,array_merge(
		$_SERVER
		,Array(
			//--we must do this because Symfony uses this to determine its path root, but some of our 'index' files are not in the web root
			"SCRIPT_FILENAME"=> $_SERVER["DOCUMENT_ROOT"]."/skeleton.php"
		)
	)
);
$kernel->handle($request)->send();
```

routing
-------

```
old_system_pull_in_old_skeleton:
	pattern: /_old_system_pull_in_old_skeleton/{path}
	defaults: { _controller: CogneatoOldSystemBundle:Default:pullInOldSkeletonFromSkeleton, path: "/" }
	requirements:
		path: .*
```

Controller
----------

``` php
…
class …{
…
	public function pullInOldSkeletonFromSkeletonAction($path) {
		if(array_key_exists("cgGlobals", $GLOBALS) && array_key_exists("isThroughSkeleton", $GLOBALS["cgGlobals"]) && $GLOBALS["cgGlobals"]["isThroughSkeleton"]){
			//--make all globals available to 'template', as all of the old system stuff set up by our first run through the 'skeleton' are globals
			$data = $GLOBALS;
			$data["_skeletonPath"] = (isset($GLOBALS["cgGlobals"]["pathSkeleton"])) ? $GLOBALS["cgGlobals"]["pathSkeleton"] : $_SERVER["DOCUMENT_ROOT"] . "/skeleton.php";
			$data["path"] = $path;
			return $this->renderPage(
				'CogneatoOldSystemBundle:Default:pullInOldSkeletonFromSkeleton.html.php'
				,$data
			);
		}else{
			//--return 404
		}
	}
…
}
```

View
----

``` php
<?php
require($_skeletonPath);
```
