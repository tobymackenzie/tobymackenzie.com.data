---
categories: [www]
date: 2015-10-13T02:11:05-04:00
date_gmt: 2015-10-13T06:11:05+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=707'
id: 707
modified: 2017-10-25T21:33:45-05:00
modified_gmt: 2017-10-26T02:33:45+00:00
name: symfony-appcache-x-reverse-proxy-ttl-hack
pings: ['https://tobymackenzie.com/blog/2015/08/24/symfony-appcache-built-in-reverse-http-proxy/']
tags: [cache, development, symfony, web]
---

Symfony AppCache and 'X-Reverse-Proxy-TTL', a hack
==================================================

[Symfony's HttpCache reverse proxy](http://symfony.com/doc/current/book/http_cache.html#symfony-reverse-proxy) is a simple way to get caching of pages with Symfony.  It is simple to set up, easy to work with, and easy to clear.  [I started using it recently](https://tobymackenzie.com/blog/2015/08/24/symfony-appcache-built-in-reverse-http-proxy/) on my own site.

A simple `app/console cache:clear` will clear the entire cache.  Otherwise, following the HTTP-oriented spirit of the framework, invalidation is based entirely on HTTP headers.  In this way, it works the same as proxy / gateway caches.  It only caches responses with `public` `Cache-Control` headers.  It is age based, using the `Cache-Control` `s-maxage` or `maxage` values or `Expires` headers (following that order of precedence).  It then considers the cached items fresh until they are stored for longer than those headers specify they can be stored.  The cached version is served, bypassing the router / controller, as long as the cache is fresh.

This is all nice, but using long max-ages for those headers means that caches outside of my control can cache pages for long periods of time.  `cache:clear` won't help when a page changes.  One possible option would be to have shorter and safer max-ages as `Cache-Control` headers and use something else for `HTTPCache`.

<!--more-->

Friends of Symfony have created an extension of `HTTPCache`, [FOSHttpCache](http://foshttpcache.readthedocs.org/en/stable/) that has a [CustomTtlListener](https://github.com/FriendsOfSymfony/FOSHttpCache/blob/master/src/SymfonyCache/CustomTtlListener.php) for this purpose.  With it, you use an `X-Reverse-Proxy-TTL` header to specify cache max-age.  The only problem with it (besides that it's not yet in a release version) is that it doesn't work with Symfony Standard Edition (SE).  With SE, you use the bundle [FOSHttpCacheBundle](http://foshttpcachebundle.readthedocs.org/en/latest/) to manage `FOSHttpCache`.  It doesn't fire the event that `CustomTtlListener` needs to work properly.

I attempted to hack at the FOS projects to get `CustomTtlListener` working, but to no avail.  I settled on a quick hack that doesn't require either of the FOS projects, but requires modifying a core Symfony class, the Symfony `Response` class and its `getMaxAge()` method.  This obviously is not a long term solution, but it is working for my site for now.  Assuming you are using `bootstrap.php.cache`, find `public function getMaxAge()` within the file and add the following at the beginning of the function block:

``` php
if ($this->headers->has('X-Reverse-Proxy-TTL')) {
	$value = (int) $this->headers->get('X-Reverse-Proxy-TTL');
	// $this->headers->remove('X-Reverse-Proxy-TTL');
	return $value;
}
```

This will have to be redone every time `composer update` is run.  If you aren't using the bootstrap, just find the `Symfony\Component\HttpFoundation\Response` class and make the change there.  Note that ideally the header would be removed before sending to the client, like the commented out line shows, but the value needs to be in the cached response for future requests to know about the max-age.

Then, within your controllers or via configuration of `FOSHttpCacheBundle`, set the `X-Reverse-Proxy-TTL` header on your responses.  My actions look something like:

``` php
$response = $this->render('MyBundle:default:myPage.html.twig', $data);
$response->setPublic();
$response->setMaxAge(60);
$response->setSharedMaxAge(10);
$response->headers->set('X-Reverse-Proxy-TTL', 3600000);
return $response;
```

I have mine set to 3600000 (seconds, a little over a month) for my relatively static pages, relying entirely on `cache:clear` for invalidation for now.  My max-ages that go out to caches I have no control over are very conservative, and thus safe.

As I said, I want to figure out a better solution in the future, possibly using the FOS projects or perhaps just extending the classes involved myself.  After a bit of reflection, I have a few ideas of how to do it.
