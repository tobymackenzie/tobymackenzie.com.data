---
categories: [www]
comment_count: 7
date: 2010-02-13T02:44:20+00:00
date_gmt: 2010-02-13T02:44:20+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=253'
id: 416
modified: 2017-03-03T02:28:22-05:00
modified_gmt: 2017-03-03T07:28:22+00:00
name: wordpress-comment-approval-email-address
tags: [admin, comment, problem, wordpress]
---

Wordpress: Comment Approval Email Address
=========================================

[Update 6/11/2009] See [comments](https://tobymackenzie.com/blog/2010/02/13/wordpress-comment-approval-email-address/#comment-59) for resolution of this issue.[/update]

Had a weird problem that might point to a weird semi-bug of Wordpress.

I just recently received an email asking me to approve a comment on the Stearns site.  I haven't touched the admin part of the site in two months.  We had set them up to need to approve every comment, and to have Wordpress email the administrator whenever a comment was submitted.  When I left I had made sure the address in the >Settings>General pane was set to one of the Stearns people, and it still is.  This is the address I thought would receive the comment approval mailings.

I went looking for information on where the address for comment approval mailings is pulled from.  According to [this thread](http://www.wptavern.com/forum/troubleshooting/226-comment-notification-e-mails.html), the mailings are sent to the address of the "admin" account.  I had deleted the "admin" account for security purposes (getting rid of a known user name) and may have transferred that account's posts to mine.  Or maybe it's because my ID is the next closest to zero.  So my account may be considered the "admin" account now.

The other possibility that I thought of is that the mailings get sent to the post author.  I'm set as the author of the post the test comment was set to and a number of others.  I would have to change them all over to one of the Stearns people if this were the case.

Choosing the easier solution first, I changed the email address of my account to that of one of the Stearns people (modified with the "+" syntax to avoid duplication).  I did a test comment on the same post as the previous one was sent to and did not receive an email, so the suspicion of that thread may be correct (have to verify with the Stearns people).

I think that is a silly place to pull the address from if true.  It would certainly make sense to have this settable and not tied to one particular account.  The comment moderator might not necessarily be the "admin" user, as with Stearns.  It doesn't seem to be unreasonable to have the comment approval mailings sent to the same person who receives mailings about user registrations (the one on the "General" tab).  Or, to be a bit more fancy, either have a separate address or user set for comment moderation on the >Settings>Discussions pane.

I'll update this post if I find out more.

[Update: 6/10/2010] At this point I am thinking that the author of the post receives the comment approval emails, as it would certainly make the most sense.  For the [Samba Soccer Club](http://sambasoccerclub.org) site I did a while back, I received a comment approval message for a post I wrote as myself rather than admin.  I do have the lowest current ID, so that can't be ruled out, but it really doesn't make any sense for that to be how it works.  I've realized that my changes on Stearns shouldn't tell anything, because the lowest user id and post author are both the same for the relevant posts.[/update]
