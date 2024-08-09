---
categories: [www]
date: 2016-04-29T00:27:02-05:00
date_gmt: 2016-04-29T05:27:02+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=1106'
id: 1106
modified: 2016-04-29T00:27:02-05:00
modified_gmt: 2016-04-29T05:27:02+00:00
name: email-attachments-php-mail
tags: [email, php]
---

Sending email attachments with PHP `mail`
=========================================

I recently had to set up a PHP script to send an email with an attachment.  With the current version of our CMS, we have [swiftmailer](http://swiftmailer.org/) available, which would make this easy, but for this site, I didn't have it easily available.  I considered bringing it in, but since this was just a simple script, I decided to give a go at doing it directly with PHP's built in `mail()` function.  I found [an answer on StackOverflow](http://stackoverflow.com/a/31428803) to guide me.  Many respondents to that question recommended just using a library, but the answers that didn't seemed reasonable.

It took me a number of failed attempts to get the headers and line-breaks just right so that both the email message and attachment sent properly, but I got it working.  The code of my solution was fairly specific to the application, so I've modified it to make it more generically applicable for this post.  The (untested but generic) variant of the solution looks like:

<!--more-->

``` php
function mailWithAttachement($to, $subject, $message, $opts = Array()){
	$separator = (isset($opts['seperator']) ? $opts['seperator'] : 'separator_' . md5(time()));
	$headers = '';
	if(!isset($opts['headers'])){
		$opts['headers'] = Array();
	}
	if(isset($opts['from'])){
		$value = $opts['from'];
		if(isset($opts['fromName'])){
			$value = str_replace(";", "", str_replace(",", "", $opts['fromName'])) . ' <' . $opts['from'] . '>';
		}
	}
	if(!isset($opts['headers']['Mime-Version'])){
		$opts['headers']['Mime-Version'] = "1.0";
	}
	if(!isset($opts['headers']['Content-Type'])){
		$opts['headers']['Content-Type'] = "multipart/mixed; boundary=\"{$separator}\"";
	}
	foreach($opts['headers'] as $header=> $value){
		if(is_string($header)){
			$headers .= "{$header}: {$value}\r\n";
		}else{
			$headers .= $value . "\r\n";
		}
	}
	$headers .= 
		"--{$separator}\r\n"
		. "Content-Type: text/html; charset=\"us-ascii\"\r\n"
		. "Content-Transfer-Encoding: 7bit\r\n\r\n"
		. $message
	;
	//-@ http://stackoverflow.com/a/31428803
	if(isset($opts['file']) && file_exists($opts['file'])){
		$fileContent = file_get_contents($opts['file']);
		$fileContent = chunk_split(base64_encode($fileContent));
		$fileName = (isset($opts['fileName']) ? $opts['fileName'] : basename($opts['file']));

		$headers .= 
			"\r\n\r\n--{$separator}\r\n"
			. "Content-Type: application/octet-stream; name=\"" . $fileName . "\"\r\n"
			. "Content-Transfer-Encoding: base64\r\n"
			. "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n\r\n"
			. $fileContent
		;
	}
	$headers .= "\r\n\r\n--{$separator}--\r\n";
	mail($to, $subject, null, $headers, (isset($opts['parameters']) ? $opts['parameters'] : null));
}
```

I tried to follow the signature of `mail()` itself for the first three arguments, but then just put everything else in an `$opts` array for simplicity.  The options that can be passed in with `$opts` are:

- 'file': Absolute path of file to attach.  None of the file stuff will be done if this isn't set.
- 'fileName': If you want a different name than the one from the path, this allows you to set it.
- 'from': Email address to send to.  can alternatively manually create the header with 'headers'.
- 'fromName': If set, will add a name part to the `From` header (the part many clients show as the 'From' to be clean).
- 'headers': An array of headers for the email.  If none are passed, this will be constructed automatically.
- 'parameters': The fifth argument to the `mail()` function, these get passed to the underlying mail implementation.
- 'seperator': If you want to set the boundary separator for the email parts, pass this in.  Otherwise, it will be automatically generated.

Other notes:

- This example only allows an HTML message, as that's all I had available.  In the interest of progressive enhancement, a text version should be provided, but I didn't test that.
- There were some hints in the StackOverflow responses that the separator needed to be more unique, but I didn't have a problem.  I added the 'separator_' bit just to make it less likely to occur anywhere else.
