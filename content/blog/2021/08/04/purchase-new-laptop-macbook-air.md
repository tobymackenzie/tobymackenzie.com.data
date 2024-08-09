---
categories: [computer, computer, www]
date: 2021-08-04T01:02:01-04:00
date_gmt: 2021-08-04T05:02:01+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3469'
id: 3469
modified: 2021-08-04T01:02:01-04:00
modified_gmt: 2021-08-04T05:02:01+00:00
name: purchase-new-laptop-macbook-air
tags: [linux, mac, purchase]
---

Purchase: New laptop, MacBook Air
=================================

I've made another new laptop purchase in the past couple months:  I bought a refurbished [2020 MacBook Air](https://everymac.com/systems/apple/macbook-air/specs/macbook-air-core-i3-1.1-dual-core-13-retina-display-2020-scissor-specs.html) from Apple.com.  It has a 10th gen i3 Intel processor, 8GB of RAM, and 256GB of storage.  I bought it to replace my struggling [11 year old MacBook](https://everymac.com/systems/apple/macbook/specs/macbook-core-2-duo-2.26-white-13-polycarbonate-unibody-late-2009-specs.html).  I bought a Lenovo Yoga 7i, but was struggling to get comfortable with it for my web development work.  I made the call to get the Mac so I could directly migrate both my work computer user and my personal computer users, with the plan to use it for development and use the Yoga for other stuff.

<!--more-->

I was eyeing the new M1 MacBook Airs, which I could have gotten new for $849 at MicroCenter.  The $849 price tag was what first brought on the idea, being cheap enough to make a second laptop purchase more palatable.  The virtual machine story didn't seem fully worked out on the M1 yet though, which I kinda need for development stuff, and some of my older apps won't run on the newer OS.  That made the last Intel ones seem like the best option, and when I saw the i3 refurb for $729 on apple.com, it made it even more palatable.  I was also eyeing the i5 and / or 16GB RAM options of the 2020 model.  The RAM would've helped with virtual machines, and both would've helped for future proofing.  However, having just bought another new laptop, the price of the refurbished base model won out, giving me two laptops at only slightly over the $1500 ceiling I had set for the one Windows / Linux laptop originally.

I should note that this was the third Mac laptop I've purchased since vowing to wait until they introduced Macs with touchscreens.  I had thought they were coming soon back when rumors were flying before the release of the iPhone, circa 2005 when I bought my second iBook.  There were also rumors flying before the release of the iPad, which was when I bought the MacBook that would be my main machine until these recent purchase.  I haven't been hearing (or paying attention to) rumors this time.  I miss the touch screen when I use the Mac and have touched the screen in vain several times, and moved to touch it many more.  If they release one soon, I would not regret the purchase and be happy for the future potential.

The new Air is similar to my old MacBook, but is:

- much lighter (almost 2 pounds)
- much better battery (all day versus struggling to last a couple hours due to old battery)
- much faster (3-4 times the GeekBench score, feels snappy)
- more stable (no unexpectedly dying due to battery, no frequent WiFi problems)
- more RAM (can run VMs without killing the system)

It has Big Sur as the OS version, while the Macbook is stuck on High Sierra, which should make it more secure and featured.  Better dark mode and tabs support are the main things I've noticed there.  It has USB C charging, so I can now charge the two laptops and my phone with the same charger.  It has a backlit keyboard so I can work more easily in the dark.  It has a fingerprint reader so I can more easily switch accounts.  The screen is sharper and easier on the eyes, though unfortunately, still glossy.  I think the keyboard is slightly less tactile, though still good enough.

Apple's Migration Assistant allowed me to easily copy my users with files from both work and personal computers.  It didn't always go smoothly though.  I couldn't get it to work over WiFi, so I had to do Time Machine backups to a portable drive and then import from that.  It took many hours, but other than needing to get the disk plus USB C adapter, it was probably faster than WiFi.  Apple changed the location of mail for its Mail.app, and the migration didn't take this into account.  I was using POP, but switched to IMAP on both computers, then had to manually copy all mail from the old computer to new IMAP folders.  That's still in progress.  I had the user setup wizard freeze for one of my accounts and had to force shut down, but the account worked fine after restart.

I'm still working on setting things up after having it several weeks already.  With merging my work and personal computers into one device, I am wanting to have a more isolated and secure setup, as well as needing to have different versions of some dev software for work versus personal dev.  I am doing separate users to isolate, running separate [homebrew](https://brew.sh/) installations per user to allow different versions of dev software, and trying to use VMs for isolating server environments.  This is all taking time to figure out how to get working as I want it.  Thus, I've still had to go to my old work and personal computers sometimes, giving me four computers to deal with.  Soon, I should be down to two, and hopefully eventually, when I get more comfortable in Linux, one.
