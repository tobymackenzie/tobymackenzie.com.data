Nate Nuzum [filed a bug report](http://core.trac.wordpress.org/ticket/13799) which clarified the way it's supposed to work.  I responded:

> Ah so it appears that settings:
> - "Anyone posts a comment" goes to the post author
> - "A comment is held for moderation" goes to the admin
> So if both are checked, emails will go to both when held for moderation.  Makes sense then.  For clients I will probably just check the second box then.

Nabha pointed to [a Settings Discussion SubPanel page in the docs](http://codex.wordpress.org/Settings_Discussion_SubPanel), which said:

> The email notification is sent to the E-mail address listed in the Administration > Settings > General SubPanel.

I responded:

> The author of the post also receives an email if you have checked "anyone posts a comment".  If you check both, then both might receive an email (the author and the admin address).  At the time, I couldn't find the destination specified.  That codex page at least at this point specifies both if you know to look there.

Neel (snilesh) asked about having WordPress email all users when a comment is added to a post in a particular category.  I responded:

> Oh, sorry, kinda forgot about your comment.  I don't really know an automated way to do what you want.  People can certainly subscribe to the RSS feed of the comments on a post though, which you could place as a link in their newsletter.  There might be a plugin for doing that sort of thing, I dunno.  Otherwise if they must receive emails and you are handy at writing php scripts, you might be able to attach something to wp-cron that is triggered by comments.  Anyway, unless people specifically want to receive emails for every comment, the emails might get quite annoying, especially if you get lots of comments.

A couple years later, piyushranjan143 recommended a plugin, but it seems to no longer exist.
