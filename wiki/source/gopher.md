---
title: gopher
author: benharri
category: tutorial
---

tilde.club now serves gopher! we're using
[gophernicus](https://github.com/gophernicus/gophernicus) as our
gopherd.

user pages are served from your `~/public_gopher` dirs and can be
accessed at `gopher://tilde.club/1/~username`. note that the itemtype
`1` is required.

## basic gophermap syntax

files named `gophermap` are the gopher equivalent to index.html. each
line in a gophermap consists of the following parts separated by literal
tab characters:

-   item type
-   display name
-   selector
-   host
-   port

for example:

`1tildeclub<tab>/<tab>tilde.club<tab>70`

basic item types include:

-   `0` - text file
-   `1` - directory
-   `7` - search query
-   `9` - binary file
-   `g` - gif image
-   `h` - html file
-   `i` - info text
-   `I` - generic image file (not a gif)

gophernicus also supports the following special types:

-   `#` - comment
-   `!title` - only valid on the first line
-   `-file` - hide file from listings
-   `:ext=type` - change filetype
-   `~` - include a list of users with a valid `~/public_gopher`
-   `=mapfile` - include or execute a script or gophermap
-   `-` - stop processing gophermap and include file listing

-   `.` - stop processing gophermap (default)

## additional resources

see [gophernicus' gophermap
documentation](https://github.com/gophernicus/gophernicus/blob/master/README.Gophermap)
for more info on available item types and other special selectors.

if you're completely new to gopher, check out the [gopher zone](https://gopher.zone)!
