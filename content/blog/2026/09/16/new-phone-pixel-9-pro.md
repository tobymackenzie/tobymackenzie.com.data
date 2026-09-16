---
date: 2026-09-16T14:02:02-04:00
categories: [computer]
tags: [phone, convergence, google]
id: 4889
name: new-phone-pixel-9-pro
guid: 'https://www.tobymackenzie.com/blog/2026/09/16/new-phone-pixel-9-pro.md'
---

New Phone: Pixel 9 Pro
======================

A couple weeks ago, I bought a new phone, a Pixel 9 Pro.  That is my 3rd phone in the last three years, about as many as I had bought in the previous 15.  But the last two just weren't meeting my desires.  The Samsung S24 didn't support multiple profiles or the AVF terminal, and the separate Samsung account, required for some features, was off-putting.  The Minimal MP01 was missing reasonably frequent security updates, had a poor camera, had some buggyness and definitely had no video out or AVF terminal, among other things.  The Pixel can support all that I want and can run the security / privacy focused Android fork, [Graphene OS](https://grapheneos.org/), as well as other common Android forks.  This is my first try with Graphene or any self-installed alternative.  I set it up and then moved my SIM card over a little over a week ago.
<!--more-->

I had been looking at Pixels when I got my S24, but they didn't support video out at the time at the software level, and AVF terminal even didn't exist then.  I got the Minimal because of its e-paper screen and physical keyboard, but small startup phones have disadvantages and I think I need a better security setup for my main communications device.

I went specifically with the 9 series because the 10 series has no physical SIM, but I've been using the SIM to switch from phone to phone for years.  The 8 series is missing some of the security and other features of later phones.  The 11 series will likely not support Graphene OS due to a missing security feature.  The Pro has a good camera set, better than the S24 most likely.  I got mine refurbished from Amazon.  Cost over $500, which seems like a lot for a refurbished phones, but the newer ones are even more.

The device is slightly bigger and heavier than the S24, which is undesirable, but the way that advanced phones are going.  It has the reflective screen that most phones have these days, so I will have to get a matte protector soon.  Otherwise, it is similar in form to the S24.

I have set up Graphene OS using profiles to separate different uses.  It was fairly straightforward to install with their web installer, if a bit long and with very verbose instructions to read.  It was fairly easy to get the OS set up, besides me having to check out the settings and read up on the best way to do things for my first time.  It is much like stock Android to set up, other than there are more permissions to deal with, and a bit more effort to use the multiple profiles and copy apps between them.

The main reasons I went with Graphene over stock Android are security, control, and my dislike of all the AI and other junk getting added to the latter.  Graphene also has a much better multi-profile experience and better privacy by default.  I do have a little bit of distrust of the Graphene devs based on their social media personas, but it's probably less at this point than my distrust of Google.

Graphene has an "Owner" profile and then can have many secondary profiles set up.  The owner can do some settings that other profiles cannot and must be logged in before other profiles can.  I have set things up based somewhat on [Side of Burritos' setup](https://sideofburritos.com/blog/grapheneos-how-i-install-apps/), having the owner profile with app stores and then using that to install the apps to other profiles where they are actually used.  I had to install Play Store and Play Services on my main secondary profile as well though, and to log in separately with Google, to get Google apps and some others to work properly and connect to my account.  I may in the future remove Play from the owner account and just have it in my main one.  In addition to owner and main profiles, I have a work and a dev profile, and plan to create a sandbox profile for playing with new apps and other less trusted stuff.

Graphene and the phone do appear to handle my use cases.  Android's desktop mode isn't quite as nice as Dex, but it does work, should handle my use cases, and will probably only get better as Google tries to make it a sellable feature.  The AVF terminal installed just fine, with a little developer mode dance.  It boots a Debian virtual machine to CLI, and I've been able to install the dev software I wanted.  I haven't tried the GUI yet.  The Android interface surrounding it is weirdly finicky, often losing focus of the terminal, sometimes behaving weirdly and opening up a weird GUI-like window that does nothing, and other issues.  The beta Android version supposedly has some important new features and fixes that will hopefully make their way to me.  The camera seems nice, has a better zoom than the S24.

The two main problems I have had so far are with cross-profile messages and a bank app.  The cross-profile messages do usually show, but my phone does not make any alert sound or vibration, nor send them to my watch.  Also, there's some weirdness of getting SMS notices twice in secondary profiles that they are shared with, once from the Messages app and once from the owner profile.  My bank app (Citizens) doesn't appear to work.  I tried playing with the permissions settings and moving it to the owner profile, but still get errors.  I may play with it some more, but for now have to keep a second phone for that purpose (mainly remote depositing checks).

It took me a long time to get set up to where I am, and there is still more to do, but I think I will like it overall.  I'm going to keep on with it and hopefully it will finally allow me to do some level of the "convergence" and dev work I've been hoping to make possible with my phone.
