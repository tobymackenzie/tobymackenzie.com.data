---
categories: [www]
date: 2017-12-14T06:25:31-05:00
date_gmt: 2017-12-14T11:25:31+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1708'
id: 1708
modified: 2017-12-14T06:50:22-05:00
modified_gmt: 2017-12-14T11:50:22+00:00
name: symfony-router-match-different-host
tags: [routing, solution, symfony]
---

Symfony router: check for match on different host
=================================================

I found myself wanting to check if a given URL path exists on another host of a multi-host Symfony application from within a controller action.  The router service, which is the instance of Symfony's [routing component](http://symfony.com/doc/current/components/routing.html) used to route requests to actions, has a `match()` method, but it only accepts the path part of the URL.  It also has a `matchRequest()` method, but that seems to ignore the `HTTP_HOST` and `SERVER_NAME` of the passed `Request` object.

<!--more-->

I discovered that the router, during a request, has a `RequestContext` object, from which it gets the host value for matching routes.  The router's context is gettable and the context's host is settable, so it's just a matter of changing the host, then doing the `match()`:

``` php
//…
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
class Controller{
	public action(){
		$router = $this->get('router');
		$routerContext = $router->getContext();
		$requestHost = $routerContext->getHost();
		try{
			$routerContext->setHost('other-domain.com');
			$router->match('/foo');
			$haveMatch = true;
		}catch(ResourceNotFoundException $e){
			$haveMatch = false;
		}
		$routerContext->setHost($requestHost);
		//…
	}
}
```

The `$haveMatch` boolean can then be used for whatever logic I want.  I am setting the host back to what it was just in case, though it didn't seem to cause any problems when I didn't.
