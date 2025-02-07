---
title: Tilde.club Help Desk Guide
category: tilde.club
author: deepend
---

# Tilde.club Help Desk Guide

Welcome! This Help Desk system provides a quick, self-serve way to:

1. **Request or redeem a new SSH key** for your tilde account.  
2. **Reset your account password** (if you've forgotten it).

Below you’ll find step-by-step instructions on how to use the help desk system when you **SSH** into the `help` user. 

---

## Accessing the Help Desk

1. Open a terminal on your local machine.  
2. **SSH** into the **help** account (adjust the hostname to your actual tilde server name):
   ```bash
   ssh help@tilde.club
   ```
3. You’ll see a welcome message and a **main menu** with numbered options.

---

## Main Menu Overview

After logging in, you’ll see three main options:

1. **SSH Key Help**  
2. **Password Help**  
3. **Exit**

Select the option that applies by typing its corresponding number and pressing **Enter**.

---

## 1. SSH Key Help

When you choose **SSH Key Help** at the main menu, you’ll see another menu:

1. **Request a new SSH key**  
2. **Redeem a code** for a new SSH key  
3. **Return** to the previous menu

### 1.1 Request a New SSH Key

1. Pick **“I want to request a new SSH key”** (option 1).  
2. **Enter the email** you registered with your tilde account. The system does a simple check to ensure it’s valid.  
3. If the email matches an existing account, you’ll receive a **“request code”** at that address.  
4. After receiving that code, **log out** or press **Enter** to return to the main menu.

### 1.2 Redeem a New SSH Key

1. Back in the **SSH Key Help** menu, choose **“I have a code from my email and need to redeem it.”**  
2. Paste in the **request code** you received.  
3. The system confirms your username.  
4. When prompted, **paste your new public SSH key** (the part that starts with `ssh-ed25519` or `ssh-rsa` or similar).  
5. The system appends your key to your `~/.ssh/authorized_keys`.  
6. You’ll see a success message, and you can then **log in** to your tilde with that new key.

---

## 2. Password Help

At the main menu, choosing **Password Help** displays:

1. **Request a password reset code**  
2. **Redeem a password reset code**  
3. **Return** to the previous menu

### 2.1 Request a Password Reset Code

1. Choose **“Request a password reset code.”**  
2. **Enter your email** address.  
3. The system sends a **reset code** to your email if the account matches.  
4. Exit or return to the menu once you have the code.

### 2.2 Redeem a Password Reset Code

1. Choose **“Redeem a password reset code.”**  
2. **Paste in** the code from your email.  
3. Enter a **new password** for your tilde account, then **confirm** it.  
4. Upon success, the system updates your account’s password immediately.

---

## 3. Exiting the Help Desk

Simply choose **“I’d like to leave this help desk”** (option 3 in the main menu) or press <kbd>Ctrl</kbd>+<kbd>D</kbd> (end of file) to disconnect.

---

## Tips & Troubleshooting

- **Time Limit**: Each prompt has a 2-minute inactivity timer. If you wait too long, the help desk **exits** automatically. Just log in again to resume.  
- **Email Didn’t Arrive?** Check your spam folder. If you still don’t see it, contact root@tilde.club.  
- **Invalid Email**: If you mistype an email or use an unrecognized domain, you’ll see an error. Double-check your address.  
- **Incorrect Code**: If the code was typed incorrectly or expired, the system will refuse it. Request a new one if needed.  

---
