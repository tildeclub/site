---
title: Byobu, TMUX & Screen (terminal multiplexers)
author: rudi
category: software
---

# Terminal Muiltiplexers
Terminal multiplexers are programs that will keep your session running, even if you disconnect from the server. They also allow you to 'multiplex' your terminals, spawning multiple shells in one local terminal. The three multiplexers on tilde.club are [byobu](https://linux.die.net/man/1/byobu), [tmux](https://linux.die.net/man/1/tmux), and [screen](https://linux.die.net/man/1/screen).

# Byobu
byobu is the default mutliplexer for tilde.club. It was originally designed to provide elegant enhancements to the otherwise functional, plain, practical [GNU Screen](http://www.gnu.org/software/screen/), for the [Ubuntu](https://ubuntu.com/) server distribution. Byobu now includes an enhanced profiles, convenient keybindings, configuration utilities, and toggle-able system status notifications for both the GNU Screen window manager and the more modern [Tmux](https://github.com/tmux/tmux) terminal multiplexer, and works on most Linux, BSD, and Mac distributions.

In the spirit of the former tmux page, here is a super basic primer:
The basic keys to know are f2, f3, f4, f6, f8, and f9
f2 - spawn new tab
f3 - move to previous (left) tab
f4 - move to next (right) tab
f6 - disconnect from byobu (and the server)
f8 - rename a tab
f9 - configuration menu (also has a basic help guide)

With those keys, you can do a lot. However tmux shortcuts will work here in byobu (but unless you configure it differently, the escape sequence isn't ctrl-b, it's ctrl-a)
You can even configure byobu to run automatically when you connect, using `byobu-enable` (`byobu-disable` to undo).
For a more in depth overview, you can go to [byobu's documentation](https://www.byobu.org/documentation) or `man byobu`.

# Tmux
Here's a super basic primer.

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

I'm not the best writer or teacher. Just google anything that doesn't make sense. 

[Or take a look at this tmux guide](http://robots.thoughtbot.com/a-tmux-crash-course)

But definitely use tmux or byobu.

Or, if you don't like it - try [screen](screen.html)

# screen

`screen` is a unix utility that lets you manage multiple shells from within a single window. You switch between them with a few keystrokes. When you disconnect it keeps the processes alive, and you can reconnect from another login.

It's pretty handy. [tmux](tmux.html) does a similar set of things.

a nice [screen tutorial](http://tilde.club/~jonathan/screen/) from ~jonathan will walk you through it.

