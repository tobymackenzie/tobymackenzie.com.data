---
categories: [computer]
date: 2024-10-29T17:22:08-04:00
date_gmt: 2024-10-29T21:22:08+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=4459'
id: 4459
modified: 2024-10-29T17:22:08-04:00
modified_gmt: 2024-10-29T21:22:08+00:00
name: mac-app-launch-keyboard-shortcuts
tags: [mac]
---

Mac: create app launch keyboard shortcuts
=========================================

I wanted to create some global keyboard shortcuts for launching apps on MacOS.  I used to do this with Quicksilver, but I've stopped using that and now just use Spotlight for most of what I used that for.  Spotlight, of course, doesn't have all the features of Quicksilver, including keyboard shortcuts for arbitrary actions.  The "Keyboards Shortcuts" pane in System Settings can do a lot, but not specify a specific app to launch.  Searching around the web, I found that Automator could be used to add services to it.  So a flow to do this for an app would be like:

<!--more-->

1. open Automator
2. create new Quick Action
3. add Launch Application task
4. select application from dropdown, or drag from finder (need to do so for Finder.app, Terminal.app, some third party apps.  Can use finder search to find.)
5. save, give name like "Open app-name"
6. open Keyboard Shortcuts in System Settings
7. select Services, open General in list
8. find Automator action name we just created, click "none" to right, enter keyboard shortcut
9. click Done button

I set up these shortcuts for frequently used apps:

- Finder: `cmd-opt-ctl-f`
- MacVim: `cmd-opt-ctl-v`
- Terminal: `cmd-opt-ctl-space`

For some reason, this is a bit slow (like a second), but doesn't require any third party software.  It launches the app if it isn't and brings it to the foreground, as I wanted.  I'm not sure if this works on older MacOS versions, but works in MacOS Sonoma (14) and Sequoia (15).
