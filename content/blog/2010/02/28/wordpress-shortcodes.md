---
categories: [www]
comment_count: 4
date: 2010-02-28T12:36:38+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=272'
id: 421
modified: 2016-04-06T21:43:50-05:00
name: wordpress-shortcodes
tags: [images, pod, shortcodes, slideshow, wordpress]
---

Wordpress: Shortcodes
=====================

I've been playing with [shortcodes](http://codex.wordpress.org/Shortcode_API) in Wordpress.  They provide a nice way to allow the client to insert certain content without them needing to even deal with HTML, such as predefined pieces or wrappers with specific classes or structure.  They are the only way to effectively run PHP functions from within a page without actually allowing PHP code to be run.  This can allow pulling things from data, such as custom fields or from Pods CMS.  The built in `[gallery]` shortcode, for instance, pulls image data from the database about images connected to a post.

It's very easy to add a shortcode.  You create a function that does what you want and returns a string to output in place of the shortcode then use the `add_shortcode()` function of Wordpress to attach it as a shortcode.  The function is done like: 

``` php
function repFunctionName($repArguments, $repContent=null){
	return "some string";
}
```

`$repArgument` is an array of arguments passed to the shortcode like: 

```
[repShortcode repArgument1="value1" repArgument2="value2"]
```

<!--more-->

`$repContent` is the content placed between a start and end shortcode tag, if there is some, like: 

```
[repShortcode]This is content to be handled by the shortcode function[/repShortcode]
```

Since shortcode content isn't processed like post/page content, you will have to process it.  You can use the `do_shortcode()` function to ensure nested shortcodes are handled.  The attachment is then:

``` php
add_shortcode('repShortcode', 'repFunctionName');
```

One simple HTML type example I've done is allow internal links to be added without the base part of the URL, very helpful when the site will be moved, like with a test site. 

``` php
add_shortcode('internalLink', 'fncsInternalLink');
function fncsInternalLink($argArray, $argContent=null){
	// set up variables
	$fncInternalPath = ($argArray['path'])?$argArray['path']: '/';
		if(substr($fncInternalPath,0,1) != "/")
			$fncInternalPath = "/".$fncInternalPath;
		if(substr($fncInternalPath,-1,1) != "/" 
				&& strpos($argArray['path'], ".") == false 
				&& strpos($argArray['path'], "#") == false 
				&& strpos($argArray['path'], "?") == false
			)
			$fncInternalPath .= "/";
	$fncAddClasses = ($argArray['add_classes'])?$argArray['add_classes']: null;
	$fncReturn = '';
	
	$fncReturn .= "<a href=\"".get_bloginfo('url')."{$fncInternalPath}\"";
	$fncReturn .= " class=\"internal {$fncAddClasses}\"";
	$fncReturn .= ">{$argContent}</a>";

	return do_shortcode($fncReturn);
}

```

I've also done some data ones.  For example, for Samba, I've made a shortcode version of the [image slideshow](https://tobymackenzie.com/blog/2009/12/08/stearns-slideshow-media-tags/) I had created for Stearns.  I am thinking of making this into a plugin.  If I do I will post it later.  Not that such a simple and unconfigurable is needed in addition to the image plugins already available, but it may be helpful to someone.

For Canine Lifeline, I created shortcodes to pull a list of news items and a list of donors, stored as posts and a pod (Pods CMS) respectively.  The news shortcode allows the list of news to be placed in the middle of a page.  Not to make this post super long, but some may find this helpful to give an idea of how this could work:

``` php
// news output shortcode
add_shortcode('news', 'fncsNews');
function fncsNews($prmArguments){
	if(isset($prmArguments['count']))
		$fncItemCount = $prmArguments['count'];
	else
		$fncItemCount = ($prmArguments['limit']) ? $prmArguments['limit'] : 3;
	$fncLength = ($prmArguments['length']) ? $prmArguments['length'] : 'excerpt';
		// from 'excerpt', 'full'
	$fncReturn = '';
	
	query_posts("cat=5&paged=".$paged); 
	if(have_posts()):
		ob_start();
?>
            	<div class="news items">
<?php 
		while(have_posts()) : the_post();
?>
					<div class="item">
						<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'sandbox'), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></h3>
						<div class="postmetadata">
							 <!--<span class="author vcard">By <?php echo get_the_author(); ?></span>
							 on --><div class="date"><abbr class="published" title="<?php the_time('Y-m-d') ?>"><?php unset($previousday); echo the_date( '', '', '', false ); ?></abbr></div>
						</div><!-- entry-meta -->
						<div class="entry-content">
<?php		if($fncLength == 'excerpt'): ?>
							<?php the_excerpt() ?>
<?php		else: ?>
							<?php the_content(); ?>
<?php		endif; ?>
							<a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'sandbox'), the_title_attribute('echo=0') ) ?>" rel="bookmark">Read More &raquo;</a>
						</div><!-- entry-content -->
						<!--<div class="postmetadata">
							<?php the_tags( '<span class="tag-links">Tagged ', ", ", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
						</div>--><!-- entrymeta -->
					</div><!-- item -->
<?php
		endwhile;
?>
					<div><a href="<?php bloginfo('url')?>/news/">More News</a></div>
				</div><!-- news items -->
<?php	
		$fncReturn = ob_get_contents();
		ob_end_clean();
	endif; 
	
	return $fncReturn;
}
```

The Pod one is just a wrapper around the shortcodes that Pods already provides, just to make it easier for the client to deal with.

I like the shortcodes and will continue to add more so that my clients will have an easier time of making content fit into the site and of adding content from data to pages.
