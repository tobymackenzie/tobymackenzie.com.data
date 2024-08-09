---
categories: [www]
comment_count: 6
date: 2010-02-09T20:56:05+00:00
date_gmt: 2010-02-09T20:56:05+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=240'
id: 413
modified: 2010-02-09T20:56:05+00:00
modified_gmt: 2010-02-09T20:56:05+00:00
name: canine-wordpress-custom-searches
tags: [caninelifeline, magicfields, pods, search, wordpress]
---

Canine: Wordpress Custom Searches
=================================

The Wordpress search by default looks through the title and content of all available posts and pages for given query words.  But sometimes you might want to only search a certain category or search custom fields or some other criteria.  On the Canine Lifeline site, we have a dog section where we want to be able to list dogs based on a number of parameters, such as age, gender, adoption status, et cetera.  We are currently storing dogs as posts in a particular category, and using [Magic Fields](http://magicfields.org) to add custom fields for various aspects of each dog.

Wordpress sends search queries as GET requests from its search form.  The "s" variable contains the search query, but others are allowed.  In fact, if you're familiar with the "[query\_posts](http://codex.wordpress.org/Template_Tags/query_posts)" function, many of the parameters for that are available, and the rest can be enabled, because the search is basically just a regular Wordpress query with parameters appended from the GET variables.

<!--more-->

To modify the search functionality, you can simply add fields to your search form with the names of the parameters you want to search with, like:

```
<div class="search dogs">
	<form role="search" method="GET" action="<?php bloginfo('siteurl'); ?>/">
		<label class="screen-reader-text" for="s">Search dogs:</label>
		<input type="text" value="<?php echo $_GET['s']; ?>" name="s" id="s" />
		<input type="hidden" name="cat" value="3" />
		<input type="submit" id="searchsubmit" value="Search" />
	</form>
</div>
```

This does a regular query search on only posts in category 3 by using a hidden input.  The value for the "cat" variable can actually be comma separated to include multiple categories, such as "3,5,7".  We can display this form only when in the dog section by putting an "if" in the "searchform.php", or possibly just the "sidebar.php" (that wouldn't appear on the "No results" page though), that checks the page, post category, or search query category ($_GET['cat'] == 3):

```
if(
	is_page('adopt-a-dog') ||
	is_page('adoption-process') ||
	is_page('mended-mutts') ||
	in_category('adoptable-dogs') ||
	$_GET['cat'] == "3"
): // display dog search form
else: // display normal search form
endif;
```

As the search is sent as a GET request, URLs can also be crafted with the appropriate variables so that you can have a link to a page with a certain result set.  This link shows all posts from the current year in category 3:

```
http://repMyURL.com/?cat=3&year=<?php echo date('Y');?>
```

As all but the "s" parameter seem to be apendable to permalinks and have their affects, the above could become:

```
http://repMyRL.com/category/adoptable-dogs/?year=<?php echo date('Y');?>
```

when that permalink structure is used and category 3 is called "adoptable-dogs".

Since we store much of the dog data in the custom fields, we need to be able to search those.  By default, these parameters of "query_posts" are available, as currently found on line 29 of classes.php:

```
array('m', 'p', 'posts', 'w', 'cat', 'withcomments', 'withoutcomments',
's', 'search', 'exact', 'sentence', 'debug', 'calendar', 'page', 
'paged', 'more', 'tb', 'pb', 'author', 'order', 'orderby', 'year',
'monthnum', 'day', 'hour', 'minute', 'second', 'name', 
'category_name', 'tag', 'feed', 'author_name', 'static',
'pagename', 'page_id', 'error', 'comments_popup',
'attachment', 'attachment_id', 'subpost', 'subpost_id', 
'preview', 'robots', 'taxonomy', 'term', 'cpage')
```

That gives a lot to work with, but the important meta parameters (meta_key, meta_value, meta_compare) that we'd need to search through custom fields are not available.  They can easily be added, though, by adding the following to "functions.php" or a plugin:

```
$wp->add_query_var('meta_key');
$wp->add_query_var('meta_value');
$wp->add_query_var('meta_compare');
```

This can, of course, be used to add any of the parameters not normally available.

On the canine site, we want links for different age groups and other attributes stored in custom fields.  We can use the meta parameters in URLs for this.  For example, puppies can be found like:

```
http://repMyURL.com/category/adoptable-dogs/?meta_key=age&meta_value=Puppy
```

Wordpress stores custom fields as rows rather than columns.  This makes it easy to add any number of custom fields to any posts or pages without affecting the others.  Unfortunately, it makes it hard (and inefficient) to search using them.  With the method above, we can only search with one field at a time.  For the canine site, we will probably need multiple fields at once to be searchable.  This could allow an advanced search page with multiple parameters, but it would also allow us to show, for instance, only adoptable dogs in normal searches.

There is a plugin called [WP Custom Fields Search](http://wordpress.org/extend/plugins/wp-custom-fields-search/) that I will have to check out.  It allows searching by multiple parameters, but I'm not sure if it allows multiple custom field parameters.  If not and I determine this functionality is really needed, I may have to craft my own complex search function with ad-hoc [custom queries](https://tobymackenzie.com/blog/2009/11/18/stearns-wordpress-custom-queries/) that join an instance of the table(s) of meta-data for each query parameter.  This would be complex, messy, and inefficient.  Or I could store the dogs in [Pods CMS](http://pods.uproot.us/) and figure out searching with that.
