---
categories: [computer]
date: 2025-12-09T23:43:07-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=4721'
id: 4721
modified: 2025-12-09T23:43:07-05:00
name: vim-netrw-sftp-error
tags: [problem, sftp, vim]
---

Vim: Netrw SFTP error
=====================

I was annoyed by a problem that cropped up in the latest version of MacVim when using SFTP with the included Netrw plugin.  It showed an error every time I opened a directory.  So I filed a bug and helped get it fixed.  I spent a fair amount of time looking for the exact commit in the Netrw code where the problem started.  I then [filed a GitHub issue](https://github.com/vim/vim/issues/18829) about it with that information.  It got fixed in like an hour, at least in the repo.  Still waiting for it to make it to MacVim.

<!--more-->

The problem is just an `Undefined variable` error displayed every time a directory is opened through a Netrw SFTP or SCP connection.  It looks like this:

```
Error detected while processing BufReadCmd Autocommands for "sftp://*"..function netrw#Nread[2]..netrw#NetRead[99]..<SNR>57_NetrwBrowse[106]..<SNR>57_NetrwMenu:
line 85:
E121: Undefined variable: curwin
line 87
E121: Undefined variable: s:netrwcnt
```

The annoyance is that this happens for every folder and I must wait a couple seconds, then hit return.  This really slows down navigating through folders quite a bit and makes it more frustrating, especially when I need to get something done quickly.

It happens for me in MacVim version 9.1.1887, but not 9.1.1128.  It happens in gVim version 9.1.1914, but not 9.1.967.  It does not happen in the command line `vim` of any version, so it seems to be GUI related.  I made sure it wasn't my plugins by launching with the clean flag: `gvim --clean`.  This also prevents Netrw from loading, so in Vim I had to run `:packadd netrw`.  I could then run my test connection, eg `:e sftp://me@example.com/`.

To look for the commit where the problem occurs, I checked out the entire [vim repo](https://github.com/vim/vim), since that is where the current Netrw code is managed, and launched MacVim with the `VIMRUNTIME` environment variable set to the `runtime` folder in that repo, like:

``` sh
VIMRUNTIME="~/code/vim/runtime" gvim
```

The problem still existed at the then current commit, so I knew it hadn't been fixed already.  I jumped back in git commit history to see whether the problem existed or not.  I used the `git log` of the Netrw directory to find target commits, so I didn't have to deal with all the rest of the huge number of commits in the repo.  After some time, I traced the problem to [commit d62377386](https://github.com/vim/vim/commit/d62377386c92e500365009412efd3b1232a02c82), which was Netrw v180.  The previous Netrw commit, 29d596c80, doesn't have the problem.

When I first saw the problem in MacVim, I wasn't sure where to report it, but when I saw that it occurred in gVim and that Netrw code was now managed in the main repo, I figured out to go there.  Vim has a template for filing issues.  I was a little unsure of where to put some of the information I found, but was able to shove it in there in a way that seemed alright.  I don't file issues too often.  Like I said, they marked it as closed and fixed not long after, with [commit ab09099](https://github.com/vim/vim/commit/ab090993ad0d9134837a0299a5c7589c66ef4db5).  I pulled locally and verified that it was fixed.

The fix still has to make its way into Homebrew and Linux repos.  For now, I have to set the `VIMRUNTIME` when I want to SFTP, or continue dealing with the errors.  But I'm glad the fix is there and that I helped make it happen.
