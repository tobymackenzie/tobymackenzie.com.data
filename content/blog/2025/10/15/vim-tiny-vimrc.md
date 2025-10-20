---
categories: [computer]
date: 2025-10-15T15:27:33-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=4670'
id: 4670
modified: 2025-10-15T15:27:33-04:00
name: vim-tiny-vimrc
tags: [configuration, dotfiles, vim]
---

vim.tiny and vimrc
==================

I tried installing [my dotfiles](https://github.com/tobymackenzie/dotfiles) on an unmodified Ubuntu install.  [My vimrc](https://github.com/tobymackenzie/dotfiles/blob/master/vim/vimrc) threw many errors.  Ubuntu and other Debian based distros install the tiny build of vim by default, which has a lot of features disabled, including `eval`, but still loads the user vimrc.  That means that many things that might be in there, including `function` and even `let`, do not exist in tiny.  `:help no-eval-feature` provides a solution:  Wrap everything that should only work in `+eval` capable versions of vim in `if 1 … endif`.

<!--more-->

Things that tiny does support include:

- most `set`.  Ones that don't exist don't seem to throw an error from vimrc
- `map` and variants, though what is mapped might not work when called
- `augroup` and `autocmd`, though events may not work right
- some `filetype`.  `filetype plugin indent on` caused errors for me
- `colorscheme` works, though no color schemes are installed.  If I use one of the standard vim color scheme files, I get an error because of the `let` in them
- `if` structures and any syntax in them are basically ignored

I went through and [if'd the erroring stuff in my vimrc](https://github.com/tobymackenzie/dotfiles/commit/e6eac3409d7a67761580fb8555e84ddb05cdb866) and now am able to get a tiny vim with at least some of my settings.  I haven't thoroughly tested this, and would most likely install regular vim on any machine I'm using long enough to install my dotfiles on anyway.  This was just a quick fix for those rare cases where I'm in vim.tiny.
