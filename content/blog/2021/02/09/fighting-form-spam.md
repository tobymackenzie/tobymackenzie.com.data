---
categories: [www]
date: 2021-02-09T01:07:50-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3271'
id: 3271
modified: 2021-02-09T01:07:50-05:00
name: fighting-form-spam
pings: ['https://www.tobymackenzie.com/blog/2020/06/21/2907/']
tags: [form, problem, spam, web]
---

Fighting form spam
==================

Cogneato has dozens of sites with openly submittable forms on them, and they have no doubt all had some level of problems with spam submissions.  Bots, and perhaps people, like to share their links or services, try to hack sites, or whatever other nefarious or annoying purposes they may have through forms, which require some sort of server side processing, and will possibly result in human processing as well, such as with sent emails, database data, or comments on a website.

Spammers have gotten more sophisticated over time, and over the last year or two, have really started to hit Cogneato's sites hard and get past the protections we had in place.  We've had to add protections on forms that didn't have them before, and use more techniques to attempt to detect spam.  We've recently added a set of checks of the submitted form data and the submitter IP address that produces a score of "spaminess" that we can then use to block the submission if the score is above a threshold.  That score script is the primary purpose of this post, but I will cover the other techniques we use as well.

<!--more-->

Hackers
-------

Though this post is mainly about spam, first I will note that forms are also a target for hackers.  Validate submitted data.  Use bound parameters, such as what [PDO](https://www.php.net/manual/en/book.pdo.php) provides, when using user content in SQL queries to prevent SQL injection attacks.  Use things like CSRF tokens to protect users.  Limit what files can be uploaded and keep them out of the web-root.  Escape or remove dangerous content from strings that will be output on sites.

Incentive
---------

We don't have any more sites that directly display (non-admin) user content on sites, as it can be tough for us and for clients, and tantalizing for spammers and hackers.  This brings up the point that spammers spam to achieve a goal, and if you limit the benefit they gain from spamming, you limit the incentive to try.  We once had some functionality in our software that allowed a form submission to send an email with arbitrary content to any email address the submitter wanted.  This eventually got found by bots and got hit heavily, like 100s of thousands of times, presumably to spam whatever addresses the spammer wanted.  We quickly removed that functionality and eventually the bots stopped hitting those URLs.

Most of our open forms these days just store data in a database and maybe email an administrator.  If it emails submitted email address, the content is largely fixed values, and content from the form generally won't include text areas or URLs.  This limits the value bots get from submitting the forms in the first place.

Captcha
-------

A long time solution for form spam has been to use a Captcha or related technique, basically a test the form submitter must perform to prove they're human, the idea being that bots will have trouble with the test.  These have gotten more sophisticated in order to keep up with improvements in spam bot capability and attempt to improve user experience.  The most popular is [Google's Recaptcha](https://developers.google.com/recaptcha/), which we use at Cogneato on most of our open forms that don't accept payments, and [even some that do](https://www.tobymackenzie.com/blog/2020/06/21/2907/).

Recaptcha may only require a user to check a box or even do nothing at all.  This reduces or eliminates the user experience hit that Captcha's take.  However, it still seems to happen frequently that Recaptcha's more involved test is triggered, where one must click on pictures matching a text description.  This can be very annoying.  As such, this technique is a compromise.

Recaptcha works against a lot of bots, and was mostly sufficient for quite a while, but [more and more have been managing to get through](https://www.tobymackenzie.com/blog/2020/09/07/recaptcha-solved-by-bots/), especially in the last year.

Honeypot
-----

Before the bots really started to ramp up, some sites were getting some spam but not enough that they wanted to add the user inconvenience of captcha to their forms.  We implemented simple solution for those sites by adding a honeypot, a form field that regular users aren't supposed to fill out, and if the form processor sees the field filled, it will know that it's a bot.  This can be done something like:

``` html
<form method="POST">
	…
	<label style="display:none !important">
		Leave blank
		<input autocomplete="off" name="hunny" tabindex="-1" />
	</label>
	…
</form>
```

for the client, and then on the server:

``` php
if(!empty($_POST['hunny'])){
	header("HTTP/1.1 500 Server error");
	die("500 Server error");
}
```

Technically that should probably be a 400 error, but I didn't want to give the bots any hints.

This seemed to help some when we first implemented it, but I haven't seen it getting filled more recently.  None-the-less, defense in depth.

Spaminess score
-------

When more and more spam started getting through recently, we looked for another protection option, but couldn't find anything pre-built that looked good to us.  We implemented a few checks in our code for certain IPs and specific field content.  This was sort of a game of whac-a-mole though.  So we morphed this work into a spaminess score.

The idea is that various signs of spaminess are taken into account, each giving an integer score based on likelihood of it indicating spam and unlikelihood of it being in a legitimate submission.  If the total score goes above a given value, such as `100`, the form will be considered spam, and will not process, instead showing an error to the user in the same way it would if they put an invalid value in a field.  This would allow valid users an ability to correct their mistakes, though it isn't telling them specifically what to change.

The signs we have are IPs and form data string based.  The IPs are ones we've seen frequently submitting spam in the logs, with more submissions making for a higher score.  Those are manually added, and we've largely stopped adding to the list in favor of making the form data checks more robust.  IPs that have spammed us particularly relentlessly are `5.188.84.115`, `5.188.84.228`, and `185.7.145.88`.

The form data signs have been based mostly on actual submissions that have gotten through, with us adding more signs until the spam tests show as spam but the valid tests still show as valid.  We have hundreds of strings to check against.  The code converts the strings to lowercase and normalizes them.  It also tests JSON encoded and uses the higher score, to deal with some special string encodings that get escaped in JSON.  The count of occurrences of a given string are used to determine a multiplier for that strings score: The multiplied value is added to the running total.

A given string might be in the list multiple times to try to catch various ways spam bots will say something.  So a given word might give a small score, but if used in a phrase, it would add a larger score.  Strings are of many types based on what we've seen in forms, such as:

- html and links (there almost always are links)
- special characters
- marketing speak
- site owner products (eg seo, marketing, domain expiration)
- user targeting products (eg sex, drugs, music, gambling, crypto)
- email content (eg dear, unsubscribe)
- url shorteners
- weird words or turns of phrase that humans would not likely use
- random combos of words (very whac-a-mole)

Since our software is used by dozens of sites in different industries, including marketing and medicine, we have to be careful about giving some common spam strings too high of a score.  Sites can override the functions and lists, though we haven't needed to do that yet.  Ideally, we'd group the strings into categories and allow a given site to adjust the multiplier of scores in that category to match their needs.

There also are some signs based on specific named fields.  It's particularly common for bots to submit a first and last name that are the same or with two characters appended to the other.  It's also common to have various address fields with the same values.  Email addresses ending in ".ru" are not uncommon.

The code is very long for a blog post, but a simplified version that just checks form data looks something like:

``` php
class Forms{
	const MAX_SPAMINESS = 100;
	protected $spamStringRegex = [
		'!http(s)?:(\\\)*/(\\\)*/!i'=> 25, //URL
		'!<[\\\]*/[\w:-]+>!'=> 20, //HTML
		'!<[\\\]*/a>!i'=> 25, //HTML link
		'!\\\u[\w]!i'=> 30, //special characters
		'/[\p{Cyrillic}]/'=> 30, //special characters
		'/ in just [\d\.]+ /i'=> 8, //marketing speak
		//…
	];
	protected $spamStrings = [
		'your website'=> 10,
		'unsubscribe: '=> 10,
		'check out'=> 10,
		'satisfaction guaranteed'=> 8,
		'casino'=> 30,
		'porn'=> 80,
		'marketing'=> 8,
		''=> 12,
		'Ð'=> 18,
		//…
	];

	protected function getCountMultiplier($count){
		if($count >= 15){
			return 4;
		}elseif($count >= 10){
			return 3.5;
		}elseif($count >= 5){
			return 3;
		}elseif($count >= 3){
			return 2;
		}elseif($count >= 2){
			return 1.5;
		}elseif($count){
			return 1;
		}else{
			return 0;
		}
	}
	protected function getStringSpaminess($string, $stopAt = null){
		$score = 0;
		if(!isset($stopAt)){
			$stopAt = static::MAX_SPAMINESS;
		}
		if(is_array($string)){
			foreach($string as $stringItem){
				$score += $this->getStringSpaminess($stringItem);
				if($score >= $stopAt){
					break;
				}
			}
		}else{
			if(class_exists('Normalizer')){
				$string = Normalizer::normalize($string);
			}
			foreach($this->spamStringRegex as $test=> $testScore){
				if(preg_match($test, $string, $matches)){
					$count = count($matches[0]);
					if($count){
						$score += $this->getCountMultiplier($count) * $testScore;
					}
					if($score >= $stopAt){
						break;
					}
				}
			}
			foreach($this->spamStrings as $test=> $testScore){
				$count = substr_count(strtolower($string), $test);
				$countJSON = substr_count(json_encode(strtolower($string)), $test);
				$count = $count > $countJSON ? $count : $countJSON;
				if($count){
					$score += $this->getCountMultiplier($count) * $testScore;
				}
				if($score >= $stopAt){
					break;
				}
			}
		}
		return $score;
	}
	public function getRequestSpaminess($formData, $stopAt = null){
		if(!isset($formData)){
			$formData = $_POST;
		}
		if(!isset($stopAt)){
			$stopAt = static::MAX_SPAMINESS;
		}
		$score = $this->getStringSpaminess($formData, $stopAt);
		if($score >= $stopAt){
			return $score;
		}
		//… test IP similarly
		if(!empty($formData['firstName']) && !empty($formData['lastName'])){
			if($formData['firstName'] === $formData['lastName']){
				$score += 90;
			}elseif(substr($formData['lastName'], 0, strlen($formData['firstName'])) === $formData['firstName']){
				$score += 50;
				if(strlen($formData['firstName']) + 2 === strlen($formData['lastName'])){
					$score += 10;
					if(preg_match('/[A-Z]{2}$/', $formData['lastName'])){
						$score += 30;
					}
				}
			}
			if($score >= $stopAt){
				return $score;
			}
		}
		//… test address fields similarly
		return $score;
	}
}
```

This would then be used in the form processing something like:

``` php
//…
$formData = $form->getData();
$formService = new \Form();
if($formService->getRequestSpaminess($formData) >= Form::MAX_SPAMINESS){
	$form->addError(new \Symfony\Component\Form\FormError("Your request looks suspicious.  Please simplify your request with fewer links, special characters, marketing speak, etc."));
}
//…
```

as an example snippet for a Symfony form processing action, where that error would cause the form to be marked invalid and to be displayed to the user again with that error message.

Though we don't do a lot of unit testing of our code base, we definitely have unit tests for this.  This helps ensure that any tweaks to the sign strings and scores don't cause problems.  Now that we have the scores in a pretty good state, we do spot checks on submissions occasionally to look for problems with false positives and negatives.  We have logging of submission data to help with this.

Some submissions that are clearly spam we just have to live with letting through because they have too little to go on or otherwise would be too similar to valid submissions.

This has been pretty successful for us so far, dramatically slowing down the intake of spam for our clients, and thus reducing the amount of time they have to spend sifting through spam to find the real customer submissions.  It blocked something around 2k requests across our sites last week, though that count is before any captcha checks would've been sent.  Hopefully, it will keep blocking spam requests and letting through real user requests.
