---
title: Editing Basic UNIX Security the Tilde way
author: michaelcoyote
category: tutorials
---


> "Unix is public by default. This means that other people who use the server can see your files. You can change that on a file-by-file basis. You can also change the default behavior for you. It is totally okay to keep your stuff private. Let us show you how." 

Unix was built with a fairly open security policy. It's the kind of system you might expect a bunch of Berkley hippies to design. That said, if it bugs you that someone might be able to look the files in your home directory and you don't want to read any more of this document then run these commands:

    cd ~
    chmod 711 .

Those will keep anyone on the system from looking at your directory while still allowing your `~youruser` site to work.  If you want to have more control over who can view what in your directory, then please read on. You can even come back and read this later, we'll be here.

### Users and Groups

What is a user? For starters, you are a user and so is every other person on the system. Sometimes special user accounts are used for running specific processes (such as the web server) or for handling special administrative tasks.

There are several attributes that define a user.

- username
    This is your login id and the name of your homedir
- user id (or uid)
    This is your unique numerical id number on the system. This is how the system keeps track of you, your processes, and your files.
- group id (or gid)
    This is a unique numerical id number for your primary user group on the system. User groups are the traditional way that users would colaberate on large projects. 

For now we only need to know about the username.

#### Welcome to tilde.club, your new home (and homedir)
When you registered for the system, you got an email that contained many things. One of those things was a username, and another was a password. When you logged into the server you were presented with what we call a prompt, and it looked a bit like this:
   
    sh-4.1$

That's boring so type the command `ls -l public_html/index.html` 

    sh-4.1$ ls -l public_html/index.html
    rw-rw-r-- 1 youruser youruser 177 Oct 13 04:51 public_html/index.html

You'll notice that your login shows up, but what does this actually show us?

First of all `ls` is a command to list files and directories. We've given it the command line switch `-l` that tells the `ls` command that we want a long listing of the file or directory attributes, and finally we've given it the filename `my_file` so that we can see its file attributes.

What does this long file listing of `my_file` show us?

    -rw-rw-r--  1  youruser  youruser   177   Oct 13 04:51    my_file
    ---------- --- -------   --------  -----  ------------ -------------
        |       |     |        |         |         |             |
        |       |     |        |         |         |         File Name
        |       |     |        |         |         +---  Modification Time
        |       |     |        |         +-------------   Size (in bytes)
        |       |     |        +-----------------------     Group owner
        |       |     +--------------------------------      User owner
        |       +--------------------------------------    Number of links
        +----------------------------------------------   File Permissions
    
This seems like a lot to take in, but for the purpose of talking about files and security, we'll only need three things: the file permissions, the group owner and the user owner.

- Homework
    - Run `ls -la` in your home directory and note the users and permissions of the various files
    - Run `ls -l /etc/passwd` and `ls -l /var/log/messages` and compare the permissions and ownership to that of your homedir   
 

### Basics about file and directory permissions

    -rwxrwxrwx
    ----------
    | |  |  |
    | |  |  +--- Other Read/Write/Execute permissions
    | |  +------ Group Read/Write/Execute permissions  
    | +--------- User Read/Write/Execute permissions
    +----------- Directory/Special flag

The first column at first glance looks like a bunch of alphabet soup, however if you look over a few of them, a pattern begins to emerge. Some lines begin with `d` and there are repeating instances of `r`, `w` and `x`. You might notice that the lines beginning with `d` refer to directories and that many files have `rw-` at the start of the column and `r--` or even `---` at the end of the column. These are important and indicate to the computer and to users how that file can be accessed. 

#### Types of permissions

There are three major types of permissions (and a hand full of others)
- Read 
    Read permission is represented as an `r` and will allow a listing of a directory and reading a file.
- Write
    Write permission is represented with a `w` and allows a file or directory to be written to or deleted.
- Execute
    Execute permission is represented as an `x` and allows a file (such as a script) to be executed  and it allows for a directory to be "traversed" 
    
- Other special permissions and notations in `ls -l`
    - `-` means that the permission for that place isn't set. If it's at the beginning of the line, it means it's a normal file.
    - `d` at the start of a line isn't a permission really. It just denotes a directory.
    - `b` or `c` isn't a permission either, it probably means you did an `ls -l` of the `/dev` directory as those indicate block or character devices.
    - `s` is a setuid/setgid permission. It's a special setting that allows you to run a script file or program as a user or a group. It can be used on a directory to make sure files are written as a user/group. It's rare to see, and in general should be used only if the proper precautions are taken. Serious consequences can come about if a shell script/program is poorly written and given setuid permissions, as it could lead to an escalation to root privileges or a more privileged user.

#### Three classes of access permissions

- User permissions
    This set of access controls define what an owner can do to her own files or directories. These controls are most often useful to set on a script file you want to run or a file you want to protect from deletion or overwriting.
 
- Group permissions
    This set of access controls define what the group can do to a file or directory. This tends not to matter much in your homedir, but it can matter a lot when working with other users on shared projects.
    
- Others
    These access controls are what you use to allow and others who are not listed as an owner or group member to do to a file or directory. For example, if you remove read permissions from others on your  ~/public_html/index.html`, the webserver process will be unable to read your web page. 
    
#### Changing file and directory permissions using `chmod`

Examples

- Homework
    - `mkdir -p test/01` and then try the following `chmod` commands
            chmod u+rwx test
            echo "hello world" > test/a_file
            ls -l test
            chmod ugo-rw test
            ls -l test
            ls -l test/a_file
            
            

#### Basics about the `finger` and `chfn` commands

How to see others in the system using `finger`
    
    Type the command `finger`
    
    Type the command `finger $USER`

How others see you.

Changing the information people see about you using `chfn`

creating a `~/.plan` and `~/.project` file that's readable


#### More advanced topics

Let's look at the `/etc/passwd` file. What is it?  It's a file that contains most of the information about users in the system. 

- Homework
    - `head -10 /etc/passwd`
    - `grep $USER /etc/passwd`
    - Note the columns in the `/etc/passwd` file. Note the columns and the `:` separator between them.

Back at our command line, lets type the command `id`:
    
    sh-4.1$ id
    uid=501(youruser) gid=501(youruser) groups=501(youruser)`

The `id` command is a tool to show us how the system keeps track of us. From this we can see that according to the system, our user ID (or uid) is 501, and our group id is also 501.

- Homework
    - Run `id` in your own directory, then run
    - Run `id -u root`
    - use the `grep` command to find your uid in the `/etc/passwd` file
        
As noted above, we can obtain our group id using the `id` command. Try locating your group in `/etc/group` using the commands that were specified above; your group name will probably be the same as your user (although at times this might not be true depending on the configuration of the system).
