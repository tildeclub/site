---
title: time zones
category: tutorial
---

The timezone by default on the server is UTC.

If you want to make it so that your shell prints out dates in localtime for you, run `tzselect`
to find the correct timezone name that you'll need to export as the `TZ` environment variable.

for example, if you're in eastern time, add something like this
`export TZ="America/Detroit"`

to your `.bashrc`

