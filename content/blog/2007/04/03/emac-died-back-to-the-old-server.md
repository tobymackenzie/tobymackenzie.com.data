---
categories: [www]
date: 2007-04-03T23:57:53-05:00
date_gmt: 2007-04-04T04:57:53+00:00
guid: 'http://cosmicosmo.ath.cx/log/2007/04/03/emac-died-back-to-the-old-server/'
id: 140
modified: 2016-04-30T02:12:09-05:00
modified_gmt: 2016-04-30T07:12:09+00:00
name: emac-died-back-to-the-old-server
---

emac died; back to the old server
=================================

On Friday, the eMac being used as my server suddenly died.  It was running fine at maybe 1400, and I had remotely accessed the drive around then.  But I noticed the fan noise was strangely missing at maybe 1800.  The power button did nothing at all.  Reading online, it seemed a dead PRAM battery could cause some all-in-one macs of that era to not boot.  So I bought a new battery from radio shack on Saturday.  It ran a ridiculous $15 for a 1/2 AA Lithium battery, but I figured it was worth a try to get the server up again.  Unfortunately, after putting it in and resetting the power management unit several times, the best I got was the fan to get power for less then a second before shutting off.  After some more reading, I found the power supply board is probably bad.  On those computers, the power supply is built into a special board for only those computers that contains the graphics and audio stuff as well.  So it's probably not worth it to get a new board for the thing to fix it.

I bought myself an external drive enclosure for 3.5" disks (I already had one for 2.5") to get the data from the eMac.  I had backed up nearly a month before, and had made several important changes since then, so I wanted the data before I got the server up again.  The drive was quite a pain to get to.  I had to dissassemble much of the emac to get to the drive.  Everything in there is very tightly packed together and crazy, very proprietary looking parts for much of it.  When I took out the drive, I was a little worried.  It had been a while since I had worked with anything but 2.5" drives.  The thing looked so big compared to them that I was worried it might be and old 5.25".  But of course those went by the wayside long before this computer was made.  The enclosure I got (an acomdata) works nicely and is very speedy.  It's also quiet, with no fan, but still doesn't get hot it seems.  It cost more than others, but it got very good reviews, much better than the only other one that I could find locally.

So i got the old data and put it back on my iBook, the computer I use most of the time.  I had set up a server for testing stuff on it, so I just copied the old site folders and the important mysql files and got it up fairly easily.  The new server has MySQL 5, so it is a little more up to date.  It still only has Apache 1 though.

Whenever I get my new computer, which will hopefully be in June, when Mac OS 10.5 is released, the iBook will become the server full time.  So it worked out alright really.  Except that I'm not sure what to do with the dead eMac.  It is currently disassembled in my living room.  I don't really know how to sell it, nor to fix it.
