---
title: .vimrc file
category: tutorials
---

The file `.vimrc` in your home directory has instructions for [[vim]]
to load every time it runs. Customizations go there.

For instance, you might want to use [[Markdown]] to edit files that
end in `.md`. The system default for some reason is to treat these as
[[Modula-2]] files, though we don't have a Modula-2 compiler running
(yet).  So the contents of `.vimrc` should read

``
au BufRead,BufNewFile *.md set filetype=markdown
``

For more suggestions in deep depth on how to set up your `.vimrc` please read
[this tutorial from Doug Black](https://web.archive.org/web/20161224112739/https://dougblack.io/words/a-good-vimrc.html). (The website's no longer up, it's on the 'net archive.
