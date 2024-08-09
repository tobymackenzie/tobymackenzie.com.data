---
categories: [computer, www]
date: 2018-10-22T03:24:48-04:00
date_gmt: 2018-10-22T07:24:48+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2087'
id: 2087
modified: 2018-10-22T03:26:56-04:00
modified_gmt: 2018-10-22T07:26:56+00:00
name: recreating-missing-vagrant-user
tags: [problem, ssh, user, vagrant, vm]
---

Recreating missing 'vagrant' user
=================================

Recently, the 'vagrant' user somehow disappeared on a vagrant <abbr title="Virtual Machine">VM</abbr> of mine.  It may have happened during a `do-dist-upgrade`.  It took me a while to figure out why `vagrant provision` and `vagrant ssh` were failing.<!--more-->  Luckily, I had another sudo capable user on the VM that I could log in with to find the problem and resolve it.  If I didn't, I would probably have had to destroy the VM and recreate it.

Vagrant stores the private ssh key at a path like `.vagrant/machines/default/virtualbox/private_key`.  It only puts the public key on the vm, so if the user is deleted, it's gone.  I generated a new one like:

``` sh
ssh-keygen -t rsa -C 'me@tobymackenzie.com' -f .vagrant/machines/default/virtualbox/private_key
```

I then logged into the VM with my remaining user to recreate the vagrant user:

``` sh
sudo useradd -m -s /bin/bash vagrant
```

gave them passwordless sudo capabilities:

``` sh
sudo adduser vagrant sudo
sudo sh -c 'echo "vagrant ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers'
```

and installed the new public into `authorized_keys`:

``` sh
sudo mkdir /home/vagrant/.ssh
sudo vi /home/vagrant/.ssh/authorized_keys
# paste in key, `:wq`
sudo chmod -R go-rwx /home/vagrant/.ssh
sudo chown -R vagrant:vagrant /home/vagrant/.ssh
```

With that, I was once again able to `vagrant ssh` and `vagrant provision` to my hearts content.
