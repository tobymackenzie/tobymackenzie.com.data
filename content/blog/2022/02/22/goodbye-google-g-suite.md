---
categories: [www]
date: 2022-02-22T11:19:48-05:00
date_gmt: 2022-02-22T16:19:48+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3645'
id: 3645
modified: 2022-02-22T11:19:48-05:00
modified_gmt: 2022-02-22T16:19:48+00:00
name: goodbye-google-g-suite
tags: [email, fastmail, google, service]
---

Goodbye, Google G Suite
=======================

When I registered my domain "tobymackenzie.com" in 2009, [Dreamhost](https://www.dreamhost.com/r.cgi?568062) offered the then free Google Apps to provide email for the domain.  Already having a normal Gmail account and preferring the labels system over folders, I went with it.  For 12 some years, it provided my email service for that domain.  It changed names and eventually became "G Suite legacy free edition" after they started charging all new accounts.  But this summer they are finally killing off the free version, requiring me to pay up or leave.  I chose to leave, migrating over to my existing [Fastmail](https://ref.fm/u65602) account being used for other domains.

<!--more-->

The migration was pretty straightforward following [their documentation](https://www.fastmail.help/hc/en-us/articles/360058752414-Migrate-to-Fastmail-from-Gmail).  I was worried about the email import because in the past Fastmail has said that Gmail emails in multiple labels will get imported multiple times.  I've switched to Fastmail's label system though.  I checked with support if there would still be this problem and they said sometimes.  But my import seems to have gone smoothly and emails properly were imported once with multiple labels.

Now, it will be easier to manage one less email account.  Fewer accounts to configure, fewer places to check my emails, fewer services to keep track of.  It will also make my "tobymackenzie.com" DNS simpler, as I can now just CNAME my subdomains to the main domain.  I've made the change and everything seems to be working.  I've liked Fastmail and I think I will be happy with this.
