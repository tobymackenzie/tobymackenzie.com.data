---
categories: [www]
date: 2017-04-29T20:52:47-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1461'
id: 1461
modified: 2017-04-29T20:52:47-05:00
name: answer-conditional-blocks-in-twig
tags: [answer, block, stackoverflow, templates, twig]
---

Answer: Conditional blocks in twig
==================================

Somebody asked a [StackOverflow question](http://stackoverflow.com/questions/42186007/conditionally-define-a-block-in-twig-2) about conditionally outputting blocks.  I had a similar need.  I came up with a solution that fit my need and responded with the [answer](http://stackoverflow.com/a/43702022/1139122)<!--more-->:

The `block()` function appears to return a falsey value if nothing or only white space was output in it, so you can wrap the block in a truthiness test and in the child template make sure it is empty if you don't want it to show.  Something like this worked for me:

base.html.twig:
--------------

``` twig
{% if block('left_sidebar') %}
	<div class="col-md-2">
		{% block left_sidebar %}{% endblock %}
	</div>
	<div class="col-md-10">
{% else %}
	<div class="col-md-12">
{% endif %}
```

-------

index.html.twig:
----------------

``` twig
{% block left_sidebar %}
	{% if not is_granted('IS_FULLY_AUTHENTICATED') %}
		{% include ':blocks:block__login.html.twig' %}
	{% endif %}
{% endblock %}
```
