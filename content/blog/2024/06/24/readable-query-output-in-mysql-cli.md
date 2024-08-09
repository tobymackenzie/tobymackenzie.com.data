---
categories: [www]
date: 2024-06-24T01:21:29-04:00
date_gmt: 2024-06-24T05:21:29+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=4352'
id: 4352
modified: 2024-07-26T20:38:27-04:00
modified_gmt: 2024-07-27T00:38:27+00:00
name: readable-query-output-in-mysql-cli
tags: [cli, mysql]
---

Readable query output in MySQL CLI
==================================

I tend to prefer a GUI like Sequel Pro for looking at database data, but since Sequel Pro doesn't support MySQL 8+ and I haven't settled on an alternative, I found myself needing to use the CLI.  It also can just be faster to use for new or rarely accessed servers or whatever, and is nice and lightweight.  However, it wraps query output by default, and with many or wide columns, it can become very hard to read and figure out which data is in which column.  Recently, I went looking for something better, and found [a StackOverflow question with a couple ways](https://stackoverflow.com/a/46180255): outputting vertically, and using a pager with a nowrap option set.

<!--more-->

To get vertical output, you can replace the `;` at the end of the query with `\G`.  This has to be done on each query, and would make for very long output when outputting a lot of rows, but can be very readable for outputting one or a few rows.  This would look something like:

``` sh
mysql> SELECT ID, post_name, post_date, guid, substr(post_content, 1, 80) as post_content FROM posts limit 1\G
*************************** 1. row ***************************
          ID: 4333
   post_name: 4333
   post_date: 2024-05-21 23:13:33
        guid: https://www.tobymackenzie.com/blog/?p=4333
post_content: Another bird incident happened today.  I was walking my brother's dog, Duncan, w
1 row in set (0.00 sec)
```

With any number of columns, it would remain very easy to associate each non-wrapped column with its value.  Wrapping for longer column values can make it harder to read since it doesn't get indented, but still much better than the wrapped horizontal output.  That `\G` is a bit hard to remember though.

Another way to improve the readability is by setting the CLI's `pager` option to `less` with line wrapping disabled using the `-S` option.  This option uses an external command to display the output, in this case `less`.  Any other external command available on the system can be used instead if it produces output more to your liking.  This option can be set for a session with a command directly in the MySQL CLI like:

```
pager less -SF
```

With this set, after running a query, the output will be shown in a nice, non-wrapped table, with the normal `less` navigation abilities, such as using right and left arrow keys to scroll horizontally and see offscreen columns.  Searching with `less` is also possible using its normal `/` key functionality, as is any other of its commands.  `q` quits to get back to the `mysql` prompt.

Within `less`, this may look something like:

```
+------+-----------+---------------------+--------------------------------------------+--------------------------------------------------------------------------->
| ID   | post_name | post_date           | guid                                       | post_content                                                              >
+------+-----------+---------------------+--------------------------------------------+--------------------------------------------------------------------------->
| 4333 | 4333      | 2024-05-21 23:13:33 | https://www.tobymackenzie.com/blog/?p=4333 | Another bird incident happened today.  I was walking my brother's dog, Dun>
+------+-----------+---------------------+--------------------------------------------+--------------------------------------------------------------------------->

```

I like the `-F` option, which quits `less` and leaves the output on the screen if no scrolling is needed.  Some like the `-X` option, which doesn't clear the screen when exiting, but can leave a mess in the shell's scroll buffer if you navigate up and down a lot.

Even with MySQL's table output, line breaks in a column value still cause the line to break in the output.  This will knock later columns out of alignment with their headers.  But at least the header column doesn't wrap and each new row starts out aligned properly again.  And this pager still works with the `\G` method above, so 

The `pager` option can be made permanent by adding the setting to the OS user's `.my.cnf` file in the home directory, adding lines like:

```
[mysql]
pager='less -SF'
```

so that this will happen automatically for this user.

With these options, the CLI still isn't as nice as a GUI for looking through many / wide columns of data, but it is much improved and manageable.
