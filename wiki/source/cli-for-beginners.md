---
title: command line for absolute beginners
author: cmccabe
category: tutorials
---

So, you want to join a public-access shell community like tilde.club,
but you don't yet have experience using GNU+Linux or other UNIX-like
operating systems? This tutorial is designed to give you enough guidance
that you can get started and move on to successfully directing your
future learning. Once you get a basic level of self-sufficiency,
tilde.club is a great place to practice and learn more.

GNU+Linux is a text-based operating system. And it takes work and thought to start using.
-----------------------------------------------------------------------------------------

You'll find a lot of people online arguing that GNU+Linux is *not* a
text-based operating system, and that it in fact has a GUI interface
just like Windows. It is true that you can use GNU+Linux through a
graphical user interface (GUI) like Gnome, or that you can use services
from GNU+Linux servers like tilde.club through a web interface. But the
people who are so keen on GUIs are saying this to make GNU+Linux sound
like an easy transition for Windows or Mac users. However: (1) to really
leverage the power of GNU+Linux, you need to learn to interact with it
as a text-based system, and (2) while it is different, it's not really
that hard. It will take effort to learn the differences, but that effort
will pay huge dividends.

How do I connect to a shell server?
-----------------------------------

The most common way to connect remote GNU+Linux system is with an SSH
client. SSH stands for secure-shell. SSH allows you to make a private
connection between your computer and a shell server like
[tilde.club](https://tilde.club), and it ensures that nobody else along
the wire can listen in on your connection. Check out [our SSH
page](/wiki/ssh.html) for information on connecting to tilde.club over
SSH.

If you are having trouble with making your first SSH connection to
tilde.club, or anything else while you're learning from this tutorial,
drop by the [tilde.club web chat](https://web.tilde.chat/) or email an
admin for help (<root@tilde.club>).

What is a shell?
----------------

An operating system (OS) is the nuts and bolts that makes all the parts
of your computer work together for you. At its core, the OS is not
friendly for day to day computer usage. A shell is a user friendly
"wrapper" around the operating system that allows you to use it easily.
A shell can be graphical, like the Windows or Android GUIs. Or a shell
can be text-based. A text based shell, also called a command line
interface (or CLI), is a tool you can use to control the operating
system by sending it text commands.

What kind of things can you make the OS do? Things like opening files,
listing the files in a directory, displaying the current system load, or
telling you what other users are currently doing.

What is a command?
------------------

Commands are simple words, often abbreviated, that make the system do
things when typed into the shell. Some simple examples are 'ls' which
lists the files in a directory, or 'cd' which changes your location to a
new directory (cd = change directory), or 'exit' which logs you out of
your current shell session. There are thousands of useful commands, but
you only need to know a few to get started and be self-sustaining.

This tutorial will teach you the few commands that should allow you to
take care of yourself and start down the real, longer-term path of
self-directed learning. Once you're logged into tilde.club (or any
GNU+Linux shell server), you can practice the following commands as you
learn them.

What are the first commands a new user should learn?
----------------------------------------------------

When you're first starting to use a shell in a UNIX-like environment,
you will want to be able to do the following things:

1.  logging in and logging out
2.  list the files or directories in a directory
3.  move between directories
4.  read, write, and save files
5.  create new files or directories
6.  move or copy files between directories
7.  delete files or directories
8.  download files from elsewhere on the internet
9.  learn more about new commands

When you're logged into a shell, you should see a command prompt and a
blinking cursor. At this point, simply type a command and hit Enter to
run it. You can try this as you work through learning the commands
below.

### Logging In, with `ssh`

Recall from the How-Do-I-Connect section above that you can use a SSH
client to log into tilde.club. Once you're logged in, you can use the
command line SSH client to log into any other shell server; in the
example below, let's say you want to log into tilde.town from
tilde.club.

Skipping some specifics for now, you can log into tilde.town from a
tilde.club shell by using SSH as follows:

> `ssh username@tilde.club`

Some shell servers allow you to log in with nothing more than a username
and password. But increasingly, many servers (like both tilde.club and
tilde.town) require you to use ssh keys. To learn more about ssh keys,
again, see our [SSH page](/wiki/ssh.html).

### Logging Out, with `logout` or `exit`

`logout` is a simple command you can use to log out of a shell. You
could also use `exit`.

### Listing Files, with `ls`

To list the files in a directory, simply type `ls`. This will print a
list of the files in your current directory.

> `ls`

### Changing Directories, with `cd`

You may move from one directory to another with `cd`. Wherever you are
in the file system, you can type `cd` by itself to return to your home
directory:

> `cd`

Change to the directory with your html files as follows:

> `cd public_html`

### Read the Contents of a File, with `less`

If you're still in your public\_html directory, you should see a file
called 'index.php' when you use the `ls` command. Let's peek inside
'index.php' as follows:

> `less index.php`

`less` has opened the 'index.php' file for you to read. You cannot edit
it; only read it. Type `q` (quit) to stop viewing the file contents and
return to the shell.

### Edit and Save Changes to a File, with `nano`

`nano` is one of many text editors availble for GNU+Linux. There are
many more powerful editors, but we'll start with this one because it is
simple. Let's open your 'index.php' file and make some changes.

> `nano index.php`

Now you're viewing the contents of 'index.php' again, but this time you
can change the contents. If you don't know HTML, be careful here. Use
your arrow keys to move the cursor down to the line that says the
following:
`<p>Just log in with your secure internet shell to change this file!</p>`

Leave the `<p>` and `</p>` tags as they are, but change the sentence in
between them.

Now, save and quit by hitting the key combination Ctrl+x, and then
typing 'y' in response to the question about wanting to save the
modified buffer.

Now you can pull up a browser to see the change at your tilde.club URL:
'https://tilde.club/\~yourUserName'

### Create a New File with `nano`

Let's create a new file in your public\_html directory, called
'testing.html'.

> `nano testing.html`

'testing.html' did not exist before you opened it with `nano`, so it was
created for you.

Now, add some quick contents by opening the file for editing with
`nano`, and adding whatever you want. Then Ctrl+x to save, you will have
created a new file.

Type `ls` to view the contents of your directory an confirm that you did
indeed make the file.

Later in this tutorial, we will come back to this file and make it
viewable in your web space.

### Create a New Directory, with `mkdir`

First, hop back to your home directory with the `cd` command (remember
that `cd` from anywhere in the file system will take you back to your
home directory).

Now create a new directory called 'downloads' in your home directory:

> `mkdir downloads`

Use `ls` to see that it was created, and even move into the new
directory with `cd downloads`.

### Moving Files Between Directories, with `mv` or `cp`

First, `cd` back to your home directory, and use `nano` to create two
new files called 'fileone.txt' and 'filetwo.txt'.

Lets move those into your 'downloads' directory using two different
commands, to demonstrate how they workd differently.

Move 'fileone.txt' into 'downloads':

> `mv fileone.txt downloads/`

Now if you `ls` the contents of your home directory, you will no longer
see 'fileone.txt', because it has been moved into 'downloads'. If you
'ls' the contents of 'downloads' (a shortcut command is `ls downloads`),
you will see it there.

Next, copy 'filetwo.txt' into 'downloads' as follows:

> `cp filetwo.txt downloads`

Now if you `ls` the contents of your home directory, 'filetwo.txt' will
still be there. This is because `cp` made a copy of 'filetwo.txt' and
put the copy in 'downloads'. It did not touch the original file in your
home directory. Verify this with `ls` in your home directory and in
'downloads'.

### Delete Files and Directories, with `rm` and `rmdir`

As long as you're in one of your own directories (e.g. your home, or
'downloads' or 'public\_html'), you can create a new files. Create a new
file called 'testtrash.txt':

