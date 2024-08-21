---
categories: [www]
comment_count: 9
date: 2010-02-26T14:08:35+00:00
date_gmt: 2010-02-26T14:08:35+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=269'
id: 420
modified: 2024-08-01T12:20:06-04:00
modified_gmt: 2024-08-01T16:20:06+00:00
name: tmcom-now-real-xhtml-5
tags: [doctype, html5, tmcom, xhtml, xhtml5, xsl]
---

TMCom: Now Real XHTML 5
=======================

As mentioned in [a previous post](/content/blog/2010/02/16/tmcom-goes-html-5.md), my site has gone to the HTML 5 doctype.  I had come from XHTML 1.0 and wanted to continue with the XML syntax of HTML 5, but my site wouldn't validate with the XML declaration.  I recently remembered that I had been serving my site with the mime-type "text/html", which is allowed in XHTML 1.0 <ins>transitional</ins>.	HTML 5 got stricter, and if you want to use the XML syntax, it must be served as "application/xhtml+xml" or "application/xml".

So I modified the doctype switcher I had made (mentioned in that previous post) to change the mime-type to "application/xhtml+xml" when the configuration doctype was set to "xhtml5".	But <abbr title="Internet Explorer">IE</abbr> evidently cannot handle that mime-type, so I set up my switcher to output as "html5" for IE, but "xhtml5" for other browsers.  I reset the doctype variable (now an attribute of a page object):

``` php
if($this->doctype == 'xhtml5' && strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
	$this->doctype = 'html5';
```

<!--more-->

I send my "Content-type" header only for a doctype of "xhtml5":

``` php
if($this->doctype == 'xhtml5')
	header("Content-type: application/xhtml+xml;charset=utf-8");
```

And, since I've removed the now optional "xmlns" and "xml:lang" attributes for the "head" tag in HTML 5, I make sure to put them back in for XHTML 5:

``` php
if($this->doctype != 'html5' && !defined('pagIsXSLT')): echo 'xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"'; endif;
```

Most other output is the same for HTML 5 and XHTML 5.

I have not actually verified this works in IE, since I don't have access to it.  I did verify that sending a user agent string from IE 7 does change the doctype properly though.

For my XML sitemap, I had been just sending it as XHTML 1.0 still, since XSLT doesn't have an HTML 5 doctype for the "xsl:output" declaration.	However, the comments on [this post](http://www.contentwithstyle.co.uk/content/xslt-and-html-5-problems) pointed to a solution: the [doctype legacy string](http://dev.w3.org/html5/spec/Overview.html#doctype-legacy-string) format.  My "xsl:output" element now looks like this:

``` xml
<xsl:output method="html" indent="yes" doctype-system="about:legacy-compat" />
```

It renders just fine in both iCab (WebKit) and Firefox.  I, of course, haven't tested this in IE.

[Update 2010-8-15] Updated the `xsl:output` declaration to reflect the changes to the recommendation as pointed out by [Andreas Riedmüller](#comment-92).	Had been:

``` xml
<xsl:output method="html" indent="yes" doctype-public="XSLT-compat" />
```
