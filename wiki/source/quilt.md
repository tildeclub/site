---
title: tilde quilt
author: lab6
category: tilde.club
---

## 2-dimensional anonymous collaborative microblogging

[Visit the tilde quilt](https://tilde.club/~lab6/quilt.html) to read messages from other tilde users.

Add your own messages (up to 150 printable ASCII characters) by running a command like the following:

`echo "Hi!" > /home/lab6/quilt`

Each message has an id in the top left corner, which you can use to influence where your message is placed.
You can prefix your message with &lt;id>&lt;compassdirection>, where direction is one of N, E, W, or S, like this:

`echo "2EThis message goes to the east of the message with id 2" > /home/lab6/quilt`
`echo "3NThis message goes to the north of message 3" > /home/lab6/quilt`
`echo "4SThis message goes to the south of message 4" > /home/lab6/quilt`
`echo "5WAnd this message goes to the west of message 5" > /home/lab6/quilt`

If you don't use a prefix like this, your message will be placed randomly.

Rate-limiting is in effect. If your write blocks, just wait. If your write fails, or your message fails to appear on the quilt,
wait a minute or so and try again. The rate-limiting is intended to keep the quilt slow and human-scale. Please don't pipe in
massive streams of data - it will clog the pipe for other users.

Have fun and be kind!

## What's going on?

We are building a patchwork quilt with the aid of POSIX named pipes. Any user able to execute a command on tilde.club
can pipe their message to `/home/lab6/quilt`. Messages are anonymous - there is no way to detect which user sent data into the pipe.
Users from outside the tilde.club server can [read the quilt](https://tilde.club/~lab6/quilt.html) but cannot add to it.

Backups will be taken regularly and the quilt will never be reset. The quilt is strictly
append-only. Old messages are never edited or overwritten (spam and nastiness may be spray-painted over but I trust you folk to be better than this).
The quilt grows without bound in all four directions.

Be creative. Use your 150 characters wisely. If you didn't use them wisely, try again. Hold a conversation. Vent a thought. 
Play correspondence chess. Golf some perl. Branch off into the void.

Early adopters who snag the low messages IDs will be venerated by the generations to come.

Contact ~lab6 if it's broken. Contact ~lab6 if it's not broken - he loves getting postcards.

## Roadmap

* Unicode
* 2D blockchain
* z-axis