> `nano testtrash.txt`

Then save it as you have already learned, and confirm that it exists by
listing (`ls`) the contents of the directory.

Now, you can delete the file with the `rm` (remove) command:

> `rm testtrash.txt`

Notice that you don't get a warning that you're about to delete it, and
you don't even get a confirmation that it is deleted. You've learned
your first command that you need to be careful with. If you delete an
important file with `rm`, it is gone forever.

You can delete directories the same way, only using the `rmdir` command
(remove directory) instead of `rm`. If you use `mkdir testtrash`, you
can then delete it as follows:

> `rmdir testtrash`

Note that you can only delete empty directories with `rmdir`.

If you want to delete directories that still have contents in them, use
the following:

> `rm -rf directoryName`

Be very, very careful with this command. Many a user, new and seasoned,
has been stung by hastily deleting directories like this. This is also
the source of the classic sysadmin joke/horror story about `rm -rf /`
which deletes the entire file system.

### Downloading Files, with `wget`

Now `cd` into your 'downloads' directory because we're going to use it
for actual downloads.

Use the `wget` (WWW get) command to download a text copy of this
tutorial from tilde.club user cmccabe's public\_html directory:

> `wget https://tilde.team/~cmccabe/gnu-linux-toot.txt`

You will see output of the command that confirms it is downloading. You
can also verify that it has downloaded with your `ls` command. You can
also peek at the contents with the `nano` or `less` commands that you
learned above.

