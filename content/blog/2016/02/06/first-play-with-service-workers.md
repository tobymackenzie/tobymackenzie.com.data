---
categories: [www]
date: 2016-02-06T04:30:52-05:00
date_gmt: 2016-02-06T09:30:52+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=955'
id: 955
modified: 2016-04-04T22:25:50-05:00
modified_gmt: 2016-04-05T03:25:50+00:00
name: first-play-with-service-workers
tags: [cache, javascript, serviceworkers]
---

First play with service workers
===============================

I started playing with service workers as a client side cache manager a bit tonight.  I'm using [this Smashing Magazine article](https://www.smashingmagazine.com/2016/02/making-a-service-worker/) as a guide.  I've been reading a bit here and there about them, intrigued by their role in [making web sites installable as apps](https://developers.google.com/web/updates/2015/03/increasing-engagement-with-app-install-banners-in-chrome-for-android?hl=en) and their ability to allow sites to function even while offline.  However, my site's current lack of pages and other priorities plus the learning curve and things that have to be done to set them up kept me from playing with them until now.

Workers require HTTPS, unless, luckily, you are serving from `localhost`.  I had to modify my local app install to use that instead of the more site-indicative name it was using.  They also require placement at or above the path level they apply to, or theoretically a `Service-Worker-Allowed` header, though I was unable to get that working.  I'm assuming this is for some security reason.  Because my file is stored in a Symfony bundle and because I am serving multiple sites with the same application, I didn't want an actual file in my web root.  I made a Symfony route and action that passes through the file, like:

<!--more-->

``` php
public function proxyServiceWorkerAction(){
	$response = new Response(file_get_contents(__DIR__ . '/../Resources/scripts/cache-worker.js'));
	$response->headers->set('Content-Type', 'application/javascript');
	return $response;
}
```

I was successfully able to make my site work offline from cached files.  I haven't played with the offline fallback for uncached files yet, but likely will.  The one thing I have to figure out before I make anything live is how to work with `max-age` cache control.  What I'd like is to serve from cache if the cache is still fresh based on `max-age`.  If it isn't, I want to use the network first, and fall back to cache or a placeholder fallback if there is no connection.  This way, I will follow the server's desired cache behavior, as the browser normally would, but will be able to server a stale version if the network is not available.  Ideally I'd be able to inject a message into that telling the user the page is stale and they should reload when they get a connection.

My eventual plans are to do the single-page app, AJAX-like page loading by intercepting requests for HTML pages, requesting JSON versions instead, and passing the data to the pages script to stick the content into the DOM.  Seems like a cool way to progressively enhance that sort of thing.  I also plan to have a configuration page or panel for my site, and I may add configuration for a cache size limit so the users can enforce that.  I would just kick less-important things from the cache if the limit was reached.

Workers seem to be kind of a pain to develop.  In addition to the special setup requirements mentioned above, I had to remove the worker to load any changes, and I had to reload twice just to see any `fetch` events (the nature of how they work I guess, just more effort in development).  The `console.log()` messages from the worker are always preserved, regardless of the setting for other messages, so it's not easy to tell what's happening when.  I ran into various problems, and it's not always easy to find answers via search, especially since some of the words used are generic.
