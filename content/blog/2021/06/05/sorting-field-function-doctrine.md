---
categories: [www]
date: 2021-06-05T16:09:17-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=3424'
id: 3424
modified: 2021-06-05T16:09:17-04:00
name: sorting-field-function-doctrine
tags: [database, doctrine, php, query]
---

Sorting with `FIELD()` function in Doctrine
===========================================

I recently needed to sort query results to match the order of IDs passed to it for use in a `WHERE … IN()` clause.  In MySQL, this can be done using the [`FIELD()` function](https://dev.mysql.com/doc/refman/8.0/en/string-functions.html#function_field) in the `ORDERY BY` clause.  For Doctrine, which doesn't have the `FIELD()` function and doesn't allow functions in the `ORDER BY` clause, there's a little more work needed to make use of it.

<!--more-->

In MySQL, sorting to match a given list of IDs can be done like:

``` sql
SELECT * FROM my_table WHERE id IN(2, 3, 1) ORDER BY FIELD(id, 2, 3, 1);
```

where `id` is the field that is both matched and sorted on.  The resulting value of the function for a given row is the index position of the second or later argument that matches the first argument, ensuring the results will be returned as ID `2`, then `3`, then `1`.

The first argument to `FIELD()` is the value used in comparison, 

Doctrine doesn't have the `FIELD()` function built in, but is extensible to add new functions.  The popular [Doctrine Extensions repo](https://github.com/beberlei/DoctrineExtensions) happens to add this function, among many others.  Via composer, that can be added like:

``` sh
composer require beberlei/doctrineextensions
```

We already had it installed though, so I commenced trying to get it to work.

I quickly found out that it couldn't be done in the same way as MySQL, because of Doctrine not allowing functions in the `ORDER BY` clause.  However, it can be added to the `SELECT` clause and then used by `ORDER BY`.  `HIDDEN` can be used to prevent it from ending up in the results.  This can look like:

``` php
//…
$qb =
	$doctrine->getManager()->createQueryBuilder()
	->select('DISTINCT this, FIELD(this.id, :ids) AS HIDDEN orderBySort')
	->from('MyDB\MyTable', 'this')
	->where('this.id IN(:ids)')
	->orderBy('orderBySort asc')
	->setParameter('ids', array(2, 3, 1))
;
//…
```

This worked perfectly for our needs, and meant I didn't have to sort them in PHP like I was thinking I might need to.
