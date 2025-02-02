---
categories: [www]
comment_count: 1
date: 2013-07-16T02:23:50-05:00
guid: 'http://tobymackenzie.wordpress.com/?p=543'
id: 543
modified: 2013-07-16T02:23:50-05:00
name: working-on-a-new-wordpress-bare-theme
tags: [theme, wordpress]
---

Working on a new WordPress bare theme
=====================================

I haven't been doing much with WordPress, since at [Cogneato](http://cogneato.com) we have our own CMS.  But a customer request for a WordPress site a while back and the upcoming [GiveCamp](http://clevelandgivecamp.org/) which I will be participating in this weekend have rejuvenated my interest in working with it.  Back when I was using WordPress more often, I had built a bare theme I used as a starting point, including for the [Stearns Homestead](http://www.stearnshomestead.com/) site I was working on when I first started this blog.  That was the WordPress 2.x era though, and the theme is now outdated.  I decided to begin work on a new theme, making use of the new 3.x features.

I have learned a lot since building that theme, and wanted to bring in some of my new knowledge and coding practices to the new theme.  I also wanted to put this one on [GitHub](http://github.com/), since I now have [an account](http://github.com/tobymackenzie/) and others might find it useful.  I still haven't decided for sure what I'll call it (for now it is TJMBare) and have more work to do, so it isn't on there yet, but hopefully will be by this weekend.  Anyway, I wanted to mention some of the things I have done or will be doing with it.

Class helpers
-------------

I am putting all of my functionality and data into classes that in most themes is put into the global namespace.  The classes will help group functionality and data together, making it easier to develop and to avoid collisions.  Since WordPress doesn't yet require PHP 5.3+, I am avoiding using PHP namespaces, but am compensating by putting the equivalent on the front of the class names.  Functions.php will just include the class files and instantiate what is needed.  Child themes will be able to extend parent theme classes to change functionality.

<!--more-->
Output buffering and rendering management
-----------------------------------------

One thing I like about the CMS we have at Cogneato is that the 'skeleton' of a site, which in WordPress would consist of header.php, footer.php, and possibly sidebar.php, is built in one file (though it includes other files for various pieces) so I can see the whole wrapping structure basically at once.  I wanted to do this in WordPress, but with the way it pulls in view files, this is not easy.  At least not without [output buffering](http://php.net/manual/en/book.outcontrol.php).  Output buffering allows me to render the page that WordPress loads, but just store it into a variable, then render my skeleton, sticking the page content somewhere in the middle.

I built a buffer manager to handle this for me.  It allows me to store named buffers for later access by simply calling a method at the beginning of the content and another at the end.  I borrowed this to some extent from [Symfony's PHP templating](http://symfony.com/doc/current/cookbook/templating/PHP.html) concept of 'slots'.  Later in the document, I can then echo a buffer, using its name to access it.  I will likely cover this buffer manager in more depth in another post.

Another thing that I like doing that this buffer manager helps with is splitting my views into multiple pieces that can be included wherever they are needed.  I have an expansion of the buffer manager that allows me to pass it a name of a template to include and some data to pass to a template and have it return the rendered output of that template.  It's sort of like using [get\_template\_part()](http://codex.wordpress.org/Function_Reference/get_template_part), but being able to pass data in, either for configuration or actual data to fill spots in the template, makes these templates much more versatile.  I plan to do a lot with them to keep things DRY.

Theme configuration/settings handler
------------------------------------

As WordPress has evolved, the number of things a theme can configure has increased.  There are various things that can be configured by the user within the WordPress interface if the theme is configured to take advantage of them, such as user sidebars, backgrounds, and headers.  Many of the newer ones use the [add\_theme\_support() method](http://codex.wordpress.org/Function_Reference/add_theme_support), but there is also [register\_nav\_menus()](http://codex.wordpress.org/Function_Reference/register_nav_menus), [register\_sidebar](http://codex.wordpress.org/Function_Reference/register_sidebar), etc.  Some of them also seem to need to be called at different times during the WordPress lifecycle.

I wanted a way to sort of abstract away these differences.  I made a setting manager class that accepts an array of settings.  It will apply the settings with the appropriate method at the appropriate time (based on when the [Twenty Twelve Theme](http://wordpress.org/themes/twentytwelve) calls them, since I figure they chose their timings well).  It makes the whole configuration look much cleaner and allows me to fix the way the settings are applied in a separate location.  This setting manager class will likely be another post topic sometime soon.

GitHub
------

Hopefully by this weekend, I will put this on GitHub.  I will add the link when I do.  I also may submit it to the [WordPress themes directory](http://wordpress.org/themes/), but their requirements are not necessarily the same as mine.  Some of the ideas may not fit in with [their guidelines](http://codex.wordpress.org/Theme_Review).  But either way, I hope it will be useful to others, and perhaps others can share their ideas to improve it.
