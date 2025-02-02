---
categories: [www]
date: 2016-06-28T22:56:49-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1170'
id: 1170
modified: 2016-06-28T22:56:49-05:00
name: abstractions-interfaces-lists-details-flows
tags: [abstraction, design, programming]
---

Abstractions: interfaces as lists, details, and flows
=====================================================

I read a post recently of Dave Rupert lamenting that he can describe any digital interfaces as [lists, details, or flows](http://daverupert.com/2016/04/lists-details-and-flows/).  This is, of course, an abstraction.  Abstractions can be useful for reducing complexity and making things understandable.  In code, they also can be used to reduce duplication and provide reason for limited responsibility, improving maintainability.  But if everything is fit into a small number of buckets, it can certainly make it seem like there is a lack of diversity, a sameness to everything.

With any good abstraction, everything can fit into it with a certain level of mental effort.  Some might be more willing to go further than others to make a given classification work.  In code, too heavy abstraction can lead to a given abstraction trying to do too much, or conversely, functionality being limited to fit a simple concept of the abstraction.

<!--more-->

I have come to similar abstractions as the 'list, details, flows' myself as I've tried to abstract my interface modules, javascript widgets, and even database data.  I think this abstraction is easy to see because it is not that different from other common abstractions from computer science to language itself.  Details are similar to items, objects, entities, table rows, nouns.  Lists are like arrays, vectors, collections, tables, groupings of nouns.  And flows are related to actions, activities, transactions, verbs.  Missing from this are properties, attributes, columns, and adjectives that could correspond to sub-elements of these, such as titles, descriptions, and form fields.  There are other parts of speech and related computer science terms that could be tossed in there too if desired.

Taken in this context, it would not be hard to find these abstractions in the [other places Dave went looking for different types of interfaces](http://daverupert.com/2016/05/alternate-realities/).  In video games, for instance, it's easy to see a flow.  Things such as characters, ships, and items that characters can be acquired can be presented as details (individually) or as lists (grouped together).  Individual book covers might be harder to directly tie to one or more of those three words, but they are not dissimilar from simple web home pages, and certainly bringing in the other related words, particularly parts of speech, could be used to describe them.  Graph databases are like items in lists with more complicated groupings.

I guess my point is that looking at things only as a given abstraction can give a simplistic view of reality.  This can be both useful and problematic.  This is mostly just some thoughts I had when reading Dave's articles, but they hit on something I've been feeling encountering many people trying to abstract everything into small sets of options.
