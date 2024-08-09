---
categories: [www]
date: 2016-09-28T07:10:48-05:00
date_gmt: 2016-09-28T12:10:48+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1277'
id: 1277
modified: 2016-09-28T07:15:33-05:00
modified_gmt: 2016-09-28T12:15:33+00:00
name: 10k-apart-updated
tags: [10kapart, development, git, project, update, web]
---

10k Apart: Updated
==================

I got an update link for [my 10k Apart project](http://conway-s-game-of-life-10kapart2016.azurewebsites.net) on the 22cnd.  I already had some updates committed, so I soon-after clicked the link.  It wasn't until yesterday that the update finally applied.  So it was quite a relief when it finally did.<!--more-->  The basic functionality was already there, but I had made several fixes to content, style, performance, functionality, and bugs.

That first update request I let sit for several days, hoping it was just taking a while.  I tried a few more times after that.  Each time, my entry would disappear from the gallery for a while, then reappear, but still be the same as it had been.  All along, I had an inkling of what the problem was, but was getting no feedback.  I had done some history rewriting in git to keep a clean history, and I'm assuming their deploy method was just an unforced pull, and didn't like that.  For the final, working request, I went back and figured out which commit I would've been on when it first deployed, removed all history after that, and rebuild from another branch in a way that wouldn't require a force-push.  Since it worked that time, I assume that was the problem.

There're only two days left for the contest.  I still have some things I'd like to do, but probably won't attempt the more involved ones.  The ones I might try to get in are:  a restart button to go back to tick 1, if I can find a way to fit it; try to improve reflow performance; try to shave any bytes I can.  Since the update process still took perhaps half a day when it worked, I'll probably do what I can and submit the last request by the end of day tomorrow.  Then it's done, and I can move on to the next phase:  looking more closely at other entries; writing some blog posts; writing a readme and adding a license to the project repo.
