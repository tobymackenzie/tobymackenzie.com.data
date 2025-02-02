---
categories: [www]
comment_count: 1
date: 2016-09-21T01:48:54-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1266'
id: 1266
modified: 2016-09-30T21:07:23-05:00
name: 10k-apart-deployed
tags: [10kapart, azure, contest, deploy, development, performance, php, web]
---

10k Apart: Deployed
===================

My [10k Apart](http://a-k-apart.com/) entry was finally deployed and can be [seen at its Azure URL](http://conway-s-game-of-life-10kapart2016.azurewebsites.net/), though it's not in their gallery yet.  There were problems deploying it, and it took several tries and back and forths with [Aaron Gustafson himself](https://www.aaron-gustafson.com/) to get it working.<!--more-->  One simple problem was I forgot to commit a distribution version of a JS file.  The other, though, was because I made a custom built PHP router that determined the route and a relative base path based on some `$_SERVER` vars and `__DIR__`.  I couldn't figure out a solution then, so I just hard-coded the routes and assumed serving from the web root.  I'm thinking the problem was related to `$_SERVER['SCRIPT_FILENAME']` and Windows file path formats.  I've made a solution I think will work, but I'm not going to even try deploying it for this contest.  It's quite a relief that it's up and working.

One problem I've noticed with the deployed site is that the server's gzip is not as friendly to me as Apache's is.  With my Apache deploys, I am comfortably within the 10k limit up to at least a 50 by 50 grid, but with the Azure deploy, I can go slightly over the limit on first load with default grid size for browsers that use CSS but not JS.  I have made a few changes to reduce the weight.  Hopefully I'll be able to update the Azure deploy and the reduction will be enough.  It also may mean that I won't even try to implement some of the features I was considering adding though, unless I can get a reasonable margin.
