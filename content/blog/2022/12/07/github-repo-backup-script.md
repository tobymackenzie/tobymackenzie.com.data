---
categories: [computer, www]
date: 2022-12-07T12:07:17-05:00
date_gmt: 2022-12-07T17:07:17+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3898'
id: 3898
modified: 2022-12-07T12:07:17-05:00
modified_gmt: 2022-12-07T17:07:17+00:00
name: github-repo-backup-script
tags: [backup, git, github, script]
---

Github repo backup script
=========================

For some time, I've been wanting to set up a backup for my Github repos.  Technically they are all backed up by my local copies, which are also backed up when I back up my local computer.  However, I wanted something that was sure to have everything from all the repos (all branches, tags, etc) and could be set up and run continuously on a yet-to-be-created backup server.  I have create a bash script to do this for me.<!--more-->

The script uses Github's API to grab a list of all repos.  This is JSON, so it uses `grep` and `cut` to extract the important part.  It caches this in a file for 7 days so it doesn't have to keep calling the API.

It then loops through each of the repo names, skipping certain ones that I don't want to back up because they are third-party forks.  If there is already a backup of that repo, it will run `git remote update` to grab only the changes.  If the backup doesn't exist yet, it will use `git clone --mirror`, which makes a bare repository containing everything I'm interested in from the repo.

It is a script in a `bin` folder inside of the backup target folder.  The target folder will end up with the `bin` folder plus a folder for each repo, with the repo name as the folder name.  It will have problems if there is a repo named "bin", but the script folder can easily be renamed.

The script looks like:

``` bash
#!/bin/bash
gh_user='tobymackenzie'

dir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
if [ ! -e "${dir}/.ghdata" ] || [[ $(find "${dir}/.ghdata" -mtime +7 -print) ]]; then
	curl "https://api.github.com/users/${gh_user}/repos?per_page=100" | \
		grep -e '^    "name"*' | \
		cut -d \" -f 4 > "${dir}/.ghdata"
fi
gh_data=`cat "${dir}/.ghdata"`

for name in ${gh_data}; do
	case $name in fork-* | 'symfony-docs')
		continue
	esac
	dest="${dir}/../${name}"
	# echo "${dest}"
	if [ -d "${dest}" ]; then
		cd "${dest}"
		git remote -v update --prune
	else
		mkdir "${dest}"
		git clone --mirror "https://github.com/${gh_user}/${name}.git" "${dest}"
	fi
done
```

I will likely rebuild this in PHP so that I can more easily parse the API JSON and add other features.
