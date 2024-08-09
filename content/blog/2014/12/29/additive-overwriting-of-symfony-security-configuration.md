---
categories: [www]
date: 2014-12-29T02:26:07-05:00
date_gmt: 2014-12-29T07:26:07+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=674'
id: 674
modified: 2020-01-11T15:59:46-05:00
modified_gmt: 2020-01-11T20:59:46+00:00
name: additive-overwriting-of-symfony-security-configuration
tags: [configuration, security, symfony]
---

Additive overwriting of Symfony security configuration
======================================================

Symfony provides [a security component and bundle](http://symfony.com/doc/current/book/security.html) for managing authentication and authorization in an application.  It is versatile and powerful, if not a bit complicated.  You can toss as many mixes of authentication and authorization configuration as you want.  The important parts of the configuration cannot be overridden or added to by multiple config files, though.  This makes sense for one-off applications, where you can be sure that no bundles are messing with your security configuration.  However, if you're building something like a CMS that will be used for multiple sites, where you want the CMS's bundle to manage security, setting the configuration within the bundle will block the application itself from adding its own configuration.

One way I've found to work around this is to have the security configuration set on your bundles configuration extension instead of the 'security' extension directly, and have your bundle merge all such configurations and set them on the 'security' extension in PHP.  If you allow this configuration node to be overridden, any number of bundles can add to it and avoid the "cannot be overwritten" error.

<!--more-->

To do this, you must add a key to your bundle's configuration tree that can hold any sort of content, like:

``` php
use Symfony\Component\ConfigDefinitionBuilderTreeBuilder;
use Symfony\Component\ConfigDefinitionConfigurationInterface;

class Configuration implements ConfigurationInterface{
	public function getConfigTreeBuilder(){
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('acme_demo');
		$rootNode
			->children()
				->arrayNode('security')
					->prototype('variable')->end()
				->end()
			->end()
		;
		return $treeBuilder;
	}
}
```

You then have to grab this config and use it *before* your bundle extension's `load()` call.  I used the [prepend method](http://symfony.com/doc/current/cookbook/bundles/prepend_extension.html) of my extension.  It receives the `ContainerBuilder` before configuration is finalized.  If you want to use the same merging strategies that Symfony uses, it would look something like:

``` php
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class AcmeDemoExtension extends Extension implements PrependExtensionInterface{
	public function prepend(ContainerBuilder $container){
		$configs = $container->getExtensionConfig('acme_demo');
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);
		if(isset($config['security']) && count($config['security'])){
			$container->loadFromExtension('security', $config['security']);
		}
	}
}
```

However, the merging strategy used probably isn't the best for an additive setup.  For instance, with the 'access_control' array, numeric keys just override each other, meaning you'll be wiping out routes from the earlier bundles / configs.  I played with `array_merge_recursive()` and `array_replace_recursive()`, but didn't like those results either.  For now I'm going with something based on [Drupal's drupal_array_merge_deep()](https://github.com/drupal/drupal/blob/7.x/includes/bootstrap.inc#L2139), which would look something like:

``` php
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class AcmeDemoExtension extends Extension implements PrependExtensionInterface{
	public function prepend(ContainerBuilder $container){
		$configs = $container->getExtensionConfig('acme_demo');
		$config = $this->mergeConfigs($configs);
		if(isset($config['security']) && count($config['security'])){
			$container->loadFromExtension('security', $config['security']);
		}
	}
	public function mergeConfigs(){
		$merged = Array();
		$arrays = func_get_args();
		if(count($arrays) === 1){
			$arrays = $arrays[0];
		}
		foreach($arrays as $array){
			foreach($array as $key=> $value){
				//--push into array if numeric key
				if(is_integer($key)){
					$merged[] = $value;
				//--recursively merge if arrays
				}elseif(isset($merged[$key]) && is_array($merged[$key]) && is_array($value)){
					$merged[$key] = $this->mergeConfigs($merged[$key], $value);
				//--otherwise, new value overrides existing
				}else{
					$merged[$key] = $value;
				}
			}
		}
		return $merged;
	}
}
```

You could also take a more nuanced approach, merging each key separately with a desired merging strategy, but this approach was adequate for my purposes (at least for now).  You could also make the configuration more advanced to limit what can be added by other bundles or other constraints, specifying the children nodes allowed and putting other constraints.

To summarize, if you want to have a bundle like a CMS control security settings while allowing individual Symfony apps that use it to add their own security settings, you can do it by using your bundle's configuration extension instead of 'security'.  You just need to add a 'security' array node with a variable prototype to the configuration, grab that value in the extension's `prepend()` method, and give the merged settings to the `loadFromExtension()` method of the `ContainerBuilder`.  If you need to, you can make any of this more advanced than I did.
