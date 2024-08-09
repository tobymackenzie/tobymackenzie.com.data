---
categories: [www]
date: 2015-11-16T22:49:43-05:00
date_gmt: 2015-11-17T03:49:43+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=715'
id: 715
modified: 2017-03-13T23:15:11-05:00
modified_gmt: 2017-03-14T04:15:11+00:00
name: ascii-art-source-code-signature-for-my-site
tags: [asciiart, development, flare, web]
---

ASCII art source code signature for my site
===========================================

Sometimes I see sites with [ASCII art](https://en.wikipedia.org/wiki/ASCII_art) hidden in comments in their source code.  I've long admired the retro computer nerdiness of ASCII art.  At times, I've wanted to add some to my site, but have been reluctant because of the extra bites it would add to page weight, the difficulty in making it look good, the lack of a subject I felt worth it, and the problems they can have with differing fonts and display widths.  However, after [adding an easter egg](https://www.tobymackenzie.com/2015/11/08/konami-easter-egg/) recently, I was more receptive to the idea when reminded about it by the source code of [archive.org](https://archive.org/).

I spent some time this past weekend trying various different ASCII versions of my name.  Some examples:

<!--more-->

``` txt
███████ ███████ ██████  █     █
   █    █     █ █     █  █   █
   █    █     █ █    █    █ █
   █    █     █ █     █    █
   █    ███████ ██████     █
```

``` txt
_______ _______ _____   .     .
   |    |     | |     )  \   /
   |    |     | |   <     \ /
   |    |     | |     )    |
   |    \_____/ |____/     |
```

``` txt
•••••••  •••••  ••••••  •     •
   •    •     • •     •  •   •
   •    •     • •    •    • •
   •    •     • •     •    •
   •     •••••  ••••••     •
```

``` txt
....... ....... ......  .     .
   :    :     : :     :  .   .
   :    :     : :   ·:    . .
   :    :     : :     :    :
   :    :.....: :....:     :
```

A full-name version made entirely of my intials was wide and not very legible:

``` txt
™™™™™™™  ™™™™™  ™™™™™™  ™     ™
   ™    ™     ™ ™     ™  ™   ™
   ™    ™     ™ ™   ™™    ™ ™
   ™    ™     ™ ™     ™    ™
   ™     ™™™™™  ™™™™™™     ™
™     ™   ™™™     ™™™™  ™     ™ ™™™™™™™ ™     ™ ™™™™™™™ ™™™™™™™ ™™™™™™™
™ ™ ™ ™  ™   ™   ™      ™  ™™   ™       ™ ™   ™      ™     ™    ™
™  ™  ™ ™™™™™™™ ™       ™™      ™™™™™™™ ™  ™  ™    ™       ™    ™™™™™™™
™     ™ ™     ™  ™    ™ ™  ™™   ™       ™   ™ ™  ™         ™    ™
™     ™ ™     ™   ™™™™  ™     ™ ™™™™™™™ ™     ™ ™™™™™™™ ™™™™™™™ ™™™™™™™
```

A small full-name version is only 55 characters wide for both names and 193 characters total, but didn't look great in the font my browsers were using for source and seemed a bit boring:

``` txt
¯T¯ |¯| |¯) \ /    ^ ^ /¯\ |¯¯ | / |¯¯ ^ | ¯¯7 ¯T¯ |¯¯
 |  | | | \  |     |V| |¯| |   |<  |¯¯ |\|  /   |  |¯¯
 |  |_| |_/  |     | | | | |__ | \ |__ | | /__ _L_ |__
```

The one I finally settled on was big and bold, really announcing itself:

``` txt
._______.  _____  ._____   __     _.
|__   __| /  _  \ |   _  \ \ \  / /
   | |   |  | |  ||  |_| /   \ v /
   | |   |  | |  ||   _  \    | |
   | |   |  |_|  ||  |_|  \   | |
   |_|    \_____/ |______/    |_|
__     __    _      ______ ._.    __._______.._    ._. _______.._______.._______.
| \   / |  /   \   /  __  \| |   / /| ._____|| \   | ||_____  ||__   __|| ._____|
|  \ /  | /  ◊  \ | /    \|| | / /  | |_____.|  \  | |     / /    | |   | |_____.
| |\˘/| ||  / \  || |      |   <    | ._____|| |\ \| |   / /      | |   | ._____|
| | ˘ | || |   | || \___/¯|| | \ \  | |_____.| |  \  | / /____ .__| |__.| |_____.
|_|   |_||_|   |_| \_____/ |_|   \_\|_______||_|   \_||_______||_______||_______|
```

This added in total 717 bytes raw / 264 bytes gzipped to my page weight (with the comment wrapper).  This is more than I would like for something that can't be seen by visiting my site normally.  But I'm a developer, to some extend showcasing my source with my site, so I think it is worth it.  It's 81 characters wide, which is just slightly wider than the 80 that is considered a safe limit.  As to the subject, my name is sort of my brand.  I may switch to something more interesting or lighter weight later, but I like it for my first attempt.

I put it below my `<meta charset />` to [ensure all browsers get the proper encoding](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/meta#attr-charset).  I put it below my `<title>` for good measure.  I might even move it down to the bottom of the document to minimize its affects when parsing, but that will also make it less noticeable.

View [my site's](https://www.tobymackenzie.com) source to see the result.
