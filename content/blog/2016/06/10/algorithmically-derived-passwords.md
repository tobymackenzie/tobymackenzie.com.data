---
categories: [computer]
date: 2016-06-10T02:06:52-05:00
date_gmt: 2016-06-10T07:06:52+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1151'
id: 1151
modified: 2016-06-10T02:06:52-05:00
modified_gmt: 2016-06-10T07:06:52+00:00
name: algorithmically-derived-passwords
tags: [password, security, technique]
---

Algorithmically derived passwords
=================================

I've been considering a new password storage method for a while now.  Currently, I have a system where I compose passwords of pieces of several different values that I have memorized.  Each value has a key that I have associated in my head to the value, and I have a file with the keys for each site.  Lately, I've also been doing part of the password as something derived from the name of the site.  This has helped somewhat with making the passwords memorable, but I still frequently have to look at my password file.  If someone got a hold of this file, it would take some dedication and knowledge of me, or at least access to the plain texts of some of the passwords, to crack the system.  Nevertheless, I've been looking for something easier to use and preferably more secure at the same time.

I've been looking at options like [YubiKeys](https://www.yubico.com/products/yubikey-hardware/)  and [1password](https://1password.com/), but they have their issues.  Today, I came across a cool option wherein passwords are algorithmically derived from a single password and the site name.  This is sort of like what I'm doing in my head for some of my newer passwords, but much more advanced, able to produce hash passwords of a desired length and even with character constraints.  I read about the idea from [a post by Tab Atkins](http://www.xanthir.com/b4g30), who has [his own solution](https://tabatkins.github.io/password/) freely available to use.  The comments on his post also led me to [SuperGenPass](https://chriszarate.github.io/supergenpass/), a similar idea.

Both are of these options built purely using web technologies, making them easy to use anywhere.  Both are open source, so I can check their code, verify they are doing what I want, and modify them so they can be slightly different.  Neither need to store anything (unless you change the config for SuperGenPass) or require accounts.  They have an option to work as a single-page file that can work even offline, wherein you type your master password and the name of the site, and they will give you the password in plain-text to copy elsewhere.  SuperGenPass also has a bookmarklet option that can be run from the page you are entering the password on (obviously web only) by using an iframe (requires a third-party server) that can put the password directly into the password field, bypassing the need to copy the password at all.

So these are definitely interesting options to make working with passwords much easier, and the passwords I have for each site can be more complicated and theoretically secure than what I use currently.  The biggest danger would be, if someone figures out my master password and what settings I've used for the generators, they will have access to any passwords I've created.  I would probably do multiple master passwords, at least a normal one and an extra-secure one, just to limit the number of accounts they could access.  I could even throw in a simple modification to the master password derived from the site name to make it even less of a problem.
