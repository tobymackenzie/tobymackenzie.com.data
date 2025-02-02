---
categories: [www]
date: 2016-04-06T23:13:49-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1063'
id: 1063
modified: 2016-06-30T22:47:07-05:00
name: wordpress-code-plugin
tags: [code, move, plugins, shortcodes, wordpress, wordpress-com]
---

WordPress code plugin, a quick solution
=======================================

I'm slowly copying the markdown versions of my posts after [my recent move of this blog](https://www.tobymackenzie.com/blog/2016/04/04/blogs-moved-and-merged/).  It really is tedious, and I don't think I'll finish anytime soon, so in the meantime I created a plugin to output the `[ code]` shortcode that wordpress.com put in my post export in the same way that markdown does.  This is the first plugin and shortcode I've created in a long while, but it was relatively quick to do working off of my posts on [plugins](https://www.tobymackenzie.com/blog/2010/07/01/wordpress-my-first-plugin/) and [shortcodes](https://www.tobymackenzie.com/blog/2010/02/28/wordpress-shortcodes/).  The biggest time consumer was figuring out how to deal with whitespace issues.  Apparently, WordPress sometimes will add `<p>` and `<br />` to shortcode content.  Also, there were leading and trailing line breaks adding unnecessary space.  My quick solution:

<!--more-->

``` php
<?php
/*
Plugin Name: tjm-code
Plugin URI:  https://www.tobymackenzie.com/blog/2016/04/06/wordpress-code-plugin/
Description: Simple handler of 'code' shorttag
Version: 0.1
Author: Toby Mackenzie
Author URI: https://www.tobymackenzie.com
License: licenseName
*/

add_shortcode('code', function($args = null, $content = null){
	$content = trim($content);
	$content = str_replace('<br />', '', $content);
	$content = str_replace('<p>', '', $content);
	$content = str_replace('</p>', '', $content);
	if(ord($content{0}) === 10){
		$content = substr($content, 1);
	}
	if($args && isset($args['lang'])){
		return '<pre><code class="' . $args['lang'] . '">' . $content . '</code></pre>';
	}else{
		return '<pre><code>' . $content . '</code></pre>';
	}
});
```

I still have to find a solution for syntax highlighting.  I haven't liked the plugins I've tried so far.
