---
title: Socializing and chat
author: 
  - emv
  - benharri
category: tilde.club
---

## irc

we're members of the [tildeverse](https://tildeverse.org) and host a server
in the [tildeverse irc network](https://tilde.chat). the official channel for
~club is `#club`. stop by and say hello!

run `chat` to open [weechat](https://weechat.org) auto-connected to our irc
server. try launching [tmux](tmux.html), [byobu](https://superuser.com/a/423397)
 or [screen](screen.html) to keep your chat session running.

other clients like irssi are available as well! just connect to localhost on
port 6667 and `/join #club`.

feel free to use tilde.chat's [webchat](https://web.tilde.chat/?join=club) if
you prefer.

some channels might require you to register your nickname with NickServ to post in them (e.g. #meta). NickServ acts like a regular user, so you communicate with it through `/msg`. steps:

1. [optional] set nickname: `/nick YourNick` - not necessary with weechat, since it connects you under your tilde.club username
2. register: `/msg NickServ REGISTER YourPassword youremail@example.com` - you can use your tilde.club e-mail address for this
3. wait for registration email with confirmation code
4. confirm: `/msg NickServ CONFIRM someCode`

after this, every time you reconnect to irc you will have to identify with nickserv again: `/msg NickServ IDENTIFY YourPassword`.  

weechat tip: NickServ replies and error messages appear in the first buffer `tilde weechat` (use Alt + up/down to switch).

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

