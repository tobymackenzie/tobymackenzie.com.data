This site is built by and for [Toby Mackenzie](/content/about.md), AKA me, though I hope some of its content can also be useful to others.  It has evolved from sites I have built for myself starting in the early 2000s or possibly late 90s.  As a [web developer](/content/web-dev), I have put a lot of time and effort into this site and take some pride in it.

Server
------

I host the site on a Digital Ocean droplet (VPS).  It runs Ubuntu, Apache, PHP, and MySQL.  I use Ansible to manage server configuration.  I develop locally with [Vagrant](https://www.vagrantup.com/) and [VirtualBox](https://www.virtualbox.org/).  I deploy with [rsync](https://en.wikipedia.org/wiki/Rsync) using custom scripts.  This is all managed with my [server management code repository](https://github.com/tobymackenzie/tobymackenzie.srv/).

The site is built in PHP using the [Symfony](https://symfony.com/) framework.  The blog section uses [WordPress](https://wordpress.org/).  I use [league/commonmark](https://github.com/thephpleague/commonmark) to convert markdown content to HTML.

See the [site code repository](https://github.com/tobymackenzie/tobymackenzie.site/).

HTML
----

I build the base HTML of my site to look good without CSS and in CLI browsers (eg lynx, w3m).  That way it should work for all browsers, even really old ones that nobody really use.  I throw some `<hr>` in there, for instance, to make it look better in these cases.  I try to make my markup semantically good for screen readers, etc.  I add some occasional wrapper elements and empty extra elements for styling purposes.  I try to make my markup theme agnostic, so I can switch themes with only changing CSS.  I have recently taken to using custom element names to shorten the overall markup when adding some non-semantically important elements.  I try to keep my regular page documents as streamlined to just the content as possible, with a minimal header and link to the site navigation that gets enhanced with JS.  I have worked toward making all of my markup static site friendly and am working toward making the whole site static or mostly static.

Styles
------

I style my site with CSS for browsers that support it.  I have multiple themes that can be switched between, though the default one has far more time and effort into it.  I try to keep things relatively light weight and simple, especially for the default theme.

I use [Sass](https://sass-lang.com/) and [autoprefixer](https://github.com/postcss/autoprefixer) for building my stylesheets.

I use a third party client side syntax highlighting script for code blocks called [PrismJS](https://github.com/PrismJS/prism).

I do have some small stylesheets that are applied for certain holidays to make my site more festive.

Scripts
-------

My site is not dependent on JavaScript, but does enhance the experience a little with it.  The main usability enhancement is that I load the navigation menu as an overlay dialog.  I also add links to jump to the page top and bottom.

I [force HTTPS using a short JS script](/content/blog/2019/09/30/forcing-https-progressive-enhancement), to ensure old browsers can still load my site.

To make my site more fun, I add a [theme switcher](https://github.com/tobymackenzie/theme-switch.js) via JS.  I add a bit of whimsy with some holiday related content and styles, and a Konami code Easter egg.

As mentioned above, I use the PrismJS third party script for syntax highlighting of code blocks.  Any of my blog pages will have scripts from WordPress and JetPack that I do not vet or control.

I use [rollup](https://rollupjs.org/guide/en/) for building my JS, which is coded in JS modules.

Since some of my site pages are statically built, and thus can't be modified by the server at request time, I have JS handle anything that must change per request in the document.  I try to keep it lightweight and limited, especially any blocking JS.

Images
------

I created my texture background image in Adobe Photoshop.  My stark theme background image was created in GIMP.  The icons are third party, made by [fontawesome](https://github.com/FortAwesome/Font-Awesome.git), [icomoon](https://github.com/Keyamoon/IcoMoon-Free), and octicons.  I try to do as much of the interface elements with CSS as possible to limit requests.

Domain
------

I buy my domains through PorkBun.  My main site is a .com, in part because it was intended to be used for professional purposes when I first bought it.  I also have a .name domain, which was used for my personal site when they were separate, and a .me for a much shorter to type and share entry point.

I use Fastmail for my domains' email.

Content
-------

I keep the content / data for my site in [its own repo](https://github.com/tobymackenzie/tobymackenzie.com.data).  The blog data is all separate from that, using a MySQL database, but I have copies of blog posts in the repo, with intention to eventually remove WordPress and build the post pages statically.  Since the content is in markdown format, which GitHub renders, that repo acts as a sort of mirror of my site that may survive the site itself.  I have links set up so that they work on GitHub and are transformed on build to work on my site.

History
-------

When I first started building my own site, it was just experimenting locally.  The first world-accessible version was probably on the now defunct [GeoCities](https://en.wikipedia.org/wiki/Yahoo!_GeoCities), though I had tried some other free hosting as well.  It went through several iterations.  The earliest iteration on the Internet Wayback Machine I could find is [this 2009 version](http://web.archive.org/web/20090725121956/http://geocities.com/ardotipspornguzz/) from well after my main site had moved elsewhere.

I quickly discovered I wanted dynamic page building and more server side functionality, and found PHP and MySQL.  I built a site with a blog that I served from my home, running on an iBook and briefly an eMac.  I used DynDNS to point a free domain name at my variable IP home internet connection provided by Adelphia / Windstream.  It had downtime problems on occasion.  Here's [a Wayback snapshot](http://web.archive.org/web/20070509143247/http://cosmicosmo.ath.cx/) of it in 2007.  The styles didn't get saved.  The [2006 archive](http://web.archive.org/web/20060404121236/http://cosmicosmo.ath.cx:80/) has partial styles, but it is missing enough to make it unreadable.

Looking to change career paths into the web industry, I took a class that had us create a blog to journal our task of creating the class project, a website for a non-profit.  We used wordpress.com.  This was the start of my "professional" blog, separate at the time from my personal blog.

When looking for a job in the industry, I decided I needed a more professional site with better uptime, so I built a separate site, bought my first domain of tobymackenzie.com, and paid for hosting for the first time with Dreamhost's shared hosting.

I eventually slowed working on my personal site as I focused on the professional one.  When I moved, it went down entirely and stayed down for a while.  At one point I put it up under a subdomain, then a different domain, though some functionality didn't work or had broken.  I eventually became comfortable enough with having that content on my professional site that I merged the two.  I brought the blog posts and some of the content over, but much of the other content and functionality was never ported.

I decided to move to a VPS when cost got low enough, for the added control and capability.
