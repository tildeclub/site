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

