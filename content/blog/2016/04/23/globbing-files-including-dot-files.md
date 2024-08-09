---
categories: [www]
date: 2016-04-23T18:26:57-05:00
date_gmt: 2016-04-23T23:26:57+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1095'
id: 1095
modified: 2016-04-23T18:26:57-05:00
modified_gmt: 2016-04-23T23:26:57+00:00
name: globbing-files-including-dot-files
tags: [dotfiles, glob, paths, php, programming]
---

Globbing files including dot-files
==================================

Normally globbing for the wildcard `*` will find all files in a directory except for ones beginning with a `.`.  Sometimes I need to get all files including the dot-files.  The pattern `.*` will find these hidden files, but will also include `.` and `..`, referring to the directory and its parent.  As I've learned in the past, this can be dangerous with commands like `rm`, (i.e. you running `rm -rf .*` to remove dot-files will remove more than expected).  Today, needing to get all files in a particular path in PHP, I sought a solution.  A post on a Perl forum gave me [a solution using curly braces](http://www.perlmonks.org/?node_id=310198): `{.??*,.[!.],*}`.  Braces basically allow multiple comma-separated patterns to be evaluated.  The three patterns are:

1. `.??*` matches a dot followed by two characters followed by any number of characters.
2. `.[!.]` matches a dot followed by a single character that isn't a dot.  This is needed since the previous pattern doesn't match this case.
3. `*` is the normal wildcard glob, matching all non-dot-files.

In PHP, the `glob()` function requires the `GLOB_BRACE` flag to use braces.  An example might look like: `$files = glob($path . '/{.??*,.[!.],*}', GLOB_BRACE);`.  This did exactly what I wanted.
