---
categories: [www]
comment_count: 1
date: 2010-01-07T20:04:11+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=153'
id: 404
modified: 2010-01-07T20:04:11+00:00
name: wordpress-multiple-dynamic-sidebars
tags: [templates, theme, wordpress]
---

Wordpress: Multiple Dynamic Sidebars
====================================

I'm making a "blank" type template for Wordpress that I'll be able to modify for sites as I develop them.  I wanted to make sure my template was compliant with the dynamic sidebars feature of Wordpress and have multiple sidebars already there for quick creation with new sites.  I wanted the first to have some default content, while the others would not be displayed unless they have dynamic content.  I suppose that might not end up being useful for the fixedness of the one-off designs I've been doing, but we'll see...

The tutorials I found didn't discuss how to make the container for each of multiple sidebars display only if the sidebar had dynamic widgets.  The is_dynamic_sidebar() function is what was needed.  So I register my sidebars like normal, in "functions.php":

```
if(function_exists('register_sidebar')){
register_sidebars(2, array(
'before_widget' => '<div id="%1$s" class="widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
```
<!--more-->

I used register_sidebars() and divs instead of ul containers.  You can use multiple register_sidebar() calls to have named sidebars, which I may consider if I want to use this for conditional sidebars in different sections instead of the if-elseif I've been using, in which case I'll probably have to change this even further.

Anyway, for the "sidebar.php", I used basically the normal dynamic sidebar call, with the first sidebar (or a name) specified:

```
<div id="sidebar1" class="sidebar" role="complementary">
<?php 
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : 
?>
		<div class="pages" role="navigation">
			<h2>Pages</h2>
			<?php wp_list_pages('title_li='); ?>
		</div><!-- pages -->
<?php
endif;
?>
		<?php wp_meta(); ?>	
	</div><!-- sidebar1 -->
```

and for the other sidebar, I put the whole thing in an if wrapper:

```
<?php
if(function_exists('dynamic_sidebar') && is_dynamic_sidebar(2)):
?>
	<div id="sidebar2" class="sidebar" role="complementary">
		<?php dynamic_sidebar(2); ?>
	</div><!-- sidebar2 -->
<?php
endif;
?>
```

For future projects, though, I may have to find a better way to do this, more inline with the way I've actually been using the sidebars.  We haven't been using dynamic functionality, but I would like to leave the capability in just in case.
