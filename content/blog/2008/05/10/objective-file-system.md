---
categories: [computer, ideas, ideas]
date: 2008-05-10T01:20:10-05:00
date_gmt: 2008-05-10T06:20:10+00:00
guid: 'http://cosmicosmo.ath.cx/log/?p=190'
id: 190
modified: 2022-03-08T20:57:27-05:00
modified_gmt: 2022-03-09T01:57:27+00:00
name: objective-file-system
pings: ['http://cosmicosmo.ath.cx/log/2004/05/05/file-browser/']
tags: [computing, database, file, system]
---

Objective File System
=====================

This is a modification of part of a [previous post](/log/2004/05/05/file-browser/).

each file is stored in two databases: the normal hierchical db and an objective db.  The hierarchical db is used for speed and for compatibility with current file systems.  The objective db is used for metadata and other information less critical to basic file operations.

The objective db contains much of the metadata (non file operation related stuff).  Each file type is an object type in the database, inheriting from the basic file object or one of its children.  Each file type will have its own attributes as well as actions related to it.  The actions may consist only of OS functions related to it, may also include application calls, and could even include user/other created scripts and functions related to the file type.  The actions would provide the data from the file to the system or other function that is necessary for it to operate (functions and applications would all have a defined standard interface to them).
