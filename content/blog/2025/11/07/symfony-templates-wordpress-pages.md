---
categories: [www]
date: 2025-11-07T14:35:27-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=4693'
id: 4693
modified: 2025-11-07T14:35:27-05:00
name: symfony-templates-wordpress-pages
tags: [symfony, templates, wordpress]
---

Symfony templates for WordPress pages
=====================================

I've been using Symfony for all of my site pages except the blog, which is run with WordPress.  Originally I was using a standard WordPress theme that made my blog look different than the rest of my site.  I had looked into ways to pull WordPress through a controller action and stuff like that, but ran into difficulties.  I ended up using a solution where WordPress functions as normal for the subpath that it is in, but code in a custom theme boots the kernel from the Symfony part of my site and uses the twig service to render the template.  Output buffering is used to capture the normal output of the site to pass to twig.

[My theme code](https://github.com/tobymackenzie/tobymackenzie.com.site/tree/013723e60b6a64bd375be281afc3e313bff6d1ea/src/Blog) does some other things, but I will try to present a stripped down version that could work with a Symfony Standard Edition site for the purposes of this post to hopefully help others do the same.

<!--more-->

I put a `SymfonyHelper` class in my theme's `functions.php`, as that file is loaded early for every request.  I use static methods off of the class to make them easy to access in other files regardless of how they are loaded.  It has three Symfony related public methods, `getKernel()`, `getContainer()`, and `getService()`, that ultimately allow instantiating a kernel instance and getting services from its container.  It also has a static `$viewData` array that allows setting the data that will be passed to the template.  The important part of the `functions.php` looks something like:

``` php
<?php
class SymfonyHelper{
	static protected $container;
	static protected $kernel;
	static public $viewData = [];
	static public function getContainer(){
		if(!static::$container){
			static::$container = static::getKernel()->getContainer();
		}
		return static::$container;
	}
	static public function getKernel(){
		if(!static::$kernel){
			require_once(__DIR__ . '/../../../vendor/autoload.php');
			$env = (defined('WP_DEBUG') && WP_DEBUG ? 'dev' : 'prod');
			$kernel = new AppKernel($env, $env === 'dev');
			$kernel->boot();
			$kernel->getContainer()->get('request_stack')->push(Request::createFromGlobals());
			static::$kernel = $kernel;
		}
		return static::$kernel;
	}
	static public function getService($name){
		return static::getContainer()->get($name);
	}
	static public function getViewData(){
		if(!isset(static::$viewData['canonical'])){
			$request = static::getService('request_stack')->getCurrentRequest();
			static::$viewData['canonical'] = 'https://www.tobymackenzie.com' . $request->server->get('REQUEST_URI');
		}
		return static::$viewData;
	}
}
```

The theme `index.php`, which handles requests for all pages when no more specific template is created, does some setting of some `$viewData` that must come from WordPress, as well as fairly normal template operations of rendering the header, content, and footer.  It looks something like:

``` php
<?php
get_header();

$title = wp_title(null, false);
//-# wp encodes various characters.  we must convert them back for the title element, which is itself encoded in twig.
SymfonyHelper::$viewData['doc']['title'] = html_entity_decode($title, ENT_QUOTES | ENT_XML1, 'UTF-8');
ob_start();
wp_head();
SymfonyHelper::$viewData['headExtra'] = ob_get_contents();
ob_end_clean();
ob_start();
wp_footer();
SymfonyHelper::$viewData['footExtra'] = ob_get_contents();
ob_end_clean();

//… normal stuff including outputting the 'content' template part

get_footer();
```

That call to `get_header()` is above all output because `header.php` starts an output buffer to capture it.  It is as simple as:

``` php
<?php
ob_start();
```

The buffer is then captured in `footer.php` and stored in the `content` element of `$viewData`.  That would contain all output that would go in the `<main>` of a page.  The `$viewData` is then passed to twig to render a template made to handle it.  That looks like:

``` php
<?php
SymfonyHelper::$viewData['content'] = ob_get_contents();
ob_end_clean();
echo SymfonyHelper::getService('templates')->render('@Main/content.html.twig', SymfonyHelper::getViewData());
```

Note that in my example, the service I'm using is named `templates` instead of `twig`.  In Symfony 6, the `twig` service was made private, so I had to make an alias to it.  The important bit in my `services.yml` looks like:

``` yml
services:
  templates:
    alias: twig
    public: true
```

My normal twig shell template uses some of the variables in `$viewData` directly, but I have a special template, `content.html.twig`, that outputs the `headExtra`, `content`, and `footExtra` content from WordPress.  The template extends my `page.shell`, then outputs those variables in certain blocks that are output in `page.shell`.  It uses twig's `raw` filter since this is all HTML.  The template looks like:

``` twig
{% extends page.shell %}
{% block docPreScripts %}
{{parent()}}
{% if headExtra is defined %}
{{headExtra|raw}}
{% endif %}
{% endblock %}
{%block docMain %}
	{{content|raw}}
{% endblock %}
{% block docPostScripts %}
{{parent()}}
{% if footExtra is defined %}
{{footExtra|raw}}
{% endif %}
{% endblock %}
```

Booting the whole kernel is perhaps excessive just to use twig but ensures that everything the templates need, including other services and `app` stuff, are there and fully set up.  I would otherwise have to handle this in a more complicated fashion.

This works well for me.  I can modify my twig templates without worry of problems, and if I eventually move away from WordPress as planned, it will be easy to remove this code without effects on anything else.  Hopefully if someone else is stuck in this situation of wanting to render a WordPress site using Symfony templates, this can get them most of the way there.
