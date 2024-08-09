---
categories: [www]
date: 2009-12-27T17:00:06+00:00
date_gmt: 2009-12-27T17:00:06+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=145'
id: 402
modified: 2021-01-14T23:37:51-05:00
modified_gmt: 2021-01-15T04:37:51+00:00
name: php-parser-rss-feed-wordpress-com
tags: [parse, php, rss, wordpress]
---

PHP Parser for RSS Feed From Wordpress.com
==========================================

I've been working on my own site a bit since getting out of school.  I've been pulling an RSS feed from this blog onto my homepage for a while now, using something based off of [this script](http://matthom.com/archive/2007/09/18/use-php-to-display-any-rss-feed-on-your-site).  I try to keep the markup valid.  The feed has given me a bit of troubles for valid markup, mainly with escaping ampersands.  One problem was that I was using this function:

``` php
function pagFixRSSEncoding($argString){
	return mb_convert_encoding($argString,'HTML-ENTITIES', 'UTF-8');
}
```

which I had gotten from somewhere.  I'm not sure what it does, but it seems to do nothing for me.  I removed it, though I'll reinstate it or look for something else if characters other than ampersands give me trouble.

I was also using this function:

``` php
function pagFixLinks($argString){
	return str_replace("&", "&", $argString);
}
```

to fix the ampersands in the "link".  This simply replaces all ampersands with the proper HTML entity in the passed string, works just fine.

<!--more-->

It fails for the "description", ie the content, because all HTML entities already are escaped in that element.  But Wordpress.com places an image at the end of the "description" element for stats purposes.  It contains ampersands that are not escaped.  It also contains the illegal border attribute.  After a good bit of time working on my regex and then figuring out how to run a function on the result, I made this function to fix the stats image element so that it can validly be inserted into XHTML:

``` php
function pagFixWordpressStats($argString){
	$fncString = $argString;
	$fncString = preg_replace_callback('/(stats.wordpress.com.*?")/i', "pagFixLinksForPregReplaceCallback", $fncString);
	$fncString = str_replace(" border=\"0\"", "", $fncString);
	return $fncString;
}
```

It fixes the ampersands only for that image link with the `preg_replace_callback` function.  The callback is to this wrapper function for the above `pagFixLinks` function:

``` php
function pagFixLinksForPregReplaceCallback($argString){
	return pagFixLinks($argString[1]);
}
```

The `str_replace` line simply removes the invalid border attribute.

I didn't even notice that callback version of `preg_replace` for a while.  I was missing the "/" at the beginning and end of the pattern parameter as well: not used to the PERL version of regular expressions, I guess.

I hope this helps somebody.  I guess I might as well post the whole parser to be sure:

``` php
function pagFixLinks($argString){
	return str_replace("&", "&", $argString);
}

function pagFixLinksForPregReplaceCallback($argString){
	return pagFixLinks($argString[1]);
}

function pagFixWordpressStats($argString){
	$fncString = $argString;
	$fncString = preg_replace_callback('/(stats.wordpress.com.*?")/i', "pagFixLinksForPregReplaceCallback", $fncString);
	$fncString = str_replace(" border=\"0\"", "", $fncString);
	return $fncString;
}

function fncGetRSSFeedAndFormat($argURL){
	// script based from: http://matthom.com/archive/2007/09/18/use-php-to-display-any-rss-feed-on-your-site
	# INSTANTIATE CURL.
	$curl = curl_init();

	# CURL SETTINGS.
	curl_setopt($curl, CURLOPT_URL, $argURL);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

	# GRAB THE XML FILE.
	$xmlFeed = curl_exec($curl);

	curl_close($curl);

	# SET UP XML OBJECT.
	$xmlObjFeed = simplexml_load_string( $xmlFeed );

	$tempCounter = 0;

	$temp = "";
	$max_title_length = 30;

	foreach ( $xmlObjFeed->channel->item as $item )
	{
		$temp .= "\n<div class=\"post\">";
		// title
		$temp .= "\n<h3><a href=\"".pagFixLinks($item->link)."\">".pagFixLinks($item->title)."</a></h3>";
		$temp .= "\n<div class=\"date\">"
			.date('d M Y', strtotime((string) ($item->pubDate)))
			." <span class=\"time\">@".date('h:i A', strtotime((string) ($item->pubDate)))
			."</span></div>";
		// post
		$temp .= "\n<div class=\"content\">".pagFixWordpressStats($item->description)."</div>";
		$temp .= "\n<div class=\"more\"><a href=\"".pagFixLinks($item->link)."\">Read Full Post</a></div>";
		$temp .= "\n</div><!-- post -->\n";
		$output .= $temp; // append to output
		$temp = "";
	}

	return $output;
}
```

It is just a function calling a couple other functions.  I may objectify it later, but it currently contains all output markup, so it would have to be modified to allow for custom surrounding markup.  Hopefully Worpress didn't muss it up too much.
