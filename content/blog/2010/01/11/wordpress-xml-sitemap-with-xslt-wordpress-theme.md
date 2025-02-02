---
categories: [www]
comment_count: 2
date: 2010-01-11T10:16:30+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=157'
id: 405
modified: 2017-02-24T00:57:52-05:00
name: wordpress-xml-sitemap-with-xslt-wordpress-theme
tags: [caninelifeline, plugins, project, wordpress, xml, xsl]
---

Wordpress: XML Sitemap with XSLT Wordpress Theme
================================================

For the Canine site, we wanted to have an XML sitemap to help search engines index the site.  The sitemap can help search engines find all content on the site as well as tell it which pages are most important, how often they are updated, and when they were last modified.

There seems to be a number of plugins to generate the sitemap automatically for Wordpress, but the [Google XML Sitemaps](http://www.arnebrachhold.de/redir/sitemap-home/) plugin seems to have the highest rating and have gotten the most mention in blogs.  Jason had used this plugin already for his site, so we knew a little about it already, thus we went with it.

After some minor configuration, it worked just fine.  It regenerates a static file every time a page or post is updated.  Not as dynamic, but it saves processor time.  I doubt the plugin will work with Pods at all, since that's outside the posts/pages dataset.  Our Pods content probably won't be as important anyway.  I could potentially look into modifying the plugin if need be for that.

<!--more-->

The plugin allows us to set a custom XSLT to style the sitemap, so I decided to learn XSLT a bit better (had only worked with it on small examples for a class) and create an XSLT that will display the sitemap in our theme.  It was much more trouble than I thought, and I spent  a lot of time on it:  Not the greatest thing, since this was not at all important to the project.  The biggest trouble is that neither Firefox nor Safari will give detailed or useful error messages for XSLT or XML.  Sometimes one will give some information while the other won't, so I had to use both to find my problems.  The biggest problem was that I didn't realize all elements of the sitemap were in the sitemap namespace.  Luckily, I looked at the default XSLT provided by the plugin and saw that.

So, with all that work, I am going to tell you how I did it.

In the plugin settings, I set the XSLT sheet to "wp-content/themes/repMyThemeName/sitemap.xslt.php", the relative path from the wordpress root to a file that I created within my theme.

Sitemap.xslt.php goes as follows:

``` php
<?php
header("Content-type: text/xml;charset=iso-8859-1");
define('pagIsXSLT', true);
require_once("../../../wp-load.php");
?>
<<?php echo "?"; ?>xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9">
	<xsl:output method="html" indent="yes"
		doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
		doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" />
	<xsl:template match="/">
		<?php get_header(); ?>
		<h2>Site Map</h2>
		<table>
			<tr>
				<th>Page</th>
				<!--<th>Priority</th>
				<th>Frequency</th>-->
				<th>Last Modified</th>
			</tr>
			<xsl:for-each select="sitemap:urlset/sitemap:url">
				<xsl:sort select="sitemap:loc"/>
				<tr>
					<td><a>
						<xsl:attribute name="href">
							<xsl:value-of select="sitemap:loc"/>
						</xsl:attribute>
						<xsl:value-of select="substring(sitemap:loc, <?php echo strlen(get_bloginfo("url")) + 1; ?>)"/>
					</a></td>
					<!--<td><xsl:value-of select="sitemap:priority"/></td>
					<td><xsl:value-of select="sitemap:changefreq"/></td>-->
					<td>
						<xsl:value-of select="substring(sitemap:lastmod, 6, 2)"/>/<xsl:value-of select="substring(sitemap:lastmod, 9, 2)"/>/<xsl:value-of select="substring(sitemap:lastmod, 1, 4)"/> @
						<xsl:value-of select="substring(sitemap:lastmod, 12, 5)"/>
					</td>
				</tr>
			</xsl:for-each>
		</table>
		<?php get_sidebar(); ?>
		<?php get_footer(); ?>
	</xsl:template>
</xsl:stylesheet>
```

Important lines:

- `header("Content-type …)` sends the correct mime type for the file
- the define line is used with a change to the header file, because the `<!DOCTYPE …` is invalid in the XML file, see below.  The `<xsl:output>` defines the doctype.
- the 'wp-load' `require()` is used to load the wordpress application so we can use its functions
- the `substring()` function outputting the anchor text of each url removes the domain name
- the calls to the `get_header()`, `get_sidebar()`, and `get_footer()` functions bring in our themes template files, just like with normal templates, so you want to output those like you would normally and add anything else to the page you need to make it work.

The header.php file was then modified so that it wouldn't output the doctype statement if loaded with the XSLT file, but would otherwise.  I wrapped it in an `if` like so:

``` php
<?php if(!defined('pagIsXSLT')): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php endif; ?>
```

I may clean up the output a bit later, but I have spent too much time already, have other stuff to do.  Hope this helps somebody.  I'm tired now.

[Update 1/21/10] Hid "priority" and "frequency" fields, as they aren't needed by regular users.  Threw in time formatting as well.  I've got this basic setup to work on my own, non-Wordpress site as well (just replaced wordpress functions, etc with mine). [/update]
