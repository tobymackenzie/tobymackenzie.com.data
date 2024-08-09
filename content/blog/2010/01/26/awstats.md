---
categories: [www]
comment_count: 1
date: 2010-01-26T10:40:06+00:00
date_gmt: 2010-01-26T10:40:06+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=192'
id: 408
modified: 2017-10-30T22:37:21-05:00
modified_gmt: 2017-10-31T03:37:21+00:00
name: awstats
tags: [awstats, host, statistics]
---

Awstats
=======

I am using [Awstats](http://awstats.sourceforge.net/) for my site statistics on both my home server and my [dreamhost](http://www.dreamhost.com/r.cgi?568062/green.cgi?tobymackenzie.com) host.  Dreamhost provides statistics with [Analog](http://www.analog.cx/) automatically installed, but I prefer Awstats.  Awstats is very good at accounting for robots and has a nicer interface.  It is also more configurable since I have access to the full configuration files.

I used the following method to use one install of Awstats for the multiple sites I have hosted on each server.  I use SSH.  If you don't have that available, you can modify the instructions to work with FTP.  The symbolic link (ln -s) bits would have to be modified.  You'd simply put the actual configuration files in the cgi-bin directory (the conf directory was merely a convenience for upgrades) and probably put the actual "wwwroot" directory in the proper location on the site.

These are just my setup notes, so apologies if they are cryptic:

<!--more-->

- move to location outside web root on server
- get awstats
	```
	wget http://awstats.sourceforge.net/files/awstats-6.9.tar.gz
	```
- extract
	```
	tar xfzv awstats-6.9.tar.gz
	```
- rename folder awstats
	```
	mv awstats-6.9 install
	```
- make awstats general folder
	```
	mkdir awstats
	```
- move gzip file and install into folder
	```
	mv awstats-6.9.tar.gz awstats
	mv install awstats
	```
- move into awstats
	```
	cd awstats
	```
- make configuration and data dirs
	```
	mkdir conf data
	```
- fix permissions
	- server and administrator both need access
	- server needs write/read to data, everything else can be read
- copy global config file to conf dir
	```
	cp install/wwwroot/cgi-bin/awstats.model.conf conf/awstats.global.conf
	```
- make a conf file for one site to be monitored
	```
	touch conf/awstats.example.com.conf
	```
- edit site conf file
	- following lines are likely all that's needed
		```
		LogFile="/localPathToAwstatsFolder/install/tools/logresolvemerge.pl /localPathToApacheLogsForSite*|"
		SiteDomain="example.com"
		#HostAliases=""
		SkipFiles="REGEX[^/dbmin]"
		#OnlyFiles=""
		Include "awstats.global.conf"
		```
	- see global conf file for instructions on each bit
- copy this file for each additional site
	```
	cp conf/awstats.example.com.conf conf/awstats.example2.com.conf
	```
	- edit these files appropriately
- edit global conf file to handle other settings for all files
	- comment out any lines that should only be in site files.  Possibilities: `LogFile,SiteDomain,HostAliases`
	- some lines will concatenate pieces from both files
	- These are good lines to change
		```
		DNSLookup=0 # [DNS lookups are expensive]
		DirData="/repPathToAwstatsFolder/data/"
		DirCgi="/repIntendedWebFolder/cgi-bin"
		DirIcons="/repIntendedWebFolder/icons"
		AllowToUpdateStatsFromBrowser=1 # [set this if you don't want to do a cron job]
		AllowFullYearView=3 # [set if you want a full year report]
		DefaultFile="index.php index.html"
		DetailedReportsOnNewWindows=0
		```
- Make symbolic link to these files in cgi-bin directory
	```
	ln -s /repPathToAwstats/conf/* repPathToAwstats/install/wwwroot/cgi-bin
	```
- Make symbolic link to wwwroot where it will appear on site
	```
	ln -s /repPathToAwstats/install/wwwroot/ ../repPathToWebRoot/repWebFolderName
	```
- Make HTML file with links to each sites statistics
	- can for instance put index file into wwwroot folder
		```
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
			<head>
				<title>Site Statistics by AWSTats</title>
			</head>
			<body>
			<ul>
				<li><a href="cgi-bin/awstats.pl?config=example.com">example.com</a></li>
				<li><a href="cgi-bin/awstats.pl?config=example2.com">example2.com</a></li>
			</ul>
			</body>
		</html>
		```
- Visit site, make sure it works
- Make sure perl cgi scripts can run, if needed
	- add this line to http.conf or .htaccess file if needed
		```
		AddHandler cgi-script .cgi .pl
		```
	- and possibly
		```
		<Directory /repPath/cgi-bin>
			Options +ExecCGI
			Order allow,deny
			allow from all
		</Directory>
		```
- Run awstats update for each site
	```
	/repPathToAwstats/install/wwwroot/cgi-bin/awstats.pl -config=example.com -update
	```
	- make sure no problems, watch for errors in output
- create a shell script to execute the update commands
	- add a line similar to above run for each site
	- make sure to set the execute bit for file
		```
		chmod u+x repPathToShellScript
		```
- Set up crontab to update stats data
	```
	0 3 * * * /repPathToShellScript > /dev/null
	```

Note that the `SkipFiles` directive, which tells Awstats what files to not count, seems to only work in one loaded conf file.  If you have it in the global file, the one in the per-site file doesn't seem to work.  I even tried concatenating with `.=` to no avail.  So you'll either have to put them for all sites in the global file or for each site separately in its own conf file.

With all the time it took to fix those for Wordpress, I probably could have fixed them up for readers as well.  Maybe I'll clean them up later.

[Update 10-3/16] I suddenly ran into permission problems with my awstats install on my Dreamhost account.  After some searching, I found that there was a problem following symlinks, so I had to add `Options +FollowSymLinks` to my htaccess file for the stats site.  Dreamhost must have changed something. [/Update]
