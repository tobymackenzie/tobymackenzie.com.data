Nearly a day later, David Valdez of the Magic Fields team responded that the bug I talked about is fixed in version 1.2.  He said that existing posts created with "write panel" without fields wouldn't appear in "manage", but new posts would.

hunk, another Magic Fields developer, responded the next day saying much the same thing as David and providing [a script to attach the existing posts](http://gist.github.com/244722).  The variables on line 6 and 7 must be set to the appropriate values.

I replied to David and hunk:

> Ah thanks guys.  Good that the items without custom fields thing is fixed.  I will give that script a try.  It looks much much simpler than one I found in your support forums.  That should make it easy for me, and since I've disabled the regular new post panel with Adminimize, there shouldn't be any more unassociated posts created.

A day later, I replied again:

> The script worked like a charm.  Almost.  Because of the limit to the number of posts output by `WP_Query` by default, I was only getting ten items per category handled.  I had to add the following before `cat=...` in the `WP_Query` function call: `"posts_per_page=-1&"`.  This makes all posts of that category get added to "The Loop".  I'll try to contact you some other way in case you don't see this post.

Someone four months later said that they were using 1.2 and asked how to make hunk's script work.  I responded that evening:

> Hunk's script is standalone, you can put it in the wordpress root directory (with the paths as set up) and then visit the url of that file.
>
> As I recall, the fix in Magic Fields only applies to newly created items, not to ones from before an upgrade, so you'd need to run the script first, then afterwards you'd be fine.
>
> I thought Magic Fields was up at 1.3.1.
