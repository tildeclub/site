---
title: Publish your PGP key via WKS (tilde.club)
author: deepend
category: security
---

# Publish your OpenPGP key so mail apps can auto-discover it using **WKD/WKS** on `openpgpkey.tilde.club`.

## What you’ll do

1. Create (or reuse) a modern PGP key for your `@tilde.club` address.
2. Submit a publish request (the script does this for you).
3. Confirm the request from **mutt** (one click/command).
4. Verify lookups work.

---

## 1) Create & submit (one command)

The script will:

* generate **ed25519** + **cv25519** (or **nistp256** on FIPS),
* set safe GnuPG options,
* send the WKS request via Postfix’s `sendmail`.

```bash
# if your script lives elsewhere, adjust the path
pgp-setup-and-submit.sh --name "Your Name" --email yourlogin@tilde.club
```

You’ll be prompted for a passphrase. If a key already exists for that email, it will be reused and only the request is sent.

---

## 2) Confirm from mutt

You’ll receive a “confirm your key publication” email.

### Option A — quick pipe (no config)

Open the message in mutt and press `|`, then type:

```bash
gpg-wks-client --read | /usr/sbin/sendmail -t
```
Enter your key’s passphrase if prompted. That’s it.

### Option B — one-time mutt integration (nicer UX)

In mutt: open the email → press `v` (view parts) → select the `application/vnd.gnupg.wks` part → Enter. Done.

---

## 3) Verify publication

After a minute, test WKD discovery:

```bash
gpgconf --kill all
gpg --auto-key-locate clear,wkd --locate-external-keys yourlogin@tilde.club
# or:
curl -s "$(gpg-wks-client --print-wkd-url yourlogin@tilde.club)" | gpg --show-keys
```

You should see your public key.

---

## Troubleshooting

* **“sending mail is not supported in this build”**
  Use the pipe form: `gpg-wks-client --read | /usr/sbin/sendmail -t`.
* **Pinentry/TTY issues (no prompt / permission denied)**
  In your shell:
  `echo allow-loopback-pinentry >> ~/.gnupg/gpg-agent.conf`
  `echo pinentry-mode\ loopback >> ~/.gnupg/gpg.conf`
  `gpgconf --kill gpg-agent; export GPG_TTY=$(tty); gpg-connect-agent updatestartuptty /bye`

That’s it—once confirmed, mail clients can auto-fetch your key from `openpgpkey.tilde.club` with zero copy-paste.
