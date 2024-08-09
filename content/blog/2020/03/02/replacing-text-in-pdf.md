---
categories: [computer]
date: 2020-03-02T02:36:13-05:00
date_gmt: 2020-03-02T07:36:13+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2666'
id: 2666
modified: 2020-03-02T02:36:13-05:00
modified_gmt: 2020-03-02T07:36:13+00:00
name: replacing-text-in-pdf
tags: [pdf, script, shell]
---

Replacing text in PDF
=====================

I recently found myself needing to replace some text in a PDF for confidentiality reasons.<!--more-->  I tried LibreOffice and some other GUI applications, but they had problems with content sizing and canvas size.  After searching online, [a StackOverflow answer](https://stackoverflow.com/a/9872494/1139122) showed how to do it using the command-line [PDFtk](https://stackoverflow.com/a/9872494/1139122) and `sed`.  The answer warns that it doesn't always work, but it did in my case, changing the text and not messing anything else up (that I could see).

I didn't have PDFtk already, so I used [MacPorts](https://www.macports.org/) to install it: `sudo port install pdftk`.  It actually said the port was broken, but the command was there and seemed to work fine.

I tested the commands from the above answer, but ran into a problem.  [Another StackOverflow answer](https://stackoverflow.com/a/11287641/1139122) gave me the solution:  I had to set `LANG=C` to tell `sed` to treat the file as binary.

The commands then worked to do what I wanted.  I put them together into a bash script for future use:

``` sh
#!/bin/bash
if [ "$#" -ne 4 ]; then
	echo "Usage: pdfreplace.sh input.pdf 'string to replace' 'string replacement' output.pdf"
	exit 1
fi

#--needed for encoding to be handled correctly on mac
LANG=C
#--uncompress, replace text, recompress, and remove temp files
pdftk $1 output _tmp12345.pdf uncompress \
&& sed -e "s/$2/$3/g" <_tmp12345.pdf >_tmp22345.pdf \
&& pdftk _tmp22345.pdf output $4 compress \
&& rm _tmp12345.pdf _tmp22345.pdf
```

It takes four arguments, shown in the "Usage" line echoed when you run it with less than four arguments.

I make no promises that it'll work for your needs.
