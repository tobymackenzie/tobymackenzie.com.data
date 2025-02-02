---
categories: [ideas, ideas, www]
comment_count: 1
date: 2016-02-17T01:29:25-05:00
excerpt: 'ICANN could make available single character TLD''s for URL shortening purposes, and make available on them SLD''s of one or more characters.'
guid: 'https://tobymackenzie.wordpress.com/?p=966'
id: 966
modified: 2019-07-24T01:47:23-04:00
name: single-character-tlds-permashortlinks
pings: ['http://indiewebcamp.com/permashortlinks']
tags: [domains, indieweb, permashortlinks, tld]
---

Idea: Single character TLDs for permashortlinks
===============================================

I've been interested in [Indieweb](http://indiewebcamp.com/) lately, and have been looking for a good domain for [permashortlinks](http://indiewebcamp.com/permashortlinks).  The article goes into more detail, but advantages include:

- easier to read and type, especially from print
- fit better, especially in character limits of twitter, email line wraps, etc.

I have a domain that's six characters total (SLD + dot + TLD), but I'm not sure I like it:  It has a '0' in place of an 'o' (might confuse people); is on a TLD that disallows whois privacy; and doesn't feel as representative of me as some others I've thought of. It's hard to find good short domains.  One reason, of course, is that short domains are desirable and are taken more quickly when available.  Another is that [ICANN](https://www.icann.org/) and predecessors traditionally seem to have been reluctant to allow short SLD's.  One and two character SLD's are often reserved or "premium".

Idea
---------

ICANN could make available single character TLD's for URL shortening purposes, and make available on them SLD's of one or more characters.  This would make available, using normal ASCII domain rules:

<!--more-->

- 1,296 3 character domains, which is 1 character shorter than any currently available domains
- 46,656 4 character domains
- 1,726,272 5 character domains
- 63,872,064 6 character domains
- 2,363,266,368 7 character domains

The number of 5+ character domains could be bolstered even further if it were stipulated that third and greater level domains in this space would be sold separately rather than treated as sub-domains.  This 3LD stipulation might be seen as breaking an existing contract of the web, but the TLD's would all be known, so user agents could treat them specially, and servers should only be returning redirects anyway, reducing cookie issues.

This would provide a lot of people / sites with permashortlink capabilities and give good flexibility in choosing relevant names.  The number of 7 character domains it would open is significantly more than the total number of currently registered domains ([recently 299 million according to VeriSign](https://www.verisign.com/en_US/internet-technology-news/verisign-press-releases/articles/index.xhtml?artLink=aHR0cDovL3ZlcmlzaWduLm13bmV3c3Jvb20uY29tL2FydGljbGUvcnNzP2lkPTIwMTIwNTI%3D)).

Abuse problems
---------

ICANN would most likely have concerns about abuse.  Domain squatters would want to pick up as many of them as they can, especially keywords and shorter ones.  Early buyers could get the best ones.  Large companies could afford many.  The short options would quickly disappear for future buyers.  The domains could be used for things other than permashortlinks.

There would be a number of options to limit these problems.  If these domains were treated as special, they could have special requirements.  A basic one could be that each short domain would need to be associated with a single regular domain owned by the buyer.  This might be done by having registrars make them available as an add-on upon purchase of a regular domain, or with some sort of verification of ownership, possibly similar to how Google and the like verify sites for their tools.  Perhaps the domains would have to bear some algorithmic level of similarity to the associated domain, like having a subset of the characters.

Use for permashortlink purposes could be enforced by checking upon renewal and at random times that:

- the associated domain is not parked or for sale
- the root URL over HTTP + HTTPS produces a 3xx redirect to the associated domain or a 5xx status code
- the robots.txt disallows all bots for all paths
- A 'site:' search on Google or other search engine for the short domain returns nothing
- A 'site:' search on Google or other search engine for the associated domain returns some threshold of pages, perhaps 10

Alternatively, redirection could done as service provided by an ICANN registered administrator (registered in similar way as with TLD's).  There would be obvious privacy and data-ownership concerns though.  This wouldn't be very IndieWeb.  At the least, they would either have to retain no private data about users visiting the links or maintain a privacy policy following ICANN rules.  There would also be concerns about the fees involved.

Fin
---------

The use case might not be compelling enough to ICANN to use up all of the limited number of one character TLD's.  Doing only one or two would drastically limit the number of available short domains and their relevancy for all, but could be done initially as a test.

*[TLD]: Top-level domain
*[SLD]: Second-level domain
*[3LD]: Third-level domain
