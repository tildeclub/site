---
title: how to use git
category: tutorial
---

`git` is a version control system. It's pretty confusing at first, but
once you sort out what it can do and can't do, it starts to get better.

This tutorial is pretty good: http://git-scm.com/docs/gittutorial

The best way to learn `git` is to find someone who knows `git` really
well and sort out issues with them. Ask on [IRC](chat.html) if you get
stuck. (There should be a better buddy system for this, but until there
is, we do what we can.)

A good introduction to `git` is to create a repository for your
`public_html` directory. This will allow you to back up your public web
directory.

First thing you will want to do is set up git.

If you don't have a [GitHub](http://github.com) account, you will want
one for this exercise. If you choose another Git host, you will need to
work out some parts of this setup on your own.

Once you have a git account, you will want to set up `git` for your
tilde.club account. Use the email address that you used to create your
GitHub account. You can register multiple accounts with GitHub if
needed.

    git config --global user.name "Your Name Here"
    git config --global user.email youremail@example.org

You will also want to create a `.gitignore` file. This file defines what
things you want git to ignore, such as editor temporary files or
directories you may not want to keep in `git` such as generated files or
private files you upload to a public repository. The `.gitignore` file
can be created in your home directory, but I like to create it in the
project directory.

Here is an example `.gitignore` file:

    # files being edited
    *~
    *swp
    # Generated files
    tilde_graphs
    # Private files
    diary.txt

Now go create a repository on GitHub. In our examples we are using
mytildeweb as the repo name, but you can choose whatever name works for
you. If you do change the repository name be sure to update the commands
with the proper one.

Now we should be ready to create and upload the repository.

    cd public_html/
    # This will initialize public_html as a repository
    git init
    # Adds all files to the repo. "." means "the current directory" (public_html, in this case)
    # Note: you can also add files one at a time
    git add .
    # Commits files to local repo
    git commit -m "first commit of tildeweb"
    # Tells git where your remote repo is
    git remote add origin https://github.com/<yourgithubuser>/mytildeweb.git
    # Uploads to the remote repo
    git push -u origin master

Your files should now be on GitHub. If you make a change and you want to
update, do the following after making your edits:

    git add index.html
    git commit -m "updated blog"
    git push origin master
