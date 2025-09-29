---

title: ttrv (Reddit in your terminal)
author: deepend
category: software
---

`ttrv` is a TUI Reddit client.

## Setup

### 1) Create the right Reddit app

* Go to [https://www.reddit.com/prefs/apps](https://www.reddit.com/prefs/apps) → **create another app…**
* **Type:** “installed app” (not “script”, not “web app”)
* **Redirect URI (must match exactly):** `http://127.0.0.1:65000/` **← note trailing slash**
* Copy the **client ID** (14-char string under the app name). *Installed app has no secret.*

### 2) Put creds in the right file

Create or edit `~/.config/ttrv/ttrv.cfg`:

```ini
[ttrv]
oauth_client_id = YOUR_CLIENT_ID
oauth_client_secret =
oauth_redirect_uri = http://127.0.0.1:65000/
oauth_redirect_port = 65000
autologin = True
persistent = True
```

* Make a starter config: `ttrv --copy-config`
* Refresh token is stored at: `~/.local/share/ttrv/refresh-token`

### 3) First login

Run `ttrv`, press **u**, authorize in the browser; it will callback to `http://127.0.0.1:65000/`.

## Clear any bad cached token

```bash
ttrv --clear-auth
# or
rm -f ~/.local/share/ttrv/refresh-token
```

## Common “invalid client id” causes

* Wrong app type (must be **installed app**)
* Redirect mismatch (anything other than **[http://127.0.0.1:65000/](http://127.0.0.1:65000/)**, missing slash, different port)

**GitHub:** [https://github.com/tildeclub/ttrv](https://github.com/tildeclub/ttrv)
