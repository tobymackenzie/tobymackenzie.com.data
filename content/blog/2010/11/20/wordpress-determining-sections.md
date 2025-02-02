---
categories: [www]
date: 2010-11-20T06:20:44+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=415'
id: 443
modified: 2010-11-20T06:20:44+00:00
name: wordpress-determining-sections
tags: [cms, templates, wordpress]
---

Wordpress: Determining Sections
===============================

There are many issues encountered when using Wordpress as a CMS.  One thing that is common on regular websites is the concept of sections.  Different sections might have different highlighted or open menu items, sidebar content, layouts, or actions from the same widgets (search this section for instance).  Wordpress offers the ability to use different template files depending on the category of posts or what is selected for a page.  This is somewhat limited though, as sites might have multiple pages and categories in a section.  Wordpress also has various functions that can be used in "if" statements to determine if the current page/post matches certain criteria.  These can be logically connected in "if" statements to determine if "the_post" is in a section and placed anywhere in template files, but this requires repeating the same logic questions in every place you must determine the section, and would thus be a pain to maintain.

To keep these "if" questions in one place, I built myself a function to store them in, allowing me to ask if a page is in a section using only a name.<!--more-->  This is an excerpt from one site I worked on:

```
$GLOBALS['fncsSections'] = array();
function fncsIsSection($argName){
	global $post;
	switch($argName):
		case 'home':
			if(!isset($GLOBALS['fncsSections']['home']))
				$GLOBALS['fncsSections']['home'] = (is_front_page()) ? 1 : 0;
			return $GLOBALS['fncsSections']['home'];
		case 'adopt-a-dog':
			if(!isset($GLOBALS['fncsSections']['adopt-a-dog']))
				$GLOBALS['fncsSections']['adopt-a-dog'] = (
					is_page('adopt-a-dog')
					|| stripos($_SERVER['REQUEST_URI'], "/dogs/") > 0
					|| (fncsHasParent(10) && !is_page('mended_mutts'))
				) ? 1 : 0;
			return $GLOBALS['fncsSections']['adopt-a-dog'];
		case 'mended-mutts':
			if(!isset($GLOBALS['fncsSections']['mended-mutts']))
				$GLOBALS['fncsSections']['mended-mutts'] = (is_page('mended-mutts')) ? 1 : 0;
			return $GLOBALS['fncsSections']['mended-mutts'];
		case 'happy-tails':
			if(!isset($GLOBALS['fncsSections']['happy-tails']))
				$GLOBALS['fncsSections']['happy-tails'] = (
					is_page('happy-tails')
					|| fncsHasParent(19)
				) ? 1 : 0;
			return $GLOBALS['fncsSections']['happy-tails'];
		case 'news-and-events':
			if(!isset($GLOBALS['fncsSections']['news-and-events']))
				$GLOBALS['fncsSections']['news-and-events'] = (
					is_page('news-and-events')
					|| (is_single() && in_category('news'))
					|| is_category('news')
					|| stripos($_SERVER['REQUEST_URI'], "/events/") > 0
				) ? 1 : 0;
			return $GLOBALS['fncsSections']['news-and-events'];
		// ...
	endswitch;
}
// based on instructions from http://codex.wordpress.org/Conditional_Tags
function fncsHasParent($argParentID){
	global $post;
	
	if(is_page($argParentID)) return true;
	
	$fncAncestors = get_post_ancestors($post->ID);
	foreach($fncAncestors as $forAncestor)
		if(is_page() && $forAncestor == $argParentID) return true;
	
	return false;
}
```

This would go in the functions.php template file.  All of the section names in the "switch" statement and the conditions in the "if" statements would, of course need to be set up per site.  I cache the answers to the if questions in a global array because some of them are expensive, such as those using the "fncsHasParent" function, which requires a database call.

Some of the condition functions used include:

- is\_page: true if current page slug, id, or name matches argument
- in\_category: true if current post category slug, id, or name matches argument
- stripos: used to look in the REQUEST\_URI for a string to match URIs used for PodsCMS items
- fncsHasParent: a function I made to check if the page is a child of a certain page, specified by ID

With this, I can ask anywhere in a template file whether a page belongs to a section

```
if(fncsIsSection('mended-mutts')):
	doSomethingOnMendedMuttsSection();
endif;
```

Using the switch statement allowed me to have a condition match multiple sections.  If that is not needed, a more efficient alternative would be simply compute a single value and store it in a global value, then avoid having to run through the condition checks for every section on every page load, only the ones before the current one in a set of "elseif"s.  This could be set up like:

```
if(is_front_page()) $globalSectionName = "home";
elseif(
	is_page('adopt-a-dog')
	|| stripos($_SERVER['REQUEST_URI'], "/dogs/") > 0
	|| (fncsHasParent(10) && !is_page('mended_mutts'))
) $globalSectionName = "adopt-a-dog";
elseif(is_page('mended-mutts')) $globalSectionName = "mended-mutts";
elseif(
		is_page('happy-tails')
		|| fncsHasParent(13)
) $globalSectionName = "happy-tails";
...
function fncsIsSection(argName){
	global $globalSectionName;
	return ($argName == $globalSectionName)? 1: 0;
}
```

which would still be accessed through the same interface.
