---
categories: [www]
comment_count: 3
date: 2009-11-18T11:30:04+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=98'
id: 394
modified: 2009-11-18T11:30:04+00:00
name: stearns-wordpress-custom-queries
tags: [mysql, query, stearns, wordpress]
---

Stearns: Wordpress Custom Queries
=================================

For the Stearns site, we need to list upcoming events on the home page.  Using [Flutter](http://flutter.freshout.us/), I created a custom write panel for the events (and other items).  The events are simply posts that have a custom date field attached to them.

I was attempting to use the "query_posts()" function to get the posts I need.  I discovered that it is possible to use this function multiple times on a single page.  I previously thought you were unable to because of "the loop", but you only have to make a few accommodations for the page name and other such Wordpress variables getting changed.  I was able to use this to output the page data on our home page plus two categories of posts.

Unfortunately, "[query\_posts()](http://codex.wordpress.org/Template_Tags/query_posts)" allows limiting by category and sorting by a custom key, but no less than, greater than, or other such comparisons with the meta key \[wrong, see [end of post](#update091118)\].  So I decided to make my own SQL query, to be run with the "[$wp\_db-&gt;get\_results()](http://codex.wordpress.org/Function_Reference/wpdb_Class)" function.  The function allows a straight SQL query to be run.  Then some other functions are used to put the result set into "the loop".  So, the code to run my custom query looks like the following:

<!--more-->
```
$querystr = "
	SELECT wposts.*
	FROM $wpdb->posts wposts
	LEFT JOIN $wpdb->postmeta wpostmeta ON wposts.ID = wpostmeta.post_id
	LEFT JOIN $wpdb->term_relationships ON (wposts.ID = $wpdb->term_relationships.object_id)
	LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
	WHERE wpostmeta.meta_key = 'date'
	AND wpostmeta.meta_value >= CURDATE()
	AND $wpdb->term_taxonomy.taxonomy = 'category'
	AND $wpdb->term_taxonomy.term_id = 2
	ORDER BY wpostmeta.meta_value ASC
	LIMIT 4
";
$pageposts = $wpdb->get_results($querystr, OBJECT);

if($pageposts):
	foreach ($pageposts as $post):
		setup_postdata($post);
		// output post just like normal
	endforeach;
endif;
```

where "2" is the category id, "date" is the name of the custom field, and "4" is the number of posts I want to retrieve.  It gets me the nearest four upcoming event items

It took me quite some time to get this working.  I was attempting to piece together two queries from the [Wordpress codex](http://codex.wordpress.org/Displaying_Posts_Using_a_Custom_Select_Query).  One had at least one mistake in it and one made use of aliases that the other didn't.  But finally, after much searching, looking at other codex pages, and looking at the database schema, I figured out what the problems were.  I didn't even have to do all that looking really, but I guess it was needed to get the MySQL part of my brain flowing again.

So, I will break down the query a bit for easier understanding.  To work with the custom fields, you must join the postmeta table like so:

```
LEFT JOIN $wpdb->postmeta wpostmeta ON wposts.ID = wpostmeta.post_id
```

Add this to your "WHERE" clause to use a particular custom field:

```
wpostmeta.meta_key = 'custom field name'
```

If the field is a date field, you can get items on or after today by adding this:

```
wpostmeta.meta_value >= CURDATE()
```

And you can sort with this (after the "WHERE" clause of course):

```
ORDER BY wpostmeta.meta_value ASC
```

To work with categories, you need to join both the "term_relationships" and "term_taxonomy" tables with:

```
LEFT JOIN $wpdb->term_relationships ON (wposts.ID = $wpdb->term_relationships.object_id)
LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
```

And then add the following lines to the "WHERE" clause that use the "category" type:

```
$wpdb->term_taxonomy.taxonomy = 'category'
```

and then limit to particular categories by ID:

```
$wpdb->term_taxonomy.term_id = repIntCategoryID
```

Hope this helps some folk do this much quicker than I was able.

<a name="update091118"></a>

[Update]I guess "query_posts()" can do comparisons with the meta keys, built in, nothing even fancy needed.  Don't know why I didn't see it before.  I haven't tested this, but my query would probably look something like this:

```
query_posts('cat=2&posts_per_page=4&meta_key=date&orderby=meta_value&order=ASC&meta_compare=>=&meta_value='.  date('Y-m-d', current_time('timestamp')));
```

Then you can just use "the loop" without loading the rows.  It is a lot easier to do.  Oh well, live and learn.[/update]
