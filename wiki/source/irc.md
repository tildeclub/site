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

## IRC Bouncer (ZNC)

You can find a ZNC IRC Bouncer by going to: [https://services.tilde.club/znc](https://services.tilde.club/znc).
Use your tilde.club username and password for login.  
To connect to your ZNC its at services.tilde.club   Port: 6699(SSL)

### Users created before December 28th, 2021 will need to email [mailto:root@tilde.club](root@tilde.club) to get your user added. 

