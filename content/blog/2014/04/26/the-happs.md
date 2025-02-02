---
categories: [www]
date: 2014-04-26T02:34:00-05:00
guid: 'http://tobymackenzie.wordpress.com/?p=600'
id: 600
modified: 2023-09-24T14:22:49-04:00
name: the-happs
tags: [development, happs, process, requirejs, scss, web]
---

The Happs
=========

For a while now I've been trying to write posts that draw people, such as solutions to specific problems or things that might be called articles.  I think I've focused on these types of writings because parts of me want to be bring myself more prominently into the larger web community, help others, get some praise or critique for my work, and perhaps get offered a high paying job from some bigger web firm.  I think I got a bit heady when I started getting above 50 visitors a day, peaking at 98.  But that flow has dried up and I'm back down to less than 20.

I do like writing those types of posts sometimes, and I'm not going to stop, but I think I'm going to write a lot more smaller and less focused posts that are more generally about anything on my mind.  I think I shall call the posts "The Happs" so I don't have to think of a title and to emphasize their lack of a specific topic.  The article type posts really take a long time and some research to compose, and I don't have a lot of free time for them.  It is often so long between when I do whatever is the impetus for them and when I write them that I've forgotten a lot of the details.  I think "The Happs" will get me writing more often and allow me to put out snippets of what might later go into more thorough articles.

So, what has been happening with me lately?

<!--more-->

Time in the Web Industry
------------------------

I have been spending a lot of time working for my job at [Cogneato](http://cogneato.com) as well as various personal projects outside of work and reading articles and attempting to learn things.  There're also things away from this career I try to make time for.  I must say, there is so much information to learn and so many projects to learn in this industry that I can spend as many hours in the day as I have in it and still be missing a ton.

There are so many tools, libraries, frameworks, practices and techniques, languages, and so many other categories of things just within the development area of the web that no one could keep up with them all.  And of course there are design, user experience, content, SEO, accessibility, and whatever other divisions you want to make of what is the web.  All of this being available is great in a way, but it can be hard to get at what I really actually need to and can reasonably use in the actual work I do or may want to do.

Build Process
-------------

I have always had an interest in the process of developing sites, and I have been focusing lately on using some of the newer tools, like [SCSS](http://sass-lang.com/), [grunt](http://gruntjs.com/), and [require.js](http://requirejs.org/) to improve my process, especially for styles and client side behavior.  I really liked switching to using these, and they have, for the most part, made those parts of my job a lot easier.

### JavaScript

Before require.js, I was copying and pasting bits of code into a single JavaScript file.  It was never getting minified because the entirety of my build process was using a text editor to edit this file.  I had [a JavaScript library](https://github.com/tobymackenzie/Web-ClientBehavior/tree/master/old) to store various modules and functions, but they had to be copied and pasted in and any dependencies I just put in comments in the top of the file and had to manually deal with.  A lot of functionality was added on top of these per site or not stored in the library at all, so I would have to search through a big JS file on a site I knew had the functionality I was looking for, copy and paste, figure out its dependencies and find those, and then modify as needed.

I've used [a class system](https://github.com/tobymackenzie/js-tmclasses) and namespacing to make things modular, but splitting into separate files and having automatic dependency management makes a huge difference.  I was slow to switch to require.js after discovering it because my boss is reluctant to introduce things that would require the non-developers to learn new things.  But they were so rarely needing to make changes to the JS that I figured making them go through me would be fine enough and any problems would be outweighed by the benefits.  Since switching to require.js, I've been able to just grab the files I know I need from sites with the functionality I want, and have bits from my library or Cogneato's automatically included.  Bug-fixes and changes to the library can easily be applied then by just pulling the from the repos and rebuilding.  I use require.js's optimizer, r.js.

This has also allowed me to separate a bit development and productions versions of code.  For most sites, we work directly on the live site.  So I can edit the JavaScript files and use a GET variable to have the site use the non-built version without affecting the built production version.  Once I'm sure the changes are finished and safe to make live, I can build (I use a grunt task for this) and production will get the changes.

### Styles

I used to work on CSS in a similar fashion: one big file with everything.  The non-developers (we call them contenters) do have to make changes/additions to styles a fair amount, so I was even more reluctant to bring in a preprocessor.  But we started including a separate stylesheet from our base system for some base and widget styles.  I used SCSS for that.  Then the final push was working on the most recent redesign of The Akron Art Museum's site.  It has a responsive widget grid with some requirements that made for complicated CSS with complicated math for breakpoints.  There was almost 1000 lines of CSS just for that grid.  I actually created a spreadsheet just to deal with calculating the breakpoints.  When we decided to widen the widgets, I knew I needed SCSS variables and math operations to help me.

I figured out a solution to allow me to use SCSS while the others could continue with regular CSS.  Since we were already loading two CSS files, I would just load the base system one into my SCSS as the first one.  I would create an empty CSS file that they could work in, and load it second so any changes would override mine, meaning they wouldn't need to touch the SCSS even to change my stuff.  Being able to minify my CSS (the vast majority) would also help make up for loading to CSS files.

I now can split my styles into somewhat modular files that can be copied instead of finding bits in a big file.  I can use variables to store frequently used values or values I want to do math on to apply to different circumstances (like breakpoints based on the width of widgets or simply subtracting width of logos for smaller breakpoints).  Being newer to SCSS than require.js (in practice), I have been making a lot more changes and improvements to the way I work with it.

I put my colors and fonts for a whole site each in their own file.  The colors file has variables named by color name at the top.  Then the variables named by module/class, which are the ones I actually use in other files, are set with the color named variables.  This gives me a list of all the actual colors used on the site that I can easily find by color name, while still allowing me to use variables throughout my stylesheets that I won't have to change.

I do something similar with my fonts file.  I'll have my `@font-face`s and font stack variables at the top (like `$font-helvetica`).  Below that, I'll have variables for modules/classes that I'll used in other files set to one of the font stacks variables.  Below that, I'll put all of the font sizes for the site, which I've been doing directly as modules/class associated variables.

I have a breakpoint file for storing breakpoints, but I'm still fleshing out how I want to do that, and many times have only used it for a few often used breakpoints.  I'm working on a mixin to make working with breakpoints easy.

I have some mixins that come from our base system (ie our CMS) via an `@import` at the top of my main css file.  The main ones are similar to [these](https://github.com/tobymackenzie/html-boilerplate/tree/master/src/styles/mixins).  I then load my 'configuration' files (colors, fonts, …).  I then put my base styles (mostly plain element selectors), followed by loading a modules folder, a skeleton folder (the skeleton/wrapper styles), and a pages file or folder (page specific styles).

Conclusion
----------

I have more to say, but this has already gotten and taken much longer than I wanted for my "The Happs" series.  I'll try to write more of these to catch up with where I'm at and then keep them going to output anything on my mind.
