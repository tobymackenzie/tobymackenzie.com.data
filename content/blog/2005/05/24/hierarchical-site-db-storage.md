---
categories: [ideas, ideas, www]
date: 2005-05-24T02:19:02-05:00
date_gmt: 2005-05-24T07:19:02+00:00
guid: 'http://cosmicosmo.ath.cx/log/2005/05/24/hierarchical-site-db-storage/'
id: 31
modified: 2022-03-08T20:48:16-05:00
modified_gmt: 2022-03-09T01:48:16+00:00
name: hierarchical-site-db-storage
tags: [sites]
---

Hierarchical Site DB Storage
============================

a prototype hierarchical site database will be made containing a description and discussion of everything I own organized by category.  for now this'll allow children to have only one parent, but it will need multiple parents in the future.

page display:
a nav box at the side of each page will have links to its parent, siblings, and children.  children will be ordered by type
the content will be in a box.  content may also contain links to other pages, especially children, when mentioned.
a site map will provide a hierarchical link list of all pages in database

each page will be a entry in a database.  It will have:
a unique id to identify it
the id of its parent page (what links to it)
type/template defining display of page by type
style of page (style sheet for colors, etc of sections).  parent inherited if blank.  will be unimplemented at first
content of page

root page will be home, with links to all first level sub pages. 

example for stuff
transportation page
children: car, sailboat, bicycle, foot
content: It is essential to get from point A to point B: to get products stored elsewhere, see different things and people, go to locations better suited for certain functions.  One comes with <u>feet</u> with which to travel about.  This mode of transportation is very easily accomplished, requires as little as oneself, allows careful manuevering in tight places, and can easily handle terrain other transportation types have trouble with.  It is also relatively very slow and tiring for longer lengths and can only handle ground.  A <u>bicycle</u> provides transportation with the body as a motor, allowing more speedy and efficient travel.  The bicycle is a fairly simple device, lightweight and easily storable in most places.  A <u>car</u> is a much faster mode of transportation that requires very little exertion on the users part.  It allows great distances to be achieved within less time and easy transport of goods.  It is also big and much more expensive to own and operateâ€¦
(this is a brief overview of transportation.  children are linked to in content with a brief summary of each.  Each child will go into more depth.)
template: this would probably be a "summary" or "directory" type template, just a overview of a category with summaries of each child.  Its children would probably be as well.  The car category might have children that are of a "product" type, giving a review/discussion of specific instances of the parent.  the parent of a collection of  "product" pages may contain a comparison summary that provides a conclusion as to which is best for a given situation.
