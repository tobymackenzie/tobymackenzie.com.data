---
categories: [www]
date: 2023-01-20T02:14:20-05:00
date_gmt: 2023-01-20T07:14:20+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3934'
id: 3934
modified: 2023-02-14T01:17:59-05:00
modified_gmt: 2023-02-14T06:17:59+00:00
name: ansible-vagrant-symfony-var-permissions
tags: [acl, ansible, development, symfony, vagrant, virtualbox, web]
---

Ansible, Vagrant, and Symfony `var` permissions
===============================================

I have moved to using VirtualBox VM's for my local web development.  I use Vagrant and Ansible to set them up.  For my site, I use synced folders to share the site files from the local machine to the dev VM.  This limits what permissions can be set on the files though, and doesn't work well for Symfony's `var` folder stuff, eg cache and logs.  The normal Symfony permissions for those folders use ACL's, but those cannot be set on Vagrant synced files.  My solution was to create a `/var/www/var` folder to store such folders for any sites on the VM, and symlink them into place in the shared folder location.  I did this with Ansible so that it would be reproducible.  Since I ran into some issues getting it working, I thought I'd blog about it.

<!--more-->

I store my site's Vagrant / Ansible configuration in my [tobymackenzie.srv repo](https://github.com/tobymackenzie/tobymackenzie.srv).  In my `Vagrantfile`, I have a local folder synced into the VM with a line like:

``` ruby
web.vm.synced_folder './sites/tobymackenzie.com', '/var/www/sites/tobymackenzie.com', owner: 'ubuntu', group: 'ubuntu'
```

That makes the local path specified by the first argument synced to the VM at the path specified by the second argument, with permissions specified by the other arguments.  Those permissions are forced and the OS doesn't allow changing them within the VM.  So my technique creates a folder outside of that synced folder, which allows for setting any permissions I want.

The [standard Symfony permissions](https://symfony.com/doc/current/setup/file_permissions.html) for the `var/cache` and `var/logs` uses ACL's (advanced permissions) to allow both the developer and web users to read and write files in those directories and have them inherit the same permissions.  This would use a command like:

``` sh
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
```

Since I wanted to do that in Ansible to make it reproducible, it was a bit more verbose.  I used the [Ansible ACL module](https://docs.ansible.com/ansible/latest/collections/ansible/posix/acl_module.html).  <insert>It took me a while to arrive at my config, but I ended up using three tasks: one setting an ACL mask and then one setting a default for each user.</insert>

Since my server repo manages more than just my main site, I wanted to set up some configuration to specify all folders that will use this `var` folder and where to symlink them to.  I wanted a less verbose config, but couldn't get what I wanted to work after trying all different ways with `dict2items` and other techniques I found online but couldn't get them to work.  I settled on a single variable containing a list of each folder, with a `site`, `src`, and `dest`.  I have the `site` so that I can group together folders for a given site and symlink to a path based on that site's root.

I ended up with something like:

``` yaml
- name: set up dev var folder
  become: true
  hosts: dev
  vars:
    adminUser: me
    webUser: www-data
    devVarDirs:
      -
        site: tobymackenzie.com
        dest: var/cache
        src: cache
      -
        site: tobymackenzie.com
        dest: var/logs
        src: logs
  tasks:
    - name: create var folder
      file:
        mode: 'u=rwx,g=rx,o=rx'
        path: /var/www/var
        recurse: false
        state: directory
    - name: var folder default mask
      ansible.posix.acl:
        default: true
        etype: mask
        path: /var/www/var
        permissions: rwx
        state: present
    - name: var folder admin default permissions
      ansible.posix.acl:
        default: true
        entity: '{{adminUser}}'
        etype: user
        follow: false
        path: /var/www/var
        permissions: rwX
        recalculate_mask: no_mask
        state: present
    - name: var folder web default permissions
      ansible.posix.acl:
        default: true
        entity: '{{webUser}}'
        etype: user
        follow: false
        path: /var/www/var
        permissions: rwX
        recalculate_mask: no_mask
        state: present
    - name: var folder dir sources
      file:
        path: "/var/www/var/{{item.site}}/{{item.src}}"
        state: directory
      with_items: "{{devVarDirs}}"
    - name: var folder dir destinations
      file:
        src: "/var/www/var/{{item.site}}/{{item.src}}"
        path: "/var/www/sites/{{item.site}}/{{item.dest}}"
        state: link
      with_items: "{{devVarDirs}}"
```

I separately have a script to set up the equivalent folders on the production server.  In the future, I may just use the same config array with a separate handling to do so.  I'm also considering doing this with the vendor folder, since composer warns of possible slowness installing to synced folders.  However, it hasn't been noticeably slow for me, and this will complicate my having a separate web and build VM.
