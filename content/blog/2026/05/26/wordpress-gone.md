---
categories: [www]
date: 2026-05-26T23:47:00-04:00
guid: 'https://www.tobymackenzie.com/blog/2026/05/16/wordpress-gone'
id: 4876
modified: 2026-05-27T01:19:00-04:00
name: 'wordpress-gone'
tags: [change,simplify,site, wordpress]
---

WordPress no longer running this blog
==========

As of last night, this blog is no longer running on WordPress, as it had since 2003.  I have removed it and related code, switching to my own [wiki-blog](https://github.com/tobymackenzie/wiki-blog.php) software.  It builds a blog from a directory structure of markdown files.  I've been working towards simplifying my site for some time, managing content with files kept in a git repo, using less complicated setups, and being static generator capable.  Removing WordPress was in the plans for a while, but it was complicated to migrate.  I've been pushing hard towards it for the last month or so and finally decided to make the switch even though things aren't perfect and some things aren't implemented with wiki-blog.
<!--more-->

Reasons for this change include simplification in general, but also:

- Ability to use Vim to write posts and standard shell commands and Git to manage them.
- Doesn't work as well with a Composer and Symfony workflow.
- Removing a potential security risk, as WordPress does have vulnerabilities from time to time.
- Removing frequent updates needed for my site.
- Removing dependency on a database being installed.
- Ability to store and manage posts on GitHub or the like for free.
- Simpler static site generation, especially on Github or Cloudflare.
- It is my own code, much more heavily vetted and controlled by me.
- I used Jetpack to write my posts in MarkDown, but had to use the Classic Editor plugin to work with my existing posts.  Gutenberg would make things more complicated.
- WordPress 7 has some AI stuff built in.  I'm not sure what that entails, but I don't like the sound of it.

Though I had been thinking about it before, [Lea Verou's 2023 post about switching from WordPress to a static generator](https://lea.verou.me/blog/2023/going-lean/) got me more in the mood to focus on the transition.  As with most things on my site, it ended up taking a long time and getting pushed aside for more important things, but I did make progress.  I created my [wiki-site](https://github.com/tobymackenzie/wiki-site.symf) project as general code to run a website from markdown files.  My site had already been using markdown files, but I simplified and improved the setup, putting them in my [tobymackenzie.com.data](https://github.com/tobymackenzie/tobymackenzie.com.data) git repo.  I created my [wp-to-markdown](https://github.com/tobymackenzie/wp-to-markdown.php) script to make converting my blog to this format an automated process.  More recently, I created my [wiki-blog](https://github.com/tobymackenzie/wiki-blog.php) project to serve those in a blog format.

The conversion of my posts took a lot of work.  Posts go back to 2003 and have come from two separate blogs merged together, both with different plugins and settings.  Newer posts are written as markdown with Jetpack's feature, but older posts weren't.  I did what I could from wp-to-markdown, but lots also had to be changed in the posts themselves.  Most of this was done in WordPress, since I was still using it live until recently and had to be able to sync posts with my data repo without having to manage differences.

Among the many fixes I had to do, there were some special space characters and weird mistranslated characters in older posts.  There was also a fair amount of malformed HTML in the older posts that WordPress seemed fine with but didn't translate well.  I had to replace shortcodes with HTML or regular markdown, since building shortcodes in my wiki-blog would be more complicated, especially with its ability to output in txt / md formats.  I had to deal with differing image paths that WordPress must automatically translate to the current location.  I had done some fancier HTML in some posts, such as nested `<dl>`and weird line-break formatted stuff with my own nested heading structure, which sometimes didn't convert well through wp-to-markdown:  I simplified those structures or made them more standard.  Some final changes had to be done during the final switch, since they were things that wouldn't work well through Jetpack, such as [CommonMark attributes](https://commonmark.thephpleague.com/2.x/extensions/attributes/).

Some of the many things I didn't get to finish because I wanted to get it live:

- I have no built-in way to add posts, so I have to manually create the year / month / day folders and post, and manually enter the date-times, id, category, tags, etc in [front-matter](https://commonmark.thephpleague.com/2.x/extensions/front-matter/), then build and deploy.  I have to do my own image sizing and placing for posts with images.
- List pages, such as the blog home page, categories, tags, and years, have no pagination, so they just show up to a max number.  I don't want pages where things bump down to the next page with each post, since that will require regenerating all those pages, so I plan to do a date based system.
- List pages for tags and categories are slow to render, since they `grep` through in the front-matter of the markdown files.  Lots of visits to these, like from bots, may overload my server.  Some cacheing will probably be needed here.
- Building a static copy of the site, especially with list pages, is very slow.  I'm at 10 minutes without the tags, month, and day pages.  I need to work on the rendering speed as well as improve the system to not rebuild pages that don't need rebuilt.  I'll need to write code to allow me to just add a single post and only render it, the home page, category and tags lists, and next link on the previous post.
- No display of comments.  I no longer was accepting them except pingbacks, so only older posts have them, but some contain useful info.  I want to do them in a way that works well with being part of a git repo licensed by me.
- No pingback, webmention, comment functionality at all.
- No search functionality.  Will have to be done with `grep` as is, since I don't want to complicate the server setup.
- No xml sitemap for search engines.
- No RSS feeds for categories and tags, and other pages WordPress generates.

This will be my first post with the new setup.  Hopefully it works alright.

There's much more work to do, but I'm glad to have WordPress torn out of my site and a vim + git + shell workflow in the works.

<ins>PS: Launching my first post didn't work out alright:  It took down my blog home page, some list pages, and the post wasn't available itself, because of a malformed date that I manually entered into the front-matter.  This went on for around 15 minutes as I angrily rushed to find the problem and get it fixed.  I will need to get that script that will do this for me built ASAP.</ins>
