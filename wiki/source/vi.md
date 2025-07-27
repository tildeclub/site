---
title: The Vi Editor
category: software
author:
  - ant
---

*Tilde.Club* has
[The Traditional Vi](https://ex-vi.sourceforge.net/)
installed on its premises.
It is not just another
[Vi clone](https://texteditors.org/cgi-bin/wiki.pl?ViFamily),
but the direct continuation
of Bill Joy's legendary work at Berkeley.
The binaries are in `/usr/archaic/bin/`
and the man pages
(separately for `ex` and `vi`)
in `/usr/archaic/share/man/man/`.

You can invoke *The Traditional Vi* in several ways
(in the order of increased engagement):

1. by the full path to the executable:

       /usr/archaic/bin/vi

2. by adding it as an alias to your shell's `rc` file
   (`~/.bashrc` for *Bash*), e.g:

       alias tvi=/usr/archaic/bin/vi

   and then invokng *Vi* by typing `tvi`,

3. by adding the locations *Vi* and its documentation
   in front of the `PATH` and `MANPATH` environment variables
   in your shell's profile script
   (for *Bash*, `~/.bash_profile` or `~/.profile`):

       export    PATH="/usr/archaic/bin/:$PATH"
       export MANPATH="/usr/archaic/share/man/man:$MANPATH"

The latter method has the advantage
of affecting subshells,
so that if you specify `vi` as the default editor
in your e-mail or news client, or another CLI program,
it will invoke *The Traditional Vi*,
ditto for your shell scripts
and the `EDITOR` environment variale.

## Resources

1. Bill Joy's
   [An Introduction to Display Editing with Vi ](https://ex-vi.sourceforge.net/viin/paper.html),
2. [`vi(1)`](https://ex-vi.sourceforge.net/vi.html) man page,
3. [`ex(1)`](https://ex-vi.sourceforge.net/ex.html) man page,
4. [A concise `vi` reference](http://www.ungerhu.com/jxh/vi.html),
5. [The Ultimate guide to the VI and EX text editors](https://archive.org/details/ultimateguidetov0000unse_i5e4) (a paper book),
6. The `#vi` channel on the
   [Libera.Chat](https://libera.chat/)
   IRC network,
   dedicated to the original *Vi*
   and all its variants except *Vim* & co,
7. [VI experience in the shell](https://deut-erium.github.io/2024/01/28/inputrc.html).

## Building

*The Traditional Vi* is surprisingly easy to build from
[its source](https://sourceforge.net/p/ex-vi/code/).
You only need to locate the following line in `Makefile`:

    TERMLIB = termlib

and replace the value with `curses` or `ncurses`,
depending on your preferred terminal library.
Now you can build and install the project with:

    make && make install
