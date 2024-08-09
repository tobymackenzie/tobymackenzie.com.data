---
categories: [www]
date: 2019-03-29T03:12:46-04:00
date_gmt: 2019-03-29T07:12:46+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2276'
id: 2276
modified: 2019-03-30T03:49:51-04:00
modified_gmt: 2019-03-30T07:49:51+00:00
name: tale-of-bulk-email-woes
tags: [development, email, newsletter, problem, stress]
---

A tale of bulk email system woes
================================

This past week, my coworker and I had to deal with stressful problems with [Cogneato](https://cogneato.com)'s bulk email / newsletter system.<!--more-->  The system is mostly old code written by former developers, so it is hard to work on.  Problems have only been occasional, but stressful.

Last Friday, we suddenly had seemingly unrelated problems on a couple sites.  One didn't send anything to most recipients, and the other sent more than one copy to many recipients.  Both sites had been sending newsletters fine up until then.  We really couldn't come up with any possible causes for either.  We were able to manually send the ones that didn't go out, but a few days of debugging and tweaks didn't solve the problems.  We contemplated completely rebuilding the scripts.

The bulk mail system has the ability to schedule newsletters to go out at a particular date and time.  This is accomplished with some scripts and a cron job.  We had a problem once in the past where duplicates were being sent because two user crons were running the one site's script.  We verified that this wasn't the case on that server this time.

However, we failed to account for an unusual situation created by an issue with another site on the server.  It had had a problem that required looking at logs older than our log rotation stored.  The only place we had them was backup system images.  We had a Rackspace person get the logs for us.  He spun up the clones of our server to do so, but didn't shut them down for us.  The images, of course, included the user cron jobs.  And since the newsletter configuration was on a separate database server, all the servers ran the same scripts for the same newsletters at the exact same time.

Completely outside of where we thought to look.  We wouldn't have noticed it without the help of Rackspace either: When asking them why our mail logs were missing emails that we clearly received, the discussion led them to point out the logs on the other server showed the emails, which in turn led us to realize the other servers had duplicated the cron jobs.

Soon after we killed the extra servers, several sites had similar problems.  This time, it only took a half hour to discover that it was caused by one of those tweaks I had made to a script from before we knew about the real cause of the original problem.  I had added several checks beyond what was already there to try to prevent sending duplicates to a given recipient.  I had move setting a status on the newsletter to an earlier point, but failed to notice a then later check on that status.  This caused the building of the mail body to not happen, so they either sent with an empty body or threw an error when sending.  A quick fix, but added stress.

I added one more tweak to hopefully deal with the multiple instances of the script running at the same time: I added a random pause at the beginning of the script so that the status changes and checks wouldn't line up perfectly.  The code was something like:

``` php
if($isScheduled){
	usleep(rand(1, 3000000));
}
```

Hopefully everything is fine now.
