---
date: 2026-08-06T22:16:00-05:00
modified: 2026-08-10T16:35:00-05:00
tags: [phone,privacy,security]
---

Secure privacy dumbish phone
============================

A secure dumbish phone would be created within login levels, open source where possible, hardened hardware and software.

- OS
	- open source, probably Linux or BSD based
	- minimal, with unnecessary stuff stripped
	- data and memory encrypted
- hardware
	- open hardware where possible
	- preferably some level of waterproof, shockproof
	- physical kill switches on risky hardware: cell comms, local comms, camera, mic, usb data?
	- tamper resistant / evident enclosure
	- preferably 4G + 5G capable (prevents obsolescence)
	- camera
	- mic
	- LED flashlight
	- wi-fi / bluetooth
	- bluetooth audio only
	- usb c charging and data port
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
	- not logged in is "guest" mode, probably calls out only, for handing to unknown person who wants to make call
	- two logged in levels with separate credentials
	- can configure notifications for each comms type, for email each mailbox
		- not logged in: show only icon, show subject, show full message
		- login level one: show only icon, show subject, show full message
	- can configure access for each comms / data type for what level needed to use
		- send / create only, read only, both
	- login level one may optionally see saved photos and other data, certain settings
	- login level two has full access to everything
	- logs out when phone closed or slept, when accelerometer detects sudden movement, possibly other signals of nefarious activity
	- may use password, biometric, or key for login one
	- must use 2FA or long password for level two
	- if dual sim, likely has separate account / login pair for each sim, or second sim can be set for guest mode with full access
- data retention
	- option to not retain any data of each comms type, camera after initial observation or period of time
	- option to copy each type of data to remote server over SSH / SCP with key, possibly other open protocols
	- option to only store data in memory, gets wiped on reboot or detected nefarious activity
	- can sync to usb flash drive only from level two

