---
title: using cgit on tilde.club
author: deepend
category: tilde.club
---

`cgit` gives every tilde.club member a simple, read‑only web view of their public Git repositories.
Any repo you put in `~/public_git/` and end with `.git` is automatically shown at

```
https://tilde.club/~<username>/git/
```

Below is the quick‑start plus a few tips.

---

## 1  Create the **public\_git** directory (once)

```bash
$ mkdir -p ~/public_git
```

The web server is already allowed to traverse `~/public_git`, so you do **not** have to chmod anything manually.

---

## 2  Add a repository

Only **bare** repos are accepted (they have no working tree inside them).

```bash
# create a brand‑new bare repository
$ cd ~/public_git
$ git init --bare hello.git
```

or push an existing project:

```bash
$ cd ~/my/project
# add tilde as a remote and mirror‑push everything
$ git remote add tilde ssh://<username>@tilde.club/~/public_git/project.git
$ git push --mirror tilde
```

You can repeat for as many repos as you like; just keep each one directly in
`~/public_git/` and make sure the name ends with `.git`.

---

## 3  Browse your repos

```
Index page   : https://tilde.club/~<username>/git/
Single repo  : https://tilde.club/~<username>/git/<repo>.git/
```

Example for user **deepend**:

```
https://tilde.club/~deepend/git/          # lists everything
https://tilde.club/~deepend/git/hello.git/  # specific repo
```

The header will say `~deepend Git Repositories`, commits are clickable, diffs
are highlighted, and the cloning URL is shown near the top right.

---

## 4  Update a repository

Because the repo is bare you **push** into it; cgit shows the new state
immediately.

```bash
$ git push tilde main          # normal
$ git push --mirror tilde      # full mirror (branches + tags)
```

---

## 5  Remove a repository

Simply delete or rename the directory:

```bash
$ rm -rf ~/public_git/oldstuff.git
```

The entry disappears from the index on the next page load.

---

## FAQ

### Can I hide a repo from the list?

Move it somewhere else in your home directory or make it non‑bare.
`cgit` only scans `~/public_git/*.git`.

### Why bare repos only?

Internal `.git/` directories inside non‑bare repos confuse cgit’s scanner and
produce broken links like `/repo.git/.git/`.
Bare repos avoid that and are the normal way to publish Git over HTTP.

### Clone / pull URL?

Use SSH for write access:

```
ssh://<username>@tilde.club/~/public_git/<repo>.git
```

or plain HTTPS for read‑only:

```
https://tilde.club/~<username>/git/<repo>.git
```

---

Happy hacking, and show off your code!
Questions? `#club` on irc.newnet.net or mail **[root@tilde.club](mailto:root@tilde.club)**.
