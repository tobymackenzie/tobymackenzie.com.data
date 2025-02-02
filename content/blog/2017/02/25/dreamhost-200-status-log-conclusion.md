---
categories: [www]
date: 2017-02-25T21:33:12-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1385'
id: 1385
modified: 2017-02-25T21:33:12-05:00
name: dreamhost-200-status-log-conclusion
tags: [apache, dreamhost, host, mod_rewrite, problem, status, web]
---

Dreamhost 200 status log conclusion
===================================

I decided to contact Dreamhost about my [Apache logs showing 200 statuse codes for all `mod_rewrite` responses](https://www.tobymackenzie.com/blog/2017/02/05/dreamhost-mod_rewrite-log-status-codes/).  It took seven back-and-forths to get across what was happening, discuss options, and conclude that "DreamHost systems are configured with a default environment meant to meet the most common webapp and customer requirements".<!--more-->  I would figure that the way WordPress, Drupal, Symfony, and other CMS's use `mod_rewrite` to pass requests through the CMS would be common, so I suppose that means that looking at Apache logs for status codes of their responses is not.  The ultimate solution was that I should switch to Dreamhost's [DreamCompute VPS](https://help.dreamhost.com/hc/en-us/articles/214840947-What-is-DreamCompute), where I can configure my server as I please.

Dreamhost did offer one other solution, but it wasn't practical.  The solution came from [a ServerFault answer](http://serverfault.com/a/401343) and involves sticking `[R=404,L]` on the `RewriteRule`.  This does indeed cause Apache to log a 404 for the request, but also causes Apache to send a 404 for the request, regardless of whether or not this was intended.  If one applies this change to the `RewriteRule .` that routes all non-file requests through the CMS, Apache will never send these requests through the CMS and just send a 404 with the `ErrorDocument`.  If one sets up the `ErrorDocument` like the answer suggests, the request will make it's way through the CMS, and can even respond to it with the correct content (although the CMS will have to properly handle differences in `REQUEST_URI` and other `$_SERVER` values), but the response headers and logged status will still be 404.  This is even worse than the 200 status problem, because every response will not only be 404 in the logs, but also to the clients, where it matters far more.

It is worth noting that one could make a `[R=]` for every response that is not 200 and this technique could work, but would be almost infinitely verbose (list every possible 404), difficult to maintain, and require every URL to have a known response (eg no 403 when not logged in or the like).  Alternatively, one could get rid of the `RewriteRule .` and have a rule for every valid page, passing it to the CMS, and letting all other responses be handled by Apache.  The `ErrorDocument` would then ensure the CMS 404 page was shown.  This would also be very verbose for sites with more than a handful of pages, be difficult to maintain, and still wouldn't support changing response codes for different situations.
