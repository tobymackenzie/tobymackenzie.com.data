---
date: 2026-07-01T11:58:00-04:00
categories: [www]
tags: [blog, comment, update, data, license]
id: 4880
name: blog-mentions-display
guid: 'https://www.tobymackenzie.com/blog/2026/07/01/blog-mentions-display.md'
---

Blog comments / mentions display back
=====

I have brought back the display of existing comments on this blog.  When I [switched away from WordPress to my own blog solution](/content/blog/2026/05/26/wordpress-gone.md), I didn't build any display of comments on posts since I [haven't had comments enabled in years](/content/blog/2018/07/24/comments-closed.md) and wanted to make the switch quickly.  I also wasn't sure how I wanted to handle storing them, since [my site data repo](https://github.com/tobymackenzie/tobymackenzie.com.data) is public and will likely have an open license at some point.  Storing quotes by others under my own license is probably fine, but I decided to mostly do summaries unless the exact quote seemed important.  I did mostly do full quotes of my responses, since that's definitely my data.  So I put their comments and my responses all in a single markdown file per post, in more of a prose format than normal comments are shown.
<!--more-->

The comments are stored as sort of a sub-page of the post, so paths for the pages are like `/blog/2003/02/01/my-post/mentions`.  I use the word mentions because I hope to eventually enable web-mentions and that reasonably handles comments, pingbacks, and trackbacks.  These are linked to at the bottom of the post so that they don't take up extra space or transfer data for people who aren't interested in them.

I didn't think exact date-times were that important, especially for older posts, so I mostly put approximate relative dates like "a year later" or no date info at all.  I generally put the name they used in submitting the post, and didn't put their link / email address because that also doesn't seem that important.

[This is an example comment page](/content/blog/2010/02/26/tmcom-now-real-xhtml-5/mentions.md).  [This is the commit of the data](https://github.com/tobymackenzie/tobymackenzie.com.data/commit/d13392aff270c8f042618828fe0c324ec9347745).  [This is the wiki-blog commit to add mentions support](https://github.com/tobymackenzie/wiki-blog.php/commit/fa4cc174f057b4bb76d90d57d5ecc1e4891392cd), though later commits fix some things.

I removed any comments that didn't seem useful to visitors, such as "Thank you for this post" or the like.  I removed any trackbacks that didn't still have a post linking to my site, though I summarized them as a comment if the content seemed important.

I didn't add the trackbacks from my own posts in this way.  Instead I added a `related` list in the post meta-data with the paths to these.  I haven't done anything to display them on the site yet, but will eventually.
