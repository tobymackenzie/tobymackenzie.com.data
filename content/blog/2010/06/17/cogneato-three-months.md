---
categories: [www]
date: 2010-06-17T12:24:39+00:00
date_gmt: 2010-06-17T12:24:39+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=328'
id: 429
modified: 2010-06-17T12:24:39+00:00
modified_gmt: 2010-06-17T12:24:39+00:00
name: cogneato-three-months
tags: [cogneato, jobs, web-development]
---

Cogneato: Three Months
======================

I've now been at [Cogneato](http://cogneato.com) for a little over three months.  It is definitely long term now.  I am still liking it, especially since I've been branching out into other areas even more.  I've been doing more programming in PHP and Javascript to set sites up and add functionality, and have even gotten to work a little with SQL again.

For example, on one site, called Pink Rave, I had to add blog functionality, which isn't quite built right in like with Wordpress.  For the standard "archive" box, I had to make a bit to spin through all posts and chunk them based on date, then output the represented dates in the box.  For the search functionality, Cogneato's CMS has nothing built in, so I had to do custom queries.  They are using the BLOB data type, so I couldn't use the FULLTEXT searching, instead having to build concatenated LIKE statements.  Luckily, the CMS can easily put the results of custom queries into its result objects, so it is easy to then work with them like I otherwise would.  In fact, for this blog, I handle all multiple item listings with the same output script that just fills the object array with different data depending on the type of page.

<!--more-->

A Javascript example is the David Hawkins site I am working on currently.  It uses [jQuery](http://jquery.com) animations for switching submenu items and the content on the page, and loads new content with AJAX calls.  I've worked with jQuery before, but this is more advanced and complex and has been taking me a little while to get working properly.  There is also the Javascript example of the dropdown/suckerfish menu system I built for our more normal sites.  It is easier to use and more capable than the old MM script we were using.  I will probably post more details about it at some point.

The job doesn't pay real high for a college graduate job, and I would easily be making this much had I stayed on at the [Winking Lizard](http://winkinglizard.com) as a line cook.  But it is much more relaxed, interesting, and rewarding.  Cooking involved standing for many hours with a lot of physical movement, quite tiring, especially when it was busy.  The Peninsula Lizard can really get a lot of throughput in the summer, when it could be busier than we could handle continuously all day.  At Cogneato, though, I sit relaxed in a chair, able to stretch or go to the bathroom whenever.  The Lizard was fun, but I've always found computers, the web, and data very interesting.  Anyway, enough of the comparisons.  I've not heard any mention of a raise after my three months, but two people were hired instead of the one originally planned, and I wasn't the one that was supposed to be long term, so I can't expect it that quickly.

The major point of this post, beyond a brief update of my status, was supposed to be that I've been learning a lot there.  I've been learning better ways to do things and building bits of code/markup that I'll be able to use on my own projects.  Every project I make sure I learn something.  I've shared some of what I've learned in this blog already, but am way behind if I want to post it all.  I plan to try to get more of  it on here in the near future and keep posting it at a decent frequency.  I'm not working freelance projects at the moment, so the Cogneato stuff will mostly replace Wordpress stuff.
