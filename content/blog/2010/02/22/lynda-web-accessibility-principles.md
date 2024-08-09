---
categories: [www]
date: 2010-02-22T13:31:24+00:00
date_gmt: 2010-02-22T13:31:24+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=261'
id: 418
modified: 2010-02-22T13:31:24+00:00
modified_gmt: 2010-02-22T13:31:24+00:00
name: lynda-web-accessibility-principles
tags: [accessibility, certificate, lynda]
---

Lynda: Web Accessibility Principles
===================================

I've completed another Lynda course, [Web Accessibility Principles](http://www.lynda.com/home/CertificateOfCompletion/ViewCourseCertificate.aspx?lpk57=0711D5A942AB4B52AC3572202139332F&utm_source=LDC&utm_medium=partner&utm_content=link&utm_campaign=cert_of_comp) by Zoe Gillenwater.  This course was well put together, had a lot of good information, and should be very usable, though it perhaps had a lot of repetition (to give a feeling of what screen-readers must go through?) and pacing issues.  It also, perhaps due to its age (from late 2007), missed some techniques, such as pure CSS drop-down menus.

As I watched it, in addition to taking copious notes, I stopped from time to time to implement some of the practices on my own site(s).  For instance, I added a class for content that will benefit screen-readers but not be that useful to or possibly bother regular sighted visitors:

```
.screenreaderOnly{ position: absolute; margin-left: -9000px; }
```

I had been using "display:none;", but evidently screen-readers hide that content as well.  I added some screenreaderOnly headers in my navigation and footer since screen-readers provide easy navigation by header.  I also created a skipToNav link (my nav is below my content) using the hiding technique above, but also used ":focus" and ":active" (for IE6) to allow keyboard users to access it:

```
<div id="skipToNav"><a href="#navigation">Jump to navigation</a></div>
```

and:

```
#skipToNav{ z-index: 3; position: absolute; top: -20px; left: 60px; }
#skipToNav a{ position: absolute; left: -9000px; }
#skipToNav a:focus, #skipToNav a:active{ position: relative; left: 0; }
```

I also added a few Firefox Extensions for accessibility purposes.  [Fangs](https://addons.mozilla.org/en-US/firefox/addon/402) writes out pages as text similarly to how they'd be read be a screen-reader.  I had been using [Lynx](http://en.wikipedia.org/wiki/Lynx_%28web_browser%29) to see my pages rendered text-only, but hadn't realized how much other stuff gets read out. [Colour Contrast Analyzer](https://addons.mozilla.org/en-US/firefox/addon/7313) and [WCAG Contrast Checker](https://addons.mozilla.org/en-US/firefox/addon/7391) both allow checking of page color contrast of individual page elements to make sure visually impaired folk can read text.  They do things slightly differently, and both seem to show background-foreground pairings that don't exist on the page.

I've done some other stuff to improve my sites accessibility, but plan to do more when I have free time.  I will go through those accessibility checkers and attempt to move as close as I can to being compliant with them.  As I start to implement this stuff on my own site, I will be able to more easily implement it on other sites I build as well.  This will hopefully be helpful in getting a job as well.
