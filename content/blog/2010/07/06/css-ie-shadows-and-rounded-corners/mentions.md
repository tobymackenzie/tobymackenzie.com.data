Several months later, arius opined that lines 129-131 were pointless, but this was otherwise "great work".  I responded:

> those lines are for color shadows that have transparency.  For colors, the "makeShadow" property of the "Blur" filter must be set to false and the "shadowOpacity" property does nothing.  So without those lines, color shadows are always fully opaque.

Early the next year, simone asked for a demo.  Several days later, I responded:

> Hmm, the site that I had worked on this for is still not quite yet live.  There are some other sites I've made that make use of the htc, but do not take advantage of the modifications I made, and I'd have to search through the sites I've made to see which used this and which are live anyway.  Instead, I will try to make an example page for this and post it when I have it up.  I should probably do that for a number of my posts anyway.
>
> and I've created a simple example page.  It kinda shows that the rendering is not perfect and can have some issues.  See at:
>
> [here](/content/examples/css/iecss3htc)

Sabine / mitkalejdoskop was having problems with the htc file on a WordPress site.  I responded:

> One thing you might want to make sure of is that you are serving htc's with the right mime type, I believe it's "text/x-component".  You could load it directly in something that shows response headers, like Firefox with Firebug, and make sure the mime type is correct.  Have you tried any other htc's, such as [iepngfix](http://www.twinhelix.com/css/iepngfix/)?  I've also heard of some problems with the way paths are written in the behavior property, don't remember what the issues were though.  Otherwise, the htc is just a plain text file with an htc extension, so it should work via both copy paste and download.

Matt commented about two issues.  One, he was having rounded corner containers separate from their content on window resize.  Two, he found a regression where certain items with both a shadow and rounded corners were no longer getting rounded corners.  Over the next day, I responded a few times:

> That resizing of windows, as well as moving elements around with javascript, can cause sometimes cause the shadows to become detached from their related elements.  I've not had any problems with the rounded borders, but it may be caused by the same thing.  I'm not totally sure what needs to happen to cause this, but keep in mind that the shadows are separate elements positioned absolutely, so their positioning parent affects what they are moved relatively to.  There is an update function to move them on window resize and with a timer, but perhaps this is getting broke somehow, I hadn't worked on that part.
>
> As for the rounded bit, I'm not totally sure how that ability got lost from the original.  I don't use the VML type v:roundrect for the colored shadows (though I think I found a way to since then), but they should still work fine for black shadows, but don't.  I'll play with the script for a while to see if I can figure it out and upload the update if I do get it working.

then:

> Okay, I've modified the script to use the "v:roundrect" for even the color shadows and it now should bring back round corners for everything.  The script is modified above and I've added another post with the file at [Google Code](http://code.google.com/p/box-shadow/issues/detail?id=1)

Margaret asked if the shadow could be done on only some sides, as works in newer browsers.  She figured that out, but asked about the flash of square corners before they get rounded on page load.

warnerh commented about some problems, possibly with animation and / or `z-index`.  I replied:

> @warnerh, I don't totally understand what you mean, and your link was to something password protected.  This script sometimes does have problems with animations and some positioning situations, so I guess all I can say is try playing around with things and see if something can fix the problem.  In IE8 you can see the VML elements with its element inspector:  See if that sheds any light.  If it is an animation issue, you could try applying a class with the htc behavior when the animation has stopped.

Rustem asked about gradient backgrounds.  I responded:

> For gradients, look into [CSS3 PIE](http://css3pie.com/).  It does a lot more than this htc does, though it does not support text-shadow.  I'm not sure if I want to go through the trouble of adding gradients since CSS3 PIE is available, but if I have nothing else to do I may look at it at least.
>
> I'm guessing your problem is that a gradient is rendered with square corners covering the VML with round corners that the htc creates.

vadimv commented that the htc doesn't work on mouse hover events.

Margaret came back again to ask about handling each corner border radius separately, saying it doesn't work in Windows XP.  I responded:

> Yeah actually this script doesn't even look for differing border-radiuses, it only looks for the one.  IE9 should probably support the border-radius property natively, but I'm not sure why IE8 on Windows 7 would work, unless Microsoft provided an update that they didn't for XP.  If you must have the varying radiuses and don't need text-shadow, I'd recommend [CSS3 PIE](http://css3pie.com), it is newer and more feature filled.  I'm not sure how to do it so I wouldn't be able to add it to this script currently.

Tonttu opined that inset shadows don't work in combination with rounded corners.
