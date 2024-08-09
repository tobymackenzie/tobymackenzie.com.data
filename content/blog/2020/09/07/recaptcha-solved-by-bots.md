---
categories: [www]
date: 2020-09-07T01:56:58-04:00
date_gmt: 2020-09-07T05:56:58+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3024'
id: 3024
modified: 2020-09-07T01:56:58-04:00
modified_gmt: 2020-09-07T05:56:58+00:00
name: recaptcha-solved-by-bots
tags: [bot, captcha, forms, problem, web]
---

reCaptcha solved by bots?
=========================

Some presumed bots figured out the reCaptcha (version 2) we protect forms with at Cogneato.<!--more-->  They were sending spam submissions through contact forms on two sites, at a slow but annoying rate of a one or two per hour.  The bots were not hitting the forms hard and were only succeeding with around a third of their submissions.  The successful IP's were from Russia and adjacent countries.  There were also other IP's submitting that weren't succeeding at all, which I'm not considering in the success rate.

We added a honeypot to the forms in question, increased the security level to "Most secure" in the reCaptcha settings, and tried switching from the checkbox to invisible version, but those didn't help with these bots.  Google wasn't even seeing the submissions as suspicious at first, and gave us a warning that our integration may be misconfigured.  Eventually it did acknowledge suspicious activity and removed the warning.

I eventually gave up on a general solution (besides leaving the changes I made in place), and opted to just block the specific IP's from getting the captcha added to the forms.  They could (and did) continue to submit the forms, but would just get an error message when the captcha check failed.  I added a few more IP's to the list over time, and it has largely taken care of the problem.  For now, of course.
