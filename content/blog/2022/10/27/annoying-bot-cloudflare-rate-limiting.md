---
categories: [www]
date: 2022-10-27T22:14:10-04:00
date_gmt: 2022-10-28T02:14:10+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3869'
id: 3869
modified: 2022-10-27T22:14:10-04:00
modified_gmt: 2022-10-28T02:14:10+00:00
name: annoying-bot-cloudflare-rate-limiting
tags: [bot, cloudflare, feature, problem, server]
---

Annoying bot and Cloudflare free rate limiting
==============================================

Some German bot(s) seemed to take interest in one of Cogneato's sites, [Rockin Houston](https://www.rockinhouston.com/).  The aging site is fairly inefficient with a lot of data, and the bot was causing high load on our DB server.  I have implemented a PHP blocker for certain IPs, but I wanted something more broadly applicable.  I made a rate limiting rule on Cloudflare  that should block this type of behavior and prevent it from even hitting our server once the rule triggers.

<!--more-->

A couple weeks ago I noticed a very high load on one of our DB servers.  The load goes high when a site is sending a newsletter, but one wasn't sending, and this was getting even higher than that would get.  Checking site access logs, I found that Rockin Houston had a single IP requesting a lot of the individual image pages on the site.

I looked at what options were available to fight this.  Some Apache modules can do per-IP rate limiting and things like that, but they would have to be installed and configured, and I'm not familiar with them.  I decided on a quick PHP fix.  I implemented some code in one of the files loaded for all page requests that would randomly send a 500 error for that IP.  Code looks like:

``` php
$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
if(
	in_array($ip, [
		'79.220.105.73',
		//…
	])
	&& rand(1, 3) > 1
){
	$error = '500 Internal Server Error';
	header($_SERVER["SERVER_PROTOCOL"] . " {$error}");
	echo "<h1>{$error}</h1>";
	die();
}
```

The behavior of the IP suggested it was a crawling / scraping bot.  It stopped for a period after getting a 500 and then started again.  It was visiting varying pages in succession.  But it was ignoring the robots.txt and visiting much more rapidly than a friendly bot.

Another day a little later, I saw a high load on the DB server and found another IP from the same area started doing the same thing.  I added the IP to the list and it calmed down again.

After a third IP started doing this, and was hitting the server at an even faster rate, I decided to add a more general solution.  I added a condition to my PHP code to do the same thing for all requests if the load is above a certain point.  I get the load like:

``` php
$load = sys_getloadavg();
```

and then add my condition like:

``` php
if(
	($load[0] > 1 && $load[1] > 0.8 && rand(1, ceil($load[0]) + 1) > 1)
	|| //…
)
```

But it's actually the DB server that has the high load and I don't want to query that on every request.  I decided to look at more advanced options.  The site has Cloudflare in front of it, which has built in DDoS protection.  Apparently, this bots behavior doesn't run afoul of its rules though.  Our server was still responding relatively fine, just with slower responses for DB related request.

Luckily, Cloudflare [recently added a free rate limiting rule](https://blog.cloudflare.com/unmetered-ratelimiting/) for free accounts.  It only has one free rule, but that is all I needed.  It is available in the "Security > WAF" section under the "Rate Limiting Rules" tab.  I added a rule where request URLs start with any of the more heavy page prefixes, separated by "Or".  The free rule is very limited in other options, so I have it block the request with a 429 error for 10 seconds if 30 requests are made for a matching URL from the same IP.  Since the URLs are for pages, it is unlikely that any human could do that.  If multiple people are visiting from the same IP (local network, shared IP, etc), 30 per 10 seconds is still a decent number of page requests and they will only be blocked for 10 seconds.

I monitored for an hour and Cloudflare blocked 633 requests from that one IP.  Once I tweaked the rule to have all the URL paths that were causing problems, I haven't noticed any problems with load on the DB or web server.  Few requests are making it through from that bot.  Cloudflare is doing the brunt of the work for me.

Cloudflare rules are per site, so if another site experiences this behavior, I would have to implement this separately, but that hasn't happened yet.  If the bot learns to distribute across multiple IPs, that could also be a problem.  If that happens, I might need something more advanced.  Maybe Cloudflare's DDoS rules would kick in then though.
