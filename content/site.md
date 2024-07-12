This site is built by and for [Toby Mackenzie](/about), AKA me.  It has evolved from sites I have built for myself starting in the early 2000s or possibly late 90s.

Server
------

This site is hosted on a Digital Ocean droplet (VPS).  It runs Ubuntu, Apache, PHP, and MySQL.  I use Ansible to manage server configuration.  I develop locally with [Vagrant](https://www.vagrantup.com/) and [VirtualBox](https://www.virtualbox.org/).  I deploy with [rsync](https://en.wikipedia.org/wiki/Rsync) using custom scripts.  This is all managed with my [server management code repository](https://github.com/tobymackenzie/tobymackenzie.srv/).

Code
----

The site is built in PHP using the [Symfony](https://symfony.com/) framework.  The blog section uses [WordPress](https://wordpress.org/).  I use [league/commonmark](https://github.com/thephpleague/commonmark) to convert markdown content to HTML.

I use [Sass](https://sass-lang.com/) and [autoprefixer](https://github.com/postcss/autoprefixer) for building my stylesheets.  I use [rollup](https://rollupjs.org/guide/en/) for building my javascript.

I created my background image in Adobe Photoshop.  The icons were made by [fontawesome](https://github.com/FortAwesome/Font-Awesome.git), [icomoon](https://github.com/Keyamoon/IcoMoon-Free), and octicons.

I use a client side syntax highlighting script for code blocks called [PrismJS](https://github.com/PrismJS/prism).  Any of my blog pages will have scripts from WordPress and JetPack that I do not vet or control.

See the [site code repository](https://github.com/tobymackenzie/tobymackenzie.site/).

History
-------

When I first started building my own site, it was just experimenting locally.  The first world-accessible version was probably on the now defunct [GeoCities](https://en.wikipedia.org/wiki/Yahoo!_GeoCities), though I had tried some other free hosting as well.  It went through several iterations.  The earliest iteration on the Internet Wayback Machine I could find is [this 2009 version](http://web.archive.org/web/20090725121956/http://geocities.com/ardotipspornguzz/) from well after my main site had moved elsewhere.

I quickly discovered I wanted more server side functionality, and found PHP and MySQL.  I built a site with a blog that I served from my home, running on an iBook and briefly an eMac.  I used DynDNS to point a free domain name at my variable IP home internet connection provided by Adelphia / Windstream.  It had downtime problems on occasion.  Here's [a Wayback snapshot](http://web.archive.org/web/20070509143247/http://cosmicosmo.ath.cx/) of it in 2007.  The styles didn't get saved.  The [2006 archive](http://web.archive.org/web/20060404121236/http://cosmicosmo.ath.cx:80/) has partial styles, but it's missing some and isn't even readable.

Looking to change career paths into the web industry, I took a class that had us create a blog to journal our task of creating the class project, a website for a non-profit.  We used wordpress.com.  This was the start of my "professional" blog, separate at the time from my personal blog.

When looking for a job in the industry, I decided I needed a more professional site with better uptime, so I built a separate site, bought my first domain of tobymackenzie.com, and paid for hosting for the first time with Dreamhost's shared hosting.

I eventually slowed working on my personal site as I focused on the professional one.  When I moved, it went down entirely and stayed down for a while.  At one point I put it up under a subdomain, then a different domain, though some functionality didn't work or had broken.  I eventually became comfortable enough with having that content on my professional site that I merged the two.  I brought the blog posts and some of the content over, but much of the other content and functionality was never ported.

I decided to move to a VPS when cost got low enough, for the added control and capability.
