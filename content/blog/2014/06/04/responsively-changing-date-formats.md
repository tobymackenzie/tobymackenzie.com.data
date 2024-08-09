---
categories: [www]
date: 2014-06-04T00:36:52-05:00
date_gmt: 2014-06-04T05:36:52+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=622'
id: 622
modified: 2024-08-01T12:35:24-04:00
modified_gmt: 2024-08-01T16:35:24+00:00
name: responsively-changing-date-formats
tags: [css, responsive, technique]
---

Responsively Changing Date Formats
==================================

At times in developing a responsive site, the content that is shown needs to change depending on the viewport.  One might want to show a hamburger icon instead of a menu on a small viewport or display extra less critical content on a larger viewport.  I recently had to show a more verbose format on wide viewports (like "Tuesday June 8, 2014") and a less verbose date format (like "Tue Jun 8, 2014") on a narrow viewport to make things fit well.  I didn't like the options I've used in the past.  I didn't want to have duplicate content in my raw markup, to need to inject HTML elements into generated date strings, or to involve JavaScript.  I tried fixing the width of a wrapper and hiding the rest, but with the non-monospaced font, it didn't work the same for all cases.

So I did some looking for other options.  I found [a discussion of a technique](http://www.sitepoint.com/forums/showthread.php?775206-switching-date-format-in-responsive-web-design) that seemed fairly elegant.  I had been reluctant to use it in the past because of browser support and just being a bit uncomfortable with it.  The technique makes use of [the `attr()` expression](https://developer.mozilla.org/en-US/docs/Web/CSS/attr) to inject content.  Since any browsers that support media queries should support `attr()` and I was using this in a media query, I thought it worth it to embrace it finally.  I liked the results and will probably make more use of it in the future, especially since the browsers that don't support it now have low enough market share to almost ignore.

<!--more-->

In the aforementioned discussion, the poster used a different technique to hide the text so that only the injected content displays, but I wanted something simpler, so just added an inner wrapping element.  It's hard to say whether to hide the content completely or use a technique to hide it visually but leave it readable by screen readers, because some read CSS generated content and some do not.  I'd rather go with the latter option.  So basically, what I did looks something like this:

HTML:

``` php
<span class="weekday" data-shortened-content="<?=$date->format('D')?>"><span class="weekdayContent"><?=$date->format('l')?></span></span> 
<span class="month" data-shortened-content="<?=$date->format('M')?>"><span class="monthContent"><?=$date->format('F')?></span></span> 
<?=$date->format('j, Y')?>
```

CSS:

``` css
@media screen and (max-width: 38em){
    .weekday, .month{
        overflow: hidden; /* to allow positioning below to not need to be as extreme */
    }
    .weekdayContent, .monthContent{
        /* display: none; # just do this if you don't want the content read by screen readers */
        /* choose your screen reader only technique of choice here */
        left: -100%;
        position: absolute;
    }
    .weekday:before,.month:before{
        content: attr(data-shortened-content);
    }
}
```

If you go the reverse way (ie the content is the short version and the attribute is the long version), you can just use the `<abbr>` element and the `title` attribute.

Sure, the markup is much more verbose than it otherwise would need to be, but I liked it better than the alternatives for my situation.  I will probably experiment with using something like this more often.
