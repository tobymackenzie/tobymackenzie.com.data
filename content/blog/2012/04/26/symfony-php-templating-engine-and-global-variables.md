---
categories: [www]
date: 2012-04-26T11:17:09+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=490'
id: 490
modified: 2017-02-02T18:04:00-05:00
name: symfony-php-templating-engine-and-global-variables
tags: [php, symfony, templates, todo]
---

Symfony: PHP Templating Engine and Global Variables
===================================================

At [Cogneato](http://cogneato.com/), we are using Symfony's PHP templating engine to render our views for compatibility with our existing system and for allowing our developers to continue using the same language they're used to.  I was looking for a way to make various services and other "variables" globally available in all view files, like can be done for Twig as mentioned in [this cookbook](http://symfony.com/doc/current/cookbook/templating/global_variables.html).  I [asked on Stack Overflow](http://stackoverflow.com/questions/8791715/symfony2-global-variables-in-php-templating-engine), but didn't get what I was looking for.  We came up with our own solutions.  I provided some as my own answer to that question.  I will discuss  the ones I can think of in this post.

Container
---------

The one answer to my Stackoverflow question pointed out that the `$view` object has a `container` member object that has services available, and you can also access parameters set in your configuration file.  Services would be accessed like (I believe):

<!--more-->

``` php
$view->container->get("myservice")->myFunction();
```

and parameters would be accessed like:

``` php
$view->container->parameters['myparameter'];
```

The parameters would be set up in config.yml or another configuration file like:

``` yaml
parameters:
	myparemter: 'myvalue'
```

This will also be available to any view file and requires very little work, especially for services, though the interface cannot be changed if you need to adhere to an existing or specific one, and is a bit verbose.  The parameters are limited to simple data types.

PHP Template Helpers
--------------------

The PHP rendering engine has what're called "helpers", which you can access via array keys of $view, like:

``` php
$view["foo"]->doSomething();
```

We created a class for easily making services into helpers:

``` php
use Symfony\Component\Templating\Helper\Helper as BaseHelper;

class Helper extends BaseHelper{
    protected $name;
    public $service;

    public function __construct($name, $service){
        $this->name = $name;
        $this->service = $service;
    }
    public function __get($name){ 
        if(isset($this->service->$name)){
            return $this->service->$name;
        }
    }
    public function __call($name, $arguments){
        if(method_exists($this->service, $name)){
            return call_user_func_array(array($this->service,$name), $arguments);
            
        }
    }  
    public function getName(){
        return $this->name;
    }

}
```

Then in our configuration under the services we'd add:

``` yaml
helper.foo:
	class: %helper.class%
	arguments:
	    name: "foo"
	    helper: "@foo"
	tags:
	    - { name: templating.helper, alias: foo }
```

This would theoretically then be available to any view files, even those with controllers you don't have control of, but of course the interface will be through `$view`, so this won't work if you have an existing interface to fit.  This will also only work for services or similar objects.

Override controller render function
-----------------------------------

If you create a base controller that all others inherit from, you can override symfony's render function and add keys to the parameters argument, like:

``` php
public function render($view, array $parameters = array(), Response $response = null){
	if(!array_key_exists("bar", $parameters){
		$parameters["foo"] = $this->get("foo");
	}
	if(!array_key_exists("bar", $parameters){
		$parameters["bar"] = $this->get("bar");
	}
	return parent::render($view, $parameters, $response);
}
```

This will make these "global" variables available in all views rendered by any of your own controller actions, though they'll not be available in those rendered by controllers you don't create (of course, those'll likely be done in Twig anyway and you can use the normal twig means of adding globals).  We didn't end up using this method.  I'm not sure why, but possibly because we were happy enough with the helpers for services and the following method for globals from our old system.

Pull through a single controller action
---------------------------------------

In a [previous post](/content/2012/04/13/using-symfony-alongside-an-existing-system.md), I talked about a way to initialize an existing system and then render a controller action that will pass `$GLOBALS` to the view so that everything that was set up by the other system will be available in the view as it had been with the other system.  I think this is the only way to handle making the globals from an old system available in a Symfony view file without modifying the old system.  See the other post for more details.
