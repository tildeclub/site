---
title: Botany
author: deepend
category: software
---

**Botany** is a tiny terminal game where you grow an ASCII plant that lives on your Tilde home. It thrives when you water it on time, and it sulks—then dies—if you forget.

## Quick start

* In a shell, run: `botany`
* Use the on-screen menu to **Water**, **Look**, **Visit**, **Garden**, **Instructions**, or **Exit**.
* Your plant and stats live in `~/.botany/`.

## How it grows

* Time = score. The longer it lives (and the more generations), the more **ticks** you earn.
* Stages: **seed → seedling → stages 2–5**.
  * Species appears at stage ≥2, rarity at ≥3, color at ≥4, “seed-bearing” at 5 (you can **harvest** then).
* Miss watering too long and the plant dies. Typical rhythm:
  * **Thirsty after ~18h**, **dead after ~72h** without water.

## Watering

* In the game: choose **Water**.
* On IRC (community bot): in a channel the bot is in (or via DM), use:
  * `!water <user>` — record a visit/watering for `~<user>`.
  * `!plant <user>` — show the current status summary.
  * The bot is rate-limited to prevent spam and will **tell you if a plant appears dead** (watering won’t revive it).
  * Privacy: if a user has opted out (see below), the bot **pretends their plant doesn’t exist**.

## Seeing your plant on the web

* Personal page: `https://tilde.club/~username/myplant`
  * Shows status, last watered, and the current ASCII art (including fun holiday art on Oct 31).
* **[botanygarden](https://tilde.club/botanygarden)** (web): a community “garden view” that showcases many members’ plants in one place.

### Opt-out of the web view

Don’t want your plant visible on the web (or referenced by the IRC bot)? Create this file:

```

touch \~/.notrackbotany

```

The personal page will show “private,” the garden won’t list it, and the IRC bot will act as if it doesn’t exist.

## Visiting and the garden

* **Garden** (in-game): browse everyone’s plants from inside Botany.
* **[botanygarden](https://tilde.club/botanygarden)** (web): browse a mosaic of plants and jump to user pages.
* **Visit**: see who stopped by and go say hi. Visiting is social.

## Tips

* Water roughly every 18 hours; set a reminder.
* Stage 5 lets you **harvest** to start a new generation with bonuses.
* If a web page looks wrong, launch `botany` once—opening the game reconciles state.

Grow well, water often, to keep the garden alive.

