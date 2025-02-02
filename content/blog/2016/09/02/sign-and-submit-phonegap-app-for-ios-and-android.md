---
categories: [www]
comment_count: 1
date: 2016-09-02T01:11:48-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1247'
id: 1247
modified: 2016-09-02T01:13:29-05:00
name: sign-and-submit-phonegap-app-for-ios-and-android
tags: [android, app, ios, mobile, phonegap, submit]
---

Sign and submit PhoneGap app for iOS and Android
================================================

After some struggling, I got the PhoneGap app for the [Akron Art Prize](http://akronartprize.org/) submitted to the iOS and Android app stores.  Since it was a new thing for me and I wanted to ensure I could do it again, I took some notes on how to submit them to each store.  I tried to do as much with the PhoneGap CLI as possible so it was easily reproducible from a git repo.  Note that I used ['cordova-icon'](https://github.com/AlexDisler/cordova-icon) and ['cordova-splash'](https://github.com/AlexDisler/cordova-splash) for the PhoneGap-side assets, so I didn't need to touch the platform folders beyond what is mentioned below.

<!--more-->

iOS
------

1. Go to [Apple developer site](https://developer.apple.com) > 'Certificates, Identifiers, Profiles'
	1. click 'Provisioning Profiles > All' in sidebar
	2. click '+' top right
	3. follow wizard: 'Distribution: App Store'…
2. Go to [iTunes connect site](https://itunesconnect.apple.com) > My Apps
	1. click on app
	2. click '+ Version or Platform', select iOS
	3. enter number and then all information about version
3. Open preferences in xcode
	- accounts
		1. add apple id
		2. team -> view details
			- click 'create' button near 'iOS Distribution'
			- provisioning profile will appear here after creating at developer.apple.com and opening.  You can right click and select to see the profile file, whose name will have the `provisioningProfile` for 'build.json' in the next step
4. build signed app with PhoneGap / Cordova ([details](https://cordova.apache.org/docs/en/latest/guide/platforms/ios/index.html))
	1. create 'build.json' in project root
		``` json
		{
			"ios": {
				"release": {
					"codeSignIdentity": "iOS Distribution"
					,"provisioningProfile": "abcdefg-1234-jkld-qwer-aoiuwer2938sf"
				}
			}
		}
		```
	2. run build: `phonegap build ios --release -- --buildConfig=build.json`
5. open project in xcode (eg `platforms/ios/ProjectName.xcodeproj`)
	1. click on the project in the left sidebar
		- in general:
			- Set team in drop-down
			- set 'Deployment Target' to lowest number (unless you have special needs)
	2. in the top toolbar, click on the app name.  a drop-down will open.  [Select 'Generic iOS Device'](http://stackoverflow.com/a/5267479) ([picture](http://stackoverflow.com/a/26315459/1139122)).  This one really tripped me up.
	3. click menu bar `Product > Archive`
	4. try 'Upload to App Store…' from the window that pops up (this is called the 'Organizer' window).  for me this failed.  If not, skip 5.5 and 6
	5. run 'Export…' from the 'Organizer' window
6. open 'Application Loader' (can be run from menu `XCode > Open Developer Tool` menu)
	1. open exported `.ipa` file
7. configure app, version, etc through itunes connect for testing / review

Android
--------
1. Build app with PhoneGap `phonegap build android`
2. Open generated app in Android Studio ([details](https://developer.android.com/studio/publish/app-signing.html))
	1. Run `Build > Build APK`
	2. Run `Build > Generate Signed APK…`
	3. Create keystore with their form
3. Set up build.json
	``` json
	{
		"android": {
			"release": {
				"alias": "keystore"
				,"keystore": "./keys/android.jsk"
				,"password": "12345"
				,"storePassword": "54321"
			}
		}
	}
	```
4. build with CLI: `phonegap build android --release -- --buildConfig=build.json`
	Will be built to `platforms/android/build/outputs/apk/android-release.apk`.  You may need to run the build multiple times or delete a previous build, as I had some troubles with this.
5. Log into [Play Store publish area](https://play.google.com/apps/publish), upload APK
	1. click app, click APK in left sidebar, click 'Upload new APK to Production' button
	2. Drag APK into dialog, enter change description, hit 'Save Draft'
	3. Press 'Publish Now' button at top of pane
