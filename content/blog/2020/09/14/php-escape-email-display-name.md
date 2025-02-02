---
categories: [www]
date: 2020-09-14T17:31:40-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=3029'
id: 3029
modified: 2020-09-14T17:31:40-04:00
name: php-escape-email-display-name
tags: [email, php]
---

PHP: Escaping email display name
================================

I recently had the need to take a name from a form submission and use it as the display name of the "From" address of an email sent through [PHP's `mail()` function](https://www.php.net/manual/en/function.mail.php).  For an address like `Toby Example <t@example.com>`, the display name is the `Toby Example` part.<!--more-->  Coming from a form, this could contain invalid or even malicious characters, so I wanted to remove these characters or encode them safely.  It was easy to find info on handling the actual email address, but a little harder to find info on the full address format.  I eventually found [this StackOverflow answer](https://stackoverflow.com/a/7670192/1139122) to figure out what I needed.

In our solution, we make use of [PHP's `mb_encode_mimeheader()` function](https://www.php.net/manual/en/function.mb-encode-mimeheader.php) with the "Quoted-Printable" (`Q`) format to encode any strings that need it.  We wrap it in double quotes to deal with most ASCII control characters and escape any internal double quotes with `\`.

Our solution might look like:

``` php
$userDisplayName = 
	'"' 
	. str_replace('"', '\"', mb_encode_mimeheader($_POST['name'], 'UTF-8', 'Q')) 
	. '"'
;
$userEmail = mb_encode_mimeheader($_POST['email'], 'UTF-8', 'Q');
$headers = 
	"From: {$userDisplayName} <" . getAdminEmail() . ">\r\n"
	. "Reply-To: {$userDisplayName} <{$userEmail}>"
;
mail(
	getAdminEmail()
	,'Test'
	,'Testing message'
	,$headers
);
```

Our basic goal was to make it simpler to see who submitted the form in an email client.  We use the admin email address for the `From` because we need to be sure that we can send from the address ([SPF](https://en.wikipedia.org/wiki/Sender_Policy_Framework), etc), but the user's display name so the client will show us who submitted it.  We put the user's full address in the `Reply-To` so it is easy to respond to the user.
