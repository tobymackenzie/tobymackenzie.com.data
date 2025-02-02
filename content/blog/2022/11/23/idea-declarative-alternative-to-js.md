---
categories: [ideas, ideas, www]
date: 2022-11-23T23:44:03-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3893'
id: 3893
modified: 2022-11-23T23:44:03-05:00
name: idea-declarative-alternative-to-js
tags: [declarative, js, web]
---

Ideas: Cascading Behavior Sheets, a declarative alternative to JS
=================================================================

I have had the idea for some time that the web ought to have a declarative format to define behavior on elements like it does for styles (CSS).  It would be an alternative to JavaScript (JS) that would be as robust as CSS, simplifying adding and defining common behaviors.  There are a lot of things sites do frequently that can take a fair amount of work for a new person to implement, as well as require a payload sent over the wire.  For people who don't need complications beyond standard, this could be provided by the browser with some configuration in a simple sheet.  I think there should be a Cascading Behavior Sheet (CBS) standard for the web.

Potential advantages:

- robust forward and backward compatibility like CSS
- simpler, easier to learn format than JS
- little to write or think about for common functionality
- little to send over wire for common functionality
- more performant native implementation possible
- declarative
- familiar syntax to CSS devs
- simple to connect behavior broadly to chosen selectors
- cascade, `@media`, `@support`, etc to limit which and when behaviors apply
- automatic handling of attaching and removing behaviors when they apply / don't, including new DOM elements
- maintain separation of concerns that keeping JS and CSS separate provides

<!--more-->

