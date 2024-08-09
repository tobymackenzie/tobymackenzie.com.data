---
categories: [www]
comment_count: 2
date: 2012-07-26T06:21:09+00:00
date_gmt: 2012-07-26T06:21:09+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=499'
id: 499
modified: 2018-08-23T01:04:43-04:00
modified_gmt: 2018-08-23T05:04:43+00:00
name: givecamp-2012
tags: [dotnetnuke, event, givecamp, net]
---

GiveCamp 2012
=============

This past weekend I went to my second [GiveCamp](http://clevelandgivecamp.org).  GiveCamp is an event where a bunch of developers/designers get together with local charities to build them websites, applications, databases, etc. to meet a need of theirs.  The product is started Friday evening and finished Sunday afternoon.  The developers donate their time and get food, fun, and great experience in return.  It's a great way to learn new techniques, practices, even languages, as well as meet new people in the industry, often some of the well known in the area.

This year my team was to build a website for Buckeye Industries, a division of [New Avenues to Independence](http://www.newavenues.net/).  Buckeye Industries is a business enterprise that provides training and jobs for people with disabilities.  They have info on the New Avenues site, but wanted to separate out the content into its own site.  So it was basically a new site except for the content. [Sarah Dutkiewicz](http://www.linkedin.com/in/sadukie) was our able project leader.  She did a great job working with our client, organizing things, and keeping us moving even through some troubles.  Our client contact, named Karen, was very helpful and probably the most enthusiastic client I've met.  The rest of our team started out as five people but then dropped to four as one went to another project.

<!--more-->

As we started, I was a bit worried because we were planning on using .NET, which I have no experience with.  I had some experience with classic ASP several years ago, but .NET is very different and I used very little of the language I learned then.  I also only had my Mac with me, which didn't support the WebMatrix software we were planning on using, though I did have a VM with Windows XP and Bootcamp with Windows 7.  I installed it in the VM, but it was way to slow, so I went to booting straight Windows for a while.  That took a bit of time to set up as we researched CMS options and other project considerations.

We did not have a working web and database server set up until Saturday afternoon, so much of the time beforehand was research, planning, and experimentation on our local machines.  We settled on using [DotNetNuke (DNN)](http://www.dotnetnuke.com/) because of the [store front module](http://nbstore.codeplex.com/) it has that integrates nicely with PayPal.  None of us had experience with this CMS, but there were some folk in another group we were able to get some help from, including one of the founding creators of it.

We started off thinking we might use a prebuilt template ("skin" in DNN parlance) and modify it to our needs, but none were quite like the wireframe drawing we had of what the site should look like.  When one of the experienced DNN people said we could easily convert a from scratch plain HTML/CSS layout into a DNN skin, we decided to try it out.  Since layout conversions is what I do most at work, I dived into this.  Normally at work I have a full fledged design to slice up.  This time it was just a wireframe, so I started with building a basic layout like in the wireframe and then began adding some additional style based on some of their print documents and their New Avenues site.  I'm no designer, so I was surprised when what I came up with eventually really pleased the client Karen and the team liked it as well.  I primarily focused on the design and HTML/CSS from Saturday afternoon to Sunday afternoon, while the rest of the team took care of everything else, like server and CMS setup, (lots of) contenting, installing modules, much of the image stuff, etc.

It was a very tiring weekend, working most of my waking time for the duration of the event.  It was also a bit hard to get to sleep, camping in Downtown Cleveland near a highway, train tracks, and an airport.  I must say that there were times where I was a bit frustrated.  I was worried, particularly at the beginning, that I wouldn't fit the team well with my lack of .NET/DNN experience.  I did not have a good Windows development environment set up.  Luckily once we got the external server, I was able to go back to Mac OS and develop in my normal environment using FTP. I did find the DNN admin interface rather confusing at times, having trouble figuring out where some things were and how to do things.  Much of their documentation is buried in videos.  There were numerous problems trying to convert my HTML/CSS into a DNN skin, mainly because of a lack of knowledge of the system.  It took a few hours just getting it to work, long enough that there was some talk of going back to a pre-built template.  Since we started development late due to the server issues and it was a sizable project, there were times when I worried if we'd be able to finish in time.  There was a subsection of the site with separate branding that I hadn't even worked on style wise until mid-Sunday.  Luckily I was able to reuse most of the styles from the main site branding, just with different logos, background, and colors.  I was able to use some classic ASP/VBScript experience to help keep things mostly DRY, though evidently this is frowned upon by DNN since it will cause an error when going into its "Layout" mode.

In the end though it all turned out nicely, and overall it was a lot of fun.  As always, everyone worked hard and did well at what they did, and I enjoyed meeting and working with them and learning from them.  I think GiveCamp by its nature draws the more enthusiastic people.  I learned a bit about working with .NET and DotNetNuke, and will be able to make a bare DNN skin to use in any potential future DNN projects.

<del>I will post the URL to the site once it officially goes live.</del> <del>The site is now live at www.buckeyeindustries.org.</del> <ins>It seems the site no longer exists.</ins>
