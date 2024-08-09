---
categories: [www]
date: 2019-11-22T22:54:40-05:00
date_gmt: 2019-11-23T03:54:40+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=2569'
id: 2569
modified: 2020-07-18T21:25:47-04:00
modified_gmt: 2020-07-19T01:25:47+00:00
name: ansible-share-handlers-between-playbooks
tags: [ansible, provision]
---

Ansible: Share handlers between playbooks
=========================================

[A StackOverflow question](https://stackoverflow.com/q/38188717/1139122) showed me that Ansible handlers can be stored in their own YAML file and included into any playbook to avoid repetition.<!--more-->  You can create a `handler.yml` file that is just a list of handlers, like:

``` yaml
- name: restart apache
  command: 'apachectl graceful'
  listen: 'apache conf change'
- name: restart ssh
  service:
    name: ssh
    state: restarted
```

Then, in any given playbook, you can include and use them like:

``` yaml
- name: my playbook
  become: true
  handlers:
    - include: handlers.yml
  hosts: all
  tasks:
    - name: configure server name
      lineinfile:
        dest: /etc/apache2/apache2.conf
        line: 'ServerName tobymackenzie.com'
        regexp: '^ServerName.*$'
        state: present
      notify: 'apache conf change'
```

This simplifies things nicely if you reuse handlers in multiple playbooks.  Roles sound like they make this even easier, but I haven't switched to them yet.
