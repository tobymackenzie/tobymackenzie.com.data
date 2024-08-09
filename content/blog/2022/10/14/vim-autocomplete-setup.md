---
categories: [computer, www]
date: 2022-10-14T12:42:10-04:00
date_gmt: 2022-10-14T16:42:10+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3853'
id: 3853
modified: 2024-02-26T20:41:28-05:00
modified_gmt: 2024-02-27T01:41:28+00:00
name: vim-autocomplete-setup
tags: [editor, feature, vim]
---

Vim autocomplete setup
======================

After hours of playing and learning some details of vimscript, I have improved the autocomplete in vim almost to where I like it.  I've made it work more like some GUI editors, eg Sublime and Atom, where it pops open automatically as I type and I can tab to apply the selected choice or otherwise type on and ignore it, and otherwise clean up the experience.  The main thing I would like to add is fuzzy matching.  I'd also like it to match more in-document words and work for more unknown file-types in a generic way.

<!--more-->

There are many plugins that do this sort of thing, and that would've been much simpler to use.  I had used YouCompleteMe, but it was pretty heavy to install.  It was like 300+ MB and required compiling.  It also had some user experience choices I didn't totally like.  When I saw that vim had a built in autocomplete system, I figured why not try to use that.

So far
------

I have set it up to show the dropdown when three consecutive word characters (`\w`) are typed.  I do this with a listener on the `InsertCharPre` event.  I use the `call feedkeys()` function to have it open the autocomplete dropdown.  To prevent unwanted errors, I only do it if an `omnifunc` value is set, eg when it is a file type that vim has matches for.  That looks like:

``` vim
autocmd InsertCharPre * call TMAutopleteOnIns()
fun! TMAutopleteOnIns()
	if len(&omnifunc) != 0
		\ && v:char =~ '\w'
		\ && getline('.')[col('.') - 3] =~ '\w'
		\ && getline('.')[col('.') - 2] =~ '\w'
		\ && getline('.')[col('.') - 1] !~ '\w'
		call feedkeys("\<C-x>\<C-o>", 'n')
	endif
endfun
```

In order for this to flow nicely, and not require selecting something, I prevent it from automatically selecting and inserting an item.  I also ensure it will show the drop-down when there is only one item, which it doesn't by default.  I do those by setting the `completeopt` setting like:

``` vim
set completeopt+=menuone,noinsert,noselect
```

I map tab to select and apply the first or selected item.  If nothing is selected, the first item will be, but if something else is already selected, then that item will be.  Makes it fast to type and complete or move to another item and use tab like is common with other autocomplete implementations.  That looks like:

``` vim
inoremap <expr> <Tab> pumvisible() ? (complete_info()['selected'] == -1 ? "\<C-n>" : "\<C-y>") : "\<Tab>"
```

By default an error message shows when no matches are found.  Since the autocomplete functionality will be invoked constantly, I disable this with:

``` vim
set shortmess+=c
```

To improve completions in more file types, I set the omnifunc to be `syntaxcomplete#Complete`.  This adds some level of generic support for more file types, but it seems to be slow, not generic enough, and still doesn't do anything in many file types.  This looks like:

``` vim
set omnifunc=syntaxcomplete#Complete
```

Vim's autocomplete system shows a preview window with a function signature.  It is useful, but it doesn't automatically close, and thus gets annoying.  My solution was to close it whenever a ')' is typed, so that it shows while entering the arguments to a function but then closes after they are entered.  This may not work for all languages or for non-functions, but then I'm just back to the normal situation.  I use `inoremap` to run a function on each ')' keypress in input mode, and if I find a preview window open, I use `call feedkeys` to close it.  For some reason I had to loop through all windows to see if the preview was open in this case.  I'm not sure if that will cause any problems with multiple windows.  The script for that looks like:

``` vim
inoremap <expr> ) TMClosePreviewDone()
fun! TMClosePreviewDone()
	for w in range(1, winnr('$'))
		if getwinvar(w, "&pvw") == 1
			call feedkeys("\<esc>:pclose\<CR>i\<right>", 'n')
		endif
	endfor
	return ")"
endfun
```

To make the preview window a little less cluttered, I hide line numbers in it, since I show them by default.  That uses a function on the `WinEnter` event to turn off the local `number` option when the preview window is showing, tested with `&pvw`.  Overall, that looks like:

``` vim
autocmd WinEnter * call TMHidePreviewLN()
fun! TMHidePreviewLN()
	if &pvw
		setlocal nonumber
	endif
endfun
```

I wrap the whole thing in the following condition so it will, I assume, not cause problems in builds without the autocomplete feature:

``` vim
if exists("+omnifunc")
endif
```

Todo
----

Fuzzy matching is my biggest desired feature.  The need presented itself quickly, as I was using the PHP function `file_exists()` while testing my implementation.  There are many `file_` functions in PHP, and `file_exists()` is so far down the list for typeing "file" that it would be easier to type out the rest of the function than to arrow down to it.  It comes up as the first item if "\_e" is added on, but the "\_" requires chording and is far from home row.  It would be far quicker to type "filee" and then hit tab, but that requires fuzzy matching.  Similarly with camelcase, it would be nice to not have to chord for typing the uppercase letters.  There is something built in for doing fuzzy matching, but I'm not sure how to tie this in with the built in omni dictionaries.

I'd like it to match more general words within a a document or other buffered documents.  In PHP, it seems to match variables, function names, class names, constants, but not content of strings and stuff like that.  In CSS, it doesn't seem to match class names and other selector values.  That would be nice to have.  Again, I'm not sure how to modify the built in ominfunc dictionary matching.

I'd like it to work better for more unknown file-types in a generic way, just matching any string.  By default, vim sets `omnifunc` based on the determined file-type, based on extensions.  I set it to `syntaxcomplete#Complete` for when it isn't otherwise set.  This works okay in some file types but still doesn't generically match strings in the document.  Pressing Control-n can give some increased level of generic matching sometimes, but still not enough.  This is also somewhere I might want to be able to modify the built in omnifunc matching behavior.

These features are often provided by the autocomplete plugins available.  I may just have to give in and use one of them, but I am so close and have some behavior closer to how I like it than they may provide.

Fin
---

Autocomplete is one more thing that makes me feel more comfortable in my editor.  If I want to use vim as my primary editor instead of a standard GUI app, I will need a decently comfortable autocomplete.  This brings me closer to that.  Maybe with a bit more work or a third-party plugin, I can get this feature on par with or better than how I like it in Atom, etc.

See [the full current code in my current vimrc](https://github.com/tobymackenzie/dotfiles/blob/47cca307f238620247cb0943392293893b617d23/vim/vimrc#L40-L79).
