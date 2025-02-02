---
categories: [computer, www]
date: 2022-12-16T15:30:54-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=3915'
id: 3915
modified: 2022-12-16T15:30:54-05:00
name: vagrant-network-ip-change
tags: [development, problem, vagrant, virtualbox, vm, web]
---

Vagrant network IP change
=========================

Apparently, an [update to VirtualBox after version 6.1.26](https://discuss.hashicorp.com/t/vagran-can-not-assign-ip-address-to-virtualbox-machine/30930) limited the IP's usable for network adapters on Mac / Linux hosts.  They must now be in the `192.68.56.0/21` range, which is pretty limited and much less easy to remember or type than the `10.*.*.*` that I had been using.  I had to change my projects to all be in this range and spread out the IPs to avoid collisions between the various projects when I updated VirtualBox a while back.

<!--more-->

For some time after this, I was having a problem where the IPs would only (usually) successfully allocate the first `vagrant up` after a reboot.  So I could work on one project, then would have to reboot if I wanted to work on another and needed more than just `vagrant ssh`.  I updated to version 7 today and am glad to see that that problem is fixed:  I can once again start and stop multiple projects at will without IP problems.  I guess they have switched from using kext (kernel extensions) to using hypervisor and other APIs on Mac hosts, which is probably a good thing in general and hopefully have less security concerns.

I run my project virtual machines with Vagrant using VirtualBox and a network config like:

``` ruby
#==network
web.vm.network 'private_network', ip: '192.168.56.6'
#--connect to internet
#-@ https://stackoverflow.com/a/18457420/1139122
web.vm.provider 'virtualbox' do |vb|
	vb.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
	vb.customize ['modifyvm', :id, '--natdnsproxy1', 'on']
end
```
