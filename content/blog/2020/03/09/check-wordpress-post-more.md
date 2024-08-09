---
categories: [www]
date: 2020-03-09T01:58:53-04:00
date_gmt: 2020-03-09T05:58:53+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2692'
id: 2692
modified: 2020-03-09T01:58:53-04:00
modified_gmt: 2020-03-09T05:58:53+00:00
name: check-wordpress-post-more
tags: [blog, posts, wordpress]
---

Checking if WordPress post has more
===================================

WordPress offers the `has_excerpt()` method to determine if you create a separate excerpt on a post, but does not seem to have a built in function to ask if it uses the special comment `<!--more-->` for an excerpt coming from the beginning of the post content.<!--more-->  I wanted to ask this question in my theme so I could show a more link with my own markup only if there is actually more.  [A Stack Exchange answer](https://wordpress.stackexchange.com/a/59257) helped me out.  I created a function, like:

``` php
function doesPostHaveMore($post = null){
	if(has_excerpt($post)){
		return true;
	}
	if(!is_object($post)){
		$post = get_post($post);
	}
	return is_object($post) && strpos($post->post_content, '<!--more-->') !== false;
}
```

The function could be added in `functions.php`.  To use, within a post template:

``` php
<?php if(!is_singular() && doesPostHaveMore()){ ?>
<a class="more-link" href="<?=the_permalink()?>"><?=__('Continue reading')?> <span class="sro">"<?=get_the_title()?>"</span></a>
<?php } ?>
```
