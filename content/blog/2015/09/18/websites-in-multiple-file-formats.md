---
categories: [www]
comment_count: 1
date: 2015-09-18T23:45:58-05:00
date_gmt: 2015-09-19T04:45:58+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=694'
id: 694
modified: 2015-09-18T23:45:58-05:00
modified_gmt: 2015-09-19T04:45:58+00:00
name: websites-in-multiple-file-formats
tags: [formats, functionality, site, web]
---

Websites in Multiple File Formats
=================================

Since I saw [Symfony's `_format` routing parameter](http://symfony.com/doc/current/book/routing.html#book-routing-format-param), which is used to effectively set the file type of the response, I've thought it would be cool to have every page on a website support more than just 'html' response types by adding a `.{_format}` to the end of the URL and make a template version for each.  Users would be able to consume the same information in different formats depending on their needs.  'txt', for example, would basically have just the content that would go in the `` element, in pure text format, providing a fallback or simplified view that can be read even by `curl` users.  'json' or 'xml' formats might provide the content and meta data about it in a machine consumable format.  You could even go all out with an 'mp3' format where you read the page content.

Yesterday, I took my first step toward this idea on my site by implementing [my homepage in the 'txt' format](https://www.tobymackenzie.com/index.txt).  This was very simple since my content is already being composed in markdown, a visually pleasing structure for text content.

Obviously, adding more pages and formats will add development time.  This probably wouldn't be useful enough to be worth it for a normal site, but for my own site, I get to play with whatever cool ideas I want.
