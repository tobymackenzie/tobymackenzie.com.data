---
categories: [www]
date: 2026-04-15T10:49:40-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4854'
id: 4854
modified: 2026-04-15T10:50:35-04:00
name: project-wp-to-markdown
tags: [blog, markdown, project, site, wordpress]
---

Project: WP To Markdown
=======================

I've been working for some time towards moving my blog off of WordPress, towards a simpler and static friendly setup.  In that interest, I have made a PHP script to copy the site data to a Markdown directory structure and copy the media files, called [WP to Markdown](https://github.com/tobymackenzie/wp-to-markdown.php).  The file and folder structure is largely based on the URL path structure of a WordPress site using the default permalink structure.  This will help me to reproduce a similar structure with the software that replaces WordPress, which I am in the process of writing.

<!--more-->

The project copies the data directly from the database, using the database credentials.  It supports SSHing into a server to do this if the database isn't accessible directly from the outside.  The media files are copied via `rsync`, which can have a remote path in the normal `rsync` argument format.  When run again, it only updates files that have been changed, so it is friendly for continued use, `rsync` deployment, and `git` version control management.  Though my blog isn't using the resulting content yet, I have been managing [a git repo of it](https://github.com/tobymackenzie/tobymackenzie.com.data/tree/main/content/blog) for some time, which will become the "single source of truth" once I'm off of WordPress.

I use [PHP League's CommonMark](https://commonmark.thephpleague.com/) converter for the conversion of posts to Markdown.  It adds additional data as [front-matter](https://commonmark.thephpleague.com/2.x/extensions/front-matter/) to each file, such as date, modified date, guid, categories, and tags.  That can be used by processors to output that additional info on the website target.  I have it copying the data that I think will be useful for my rendition of the blog pages.  It builds the files in the directory structure of `{prefix}/{year}/{month}/{day}/{slug}.md`.

It should be noted that my posts for at least the last decade are all in Markdown format in the database using Jetpack's Markdown feature, which stores it in the `post_content_filtered` field, requiring minimal conversion.  It prefers that field over `post_content` because that's better for my use case.  It will also convert the regular semi-HTML posts, of WordPress though.  I'm not sure how it would handle stuff from the new Blocks editor, as I don't use that.

It should also be noted that many of my posts, especially older ones, required some cleanup.  Since I run my script repeatedly, I modify the posts in WordPress until they convert cleanly, unless I clearly need to update my script.  I spent quite a bit of time on this and even converted some older posts to Markdown to make it easier.  Examples of fixes I needed to do include malformed HTML that WordPress must ignore, malformed Markdown that must've been misinterpreted by an old version of Jetpack, problems with HTML entities and other weird character issues, and problems with code blocks.  For a time I used a `code` shortcode, for instance, which wasn't getting converted to code fences, so I modified those in the posts.

The project also copies other data that I think will be needed for the new version of my blog:  media, comments, categories, and tags.  I copy the media in the same directory structure that WordPress uses from `/uploads` on, eg `{prefix}/{year}/{month}/{name}.{extension}`.  WordPress also saves some meta-data of images, which I then save in a YAML format in the folders with the images, like `{prefix}/{year}/{month}/{name}.yml`.

The comments are copied next to the related posts in a directory structure like `{prefix}/{year}/{month}/{day}/{slug}/comments/{int}.md`, using an ascending integer for which comment it is, since the database ID isn't that useful for organization outside of WordPress.  Any responses to comments are stored with a `{parent}-{int}.md` name format to associate them with their parent comment.  I separate the trackbacks and pingbacks into its own folder with the same structure, called `mentions` because I want to eventually support [webmentions](https://en.wikipedia.org/wiki/Webmention).

Categories are stored in the structure `{prefix}/category/{slug}.md`.  This matches the structure WordPress uses to view a listing of posts in a category.  The files just store the display name as the heading and the description as the body, if applicable.  I didn't need any of the other data associated with a category.  The tags are just stored in a single file at `{prefix}/tag.csv`, because mine are all much simpler.  The CSV has three fields, slug, name, and description, though the vast majority of mine just have the slug.  The post files contain the full slug of each associated category and tag, but this will allow me to list categories and tags and have the description and longer name where needed.

I've been working a lot lately on the code to use this data to generate my blog's web-pages.  I want to roughly match the output from my WordPress templates.  I will have to check basically all posts to make sure nothing gets messed up.  Since the image code from WordPress will be processed by a Markdown converter, I may have some work to do for them.  Any shortcodes I may have remaining will need handling of some sort.  I also have a lot of work to set up the list pages like WordPress has.  I will probably try to simplify them a lot, like avoiding having pagination, eg `/blog/page/2/`, which aren't friendly to static generation.  I'm still thinking out how I want to do that.  There is still a lot to do, but I will eventually get there, and then I will be able to remove WordPress and simplify my site setup significantly.
