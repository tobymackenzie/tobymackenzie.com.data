---
categories: [www]
date: 2016-01-22T02:08:52-05:00
guid: 'https://tobymackenzie.wordpress.com/?p=818'
id: 818
modified: 2024-08-01T11:56:12-04:00
name: my-sites-https-letsencrypt
tags: [certificate, dreamhost, https, letsencrypt, ssl]
---

My sites now HTTPS with LetsEncrypt
===================================

My sites are now HTTPS-enabled with [LetsEncrypt](http://letsencrypt.org/).  It was easy to set up with [Dreamhost's panel](http://wiki.dreamhost.com/Let's_Encrypt#How_do_I_add_a_free_SSL_certificate_to_my_domain.3F).  It was just a few clicks and some waiting.  This is the first time my own sites have been available over HTTPS.  I've been wanting to do it for a while, but it was kind of costly until the free LetsEncrypt became available.  This brings my sites in line with the "HTTPS Everywhere" movement.  I've also been wanting to play with the new [installable apps forming standard](https://developers.google.com/web/updates/2014/11/Support-for-installable-web-apps-with-webapp-manifest-in-chrome-38-for-Android) for making web apps installable almost like native apps.

I had written a post before about [how I'm setting my security-related headers](/content/blog/2015/12/21/security-http-headers.md).  I've now added an HTTPS related header in a similar manner: <del>`Upgrade-Insecure-Requests` and</del> HSTS.

<!--more-->

HSTS
------

I also added [an HSTS header](https://scotthelme.co.uk/hsts-the-missing-link-in-tls/) when serving over HTTPS.  When I first read about HSTS, I thought it would have the affect of telling new browsers to switch to HTTPS when served over HTTP, but apparently it just does nothing and is only to tell the browser to keep using the protocol it is already using if serving over HTTPS.  It's just there to prevent downgrade attacks.  I'm using a [Symfony response event listener](http://php-and-symfony.matthiasnoback.nl/2011/10/symfony2-create-a-response-filter-and-set-extra-response-headers/) to ensure they only get sent for the right protocol, which I'm not sure how to do in Apache 2.2 configuration.  I added the following to the listener from the previous post:

``` php
if($request->getScheme() === 'https'){
	//--tell browser to keep using https for all requests to the domain
	if(!$headers->has('Strict-Transport-Security')){
		$headers->set('Strict-Transport-Security', 'max-age=86400');
	}
}
```

I went with a one day max-age just to be safe for now in case something goes wrong with these new certificates.  Since they are free and beta, who knows.

Public-Key-Pins
----------

[HTTP Public Key Pins (HPKP)](https://scotthelme.co.uk/hpkp-http-public-key-pinning/) are considered in the scoring on [Scott Helme's security header checker](https://securityheaders.io).  The idea is that you tell the browser to only use certificates with certain signatures, to prevent them from falling for faked certificates.  I did not implement HPKP, which left me at a score of 'A' instead of 'A+'.  I read that there is a danger of getting locked out of your site if something happens to your certificate, so you want to generate one or more backups.  I don't really know how to do that with Dreamhost or if it would even be possible with shared hosting.  Since LetsEncrypt certificates only last 90 days, it would require even more effort.  The headers also look pretty long.  So I'm leaving them off for now.

[Update 01/24/2016]Previously had info about `Upgrade-Insecure-Requests`, but that is apparently not at all what I thought it was[/Update]
