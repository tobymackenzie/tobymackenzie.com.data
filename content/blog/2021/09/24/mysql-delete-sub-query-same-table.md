---
categories: [www]
date: 2021-09-24T11:27:17-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=3512'
id: 3512
modified: 2021-09-24T11:27:44-04:00
name: mysql-delete-sub-query-same-table
tags: [mysql, problem, query, solution]
---

MySQL: DELETE with sub-query on same table
==========================================

I had an issue with a MySQL query containing a sub-query recently where it worked fine when done as a `SELECT` query, but gave an error when switching it to a `DELETE` query.  The error given was something like 'You can't specify target table "items" for update in FROM clause'.  The sub-query was referencing the same table as the main query, which apparently can't be done directly in MySQL because the table will be modified during deletion.  But there is a [sort of a hack I found in this StackOverflow answer](https://stackoverflow.com/a/5816887), among others, to force it to create a temp table and allow it to work.

<!--more-->

The query selected items with some conditions including being the only item in a given list, that being where the sub-query came in.  The original query looked something like this:

``` sql
SELECT *, (
	SELECT COUNT(i2.id) FROM items i2 WHERE i2.list_id = il.id
) AS icnt
FROM items i
LEFT JOIN item_lists il ON il.id = i.list_id
WHERE i.condition = 'value'
AND (
	SELECT COUNT(i3.id) FROM items i3 WHERE i3.list_id = il.id
) = 1
```

Just changing the `SElECT` part to `DELETE i` gave the "target table" error.  To make it work as a `DELETE` query, I had to modify the sub-query to have its own nested sub-query.  This is what forces the temp table to be created.  The inner sub-query cannot reference tables from the main query though, so I had to put that part in the outer sub-query.  The end result looked something like this:

``` sql
DELETE i
FROM items i
LEFT JOIN item_lists il ON il.id = i.list_id
WHERE i.condition = 'value'
AND (
	SELECT COUNT(i3.id) FROM (
		SELECT id, list_id FROM items i4
	) AS i3 WHERE i3.list_id = il.id
) = 1
```

It did what I wanted.  This would also have to be done for an `UPDATE` and presumably `INSERT` query.  Hopefully I'll be able to remember this the next time I encounter it.
