---
title: usenet news
category: tutorial
author:
  - deepend
  - audiodude
  - xwindows
---

## As of 2020-04-14 news is back up!

You'll need a news (NNTP) client to read news.
The address to use inside of Tilde.club
is `localhost` port 119.
The address to use outside is `news.tilde.club` port 119 (plain),
or port 563 (with TLS,
available since 2023-02-17).
If you connect from outside of Tilde servers,
e.g. from home,
you would have to use TLS
and authenticate using your Tilde.club username and password,
to be able to post.

This netnews service is brought to you by [~deepend](../~deepend) (administrator)
and [~xwindows](/~xwindows/) (technical troubleshooter).

## News clients

### slrn
[slrn](slrn.html) is a newsreader; see http://slrn.sourceforge.net/ for details.

First, add `export NNTPSERVER="localhost"` to your shellrc (`.bashrc`, `.zshrc`)
and source it (`source path/to/.shellrc`).

Then run `slrn --create` to create the slrn config file, and lastly `slrn -d` to
populate group names.

You're now ready to run `slrn`! If the list is empty, press `L` (for list-groups) and enter `*` in the field for all groups. You might need to enter each group (pressing `space`) to get a proper count for how many (if any) unread messages there are.

### pine/alpine

[[pine]] can read news; this
[http://www.chebucto.ns.ca/Help/News/PineNews.html](tutorial) might help.
You can also read the [FAQ from U Washington](http://www.washington.edu/pine/faq/news.html).

If you use Pine from inside Tilde.club,
configure it by:

1. 'S' for setup, 'C' for config, then 
1. set 'NNTP Server (for news)' to `localhost`
1. Then go back to the main menu, and pick Folder List,
1. A for add, ^t for list

### Emacs

`M-x gnus` in [[emacs]] can read news, but you better know [[emacs]] first before you start.

### lynx

[[lynx]] reads news, a la `lynx news://news.tilde.club/tilde.general`. It can even post news, but you have to design your own headers.

### tin
There is also [tin](tin.html).

### Thunderbird
If you are a Tilde.club member and already using Thunderbird for email;
it can also be configured for news.

1. Go to the `Tools` menu, -> `Account Settings`
1. Under `Account Actions` click `Add Other Account...`
1. Select "Newsgroup Account"
1. Type in the name you and email address you want associated with your posts.
   This can be your real name and tilde.club email address, or any other name
   (like your tilde username) and any other email address.
1. For the "Newsgroup Server" type `news.tilde.club`. Give it a name
   ("news.tilde.club" works fine), confirm a couple of times,
   and you should see a new entry for news.tilde.club
   in the left panel of the Account Settings dialog.
1. Select `Server Settings` under it,
   and change `Connection security` to "SSL/TLS";
   you would see that the `Port` setting above it changed to 563.
   (If it doesn't do that automatically,
   make it so)
1. Press OK to close the Account Settings dialog.
1. Right click on "news.tilde.club" in your accounts list and click
   `Subscribe...`
1. You should see a dialog with a tree of news topics. Click one and click
   `Subscribe` to subscribe to the topic. When Thunderbird is running, it will
   periodically check for new messages to each of these topics. You will also
   see a list of topics in your accounts list with unread counts.
1. To post to a topic, open the topic and click the "Write" button.
1. When you click `Send` on your new post,
   Thunderbird would ask for your Tilde.club username and password
   (which is the same as the one you use on your [Tilde.club email](email.html)).
