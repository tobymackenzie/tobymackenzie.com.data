---
categories: [computer]
date: 2025-06-12T20:52:26-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4581'
id: 4581
modified: 2025-06-12T20:54:55-04:00
name: got-smartwatch-bangle-js-2
tags: [banglejs, espruino, phone, watch]
---

Got a smartwatch: Bangle.js 2
=============================

I bought a [Bangle.js 2 smartwatch](https://shop.espruino.com/banglejs2) from [Adafruit](https://www.adafruit.com/product/5427).  I haven't ever owned or played with a smartwatch, and haven't even worn a dumb watch in 15 years or more.  But I got to thinking that I look at my phone a lot for time and notifications, and this could reduce phone use and simplify that behavior at the same time.  An e-paper screen could make it less like looking at a mini phone on my wrist.  It also could do some other things like step counting, sleep monitoring, and heart rate monitoring that might be useful, and timers, alarms, and stopwatch so I don't need to reach for my phone for those either.  The Bangle is open source, lightweight, and seems feature filled enough to fit what I'm going for, cheap enough ($89) to not worry too much if I want more later.

<!--more-->

Screen
------

I initially really wanted an e-ink screen.  Always on, great visibility in environmental light from "any" angle.  There is the Watchy with a full e-ink screen, but it can't get notifications.  There is the Fossil / Citizens hybrids, but they don't have much screen and have stopped being made.  So there's the MIPs, transflective, and the like options, including some Garmins, Pebble, and Bangle.  Not quite as good to look at, but they can be better color, still always on visible with environmental light.  I eventually came to accept this is the best I could do.

Weight
------

I was never a fan of heavy watches, and would be more likely to not want to wear it if it wasn't quite light.  The Garmins can be fairly big.  The Bangle is about as light as any standard digital watch.

Phone App
---------

I feel like showing notifications and other standard smartwatch features ought to be able to be done as standardized Bluetooth HID and built into the phone OSs.  Instead, smartwatch manufacturers tend to make their own phone apps.  I was a little paranoid about having these on my phone, generally closed source, made by private companies, and potentially handling some very private data.  In looking at these, I came across GadgetBridge, a fully open source app for various Bluetooth devices.  Bangle has gone full-in on GadgetBridge, with a modified version of it as their official app.  So, open source that I could check and modify if I wanted, plus I could use it with other gadgets if I wanted to switch in the future.  By default, it can't connect to the internet, which allays concerns of it sharing my data.  Apps are installed to Bangle from a web browser.

Interface
---------

The Pebbles used buttons.  I would've preferred this.  They can be used without looking at the watch by feel and pressed quickly.  The Bangle has one button and a touch screen.  That will have to be good enough for now.

Dick Tracy
----------

Some of the watches have speakers and microphones.  It is still not common for them to be able to handle phone calls, but some can.  At first I was thinking that any smartwatch ought to be able to do this, like a fancy modern version of Dick Tracy's watch from the 40s.  But then I decided I probably wouldn't be talking into my wrist too often in reality.  The Bangle has no speaker or microphone, only a vibrator, so no cool Dick Tracy phone calls for me.

Hackable
--------

Like the Pebble before it, the Bangle is a "hackable" smartwatch, meaning the software can relatively easily be modified by the user.  The OS and apps are all open source and are installed and updated from the web app.  There are often multiple versions of a given type of functionality, such as watch face, step counter display, etc, so I can choose the one I like the most.  The apps are built in Espruino, a JavaScript interpreter that can convert JS to microcontroller code.  I happen to know JS well, and thus should be able to take and modify the existing apps or build my own if I so choose.  That means I won't be stuck with a given layout, user experience, or software functionality if I or someone else is willing to improve it.

Hackable watches often have less polished interfaces.  That is probably fine for me, especially since this is my first.

Health
------

The Garmins go heavy on the health / sports functionality.  I'm not that active and don't need a bunch of different exercise modes.  I walk a lot though, so a pedometer would be nice.  And a heart rate monitor might be nice if only because my family has a history of heart disease, and it would be nice if it could catch any unusual activity there.  Smartwatches often do sleep tracking as well.  My sleep has been fairly bad for a long time.  The Bangle has those features, although probably not nearly as polished or accurate as some of the more expensive watches.  It definitely doesn't have any EKG or similar capabilities.

It also has a GPS.  It uses a lot of battery though and can take a while to find satellites unless using phone data for AGPS.  It could be used for run tracking but likely not turn by turn directions.  It also uses quite a bit of battery.  The Garmins are more advanced here.  I don't really think I'd use this though.

Pebble / Core
-------------

Right around the time that I was considering this, the former Pebble guy got Google to open source the former Pebble code, and decided to release new watches using it with a new company called Core Devices.  Pebble was hackable, with MIPs display, similar to the Bangle, and still has a large community with lots of watch faces and apps.  The new OS will be open source, as will many of the apps, and does have some GadgetBridge support as well as another open source phone app coming called Cobble, although that may not be the official app.  The hardware and software will likely be more advanced and polished than Bangle.  The one that's mostly a clone of a previous Pebble won't be available to new buyers until August though, and the new redesigned one with more features probably won't be available until at least December.  I'm thinking if I want more than the Bangle at that point, I may upgrade and sell the Bangle.

Bangle 3
--------

The Bangle 2 has been out for several years and I was wondering if a version 3 was upcoming.  From the forums, it seemed like the Bangle guy wasn't wanting to do a new Kickstarter to fund a new watch, and was ordering more of the current one, which he felt would last him a while.  However, after I ordered mine, I saw him say that his supplier was going to discontinue that watch, so he may have to make a new one at some point after all.  Not sure how long it'd be for him to run out of supply and go through the design and fundraising process, but if it happens, and is compelling, I may upgrade to that and sell the 2.

So
---

I just got it, and am still playing with the setup, so I won't comment on how it works yet.  But I'm hoping it works out and has me looking at my phone less.  At only $90, it isn't too big an investment and should be sellable if I decide I don't like it or want to upgrade quickly.  Hopefully I can at least play some with Espruino.  I will probably upgrade at some point to something better, so maybe I've become a smartwatch person.
