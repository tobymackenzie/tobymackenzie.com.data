---
categories: [www]
comment_count: 5
date: 2010-07-12T08:24:43+00:00
date_gmt: 2010-07-12T08:24:43+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=356'
id: 434
modified: 2024-06-17T15:00:44-04:00
modified_gmt: 2024-06-17T19:00:44+00:00
name: piwik-and-xhtml-5-document-write-and-noscript
tags: [javascript, piwik, statistics, xhtml5]
---

Piwik and XHTML 5: Document.write and Noscript
==============================================

I've been using [Piwik](http://piwik.org) recently for my site analytic purposes.  I added it to my ["professional" site](http://tobymackenzie.com), which is served as XHTML 5 for anything but IE.  On that site, no visits were registering, though [awstats](http://awstats.sourceforge.net/) showed that there were visitors.  As it happens, this is because the javascript "document.write" is not allowed in XHTML.  I believe older versions of XHTML still allowed it to be run, but it certainly wasn't being run on my XHTML 5 site.  Firefox showed an error in the console.  This is mentioned on the WHATWG's [page about the differences between HTML5 and XHTML5](http://wiki.whatwg.org/wiki/HTML_vs._XHTML).

The Piwik community doesn't seem to have much mention of this, other than [one mailing list thread](http://lists.piwik.org/pipermail/piwik-hackers/2008-August/000337.html).  I modified the script to something similar to the one in that thread, like this:<!--more-->

``` html
<!-- Piwik -->
<div id="piwikbox"></div>
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://example.com/piwik/" : "http://example.com/piwik/");
var tag = document.createElement("script");
tag.setAttribute("src", pkBaseURL + "piwik.js");
tag.setAttribute("type", 'text/javascript');
document.getElementById("piwikbox").insertBefore(tag,
document.getElementById("piwik-script"));

</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script>
```

This inserts an element with the appropriate content into the DOM instead of writing it directly to the page, which would be considered the preferred way these days anyway.

You might notice that I've also removed the "noscript" element normally used by Piwik to add an image that will make a call to the stats server when javascript is disabled.  This is because the "noscript" element is not allowed in XHTML 5.  It was allowed in XHTML 1.  But XML does not allow conditional parsing:  All elements are parsed and added to the DOM.  So browsers simply set the content to "display: none;" and everything looked fine, but the elements were still parsed, and if you were to put a script into the "noscript" tags, it would be run in XHTML, though not in HTML.  Form inputs would be submitted in XML, though not in HTML (I've been told anyway).  I have to wonder why it really matters that XML must parse these elements:  The elements are just elements until the browser takes them and renders them in a certain way.  To an XML client that doesn't have special rendering for "input" elements, they are just empty elements with some attributes.  The browser could be directed to render and handle the "noscript" content differently even though it is still parsed and added to the DOM, beyond just "display: none;".  But of course old browsers will still handle them as they do now.  This would work fine in Piwik's case, but then it really doesn't matter currently for Piwik anyway, as that functionality has not actually been implemented yet anyway.  So it's just removed.

All this trouble makes me wonder why I should bother with XHTML 5 anyway.  Browsers simply give an often useless warning when there's an error in the markup, and don't display the page at all.  Firefox at least doesn't even let you view the source, making it very difficult to figure out where the issues is.  <abbr title="Internet Explorer">IE</abbr> cannot render it properly and [must be sent a different MIME and doctype](/content/blog/2010/02/26/tmcom-now-real-xhtml-5.md).  HTML 5 can be basically the same but without some of the constraints.  However, I like the XML syntax and would rather serve my document as the type of content it is marked up as.  I like to know that there are well-formedness errors, even if I'd prefer them to be handled differently.  I like being able to easily use my same layout in an XSLT, such as for my [xml sitemap](https://tobymackenzie.com/blog/2010/01/11/wordpress-xml-sitemap-with-xslt-wordpress-theme/).  For clients, I will use HTML, since I don't want their site to stop working because of a small markup error.  But for my own site, I will continue to use XTML.
