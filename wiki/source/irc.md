---
title: Socializing and chat
author: 
  - emv
  - benharri
  - deepend
category: tutorials
---

## irc

Our main channel is on the [Newnet IRC Network](https://newnet.net).  
The official channel for ~club is `#club`. Stop by and say hello!

> **New!** An *official secondary* channel is now open on the Zoite IRC  
> Network in case Newnet ever has an outage (or if you just feel like
> hanging out elsewhere). Connect to **irc.zoite.net** on port **6670 SSL**
> and `/join #club` – same welcoming vibe, different network.

run `chat` to open [weechat](https://weechat.org) auto-connected to our irc
server. try launching [tmux](tmux.html), [byobu](https://superuser.com/a/423397)
 or [screen](screen.html) to keep your chat session running.

other clients like irssi are available as well! just connect to **irc.newnet.net**
on port **6697 TLS** and `/join #club`.  

feel free to use Newnet's [webchat](https://web.newnet.net/?join=club) if
you prefer.

some channels might require you to register your nickname with NickServ to post in them (e.g. #meta). NickServ acts like a regular user, so you communicate with it through `/msg`. steps:

1. [optional] set nickname: `/nick YourNick` - not necessary with weechat, since it connects you under your tilde.club username
2. register: `/msg NickServ REGISTER YourPassword youremail@example.com` - you can use your tilde.club e-mail address for this
3. wait for registration email with confirmation code
4. confirm: `/msg NickServ CONFIRM someCode`

after this, every time you reconnect to irc you will have to identify with nickserv again: `/msg NickServ IDENTIFY YourPassword`.  

weechat tip: NickServ replies and error messages appear in the first buffer `tilde weechat` (use Alt + up/down to switch).

## WeeChat relays

WeeChat introduced [UNIX domain socket relays](https://weechat.org/files/doc/stable/weechat_user.en.html#relay_unix_socket)
in version 2.5, which is a much easier way to offer per-user relay access.

---

username.tildecities.com/weechat is configured to proxy to a per-user UNIX relay socket.
To get started:

1. In WeeChat:

   * Set your relay password using `/secure`:
     * `/secure set relay mysupersecretpassword`
     * `/set relay.network.password "${sec.data.relay}"`

   * Create the UNIX-socket relay.

     * **tilde.club’s nginx proxy expects the socket in your home dir:**
       * `/relay add unix.weechat ~/.weechat/relay_socket`

2. At your shell (permissions):

   * Ensure nginx can traverse to the socket (execute-only is enough):
     * `chmod o+x ~/.weechat`

   * After WeeChat creates the socket, allow nginx to read/write it:
     * `setfacl -m u:nginx:rw ~/.weechat/relay_socket`

3. In your relay client (WebSocket via tilde.club proxy):

   WeeChat expects the WebSocket URI to end with `/weechat` for the weechat protocol.
   (The tilde.club proxy endpoint should handle this mapping for you.)

   * [glowing-bear](https://glowingbear.tilde.club/):
     - relay host: `username.tildecities.com:443/weechat`
     - relay port: `443`
     - your relay password

   * [weechat-android](https://github.com/ubergeek42/weechat-android) and [lith](https://github.com/lithapp/lith):
     - connection type: WebSocket (SSL/TLS)
     - relay host: `username.tildecities.com`
     - relay port: `443`
     - websocket path: `/weechat`
     - your relay password

### Removing old relays

List relays:
* `/relay listrelay` (or `/relay listfull`)

Delete a relay:
* `/relay del <name>`

(Example: `/relay del unix.weechat`.)


## IRC Bouncer (ZNC)
NOTE: Email deepend or message him on IRC if you require ZNC access. 

You can find a ZNC IRC Bouncer by going to: [https://services.tilde.club/znc](https://services.tilde.club/znc).
Use your tilde.club username and password for login.  
To connect to your ZNC its at services.tilde.club   Port: 6699(SSL)

NOTE: long passwords fail to authenticate with the ZNC server.
