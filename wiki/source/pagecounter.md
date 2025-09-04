---
title: Page Counter (counter.tilde.club)
author: deepend
category: software
---

Image-digit hit counter for your tilde page. Drops in with one `<script>` tag and increments on each load.

## Quick start

Put this where you want the digits to render (footer is common):

```html
<script src="https://counter.tilde.club/?page=home&user=<your_username>"></script>
```

## What to know

* Counts are keyed by **(page, user)**. Use a unique `page` per page (`home`, `about`, `guestbook`).
* Digits are **zero-padded to 4** (e.g., `0042`).
* **Counts every load** (not unique visitors).
* Requires **JavaScript**.

## URL parameters

* `page` (required): letters/numbers/`._-` only.
* `user` (required): your tilde username (no `~`).
* `style` (optional): digit theme (default `web1`).
* `ext` (optional): image extension (default `gif`).

Example with options:

```html
<script src="https://counter.tilde.club/?page=about&user=<your_username>&style=7seg&ext=gif"></script>
```

## Available styles

`57chevy`, `7seg`, `bbldotg`, `bellbtm`, `blgrv`, `cntdwn`, `computer`, `ds9`, `fdb`, `led`, `marsil`, `sbgs`, `web1`

## Troubleshooting

* **No digits**: open the script URL directly—fix invalid `page/user` or typos.
* **Broken images**: ensure `style` exists and `ext=gif`.
* **Shared counts**: give each page a distinct `page` value.
