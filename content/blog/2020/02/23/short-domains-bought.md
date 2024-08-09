---
categories: [www]
date: 2020-02-23T04:10:10-05:00
date_gmt: 2020-02-23T09:10:10+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2658'
id: 2658
modified: 2020-09-24T00:55:18-04:00
modified_gmt: 2020-09-24T04:55:18+00:00
name: short-domains-bought
pings: ['https://indieweb.org/short-domains']
tags: [dns, domains, purchase, registrar, registration, registry, short]
---

Short-domains bought
====================

I finally made it happen: I bought a short "vanity" domain.  Two, in fact: <macn.me> and <tobm.me>.<!--more-->  I had wanted a short domain for years, but had trouble deciding which registry, registrar, and domain to go with that were available, and had to convince myself it was worth it just for "vanity" purposes.  I spent a lot of time researching and deciding, and became frustrated with the situation.  But the desire for having one finally won out.

I had one short domain in the past, but never ended up actually using it and got rid of it.  It was on the `.us` TLD, which doesn't allow WHOIS privacy, and I'm reluctant to make my home address and phone number so easily findable from my domain.

The why
-------

I became interested in the short domain idea after seeing Tantek Çelik and the IndieWeb community make use of it.  Their [wiki page on the matter](https://indieweb.org/short-domains) goes into some of the reasons to have one.

My main domain is my name, which is kind of long.  It can be a pain if I have to spell out my email address over the phone.  It takes longer to type, especially on a touch screen.  Making sure I haven't misspelled it in forms takes longer.  Using a short domain should simplify these things greatly.

The short domain will allow me to create my own link shortener.  I had been more interested in this idea when I first saw it, but I still think it will be useful in some cases.

I will be able to throw small personal apps, dev domains, etc on short subdomains so they will be quick to type.

The search
------------

### Registry / TLD

I went with a [ccTLD](https://en.wikipedia.org/wiki/Country_code_top-level_domain) because they are the shortest TLD available, and because they don't have the level of ICANN control that generic TLD's have.  `.me` is considered a [gccTLD](https://en.wikipedia.org/wiki/GccTLD), meaning search engine's don't consider sites using it associated with the country that manages it.  It is reasonably priced as gccTLD's go and seems to have reasonable terms of service compared to others.  The country seems stable and modern, with a democratic government.  The registry seems well featured such as having [DNSSEC](https://en.wikipedia.org/wiki/Domain_Name_System_Security_Extensions), if I were to want to use that.  `me` also suggests a personal site and is two characters from my last name.

### Registrar

I went with [Porkbun](https://porkbun.com/) for my registrar.  It has low prices.  It has free DNS that can do most of what I want.  It has free WHOIS privacy, and a [redacted setting](https://kb.porkbun.com/article/97-new-whois-privacy-settings-explained) that helps with asserting ownership.  Its terms of service are less bad and less long than many others.  They're US based, and seem to have reasonable values.

I was also considering [Gandi](https://www.gandi.net/en-US).  They appear to have awesome DNS that can do a lot of cool things Porkbun's can't, are respected, including by privacy / free speech groups, have partial WHOIS privacy better for asserting domain ownership, and I like the values demonstrated on their site and blog even more than Porkbun's.  But they are in France, which could cause issues, such as if legal problems come up, and their terms of service are a long, complicated mess that includes some undesirable language.

### Domain / SLD

I wanted something that could be associated to me in some way, most likely by being characters from my name.  I wanted it to make sense, without tossing on random extra characters or reordering ones from my name.  I wanted the SLD to play well with the TLD.  I preferred something that would be easy to say over the phone and have easily distinguishable characters when reading.  I wanted it to be short.  I didn't want it to be premium priced, which ruled out two character or less SLD's.

I had a list of a bunch of options, including plays on pronunciation, such as "2b".  Some were a bit of a stretch.  I wasn't sure if I wanted numbers because they might require explaining when spoken, but they were also more likely to be available.  It was hard to find reasonable three character SLD's, and got harder and harder as time went on.  The more desirable four character ones were taken.  I eventually settled on some pieced together but straightforward four letter options.  `tobm` has part of my first name and a "t".  `macn` could have my first name used as a subdomain and local part of the email address, and has the interesting play of mac n me, like [Mac and Me](https://en.wikipedia.org/wiki/Mac_and_Me).

The purchase
--------

Once I felt comfortable enough with my decision to go for it, I ran into a couple problems in execution.  The domain I had been considering for a couple years and had settled on (2b1.me) happened to get bought by someone else two days before.  This forced me to look at my options again and pick another, longer one.

Then, when I went to search for it on Porkbun, their results list was returning a generic "Error" for the `.me` TLD.  After several hours, the problem eventually cleared itself.

I got two domains because they were on sale for only a few bucks each for the first year.  I can decide which I like the best and drop the other when renewal time comes along.  I kind of like macn.me, but we'll see after a bit of use.

The setup
---------

Once the purchase was finalized, I familiarized myself with the Porkbun interface, then set up the DNS.  Their interface isn't the best UX.  It isn't always straightforward and can be cluttered, clunky, and slow to work with.  I pointed my A* records at my web server.  My web server already redirects unkown domains to my main domain, so I didn't have to do anything for that.  I did a wildcard subdomain with a CNAME to the main domain.

I set up the domains on Fastmail, then added the MX, SPF, and DKIM records at Porkbun.  When things propagated, I tested receiving email, and it worked.

I added the domains to my HTTPS certificate using certbot.  Once I restarted Apache, HTTPS was working.

So now I have to go about actually using these domains.  I haven't set up any apps / sites with them.  I haven't given the email addresses to anyone.  I look forward to reaping their benefits and playing with them.
