---
categories: [www]
date: 2013-05-04T07:34:12+00:00
date_gmt: 2013-05-04T07:34:12+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=529'
id: 529
modified: 2013-05-04T07:34:12+00:00
modified_gmt: 2013-05-04T07:34:12+00:00
name: conference-rustbelt-refresh
tags: [conference, css, html5]
---

Conference: Rustbelt Refresh
============================

I went to my first real full length web development conference today, [Rustbelt Refresh](http://rustbeltrefresh.com/).  It was a very good conference with good speakers and interesting topics.  Finally something like this in Cleveland.  I learned and got to thinking about various things.  I was rather tired though after waking up so early and spending a whole day there.  I will summarize / talk about each presentation, as sort of a minimal review, but primarily to store and cement what I've taken away in my mind.

Presentations
-------------

### [Eric Meyer](http://meyerweb.com/): [The Era of Intentional Layout](http://rustbeltrefresh.com/speakers.html#eric)

Eric Meyer is our local global CSS celebrity.  I've gone to every local presentation he gave that I was aware of, which I think totals three with this one.

His talk started with a history of CSS layout, and how CSS never got a real layout system and the things we still use today are mostly hacks, limited in what can be done with them, and often create problems.  To summarize this history: At first the web had no layout, and content just went with the flow.  Then tables came in for tabular data.  They quickly became used for layout because of the lack of alternatives, and soon made markup a nested mess that was difficult to maintain and impossible to change the layout without changing the site structure.  Floats were added to allow content to flow around things like images, and quickly became usurped for layout.  Since they were designed without layout in mind, they had a lot of problems in use for it, and a lot of creative hacks have been created to get around them, like equal height columns and zero height containers.  Then came positioning, which was actually designed for layout, but had the problem of taking things out of flow and thus not allowing things to move in relation to each other, etc.

<!--more-->

He then went into some fairly recent CSS modules that are actually real layout systems:  [flex-box](http://www.w3.org/TR/css3-flexbox/), [css-grid](http://www.w3.org/TR/css3-grid-layout/); a helper: [css-regions](http://dev.w3.org/csswg/css-regions/); and [the viewport related units](http://snook.ca/archives/html_and_css/vm-vh-units).  He focused mainly on flex-box, since that has decent support in modern browsers.  That and grids both easily allow things developers have wanted for such a long time, no hacks, like equal height columns, source order independence, vertical alignment, and justifying box spacing.  The viewport units help laid out content respond to viewport changes.  css-regions allow content to flow from one layout container to another and even be shaped.

I knew most of the stuff from his talk already (all my notes from his talk: "flex-box - self align"), but he tied some things together and filled in some cracks.  More importantly, it made me happy that someone so influential in the CSS world is this excited about the importance of these layout systems.  I've felt for a long time that existing layout techniques are hacky, fragile, limited, and a pain, and I've been excited about flexbox and grids since I've first heard about them.  I can't believe it's taken this long, and I hope they are stabilized and then implemented quickly.  The quicker we can use these for real (flex-box to some extent can be as progressive enhancement), the better.

### [Jen Simmons](http://jensimmons.com/): [Responsive Layouts Beyond the Sidebar](http://rustbeltrefresh.com/speakers.html#jen)

I was not aware of Jen Simmons before this, but she apparently has a good [podcast](http://5by5.tv/webahead) I'm going to have to check out.

She talked about responsive design and how you can do more than just reflowing the sidebar below the main content.  You can change patterns and reflow content within individual modules of a site, swap out logos, etc.  But you have to be aware when changing things how it can change user focus and emphasize things differently.

She went into her design process for responsive sites.  She has four basic steps, though she said they're not so discrete in practice (she may move back and forth):

<dl> <dt>Design content structure</dt> <dd>Define what kinds of content you will have.  Define them as well defined chunks instead of a large blob.  Separate them into different types, each with their own bits of information.</dd> <dt>Design source order</dt> <dd>Place the content onto the page in semantic markup in the order a screen reader or non-CSS browser would see it.  We don't have true source order independence yet, but we have some abilities, and the new layout modules are coming.</dd> <dt>Design for narrow viewports</dt> <dd>This will generally include all your typography and colors, and be the point where you define your important areas of focus.</dd> <dt>Design for wider and wider viewports</dt> <dd>This is where the media queries come in and the more complex layouts with columns/grids.  She says she often moves to the desktop layout after doing just the basic NVP layout to help her better define what she wants to happen with her chunks, then moves back to the NVP side.</dd></dl>

She then went into some other general bits of advice.  Layout should create a visual hierarchy.  Users have expectations of what is in certain page areas that can affect their behaviors, such as ignoring stuff in the sidebar because of ads.

### <a></a>Josh Walsh: [Making Our Users Feel Great](http://rustbeltrefresh.com/speakers.html#josh)

Josh Walsh is another local speaker.  I've seen him before and even saw this same basic [presentation before at WebSIG](http://www.gcpcug.org/websig?eventId=609038&EventViewMode=EventDetails).  It was refined though and had different areas of focus and a lot of different content.  His presentation had somewhat less of a well defined theme than the others, and if it had one, it may have been a bit different than the title would suggest, but he had some good information.

I think the most prominent theme he discussed was how influential company culture is on a company and its products.  Any group that comes together has an automatically created culture.  When creating a team/company, effort should be taken to create the team/company culture, because one will be created regardless, and the team members are not skilled at culture creation.  Just sticking a game room in the building doesn't create culture.  The most important step is hiring people for their fit with the company culture more than their skill sets, because skill sets can be taught, but peoples' characters are hard to change.  You can write out basic company goals/missions to guide culture, but shouldn't write policy except for zero-tolerance situations.  Startups can disrupt because of their energetic and open culture.

He did go some into more user experience specific stuff too.  He suggested you should start with the end in mind, then figure out how to get there.  He talked about [Donald Norman](https://en.wikipedia.org/wiki/Donald_Norman) and his [seven stages of action](https://en.wikipedia.org/wiki/Seven_stages_of_action).  He gave some interesting examples of user experience design from his career (him going into companies to learn how they do things to help him improve their systems) and from others (such as a company that designed an iPad application for helping customers purchase sunglasses in one week by immersing the entire team in a sunglasses store).

### [Jonathan Penn](http://cocoamanifest.net/): [HTTP: Get to Know the Foundations of Your Career](http://rustbeltrefresh.com/speakers.html#penn)

The third local, I've seen him speak before at [<abbr title="Cleveland Web Standards Association">CWSA</abbr>](http://www.clevelandwebstandards.org/) meetups.  He spoke very quickly about a technical subject and may have lost the less technical folk.  The HTTP stuff he discussed probably doesn't need to be known by most developers, but is still good information to know to understand what is going on and could be useful for debugging some problems.  He sort of went through the spec by designing it as if it hadn't already been designed and talking about why he decided to add things.  HTTP is both human and machine readable, and very flexible to accomadate the web from when it was created, the web of today, and the web of the future.  It is both human and machine readable, and has a simple but very open and flexible structure.  He gave a [link to the history of the spec](http://info.cern.ch/).

### [Val Head](http://www.valhead.com/): [Finding Your Perfect Web Type Match](http://rustbeltrefresh.com/speakers.html#val)

She talked about web fonts.  She spoke excitedly and threw in plenty of jokes and cat pictures.  She talked about her four criteria for choosing web fonts:

<dl> <dt>Role</dt> <dd>Font faces are designed to solve specific problems.  Many were not designed with screens or the web in mind.  High contrast and small x-height fonts don't do well on the web.  Choose a font that does well on the web and was designed for what you want to use it for.</dd> <dt>Durability/Quality</dt> <dd>Font faces will look different at different sizes and on different operating systems, etc.  Test and make sure the font looks good enough for your purposes in the sizes you will be using on the devices that will/may be viewing them.  Type specimen files can be used.  She stressed the importance of managing expectations (of the client and yourself), that fonts will look different depending on platform</dd> <dt>Context</dt> <dd>When choosing for a particular site, make sure to test within the actual context they will be used in to make sure they do what you want them to.</dd> <dt>Availability</dt> <dd>Make sure licenses allow them to be used for the web and costs fit within the budget.  Remotely served fonts often have tracking scripts that may raise security concerns for some projects.  Self hosted fonts probably won't get updates.</dd></dl>

### [Emily Lewis](http://emilylewisdesign.com/): [Take Your Markup to 11](http://rustbeltrefresh.com/speakers.html#emily)

Emily, in addition to referencing [Spinal Tap](http://en.wikipedia.org/wiki/This_Is_Spinal_Tap), stressed the importance of well thought out, semantic markup.  It:

- provides semantics for machines
- is accessible for all users
- helps development efficiency
- is syndicatable
- helps with SEO
- enhances user experience

Building a site on a [<abbr title="Plain Old Semantic HTML">POSH</abbr>](http://microformats.org/wiki/posh) foundation.  Elements should have meaning, describe the content, be used for their intended purpose, and be valid.

Microformats and microdata can be used to provide more semantics for machines.  They can already be read by search engines to add more data to search results listings, but lack tools for consumption within user agents.  She prefers microformats for their simplicity and human readability.  ARIA landmarks can help screen reader users navigate your page.

### [Jonathan Snook](http://snook.ca/): [Your CSS is a Mess](http://rustbeltrefresh.com/speakers.html#snook)

I've read some of Snook's blog posts before.  He is also the author of [<abbr title="Scalable and Modular Architecture for CSS">SMACSS</abbr>](http://smacss.com/), which I have looked a bit into.  For his presentation, he managed to modify his slides to add in ones from previous presentations to good and funny effect.

He talked about techniques for keeping CSS organized, working with it in teams, and avoiding clashes.  He talked about three methods:

<dl> <dt>Categorization</dt> <dd>He organizes into these categories: <dl> <dt>base</dt> <dd>Baseline styles, like a CSS reset</dd> <dt>layout</dt> <dd>The main page layout structure</dd> <dt>module</dt> <dd>Common patterns for pieces of content to follow.  A module is one element.  It can have components that are inside of it.  There can be variants that have different styles.</dd> <dt>state</dt> <dd>Changes to styles based on what state a module/piece is in.  States can be changed by JavaScript, pseudo classes, or media queries.</dd> <dt>theme</dt> <dd>Use configurable styles, often colors on applications.</dd> <dl> </dl></dl></dd> <dt>Naming conventions</dt> <dd>Name classes with meaning, so that other developers will understand what they are.  He talked a lot about module naming conventions.  He uses a convention like: ```
.module{}
```

</dd></dl>

.module-variation{}
.module-component{}
.is-module-state{}</code></pre>
			He mentioned some other possibilities, such as:

```
.moduleName{}
```

.moduleName-variationName{}
.moduleName--componentName{}
.moduleName-is-stateName{}</code></pre>
			and said he might do things more like that if he were to start anew.

<dt>Decouple HTML from CSS</dt> <dd>Use child selectors to avoid needing to override in nested structures.  Apply a class when HTML isn't predictable.  He also advocated using one module class type per element (could be .module plus .module-variation on the same element, but not .module plus .module2) and nesting <div>s if you need multiple module types on the same container. </div></dd>

More Info
---------

[This storify](http://storify.com/redcrew/rustbelt-refresh-2013) has some minimal notes and lots of twitter posts from the conference.