I have had various ideas of how this could be implemented over the years, but finding and reading [Tab Atkin's Cascading Attribute Sheets idea](https://www.xanthir.com/b4K_0) and [Dave Rupert's recent post on that](https://daverupert.com/2022/10/use-case-for-cascading-attribute-sheets/) got me thinking about the behavior sheets again and gave me some ideas.  It pushed me to finally write out my thoughts.

The documents would look and operate very similarly to CSS, with one or more selectors defining what elements a declaration applies to, and one or more properties defining what behavior those elements would get.  It would use the same cascade rules as CSS to determine which behavior wins when there are conflicts.  It would support media queries, etc. to limit when certain declarations apply.  It would allow attaching common built in behavior as well as custom behavior.

Built-in custom behavior properties
---

Commonly implemented behaviors for elements could be implemented in browsers and enabled and configured with CBS properties.  Drag and drop, autocomplete, table sorting, and service workers are some examples that would be good candidates for CBS because they are implemented frequently and the most common implementations are similar enough to be largely handled by an on off switch plus some settings.  The browser would implement this behavior as it sees fit and how it believes will best serve its user, taking into account the properties set by the developer in the CBS.

### Dragondrop

One common UI example could be drag and drop behavior.  In a possible implementation, one could set a `draggable` property to `true` to enable dragging behavior on a set of elements.  Related properties could define characteristics of this dragging, like what happens when the user releases the item, if it can be dragged to certain drop targets, a class to add while dragging, and if it will be constrained to a container.  An example might look like:

``` css
.draggable{
	draggable: true;
	draggable-class: 'draggable-dragging';
	draggable-container: '.drag-container';
	draggable-end: goback;
	draggable-target: '.droppable';
}
```

### Autocomplete

Another commonly implemented UI behavior might be an autocomplete widget from a search input.  That might look like:

``` css
.siteHeader input[type="search"]{
	autocomplete: '/search.json';
	autocomplete-minlength: 3;
}
```

where results would be fetched from the URL '/search.json' once the entered string reaches 3 characters.  An `autocomplete` value like `window.searchResults` might tell it to use a JS global variable for results.

The JSON result would likely have to be in a standard format.  If an array, the value would be used as the display and submit value.  If an object map of key-value pairs, the key would be used for display and the value would be used for submit.  There might be some property to define a different mapping.  If the response is HTML, it would likely be a collection of `<option>` element.

By default, this behavior would only show the drop-down when typing and then fill the input when one is selected.  The input / form would otherwise operate as normal, meaning hitting return a second time would submit the form to the server via a normal request.  This could, however, be overridden with other behaviors elsewhere.

### Service workers

Service workers are complicated to implement.  One could register a service worker script in CBS with a simple declaration on the `:root` element:

``` css
:root{
	service-worker: url('/sw.js') '/' module;
}
```

This would likely take the options for [`ServiceWorker.register()`](https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerContainer/register) second argument in a shorthand style format or perhaps with some longhand properties.

More powerfully, there could be properties to set up the functionality of a service worker declaratively without actually loading a script, for common usage patterns.  There might be a `service-worker-precache` property to define files to be cached when the faux service worker is installed, eg:

``` css
:root{
	service-worker-precache: '/script.js', 'styles.css', 'logo.svg';
}
```

This would be equivalent to adding an event listener on the service worker `install` event and then adding those URLs to the cache immediately.

There would be a property to tell the browser to use a common caching strategy for all other requests, such as [the strategies in the Workbox docs](https://developer.chrome.com/docs/workbox/caching-strategies-overview/), which would translate to single word property values like:

- `cache-first`
- `network-first`
- `stale-while-revalidate`
- `cache-only`
- `network-only`

This might look like:

``` css
:root{
	service-worker-strategy: cache-first;
}
```

which would enable a faux service worker with that strategy.

We will likely want different strategies for different URLs or file types, so there would likely be a comma separated format to specify multiple strategies with a condition and type pair.  We'd likely want to be able to specify one strategy for multiple conditions, so the conditions would come first followed by a single strategy.  A `default` option would define the default strategy for requests not matching other conditions.  It would likely need some special syntax to define what type of condition each part is, eg:

``` css
:root{
	service-worker-strategy:
		url('/_special/*') cache-only,
		audio font image script style video cache-first,
		default stale-while-revalidate
	;
}
```

With this, many users could implement common service worker capabilities without having to figure out the complication of service workers directly, with far less code.

Event listeners
--------

A common activity when writing JS is to attach listeners to elements to do something when certain events happen.  CBS would make this easy by making listeners defined as an `onwhatever` property.  The properties would function much like using `addEventListener()` in JS, and would apply if the declaration applies.  It would be a quick and simple way to add events to many elements, including adding them when elements are added.  It would add and remove them when media queries or other conditions apply, removing like `removeEventListener()` would without having to add listeners for changes or pass the original callback like one would with JS.

There would be some common browser built-in functionality that could be added through these listeners.  It is relative common to do things such as:

- show or hide an element
- add or remove a class
- change an attribute
- change a style
- fetch content from a URL into an element

They would be attached using a function value similar to CSS functions.  Required arguments could be positional, but optional arguments could be named.  Some examples might look like:

``` css
.show{
	onclick: show('.two', transition: 'fade', duration: 500ms);
}
.class-this{
	onclick: addClass('foo');
}
.attr-this{
	onclick: attr('data-foo', 'bar');
}
.attr-many{
	onclick: attr({'data-foo': 'bar', 'hidden': false, 'type': 'search'});
}
.style{
	onclick: css({'color': red, 'opacity': 0.8});
}
.fetch{
	onclick: fetch('/moreinfo.html', this, 'replace');
}
```

An optional argument might allow applying behavior to another element.  A special element selector `this` would allow specifying elements relative to the element the event is firing on.  This might look like:

``` css
.class-on-other{
	onclick: addClass('foo', 'this .show');
}
.attr-on-other{
	onclick: attr('data-foo', 'bar', 'this + .theInput');
}
.style{
	onclick: css({'color': red, 'opacity': 0.8}, '.theBox');
}
.fetch{
	onclick: fetch('/moreinfo.html', '.moreinfo');
}
```

We might want to be able to comma separate multiple functions for an event, like:

``` css
@media screen and (min-width: 600px){
	.fetch{
		onload: fetch(attr('href'), '.moreinfo'), remove();
	}
}
```

On larger screens, that would fetch the `href` content into an element when the `.fetch` link loads and then remove that link.

Or perhaps a lightweight lazy-load for when things become viewable, like:

``` css
.more{
	onintersect: fetch(attr('href'), this, 'replace');
}
```

Some special `on` events might be needed in CBS that aren't in JS to allow for doing some things declaratively, like the above `onintersect`.

There would also be a way to attach functions that have been defined in JS.  That could be done by prefixing with a `window.`, like:

``` css
button{
	onclick: window.myClick('something');
}
```

The function would likely receive a standard JS event on the element, with `.data` property set to whatever you pass as an argument in the CBS.

There may be a way to define functions within the sheet itself, perhaps something like:

```
@function foo(width: 25, color: red){
	/* definition */
}
```

It might be able to have standard JS in there, or perhaps a more limited subset, or maybe even a very simplistic format perhaps using only built in CBS functions, CSS-style variables, and simple control structures.  Standard JS would likely be the most powerful, but may be hard to implement and have more risk of breaking things.  Regardless of which is used, it must be able to fail robustly.  If the browser doesn't understand what is inside of the definition, it will ignore it completely.  The curly braces at the least must maintain parity so that it knows when the function definition ends to be able to skip it if parsing otherwise fails, ie look for `}` and decrement the count until 0.

These could then be attached in the same way as built-in functions, like:

``` css
.button{
	onclick: foo(color: blue);
}
```

or with some special syntax to distinguish them from built-ins.

For robustness, specifying an undefined function will essentially be a no-op.  Since files may be loaded or defined in different orders, this will likely be the equivalent of:

``` js
el.addEventListener('click', function(event){
	if(typeof window.myClick === 'function'){
		return window.myClick.call(el, event);
	}
});
```

where it will do nothing if the function isn't defined but will do something if the function is defined later.

For all of the `on*` properties, we would likely want them to add the listener every time they are defined in the sheet rather than overriding other listeners.  As such, they would likely have to be tracked separately and specially handled without that part of the cascade.  Or perhaps this behavior would be turned on by prefixing a property with a `+`, eg:

``` css
.button{
	+onclick: foo(color: blue);
}
```

but I think that would be too confusing, especially when there are some defined with and without the `+`.

Opts for built-in behavior or defaults
---

There are many behaviors that a browser has built in already for elements.  Some of them might be able to have definable properties that could be modified in a CBS file.  Perhaps there would be options for how `<select>` drop-downs open 

One might be able to generally define default common behavioral options, such as `duration` and `delay`.  That might work like properties on the elements, like:

``` css
.foo{
	delay: 200ms;
	duration: 1s;
}
```

or perhaps standard defined CSS-style variables, like:

``` css
.foo{
	--delay: 200ms;
	--duration: 1s;
}
```

Implementation
------

I'm hoping it wouldn't be too hard to implement this by tying into the same system that attaches styles from CSS, or separating out part of that code base to be usable by both and then building the new system off of that.  The `on*` properties would be a little different, being additive, which would require some different logic.

Surely the selector and general property part can be made similarly performant to CSS.  I'd be surprised if the behavior part couldn't be made as performant or better than the same functionality implemented in general purpose JS, being able to have optimizations and native code for some things that couldn't otherwise.

The CBS would likely be loaded into HTML with the `<script>` tag with a special `type` attribute, perhaps like `<script type="text/cbs"></script>`.  It would have similar loading behavior as loading JS scripts, eg blocking by default, with the ability to make non-blocking.  It would support many of the other attributes from `<script>` as well.  `<script>` might need a `nocbs` property added to function similarly to `nomodule`, to allow fallback for previous browsers.

Parts of CBS might be able to run in no-js contexts, since the browser would be able to know which parts are implemented by the browser and which can have undesired tracking and other side-effects in those contexts.

We could toss CBS-like functionality into CSS directly, but I think that would break the separation of concerns we've tried to maintain by having HTML, CSS, and JS separate.  We're already getting behavior and semantic effects creeping into CSS, and seeing problems because of it.

Fin
----

This is just my idea.  As far as I know, no-one else is discussing anything like this or trying to make it a reality.  It is on no standards track and thus as far as can be from implementation.  Even if it were to be in the works, it would not support current browsers, so a fallback would be needed for a long time.  But with all the advantages mentioned, I would love to see this implemented.  It has to start sometime to become a reality.  It would make things so much simpler and lighter for many sites, possibly eliminating the need for JS completely for a lot of them.  More complicated sites would still have JS for when the built in behavior is insufficient.  Of course, the bigger players in the industry have more complicated sites, and thus there would be less push to make something like this happen.  Here's hoping it does.
