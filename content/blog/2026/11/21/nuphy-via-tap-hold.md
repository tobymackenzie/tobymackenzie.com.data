---
date: 2026-11-21T16:02:08-05:00
categories: [computer]
tags: [keyboard, configuration]
id: 4896
name: nuphy-via-tap-hold
guid: 'https://www.tobymackenzie.com/blog/2026/11/21/nuphy-via-tap-hold.md'
---

Nuphy, QMK, Via, and tap hold
===========

While experimenting with `tmux`, I was reminded of the idea of changing the caps-lock key to a control key.  This provides quicker and less hand-contorting entering of the control key based key chords used to control `tmux`, as well as in other terminal applications and Linux and Windows GUIs.  There are ways to do this via System Settings on Mac OS, Gnome settings in that UI on Linux, OS level `kmscon.conf` for that virtual console, and other such places.  This is what I had to do for the internal keyboards on my laptops.  However, my mechanical keyboard (Nuphy Air75 v2) has a way to configure this so that it works automatically on all devices.  In fact, it can do a special tap-hold configuration where tapping does one thing while holding does another.  I found recommendations to do escape for tap and control for hold for nice `vim` access to those keys.

Nuphy, for my keyboard and a few others, used the open source QMK firmware.  That is one of the reasons I bought it over others.  The firmware allows configuration via a website, [usevia.app](https://usevia.app), with software called Via.  Unfortunately, Nuphy was never able to get their firmware upstreamed, so they require downloading things from their website.  I had trouble with this, so I'm going to write about what I did to get it working in case it helps others with Nuphy QMK boards.
<!--more-->

Via
-----

Nuphy provides [instructions for using Via](https://nuphy.com/pages/via-usage-guide-for-nuphy-keyboards) on its website.  Since their firmware was never upstreamed, one must [download a JSON file](https://nuphy.com/pages/json-files-for-nuphy-keyboards) for the correct board and upload it to the Via website.  In Via, this requires going to the "Settings" tab, enabling "Show Design tab", and then going to that tab (the paintbrush).  Click "Load" and select the file downloaded from Nuphy.

But first, to use Via, one must use a web browser with support for USB WebHID connectivity.  This seems to be relegated to Chromium based browsers currently.  Since I primarily use Firefox, I had to install Chromium (`sudo dnf install chromium`).  Even then, I had trouble.  In fact, I was never able to get it to work on Ubuntu.  I fared better on Fedora.

When pressing the "Authorize device" button on Linux, I was getting errors like "Failed to open the device" and "Received invalid protocol version from device".  This apparently has to do with permissions on one or more `hidraw` device nodes.  As a quick fix, I ran `sudo chmod go+rw /dev/hidraw*`.  After finishing, I made sure to undo this with `sudo chmod go-rw /dev/hidraw*`.  This could be done in a better way, but I just wanted to move on.

Configuration of keys is done on the aptly named "Configure" tab by clicking on a key and selecting a key action down below that it will trigger.  To do the tap-hold functionality, one must go to the "Special" actions and select the "Any" key.  A dialog will show to enter a command, in which the `MT()` function will be used.  It takes two arguments, the hold key and the tap key.  For my escape plus control, the value is `MT(MOD_LCTL, KC_ESC)`.  On my board, this must be done on both layers 0 and 2, selected at the top left.

The change will happen instantly once the dialog is submitted, so it can be tested right away, and the Via web app can be closed at any time after this.

QMK
-----

I'm not sure if this was necessary to get this to work, hence why I'm putting it below the more important Via info, but before I got Via working, because I was getting an error and was unsure if I needed it, I installed new firmware.  I think I was back on version 2.0.3, but the current version is 2.1.5.  This can be downloaded from the [Nuphy firmware page](https://nuphy.com/pages/qmk-firmwares#firmwaredetails02).  But QMK software is required to install it.  Mac and Windows have GUI applications, but on Linux this must be done via a command line app.

I did this on my Ubuntu machine.  To install QMK, I ran `sudo apt install qmk dos2unix`.  `dos2unix` is apparently required to actually use but not required by the package manager.  Once installed, run `qmk setup`.  This will clone the git repository into a `qmk_firmware` folder and then clone some required submodules.  I then ran `./qmk_firmware/util/install_udev.sh` to install some udev something.  It errored since I wasn't using `sudo`, so I'm not sure if this actually did anything for me.

The actual flashing is done with `qmk flash -b QMK_firmware_nuphy_air75_v2_ansi_v2.1.5.bin`, that last argument being the path to the downloaded bin file.  Before running, I had to put the board in a special mode by turning off, then turning on while holding escape.  For me, the command got stuck on an "Erase" progress bar that never moved, so I eventually gave up and pressed `ctl-c` to exit.  I turned the board off and then on, and the board worked.  It also had different lighting settings than before, so I don't know for sure that the new firmware was installed, but *something* happened.

Functionality
-----

Now that I've got the tap-hold functionality enabled, I've gotten a little bit of time to try it.  It is definitely cool, definitely easier to press than the regular escape or control keys since it's right on home row.  Nice for `vim` and `tmux` when I remember it.  The biggest problem is for the hold to work, I have to hold both keys for a beat, so it takes longer than the actual control key to press a chord.  This slows things down a bit, especially with `tmux` where another key must be pressed right after, and when I miss, the wrong thing happens.  It may take a bit to get used to.  Or maybe I'll be too annoyed and eventually switch it to the plain control key.  But it's a cool option regardless.
