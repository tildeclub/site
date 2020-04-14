---
title: how to contribute to this wiki
author:
  - benharri
  - audiodude
category: tilde.club
---

# Want to contribute to this wiki?

There are N ways to contribute to this wiki:

## The super ultra easy way

Send an email to [~audiodude](../~audiodude), audiodude@tilde.club. Put the
proposed contents in the email in markdown format. You don't have to worry
about "frontmatter", just indicate who the author is (your tilde username),
what the title of the article should be, and what category, if any, it should
fall under.

**~audiodude** will add the article to the git repo, add the YAML frontmatter,
and merge the content into the wiki repo for you. He'll also email you when
the content is live on the server so you can show all your friends!

## The super ultra mega easy way

Same as the "super ultra easy way" above, except you don't even have to add
Markdown formatting if you don't want. Just send an email with your wiki
article, and all the "metadata" aka author, title, and category, and
**~audiodude** will add the Markdown formatting for you (in addition to all the
things from the super ultra easy way).

## The easy-ish way

This wiki exists as a [git repo on Github](https://github.com/tildeclub/site/tree/master/wiki/). Whenever someone pushes a commit to the wiki directory,
the wiki site gets automatically built and made live on tilde.club.

What that means is that if you can simply create a file in that repo, you will
have made your article live on the wiki. But luckily, you can do that from the
Github GUI! Here are some steps that might help with that.

1. Visit the [source directory](https://github.com/tildeclub/site/tree/master/wiki/source) of the wiki, where all the articles live. Sign in to Github.
1. Click the "Create new file" button: <img alt="screenshot of github repo" src="https://tilde.club/~audiodude/images/wiki/create_new_file.png" width="100%"/>
1. Type in the file name of your article ('my_cat.md' for example, if the article is about your cat). Then add some YAML frontmatter with the title, author (your tilde screenname) and category, like in this screenshot: <img alt="screenshot of article creation" src="https://tilde.club/~audiodude/images/wiki/file_contents.png" width="100%"/>
1. Your article contents go on the next line after the last `---` of the front matter. You can write anything you want, especially using [Pandoc Markdown](https://pandoc.org/MANUAL.html#pandocs-markdown) and even HTML!
1. When you created the file, if you didn't have write access to the tildeclub `site` repository, Github had already created a personal "fork" of the repo for you. Click the "Propose new file" button when you're done editing.
1. You'll go to the "Comparing changes" page, where you can review your article. Next, click "Create pull request". Then on the next page, you can write a description of your article for the owners of the repo to see (but this will only appear on Github!)
1. When you're done, click "Create pull request" again. Now you will go to a page which is tracking your change to the wiki and it's status, whether it's been "merged" aka pulled into the wiki, and any comments that have been left.
1. *Your work is done, just sit back and wait for your change to be live on the site!*

## The easy way

Maybe you found a typo on one of the existing pages, or would like to otherwise edit an article on the wiki.

You can do this right from the Github GUI!

*(You might want to read the information on "The easy-ish way" for how the wiki is organized and what it means to commit to the repo)*

1. Visit the [source directory](https://github.com/tildeclub/site/tree/master/wiki/source) of the wiki, where all the articles live. Sign in to Github.
1. Find the markdown file of the article you want to edit. It might be similar, but not the same, as the article's title. An easy way to find the article is to look in your browser address bar when you're on the article's page. The part after `/wiki/` is the article name, except in Github it has an `.md` extension instead of `.html`. For example, this file is `wiki.md`.
1. Click the "edit pencil" on the gray banner: <img alt="screenshot of github article edit button" src="https://tilde.club/~audiodude/images/wiki/pencil.png" width="100%"/>
1. Edit the contents of the file using [Pandoc Markdown](https://pandoc.org/MANUAL.html#pandocs-markdown). If you don't know what that is or don't care, no problem! For simple grammatical and wording/phrasing fixes, you should be fine to just do them in place.
1. Follow the steps from (5) above (the easy-ish way), except instead of clicking "Propose new file", click "Propose file change".

## The maybe-kinda easy way

1. Grab a copy of the site's source code

    git clone https://github.com/tildeclub/site tilde.club && cd tilde.club/wiki

1. Make a new article or update an existing one. Make sure that you create the
   title, author, and category keys in the yaml frontmatter (see an existing
    article for an example).

1. submit the code via a PR on github or with git-send-email(1) to root@tilde.club
   see [git-send-email.io](https://git-send-email.io) for more info on how to use
   it. if you're working locally on tilde.club, you won't have to configure
   anything; git will use the system's sendmail to handle the email.


# Most importantly

Ask on irc if you have questions!

