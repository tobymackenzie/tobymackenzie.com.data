Six hours later, pascal commented that I am not using the latest JS tag version.  That evening, I replied:

> I used the tag given to me from the Piwik 0.63 interface.  It looked very similar to the one you linked to, which uses "document.write" to insert content (a script tag as it happens) into the document.  "document.write" as well as the "noscript" tag are invalid in XHTML 5 (see the spec [here about document.write](http://dev.w3.org/html5/spec/Overview.html#document.write) and [here about noscript](http://dev.w3.org/html5/spec/Overview.html#the-noscript-element), look for the bits about XML).

A year and a half later, Dariusz Pecuch commented that I should try the latest change from [this ticket](https://github.com/matomo-org/matomo/issues/2517A).  He also pointed out some issues with my XHTML at the time: bad values of `sitemap`, `webmaster`, and `technicalauthor` for the `rel` attribute.  I responded late that night:

> Ah, I'm almost positive those `rel` attribute values validated before.  The one (`sitemap`) is listed now as "proposed" and the other two no longer exist (`webmaster` and `technicalauthor`).
>
> I've modified the linked change to remove the `noscript` element and the `type` attributes on the `script` tags.  Seems to work.  I will email you as well.
