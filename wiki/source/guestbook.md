---
title: Tilde Guestbook
author: deepend
category: software
---

A simple, shared guestbook hosted at **guestbook.tilde.club** that you can link to from your personal tilde page.

## What it does

* Stores messages (name, email, message) per tilde user.
* Renders your guestbook at:
  `https://guestbook.tilde.club/index.php?user=<your_username>&theme=<theme_or_default>`

## Requirements

* **Link must come from your tilde page**: the request’s referrer must start with
  `https://tilde.club/~<your_username>/`
  If this doesn’t match, the guestbook shows *“Access denied: Invalid referrer.”*

## Quick start

1. On your tilde page (e.g., `~/public_html/index.html`), add a link:

   ```html
   <a href="https://guestbook.tilde.club/index.php?user=<your_username>&theme=default">
     Sign my guestbook
   </a>
   ```

## Optional theme

* Create a CSS file in your tilde home, e.g. `~/public_html/guestbook.css`.
* Link to the guestbook with `&theme=guestbook` (omit `.css`).
  The guestbook will load:
  `https://tilde.club/~<your_username>/guestbook.css`
* If you don’t set `theme`, it uses `https://guestbook.tilde.club/default.css`.

## CSS customization (what you can style)

When you pass a `theme`, **only your CSS is loaded** (the default stylesheet is not). Your CSS should style the page completely.

### Stable HTML hooks (selectors you can rely on)

* Page title: `h1` (has `align="center"`; override with CSS if desired).
* Intro paragraph and form:

  * `form`
  * `input[type="text"]` for Name and Email
  * `textarea` for Message
  * `input[type="submit"]` for the button
* Entries list:

  * Container: `.entries`
  * Each entry: `.entry`
  * Entry header: `.entry h3`
  * Email inside header: `.entry h3 span`
  * Message text: `.entry p`

## Embedding notes

* Works fine when linked from inside frames/iframes **as long as** the referrer includes your full path (`/~<user>/...`). The meta tag above usually fixes “origin-only” referrers.
* Do **not** use `rel="noreferrer"` on the link—this strips the referrer entirely.

## Troubleshooting

* **“Access denied: Invalid referrer.”**

  * Make sure the link is on `https://tilde.club/~<your_username>/...` (not just the domain root).
  * Check that browser extensions or privacy settings aren’t stripping referrers.
  * The error page will display what referrer was received and the expected pattern.

## Example links

* Default styling:

  ```
  https://guestbook.tilde.club/index.php?user=deepend&theme=default
  ```
* Custom styling (with `~/public_html/guest.css` present):

  ```
  https://guestbook.tilde.club/index.php?user=deepend&theme=guest
  ```
