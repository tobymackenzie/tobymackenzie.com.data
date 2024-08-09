---
categories: [www]
date: 2015-03-16T03:32:05-05:00
date_gmt: 2015-03-16T08:32:05+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=678'
id: 678
modified: 2015-03-16T03:32:05-05:00
modified_gmt: 2015-03-16T08:32:05+00:00
name: kendo-ui
tags: [javacript, kendo, library]
---

Kendo UI
========

We recently acquired licenses for [Kendo UI](http://www.telerik.com/kendo-ui) at [Cogneato](http://cogneato.com).  We have plans to use some of its widgets, most notably the [data grid](http://demos.telerik.com/kendo-ui/grid/index) and [window](http://demos.telerik.com/kendo-ui/window/index), heavily in the admin interface for the new CMS we will be building.  We figured that the time we save from not having to build similar widgets ourselves would be well worth the [hefty license costs](http://www.telerik.com/purchase/kendo-ui).

Troubles
--------

We have made use of the window in a few sites so far, and the grid on [alpleaders.org](https://alpleaders.org).  I have found that for both widgets, it has helped to build a sort of wrapper around them.  The wrapper helps normalize configuration and handles some things that we want to happen for all instances.  Some of this was related to problems we ran into with the widgets or features we wanted that weren't built in.

For instance, the data grid has the ability to be filtered per column client side.  A ['row' mode](http://demos.telerik.com/kendo-ui/grid/filter-row) provides an input with autocomplete for the values in that column.  If you want to use a different mode, however, there is no built in autocomplete feature.  You have to create an [autocomplete widget](http://demos.telerik.com/kendo-ui/autocomplete/index) for each column.  Attaching the same data source as the grid uses results in the same number of items in the autocomplete as there are rows in the grid, meaning if 30 items have a 'State' of 'Ohio', the autocomplete will show 'Ohio' 30 times.  I set up a helper to build columns and automatically create a new data source with a single instance of each value for the items in a given column.  I'm not sure why, since they already built their own logic for the 'row' mode, they couldn't make that an option for other modes.

<!--more-->

Speaking of the autocomplete widget, it throws an error if the data source has anything but strings.  The problem is that it calls `toLowerCase()` on the items in the collection.  This fails for something as simple as a collection of integers.  Simply calling `toString()` on the item before calling `toLowerCase()` would fix this issue.

The [API docs](http://docs.telerik.com/kendo-ui/api/javascript/ui/grid) have a lot of info, but can still be missing important details and it can be hard to find what I'm looking for.  It can be a bit confusing looking for answers on [Stack Overflow](http://stackoverflow.com), [Google](http://google.com), etc., because many examples are in the syntax for their server-side integration.

We haven't yet figured out a good way to get only what we need into our build.  With the styles, they use [Less](http://lesscss.org/) instead of the [Sass](http://sass-lang.com/) that we use.  To integrate, I will probably have to set up our build scripts to build the two separately and then concatenate.  Right now I'm just loading all of the styles, which are over 200kb in four files.  Building them directly into the Sass took way too long, like 30 seconds.

The JavaScript luckily is built in modules that support [require js](http://requirejs.org/), but I have had trouble figuring out what I need to get the data grid widget working.  For pages with the grid, I've been loading the entire kendo library which is almost 2 MB minified.  I was able to get the modules loading fine for the window widget.  The only problem with that is that the 'common' code that it depends on is fairly large for sites that only need a modal dialog.

Another thing that has caused us an issue has been the themes.  Kendo has a number of nice themes that our designer likes.  The problem comes when we want to integrate them with the look and feel of a given site.  The colors are the main thing we want to change.  They provide a [theme builder](http://demos.telerik.com/kendo-ui/themebuilder/) that can modify the colors of any of their provided themes by configuring the colors of all sorts of different bits of interface.  The problem is that we mainly just want to change a given color from the default to another.  With the theme builder, we have to find all instances of that color in the inputs on their widget and change each individually.

We could probably just take their provided stylesheets and find and replace, but it would be nice if their theme builder made it easier, so we could quickly see what our changes will look like, and also be able to rebuild when Telerik updates their stylesheets.  Whenever we get a setup where we can build the Less source files going, then we will at least be able to find and replace with variable names and easily apply our changes when their Less is updated.

Niceties
--------

In spite of these complaints, I think it will be worth it.  The widgets they offer, especially the data ones, are powerful and feature filled.  They are implemented as jQuery plugins, making them easy to attach to DOM elements, and have the object map based interfaces common in the jQuery world.  They have nice themes that provide a common look and feel shared across all widgets.  They are relatively easy to attach to data source that are simple client side collections or RESTful server side sources.  They have built in integration with [Angular](https://angularjs.org/), which we were considering for our new CMS, though unfortunately not with [Backbone](http://backbonejs.org), with which we have a lot more experience and may ultimately choose over Angular.

It would take use quite a lot of work to build the subset of Kendo that we are going to need for our CMS, and we have plenty of work to do as is.  We probably wouldn't have been able to build as nice, well tested, and feature filled a solution.  Hopefully it works out for us.
