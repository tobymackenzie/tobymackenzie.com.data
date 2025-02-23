---
categories: [www]
date: 2025-02-22T16:26:19-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=4518'
id: 4518
modified: 2025-02-22T23:38:44-05:00
name: starting-with-magento-react
tags: [advice, learning, web-development]
---

Starting with Magento / React JS
================================

My cousin expressed interest in learning Magento and React JS.  I know neither, but I wrote up some related web development info that might be helpful for him.  He would be working on a Windows machine.  He also asked about setting up a home file server.  Since this all might also be useful to someone else, I'm adding it here:

Here are some notes on web development stuff that you might find useful.

<!--more-->

Browser: Chrome, Firefox, et al have good developer tools with F12 or inspect element.  In web development these will be used a lot and you can learn a lot about a page from them.  You can create a '.html' file on your disk and load it in a browser for a quick development setup.

Codepen: A website with browser based web code editors for HTML, CSS, and JavaScript and a renderer, sort of a one page development environment.  Allows including and automatic processing of some libraries / frameworks for those languages.  Probably the easiest way to play with client side development for a beginner.

Text editor: Primary programming tool unless you use an IDE.  Code is usually just text files.  I use Vim, but that's a pretty steep learning curve.  VSCode or Notepad++ should be good on Windows.  VSCode is more advanced and has lots of plugins.  If you want to learn Vim, I can provide more info.

Client / Server: Web is done with a client server architecture.  The client is the browser, which runs HTML, CSS, and JS.  The server sends stuff to the client, often building web pages with code getting data from databases, or just grabbing static files.

HTML: Structure of all web pages / apps.  React uses an HTML-like syntax for JSX, so knowing the basic structure is good, but knowing some basic regular tags is useful as well.

CSS: Style of web pages.  React often uses abstractions for styles, but they are still similar to CSS, so it is good to know them.

JavaScript (JS): The programming language of the web for client side, and also what React is built in.  Good to learn the basics of the language even if you are only using it through React.  Also used on the server side with Node and others.

PHP: Server side programming language that I primarily use and also what Magento is built in.

React: I don't have much experience with this but it is sort of structured development with JS.  You'd usually use special syntax like JSX for templates with it, which requires build tools, so you'll probably have to make use of command line stuff and npm and figure out how to do a build.

Apache / Nginx / Node / Express: Web server software.  You would usually have one of the first two running a PHP website.  Express is written for Node and would be used for server side rendering of React apps.

MySQL / database: Where you store any data that is more complicated than simple files or need advanced queries to sift through it.  MySQL would be what Magento uses.  You might use something different for React.  There are a lot of them.

Command Line:  If you're going this in Windows, Windows has Powershell, but I'm not sure if that is the easiest way for working with the common build tools of the web.  There is WSL which I hear is very good for getting a simple Linux-based command line and related tools.

NPM / Node: A server side JS engine and related package manager to get common Node software with.  This is very common to use to get React and any dependencies and then do your build with.  Also may be used for server side rendering of React apps.

Open Source: Lots of software in the web world is written as open source, free to use, including Magento and React.  If you get into doing commercial work, you'll have to pay attention to the licenses used, because some, like GPL, can require your own software to be open source.  Lots of open source software projects are stored and managed on Github.

Git: Git is a version control system used for software.  If you do this professionally you'll no doubt have to learn git, basic commands like `git pull`, `git push`, `git add`, `git commit`, and `git log`.  There's some GUI software for working with this including some built in stuff.

Github: Most popular online git service, has free accounts.  Even if you don't create an account, you will probably visit here to see some software that you'll use.

Resources:

- [MDN](https://developer.mozilla.org/en-US/): Lots of general web development related info for HTML, CSS, JS, and some related stuff.  They do have a curriculum section that can help learn it.
- [Stack Overflow](https://stackoverflow.com): great place for asking questions or finding answers to already asked questions.
- [Magento docs](https://developer.adobe.com/commerce/docs/) and [React quick start](https://react.dev/learn): probably good places to start for learning those.

Regarding the file server you were thinking of, NextCloud, OwnCloud, and FreeNAS are among the larger open source projects for running that sort of thing with advanced features.  You can of course go very simple with just a hand coded HTML page linking to files you manually add to the server when you're at home, which would have a fairly minimal attack surface from outside.  A homelab is what some people call a home file server, which can help for finding information about this sort of thing, like at <reddit.com></reddit.com>.  You'd probably want to password protect access to it or at least any files that copyright would be an issue for.

You can also set up a similar server on a hosted platform.  You can get a VPS server for around $6/month to put it on.  Storage would of course be more limited there, like 25 GB for that price.  I use Digital Ocean for the server my website is run on.
