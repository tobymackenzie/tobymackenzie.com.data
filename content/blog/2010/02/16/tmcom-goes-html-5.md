---
categories: [www]
comment_count: 2
date: 2010-02-16T14:55:49+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=255'
id: 417
modified: 2024-06-20T21:53:40-04:00
name: tmcom-goes-html-5
tags: [doctype, html, html5, role]
---

TMCom Goes HTML 5 (Doctype anyway)
==================================

I've finally joined the bandwagon and moved my site to the HTML 5 doctype.  It is much simpler than previous doctypes:

```
<!DOCTYPE html>
```

breaking away from the SGML standard of including a reference to the DTD for that doctype.  I'm not sure how this will play out as HTML moves beyond 5, but I'm sure it won't be a problem for a while anyway.  And hopefully with all this time they are taking to finalize the specifications, we won't have problems with backward compatibility, future expansion, validation of old documents, etc.

Anyway, I had considered using the doctype a while back but abandoned it for reasons I don't remember.  The ["role" attribute](http://www.w3.org/TR/xhtml-role/), which I first noticed in Wordpress themes, is what got me to consider HTML 5 again.  It offers potential accessibility benefits to user agents that know about it by specifying what an elements "role" is in relation to its document: navigation, banner, main, contentinfo, etc.  HTML 5 offers elements with similar meanings, but they are not supported well.  The attribute is not valid in XHTML 1 (it was proposed for XHTML 2, which never came about), and my attempts at an [alternative doctype](http://www.alistapart.com/articles/waiaria) failed.

<!--more-->

So after some research, I determined the HTML 5 doctype would allow for the role attribute and be generally compatible with good semantic markup.  My site was already valid XHTML 1.0 Strict, and almost validated with no modification, except for the xml declaration at the top of my page and the "profile" attribute of "head" that I was using for the XFN and hCard [microformats](http://microformats.org/), as well as something on my homepage.  My recent addition of an [XML sitemap with XSLT](https://tobymackenzie.com/blog/2010/01/11/wordpress-xml-sitemap-with-xslt-wordpress-theme/) plus my general like of XML made me concerned about removing the XML declaration, plus I had just added those microformats and didn't want to mess them up.  And I was concerned about backwards compatibility issues.  So I stayed with XHTML and noted in my statement of validity "Valid XHTML (except role)" and had slightly invalid markup.

Just recently, as I was modifying some meta information in my headers, I decided to try again for the HTML 5 doctype.  I discovered that the standard method for dealing with the "profile" attribute was to use a "link" tag with a "rel" of "profile" for each profile instead.  I decided it would be fine to ditch the XML declaration for now (as far as I can tell, it should be valid) since it is irrelevant for my sitemap.  I also was assured that even IE6 will go into "almost standards mode".

To make it very easy to change back, just in case I didn't want to stay with it, and to enjoy some of my excess free time, I built a switch setup into my header (and footer) to switch doctypes.

```
if(!defined('pagIsXSLT')):
	if(Config::$doctype != 'html5')
		echo '<?xml version="1.0" encoding="utf-8"?>'."n";
	switch(Config::$doctype):
		case 'html5':
?>
<!DOCTYPE html>
<?				break;
		case 'xhtml strict':
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?				break;
		case 'xhtml custom':
?>
<!DOCTYPE html PUBLIC "-//TMCOM//DTD XHTML 1.1 Strict//EN" "http://learningtheworld.eu/dtd/xhtml-role-state.dtd">
<?				break;
		endswitch;
endif; 
?>
```

That sets the doctype based on the "Config::$doctype" variable (from my configuration file) and includes the XML declaration if not HTML 5.  To deal with the profile bit, I check the variable again to output in the "head" or the "link rel" format:

```
<head <?if(Config::$doctype!='html5'):?>profile="http://gmpg.org/xfn/11 <?=$argHeadProfile?>"<?endif;?>>

...

<?	if(Config::$doctype == 'html5'): ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
<?		if(!empty($argHeadProfile)):
			$fncHeadProfile = explode(" ", $argHeadProfile);
			foreach($fncHeadProfile as $forHeadProfile):
?>
	<link rel="profile" href="<?=$forHeadProfile?>" />
<?			endforeach;
		endif;
	endif;
?>
```

In this case, I always output the XFN profile, and output others depending on the page settings of a space delimited list.  I threw in handling my footer "Valid" text:

```
<?	if(Config::$doctype == 'html5'): ?>
				<a class="external" href="http://validator.w3.org/check?uri=referer">HTML 5</a>
<?	else: ?>
				<a class="external" href="http://validator.w3.org/check?uri=referer">XHTML</a> (except <a href="http://www.w3.org/TR/xhtml-role/">role</a>) 
<? endif; ?>
```

Just having fun, that will need to be removed eventually for efficiency purposes.

Only problem I've noticed so far is rendering in Opera: my footer disappears for some reason.  I can't test in IE at all though (no Windows computer), so I'll have to do that at some point to be sure of this move.

Now I should be able to more easily move into the future.  I'll add HTML 5 stuff as it becomes widely supported or can gracefully degrade (IE).  I'll be paying more attention to HTML 5's movements as well in decisions I make about changes.  Hopefully this HTML 5 will improve things for us developers and web users.

[Update 2/23] Clarified purpose of role attribute, other minor changes [/update]
