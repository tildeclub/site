---
title: tin (Usenet client)
category: software
author:
  - ant
todo:
  - describe the common entry prefixes on:
    - groups
    - threads
	- articles
  - arrange the principal keys in the way most convenient to the learner:
	- with grouping by relative function
	- with ordering by decreasing importance.
	- abridge that list, leaving out the less important ones?
---

[*tin*](http://www.tin.org/)
is a text-mode threading NNTP and spool-based
[Usenet](usenet-news.html) client
for a variety of platforms.

## Local connection

`tin` is installed on `tilde.club`
and preconfigured to access
the local spool
of the `news.tilde.club` server by default.
You need only run `tin` without arguments:
```
$ tin
```
There is also a local NNTP server
on the `tilde.club` premises,
to which you can connect via:
```
$ tin -r [-g localhost[:119]]
```
You can forward this port over SSH
to your own machine
and point your local *tin*
(as well as any newsreader)
to it.

## Remote connection

### Server configuration

To connect `tin` to a remote news server over NNTP,
a little bit of setup is required.
By default, most of your *tin* configuration
is located in the `.tin` directory in your home.
In order to register a remote server,
add a line to the `newsrctable` file
in that directory,
with the following whitespace-separated fields:

1.	server address with an optional port after a colon,
	which is needed only for non-standard ports,

2.	path to the `newsrc` file for that server,
	for internal use by *tin*
	to store an index of downloaded articles.
	for each newsgroup.

3.	optionally---but highly recommended---a
	short alias for the server,
	to facilitate invocation of *tin*.

For example, here are a few lines from my `newsrctable`:
```
news.tilde.club             ~/.tin/newsrc.club     tc
news.eternal-september.org  ~/.tin/newsrc.e-s      es
fidonews.mine.nu            ~/.tin/newsrc.mine.nu  fi
news.gmane.io               ~/.tin/newsrc.gmane    gm
*                           ~/.tin/newsrc.local
```
Now you can connect to any of the registered servers
via `rtin -g`.
For example,
to read the `tilde.club` server configured above,
enter:
```
$ rtin -g tc
```
But you will not be able to post yet,
if the server requires authorisation,
as most servers do:

### Authorisation

*tin* reads your credentials
for each server from the file `.newsauth`,
by default located in your home directory.
It also has a table structure similar to `.newsrc`,
with one line per server,
but this time the fields are:

1. server address,
2. password,
3. username.

For example, my line for tilde.club server
(with a dummy password, however) is:
```
news.tilde.club  ant  H1dd3nPa$$w0rd
```
Some servers
(*Eternal September* is
[one of them](https://www.eternal-september.org/index.php?language=en&showpage=faq#Login-No-Auth))
require that the client authorise
immediately upon connect,
or they will not show you all newsgroups,
if any.
To cause *tin* to authorise immediately,
pass the `-A` option, e.g:
```
rtin -Ag es
```
If you are among the unlucky fellows
who are guilty of using a password
with space or
(I tremble to say)
tab characters,
you will need to enclose it
in double quotes (`"`).
Make sure your `.newsauth`
is not readable by other users:
```
$ chmod 600 ~/.newsauth
```

### Specifying the NNTPS protocol

By default, `rtin` connects over the unencrypted NNTP protocol.
These days, however, most servers support the more secure NNTPS.
To cause *tin* to use it,
it should be invoked with the `-T` option.
So, the final invocation for *Eternal September*,
with the necessary initial authorisation
and the recommended encrypted connection,
is:
```
$ rtin -ATg es
```

### Simplifying the invocation

If remembering to supply
`-T` and `-A`
for servers that require them
annoys you,
consider storing
the complete invocation
in an alias in your shell's initialisation script
(`~/.shrc` for `sh`,
`~/.bashrc` for *Bash*), e.g.:
```
alias news_es='rtin -ATg es'
```
or use an the wrapper script below,
which will determine
whether `-T` and `-A` are needed
and supply them to *tin* for you:
<details>
```
#!	/bin/sh
#	tinr--launch the tin(1) newsreader
#	with a specified newsserver alias,
#	automatically providing the options
#	-A (authorisation) and -T (NNTP over TLS)
#	if they are required,
#	to save the user remembering
#	the respective properties of each server.
#	Invoke as:
#	#  $ tinr <alias> [params]
#	supplying a server alias
#	and optionally whatever parameters
#	you want to pass to tin.
#	-A is provided if the server is present in .newsauth,
#	and -T--if newsrctable in its fourth field
#	specifies any second alias for the server.
#	#
#	#Written by: Anton Shepelev <ant@tilde.club>
#	#and released into the void under The Unlicense:
#	#<https://unlicense.org/>
#SPDX-License-Identifier: Unlicense
#URL: <svn://insomnia247.nl:5120/ant-dots/bin/tinr>

help()\
{	sed -ne '
		1d
#	prefix-juggling to keep the script compatible
#	after conversion of tabs to spaces,
#	as Markdown processors will often do:
		s/^#\([	 ]\+\)/PREF/
		t cont; q
	:cont
		s/^PREF#//
		p
	' $0 \
	| fmt -74 -p "PREF"\
	| sed -e 's/^PREF//'
	exit 1
}

help_ref="See tinr -h for instructions."
while getopts h opt; do
	case $opt in
	h) help; exit 0;;
	?) [ ${OPTARG-x}=x ] && echo $help_ref && exit 1;
	esac
done
shift $(($OPTIND - 1))

if [ $# -lt 1 ]; then
	echo 1>&2 \
A server alias is not specified. $help_ref
	exit 1
fi
alias=$1

nrct=${TIN_HOMEDIR:-"$HOME"}/.tin/newsrctable
naut=${TIN_HOMEDIR:-"$HOME"}/.newsauth

get_serv() \
{
	[ ! -r $nrct ] && return 1

	script=$(
	awk -e '
		/^[^#]/{ if( $3=="'${alias}'" )
		{	print $1
			if( $4 )
				print("T")
			exit
		}}' \
		< $nrct
	)
#	awk failed, exiting:
	if [ $? -gt 0 ]; then exit   1; fi
#	no server entry was found:
	if [ ! -n "$script" ]; then return 1; fi
#	a server entry was found:
	while read s o; do
		server=$s
		  opts=$o
	done <<EOF
$(echo $script)
EOF
	return 0
}

if [ -r $naut ] && get_serv; then
#	the server is found by the alias,
#	let's see whether it has an auth entry:
	if awk -e '$1=="'$server'"{exit 1}' $naut; then :
	else opts=${opts}A
	fi
fi

#	Swallow the alias:
shift
#	The final invocation:
rtin -${opts}g $alias "$@"
```
</details>
The script above will add `-A`
if the server is present in your `.newsauth`
and `-T` if a secondary alias is assigned to it
in the fourth column of `newsrctable`.
Invoke it with the primary alias of the desired server,
optionally followed by
whatever arguments you may want to pass to *tin*, e.g.:
```
$ tinr es    # connect to Eternal September
$ tinr tc -o # submit all postponed articles
```

## Interface overview

*tin* works at four nested levels
with (more or less :-)
uniform navigation
within and between them:

--
Level      Operates on     Symbol
------     ------------    -------
selection  newsgroups      S

group      threads         G

thread     articles        T

article    single article  A
-

*tin* starts at the topmost level (selection).

Whereas
the selection, group, and article levels
are linked with fixed up/down transitions,
the thread level is the odd one out,
for it comes between the group and article levels
only upon explicit invocation
from either of them
by the `l` key.
Furthermore,
if the article level was entered from the thread level
the *level-up* command (`q`)
goes back to the thread level
instead of the group level.

The levels share many common keys
for navigation and operations,
often borrowed from
[The Vi editor](vi.html) interface.
The most important keys are:

----   ------ --------------------
Key    Level   Action
----   ------  --------------------
H      SGTA    toggle on-screen help,
               useful for learning

h      SGTA    list available commands

j/k    SGT     next/prev. group/thread/article

j/k    A       next/prev. line in text

[0-9]+ SGR     highlight by number

Return SGT     level-down (into highlighted element)

q	   SGTA    level-up, or *q*uit

l      GA      open thread view, mem. as *l*ist of articles

/      SGTA    search forward

?      SGTA    search backwards

y      S       toggle display of all/subscribed groups

s/u    S       subscribe/unsubscribe to/from selected group

r      SG      switch between read/all

TAB    SGTA    to next unread article from anywhere

p/n    GA      prev/next

P/N    A       prev/next unread

w      G       make a new post

f      A       follow-up (reply)

c/C    SGTA    mark group (SG) or thread (TA) as read
			   and move to the next unread (C) one

K      GTA     mark current thread (G) or article (TA)
               as read and move to the next unread one

z      SGA     mark group/base article/article unread

Z      TA      mark thread unread

Y      S       load new posts from the server (if any)

M      SGTA    open the menu
-

For a complete UI reference and settings,
see the
[tin(1)](http://www.tin.org/bin/man.cgi?section=1&topic=tin)
manpage.