If you know the URL of other files you'd like to download, you can grab
those too, just swapping the URL above for any URL:

> `wget [URL here]`

A brief note on security here, if you do pull any scripts from the
Internet using `wget`, it's important that you do not execute those
scripts until you've read over what it does. Otherwise, you run the risk
of compromising your account or allowing other malicious actions to take
place.

### Learn More About Commands, with `man` (and `help`)

At this point, you've learned most of the commands you need for basic
self-sufficiency in a GNU+Linux shell environment. With just a few more,
you can go a long way. When you want to learn more about a command, you
can look at its "man page" with the `man` command. "Man pages" are the
instruction manuals for most commands and programs in GNU+Linux.

Try out `man` by looking at any of the commands you've learned already
(except `cd`\*). For example, `man ls` would open the man page for the
`ls` command. When looking at a man page, type `q` at any time to quit
and return to the shell.

The `man` command will be one of your most valuable tools for as long as
you're using the GNU+Linux shell. You will always be learning new
commands and new ways to use old commands, and `man` will help you do
it.

\* Note: technically speaking `cd` is a shell built-in, not a command.
Make a mental note of that and you can learn more about the distinction
later. For now, note that you can use `help cd` to learn more about the
`cd` command.

Commands have options and arguments.
------------------------------------

When you look at the man page for a command like `ls`, you'll see in the
DESCRIPTION section a number of **options** that you can use to modify
how the command works. They look like `-a` or `-h` or `-l`. Try adding
the `-a` option to `ls` and note the difference:

> `ls -a`

The `-a` option now lists "all" contents of your directory, including
"hidden" files (aka dot files). You could combine the three options
listed above in the form of `ls -alh` to list "all" files, in "long"
form, and display file sizes in "human" readable format. Most commands
have

Commands also have **arguments**, or information passed into a command
for some kind of processing. You have already used these arguments when
you told nano to open a file: `nano testtrash.txt`. In this case,
"testtrash.txt" was the argument to the nano command. You also used
"testtrash.txt" as an argument to the `rm` command when you did
`rm testtrash.txt`.

Commands will often combine options and arguments, sometimes in specific
sequences. You can learn about these when read a command's man page.

The Filesystem Hierarchy
------------------------

You already know that you get dropped into your "home" directory when
you first log in. Your home directory is just one of many, many other
directories on the system. All of these directories are organized under
one master directory called the "root directory". The root directory is
often referred to with a single forward slash, like this: /

You can list all the directories at the root level by using the `ls`
command again, as follows:

> `ls /`

Want to check out some of the directories you see in root? You could
either `cd` into them and `ls` the contents, or just `ls` the comments
directly as follows:

> `ls /etc`

This would display the contents of the "etc" directory, which itself
lives in the "root" directory. Notice that the command uses "/" + "etc"
to create a path to the destination. In "etc" is another directory
called "cron.d", and you can use the same principle to view its
contents:

> `ls /etc/cron.d`

