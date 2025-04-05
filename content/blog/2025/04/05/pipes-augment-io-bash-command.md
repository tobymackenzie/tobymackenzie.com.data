---
categories: [computer]
date: 2025-04-05T13:14:43-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4536'
id: 4536
modified: 2025-04-05T13:15:14-04:00
name: pipes-augment-io-bash-command
tags: [bash, math, pipes, programming, script, shell]
---

Using pipes to augment IO of command with bash script
=====================================================

I like the interactive mode of the `bc` command line calculator because it is ubiquitous, but wanted to augment its functionality a bit to add a couple features I liked from another calculator program.  I wanted to make modifications to the text I typed before sent to `bc` and modify the text it outputted.  This can be done on standard POSIX shells with `mkfifo`, but it took me a good while to figure out how to do this with  both input and output and get something working nicely without it freezing or leaving artifacts.  So I'm sharing how to do this in a `bash` script.

<!--more-->

I had never used or heard of `mkfifo` before, but found it in my searches for how to do my task.  It basically takes an argument specifying a file path, which it then creates as a pipe type file.  It has a `-m` option to set the permissions, so we can prevent others from using this pipe.  Something like:

``` sh
pipe="/tmp/mypipe"
mkfifo -m 0600 "$pipe"
```

At first, I naively thought I could create one pipe and use it for both input and output, but that would just pipe the output of the program back to its input.  Two pipes are needed for going both ways.

I was having trouble with freeze-ups and ensuring the pipe files were deleted at the end of the script.  [This post](https://lonkamikaze.github.io/2015/01/17/bin-sh-using-named-pipes-to-talk-to-your-main-process) helped me resolve this.  Basically, we can run something like `exec 3<> "$pipe"`, where 3 is a number greater than 2.  Doing this allows redirection to or from that number similar to redirecting stdin and stdout.  Then we can `rm "$pipe"` immediately, which removes the pipe file.  The `exec` thing, however, has created a connection to that pipe that remains until the script is terminated, so it still works.

To run `bc` attached to these pipes, we can do normal shell redirection using the numbers of our pipes, and background the process to keep it running.  This can look like `bc -l <&3 >&4 &`.  I had problems ensuring the `bc` subprocess was terminated at the end.  I found the `trap` command for this, which I didn't have a lot of experience with.  It allows running some functionality when certain script-terminating events happen.  I found that the `EXIT SIGINT SIGTERM` events handled the events I encountered.  I stored the process ID of my `bc` command like `PID=$!` and then passed that to `kill` in the `trap` code.

To handle the input, I used `read -r in` to capture it into an `$in` variable, using a `while` loop to repeat.I passed did my modifications, then passed it to `bc` with `echo "$in" >&3`.  Part of the loop condition was to verify the `bc` process was going in case it died due to a parse error, using `kill -0` like `kill -0 "$PID" > /dev/null 2>&1`.  I used `read` again to get the output from our `bc` pipe with `read -t 1 out <&4 || out=''`.  The `-t 1` part is because `bc` sometimes doesn't give output, eg with variable assignment.  This waits one second for output from `bc` and otherwise goes to the `||` part.  Without the timeout, it would just freeze waiting for input.  Since are output is already supposed to be in the pipe, we don't really need to wait a full second, but the time value must be an integer in seconds and `0` doesn't work.

I added a few other niceties like handling empty input and allowing to exit more easily.  The [full script can be found in my dotfiles](https://github.com/tobymackenzie/dotfiles/blob/d5d647aa62889ae8b079ab768659dd19c28828b7/bin/c), but the important part looks like:

``` sh
#!/bin/bash
#--create pipes to communicate with command
inp='/tmp/'$(date +'%Y%m%d%H%M%S')'.in'
mkfifo -m 0700 $inp
exec 3<> "$inp"
outp='/tmp/'$(date +'%Y%m%d%H%M%S')'.out'
mkfifo -m 0700 $outp
exec 4<> "$outp"
#---ensure pipe files removed
rm "$inp"
rm "$outp"

#--make command terminated on exit
hasPID() {
	kill -0 "$PID" > /dev/null 2>&1 && return 0
	return 1
}
fin() {
	if hasPID; then
		kill $PID
	fi
}
trap 'fin; exit' EXIT SIGINT SIGTERM

#--start our process
bc -l <&3 >&4 &
PID=$!
#--get input
while hasPID && read -rp '> ' in; do
	#--no need to pass empty string to command
	if [ -z "$in" ]; then
		continue
	#--we can handle quitting
	elif [[ "$in" == "quit" || "$in" == "exit" || "$in" == "x" ]]; then
		fin
		exit
	fi
	#--build input (`buildIn` to be defined elsewhere)
	in=$(buildIn "$in")
	#--pass to command
	echo "$in" >&3 || fin
	#--read output (`buildOut` to be defined elsewhere)
	read -t 1 out <&4 || out=''
	if [ ! -z "$out" ]; then
		echo $(buildOut "$out")
	fi
done
fin
```

Of course, at 41 lines, this is a lot more verbose than what would otherwise just be 2 lines:

``` sh
#!/bin/sh
bc -l
```

without modified input, but I think it was worth it.

This same script structure should work for any CLI command that works interactively for repeated input and output.  Hopefully it helps someone save the time I spent on this.
