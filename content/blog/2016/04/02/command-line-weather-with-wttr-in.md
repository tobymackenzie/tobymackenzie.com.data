---
categories: [computer]
date: 2016-04-02T00:31:38-05:00
guid: 'http://tobymackenzie.name/log/?p=353'
id: 353
modified: 2016-04-02T00:31:38-05:00
name: command-line-weather-with-wttr-in
tags: [ascii, commandline, site, weather]
---

Command-line weather with wttr.in
=================================

Cool, lightweight, and simple ASCII weather forecast site that can be `curl`ed:  [wttr.in](http://wttr.in).  It does user-agent sniffing to show plain, colored text for `curl`, `wget`, and the like so that it looks nice on the command line, while browsers get HTML with a similar appearance.  The "home page" does IP lookup to guess your location.  Results of `curl wttr.in/cleveland`:

![nicely formatted ASCII weather forecast](https://www.tobymackenzie.com/log/wp-content/uploads/2016/04/wttr.in-cli-1.png)
