---
categories: [www]
comment_count: 1
date: 2013-07-27T16:25:12-05:00
date_gmt: 2013-07-27T21:25:12+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=549'
id: 549
modified: 2013-07-27T16:25:12-05:00
modified_gmt: 2013-07-27T21:25:12+00:00
name: givecamp-2013
tags: [event, givecamp]
---

GiveCamp 2013
=============

Finished my third [Cleveland GiveCamp](http://clevelandgivecamp.org/) last weekend.  Another successful event.  This year, my project was a new web site with more features for [Bike Cleveland](http://bikecleveland.org/).  We were doing well enough with that project that I was able to help another project Saturday night and Sunday, a web application for the [Cuyahoga Valley National Park Environmental Education Center](http://www.conservancyforcvnp.org/space-rental/lodging/eec).

Bike Cleveland
--------------

Bike Cleveland is a bicycle advocacy group for the greater Cleveland area.  They had an existing site that was in WordPress, but wanted it to be more engaging for members, allowing more involvement and discussion.  Our group was composed of a team lead, four developers, a designer/ux person, and a learning teen with photo editing knowledge.  Our client was good with WordPress, able to install plugins and what not, and generally understood what we were doing, so he was very easy to work with.

We started Friday night discussing what he wanted.  We decided what was most important and what we could skip if time was short.  He wanted to involve members with forums, an ability to submit events, forms to submit accidents and thefts, to have buttons to share things, and to emphasize ways to become involved with the organization.  They also wanted the site to work on mobile devices so that people could use it from phones while out cycling.

<!--more-->

The developers decided on a way to develop the new site as a new WordPress install and later replace the existing site with the new one.  We also looked for plugins to fill the clients needs.  The designer and learning teen worked with the client to come up with a mock up of what he wanted, then found an already built theme that most closely matched the mock up.

The client was fine paying for a theme, so we were able to get a nicer one.  We settled on [Blue Diamond](http://themeforest.net/item/blue-diamond-responsive-corporate-wp-theme/3454881) from Theme Forest.  I had never worked with a pay theme before.  It was impressive what all it provided.  It had an interface for changing colors, how things are output, etc.  It also had a bunch of shortcodes for creating columns and other things within posts, and there was even a fancy drag and drop interface for putting various widgets on pages (we used it for the home page).

For the forums, we used [BBPress](http://wordpress.org/plugins/bbpress/).  It was really simple to install and set up, and we barely put any time into it once it was set up.  For the calendar, we checked out a number of options, but none of them were quite up to par.  The biggest limiter was that the client wanted users to be able to submit events and have administrators approve them.  There were only three plugins I found that could handle that easily, and they all had their problems.  So for that, we just kept their previous solution of using Google calendar.  We went with [Contact Form 7](http://wordpress.org/plugins/contact-form-7/) for our forms.  I didn't do work on the forms, but have used the plugin before.  It worked.  We also used a few other plugins for sharing buttons and other odds and ends.

Between the theme's built in abilities and the plugins, we did not have to edit a single file (I technically edited one to fix a bug in a calendar plugin, but we didn't end up using it anyway partly for that reason).  We were able to do most of our colors and other appearance settings through the themes settings, and it had an 'Additional Styles' field to add CSS without modifying files directly.  I wrote maybe 15 lines of CSS to fix a few problems with colors and responsiveness.  Most of the time was spent changing settings, testing plugins, and especially working on the content.  So, in a way, it was a bit less fun, not writing code, but it was neat to make it work so easily and will be better for the client, who can update the theme without overwriting anything and make changes if need be.

CVNP Education Center
---------------------

This group was struggling when I was telling one of its members Saturday night that my group was pretty well set.  He suggested they could make use of my CSS skills, so I went over to help.  They had decided to build their application from scratch.  They were a bit disorganized and rushing.  They had very simple mockups made, but (so we thought) none built, just white table cells with borders containing their content.  I built the simple home page very quickly, and decided to make it responsive as a bonus.  Then we discovered that another team member had done the interior page layout (which was slightly different).  So we decided to keep my home page and use her interior stuff.  So I had made a single page.  They had been emphasizing the need for their current stuff to work with my styles, so I had kept it in the table markup wrapper, but then I saw the lady doing the interior pages had done them with divs and html 5 elements.  So I converted mine over to use them too, which allowed me to make it even more responsive.

After that, I began work on building the administrative form pages.  In order to do that, I had to commit something somebody else had made (he didn't have git installed and needed it to merge with my home page changes), fix some broken things, and wait on some other commits.  In committing that other person's work, I committed something I shouldn't have (since they were using a public repository).  I also, rushing, made some mistakes.  Git did some crappy merging, which exacerbated the problem.  So some of the team members were not happy with me.  I then just focused on the form stuff.  I kinda went overboard trying to set it up so that templates would be able to make all the form fields for me.  It may have taken a bit longer, but would've helped speed things up with other forms if I had gotten to them.

We were rushing, but the application was not completely finished by the end of GiveCamp.  We had to demo it on one of the developers machines.  I think most of the front end that the users will see was basically working, though I didn't get to see it besides the demo at the closing ceremonies of GiveCamp.  The team lead was planning on coordinating to get the rest of it finished for them.  I haven't heard the results, but hopefully they were able to make it 
work.

Conclusion
----------

Working on the CVNP project was stressful, and I didn't get to use my abilities to the degree I would have liked.  It was still a good learning and networking experience though.  I liked having my expertise requested, even if I may not have gotten to show my expertise very well.  I like seeing different ways of doing things, which I don't really get to see at work.  I got to see two different groups in action this year, which was nice.  I got to see a pay WordPress theme, which may give me ideas for how I build my own theme.  And, of course, I got to help out two worthy organizations in need.  I will be there again next year.
