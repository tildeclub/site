---
title: JSON
---

JSON is the "Javascript Object Notation", basically a file format for
data that's suitable for easy processing by most modern web-based tools.

Several tilde.club programs expose APIs essentially by spitting out
JSON as their output, including e.g. the list of recently updated home
pages at

[http://tilde.club/~delfuego/tilde.24h.json](http://tilde.club/~delfuego/tilde.24h.json)

If you're looking to parse JSON from the command line with a minimum of
code, the `jq` program may be your thing. `jq` is a filter that takes
JSON on standard input and produces JSON on standard output. Along the
way in the middle you can do various standard sorts of file munging on
a field by field basis.

[Documentation for `jq` is in its manual.](http://stedolan.github.io/jq/manual/) 
