---
title: how to contribute to this wiki
author: benharri
---

1. grab a copy of the site's source code

    git clone https://github.com/tildeclub/site tilde.club && cd tilde.club/wiki

1. make a new article or update an existing one (only change the markdown
   source)

1. generate the wiki pages. you need to be in the wiki directory.
   run `./build-wiki.sh` to create the html.

1. submit the code via a PR on github or with git-send-email(1) to root@tilde.chat
   see [git-send-email.io](https://git-send-email.io) for more info on how to use
   it. if you're working locally on tilde.club, you won't have to configure
   anything; git will use the system's sendmail to handle the email.

1. profit???

ask on irc if you have questions!

