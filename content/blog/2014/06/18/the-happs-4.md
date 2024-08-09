---
categories: [www]
date: 2014-06-18T00:56:36-05:00
date_gmt: 2014-06-18T05:56:36+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=626'
id: 626
modified: 2014-06-18T00:56:36-05:00
modified_gmt: 2014-06-18T05:56:36+00:00
name: the-happs-4
tags: [cogneato, conference, happs, wordpress]
---

The Happs
=========

It's been a few weeks since I've posted a Happs or any blog post.  I think a lot of the things I want to post about, I want to post a dedicated post, but that doesn't always end up happening.

Conferences
-----------

The weekend before last, I went to two conferences.  I took notes, which I plan to post once I get them digitized and cleaned up.  I enjoyed the conferences even though having both in one weekend, with one in Pittsburgh, was a bit tiring.  I went to [Rustbelt Refresh](http://rustbeltrefresh.com/) and [Pittsburgh Tech Fest](http://pghtechfest.com/).

### Rustbelt Refresh

I had gone to this last year (the initial year) as well.  I was pleased with the talks again.  It's a single track, single day event on general front end development and design.  It brings in some of the "celebrities" of the industry.  This year included Karen McGrane and Jeremy Keith, for instance, and last year had Eric Meyer (our local web "celebrity") and Jonathon Snook.  It is definitely nice to be able to hear talks by some of the people driving the thoughts in the industry.  I had a good time, the talks were good, and I learned some things or shored up some ideas I already had.

<!--more-->

### Pittsburgh Tech Fest

This was my first time for this event.  I hadn't even heard of it before, but a friend had been planning on going, and the price was cheap, so I figured it'd be a nice extra on top of Rustbelt Refresh.  I got there late, driving from Cleveland to Pittsburgh that morning.  I'm not a morning person.

The event is also a single day but had many tracks, probably around 8 at once.  The topics were much more varied and included more general software development, programming, and security topics, although many still had leanings toward the web.  The speakers were not well knowns.  I didn't know any of them besides having seen one the day before at Rustbelt Refresh.  The talks I went to were not as powerful as the ones at Rustbelt Refresh, but still brought interesting and more varied information.

This was my first full day conference with multiple tracks.  I have mixed feelings about the multi-track thing.  It definitely allows for more varied topics and an ability to skip talks that don't sound interesting.  But it was often hard choosing and I missed some talks I would've liked to go to.  It also provides less of a cohesive, group experience.

WordPress Initial
-----------------

I recently created a new GitHub repo, [wp-initial](https://github.com/tobymackenzie/wp-initial), to serve as a starting point for working on WordPress sites.  There isn't much to it, but it installs WordPress and [my base theme](https://github.com/tobymackenzie/wp-TJMBaseTheme) along with its dependencies using [composer](http://getcomposer.org).

It keeps the config file and some of the composer installed files out of the web root, but uses symlinks for the ones that do need to be there.  I struggled a bit with finding a way to have composer install WordPress and still have it work both with being accessible from the web root and having access to the config file.  It is hard coded to look in either its directory or one above, so I ended up just having a script that installs a symlink into the vendor directory.  Symlinks aren't ideal, but neither were the other options with composer.

I now have [my website](https://www.tobymackenzie.com) running on this starter.  I have some minor plans to improve it, but probably most of my WordPress focus will be on TJMBaseTheme.  And since I don't really use WordPress for new projects, I'm not sure how much focus that will get.  I have lots I want to do with my JavaScript and Symfony stuff.

Cogneato
--------

We have been getting a steady stream of projects at work.  It's been hard keeping up.  A lot of them have been taking patterns from previous sites, which has made it easier.  We redesigned the [Akron Art Museum site](http://akronartmuseum.org/) earlier in the year, which has influenced the design, structure and components of our more recent sites, such as the redesign of [Tuesday Musical's site](http://tuesdaymusical.org/).  Using SCSS, require.js, and a PHP widgeting system, among other things, have also made things faster and easier for me.  I have been focusing on improving my build process and have found it fun.  I've been happy with the improvements, though there is still more I want to do.
