---
categories: [computer]
date: 2016-04-22T02:18:55-05:00
date_gmt: 2016-04-22T07:18:55+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1092'
id: 1092
modified: 2016-04-22T02:18:56-05:00
modified_gmt: 2016-04-22T07:18:56+00:00
name: moving-folder-symlink-and-trailing-slash
tags: [cli, gotcha, move, shell, symlink]
---

Moving folder symlink and trailing slash
========================================

It caught me by surprise that if you use `mv` on a symlink to a folder and have a trailing slash on the path, it will move the entire original folder rather than the symlink.  As a simple example, if you have a symlink 'symlink' pointing to the folder 'original' and run `mv symlink/ new-symlink`, you will end up with 'original' now being named 'new-symlink' and a symlink 'symlink' still pointing to the now non-existant 'original'.  Luckily, merely reversing the arguments will move the folder back to its original location: `mv new-symlink symlink/`.  The symlink becomes like a magic portal.  I probably wouldn't have run into this if it weren't for the 'fish' shell adding trailing slashes when doing tab completions on folder paths or symlinks to them.
