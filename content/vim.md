[VIM](https://www.vim.org/) is my preferred text editor, one of my most important tools in my [web development](/content/web-dev) career and personal computer use.  It is fully open source, has been around a long time, works in both GUI and CLI, is available on pretty much any system, and is even installed by default in most current Mac and common Linux distros.  Vi, its predecessor, is a POSIX standard, with Vim being the most common implementation for modern OSs.

Vim is a modal text editor, with a command mode that can be used to do complicated things quickly.  It has a learning curve and can be confusing for new users.  I first used it in some computer classes in college, and saw how quickly a professor was able to do things in it.  I became a fan of some of its simple commands, such as `dd` to delete a line.  I missed that in my GUI editors and began using editors with some sort of Vim mode.  Over time I learned more commands through the Vim mode and when editing files on servers through CLI.  The mouse and other GUI functionality improved in MacVim / gVim in that time, as well as some other annoyances.  When Atom, my previous editor, was sunset, I decided to move full time to Vim and have become fairly happy with it.

I have spent quite a bit of time customizing the editor for my preferences.  [My config is in my dotfiles](https://github.com/tobymackenzie/dotfiles/tree/master/vim).  I add several third-party plugins:

- [ALE](https://github.com/dense-analysis/ale): syntax checking / linting, simple to set up
- [editorconfig](https://github.com/editorconfig/editorconfig-vim): simplifies per project whitespace and related configuration
- [fugitive](https://github.com/tpope/vim-fugitive): tools for working with git repos, simplifies managing commit changes by file, block, or line
- [gitgutter](https://github.com/airblade/vim-gitgutter): shows git diff markers to open file in vim sign column, good for view of what has changed while editing
- matchit: provides better matching of code symbol pairs, including HTML element start and end tags
- [nerdcommenter](https://github.com/preservim/nerdcommenter): simplifies adding and removing comments
- [vim-plug](https://github.com/junegunn/vim-plug): for installing and managing plugins, chosen for simplicity of config and use.

I try to avoid third party plugins when I don't feel I need them though.  In my dotfiles, I have done my own implementation of general settings, project handling, autocomplete, file opening, tab management, colors, and helpful keybindings and commands to make some things quicker or easier to remember.
