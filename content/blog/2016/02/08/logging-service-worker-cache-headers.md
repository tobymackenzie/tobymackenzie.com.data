---
categories: [www]
date: 2016-02-08T03:05:27-05:00
date_gmt: 2016-02-08T08:05:27+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=962'
id: 962
modified: 2016-04-04T22:23:19-05:00
modified_gmt: 2016-04-05T03:23:19+00:00
name: logging-service-worker-cache-headers
tags: [cache, logging, serviceworkers]
---

Logging service worker cache headers
====================================

As part of the [service worker API](https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorker_API), a [cache interface](https://developer.mozilla.org/en-US/docs/Web/API/Cache) has been provided to manage cached request-response pairs.  In working on the service worker for my site, I wanted to see what headers the cached requests and responses had, but due to the asynchronous way many of the cache properties are accessed, this was a bit verbose.  I wrote out a script that I could paste in the JS console to look at all stored request-response pairs in a given cache so I could examine them:

``` js
caches.open('cache-name').then(function(_cache){ 
	_cache.keys().then(function(_keys){ 
		_keys.forEach(function(_request){
			var _requestLog = [];
			_requestLog.push(['request', _request.url, _request]); 
			_request.headers.forEach(function(){ 
				_requestLog.push(['request header', arguments]); 
			}); 
			_cache.match(_request).then(function(_response){ 
				_requestLog.push(['reponse', _response]); 
				_response.headers.forEach(function(){ 
					_requestLog.push(['response header', arguments]); 
				}); 
			}).then(function(){
				_requestLog.forEach(function(_item){
					console.log.apply(console, _item);
				});
			});
		});
	}); 
});
```

Replace `cache-name` with whatever key you're using for your cache.  Be warned that this will produce a long log if you've got more than a few items in the cache.  You can also see just the requests you have a cache for with something like:

``` js
caches.open('cache-name').then(function(_cache){ 
	_cache.keys().then(function(_keys){ 
		_keys.forEach(function(_request){
			console.log(['request', _request.url, _request]); 
		});
	}); 
});
```
