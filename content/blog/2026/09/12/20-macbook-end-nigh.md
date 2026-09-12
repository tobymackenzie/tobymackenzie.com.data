---
date: 2026-09-12T00:40:36-04:00
categories: [computer, www]
tags: [mac, problem, homebrew, update, macbook]
id: 4887
name: 20-macbook-end-nigh
guid: 'https://www.tobymackenzie.com/blog/2026/09/12/20-macbook-end-nigh.md'
---

2020 Macbook Air, the (secure, up-to-date) end is nigh
=======

Wednesday, the same day that Apple announced some new products, updates, and what-not, I noticed a message from [Homebrew](https://brew.sh/) that my [2020 Macbook Air](https://everymac.com/systems/apple/macbook-air/specs/macbook-air-core-i3-1.1-dual-core-13-retina-display-2020-scissor-specs.html) (Intel) is no longer officially supported by the project.  I've still been able to update things, just needing to build more from source, but it will become fully unsupported in Fall 2027.  Apple will still provide MacOS 15 Sequoia with security updates to that same approximate date.  So that provides a likely end to when my Macbook can be considered up-to-date and secure.
<!--more-->

The message from Homebrew is:

```
Warning: You are using macOS on Intel x86_64.
We do not provide support for this platform (as-of September 2026, announced August 2025).

Apple have dropped Intel x86_64 support in macOS Golden Gate (27).
GitHub Actions are dropping macOS Intel x86_64 runners in 2027.
Homebrew is a non-profit project run entirely by volunteers, not employees.
If the biggest companies in the world cannot support macOS Intel x86_64
any longer, sadly neither can we.

You will have better luck with MacPorts which still supports macOS Intel x86_64:
  https://www.macports.org
```

I vaguely remember seeing something about this eventually happening a while back (I guess [this post last November](https://brew.sh/2025/11/12/homebrew-5.0.0/), but had largely forgotten about it.  I guess they had planned this for September, but had to jump to it a few days early because of [some GitHub CLI issue](https://github.com/orgs/Homebrew/discussions/7044#discussioncomment-18231338).

Their [support tiers page](https://docs.brew.sh/Support-Tiers#future-macos-support) provides more detail about the new state of things.  My computer has jumped from Tier 1 to Tier 3 support.  This means there will be no official support and no pre-built packages for anything new.  Things can break without any support from them.  I'm not sure how this will affect casks (generally GUI apps).

I use Homebrew for a lot of web development software and most other third party software.  Examples include PHP, Composer, PHPUnit, Tmux, Rsync, Firefox, MacVim, Gimp, Libre Office, and Sequel Ace.  So really, stuff I use a lot for both work and personal computing.  If any of these break, I will probably have to switch to [MacPorts](https://www.macports.org/), which has longer support windows, or direct updates through the apps' own mechanisms.

I used to use MacPorts, but it has to build basically everything and thus takes a really long time.  Of course, it sounds like that will be how Homebrew will work going forward as well.  MacPorts also requires being set up and run by root, which will complicate my security setup.

I've been planning on and working towards moving primarily to Linux, and this gives me a sort of push and time-frame to make that happen.  Transferring all the data will be a pain, and some of it won't really transfer.  I will likely keep the MacBook for some stuff.  Also, my boss has wanted me on Mac so far, and if he doesn't want me to develop on Linux, I will have to use the less secure Macbook or he'll have to get me a company laptop, and I will need to frequently carry around two laptops or rework how I do things.
