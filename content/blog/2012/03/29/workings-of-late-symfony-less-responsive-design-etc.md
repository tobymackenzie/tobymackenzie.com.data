---
categories: [www]
date: 2012-03-29T02:56:41+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=468'
id: 468
modified: 2012-03-29T02:56:41+00:00
name: workings-of-late-symfony-less-responsive-design-etc
tags: [cogneato, lesscss, responsive, style, symfony]
---

Workings of Late: Symfony, Less, Responsive Design, Etc
=======================================================

As I've mentioned, at [Cogneato](http://cogneato.com) we've been building a new version of our CMS using [Symfony](http://symfony.com) on the server side.  I've spent a LOT of time with Symfony now.  I like it and will be using it for some other projects outside of work as well.  We've been working on some eCommerce type sites that will hopefully be launched in the coming months, while building the system that all of our sites will eventually run on.

Though I like it, there have been many challenges to deal with, especially with making Symfony work with our old system.  We have way too many existing sites with more than enough custom programming to convert them completely to a new system, so we're setting it up so that both can be run side by side on old sites, while new sites will eventually only need the new system.  But it has been a lot of effort to get the two working together properly.  Symfony is inflexible in some ways, and not well documented in some areas.  I intend to, in the coming months, write about my solutions for the various issues we've dealt with.

<!--more-->

I've also been continuing to read and work on stuff outside of work.  I've started making a Symfony base for building my own sites.  I've been working on putting together a coding "style guide" for my personal work and finding and using best practices in my base.  I've began working with [Less CSS](http://lesscss.org) to make writing styles easier, since Symfony makes it easy to compile it to CSS automatically.  In my base I will be using [YUI Compressor](http://developer.yahoo.com/yui/compressor/) as well to reduce file sizes, Symfony providing the same automatic compiling for that.  Either of these will allow me to comment my CSS as much as I want, so I'll be doing more of that.  I will probably put my base bundle up on [GitHub](http://github.com) or something once it gets more fleshed out.  All or most of my current codebase will probably make it's way up there as well.

I've been looking into responsive web design, and will be redesigning my site using techniques from it.  I think my new site will finally make use of the HTML5 sectioning elements at the same time.  And I plan to use plenty of new CSS techniques, including stuff from the flex box module.  I have to figure out a way to have flex box for browsers that support it and fall back gracefully for older browsers.  I want to find a way to set it up so that the browsers I don't test in will get a very basic style almost like having no CSS, so that I won't have to worry about disappearing content or the like.  At work we've stopped developing for IE 6 finally, and I think I will try to serve it and browsers of the same vintage or older this very stripped down styling.  I've been experimenting with media queries to reverse target them by preventing them from seeing entire blocks of CSS or files, which I'll likely write about at some point.