You now know enough to look around the file system. Note that most
GNU+Linux systems (like tilde.club) adhere somewhat to an organization
scheme called the Filesystem Hierarchy Standard ([Wikipedia
link](https://en.wikipedia.org/wiki/Filesystem_Hierarchy_Standard)).
This is another subject for you to read up on later.

How can I keep my things private, or share them with others?
------------------------------------------------------------

As you explore the filesystem, you might bump into some directories that
won't let you in. For example, if you try to `cd` into the home
directory for the root user (not the same as the root directory), you'll
see this error: "/root: Permission denied". This is because GNU+Linux
systems maintain a "mode" for each file that limits which users can
read, write or execute it.

If you don't own a file, then you can't change its mode. This is a basic
security principle in GNU+Linux systems.

For the files you own (i.e. the files within your home directory), you
can change the file modes yourself. You do this using the "change mode"
command, `chmod`.

Each file has three permission levels: for the file owner, for members
of the file's group\*, and for all other system users. For each level,
you can permit any combination of "read", "write", and "execute"
permissions.

(/\* Do a web search for GNU+Linux users and groups to learn more about
this important concept.)

You can change a file's mode with `chmod` one of two ways. The first is
a symbolic way in which you add or subtract 'r', 'w', and/or 'x' (read,
write, execute) to 'u', 'g', or 'o' (user, group, or other). For
example:

> `chmod g+x filename.txt`

This gives 'execute' privileges to members of filename.txt's group.

You can also use `chmod` numerically, through which you may set the
user, group and other permissions all at once. For example:

> `chmod 755 filename.txt`

This gives the owner read, write and execute privileges, and gives only
read and execute privileges to group and other.

Use `man chmod` to get a fuller understanding of `chmod`.

To get an interactive, visual feel for numeric file modes, try the
cmccabe's [file mode widget](https://tilde.team/~cmccabe/mode-gui.php)

--

Finally, remember that 'testing.html' file we made above? Let's use that
as an example of how you can control who can view your files. Use the
following to make the 'testing.html' file visible in your website:

> `cd` to return to your home directory

> `chmod 644 public_html testing.html`

Now if you bring up the following URL (with your username) in a browser,
you should see the testing.html file you made.

https://tilde.club/\~username/testing.html

The End (of The Beginning)
--------------------------

There you have it -- you know about logging in, using basic shell
commands, and the file system, and you're now self-sustaining (and a
little more).

tilde.club is about community, but it is about community of individuals
who work hard to learn. what you have just leaned will give you a
platform on which you can learn by doing and trying things out.

Remember that - There is NO GUILT here. NOR SHAME. Not knowing things is
fine. Feel free to ask your questions any time on irc or the mailing
list.

Below are some other common programs you'll likely want to use. Most of
these have man pages, so you can read more about them. Others you'll
just have to try out to see how they work.

List of Common Programs
-----------------------

`mutt`, `alpine` - for email

`wget`, `curl` - for grabbing files from elsewhere

`weechat`, `irssi` - for irc

`scp` - for securely moving files between networked systems. this copies
files (i.e. 'cp') over ssh, hence 'scp'

`lynx` - web browsing

`crontab` - scheduling recurring jobs (job = sequence of commands, often
stored in a script)

`dict` - dictionary for definitions and synonyms

`aspell` - a program for spell checking

`motd` - list the message of the day, which on tilde.club displays all
the other commands below

some tilde.club specific programs
---------------------------------

`bbj` - a bulletin board for asynchronous discussions

`botany` - tend to your plants and help others care for theirs

`asciifarm` - a lovely multiplayer, text-based, farming RPG

`tilde` - a manager for user-submitted scripts

`chat` - open `weechat` preconnected to our irc

Some shell use cases
--------------------

And in this corner, we shall describe some common activities people
perform in a shell... \[Feel free to add here.\]

Other Intro-to-Linux Material
-----------------------------

Not suprisingly, you'll find a lot of other intro material online or in
your local library. Here are a few that have been mentioned by
tilde.club members:

Terminus - an interactive game-like introduction to shell commands
http://www.mprat.org/Terminus/
