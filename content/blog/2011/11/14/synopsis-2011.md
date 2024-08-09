---
categories: [www]
date: 2011-11-14T09:05:05+00:00
date_gmt: 2011-11-14T09:05:05+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=459'
id: 459
modified: 2011-11-14T09:05:05+00:00
modified_gmt: 2011-11-14T09:05:05+00:00
name: synopsis-2011
tags: [general]
---

Synopsis 2011
=============

Haven't been posting much at all, but I've not been working on web stuff any less. I'll give a bit of a synopsis of what I've been doing. This year I've been doing less new and interesting with HTML and CSS and more with JavaScript and PHP and database stuff, particularly the last several months. We've had one rather large project that requires mostly work in those areas. We are building a system that will use a JS heavy admin area based on [Qooxdoo](http://qooxdoo.org/).  The public side will use [Symfony 2](http://symfony.com) with [Doctrine](http://www.doctrine-project.org) for managing data. All three of those I've never worked with before and have had to learn as I go.

Qooxdoo is a full framework for JavaScript with a class system and a bunch of widgets that make working with it sort of like programming a desktop GUI application. It really extracts away from HTML/CSS and it can be frustrating knowing how to do something easily with those but not being able to use them. I don't care for the abstraction, and it would be unfeasible to build a non-JS compatible app with this approach. I do like its class system quite a bit though. It has a lot of features and gives a lot of functionality for free, such as firing events on property change and easy access to parent methods.  I've been working on my own class system and would like to incorporate some of its features.

<!--more-->

Symfony is a PHP framework.  It uses an extensible system with a small core and a bundle bundle system to add more features, in theory any other.  It uses somewhat of an MVC architecture and an HTTP based system for responding to requests and caching them.  It is more complicated to get set up with than Rails or CakePHP seemed, but it also seems more flexible and powerful, though I didn't delve very far into those.  There is a lot to it and it's not all well documented, so it can be hard to find solutions to some problems.  It can be difficult figuring out how to get things (data, services, etc) to where they are needed.  Still haven't figured out a good way to pull its renderings out into external scripts so we can integrate it with our old sites easily.  I mostly like the framework and think I will build my own system on top of it for at least my own website.

Doctrine is an ORM with a DBAL.  It uses regular PHP objects, but connects them to database tables or other storage methods by configuration.  It is fairly neat and makes changing things easy.  Efficiency became a problem for doing some things with the large amount of data we're working with, so we had to use raw SQL for some things.  There are also some things that can't seem to be done with it.  It is causing difficulties integrating with our old schema.

Been working on some of my own stuff, especially my javascript library.  I think I will put my library on github at some point.  I've been researching class systems for javascript heavily and wanted to migrate to one before doing so, but it's taking a long time to find something I like that will actually provide enough benefit over straight function/prototype classes to be worthwhile.

After that I want to build a base system using Symfony for my own website.  I will then do a redesign and try for a responsive one with progressive enhancement.  I'm going to try to have fun with it, since it is my own site.

I've also been looking to do some more freelance stuff, probably with Wordpress.  May move to Symfony if I get a good enough system going with it though.

That's enough of a synopsis, kinda long.
