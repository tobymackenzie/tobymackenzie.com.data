---
categories: [computer]
date: 2005-10-03T23:54:46-04:00
date_gmt: 2005-10-04T03:54:46+00:00
guid: 'http://cosmicosmo.ath.cx/log/2005/10/03/audacity-microphone-wont-stop-monitoring/'
id: 68
modified: 2005-11-26T06:34:58-04:00
modified_gmt: 2005-11-26T10:34:58+00:00
name: audacity-microphone-wont-stop-monitoring
---

audacity: microphone won't stop monitoring
==========================================

I recently recorded some music through an external USB device called a Powerwave.  It allows me to record one stereo track through a 1/8th inch jack or RCA jacks.  I used Apple's Garageband to do the recording.  It does have a strange problem of not allowing one to see or edit anything past 33 minutes into a track: you can only listen, and only by starting it from sometime within the first 33 minutes and then fast forwarding to where you want it.  But it is much more stable than Audacity, so I felt more confident in using it.  However, I used Audacity for some initial testing of the setup.  I had it play through the speakers while recording, since the input wasn't a mic.

When I finished with Garageband, I disconnected the Powerwave, and the input device was changed back to the internal microphone.  For some reason, the mic was continuosly monitoring even with all audio applications closed.  I went in to Garageband to try to turn it off, by various means, but was unable to.  I left it go for nearly a day, and nearly forgot about it, save for an occasional crackling noise I heard when I got home from work, which I at first thought was a mouse.  I finally found the solution to the problem.  Audacity had left the audio driver or whatever monitoring the input, and after I removed the Powerwave, it was still monitoring (though I had been able to turn it off for some reason from Garageband while using the Powerwave).  Switching this off in Audacity preferences wasn't enough to turn it off:  I had to record a track to make the settings take effect.
