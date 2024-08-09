---
categories: [www]
comment_count: 2
date: 2010-05-06T02:18:46+00:00
date_gmt: 2010-05-06T02:18:46+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=300'
id: 300
modified: 2016-04-04T21:03:36-05:00
modified_gmt: 2016-04-05T02:03:36+00:00
name: formatting-dates-in-classic-asp
tags: [asp, dates, functions, rpm]
---

Formatting Dates in Classic ASP
===============================

During my internship at [RPM](http://rpminc.com), we used classic ASP for server side scripting rather than the PHP I'm more used to.  Classic ASP is missing functions for formatting dates, like PHP and *NIX shell have, for instance.  SQL Server has the CONVERT function, but only has a limited number of output formats, at least for the older SQL Server version we had:  Otherwise, it would be more efficient to format the data as it is coming from the database .  I built two functions for date formatting based on the PHP and *NIX "date" formats for use on the [HSGA site](http://summithumane.org), where I had to format dates a certain way for a project.  I don't remember if I used it on other projects, but I think so.

Both functions take two parameters.  The first is a date, as would come from a SQL Server "datetime" field.  The second is a string that defines the output format.  The first function uses a format string like the [php date function](http://php.net/manual/en/function.date.php).  The long function is as follows (tabs are double spaces due to the width and length of the content):
``` asp
Function PHPFormatDateTime(strDateTime, strFormatString)
	Dim intI, strOutput, strTemp, bolEscape
	bolEscape = 0
	
	For intI = 1 to Len(strFormatString)
		If bolEscape = 0 then
			Select Case Mid(strFormatString, intI, 1)
				' day
				Case "d"
					If DatePart("d", strDateTime) < 10 Then
						strOutput = strOutput & "0" & DatePart("d", strDateTime)  
					Else
						strOutput = strOutput & DatePart("d", strDateTime)
					End If
				Case "j"
					strOutput = strOutput & DatePart("d", strDateTime)
				Case "D"
					Select Case DatePart("w", strDateTime)
						Case 1
							strOutput = strOutput &  "Mon"
						Case 2
							strOutput = strOutput &  "Tue"
						Case 3
							strOutput = strOutput &  "Wed"
						Case 4
							strOutput = strOutput &  "Thu"
						Case 5
							strOutput = strOutput &  "Fri"
						Case 6
							strOutput = strOutput &  "Sat"
						Case 7
							strOutput = strOutput &  "Sun"
					End Select
				Case "l"
					Select Case DatePart("w", strDateTime)
						Case 1
							strOutput = strOutput &  "Monday"
						Case 2
							strOutput = strOutput &  "Tuesday"
						Case 3
							strOutput = strOutput &  "Wednesday"
						Case 4
							strOutput = strOutput &  "Thursday"
						Case 5
							strOutput = strOutput &  "Friday"
						Case 6
							strOutput = strOutput &  "Saturday"
						Case 7
							strOutput = strOutput &  "Sunday"
					End Select
				Case "S"
					strTemp = DatePart("d", strDateTime)
					If strTemp < 10 Then
						strTemp = "0" & strTemp
					End If
					Select Case Left(strTemp, 1)
						Case 1
							strOutput = strOutput & "th"
						Case Else
							Select Case Right(strTemp, 1)
								Case 1
									strOutput = strOutput & "st"
								Case 2
									strOutput = strOutput & "cnd"
								Case 3
									strOutput = strOutput & "rd"
								Case Else
									strOutput = strOutput & "th"
							End Select
					End Select
				Case "w"
					strOutput = strOutput & (DatePart("w", strDateTime) - 1)
				Case "Z"
					strOutput = strOutput & DatePart("y", strDateTime)
				' week
				Case "W"
					strOutput = strOutput & DatePart("ww", strDateTime)
				' month
				Case "B"
					Select Case DatePart("m", strDateTime)
						Case 1
							strOutput = strOutput & "January"
						Case 2
							strOutput = strOutput & "February"
						Case 3
							strOutput = strOutput & "March"
						Case 4
							strOutput = strOutput & "April"
						Case 5
							strOutput = strOutput & "May"
						Case 6
							strOutput = strOutput & "June"
						Case 7
							strOutput = strOutput & "July"
						Case 8
							strOutput = strOutput & "August"
						Case 9
							strOutput = strOutput & "September"
						Case 10
							strOutput = strOutput & "October"
						Case 11
							strOutput = strOutput & "November"
						Case 12
							strOutput = strOutput & "December"
					End Select
				Case "m"
					If DatePart("m", strDateTime) < 10 Then
						strOutput = strOutput & "0" & DatePart("m", strDateTime)  
					Else
						strOutput = strOutput & DatePart("m", strDateTime)
					End If
				Case "M"
					Select Case DatePart("m", strDateTime)
						Case 1
							strOutput = strOutput & "Jan"
						Case 2
							strOutput = strOutput & "Feb"
						Case 3
							strOutput = strOutput & "Mar"
						Case 4
							strOutput = strOutput & "Apr"
						Case 5
							strOutput = strOutput & "May"
						Case 6
							strOutput = strOutput & "Jun"
						Case 7
							strOutput = strOutput & "Jul"
						Case 8
							strOutput = strOutput & "Aug"
						Case 9
							strOutput = strOutput & "Sep"
						Case 10
							strOutput = strOutput & "Oct"
						Case 11
							strOutput = strOutput & "Nov"
						Case 12
							strOutput = strOutput & "Dec"
					End Select
				Case "n"
					strOutput = strOutput & DatePart("m", strDateTime)
				' Case "t" ' number of days in given month
				' year
				' Case "L" ' whether it's a leap year
				' Case "o"
				Case "Y"
					strOutput = strOutput & DatePart("yyyy", strDateTime)
				Case "y"
					strOutput = strOutput & Right(DatePart("yyyy", strDateTime), 2)
				' time
				Case "a"
					If DatePart("h", strDateTime) < 12 Then
						strOutput = strOutput & "am"
					Else 
						strOutput = strOutput & "pm"
					End If
				Case "A"
					If DatePart("h", strDateTime) < 12 Then
						strOutput = strOutput & "AM"
					Else 
						strOutput = strOutput & "PM"
					End If
				' Case "B" ' swatch
				Case "g"
					If DatePart("h", strDateTime) = 0 Then
						strOutput = strOutput & 12
					ElseIf DatePart("h", strDateTime) <= 12 Then
						strOutput = strOutput & DatePart("h", strDateTime)
					Else
						strOutput = strOutput & (DatePart("h", strDateTime) - 12)
					End If
				Case "G"
					strOutput = strOutput & DatePart("h", strDateTime)
				Case "h"
					If DatePart("h", strDateTime) = 0 Then
						strTemp = 12
					ElseIf DatePart("h", strDateTime) <= 12 Then
						strTemp = DatePart("h", strDateTime)
					Else
						strTemp = (DatePart("h", strDateTime) - 12)
					End If
					If strTemp < 10 Then
						strOutput = strOutput & 0 & strTemp
					Else
						strOutput = strOutput & strTemp
					End If
				Case "H"
					If DatePart("h", strDateTime) < 10 Then
						strOutput = strOutput & 0 & (DatePart("h", strDateTime))
					Else
						strOutput = strOutput & (DatePart("h", strDateTime))
					End If
				Case "i"
					If DatePart("n", strDateTime) < 10 Then
						strOutput = strOutput & 0 & (DatePart("n", strDateTime))
					Else
						strOutput = strOutput & (DatePart("n", strDateTime))
					End If
				Case "s"
					If DatePart("s", strDateTime) < 10 Then
						strOutput = strOutput & 0 & (DatePart("s", strDateTime))
					Else
						strOutput = strOutput & (DatePart("s", strDateTime))
					End If
				' Case "u" ' microseconds
				' timezone
				' Case "e" ' timezone identifier
				' Case "I" ' daylight savings time boolean
				' Case "O" ' difference to GMT (0x00)
				'Case "P" ' differenct to GMT (0x:00)
				' Case "T" ' timezone abbreviation
				' Case "Z" ' timezone offset in seconds
				' full
				' Case "c" ' IS0 8601
				' Case "r" ' RFC 2822
				' Case "U" ' seconds since Unix epoch
				Case ""
					bolEscape = 1
				Case Else
					strOutput = strOutput & Mid(strFormatString, intI, 1)
			End Select
		Else
			strOutput = strOutput & Mid(strFormatString, intI, 1)
			bolEscape = 0
		End If
	Next
	
	PHPFormatDateTime = strOutput
End Function
```

<!--more-->

The second function uses a format string like with the standard *NIX date command.  [This is one](http://www.cyberciti.biz/faq/linux-unix-formatting-dates-for-display) of the many sites with information about this format.  The similarly long function follows:

``` asp
Function BASHFormatDateTime(strDateTime, strFormatString)
	Dim intI, strOutput, strTemp, bolEscape
	bolEscape = 0
	
	For intI = 1 to Len(strFormatString)
		If bolEscape = 1 then
			Select Case Mid(strFormatString, intI, 1)
				' day
				Case "d" ' day of month (e.g, 01)
					If DatePart("d", strDateTime) < 10 Then
						strOutput = strOutput & "0" & DatePart("d", strDateTime)  
					Else
						strOutput = strOutput & DatePart("d", strDateTime)
					End If
				Case "e" ' day of month, space padded; same as %_d
					strOutput = strOutput & " " & DatePart("d", strDateTime)  
				Case "a" ' locale's abbreviated weekday name (e.g., Sun)
					Select Case DatePart("w", strDateTime)
						Case 1
							strOutput = strOutput &  "Mon"
						Case 2
							strOutput = strOutput &  "Tue"
						Case 3
							strOutput = strOutput &  "Wed"
						Case 4
							strOutput = strOutput &  "Thu"
						Case 5
							strOutput = strOutput &  "Fri"
						Case 6
							strOutput = strOutput &  "Sat"
						Case 7
							strOutput = strOutput &  "Sun"
					End Select
				Case "A" ' locale's full weekday name (e.g., Sunday)
					Select Case DatePart("w", strDateTime)
						Case 1
							strOutput = strOutput &  "Monday"
						Case 2
							strOutput = strOutput &  "Tuesday"
						Case 3
							strOutput = strOutput &  "Wednesday"
						Case 4
							strOutput = strOutput &  "Thursday"
						Case 5
							strOutput = strOutput &  "Friday"
						Case 6
							strOutput = strOutput &  "Saturday"
						Case 7
							strOutput = strOutput &  "Sunday"
					End Select
				Case "u" ' day of week (1..7); 1 is Monday
					strOutput = strOutput & (DatePart("w", strDateTime))
				Case "w" '  day of week (0..6); 0 is Sunday
					strOutput = strOutput & (DatePart("w", strDateTime, vbSaturday) - 1)
				Case "j" ' day of year (001..366)
					strTemp = DatePart("y", strDateTime)
					If strTemp < 10 Then
						strOutput = strOutput & "00" & strTemp
					ElseIf strTemp < 100 Then
						strOutput = strOutput & "0" & strTemp
					Else
						strOutput = strOutput  & strTemp
					End If
				' week
				Case "U" ' week number of year, with Sunday as first day of week (00..53)
					strTemp = DatePart("ww", strDateTime, vbSunday, vbSunday)
					If strTemp < 10 Then
						strOutput = strOutput & "0" & (strTemp)
					Else
						strOutput = strOutput  & (strTemp)
					End If
				Case "W" ' week number of year, with Monday as first day of week (00..53)
					strTemp = DatePart("ww", strDateTime, vbMonday, vbMonday)
					If strTemp < 10 Then
						strOutput = strOutput & "0" & (strTemp)
					Else
						strOutput = strOutput  & (strTemp)
					End If
				'Case "g" ' last two digits of year of ISO week number
				'  strOutput = strOutput & DatePart("ww", strDateTime)
				' Case "G" ' year of ISO week number (see %V); normally useful only with %V
				' Case "V" ' ISO week number, with Monday as first day of week (01..53)
				' month
				Case "m" ' month (01..12)
					If DatePart("m", strDateTime) < 10 Then
						strOutput = strOutput & "0" & DatePart("m", strDateTime)  
					Else
						strOutput = strOutput & DatePart("m", strDateTime)
					End If
				Case "b", "h" ' locale's abbreviated month name (e.g., Jan)
					Select Case DatePart("m", strDateTime)
						Case 1
							strOutput = strOutput & "Jan"
						Case 2
							strOutput = strOutput & "Feb"
						Case 3
							strOutput = strOutput & "Mar"
						Case 4
							strOutput = strOutput & "Apr"
						Case 5
							strOutput = strOutput & "May"
						Case 6
							strOutput = strOutput & "Jun"
						Case 7
							strOutput = strOutput & "Jul"
						Case 8
							strOutput = strOutput & "Aug"
						Case 9
							strOutput = strOutput & "Sep"
						Case 10
							strOutput = strOutput & "Oct"
						Case 11
							strOutput = strOutput & "Nov"
						Case 12
							strOutput = strOutput & "Dec"
					End Select
				' year
				Case "C" ' century; like %Y, except omit last two digits (e.g., 21)
					strOutput = strOutput & Left(DatePart("yyyy", strDateTime), 2)
				Case "y" ' last two digits of year (00..99)
					strOutput = strOutput & Right(DatePart("yyyy", strDateTime), 2)
				Case "Y" ' full year
					strOutput = strOutput & DatePart("yyyy", strDateTime)
				' time
				Case "P" ' like %p, but lower case
					If DatePart("h", strDateTime) < 12 Then
						strOutput = strOutput & "am"
					Else 
						strOutput = strOutput & "pm"
					End If
				Case "p" ' locale's equivalent of either AM or PM; blank if not known
					If DatePart("h", strDateTime) < 12 Then
						strOutput = strOutput & "AM"
					Else 
						strOutput = strOutput & "PM"
					End If
				Case "l" ' hour ( 1..12)
					If DatePart("h", strDateTime) = 0 Then
						strOutput = strOutput & 12
					ElseIf DatePart("h", strDateTime) <= 12 Then
						strOutput = strOutput & DatePart("h", strDateTime)
					Else
						strOutput = strOutput & (DatePart("h", strDateTime) - 12)
					End If
				Case "k" ' hour ( 0..23)
					strOutput = strOutput & DatePart("h", strDateTime)
				Case "I" ' hour (01..12)
					If DatePart("h", strDateTime) = 0 Then
						strTemp = 12
					ElseIf DatePart("h", strDateTime) <= 12 Then
						strTemp = DatePart("h", strDateTime)
					Else
						strTemp = (DatePart("h", strDateTime) - 12)
					End If
					If strTemp < 10 Then
						strOutput = strOutput & 0 & strTemp
					Else
						strOutput = strOutput & strTemp
					End If
				Case "H" ' hour (00..23)
					If DatePart("h", strDateTime) < 10 Then
						strOutput = strOutput & 0 & (DatePart("h", strDateTime))
					Else
						strOutput = strOutput & (DatePart("h", strDateTime))
					End If
				Case "M" ' minute (00..59)
					If DatePart("n", strDateTime) < 10 Then
						strOutput = strOutput & 0 & (DatePart("n", strDateTime))
					Else
						strOutput = strOutput & (DatePart("n", strDateTime))
					End If
				Case "S" ' second (00..60)
					If DatePart("s", strDateTime) < 10 Then
						strOutput = strOutput & 0 & (DatePart("s", strDateTime))
					Else
						strOutput = strOutput & (DatePart("s", strDateTime))
					End If
				' Case "N" ' nanoseconds
				' Case "s" ' seconds since unix epoch
				' Case "z", ":z" ..., "Z" all for timezone
				' formatted
				Case "c"
					strOutput = strOutput & BASHFormatDateTime(strDateTime, "%a %b %e %T %Y")
				Case "D"
					strOutput = strOutput & BASHFormatDateTime(strDateTime, "%m/%d/%y")
				Case "F"
					strOutput = strOutput & BASHFormatDateTime(strDateTime, "%Y-%m-%d")
				Case "r"
					strOutput = strOutput & BASHFormatDateTime(strDateTime, "%I:%M:%S %p")
				Case "R"
					strOutput = strOutput & BASHFormatDateTime(strDateTime, "%H:%M")
				Case "T"
					strOutput = strOutput & BASHFormatDateTime(strDateTime, "%H:%M:%S")
				' Case "x" ' locales date representation
				' Case "X" ' locales time representation
				' etc
				Case "n"
					strOutput = strOutput & "<br />" ' or vbcrlf
				Case "t"
					strOutput = strOutput & "    " ' or vbtab
				Case Else
					strOutput = strOutput & Mid(strFormatString, intI, 1)
			End Select
			bolEscape = 0
		Else
			If Mid(strFormatString, intI, 1) = "%" Then
				bolEscape = 1
			Else
				strOutput = strOutput & Mid(strFormatString, intI, 1)
			End If
		End If
	Next
	
	BASHFormatDateTime = strOutput
End Function
```

For testing purposes,  I stuck those in a file with this form and processor for testing:
``` asp
If Request.Item("format") & "" <> "" Then
	Dim i, varDate, varOutput
	Dim varDatePart

	For i = 1 to  31
		'set date
		If i <= 24 then
			varDatePart = i - 1
		Else 
			varDatePart = 1
		End If
		
		'varDate = varDatePart & "/" & i
		 If i < 10 Then
			varDate = "2009-01-0" & i & " " & varDatePart & ":" & (varDatePart + 10) & ":" & (varDatePart + 23)
		Else
			varDate = "2009-01-" & i & " " & varDatePart & ":" & (varDatePart + 10) & ":" & (varDatePart + 23)
		End If
		
		'Response.Write(PHPFormatDateTime(varDate, "F jS, Y") & "<br />")
		'Response.Write("Date: " & PHPFormatDateTime(varDate, "w d l the jS M(F) Z W m/d y(Y) g:i:s a G:i:s h:i:s A H:i:s") & "<br />")
		'Response.Write(DatePart("w", varDate) & "<br />")
		Select Case Request.Form("type")
			Case "PHP"
				Response.Write(PHPFormatDateTime(varDate, Request.Form("format"))&"<br />")
			Case "BASH"
				Response.Write(BASHFormatDateTime(varDate, Request.Form("format"))&"<br />")
		End Select
	Next
End If
```

I don't code in classic ASP at all anymore, and I think .NET is taking over that segment of development, but hopefully this will help someone stuck with old servers anyway.
