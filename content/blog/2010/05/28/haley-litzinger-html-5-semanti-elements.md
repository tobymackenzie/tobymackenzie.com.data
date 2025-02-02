---
categories: [www]
date: 2010-05-28T23:48:28+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=318'
id: 428
modified: 2010-05-28T23:48:28+00:00
name: haley-litzinger-html-5-semanti-elements
tags: [elements, html5, project]
---

Haley Litzinger: HTML 5 Semantic Elements
=========================================

It looks like I will not be doing at least the design for [Haley's site](http://haleylitzinger.com).  She just got Adobe Suite CS3 and wants to make use of it.  I will probably be helping her out at least some with it though, and we may even use her design on the Wordpress site I built for her.  We still haven't met to discuss the details of this yet though.

Before I found out about her plans to build or at least design the site, I built a simple but functioning test site.  In doing so, I made my first venture into using the new HTML 5 semantic elements.  I used the [Dive Into HTML 5](http://diveintohtml5.org/semantics.html) site along with a few others to learn how to use the elements.  The new elements I made use of are "section", "header", "footer", "nav", "hgroup", and "time".  There's also the "article", "aside", "mark", "figure", "meter", etc.  tags, but I did not use them on this site.  The Dive Into HTML 5 site [describes the basic ones fairly well](http://diveintohtml5.org/semantics.html#new-elements) in brief.

<!--more-->
Semantics
---------

The elements are meant to give more semantic meaning to content to help screen readers, search bots, and even potentially any browser handle content more aptly.  Some of these elements have complements in the role attribute, which I'd already been using on sites.  I use both to remain backwards compatible and because there're plenty that don't overlap.

The "nav" element (like role="navigation") denotes navigation on a page.  This could allow screen readers to quickly access the navigation when needed, or skip over it when not.  The "aside" element (like role="complementary") denotes secondary, less important content, and could be used for a sidebar.  The "time" and "meter" elements are similar to spans, but have attributes that denote more machine friendly versions or characteristics of the content.

I used a "nav" element for my simple four item horizontal navigation, which was also placed inside a "ul", as usual.  I put my usual screen-reader-only heading to label this section for screen readers as well as my skip navigation link so that current screen readers and other users can still skip the navigation.  I used the time element for page update times, using Wordpresses "the_time" function (very similar to PHP's "date" function fed the articles publication date) to fill the "datetime" attribute using the format "Y-m-d".  I couldn't be bothered to figure out the format string for the full "datetime".

Hierarchy
---------

Some of the new elements could be considered sectioning elements.  They change the way document hierarchies are interpreted.  Instead of the ordered hierarchy of h1 down, with one h1 per page, sectioning elements can have their own sub-hierarchy, allowing "article"s and "section"s to start with h1s, with no need to pay attention to how deep into the hierarchy they will be on pages they are placed into.  "header" (perhaps like role="banner") and "footer" elements denote headers and footers of a given section (not the element, but a generic section of a page).  The "hgroup" simply allows subheadings to be added without affecting the hierarchy.  Other than the intervention of sectioning elements, the outlining of a page is done the same as with previous versions of HTML.

I used a "section" element around each pages content, as well as separating two parts of my footer.  My main gallery page had two sections, one for each gallery.  The "article" element went around items in my "index.php", my search results page, and my single post page, though these were not actually used on the site.  I had a "header" and a "footer" for the entire page, plus a "header" for each "section" that surrounded the main page content.  This per section header was used to place not only an "h1" in the section, but also page meta data, such as "last updated" for pages and things like "medium" and "size" for the gallery of her works, and have it styled as one box, which I'd normally do by wrapping them in a classed div instead.  For my page footer, I again used the screen-reader-only heading to label the section like usual.  I set up "footer"s for each single article page, but again those weren't used.  The "hgroup" was used once to add a tagline to my main page "header".

For the most part, I found it relatively easy to deal with this new way of creating hierarchy, and it seems like it may be fairly nice.  Using [this HTML 5 document outliner](http://gsnedders.html5.org/outliner/), I found the outline to work mostly as expected, except the "footer" element, which was for some reason interpreted as a completely new section.  There're some oddities about the "footer" element, such as the inability to use "nav" elements within it.  Perhaps headers aren't supposed to go there either.  Hopefully this will be worked out before the 2022 final release of the spec.  The hierarchies aren't really seen by sited users directly, but screen readers use them to navigate around more easily, and search engines use them to determine importance of content.

Backwards Compatibility
-----------------------

The main reason I had no qualms with using these new elements is that they were fairly well designed to be handled by browsers that don't know what they mean, ie older browsers.  Browsers interpret unknown elements as generic elements with text content.  They seem to be treated the same as "span"s, thus inline.  Rendering behavior was strange with sectioning elements inline.  They should be block level elements, so I used this CSS rule block:

```
header, section, footer, aside, nav, article, figure{
	display: block;
}
```

Also, though the "header" and "footer" elements of a page would replace elements with "id"s of the same name, I had to keep the "id"s to target the elements properly when sectioning elements had their headers and footers.

The only other significant issue I'm aware of is that current versions of IE don't allow styles to be applied to unknown elements.  The content will be rendered, but it could end up looking very bad, since some styles will be applied while others won't.  There is a [simple javascript workaround](http://code.google.com/p/html5shiv/) weighing in at 1.5k and allowing IE to style all new HTML 5 elements.  But this does nothing if javascript is turned off.  Not many people have it turned off, but IE is still the market leader, and some of its users will have it turned off.  Because of this, I won't use these elements at work or for a site that I expect will be getting a lot of traffic.  But for a small site like Haley's, and perhaps soon my own, I'm fine with this.  I could in theory browser sniff and output "div"s and "spans"s for IE, HTML 5 elements for other browsers, but that would be a pain to maintain.

So, even if my work on Haley's site doesn't get used at all, I have learned something.
