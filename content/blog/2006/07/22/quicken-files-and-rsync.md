---
categories: [computer]
date: 2006-07-22T16:34:23-04:00
date_gmt: 2006-07-22T20:34:23+00:00
guid: 'http://cosmicosmo.ath.cx/log/2006/07/22/quicken-files-and-rsync/'
id: 115
modified: 2006-07-22T16:36:04-04:00
modified_gmt: 2006-07-22T20:36:04+00:00
name: quicken-files-and-rsync
---

quicken files and rsync
=======================

Backing up quicken files via rsync evidently doesn't work: the resource forks are destroyed, which the files "need".  Files saved in this way will just give an error message when opened in Quicken, "Unable to open file."  However, the data is not lost at all.  The data file is actually a package.  If you show package contents, you will get to the actual data file (<path>/Data\ File/Contents/Data\ File).  To recover this data, use vim or some other text editor that can handle the data properly.  TextEdit or many other similar programs won't work.  You need to get the Contents/Data File from a working data file, perhaps a newly created one.  Yank all the data from the file with your data in it:  there are a lot of lines, so '500dd' or something like that will get them all, or simply using the graphical version to select all.  Then open the working file and replace all with the yanked lines.  This worked great for me.

After my recent hard drive crash, I had to use whatever I had backed up.  Quicken wise, I had backed up about 15 days before the crash using rsync.  I also had an old file from nearly a year ago.  Unfortunately, because of my saving methods, the data in both seemed to be from more than a year and a half ago.  I soon discovered that the recent data file had been rsynced to the inside of the contents of the data file I had intented it to replace.  This was the actual recent data file.  Unfortunately it would not work.  I searched the web for solutions, but no one seemed to have one.  I did get information that the resources were removed by rsync, however.  I decided to figure out how to put the new data into a data file that worked.  Simply copying via the finder the Contents/Data\ File didn't work.  I tried replacing the contents via TextEdit, but that didn't work either.  I tried modifying a single line in the working data file with vim, and that worked.  I then tried replacing the whole file contents, and that worked well.</path>
