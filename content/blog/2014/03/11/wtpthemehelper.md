---
categories: [www]
date: 2014-03-11T01:19:31-05:00
date_gmt: 2014-03-11T06:19:31+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=574'
id: 574
modified: 2024-08-01T12:52:17-04:00
modified_gmt: 2024-08-01T16:52:17+00:00
name: wtpthemehelper
tags: [github, project, theme, wordpress]
---

WPThemeHelper, my helper for WordPress themes
=============================================

In remaking my website using WordPress, I've been working on a base theme that I can use for other sites.  I decided to take some of my experience from the Symfony world, such as organizing functionality into namespaced classes, grouped into "bundles" of functionality that can be (somewhat) independently installed as needed depending on the project.  I already mentioned the [PHP-BufferManager](https://github.com/tobymackenzie/PHP-BufferManager) I'm using in a [previous post](/content/blog/2014/02/10/php-output-buffer-manager.md).  I've also created a more specific to WordPress project with more varied functionality, a theme helper called [WPThemeHelper](https://github.com/tobymackenzie/WPThemeHelper).

The theme helper has several classes to help make theme development cleaner and perhaps a bit easier.  The readme on github has more details, but some of the more important ones are:

- [SettingHelper](https://github.com/tobymackenzie/WPThemeHelper/blob/master/src/SettingHelper.php): Allows setting of WordPress settings with a map (associative array).  It calls the appropriate WordPress function at the appropriate time in WordPress's initialization cycle.  Helps clean up the 'functions.php' file and makes remembering what functions to call for various theme settings easier. <!--more-->

	Example:

	``` php
	$settingsHelper = new TJMWPThemeHelperSettingHelper(Array(
		'settings'=> Array(
			'automatic-feed-links'=> true
			,'custom-header'=> Array(
				'default-image'=> ''
				,'default-text-color'=> '000000'
				,'flex-height'=> true
				,'flex-width'=> true
				,'height'=> 250
				,'max-width'=> 2000
				,'random-default'=> false
				,'width'=> 960
			)
			,'nav-menus'=> Array(
				'footer'=> 'Footer'
				,'header'=> 'Header'
			)
			,'post-thumbnail-size'=> Array(625, 9999)
			,'widget-areas'=> Array(
				Array(
					'name'=> 'Aside 1'
					,'id'=> 'aside-1'
					,'before_widget'=> '<div id="%1$s" class="widget %2$s">'
					,'after_widget'=> '</div>'
					,'before_title'=> '<h3 class="widget-title">'
					,'after_title'=> '</h3>'
				)
				,Array(
					'name'=> 'Aside 2'
					,'id'=> 'aside-2'
					,'before_widget'=> '<div id="%1$s" class="widget %2$s">'
					,'after_widget'=> '</div>'
					,'before_title'=> '<h3 class="widget-title">'
					,'after_title'=> '</h3>'
				)
			)
		)
	));
	```
- [Renderer](https://github.com/tobymackenzie/WPThemeHelper/blob/master/src/Renderer.php): Uses PHP-BufferManager to render pieces of a page outside of the order they are output and with their own scope.  Helped me split up the page into multiple pieces and to write a skeleton wrapper in a single file instead of splitting it into 'header.php' and 'footer.php'

	Example:

	``` php
	$renderer = new TJMWPThemeHelperRenderer();
	echo $renderer->render('aboutBox.php', Array(
		'name'=> 'Toby Mackenzie'
		,'description'=> 'Ohio web developer'
	));
	```

	``` php
	// {theme}/aboutBox.php
	<div class="aboutBox">
		<div class="aboutBoxName"></div>
		<div class="aboutBoxDescription"></div>
	</div>
	```
- [PathHelper](https://github.com/tobymackenzie/WPThemeHelper/blob/master/src/PathHelper.php): Simply gets the path to a file inside either a child theme or, if not there, the parent theme.  Makes it easy to allow files other than those automatically managed by WordPress to be overridden by child themes.  Used by the Renderer class to render templates from appropriate theme.

The SettingHelper and Renderer were the primary reasons I created this helper project in the first place, and have helped keep my theme clean and organized and helped abstract away things I don't want to have to think about while developing the theme.  Other classes are helpers for those two or less significant, but still convenient.  I don't develop in WordPress often anymore, but when I do, I will attempt to improve and add to the functionality of this project.  I also intend to open source a cleaned up version of the parent theme I am using for my site to be used as a base theme for general theme development.
