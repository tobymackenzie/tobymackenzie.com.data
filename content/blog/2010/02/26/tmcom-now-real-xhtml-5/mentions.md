Half a year later, Andreas Riedmüller pointed to a new syntax in the spec.  I responded:

> Hmm, that's weird, they must have changed that section.  There are still blog posts to be found discussing the XSLT-Compat legacy doctype and [a WHATWG thread](http://lists.whatwg.org/htdig.cgi/whatwg-whatwg.org/2008-December/017948.html) quoting similarly to the section in the current draft but with XSLT-Compat instead.
>
> I will look into it a bit more and change it if this is indeed the new way.

He provided a link to a mailing list, now gone, about the change.  I responded:

> Ah that does explain the change then.  It works fine either way for XSLT, but I will change it to reflect the changed recommendation.

and a bit later:

> I changed this on my site.  The W3C validator gives the warning "No DOCTYPE found! Checking XML syntax only." It does for both doctypes, so it had to have been doing this before.  Setting the doctype to HTML5 in the validator gives lots of errors, and there isn't really any other better manual setting to choose.   Not sure what this says in regards to validation, but it renders fine (now verified in IE, my layout gets messed up in 6 and 7 but still renders).

Andreas then recommended [totalvalidator.com](https://www.totalvalidator.com).  I responded:

> Hmm, doesn't seem to help either.  I am validating the file served as XML with reference to an XSLT converting it to XHTML5.  The file is an XML sitemap.  When served as mime-type "text/html" (proper for an XML sitemap) totalvalidator simply says it is "not an (x)html page".  Served as "application/xhtml+xml" it points to the many unrecognized elements.  I imagine there's really not a validator that will directly validate the XHTML result of an XSLT transform anyway, and seemingly the only way to really validate XML is to see if browsers or other parsers parse it without throwing an error.  I can't really directly grab the output of the transformation as applied by a browser to validate that by copy and paste.
>
> That totalvalidator seems somewhat nice though, with accessibility checking built in.
