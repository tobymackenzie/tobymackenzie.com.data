---
categories: [www]
date: 2016-09-02T00:48:27-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1243'
id: 1243
modified: 2016-09-02T00:48:27-05:00
name: php-break-argument
---

PHP 'break' argument
====================

I'm not sure if I ever knew this before, but the [PHP `break` statement](http://php.net/manual/en/control-structures.break.php) has an optional argument that declares how many levels to break out of, eg `break 2`.  For instance, in the following example, the break will break out of both loops when *the* sub-item is found:

``` php
$theSubItem = null;
foreach(getItems() as $item){
	foreach($item->getSubItems() as $subItem){
		if($subItem->isTheSubItem()){
			$theSubItem = $subItem;
			break 2;
		}
	}
}
var_dump($theSubItem);
```

ensuring that we won't loop through any extra items or sub-items.
