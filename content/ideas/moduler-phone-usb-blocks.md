---
date: 2026-08-07T00:05:00-05:00
tags: [phone,standard]
---

Modular cell phone via generic USB blocks
======

Cell phone device would be composed of multiple standardized, purpose specific components / modules that could be replaced individually, added, or removed.  Modules would be built to and use a communication standard used by all manufacturers.  Each module would be the width and depth of a normal cell phone, with one or a few standards, but the height it needs to be to fit its contents.  Each except the end one would have a standard male USB C connector on one side and a female USB C on the other, such that each can connect to the next module.  Each USB C port would support power delivery, data transfer, and video (alt display-port mode) so that all components can daisy chain and be controlled by the controller module.

- Any module can be replaced by another, can be from any manufacturer supporting the standard
- Allows user to upgrade, downgrade, or remove modules as desired
- Allows user to choose putting more money into modules that matter to them, eg if they take a lot of pictures, they can go for a better camera module.  If they need a lot of battery, they can go for a bigger battery module.
- Could also attach generic USB devices when form factor isn't as important
- special screen and antenna modules would have block with larger flat piece connected to one face, which would overlap other blocks
	- may have magnets in each block face or some side pieces that hold the block depth plus screen and antenna depth, hold things together
	- screen would go on once face, antenna on other
	- only including antenna assuming it needs to be larger than a block:  If not needed, won't have it
- Applicable modules would work as generic device when connected directly to a computer.

Modules
-------

### Controller

CPU, RAM, OS storage, tiny battery to keep things alive when main battery not attached.  Buttons, maybe small LCD or e-ink screen for control, notifications.  May be where mic / speakers are.

### Cell comms

Module with cellular communication chip, could be updated when new wireless generation comes out without upgrading rest of phone.  Probably would need to be antenna module.  Could remove to disable comms.  Could provide cellular internet to regular computer if connected.

### Local comms

Wi-fi and bluetooth.  May need to be part of controller, or cell comms if more antenna space needed.

### Sensors

GPS, acceleration, etc.  May be part of controller block if that makes more sense.  USB usage on a computer might be a compelling alternate use though.

### Screen

- Could choose bigger or smaller display (may require more or less blocks.
- Could choose nice OLED or whatever smart display, small simple LED dumb display with keypad, e-ink display, or any other screen / face possibilities
- Could have multiple and switch when desired
- Would work as a tiny monitor when connected to a regular computer

### Drive

personal date storage.  Would work like a flash drive on a personal computer, or allow easy transfer of phone data to computer.

### Battery

Main battery, size as desired, replace if needed.  Could add multiple if you want to be able to go lighter at times, are going on a trip, or happen to have more than one.  Could charge or run other USB C devices within system's power draw.

### Camera

Lenses, flash
- probably would have both front and back cameras if desired, couldn't do screen notch or hole
- would likely need to be the top module, above the reach of the screen / antenna
- would be webcam when connected to regular computer

### Spacer

Simply passes through USB signal, to be used when you don't need more modules but have more screen height to get blocks behind.  End spacer without male connector might be the easiest way to get an end piece without limiting other modules.

### Special

This would allow more specialized modules like Moto Z and other similar devices had.  Bigger speakers, micro projector, specialized sensors, built in credit card reader for business use, etc.

Manufacturer motivation
----------

This would, of course, result in phone manufacturers selling less full phones down the line, which would be a big disincentive.  But, if they have desirable modules, good or cheap or new tech, they could also make a lot of sales to people who have different phone brands.  People might buy multiple of a given type to be able to swap them out for different purposes, like having a smarter phone for work days and a dumber phone for weekends or vacation.  People might be quicker to swap up to newer tech when the price is cheaper than a whole new phone.  If done right, I think they could end up doing better overall.

Consumer motivation
----------

Consumers could upgrade the bits that need upgrading more frequently, such as cell modems when new generations come out, for cheaper than a whole new phone.  They could get whatever features they want that are available.  They could have a single device that could switch capabilities, sizes, and weights for different purposes.  They wouldn't need to transfer data to a new device as often.  If they now have separate work and personal phones, they could instead just swap out work and personal modules for a much smaller overall package.  They could make other uses of these modules with computers or other devices when they're done with them for their phone.  They would likely be able to buy and sell modules on the used market and have them be useful for far longer.  Would have less vendor lock-in.

Societal motivation
------

Being able to reuse modules would be able to reduce overall e-waste quite a bit.  Used markets would likely make it easier for less wealthy people get better modules quicker and cheaper.  Would likely allow smaller innovators to enter markets and come up with cool ideas for specific modules.  Or big companies to sell must have patented ideas to multiple phone ecosystems.
