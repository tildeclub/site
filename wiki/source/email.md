---
title: email
author: benharri
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

if you'd like your @tilde.club mail forwarded elsewhere, you can put an email 
address in a file called `~/.forward`

## sieve filtering

our dovecot configuration supports [sieve](http://sieve.info/) and 
[managesieve](https://wiki1.dovecot.org/ManageSieve).

this means that you should put your scripts in a `~/sieve/` directory,
symlink the active script to `~/.dovecot.sieve`, and make sure to compile it
with `sievec ~/.dovecot.sieve`.

you can find some example sieve scripts [here](
https://wiki.dovecot.org/Pigeonhole/Sieve/Examples).

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

