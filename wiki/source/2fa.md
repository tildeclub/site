---
title: USING Two-Factor Authentication (2FA) ON TILDE.CLUB
author: deepend
---

# Using Two-Factor Authentication (2FA).

To get started, run the following command:

   setup-2fa
  
Allow the command to update your Two-Factor Authentication. After running the
command, you’ll be asked a couple of questions, the first one being:
This one you need to answer 'yes'(y).
  
    Do you want authentication tokens to be time-based (y/n)
  
You’ll then be presented with a secret key and multiple “scratch codes”.
We strongly suggest saving these emergency scratch codes in a safe place,
like a password manager. These codes are the only way to regain access if
you lose your phone or lose access to your TOTP app, and each one can
only be used once, so they really are in case of emergency.

You’ll then be prompted with several questions,  The choices are all
about balancing security with ease-of-use. It begins with:

   Do you want me to update your "~/.google_authenticator" file (y/n)

You will need to answer 'yes'(y) for two-factor authentication to work with your login.

Next question we also suggest answering yes to prevent a replay attack:

    Do you want to disallow multiple uses of the same authentication
    token? This restricts you to one login about every 30s, but it
    increases your chances to notice or even prevent
    man-in-the-middle attacks (y/n)

For security reasons we strongly suggest answering 'no'(n) to this next question:  

    By default, tokens are good for 30 seconds and in order to
    compensate for possible time-skew between the client and the server,
    we allow an extra token before and after the current time. If you
    experience problems with poor time synchronization, you can increase
    the window from its default size of 1:30min to about 4min.
    Do you want to do so (y/n)

On the next question we suggest answering 'yes'(y) since rate-limiting
means that a remote attacker can only attempt a certain number of guesses
before being blocked.

    If the computer that you are logging into isn't hardened against
    brute-force login attempts, you can enable rate-limiting for the
    authentication module. By default, this limits attackers to no more
    than 3 login attempts every 30s.

    Do you want to enable rate-limiting (y/n)

Now you're configured. You can now login without an SSH key. Make sure you
know your account password because login using two-factor authentication will
still require your password before letting you in.

# 2FA Mobile Applications

1. [Google Authenticator](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en_CA)

2. [Authy](https://authy.com/)

3. [Microsoft Authenticator](https://www.microsoft.com/en-us/account/authenticator)

4. [FreeOTP Authenticator](https://freeotp.github.io/)

5. [Aegis Authenticator](https://getaegis.app/)

6. [Tofu for IOS](https://www.tofuauth.com/)

More suggestions welcome.
