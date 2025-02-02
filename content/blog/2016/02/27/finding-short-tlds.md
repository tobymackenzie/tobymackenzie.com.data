---
categories: [www]
date: 2016-02-27T01:55:09-05:00
guid: 'https://tobymackenzie.wordpress.com/?p=980'
id: 980
modified: 2016-04-04T21:23:08-05:00
name: finding-short-tlds
pings: ['http://indiewebcamp.com/permashortlinks', 'http://indiewebcamp.com/short-domain#Domains']
tags: [domains, permashortlinks, script, tld]
---

Finding short TLD's
===================

I've been looking for a short domain to potentially use for [permashortlinks](http://indiewebcamp.com/permashortlinks).  For a domain to be usefully short, it must have both a short TLD and short SLD.  Having three characters each would make for seven total characters (including the period) for the domain.  Much more than that and it starts to lose its usefulness.  There are no one character TLD's (though [they'd be great for permashortlinks](https://tobymackenzie.com/blog/2016/02/17/single-character-tlds-permashortlinks/)).  Two character TLD's are reserved for country codes.  I'm a bit reluctant to use a code for a country I don't live in, and the one I do [disallows whois privacy](http://wiki.dreamhost.com/WHOIS#Is_domain_WHOIS_privacy_available_for_every_domain_type.3F).  I'm a bit reluctant to decide that my address, phone number and email address will be "perma"nently available for all to see (assuming I keep the permanent promise of of permashortlinks).  So three characters have been where I've been doing most of my looking.

There are a number of good lists of available TLD's.  Indiewebcamp has a [list of options](http://indiewebcamp.com/short-domain#Domains) with a brief blurb on their fitness and possible problems.  It only has country code domains though.  [United Domains has a list](https://www.uniteddomains.com/ntld/pre-register-new-domains/) with current TLD's and their prices plus soon to be available TLD's.  It has a page for each with some information about the TLD and marketing-speak thoughts on uses.  [Name.com has a list](https://www.name.com/new-gtld) with per-TLD pages as well that are often more brief.  It's hard to parse these lists to find just the short ones though.

I found two plain-text lists of TLD's ([IANA's](http://data.iana.org/TLD/tlds-alpha-by-domain.txt) and [publicsuffix's](https://publicsuffix.org/list/public_suffix_list.dat)), which got me to thinking that I could parse these to find just the ones with three characters.  I wrote a script in PHP and modified it to handle any number of characters.  It looks like:

<!--more-->

``` php
#!/usr/bin/env php
<?php
$srcs = Array(
	'iana'=> 'http://data.iana.org/TLD/tlds-alpha-by-domain.txt'
	,'publicsuffix'=> 'https://publicsuffix.org/list/public_suffix_list.dat'
);
$src = (isset($argv[2]) ? $argv[2] : 'iana');
if(isset($srcs[$src])){
	$src = $srcs[$src];
}
$strLength = (isset($argv[1]) ? (int) $argv[1] : 3);

//--get all
$all = explode("\n", file_get_contents($src));

//--get items of specified length
$specified = Array();
foreach($all as $line){
	if($line && $line{0} !== '/' && strlen($line) === $strLength){
		$specified[] = strtolower($line);
	}
}

//--sort
sort($specified);

//--output
echo "." . implode("\n.", $specified) . "\n";
```

It is run like `n-character-tlds iana 3` and will produce output like:

```
.aaa
.abb
.aco
.ads
.aeg
.afl
…
```

Unfortunately, both seem to have TLD's that can't seem to be currently registered or can't be registered except by certain people.  But it is a great starting point to find possibilities.

*[TLD]: Top-level domain
*[SLD]: Second-level domain
