---
title: Editing your tilde.club site with WinSCP
author: vincenz00
category: tutorial
---

![](https://user-images.githubusercontent.com/57832/132138979-3c05c6fa-f0fd-4332-9c55-8a00260effb0.PNG)

## Stuff you'll need:-

1. tilde.club sign up confirmation email
1. WinSCP ([download](https://winscp.net/eng/index.php))
1. Public and private keys you used for signing up to tilde.club
1. Decent knowledge in HTML(why are you even here otherwise?)

## Steps to follow:-

1. Hopefully by now you've got your sign up confirmation by email and are
   looking forward to creating your own page, keep the password provided in
   the back of your head, it comes into play later.
1. Download and install WinSCP
1. Now when you open WinSCP, you'll meet with the login page.
1. Enter the following here:-
   - Host name: tilde.club
   - Username: username you used to sign up to tilde.club
   - Password: the password given in the sign up confirmation email
1. Now the final step before you go ahead and login. Go to
   advanced=>SSH=>Authentication and under authentication parameters, add your
   private key by locating it by using the file browser.
1. Add your public key in the same tab by copying it from the file and
   adding it to the  “Display public key” button.
1. Close that tab and now save your preferences for making logging in
   easier.
1. Login and after logging in you can find your index.html file present
   there.
1. ???
1. profit
