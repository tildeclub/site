--- 
title: bashblog 
author: deepend / benharri
---


## Usage

1. To show the available commands type `bb`

Before creating your first post, you may want to configure the blog settings (title, author, etc). Read the Configuration section below for more information

To create your first post, just run:

1. `bb post`

1. write a post (it will open your preferred $EDITOR for you, so make sure it's set)

It will use Markdown. To force HTML:

`bb post -html`

The script will handle the rest.

When you’re done, access the public URL for that folder (https://tilde.club/~username/blog) and you should see the index file and a new page for that post!


## advanced

edit the `.config` file to change the name and url and other settings for your blog

for more details: see [the bashblog repo](https://tildegit.org/club/bashblog)

if you have any improvements/bugfixes, feel free to open a PR!

---
