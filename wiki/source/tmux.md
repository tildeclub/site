---
title: terminal multiplexers - tmux
category: software
---

TMUX IS THE BEST. Here's a super basic primer.

to start a new session, type `tmux new -s tildemux`.

A yellow bar will appear at the bottom of your terminal. You're now in TMUX!

TMUX has sessions, windows, and panes. Each of these things will have a terminal in it. If you actually typed what I told you to earlier, you'll be in a session named `tildemux`. That session has one window, `0`. That window has one pane, also named `0`. (Computers start counting at 0, not 1.)

## windows

Your tmux bar should look like: 

`[tildemux] 0:bash*`

…which means that you're in a session named `tildemux`, which has a window `0`, running the command `bash`. `*` means that window 0 is active, and the pane running bash is currently active.

To create a new window within this session, type `PREFIX c`. PREFIX?!? By default, it's `control-b`. Now you should see:

`[tildemux] 0:bash- 1:bash*`

`1:bash*` means you're in a pane running `bash` inside window 1. To change back to pane 0, type `PREFIX 0`. The `*` should be back on `0:bash`.

Run a cool interactive command, such as `htop` (to see how many of system resources we're eating up) or `vim` (to write some awesome webpages). Your tmux status bar should update to `0:<name of the current process>`. So now instead of saying `bash` it will say `htop` or `vim`.

## panes

Panes are great. TMUX panes let you run more than one terminal inside your one, actual terminal. To "split" a new pane, `PREFIX "`. That makes a horizontal split. You'll notice there are now two panes open one on top of the other. `PREFIX %` makes a vertical split, for side-by-side panes. Did I mention that panes are great?

To move between panes in the current window, use `PREFIX <up,down,left,right>`. That's right, the arrow keys.

## more

I not the best writer or teacher. Just google anything that doesn't make sense. 

[Or take a look at this tmux guide](http://robots.thoughtbot.com/a-tmux-crash-course)

But definitely use tmux.

Or, if you don't like it - try [screen](screen.html)
