---
categories: [www]
date: 2014-02-10T06:17:35-05:00
date_gmt: 2014-02-10T11:17:35+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=567'
id: 567
modified: 2024-06-28T21:48:42-04:00
modified_gmt: 2024-06-29T01:48:42+00:00
name: php-output-buffer-manager
tags: [github, php, repository]
---

PHP Output Buffer Manager
=========================

With rebuilding [my website](https://www.tobymackenzie.com) with WordPress, I have made progress on the [WordPress starter theme](https://tobymackenzie.com/blog/2013/07/16/working-on-a-new-wordpress-bare-theme/#more-543) I've been working on.  One thing I used for it was PHP's [output buffering](http://www.php.net/manual/en/book.outcontrol.php) to control output and allow me to define "blocks" of content, then render them at a later point in their proper location.  To this end, I created some helper methods to manage this for me and allow easy creating of named buffers.  I got the idea for this from the [slots of Symfony's PHP templating engine](http://symfony.com/doc/current/book/templating.html).

I have since broken this out of my WordPress theme helper classes into its own class and created [a github repo, PHP-BufferManager](https://github.com/tobymackenzie/PHP-BufferManager) to allow its use for generic purposes.  This is a very simple repo and class.  The most common way to use it would be to use `$instance->start('name');` to start a buffer named 'name' and `$instance->end();` to end it, then `$instance->get('name');` at a later point to get the string value of the buffer for output or other purposes.  A simple example:

<!--more-->

``` php
<?php
$bufferManager = new TJMComponentBufferManagerBufferManager();

$bufferManager->start('block1');
echo 'This is in block 1';
$bufferManager->end();

$bufferManager->start('block2');
echo 'This is in block 2';
?>
<div class="wrapper">
	<h2>This is block 1's heading</h2>
	<div class="block1">get('block1'); ?></div>
	<h2>This is block 2's heading</h2>
	<div class="block2">get('block2'); ?></div>
</div>
```

Or:

``` php
<?php
$bufferManager->start('main');
include($mainContentFile);
$bufferManager->end();
$bufferManager->start('aside');
include($asideContentFile);
$bufferManager->end();

if($isAjaxRequest){
	echo json_encode(Array(
		'title'=> $pagetitle
		,'main'=> $bufferManager->get('main')
		,'aside'=> $bufferManager->get('aside')
	));
}else{
?>
<!DOCTYPE html>
<html>
	<title><?=$pagetitle?></title>
	…
	<main><?=$bufferManager->get('main')?></main>
	<aside><?=$bufferManager->get('aside')?></aside>
	…
</html>
<?php }
```

In the case of my WordPress theme, WordPress loads files representing the content of a page, and you call `get_header();` at the top and `get_footer();` at the bottom, which include the theme's header.php and footer.php respectively.  I wanted to be able to have the entire wrapper/skeleton in one file instead of split into two.  So I use output buffering.  In my header.php, I start a buffer:

``` php
<?php
// {theme}/header.php
$tjmThemeHelper->buffers->start('main');
```

Then in my footer I end the buffer and include the wrapper/skeleton file:

``` php
<?php
// {theme}/footer.php
$tjmThemeHelper->buffers->end('main');
require('./skeleton.php');
```

The skeleton file then can define the entire document wrapper and output the content of the file representing the main content where it pleases:

``` php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	…
	<title><?php echo wp_title('-', false, 'right') .  get_bloginfo('name'); ?></title>
	…
<?php
//--main with wrapper
if($tjmThemeHelper->buffers->has('main')){
?>
	<main class="siteMainWrap" id="main" role="main">
		<div class="siteMain" id="mainContent">
			<?=$tjmThemeHelper->buffers->get('main'); ?>
		</div>
	</main>
<?php
}

//--aside/sidebar
if($tjmThemeHelper->buffers->has('aside')){
	echo $tjmThemeHelper->buffers->get('aside');
}
?>
</html>
```
