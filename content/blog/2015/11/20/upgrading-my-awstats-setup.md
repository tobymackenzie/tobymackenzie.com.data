---
categories: [www]
date: 2015-11-20T00:45:32-05:00
date_gmt: 2015-11-20T05:45:32+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=739'
id: 739
modified: 2019-10-24T23:48:59-04:00
modified_gmt: 2019-10-25T03:48:59+00:00
name: upgrading-my-awstats-setup
tags: [analytics, script, upgrade, web]
---

Upgrading my Awstats setup
==========================

I don't really monitor analytics for my personal sites that often besides for my blogs, for which I use wordpress.com's analytics.  I do have three open-source analytics programs set up for my main sites though:  [piwik](http://piwik.org/), [owa](http://www.openwebanalytics.com/), and [awstats](http://awstats.org/).  Awstats is the one I've tended to look at the least, probably because its interface isn't as nice as the others and it doesn't have as much data about visits.  However, it is the only one that looks at actual server logs, so it should be the most accurate about basic visit information.  The other two use JavaScript, one having an image fallback, so there's the potential for them to miss visits.

I have my [awstats set up as I described in 2010](/content/2010/01/26/awstats.md).  I keep the configuration and the data separate from the install to make updates easier.  However, it had been so long since I upgraded that I forgot how it was set up and fumbled a little before finding that article and figuring out what had to be done.  In order to make it easier for next time, I created myself a simple little script to handle the upgrade for me:

<!--more-->

``` php
#!/usr/bin/env php
<?php
//==main
//--config
$version = (isset($argv[1]) ? $argv[1] : null);
if(!$version){
	echo 'You must specify a version number\n';
	exit(1);
}
$rootPath = (isset($argv[2]) ? $argv[2] : null);
if(!$rootPath){
	$rootPath = "/path/to/awstats"; //-! make this your awstats path to make things easier
}
$tarFileName = "awstats-{$version}.tar.gz";
$hasSymlinked = false;

//--go to directory
chdir($rootPath);

//--capture current version for message about reversion
$oldVersion = realpath('install');
if(preg_match("/awstats-([\w-\.]+)$/", $oldVersion, $matches)){
	$oldVersion = $matches[1];
}else{
	$oldVersion = null;
}

//--download if needed
if(!is_dir("awstats-{$version}")){
	runShellCommand("wget http://prdownloads.sourceforge.net/awstats/{$tarFileName}");
	runShellCommand("tar -xzf {$tarFileName}");
}

//--get everything in place
runShellCommand("ln -nfs awstats-{$version} install");
$hasSymlinked = true;
runShellCommand("ln -nfs {$rootPath}/conf/* install/wwwroot/cgi-bin/");

//--run update command for each site
$confFiles = glob("conf/awstats.*.conf");
foreach($confFiles as $confFile){
	if(preg_match("/^conf\/awstats\.([\w-\.]+)\.conf$/", $confFile, $matches) && $matches[1] !== 'global'){
		runShellCommand("install/wwwroot/cgi-bin/awstats.pl -config={$matches[1]} -update");
	}
}

echo "Upgrade complete.  If something goes wrong, you can check for any changes to the upgrade procedures at http://www.awstats.org/docs/awstats_upgrade.html.  If this doesn't help, the previous version can be reinstalled by running `{$argv[0]} " . ($oldVersion ?: 'old-version') . "`\n";


//==lib
function runShellCommand($command){
	global $hasSymlinked, $oldVersion;
	echo "Running `{$command}`\n";
	passthru($command, $return);
	if($return !== 0){
		if($hasSymlinked && $oldVersion){
			$reversionCommand = "{$argv[0]} {$oldVersion}";
			echo "Failure after installing symlink to new version.  Reverting to old version.  Running `{$reversionCommand}`\n";
			passthru($reversionCommand);
		}
		exit($return);
	}
}
```

Next time, assuming I remember I have the script, I can just run it like `awstats-upgrade 7.5`, and it will download and install the new version and update the data, leaving my previous version in place in case things go wrong.
