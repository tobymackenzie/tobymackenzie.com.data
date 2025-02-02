---
categories: [toby, www]
date: 2020-12-06T04:20:52-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3149'
id: 3149
modified: 2020-12-07T00:36:07-05:00
name: home-internet-again
pings: ['https://www.tobymackenzie.com/blog/2020/06/27/2916/', 'https://www.tobymackenzie.com/blog/2020/11/29/3124/']
tags: [internet, phone, plan, service, telecommute, tmobile, wifi]
---

I've got home internet again
============================

After three and a half years tethering for my home internet, I've given in and switched to "real" home internet: [T-mobile Home Internet](https://www.t-mobile.com/isp).  Yes, it is cellular just like tethering, but it should allow for a lot more monthly transfer and may have bigger and better antennas and different handling at the tower.  I finally gave in because the cost made sense and I feel it will give me more freedom and ease of doing things that require data.

<!--more-->

Cost
----

I can theoretically get cell phone plus home internet for only $5 more per month than my current tethering friendly plan by dropping to T-Mobile's cheapest prepaid phone option.  I currently have their Simply Prepaid Unlimited Plus plan, which comes to a little over $62 per month.  Their [Connect 2GB plan](https://prepaid.t-mobile.com/prepaid-plans/connect) is $15 plus taxes and fees per month.  Their Home Internet is $50 per month out the door.  That will probably be a little over $67.  And there was no setup fee.

Of course, I could've done the same cheap phone plan with the more traditional local ISP's, AT&T and Spectrum.  They are faster and likely can handle more transfer.  And they could even potentially be cheaper or the same price, at first.  But that's only for the first year, after which they jump up.  Spectrum is $50 per month plus taxes and fees for the first year, but then [jumps up to $65](https://www.reddit.com/r/chartercable/comments/6eaapq/what_does_spectrum_internet_cost_full_price/).  AT&T has a $35 a month plus taxes and fees plan, but it seems to require a $10 a month equipment fee, making for $45+.  It also jumps up after a year to possibly $65+ with equipment.  Both companies may charge an install fee, though I might not have to for Spectrum since I have cable run already.  Either way, both of these options look to be notably more in the long run.

Capability
----------

I spend a lot of time using the internet, both for work and personal use.  Opening up my data will have quite an affect for me.

With the Simply … Plus plan, I get unlimited data on my phone and 10GB LTE speed tethering, then "unlimited" 3G tethering after that.  This setup has required various behavior accommodations for data usage.

With the new setup, I will no longer need to:

- pay much attention to how much data a particular activity will use.
- push more data usage to my phone to get the unlimited usage.
- wait and do some data heavy activities at work, the library, coffee shops, and other third party wi-fi locations.  This can take a fair amount of time, especially when [my car battery dies while getting data](https://www.tobymackenzie.com/blog/2020/06/27/2916/).  Covid has made things harder.
- deal with slow internet for work at the end of the month, since I'm working from home.
- defer or forgo altogether some activities.
- turn the tethering on and off on my phone numerous times a day.

Some of the activities that I will be able to more freely do:

- Download Linux ISO's and do installs for Raspberry Pis and other computers, which I've been wanting to tinker with, set up backup and file servers, and possibly even replace my main OS.
- Do OS and software updates that I had often put off and tried to do at third party wi-fi locations.
- Use my Windows computers, as the constant updates pretty much meant I rarely used them.
- Download backup files for work that I've left on servers for now, download and upload any other big files more freely.
- Download web / code software to try for work or personal projects.
- Download games and other apps to try.
- Watch more streaming TV / movies.  I had to be careful with this and limit the quality.
- Play internet computer games.  I [played some Jackbox games](https://www.tobymackenzie.com/blog/2020/11/29/3124/) over the internet recently and am considering buying [Splendor](https://store.steampowered.com/app/376680/Splendor/) and other computer versions of board games.
- Relatedly, do video chats from my computer.  I had to do it from my phone for that Jackbox game night, and haven't really done it otherwise, but now could.
- Do some remote backups, though I will have to think how to limit this, since this could easily cause 100s of GB of transfer and likely draw the attention of T-Mobile.

So, like I said, it will open some things up for me.

Service
-------

I ordered the service on Thursday.  I went to their [ISP page](https://www.t-mobile.com/isp), checked my address and phone number for availability, then set things up through their web chat.  It didn't take long, though the guy had to create a new account for me because the service is postpaid but my phone account is prepaid.  I don't know why they are so separate.  Anyway, the modem shipped quickly and got to me today (Saturday).

Setup was simple.  I removed the device from the box, installed the battery, and plugged it in.  It connected itself to LTE.  I connected to the wi-fi based on the instructions.  I downloaded the [T-Mobile Home Internet app](https://play.google.com/store/apps/details?id=com.tmobile.homeisp&hl=en_US&gl=US), set the wi-fi names and passwords to match my tethering ones for simple setup, and set the admin password.  At that point, it was fully working.

I did check out the more advanced settings that can be accessed from the web admin panel, but that wasn't really necessary and I'm not sure I changed anything there.  It does have some standard advanced router options like: 

- some logging
- DHCP settings
- DMZ forwarding
- UPnP forwarding
- virtual servers (another form of port forwarding)
- MAC to IP binding
- access control
- QoS
- parental controls

Interestingly, the modem interface says it can send and receive SMS.  I'm not sure what that's for.

The wi-fi signal has been strong, reaching my entire small house and into my backyard.  I may want to move it somewhere more out of the way, but based on its current strength for its current location, I think most any spot I'd consider will do.

The internet has been just fine, fast enough speeds and no noticeable connectivity problems like I've occasionally been getting with tethering.  It's felt much like other home internet I've used.  I can't tell if it's faster or the same speed as my tethering when at its best, but it will be nice to have this continuously.  I ran [one speed test](https://www.speedtest.net/result/10539637402) on speedtest.net, which showed a 59ms ping and transfer speeds of 45.99Mbps down, 10.74Mbps up.  Pings have been a little slower to common servers, like 102 average to t-mobile.com, but that's not bad for cellular.  I can SSH to my servers, so it doesn't seem to be blocking ports or traffic I need.  Seems plenty good for my needs.  Note that I am a single user.  Multi-user households might find the higher wired speeds more beneficial.

I haven't even logged into the account on the website, so I can't comment on that.  I'm trying to figure out if I can attach it to my prepaid account login.  I get the feeling their prepaid system is somewhat of a "red-headed stepchild" of T-Mobile, as I've had plenty of website and account change problems with it.  A link I found on their support pages to link phone numbers takes me to a "Gone Fishing" (presumably their 404 message) page.  So I may just have to live with separate logins.  I set up autopay when I first set up the account, so there's no rush.

Something lost
--------------

There are, of course, downsides to the cheaper phone plans.  The 2GB (or 5GB for $25) is a hard limit for both tethering and phone data usage.  Although I'm currently home most of the time and can use wi-fi for everything, I will have to be more careful when traveling or if I spend more time out and about once covid wanes.  Also, the cheaper plans don't allow for international calls and texts.  I haven't traveled internationally in a long time though and could switch back up to a more expensive plan if I know I will be.

Going Forward
-------------

I'm going to put this through it's paces early on to decide if it's really going to work.  If, after a week or two, it remains as good as it seems so far, I will switch to the cheaper phone plan.  I may start with the $25 5GB plan first just in case.
