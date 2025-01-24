---
author: jeffbonhag
title: SSHFS (SSH Filesystem)
category: software
---

On OS X:

- Download the lastest version of OSXFUSE: [http://osxfuse.github.io/](http://osxfuse.github.io/)
- `brew install sshfs`


Now you can mount a ssh server by issuing the following commands:

    mkdir tilde.club
    sshfs jeffbonhag@tilde.club:/home/jeffbonhag tilde.club

If you're on Linux and want to make an entry in your fstab:

    mkdir -p /mnt/tilde.club

Put an entry in your `/etc/fstab` like this:

jeffbonhag@tilde.club:/home/jeffbonhag /mnt/tilde.club  fuse.sshfs _netdev,user,idmap=user,transform_symlinks,allow_other,default_permissions,uid=jeff,gid=jeff,umask=0 0 0

then you can do

    mount /mnt/tilde.club

If you want to use an identity file to mount instead of a password, this may
work (untested):

    jeffbonhag@tilde.club:/home/jeffbonhag /mnt/tilde.club  fuse.sshfs _netdev,user,idmap=user,transform_symlinks,identityfile=/home/USER_C/.ssh/id_rsa,allow_other,default_permissions,uid=USER_C_ID,gid=GROUP_C_ID,umask=0 0 0

Although -- do you really need to do this?  It just occurred to me that the
first command is just as easy, and probably makes more sense.
