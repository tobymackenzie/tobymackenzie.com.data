---
categories: [www]
date: 2012-12-03T07:22:37+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=511'
id: 511
modified: 2012-12-03T07:22:37+00:00
name: my-first-responsive-site
tags: [css, design, layout, responsive]
---

My first responsive site
========================

I've been interested in the basic idea of responsive design since I first started into web development.  Back then it was mainly limited to flexible widths that accommodated changing screen widths and font sizes.  I experimented with that when development was just a hobby.  Still, I found CSS2 and browser compatibility issues to greatly limit the flexibility.  When starting to actually get paid as a developer, I went with what was already being done at the places I worked, which was pixel-perfect design.  Sites had to work in old browsers and time was limited.  Designs were flat images that were easy to cut up and use CSS to match exactly.  I did play with some flexibility when I had more free time.

When responsive design became a thing, I thought it looked pretty awesome.  It gave a lot more flexibility than what I had been playing with.  Still, browser support was too bad for parts of it for me to use at work.  I played with some aspects of it, adding a bit of flexibility here and there, but still kept mostly with the pixel perfect type design.  When we eventually discussed it with my boss, he didn't like the idea, particularly for accommodating his designs and the browser support issues.  I started a yet unfinished remake of my own site that allowed me to play much more, but didn't get very far towards a finished design.

### The Site

Recently, my boss came up with a simple design for a simple site that he thought would be perfect for trying responsive techniques with, the [annual report for the Gay Community Fund](http://2011.gaycommunityfund.org/).  It lent itself well to flexibility and him and the client were fine with graceful degradation / progressive enhancement.  It consists of basically two layouts:  the home page, with a gallery layout of boxes; and an internal layout with a heading, a possible image, a possible small image gallery, and a possible long list.

<!--more-->
### Responsive Characteristics

For the home page, I allowed the gallery to expand and contract in number of columns based on the viewport width.  The widths of the boxes and of the media queries was done in ems/rems and the background images were set to 'cover' to accommodate changing font sizes.  Because I wanted the gallery centered on the screen and still laid out with items floated left, I had to make separate media query stops for each number of columns (see related [StackOverflow question](http://stackoverflow.com/questions/13496280/css-horizontally-center-floated-image-gallery) if you have any alternatives).  I went up to six.  I also made the heading block get narrower when the viewport gets narrow enough.

For interior pages, I made them a fixed width if the viewport is wider than the em equivalent of our standard 960px.  I also have two columns on some pages for the top text content and three columns for the bottom list.  When going narrower than 960px equivalent, the site becomes 100% width.  The gallery loses columns just like on the home page as the viewport shrinks.  At certain points, the text content and lists lose columns as well.  A floated image in the text content gets moved above it near the narrowest of widths.

### Older Browsers

For the homepage, the flexible number of columns works in non media query browsers just fine, except that there is no centering.  The heading block does not narrow either.

The internal layout degrades rather gracefully as well.  It maintains the max-width to 100% width switch back to IE7.  IE9 and lower don't support text columns at all, so they can't even have the effects of losing them.  Losing the text columns for the top text content area is not really a big deal, just making for longer text lines.  For the bottom lists, though, they become rather long.  The image gallery does lose columns as expected.  The floated image at the top remains floated for IE8-, which is not that big of a deal.

These older browsers are dropping in usage numbers.  The farther they drop, the more plausible it is to use a variety of techniques, including the media queries that are an important part of responsive design.  If only IE9 had columns support.

### Conclusion

I really enjoyed doing this layout and liked how it turned out.  It looks rather nice on phones and various widths of larger viewports.  I learned a good bit about making a responsive layout work, even if this was a fairly simple one.  Some sophisticated flexibility can be created in sites, and other CSS developments, such as [flexbox](http://www.w3.org/TR/css3-flexbox/) and [grid layout](http://www.w3.org/TR/css3-grid-layout/) will allow even more flexibility as they become fleshed out and more well supported.  I hope to be able to use this stuff more.  Gotta get back to working on my own site at some point…
