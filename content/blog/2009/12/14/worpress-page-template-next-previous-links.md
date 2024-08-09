---
categories: [www]
date: 2009-12-14T23:15:41+00:00
date_gmt: 2009-12-14T23:15:41+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=124'
id: 399
modified: 2009-12-14T23:15:41+00:00
modified_gmt: 2009-12-14T23:15:41+00:00
name: worpress-page-template-next-previous-links
tags: [stearns, templates, wordpress]
---

Worpress Page Template Next & Previous Links
============================================

I ran into this problem on the Stearns events and recipes pages, which both use custom templates pulling in posts from a particular category.  We use the query_posts() function on those pages.  The next_posts_link() and previous_posts_link() functions are used on normal multi-post pages to navigate through more items than appear on one page.  Using the query_posts() function without the paging, such as:

```
query_posts("cat=4&limit=5")
```

the paging doesn't work at all:  It just shows the same results for each page.  To get this to work, you must tack on the "paged" parameter with the "$paged" wordpress php variable, like:

```
query_posts("cat=4&limit=5&paged=".$paged)
```

and pagination will work just fine.  You can only do this for one set of items, but you'd want to break out to a separate  page for multiple anyway.
