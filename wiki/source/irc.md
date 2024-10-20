---
title: Socializing and chat
author: 
  - emv
  - benharri
  - deepend
category: tutorials
---

## irc

Our main channel is on the [Newnet IRC Network](https://newnet.net). the official 
channel for ~club is `#club`. Stop by and say hello!

run `chat` to open [weechat](https://weechat.org) auto-connected to our irc
server. try launching [tmux](tmux.html), [byobu](https://superuser.com/a/423397)
 or [screen](screen.html) to keep your chat session running.

other clients like irssi are available as well! just connect to localhost on
port 6667 and `/join #club`. If your client defaults to enabling TLS, you'll need to specify that it shouldn't use TLS.

feel free to use Newnet's [webchat](https://web.newnet.net/?join=club) if
you prefer.

some channels might require you to register your nickname with NickServ to post in them (e.g. #meta). NickServ acts like a regular user, so you communicate with it through `/msg`. steps:

1. [optional] set nickname: `/nick YourNick` - not necessary with weechat, since it connects you under your tilde.club username
2. register: `/msg NickServ REGISTER YourPassword youremail@example.com` - you can use your tilde.club e-mail address for this
3. wait for registration email with confirmation code
4. confirm: `/msg NickServ CONFIRM someCode`

after this, every time you reconnect to irc you will have to identify with nickserv again: `/msg NickServ IDENTIFY YourPassword`.  

weechat tip: NickServ replies and error messages appear in the first buffer `tilde weechat` (use Alt + up/down to switch).

## Weechat relays

weechat introduced [unix socket relays](
https://weechat.org/files/doc/stable/weechat_user.en.html#relay_unix_socket)
in version 2.5 which is a much easier way to offer per-user relay access.

tilde.club/~username/weechat is configured to proxy to the default unix relay socket
location (`~/.weechat/relay_socket`). to get started using it, follow these steps.

1. in weechat:
    * `/relay add unix.weechat %h/relay_socket`
    * `/set relay.network.password mysupersecretpassword` - don't use this password
      of course. note that you might already have this set.

2. at your shell:
    * `chmod o+rw ~/.weechat/relay_socket` - note that other members of the club group
      are not included in the granted permissions. this allows nginx to connect
      to your socket on your behalf. you will need to do this every time you start
      weechat as the socket doesn't exist until weechat starts up.

3. in your relay client:
    * [glowing-bear](https://glowingbear.tilde.club/):
        - relay hostname: tilde.club:443/~username/weechat
        - relay port: 443
        - your relay password

    * [weechat-android](https://github.com/ubergeek42/weechat-android) and [lith](https://github.com/lithapp/lith):
        - connection type: websocket (ssl)
        - websocket path: ~username/weechat
        - relay host: tilde.club
        - relay port: 443
        - your relay password

    - (if you get "Error: Could not connect using WebSocket", check to be sure
      ~/ and ~/.weechat have at least o+rx permissions so nginx can reach
      ~/.weechat/relay_socket)

## IRC Bouncer (ZNC)
NOTE: Email deepend or message him on IRC if you require ZNC access. 

You can find a ZNC IRC Bouncer by going to: [https://services.tilde.club/znc](https://services.tilde.club/znc).
Use your tilde.club username and password for login.  
To connect to your ZNC its at services.tilde.club   Port: 6699(SSL)

NOTE: long passwords fail to authenticate with the ZNC server.
