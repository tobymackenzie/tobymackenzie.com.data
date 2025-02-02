---
categories: [www]
date: 2005-11-26T06:01:36-04:00
guid: 'http://cosmicosmo.ath.cx/log/2005/11/26/darwinports-ror-new-apache/'
id: 92
modified: 2024-04-15T20:08:30-04:00
name: darwinports-ror-new-apache
---

DarwinPorts: RoR, new apache
============================

I've taken an interest in Ruby on Rails because of a recomendation from some folk at [Macaddicit forums](https://web.archive.org/web/20051219091711/http://www.macaddict.com/forums/topic/67023).  I used [darwinports](http://darwinports.org) to install Ruby and the gems installer.  I then used the gems installer to install rails.  Darwinports is very nice and easy to use for the installations, as it takes care of all dependcies automatically and has an easy to understand interface.  It is extremely slow though, often taking several hours for some packages.

I got rails working quite quickly through the Webrick server.  I followed a [tutorial](http://www.onlamp.com/pub/a/onlamp/2005/01/20/rails.html?page=1) that helped me easily create a simple application in rails.  So far it seems very nifty and easy to work with, but I still have a lot more to learn before I can really get going with this.

One part of the tutorial introduced me to AJAX, codename for a set of javascript functions that allow loading of content into an already loaded browser page without the use of frames or objects, the only methods I had known of before this.  I had been looking for a replacement for frames for a good while.  AJAX allows a lot more versatility than the frame method.  RoR offers AJAX through some built-in functions, requiring no use of the underlying javascript.  I would, however, like to learn the javascript as well.

The Webrick is much slower and less versatile/functional than a regular server, so I wanted to try to get it running through Apache.  I tried it with my current apache install, but couldn't figure out how to get fast-cgi, a seemingly required component, to work with it.  So I decided to move over to a darwinports installed apache; it'd be easier to update anyway, than with the WebServerXKit that I had been using, and would also allow me to change my PHP version to use exif tags so that my photo gallery'd work.  That was much more of a hastle.  I had trouble installing my apache2 with php5, until I realized I needed to remove the startup item created by WebServerXKit to allow darwinports to create its own.  I then had trouble getting it running.  I thought it replaced the standard apache install from apple, as it seemed to have modified its httpd.conf, but it was really in it's own directory.  It also didn't create an httpd.conf for me, so I had to create one from its default one, then modify it with my own settings, plus add in loading of both php and fastcgi.  I still haven't gotten RoR working with it yet.  I also couldn't get the darwinports mysql server to work with it, and for some reason had trouble getting the old mysql server to work (I don't even know what I did to get it working).  Darwinports oughta have more documentation on this stuff, as it doesn't quite work out of the box and has configuration files and what not in its own locations.
