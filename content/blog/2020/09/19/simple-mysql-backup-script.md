---
categories: [computer, www]
date: 2020-09-19T01:02:01-04:00
date_gmt: 2020-09-19T05:02:01+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3043'
id: 3043
modified: 2023-06-27T23:39:53-04:00
modified_gmt: 2023-06-28T03:39:53+00:00
name: simple-mysql-backup-script
tags: [backup, database, mysql, script]
---

Simple MySQL backup script
==========================

I made a simple `bash` backup script for the newer MySQL database servers at Cogneato.<!--more-->  We moved to Ubuntu servers for our newer sites, which doesn't have [holland](https://hollandbackup.org/) in its default repos like CentOS.  Ubuntu's [automysqlbackup](https://sourceforge.net/projects/automysqlbackup/) seemed less flexible and transparent.  Wanting something with normal sql dumps, instead of [what I use for my own server](https://github.com/tobymackenzie/server-tobymackenzie.com/blob/51232f91b42a7ec79359fbf952950ab03b343b04/assets/home/backup/bin/db-backup.j2), I decided to make a quick shell script.

The script runs on a cron, and basically:

1. Removes previous latest backup (because of hard links)
2. Queries for list of databases
3. Loops through databases and dumps to a gzipped file in the latest backup directory
4. Does a hard link copy with date named folder for hourly, daily, weekly, monthly, and yearly periods, if applicable

We do the backup directly on the server, and use snapshots to back them up remotely.  We have created a `backup` database user with only `SELECT` privileges on all tables to use for the dumps, something like:

``` sql
CREATE USER 'backup'@'127.0.0.1' IDENTIFIED BY 'p455w0rd';
GRANT SELECT ON *.* to 'backup'@'127.0.0.1';
FLUSH PRIVILEGES;
```

We are using the user dotfile `.my.cnf` to store the credentials, which can look like:

```
[clientbackup]
user=backup
password=p455w0rd
```

with a `chmod 600` to limit prying eyes.

If running as `root`, we can save our script to `/root/bin/db-backup` and then set up our cron job with `crontab -e`, to run every, say, 8 hours:

```
5 */8 * * * test -x /root/bin/db-backup && /root/bin/db-backup
```

We might create our backup folder in `/var/backups/db`:

``` sh
mkdir /var/backups/db && chmod 750 /var/backups/db
```
Our backup script looks something like:

``` bash
#!/bin/bash
backupPath=/var/backups/db
keepHourly=3
keepDaily=6
keepWeekly=3
keepMonthly=4
keepYearly=5

#--prep folder
latestDate=`date +%y%m%d-%H%M`
latestPath=${backupPath}/_latest
mkdir -p ${latestPath}
tmpPath = ${backupPath}/_tmp
mkdir -p ${tmpPath}
rm -rf ${tmpPath}/*

#--grab db names
dbNames=`echo 'SHOW DATABASES' | mysql --defaults-group-suffix=backup`
readarray -t dbNames <<<"$dbNames"
for db in "${dbNames[@]}"
do
	case "$db" in
		Database|information_schema|mysql|performance|_schema|sys)
			#--skip internal db's
		;;
		*)
			#--dump and gzip
			mysqldump --defaults-group-suffix=backup --add-drop-table --allow-keywords \
				--create-options --extended-insert --hex-blob --lock-tables=false --no-create-db \
				--no-tablespaces --quick --set-charset --skip-add-locks --skip-comments \
				--skip-opt ${db} | gzip -cn --rsyncable > ${tmpPath}/${db}.sql.gz
			#--move into place if different
			if cmp --silent --${tmpFolder}/${db}.sql.gz ${latestPath}/${db}.sql.gz; then
				rm -f "${tmpPath}/${db}.sql.gz"
			else
				mv -f "${tmpPath}/${db}.sql.gz"  ${latestPath}/${db}.sql.gz
			fi
		;;
	esac
done

#--rotate
function rotate {
	path="${backupPath}/${rotateSubPath}"
	mkdir -p ${path}
	cd ${path}
	#--hard link copy of latest into place
	cp -al ${latestPath} ${latestDate}
	#--remove old backups by count
	ls -t . | sed -e 1,"${rotateKeep}"d | xargs -d '\n' rm -rf > /dev/null 2>&1
}
if (( $keepHourly > 0 )); then
	rotateSubPath="hourly"
	rotateKeep="${keepHourly}"
	rotate
fi
if [ `find ${backupPath}/hourly -maxdepth 1 -type d -name "$(date +'%y%m%d-')*" | wc -l` -eq 1 ]; then
	if (( $keepDaily > 0 )); then
		rotateSubPath="daily"
		rotateKeep="${keepDaily}"
		rotate
	fi
	if (( $keepWeekly > 0 )) && [ `date +%u` -eq 1 ]; then
		rotateSubPath="weekly"
		rotateKeep="${keepWeekly}"
		rotate
	fi
	if (( $keepMonthly > 0 )) && [ `date +%d` -eq 1 ]; then
		rotateSubPath="monthly"
		rotateKeep="${keepMonthly}"
		rotate
	fi
	if (( $keepYearly > 0 )) && [ `date +%j` -eq 1 ]; then
		rotateSubPath="yearly"
		rotateKeep="${keepYearly}"
		rotate
	fi
fi
```

That seems to be working for us.  Note: this script hasn't been directly tested, but is approximately what we have, with some stuff simplified and removed for general purposes.

[Update]Fixed logic to prevent unnecessary duplication due to date modification[/Update]
