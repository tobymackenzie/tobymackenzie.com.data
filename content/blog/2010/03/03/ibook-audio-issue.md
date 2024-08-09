---
categories: [computer]
date: 2010-03-03T10:48:04-05:00
date_gmt: 2010-03-03T15:48:04+00:00
guid: '/log/?p=258'
id: 258
modified: 2010-03-03T10:48:04-05:00
modified_gmt: 2010-03-03T15:48:04+00:00
name: ibook-audio-issue
tags: [audio, ibook, mac, osx, problem]
---

iBook Audio Issue
=================

After running [the utility Onyx](http://www.google.com/url?sa=t&source=web&ct=res&cd=2&ved=0CA0QFjAB&url=http%3A%2F%2Fwww.macupdate.com%2Finfo.php%2Fid%2F11582%2Fonyx&ei=HYKOS8T8GsO2lAe8uLy9DQ&usg=AFQjCNFVtv7hiM-uNHTPMbZj3xkh20AtZQ&sig2=KxpO1Sd1oyqfRt5t-SgpZQ) on my computer to both clean it up a bit and change some settings, I suddenly found my computer having some troubles.Â  Dialog boxes would just beachball shortly after appearing, and the applications that created them would have to be force quit.Â  After trying to change my volume, I noticed that something was wrong with my audio, so I turned off the text-to-speech I had set up for dialog boxes.Â  After this, the beachball problem stopped.

But I had no audio at all.Â  On further investigation, I noticed the OS was not recognizing any audio devices, input or output.Â  I found a [forum thread discussing this issue](http://discussions.apple.com/thread.jspa?threadID=1273177&start=0&tstart=-2).Â  I couldn't find the cause, but I did find a solution.Â  I simply had to download Quicktime from Apple and reinstall it over my current install.Â  Since then, I have full audio and no problems with it, and no unusual beachballing.

I'm not sure what happened that caused this problem, but it might have been related to the permissions check Onyx does on loading.Â  I hope to avoid it in the future.Â  I will be more careful using Onyx in the future anyway.
