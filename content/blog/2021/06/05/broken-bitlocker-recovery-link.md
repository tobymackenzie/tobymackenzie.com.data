---
categories: [computer]
date: 2021-06-05T23:24:40-04:00
date_gmt: 2021-06-06T03:24:40+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3427'
id: 3427
modified: 2021-06-05T23:24:40-04:00
modified_gmt: 2021-06-06T03:24:40+00:00
name: broken-bitlocker-recovery-link
tags: [bitlocker, problem, windows]
---

Broken Bitlocker recovery link
==============================

Apparently, Microsoft gives the wrong link for their Bitlocker recovery key page on both the Bitlocker recovery screen on the device and on the Microsoft account web page.<!--more-->  The link they give points to <https://account.microsoft.com/devices/recoverykey> and simply says:

> Try a different URL
> We don’t have anything to show you at this link. Try searching for what you want, instead.

That provides little useful information, and there is, of course, no search functionality anywhere on the page.  However, the message did lead me to [this MS answers page](https://answers.microsoft.com/en-us/windows/forum/windows_10-security/bitlocker-recovery-key-not-accessible-on-microsoft/2acf2cb6-d27a-4cf5-9a66-9a09f2ecb7da) that led me to the correct location: <https://onedrive.live.com/RecoveryKey>.

Considering that the answer was from 2018, this has been a longstanding problem.  I would think that Microsoft could afford and manage in three years to switch the links, add a redirect from the old link, and possibly add search functionality to their accounts site.

I discovered this after booting into a Ubuntu USB stick.  Too suspicious for Microsoft.  I may have to enter my key a lot then, since I plan to dual boot.  What a pain.
