---
categories: [www]
date: 2018-02-17T02:28:58-05:00
guid: 'https://www.tobymackenzie.com/blog/?p=1786'
id: 1786
modified: 2018-02-17T02:28:58-05:00
name: ansible-2-4-not-loading-group_vars
tags: [ansible, problem, provision]
---

Ansible 2.4 not loading group_vars?
===================================

I recently updated to [Ansible](https://www.ansible.com/) 2.4 from 2.3, and my `group_vars` no longer seem to be loading automatically.<!--more-->  Spent a couple hours looking into it, but since it's "magic", I'm not really sure what's going on.

My solution for the moment is to load them manually:

``` yml
- name: load vars
  hosts: all
  tasks:
    - name: load vars
      include_vars: group_vars/all.yml
```

Not sure if this will cause problems if they suddenly start working again.  I've been considering moving those vars to a better location for reuse anyway, and this will make that easier.
