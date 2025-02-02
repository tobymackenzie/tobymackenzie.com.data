---
categories: [computer]
date: 2021-02-20T01:50:09-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3291'
id: 3291
modified: 2021-02-20T01:50:09-05:00
name: easily-typed-passwords
tags: [password, security, ux]
---

Easily typed passwords
======================

I came across an interesting [Stackexchange question about easy to type passwords](https://security.stackexchange.com/questions/166725/how-to-generate-easy-to-type-passwords-without-sacrificing-security).  It seems a useful consideration for passwords we have to type frequently.  Reading through the answers got me to thinking about a solution that fits the criteria of easy / fast to type along with the general password criteria of easy to remember and some reasonable level of secure.

My solution considers typing style for determining ease and uses words and rules for making them memorable.  It keeps to the rules from the question of at least one upper case letter, one number, and one symbol.

<!--more-->

What makes something quick and / or easy to type will depend a lot on how we individually type and will be fairly personal.  In general, we might be hunt and peckers or touch typists.  If we are hunt and peckers, adjacent keys will likely be the best.  For good touch typists, words and sentences will likely be quickest to gain security entropy, but we'll use some adjacency or movement considerations for the non-word parts of the password.

To aid with memory of a given password, we can use words or sentences, generally more memorable than random strings.  We can use a fixed set of rules for all passwords.  We can make our number(s) and symbol(s) chosen with a rule based on the word / sentence used, so that there is less to remember.

We make use of spaces for the sentences.  If a password system doesn't allow this, we could use another character, like '.' in its place.  If a system doesn't allow certain special characters, we will have to decide on a rule to deal with that, but that's harder since the system could restrict any given character.  We could just always use a ';' in place of that character, for example.  We'd then have to remember if a given site has a given restriction.

The chosen rules can make for more or less secure passwords.  We could create a different set of rules based on a chosen security level for a given system, eg length of words or sentences, length of rolls.

It's unlikely most attackers would even notice that we're using a rule set if they break one of our passwords, but a dedicated attacker that did would have an advantage in attacking our other passwords.  Here, the leveled rule sets and increased difficulty of guessing the memorized part is important.

We can, of course, use a password manager for most systems and use the easy typing scheme for the password manager's password and other systems we can't use the manager for.

Hunt and peckers
---------

Pick a fairly short single word.  Create a rule, where we will motion to the right or left and move n characters in that direction.  Three to four seems easiest.  A number can either be memorized or we can make a rule that the number is up-column from the first or last letter of the word.  We would then either start with the number or the first letter of the word, rolling our number of characters to the left or right.  We'd move on to the next character of the word, doing the same thing, until all letters of the word and the number are typed.  We'd hold shift for the first letter of the word, and for the number, while we release it for the roll.  If rolling in our direction reaches the end of a row on the keyboard before we've rolled our number of characters, we'd switch directions and continue rolling until we've typed them all.

Examples:

- Rule: roll 3 characters, direction left, symbol up-column from last letter
	Memorize: fast
	Result: Fdsasdsastre%43
- Rule: roll 4 characters, uppercase first roll, direction toward middle of keyboard, symbol up-column from last letter
	Memorize: noun
	Result: NBVCoiuyuytrnbvc^543
- Rule: roll 5 characters, uppercase each letter from word, direction toward closest side of keyboard to letter, memorized number with number then symbols
	Memorize: run 3
	Result: RewqwUiopNm,./[3@!@#

It might be worth it to roll back and forth for extra length without much more effort, eg:

- Rule: roll 3 characters, direction left, roll back to starting character, symbol up-column from last letter
	Memorize: fast
	Result: Fdsdfasdsasastrert%4345
- Rule: roll 2 characters, direction toward middle of keyboard, 5 character back and forth roll, symbol up-column from last letter
	Memorize: fast
	Result: Fgfgfasasasdsdstytyt%6565

Rolling could also be done moving up and down column, in a square shape, or other such patterns.

Touch typists
---------

Pick a short, memorable sentence that feels quick enough to type, with words that are easy to spell and flow well.  Switching fingers each letter is good for speed.  Create a rule for the symbol and number to be based off the first or last letter typed such as using the number / symbol up-column from that letter, eg '3#' for the letter 'd'.  Or we could go up-column for the same finger on the opposite hand.  We'd have a rule to either start by typing the letter + symbol combo and then type the sentence, or type the sentence and then the combo. The sentence would start with a capital letter.  Examples:

- Rule: number up-column from last letter, number then symbol
	Memorize: the pig likes delicious food
	Result: The pig likes delicious food3#
- Rule: number up-column from opposite finger of first letter, number then symbol
	Memorize: form a line behind me please
	Memorize: under the table and streaming
	Result: 7&Under the table and streaming
- Rule: four words, number up-column from last letter, symbol then number
	Memorize: You are the bestest
	Result: You are the bestest%5

If we wanted more number / symbol characters, we could use a roll to one side of our symbol / number character like in the hunt and pecker setup, like:

- Rule: symbol up-column from last letter, symbol then roll left three numbers
	Memorize: the pig likes delicious food
	Result: The pig likes delicious food#212

We can tweak these to make them easiest / best for ourselves while reaching a comfortable level of security.
