---
categories: [www]
comment_count: 1
date: 2015-08-24T01:46:36-05:00
guid: 'https://tobymackenzie.wordpress.com/?p=692'
id: 692
modified: 2015-08-24T01:46:36-05:00
name: symfony-appcache-built-in-reverse-http-proxy
tags: [cache, performance, proxy, symfony, web]
---

Symfony AppCache: built in reverse HTTP proxy
=============================================

I finally set up [my site](https://www.tobymackenzie.com) to work with [Symfony's built in HTTP reverse proxy](http://symfony.com/doc/current/book/http_cache.html#symfony-reverse-proxy).  Took a little bit of time since I had to fix a couple minor bugs in how things are set up with my [symfony-initial](https://github.com/tobymackenzie/Symfony-Initial) and [Symfony Standard Edition Bundle](https://github.com/tobymackenzie/symfony-StandardEditionBundle) and then made a mistake in testing whether or not it was working that made me think it wasn't when it was.

One useful way to test if it's working is to set the 'debug' option of `AppCache` to `true` (turn this back off for production).  This will set an `X-Symfony-Cache` header that will provide info on the cache behaviour.  You can see these headers on the shell by running `curl -I your.url`.  If it says 'fresh' as part of the header value, that means it was served from the cache.  If it shows the header at all, that means AppCache is being used.

For the cache to work, the response must be public and have something set to control how the cache becomes stale.  See [Symfony's docs on caching](http://symfony.com/doc/current/book/http_cache.html#introduction-to-http-caching) for more details.  Since my content rarely changes at the moment, I went with the `Cache-Control` header with `max-age`.  A cool thing about using Symfony's reverse proxy is that the entire cache will be cleared when clearing Symfony's cache like normal.  This means that if you make a mistake and must remove it from the cache, there is a quick and easy way.
