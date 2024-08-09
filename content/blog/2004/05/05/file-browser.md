---
categories: [computer, ideas, ideas]
comment_count: 1
date: 2004-05-05T03:23:19-05:00
date_gmt: 2004-05-05T08:23:19+00:00
guid: 'http://cosmicosmo.ath.cx/log/2004/05/05/file-browser/'
id: 83
modified: 2023-08-02T20:56:22-04:00
modified_gmt: 2023-08-03T00:56:22+00:00
name: file-browser
tags: [computing]
---

Ideas: File Browser
===================

file browser (like finder) has built-in/plug-in capabilities to read and work with basic document formats. Images would appear as thumbnails, with preferences, that can be easily viewed at full size in a self controlled slide show type thing by folder. Movies would be viewable full size in the browser as well. audio files would be listenable toable, including being able to leave them play while doing other browsing. Text files would be completely viewable, possible editable. PDF's would be viewable. Other formats would have plugins available from the maker of the app that produces them.

Allows viewing of files while still maintaining a file-browser like appearance and functionality at all times.

Controls would be provide when necessary from an easily accessible location, such as at the top of the window or in a floating window that disappears with no mouse movement. Proper controls would appear for the proper file-type.

All files would be able to be given tags, including user created tags, that are simply data about the file for informative and searching use. For example mp3 tags would be editable from the browser, as well as JPEG EXIF data.

Files could be organized in multiple directory setups without the use of aliases or anything, just an additional centrally located database directory file. Each media type would or could be given its own database so that one could look at all images at once in the image database while still have those images grouped with related other media in the regular directory system. This could perhaps be automated, having all images automatically put into the image database, which would then be able to be queried by its tags to show categories or specific dates or what-have-you.

All controls would be easily navigable and accessible with the keyboard as well as with the mouse, allowing speed and flexibility. This would include at least the major preference settings.

The browser would be very customizable to fit most peoples needs and tastes.

The browser would be designed to be slim and fast, taking up as little disk space, memory, and processor power as possible.

It would also be very plug-inable, so that users who don't want certain features could easily remove them to save resources. Plug-ins would be able to be developed by third parties, so that alternatives for each file-type or function could be provided. If someone doesn't like, say, the regular image browser, they could remove it and install a third party one easily that would integrate with the browser.

/****** the following is sort of a reworded, newer, and a bit different version of the above *****/

The independent application that handles specific document types is generally no longer needed, in my opinion. All files can be handled from within a single application, allowing the difference in file types to not affect the similarity in content (one should be able to view both text files and images relating to a given subject without having to change applications).

Plug-ins would provide the capabilities for multiple file-types: a plugin would essentially be the application for viewing and editing a given file-type, but would be opened within the 'finder' instead of separately. Each plugin would be loaded when opened, and taken back out of memory when no longer needed, possibly a specified time after the last opening of that doc type, with the amount of time weighted based upon the frequency of opening that given doc type.

Each document would be stored in the database like an object of an inherited class in an object oriented programming language. Every file would have certain attributes, such as disk location, creation and modification dates, name, user, group, as well as functions, such as rename, modifyContent, view. These would be part of the 'file' class. General categories of files may have more attributes and functions than that: ex 'media' category may contain author, date media was created. The 'media' category would contain some specific file types, or perhaps more specific of categories, such as pictures, movies, music. Each specific file type, what would be the instances created in the database, would have the most specific attributes and functions. A photo might have attributes size, color profile, shutter speed, and functions resize, contrast. Each specific file type, like in any OO inherited object, would have all attributes and functions of the more general categories of file type in addition to its own.

With standard setting, the document by default is opened in viewing mode. In this mode, no changes can be made to the file. All commands are designed to aid in the viewing of the file. A certain command would enter editing mode (likewise in editing mode, a certain command would bring you to view mode). In editing mode, all commands are set-up for editing. As an example, for a text document, typing 'apple' might put 'apple where the cursor is currently when editing, but live-search for that text when viewing (another entry has more on this).

If anyone is interested in helping me build such a thing, contact me at [public@tobymackenzie.com](mailto:public@tobymackenzie.com). I have only a little programming experience and have done almost nothing towards creating this project. I plan to start by making an application for Mac OS X that is like any other application and doesn't affect the finder or its database, instead having an additional database that is its own and working through/with the systems database.

related thought
---------------

folders are not really files. they are used only for organization, so would not exist if there was no organization. files containing your content are a different kind of file from the organizing folders.
