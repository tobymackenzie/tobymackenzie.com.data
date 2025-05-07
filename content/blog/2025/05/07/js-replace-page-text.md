---
categories: [www]
date: 2025-05-07T15:13:18-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4553'
id: 4553
modified: 2025-05-07T15:13:50-04:00
name: js-replace-page-text
tags: [aprilfools, js, string, web]
---

JS: Replace page text
=====================

For this year's April Fools Day, I decided I wanted to replace some text in the content of my site's pages to something funny, weird, or confusing.  Since I'm moving toward a static site, I wanted to do this client side, which meant replacing text with JavaScript.  This would be simple with `innerHTML`, but that completely replaces the DOM with a new DOM, possibly causing usability and performance issues, and could replace text in URLs, breaking them.  Probably a better way is to loop through all nodes on the page, looking for text nodes, and replace text in each of those.  So I did this, and it worked nicely.  Thought I'd share.

<!--more-->

To get it out of the way, since we only want this to run on April 1st and are determining this client side, we have to check the date with something like:

``` js
var now = new Date();
var month = now.getMonth();
var day = now.getDate();
if(month === 3 && day === 1){
	if(document.readyState !== 'loading'){
		main();
	}else{
		document.addEventListener('DOMContentLoaded', main);
	}
}
```

That will run our `main()` function on April 1st once the DOM content is loaded.  Our `main()` function will call our function to replace strings in a DOM node, which we shall call `replaceStringInNode()`.  `main()` will look something like:

``` js
function main($el){
	if(!$el) $el = document.body;
	replaceStringInNode($el, 'toby', 'boby');
	replaceStringInNode($el, /\bcool\b/gi, 'shiny');
};
```

with all of our replacements, of course.

Now to build our `replaceStringInNode()` function.  We will loop through the DOM and look for only text nodes, which have a node type of `3`.  To handle hierarchy easily, we can call our function recursively.  So our function wrapper will look something like:

``` js
function replaceStringInNode(node, find, replacement){
	if(node.nodeType === 3 && node.textContent){
		//… handle text here
	}else{
		for(var sub in node.childNodes){
			replaceStringInNode(node.childNodes[sub], find, replacement);
		}
	}
}
```

We can replace the content of a text node by reassigning it like `node.textContent = 'new content';`.  To change the existing content with the string's [`replace()` method](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/replace).  That luckily supports a `RegExp` argument, so we can support regex without any special handling.

We want to support replacement regardless of case so that we don't have to specify a bunch of expressions to replace eg 'Cool' and 'cool' separately, so we will convert any strings to a `RegExp` with the `gi` flags by default:

``` js
if(typeof find === 'string'){
	find = new RegExp(find, 'gi');
}
```

To keep the case, eg 'Shiny' or 'shiny' depending on the original context, we will use a function as the second argument of `replace()` to do some advanced replacement.  We will loop through each character to determine its case and rebuild our replacement, matching the case of each character at that position.  Since we're building this character by character and our strings could be different lengths, we have to stick on the rest of the replacement string.  Then we return it to tell `replace()` our ending string value.  This will look like:

``` js
function(match){
	var str = '';
	for(var i = 0; i < match.length; ++i){
		var char = match.charAt(i);
		var replaceChar = replacement.charAt(i);
		if(char.match(/[A-Z]/)){
			str += replaceChar.toUpperCase();
		}else if(char.match(/[a-z]/)){
			str += replaceChar.toLowerCase();
		}else{
			str += replaceChar;
		}
	}
	if(match.length < replacement.length){
		str += replacement.substr(match.length);
	}
	return str;
}
```

Putting it all together, our `replaceStringInNode()` function would look like:

``` js
function replaceStringInNode(node, find, replacement){
	if(node.nodeType === 3 && node.textContent){
		if(typeof find === 'string'){
			find = new RegExp(find, 'gi');
		}
		node.textContent = node.textContent.replace(find, function(match){
			var str = '';
			for(var i = 0; i < match.length; ++i){
				var char = match.charAt(i);
				var replaceChar = replacement.charAt(i);
				if(char.match(/[A-Z]/)){
					str += replaceChar.toUpperCase();
				}else if(char.match(/[a-z]/)){
					str += replaceChar.toLowerCase();
				}else{
					str += replaceChar;
				}
			}
			if(match.length < replacement.length){
				str += replacement.substr(match.length);
			}
			return str;
		});
	}else{
		for(var sub in node.childNodes){
			replaceStringInNode(node.childNodes[sub], find, replacement);
		}
	}
}
```

It did what I wanted this April Fools Day.  It was fast enough to not notice, didn't cause weird focus or other usability issues that I could see, and didn't break any links.  It made for a subtly funny change to my site.  I hope this can be useful to someone else.  I'm sure this could be made more efficient, but it only happens one day a year, so I'm not too worried about that.

The results can be seen [in my site's aprilFools.js](https://github.com/tobymackenzie/tobymackenzie.com.site/blob/f5350804976dd12f84666f3b82bcc09557d124aa/src/PublicApp/scripts/aprilFools.js).
