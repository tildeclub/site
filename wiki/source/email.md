---
title: email
author:
  - benharri
  - xwindows
category: tutorial
---

Your shiny, new tilde.club account comes with an email account. `alpine`  is a command-line email application to use it, as is `mutt`. Good old-fashioned `mail` works too, although it's a little cryptic.

`alpine` is menu driven, and the menus are self-explanatory; it's surprisingly easy to learn, and surprisingly powerful when you want to customize it.

From the command line (after logged in via SSH), type: `pine` and `[return]`
Follow instructions and use the menus at the bottom and top. (Note: When you see the ^ in front of the letter it means you need to use CTRL, otherwise just use the letter.)

## non-cli options

alternatively, you can use the [webmail](https://webmail.tilde.club/) or standard imap/smtp.

some clients will automatically detect the right settings (tested with thunderbird).

connection settings:

- imap.tilde.club port 993 with ssl
- pop3.tilde.club port 995 with ssl
- smtp.tilde.club port 587 with starttls

please remember to use only your tilde username as the login name, excluding the `@tilde.club`; for example `invalid` instead of `invalid@tilde.club`

if you'd like your @tilde.club mail forwarded elsewhere, you can put an email 
address in a file called `~/.forward`

## sieve filtering

our dovecot configuration supports [sieve](http://sieve.info/) and 
[managesieve](https://wiki1.dovecot.org/ManageSieve).

this means that you should put your scripts in a `~/sieve/` directory,
symlink the active script to `~/.dovecot.sieve`, and make sure to compile it
with `sievec ~/.dovecot.sieve`.

you can find some example sieve scripts [here](
https://doc.dovecot.org/configuration_manual/sieve/examples/).

alternately, you can use webmail's [filter settings](
https://webmail.tilde.club/#/settings/filters) to configure your filters.

## mailing list

we now have an official mailing list!

if your account is old (pre sept 2019), you should be subscribed with the email
you originally signed up with. if your account is newer (post sept 2019), then 
you should be subscribed with your @tilde.club address. if you don't fit either
of those categories, you can subscribe by visiting the [web portal](
https://lists.tildeverse.org/postorius/lists/tildeclub.lists.tildeverse.org/)
or by sending a mail to tildeclub-subscribe@lists.tildeverse.org with "subscribe"
in the subject line. in either case, you can change the email you're subscribed
with on the web portal or by unsubscribing and re-subscribing from the other
address.

list archives are available [on the web here](
https://lists.tildeverse.org/hyperkitty/list/tildeclub@lists.tildeverse.org/).

as of september 17, 2019, we're still seeing quite a few pending mails to
gmail, yahoo, and fastmail. help get our list delivered by making sure to
mark list messages as not spam and adding the list address to your contacts.
if you're feeling especially motivated, please reach out to the support on
your mail provider and ask them to look into why you're not receiving the
messages.

## Login-Time New Mail Notification

If you use an on-server email client to handle your Tilde.club inbox
and have ever received any email there,
you probably noticed that there was no incoming mail notification
(<q>You have new mail.</q> or similar message)
appearing at login time.
This is due to the [mailbox format](#Mailbox-Format) used in Tilde.club
not being the traditional centralized-folder MBOX;
but fret not:
if you wish to bring back this old-timey function,
it can still be done by a one-line script.

To add this notification,
add the following one-line Bourne shell snippet
to your _login script_:

	ls -U ~/.mail/new | grep -F -q "" && echo "You got mail."

If you are using Bash (default) as your login shell,
your _login script_ file would be `~/.bash_profile`;
but if you are using Dash,
your _login script_ would be the traditional `~/.profile`.
(For other shells,
check your manual)

However,
if you arranged for a terminal multiplexer to start automatically
at the login time,
you would not see the notification added this way.
So in this case,
you would rather want this notification
to be shown at each start of your shell:
instead of adding the snippet to your login script,
you would have to add it to your shell's startup script:
in case of Bash (default shell),
your startup script would be `~/.bashrc`.
(For other shells,
check your manual)

Note that this code snippet
only checks your main inbox folder.
So,
if you have explicitly written some [Sieve](#sieve-filtering)
or webmail filtering rules
to deliver some of the incoming emails into specific folder
other than the main inbox,
those emails would not produce notification.
(This can be a desirable outcome in most cases,
where people write Sieve filter
to redirect unsolicited emails into <q>Junk</q> folder)

## Mailbox Format

Tilde.club uses [Dovecot](https://www.dovecot.org/) as a local mail delivery agent
as well as an IMAP server.
It is configured to deliver your emails
into a `.mail/` subdirectory
within your home directory on the server,
structured in [Courier MTA's Maildir++ format](https://www.courier-mta.org/imap/README.maildirquota.html).

Maildir++ format is essentially the same as Maildir mailbox format,
but with a concept of subfolders added in:
apart from the usual `cur/`,
`new/`,
and `tmp/` subdirectories for normal Maildir operations;
there would now also be dot-subdirectories
which are email subfolders.
Each dot-subdirectory
would contain usual Maildir subdirectories,
but not any more dot-subdirectory inside it.

In Tilde.club,
the default layout of your Maildir++ folder hierarchy
would be as the following:

| Email Folder | Filesystem Directory  |
|:-------------|:----------------------|
| _(Inbox)_    | `~/.mail/`            |
| _(Sent)_     | `~/.mail/.sent-mail/` |
| Junk         | `~/.mail/.Junk/`      |
| Drafts       | `~/.mail/.Drafts/`    |
| Trash        | `~/.mail/.Trash/`     |

So,
if you would like to use command line tools
to tinker with your mailbox,
then more power to you.
Also,
note that email access via IMAP and webmail
actually read/write emails directly onto these directories;
so now you know where to grab a copy of all your emails data
if you ever need a backup as well.
