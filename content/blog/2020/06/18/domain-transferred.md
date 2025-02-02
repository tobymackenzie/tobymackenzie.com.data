---
categories: [www]
date: 2020-06-18T02:09:05-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=2904'
id: 2904
modified: 2020-06-18T02:09:05-04:00
name: domain-transferred
tags: [dns, domains, dreamhost, porkbun, registrar, registration, transfer]
---

Domain transferred
==================

I transferred this site's domain (tobymackenzie.com) from [Dreamhost](https://www.dreamhost.com/) to [Porkbun](https://porkbun.com/).<!--more-->  This was the first time I've done a domain transfer.  It went smoothly, taking a couple hours.  I was of course antsy during that time and kept checking its progress, worried that it would fail or take days.

I started on the Dreamhost side, going to 'Domains > Registrations' and clicking 'Yes' in the 'Locked?' column to switch it to 'No'.  I then went to 'Domains > Reg. Transfers' and clicked 'Or transfer away from Dreamhost'.  There was a button to show my auth code: I clicked it and copied the code.  I then went to [Porksbun's transfer page](https://porkbun.com/transfer) and entered my domain and auth code.  I got an email from Dreamhost, which directed me back to the transfer panel, where I clicked a button to authorize the transfer.  While I was waiting for them to do the transfer, I manually copied my DNS records to Porkbun and switched my nameservers to them.  They had a little gear on the transfer page for entering the DNS.  That was it from me: the rest was automatic.

Dreamhost was my first registrar and host.  I like them and still have my hosting and one domain with them.  They have in the past suggested support of free speech and privacy and even went [above and beyond to support](https://www.dreamhost.com/blog/we-fight-for-the-users/) one political client.  However, some things I dislike about them as a registrar:

- no partial whois privacy, only full privacy or none
- no [MX DNS records](https://en.wikipedia.org/wiki/MX_record) for subdomains (unless you have managed hosting for those subdomains or go through support tickets)
- no [CAA DNS records](https://en.wikipedia.org/wiki/DNS_Certification_Authority_Authorization)
- weirdness with NS records when trying to use both their DNS and a third party
- expensive .me domains, others getting more expensive
- limited number of years that can be registered at a time
- slowness to add new technical features

Porkbun seems to fix or be better on most or all of these points, and be more registrar focused in general.
