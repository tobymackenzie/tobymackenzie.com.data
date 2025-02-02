---
categories: [www]
date: 2010-07-01T03:15:54+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=340'
id: 432
modified: 2023-12-20T20:09:17-05:00
name: wordpress-my-first-plugin
tags: [plugins, wordpress]
---

Wordpress: My First Plugin
==========================

I made my first Wordpress plugin today.  It's very simple and for my own site only:  It adds the script bits for the [Piwik analytics](http://piwik.org) of my personal blog.  It showed me just how easy it is to create a plugin in Wordpress.  Normally, for clients, I'd just add additional functionality in the "functions.php" file, but for my personal site I'm using the new default theme for Wordpress 3.0 (in part out of laziness and in part to try out some of the new features it introduced).  I decided rather than modify the theme at all I'd create a plugin, and was happy with how easily and well it worked.

Creating a simple plugin involves creating a PHP file in the 'plugins' folder (in 'wp-content').  It can be named anything, and could also go inside of a folder if multiple files are needed.  The plugin file starts with a snippet like the following:

<!--more-->
``` php
<?php
/*
Plugin Name: nameOfPlugin
Plugin URI: http://pluginURI
Description: descriptionOfPlugin
Version: number
Author: authorName
Author URI: http://authorURI
License: licenseName
*/
```

This could be followed by license information in comments as well.  For a simple plugin like the one I made, it needs no license, so I said "Private" and has no plugin page, so I left that blank.

After that bit, you can add anything you might add to functions.php, usually connections to the various Wordpress hooks.  In my case, I wanted the Piwik script code to be output by "wp_footer()" in the template, so I added:

``` php
<?php
add_action('wp_footer', 'plgpiwikAddScriptTags');
```

which will run the function "plgpiwikAddScriptTags" when "wp_footer()" is run, then created a function that echo's the appropriate script tags:

``` php
<?php 
function plgpiwikAddScriptTags() {
	if(!is_user_logged_in()){
		ob_start();
?>
<script>// piwik script stuff goes here, as well as other html stuff.</script>
<?php
		$fncContent = ob_get_contents();
		ob_end_clean();
		echo $fncContent;
	}
}
```

I only output the tag if the user is not logged in and use the output buffer out of habit and for good measure, in case I want to do something with the resulting string.

I think I will use these plugins more often, perhaps for stuff that would otherwise go into "functions.php" but is not required by the theme.  It allows separation of functionality and better control of updating with separate versions.

[Find more information about writing Wordpress plugins](http://codex.wordpress.org/Writing_a_Plugin)
