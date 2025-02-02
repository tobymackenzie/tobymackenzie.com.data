---
categories: [www]
date: 2021-01-21T22:05:47-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3232'
id: 3232
modified: 2021-01-21T23:38:23-05:00
name: apache-logs-command-line-tools
tags: [apache, cli, log, server, web]
---

Looking at Apache logs with command line tools
==============================================

In my web development career, I have countless times needed to look at Apache logs to figure out or find out about problems with sites, monitor activity, or for various other purposes.  I've used command line tools to help with this, often looking for strings and counting occurrences.  Since I recently needed to create a command string to count unique IP's connected to a given string in the logs, I thought I'd post about it and a few related useful commands.

<!--more-->

Looking for strings
--------------

We can use the common command line tool `grep` to find strings in the content of files.  Simple usage is like `grep 'string' files*`, which will output all lines in the specified file(s) which contain 'string'.  Adding the `-l` option causes it to only list the filenames with matches, useful if we pass multiple file paths, such as with a glob.  Adding the `-E` option allows for extended regular expressions, though it does require escaping of special shell characters and has some things different from the regex I'm used to from PHP and JavaScript.

As an example, we can find some PHP and Apache errors or other things of interest in some error logs like:

``` sh
grep -E '(fatal error|Fatal|Critical|internal redir|PHP Parse|Stack trace)' /var/log/{apache2,httpd}/*error.log 2> /dev/null
```

Note the log path I'm globbing, which works on both the CentOS and Ubuntu servers I commonly work on.  We do the `2> /dev/null` thing to eat errors, which get output because one of `apache2` and `httpd` folders don't exist.  Without that glob, we don't need to eat the errors.

The command `less` allows us to view files and navigate through them.  It can also look at stdin, as in the output stream from another command.  The `--pattern` option can be used to find and highlight a regex pattern in whatever is being viewed.  This can be used to look at error logs and highlight the same strings as the `grep` command, like:

``` sh
less --pattern='(fatal error|Fatal|Critical|internal redir|PHP Parse|Stack trace)' /var/log/{apache2,httpd}/*error.log 2> /dev/null
```

Unlike `grep`, it will show the full file contents, if we want to look at the surrounding context.  It will also show the files that don't contain the string, so we have to navigate through them all even if the string doesn't exist in any of them.

`xargs` allows taking a list of files from the command line and executing another command on all of them.  We can use this to combine `grep` and `less` to show the full file contents of only files that match, and highlight the lines we are most interested in.  This can look like:

``` sh
grep -lE '(fatal error|Fatal|Critical|internal redir|PHP Parse|Stack trace)' /var/log/{apache2,httpd}/*error.log 2> /dev/null | xargs less --pattern='(fatal error|Fatal|Critical|internal redir|PHP Parse|Stack trace)'
```

That is fairly verbose, so I have made script files to build these commands for me, or copy them from a notes file.

Counting matching occurrences
--------------

The `wc` command counts words or other string things.  Most useful for us is the `-l` option, which counts lines.  Combined with `grep`, we could count the number of times something happened in the logs, such as POSTing to a particular form endpoint, like:

``` sh
grep 'POST /contact' /var/log/{apache2,httpd}/example.com-access.log 2> /dev/null | wc -l
```

Counting IP's that match occurrences
--------------

The `sort` command will take multiple lines and sort them.  It is alphabetical by default, but can sort numerically with the `-n` option.  `-r` will reverse the sort.  `-b` will cause it to ignore leading whitespace.

The `uniq` command takes multiple lines and finds and removes the repeated adjacent ones among them.  If we sort the lines first, that will ensure each line is unique among the rest.  With the `-c` option, it will show a count for each unique line.

`sed` is a fancy command for doing a lot of things with strings.  It can perform regex replacements.  The regex is again a little different than other common regexes I'm used to, and requires more escaping.

With these and some previously discussed commands, we can count the IP's on lines that contain a particular string, to see, for instance, if some IP's are sending an unusual number of submissions to forms on sites, like:

``` sh
grep 'POST ' /var/log/{apache2,httpd}/*access.log 2> /dev/null | sed 's/^[A-Za-z0-9:.\/-]\+ \([A-Za-z0-9.:]\+\) .*$/\1/gi' | sort | uniq -c | sort -bnr | less
```

This will give us counts with IP's, sorted with the highest counts at the top.  Note that the `sed` regex is based on a particular log format, and might need tweaked for a different format.

The use case that led to this post was similar.  I have PHP logging a message whenever our form processing script thinks a submission is suspicious or not.  The suspicious ones have a message something like "Notice: suspicious submission: IP: 1.2.3.4…".  Thus, I can do something like:

``` sh
grep 'suspicious submission:' /var/log/{apache2,httpd}/*error.log 2> /dev/null | sed 's/^.*submission: IP: \([A-Za-z0-9.:]\+\)[ ,\\].*$/\1/gi' | sort | uniq -c | sort -bnr | less
```

to get a count of the IP's making these suspicious submissions.  If an IP has a high count, I can check to see if those submissions indeed look suspicious, and add those IP's to a list that gets special consideration, such as blocking or counting towards a spam score.
