---
date: 2026-08-06T22:16:00-05:00
tags: [phone,privacy,security]
---

Secure privacy dumbish phone
============================

- OS
	- open source, probably Linux or BSD based
	- minimal, with unnecessary stuff stripped
	- data and memory encrypted
- hardware
	- open hardware where possible
	- preferably some level of waterproof, shockproof
	- physical kill switches on risky hardware
	- tamper resistant / evident enclosure
	- preferably 4G + 5G capable (prevents obsolescence) with kill switch
	- camera with kill switch
	- mic with kill switch
	- LED flashlight
	- wi-fi / bluetooth with kill switch
	- bluetooth audio only
	- usb c charging and data port
		- possibly with data kill switch
		- fuse to prevent voltage attack
- firmware
	- tamper evident chip enclosure, should destroy chip if open attempted
	- read only chip with original firmware verifies updated firmware
	- updated firmware must be signed by manufacturer or will show special menu on boot, show blinking led of different color or some such
	- special menu will have message that firmware doesn't match, options: restore original firmware, boot in risky state, turn off
	- in risky state, will have visible sign like blinking led of different color, icon on screen at all times
	- risky state primarily to allow custom firmware if desired or if company goes under
- software functionality
	- most comms plus camera
	- phone
	- SMS
	- email over IMAP with PGP support
	- possibly open source encrypted chat
	- possibly simple web browser, no CSS or JS
	- notes?
- login
	- two login levels with separate credentials
	- can configure each comms type, for email each mailbox
		- not logged in: show only icon, show subject, show full message
		- login level one: show only icon, show subject, show full message
	- login level one may also optionally see saved photos and other data, certain settings
	- login level two allows fully message and data access, settings, etc
	- logs out when phone closed or slept, when accelerometer detects sudden movement, possibly other signals of nefarious activity
	- may use password, biometric, or key for login one
	- must use 2FA or long password for level two
- data retention
	- option to not retain any data of each comms type, camera after initial observation or period of time
	- option to copy each type of data to remote server over SSH / SCP with key, possibly other open protocols
	- option to only store data in memory, gets wiped on reboot or detected nefarious activity
	- can sync to usb flash drive only from level two

