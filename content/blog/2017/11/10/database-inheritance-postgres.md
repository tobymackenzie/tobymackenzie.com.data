---
categories: [computer, www]
date: 2017-11-10T02:15:27-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1663'
id: 1663
modified: 2017-11-10T02:24:55-05:00
name: database-inheritance-postgres
tags: [database, inheritance, objects, oo, orm, postgres]
---

Database inheritance: Postgres?
===============================

I've been unhappy with the inheritance provided by PHP ORM's I've looked at.  In looking for something better, I discovered that [Postgres](https://en.wikipedia.org/wiki/PostgreSQL) has built in inheritance, because it is an [object-relational database](https://en.wikipedia.org/wiki/Object-relational_database).<!--more-->  One table can inherit from another as part of its schema.

Being built in, it seems like it might not have the limitations that were bothering me about the ORM's inheritance systems.  I will have to take a closer look at it and maybe build my own minimal ORM on top of it.  It might fit nicely with an application I have in mind.

It might seem a bit daunting to learn a new DBMS, but Postgres still supports SQL, so it shouldn't be overly difficult.
