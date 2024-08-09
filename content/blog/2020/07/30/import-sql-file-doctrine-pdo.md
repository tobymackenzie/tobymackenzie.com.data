---
categories: [www]
date: 2020-07-30T01:32:45-04:00
date_gmt: 2020-07-30T05:32:45+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2963'
id: 2963
modified: 2020-07-30T01:32:45-04:00
modified_gmt: 2020-07-30T05:32:45+00:00
name: import-sql-file-doctrine-pdo
tags: [database, doctrine, import, mysql, pdo, php]
---

Import SQL file in Doctrine / PDO
=================================

I recently needed to programmatically import SQL files containing database dumps into a database managed by [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html).<!--more-->  There didn't seem to be a built in way to do that, possibly due to our older Doctrine / Symfony versions.  I created a solution based on [this StackOverflow answer](https://stackoverflow.com/a/56546255) that just made use of the underlying PDO connection, and thus would also be useful for regular PDO situations.  The solution runs the SQL row by row in a transaction, so it will automatically roll back on failure.

The code for the import looks something like:

``` php
$db = $em->getConnection()->getWrappedConnection();
foreach($files as $file){
	if(file_exists($file)){
		$sql = trim(file_get_contents($file));
		if($sql){
			$db->beginTransaction();
			$count = 0;
			try{
				$querySet = $db->prepare($sql);
				$querySet->execute();
				while($querySet->nextRowSet()){
					++$count;
				}
			}catch(Exception $e){
				$db->rollBack();
				throw $e;
			}
			echo "{$file}: {$count}\n";
		}else{
			throw new Exception("File {$file} appears to be empty.");
		}
	}else{
		throw new Exception("File '{$file}' not found.");
	}
}
```

where `$em` is a Doctrine entity manager (or `$db` can be your PDO object directly) and `$files` is an array of file path strings pointing at SQL files.

This worked well for us even with multi-megabyte SQL dumps and can easily be modified for use in a Symfony command or service, as I did.
