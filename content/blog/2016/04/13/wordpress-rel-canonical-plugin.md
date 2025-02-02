---
categories: [www]
comment_count: 1
date: 2016-04-13T23:56:53-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1077'
id: 1077
modified: 2016-04-16T00:09:51-05:00
name: wordpress-rel-canonical-plugin
pings: ['https://www.tobymackenzie.com/blog/2016/04/12/1071/']
tags: [canonical, plugins, seo, wordpress]
---

WordPress plugin: changing rel-canonical
========================================

I serve my site over both HTTP and HTTPS to support older browser that can't support modern or any HTTPS protocols.  I prefer HTTPS for search engines and general use though, as it is more secure, increases user privacy, and is factored into SEO rankings.  Due to an [issue with my sitemap](https://www.tobymackenzie.com/blog/2016/04/12/1071/), Google ended up indexing all of my blog pages as HTTP.  The first thing I'm going to try to get Google to show my blog pages as HTTPS is to set the `rel-canonical` link to the HTTPS version regardless of which protocol the visitor uses.  WordPress doesn't have a built in way to change the canonical URL, and I didn't want to install a heavy SEO plugin just for this, so I wrote my own.

This simple plugin removes WordPress's `rel_canonical` action, then replaces it with its own.  I basically re-implemented WordPress's own functionality, replacing the `http` with `https` before outputting the link.  It looks like:

<!--more-->

``` php
<?php
/*
Plugin Name: tjm-rel-canonical
Plugin URI: https://www.tobymackenzie.com/blog/2016/04/13/wordpress-rel-canonical-plugin/
Description: modify the rel canonical links to have https instead of http
Version: 0.1
Author: Toby Mackenzie
Author URI: https://www.tobymackenzie.com
License: GPL2
*/

remove_action('wp_head', 'rel_canonical');
add_action('wp_head', function(){
	if(!is_singular()){
		return;
	}
	$id = get_queried_object_id();
	if(!$id){
		return;
	}
	$cpage = get_query_var('cpage');
	if($cpage){
		$url = get_comments_pagenum_link($cpage);
	}else{
		$url = get_permalink($id);
		$page = get_query_var('page');
		if($page > 1){
			if(get_option('permalink_structure') == ''){
				$url = add_query_arg('page', $page, $url);
			}else{
				$url = trailingslashit($url) . user_trailingslashit($page, 'single_paged');
			}
		}
	}
	$url = str_replace('http://', 'https://', $url);
	echo "<link href=\"{$url}\" rel=\"canonical\" />\n";
});
```

This has the desired affect on the output markup.  Hopefully it will on Google's index as well.
