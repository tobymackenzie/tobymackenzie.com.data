---
categories: [www]
date: 2005-09-27T05:52:39-04:00
date_gmt: 2005-09-27T09:52:39+00:00
guid: 'http://cosmicosmo.ath.cx/log/2005/09/27/symbolic-links-from-intended-dir-only/'
id: 67
modified: 2016-09-01T01:35:12-05:00
modified_gmt: 2016-09-01T06:35:12+00:00
name: symbolic-links-from-intended-dir-only
---

Symbolic Links: from intended dir only
======================================

I had much trouble making symbolic links work for my web site.  After a bit of investigation, I finally realized the problem: symbolic links <ins>with relative paths</ins> must be made from within the directory they well be in, i.e. `ln -s path/to/file linkname`.  This means you must cd into the directory the link will be in before making the link.  Otherwise, the link will not work properly.  This is because the path stored in the link is exactly the one you feed into ln.  For example, if you type `ln -s . /Users/bob/bill.link` <ins>in a different directory than `bob`</ins>, `bill.link` would point to `.`, <ins>AKA `bob`,</ins> which <ins>may not be</ins> the intention.  On websites, such things will lead to a 403 forbidden error no matter what the permissions are.  In the finder, the link will not work.

This helped me out a lot for my calendar, for which I needed to point it to the iCal .ics files.  Since Apple moved the files into individual folders, I couldn't just point my phpicalendar to that folder; I had to make symbolic links to each file.  The alternative to this would require me to manually synchronize two copies of the file, which would be <ins>undesirable</ins>.

[Update 2016/09/01]Clarified some things based on increased knowledge[/Update]
