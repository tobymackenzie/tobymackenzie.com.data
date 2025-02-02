---
categories: [www]
date: 2010-08-21T05:03:47+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=373'
id: 436
modified: 2023-06-19T23:30:23-04:00
name: php-outputting-lists-in-arbitrary-number-of-columns
tags: [columns, php]
---

PHP: Outputting Lists in Arbitrary Number of Columns
====================================================

For lists of narrow pieces of content, it can make sense to put them in multiple columns to better use available space.  For things like image galleries (a list of images), where it tends to be easier to read from right to left, or when order is irrelevant, it is easy to turn a regular list into columns (like a grid in the case of the images) by simply making each item a fixed width and height and then floating the items left.  This works fine back to IE6 and remains fully semantic and accessible as one list.

Text lists tend to be easier to read top to bottom though, so when they are in alphabetical or some other important order, it is generally better to order them top to bottom in each column.  I haven't delved into the [CSS3 multi-column layout abilities](http://www.w3.org/TR/css3-multicol/) yet, as that is not widely supported (especially no IE).  The float item method cannot be made to appear in the proper order while truly keeping the items in proper order in the list for accessibility and semantics, and putting the data in the proper improper order to make that work would be complicated anyway.  The only real way I am aware of to currently make the columns be in proper order is to separate the list into a list for each column and then float each column left.  This is not ideal semantically and for accessibility, but will still read in the proper order for all users.

<!--more-->

Having needed to output lists in such a fashion on several sites recently, I decided to make a piece of script (PHP in this case, though it will migrate easily to most any language with arrays or the like) to handle the separation of lists into columns with a desirable number of items in each.  If there are an even number of items for each column, then that's what each column should get.  If there is an uneven number, then I feel it best that each column should get almost even numbers, except that the leftmost columns should be given one more item until there aren't any extra.  Purely out of interest, as I only needed this to work for two or three columns, I wrote my script to handle any number of columns by simply changing a single variable.  Here it is:

``` php
<ol class="itemlist column column1">
<?php
$columns = 3; // set this

$arraySize = count($array);
$itemcount=1;
$modolus=$arraySize%$columns;
$columncount=1;
$columnSizeBase = $arraySize/$columns;
$arrayColumnSizes[1] = ceil($columnSizeBase);
for($i=1;$i<$columns-1;++$i){
	if($modolus - 1 != 0){
		$arrayColumnSizes[] = ceil($columnSizeBase);
		$modolus -= 1;
	}
	else
		$arrayColumnSizes[] = floor($columnSizeBase);
}
$arrayColumnSizes[$columns] = ($modolus == 0)? ceil($columnSizeBase): floor($columnSizeBase);
for( $i=0; $i < $arraySize; ++$i ) {
?>

	<li class="item"><?php echo $array[$i]; ?></li>

<?php
	if(($itemcount==$arrayColumnSizes[$columncount]) && $i < $arraySize - 1){ $itemcount=1;++$columncount;
?>
</ol><ol class="itemlist column column<?php echo $columncount; ?>">
<?php 
	}else{$itemcount++;}
} 
?>
</ol>
```

You simply need to supply an array of items and set the number of columns with the `$columns` variable.  You also may need to change the classes of the lists:  I often set a class like "twocolumns" or "threecolumns" so that I can target them differently for column widths and padding.  These unfortunately must be changed in two places.

This should be pretty efficient, as it just has to do a small number of calculations plus one for each column.  I can't think of a more efficient way, but if you know of one, let me know.

Oh yeah, and in constructing this post, I determined that my lists should be `ol`'s instead of `ul`'s, since they are in fact ordered.  The numbers can be removed with CSS, since they are irrelevant in my use cases.  I will have to change this in my codebase and on the sites I can.
