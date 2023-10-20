This site is built by and for [Toby Mackenzie](/about), AKA me.  It has evolved from sites I have built for myself starting in the early 2000s or possibly late 90s.

Server
------

This site is hosted on a Dreamhost equivalent of an unmanaged VPS, which they call DreamCompute.  It runs Ubuntu, Apache, and PHP.  I use Ansible to manage server configuration and Vagrant with VirtualBox to test the config locally.

Code
----

The site is built in PHP using the Symfony framework.  The blog section uses WordPress.  I use Parsedown Extra to convert markdown content to HTML.

I use Sass and autoprefixer for building my stylesheets.  I use rollup for building my javascript.

I created my background images in Adobe Photoshop.  The icons were provided through icomoon.

History
-------

When I first started building my site, it was just experimenting locally.  The first world-accessible version was probably on [GeoCities](https://en.wikipedia.org/wiki/Yahoo!_GeoCities), though I had tried some other free hosting as well.

I had quickly discovered I wanted more server side functionality, and started working with PHP and MySQL.  I built a site with a blog that I served from my home, running on an iBook and briefly an eMac.  I used DynDNS to point a free domain name at my variable IP'd home internet connection provided by Adelphia / Windstream.  It had significant downtime sometimes.

When I started looking for a job in the industry, I decided I needed a professional site with better uptime, so I built a separate site, bought my first domain of tobymackenzie.com, and paid for hosting for the first time with Dreamhost's shared hosting.

I eventually slowed working on my personal website as I focused on the professional one.  When I moved, it went down entirely and stayed down for a while.  At one point I put it up under a subdomain, then a different domain, though some functionality didn't work or had broken.  I eventually became comfortable enough with having the content on my professional site that I merged the sites.  I brought the blog posts and some of the content over, but much of the other content and functionality has yet to be ported.

When the cost of VPS's got low enough, I decided to move to one of those for the added control and capability.
