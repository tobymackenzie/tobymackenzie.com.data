---
categories: [www]
date: 2015-10-06T02:18:28-04:00
guid: 'https://tobymackenzie.wordpress.com/?p=703'
id: 703
modified: 2024-08-01T12:29:29-04:00
name: 404-with-autofilling-form
tags: ['404', error, frontend, symfony, web]
---

404 with autofilling form
=========================

Inspired by a tweet by [@simevidas](https://twitter.com/simevidas) about [a 404 page search form](https://twitter.com/simevidas/status/644711449730940929), I decided to finally [replace Symfony's default 404 page](http://symfony.com/doc/current/cookbook/controller/error_pages.html) on my site.  The tweet was about an example site's 404 pages that take pieces from the URL path to populate a search field.  Upon seeing it, I immediately thought how easy it would be to implement a simple version of that.

I had been thinking of customizing my 404 for a while, but stopped trying because Twig doesn't seem to know about bundle paths in the error pages, preventing me from extending the "base" template in my bundle.  I still didn't find a solution for this, so the 404 page has an unstyled look, but I wanted to capture the search form idea while it was on my mind.

Looking into 404 best practices, I found three things that I wanted on mine: branding, guidance / next steps for the user, and small size / low power.

<!--more-->

- **Branding**: The branding tells the user where they are.
- **Guidance**: The guidance is so they aren't stuck at a dead end.  A 404 page is jarring, telling the user their efforts thus far will not get them the content they want.  We want to make it as easy as possible for them to continue on towards finding what they are looking for.  This can be advanced, like suggestions calculated from the URL, or simple, like a search form, links to entry pages, or even just the site's regular navigation.
- **Low resources**: The small size and low power is important because the page will be loaded for 404s that aren't seen by users, such as those loaded by bots or for missing resources.  Ideally, you wouldn't waste too much bandwidth and processing resources for those requests.  Here, external resources (images, CSS, JavaScript) can help limit the initial payload, which is all that will be received by non-users.

Here is my current 404 markup:

``` html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Not Found</title>
        <meta content="initial-scale=1,width=device-width" name="viewport" />
        <style><!--
        body{ margin: auto; max-width: 30em; padding: 1em; } #q{ width: 100%; }
        --></style>
    </head>
    <body>
        <header>Toby Mackenzie</header>
        <main>
            <h1>404 Not Found</h1>
            <p>The URL you requested was not found on this server.  You can try finding what you were looking for on the <a href="/">home page</a> or using the search form below.</p>
            <form action="https://duckduckgo.com/">
                <label for="q">Search via DuckDuckGo:</label>
                <input id="q" autofocus name="q" rel="search" title="Search" />
                <input type="submit" value="Go" />
            </form>
        </main>
        <s cript><!--
        document.getElementById('q').value = 'site:' + location.host + ' ' + (location.pathname.replace(/.[w]+$/, '') + location.search).replace(/[?/\-_+.%=&[]]+/g, ' ').replace(/[<>]/g, '');
        --></script>
    </body>
</html>
```

[Note the script tag has been modified because WordPress was eating it.]
[Note that I am using a third party search engine for now since my site doesn't have search capabilities.]

With Symfony, that can just be placed at `app/Resources/TwigBundle/views/Exception/error404.html.twig`.  I tested in the 'prod' environment because of the debug page in 'dev' and the extra junk that would be added to the form input using the `/_error/404` route under `app_dev.php`.

The result I came up with requires no processing on the server because it uses JavaScript to populate the form.  The server basically just has a static file to serve.  At some point I intend to move the JavaScript and CSS to external files to reduce the size.  The page is very generic because of the aforementioned Twig path problem and because I am serving multiple sites with the same Symfony application.  I intend to find a way to get the appropriate site "base" / "skeleton" wrapping the 404 in the future.  It is currently 992 bytes.  I'm hoping to be able to not let it get much bigger than that.  I also want to do something more playful with it, as many sites do ([404 examples](http://www.creativebloq.com/web-design/best-404-pages-812505)).  [Nouveller's 404](http://nouveller.com/404/) is particularly neat.
