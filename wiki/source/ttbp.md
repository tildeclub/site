---
title: ttbp (feels)
author:
  - benharri
category: tilde.club
---

# FEELS MANUAL #

`ttbp` stands for "tilde.town blogging platform", the original working name for
this project. the complete codebase is available on
[github](https://github.com/tildeclub/ttbp).

`ttbp` runs from the command line, providing a hub for writing personal blog
posts and reading posts written by other users of tilde.club. it's a little bit
like livejournal or dreamwidth or tumblr. you can opt to publish your posts to a
public html file hosted on your tilde page, to tilde.club's gopher server, or
keep all your entries private to the tilde.club server.

this is a project that runs on tilde.club, so all users of this program are
expected to operate under the tilde.club [code of
conduct](http://tilde.club/wiki/code-of-conduct.html). content/personal issues should be
worked out according to the CoC, with support from the [administrative
team](https://tilde.club/wiki/code-of-conduct.html#contact-info) if needed.

### support

if you're having trouble getting started, or run into program errors or strange
behavior, please hop on irc and contact ben or deepend.

there's also a function from the main menu that lets you send feedback/inquiries
to me directly; this uses email, which is what i'll respond to.

### writing entries

entries are recorded as plaintext files in your `~/.ttbp/entries` directory.
`ttbp` will use your selected editor to open and write files; each day is its
own entry, like a diary page. at midnight for whatever timezone you've set for
your user account on tilde.club, you'll get a fresh entry. if you don't write
any feels on a particular day, no entries will show up there.

when you save and quit the text editor, your entry will automatically propagate
to the global feels list; if you've opted to publish your feels to html/gopher,
those files will update immediately. you can always go back to the current day's
entry and edit/add as you'd like, but older entries will not be available for
editing from `ttbp`.

*(since files are just stored as plaintext in your directory, it's possible to
edit and move old entries directly from the command line. however, changing old
entries might cause strange things to happen with timestamps. the main program
looks at the filename first for setting the date, then the last modified time to
sort recent posts. it expects YYYMMDD.txt as the filename; anything else won't
show up as a valid entry. yes, this means you can post things out of date order
by creating files with any date you want.)*

#### general entry-writing notes

* you can use [markdown](https://daringfireball.net/projects/markdown/syntax)
* you can use html
* you can also put things between `<!-- comments -->` to have them show up
  in the feed but not render in a browser (but people can still read them with
  view-source)

### reading other feels

the `browse global feels` feature shows the ten most recent entries that anyone
has written on ttbp. this list is only accessible from within tilde.club,
although individual entries may be posted to html or gopher.

you can also pull up a list of a single user's feels through `check out your
neighbors`, which displays all users who are writing on `ttbp` based on their
most recently updated entry, and a link to their public html blog if they've
opted to publish their posts.

**please note!** entries written on `ttbp` should be considered sensitive,
private information, even if a particular user is publishing entries in a
world-viewable way! please be respectful about having access to other people's
feels, and do not copy/repeat any information without getting their explicit
permission. tilde.club operates on a high level of mutual trust, and `ttbp` is
designed to give individuals control over their content.

### privacy

when you start your ttbp, you have the option of publishing or not publishing
your blog.

if you opt to not publish, your entires will never be accessible from outside of
the tilde.club network; other tilde.club users will still be able to read your
entries through the ttbp interface, or by directly accessing your
`~/.ttbp/entries` directory.

if you want to further protect your entries, you can `chmod 700` your entries
directory.

if you opt to publish, the program creates a directory `~/.ttbp/www` where it
stores all html files it generates, and symlinks this from your `~/public_html`
with your chosen blog directory. your blog will also be listed on the [main ttbp
page](https://tilde.club/wiki/ttbp.html).

you can also opt to publish to gopher, and the program will automatically
generate a gophermap of your feels.

you can set publishing status on individual entries, or bury individual feels;
see "data management" below for details.

### data management

the `manage your feels` menu provides several tools for organizing your feels.
these are all actions you can perform manually from the command line, but doing
them from within the program can help keep your files properly linked up.

* **read over feels**--a list of all your entries, which you can open and
  read like any other feel
* **modify feels publishing**--this lets you toggle privacy on individual
  posts. entries marked `(nopub)` will not get written to html or gopher,
  and toggling them from this menu will immediately publish or unpublish
  that entry (if you're not publishing your posts at all, these settings
  won't matter, since your feels will never show up outside of tilde.club)
* **backup your feels**--makes a .tar.gz of all your entries, saving one
  copy to `~/.ttbp/backups/` with the current date, and a second copy to
  your home directory for safekeeping.
* **import a feels backup**--unpacks a backup file into your current feels
  list. this tool checks the `~/.ttbp/backups` directory for archives, and
  expects a file created by the above backup utility. if it detects any file
  collisions, it will preserve your current live copy and leave the backup
  verison in a temp directory, and notify you that this happened. also, any
  entries that were previously marked as `(nopub)` will retain their nopub
  status.
* **bury some feels**--hides individual feels from viewing; entries are
  moved to `~/.ttbp/buried` (and marked with a unique timestamp to prevent
  file collision) with permissions set to 600, meaning no one except you
  will be able to open that file. these entries are also hidden from your
  own view from `read over feels`, and you'll have to open the files from
  the command line if you want to see them. this is intended to be a
  permament action, so you'll be asked to type the entry date once to load
  the feel, then shown a preview of that feel, and then type the date again
  to confirm burying.
* **delete feels by day**--*permanently removes individual entries*,
  including deleting published html/gopher files if needed. this action is
  not recoverable, unless you have a backup to restore; you'll be asked to
  type the entry date once to load the feel, then shown a preview of that
  feel, and then type the date again to confirm deletion.
* **purge all feels**--*permanently removes all feels*, including deleting
  all published html/gopher files if needed. this action is not recoverable,
  unless you have a backup to restore. you'll be asked to type a
  one-time-use purge code to confirm this action.
* **wipe feels account**--*permanently removes all data associated with
  feels*, including deleting any published hmtl/gopher files and removing
  your `~/.ttbp` directory. any backups that you have in `~/.ttbp/backups`
  will also be deleted with this action (which is why the backup function
  makes a second copy for safekeeping in your home directory). you will no
  longer show up in any lists as a user.

### settings

the settings menu lets you change specific options for handling your feels and
using the interface.

* **editor**--set your text editor
* **gopher**--opt in or out of automatically posting to gopher
* **post as nopub**--set whether posts default to being published or not
  published (if you're not publishing your feels, this doesn't matter)
* **publish dir**--set the directory under you `public_html` where feels will be
  published (if you're not publishing your feels, this defaults to `None`)
* **publishing**--opt in or out of automatically publishing entries to a
  world-readable html page
* **rainbows**--opt in or out of having multicolored menu text

### changing your page layout

you can modify how your blog looks by editing the stylesheet or header and
footer files. the program sets you up with basic default. if you break your page
somehow, you can force the program to regenerate your configuration by deleting
your ~/.ttbp directory entirely.  **you might want to back up your
~/.ttbp/entries directory before you do this.**

* to modify your stylesheet, edit your ~/.ttbp/config/style.css
* to modify the page header, edit your ~/.ttbp/config/header.txt
  * there's a place marked off in the default header where you can safely put
    custom HTML elements!
* to modify the page footer, edit your ~/.ttbp/config/footer.txt

### general tips/troubleshooting

* if the date looks like it's ahead or behind, it's because you haven't set
  your local timezone yet.  here are some
  [timezone setting instructions](http://www.cyberciti.biz/faq/linux-unix-set-tz-environment-variable/)
* the feels burying tool will effectively clear your post for the day; you can
  use this feature to start a fresh entry on a particular day by burying the
  current day's feels and then editing a new file

### future features

these are a few ideas being kicked around, or under active development:

* stylesheet/theme selector
* better entry display within ttbp (currently just offloads to `less`)
* buried feels browser

other ideas are listed on github as
[upcoming features](https://github.com/modgethanc/ttbp/issues?q=is%3Aissue+is%3Aopen+label%3A"upcoming+features") or [feature requests](https://github.com/modgethanc/ttbp/issues?q=is%3Aissue+is%3Aopen+label%3A"feature+request")!
