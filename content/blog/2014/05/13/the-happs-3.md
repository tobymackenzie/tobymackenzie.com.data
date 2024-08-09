---
categories: [www]
date: 2014-05-13T02:08:01-05:00
date_gmt: 2014-05-13T07:08:01+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=607'
id: 607
modified: 2014-05-13T02:08:01-05:00
modified_gmt: 2014-05-13T07:08:01+00:00
name: the-happs-3
tags: [cogneato, happs, samba-soccer, theme, wordpress]
---

The Happs
=========

These happs blogs don't always allow me to go into as much depth as I would like, but they are definitely a lot easier to write.  I have been writing much more frequently now that I've started them.  "Remember, a writer writes, always."

WordPress Starter Theme
-----------------------

After much time and effort, I've finally released my WordPress base theme, [TJMBase](https://github.com/tobymackenzie/wp-TJMBaseTheme).  It is the very bare parent theme for what [my website](https://www.tobymackenzie.com) has been running on for several months now.  These days, I don't use WordPress for very much, but I have done several projects with it, especially earlier in my web development life, and to some extent still like it.

Years ago, I had made a theme starter that was basically bare of any styles and extra fluff, the kind of thing you might want to start with if you wanted a good starting point for doing a theme basically from scratch.  I never released it (didn't release anything open source at that point), though I did use it for some projects and let at least one interested party use it.  I had stopped doing much with WordPress once I got my current job, but I did want my theme starter to be useful to the community.  WordPress 3 came out and brought some important changes that made my old theme behind the times, missing some important features.

<!--more-->

While doing a couple projects at [GiveCamp](http://clevelandgivecamp.org/) and one at work, I started laying the groundwork for a new version of my starter theme.  With my experience from work, I may have gone a bit overboard using output buffers, object orientation, and the like to organize and abstract.  Most WordPress themes don't go this far with those, though newer ones are starting to.  This more advanced setup, of course, took time to build.  I kept playing with more ideas and reorganizing things as I went, since I had no deadline.  I also wanted to make sure that I had no code copied from some of the themes I used as a basis for mine, so they wouldn't affect my license choice.  Last week I basically took my then working theme and rewrote every line that might've been copied to be sure that every one is mine, modifying and fixing things as I went.

So the new theme is released.  The [readme](https://github.com/tobymackenzie/wp-TJMBaseTheme/blob/master/README.md) goes into more details about what it is about.  It is not exactly simple anymore, but if you just want to do the styles on top of already built markup, it is a good starting point.  It is easy enough to modify the markup around the OO method calls if you don't understand them.  The template files are kept relatively DRY and some of the pieces are split into their own template files.  If you have a little more of a programming understanding, you can probably with my [WPThemeHelper project](https://github.com/tobymackenzie/WPThemeHelper) to simply render files or do some more advanced theme setup.  I'm glad it's finally out there.

Work
----

At work, I've been finishing up several new sites or rebuilds of existing sites.  The company seems to be doing well again and I'm finally getting some cash flowing in again.  Basically all of our sites we do now are responsive.  Most sites seem to introduce some new difficulty in maintaining responsiveness.  It has been a challenge, but I feel I've learned a good bit from it.  I hope I can resolve some of the outstanding issues and continue to refine my process.

Goodbye, Freelance Client
-------------------------

Before I started at Cogneato, I built a site for [Samba Soccer Club](http://www.sambasoccerclub.org/).  It was my only truly freelance site (ie that I built for someone else by myself and got paid for it).  I designed it and everything.  I'm no designer, and the styles might've been considered dated, but it worked.  I didn't get paid much for it, but it was a good learning experience.  I did some continued work for the site, though that kinda died off over the years.  A couple of times, I gave some parents or other helpers accounts to do some writing or other work on the site, including once a few months ago.

Every once in a while, I check on the site to make sure things are going alright with it.  I was a little surprised when I visited it today to find that it was completely redone.  The new site appears to have been done with something that is probably similar to Square Space, ie using prebuilt templates, hosted on their server, with their site builder admin interface.

The theme is probably more modern than what I provided.  It probably has a much better admin interface for adding things like schedules and photo galleries.  I'll admit that I didn't provide the best interface for those things in particular.  I would've built something fancier, but as I stated before, I didn't get much money for it.  The schedules were done in tables with classes on everything, so they basically had to copy a previous one and stick the new stuff in the right spots.  The photo gallery stuff was done mostly through WordPress's nice media gallery, except that new galleries had to be added as a specially formatted link on the gallery page (they would otherwise still exist, but visitors wouldn't know how to get to them).

I wasn't that enthused at doing content updates for them, especially for the low prices I was charging.  I would rather be developing new, interesting things.  So I think they are probably better served by the new site solution, assuming it does what they need.  I'm just a little surprised, that's all.
