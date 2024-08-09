---
categories: [www]
date: 2020-05-06T21:01:56-04:00
date_gmt: 2020-05-07T01:01:56+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2851'
id: 2851
modified: 2020-05-06T21:01:56-04:00
modified_gmt: 2020-05-07T01:01:56+00:00
name: dns-added-caa-records
tags: [certificate, dns, ssl]
---

DNS: added CAA records
======================

I've set up a [CAA DNS record](https://en.wikipedia.org/wiki/DNS_Certification_Authority_Authorization) for my domains that allow it.<!--more-->  Dreamhost and Fastmail don't have that record type, but Porkbun does.  The CAA record basically tells TLS/SSL certificate issuers which issuers are allowed to issue a cert for that domain, theoretically limiting bad actors from getting certs issued from some other authority who they've otherwise convinced they are allowed to issue the cert from.  It isn't verified by browsers though.

Since I use LetsEncrypt, my record value looks like `128 issue "letsencrypt.org"`.  The `128` tells authorities to disallow registration if there is an error in the record.  The `issue` tells authorities they can issue any cert type, as opposed to `issuewild`, which only allows wildcards.  The `"letsencrypt.org"` specifies which authority to allow.  The quotes are important.  I left them off at first and it seemingly broke DNS (all record types) for that domain.  If you want more authorities, you would create multiple records.

I also created an `iodef` record, which tells authorities how to contact you if an invalid certificate request is made.  They have a similar format, looking like `0 iodef "mailto:admin@example.com"`.  LetsEncrypt doesn't support this from what I hear, but some authorities do, and could give warning to an attempted use of your domain for nefarious purposes.

You can verify that your records look right by running `host -t caa example.com` or `dig -t caa example.com`.  Unless you're on Mac OS X.11 (El Capitan) or earlier, which doesn't seem to support that record type with the native commands.

My related certs don't expire for a while, so I haven't gotten to test that this works yet.  I'm not sure what would happen if it fails.  LetsEncrypt sends notices to my account email address, so I suspect they'd send something there.  But I don't figure there'll be problems with this simple syntax.
