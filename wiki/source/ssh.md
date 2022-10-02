---
author: benharri
title: ssh
category: tutorial
---


_or, how to tell other computers to do cool things_

---

> all users are required to use an ssh keypair for login, or will be required
> to proceed with manual account recovery.
> you can also set up [two-factor authentication](2fa.html) to log in without your
> keypair.

## tilde.club details

for example, to connect to tilde.club, you can do:

```
ssh user@tilde.club
mosh user@tilde.club
```

ssh is also available on port 443 using the address `ssh.tilde.club`:

    ssh -p 443 user@ssh.tilde.club

this is useful if you're on a limited public network that blocks non-http
ports.

if you are prompted for a verification code, it's for [2fa](2fa.html).
it will not work if you haven't set it up. be sure you're using the right ssh keypair.

---

## intro

** if you just want to get right to a tutorial you can
[skip over this background info](#how-to-make-an-ssh-key)**

while [tilde.club](https://tilde.club) is accessible on the web and features
lovely web pages written by its users, most interaction with tilde.club takes
place **inside the machine** that runs tilde.club as opposed to via web forms
that have an effect from **outside** tilde.club's computer.

this is what sets tilde.club apart from most other online communities. you
connect directly to another computer from yours alongside other people and then
write your web pages, chat, and play games all via text-based interfaces right
on tilde.club's computer.

prior to the web (which debuted in 1995) this is how pretty much all computer
stuff got done. you connected directly to a machine (usually over a direct,
physical phone line) and did your work there.

for a long time, people used a tool called
[`telnet`](https://en.wikipedia.org/wiki/telnet) to connect to other computers.
these days we use a tool called **ssh**.

`ssh` is a text-based tool that provides a direct connection from your computer
to another. ssh is an acronym that stands for secure shell. the _shell_ part
refers to the fact that it's a text-based tool; we use the word shell to refer
to a text-based interface that you give commands to. the _secure_ part refers
to the fact that, when you're using ssh, no one can spy on your connection to
another computer (unlike the old `telnet` command).

**why bother with all of this?** passwords are really insecure and hard to manage.
using keys makes life easier for you, fair user (your account is less likely to
be hacked) and for me, your humble sysadmin (less administration than passwords).

---

## how to make an ssh key

SSH supports a handful of types of cryptographic keys. The most used are [RSA](
  <https://en.wikipedia.org/wiki/RSA_(cryptosystem)>) and the more modern [Ed25519](
    https://en.wikipedia.org/wiki/EdDSA#Ed25519).

RSA is the de-facto standard and is supported everywhere (just choose a big
enough key like 4096 bits to be secure). Ed25519 is designed to be faster and
smaller withouth sacrificing security, so is best suited for embedded devices
or machines with low resources. It's supported on tilde (and really on any
modern system) but you may find older systems which do not support it.

Below you'll find instructions to generate either type (or both if you want).

Keep in mind that these instructions leave your private keys unencrypted in
your local hard disk. So keep them private; never share them. A good solution
is to provide a password for them at creation time, but this implies entering
a password any time you used them (impractical) or use something like [ssh-agent](
  https://man.openbsd.org/ssh-agent.1) (a bit more complex)

pick your fighter: [[mac](#mac)] | [[windows](#windows)] | [[linux](#linux)]

---

### mac

#### generating your keypair

1. open terminal (it's in `/Applications/Utilities`)

2. create your .ssh directory:

```bash
mkdir -m 700 ~/.ssh
```

3. create your keypair:

```bash
ssh-keygen -t ed25519 -a 100
```

4. if you press enter to accept the defaults, your public and private key will
be located at `~/.ssh/id_ed25519.pub` and `~/.ssh/id_ed25519`

`cat ~/.ssh/id_ed25519.pub`

5. copy the output of the last command and paste it in the sshkey field on the
signup form (or email it to [~root](mailto:root@tilde.club) if you already have an account)

#### using your keypair

once an admin approves your signup, you can join the tilde.club

6. open terminal (it's in `/Applications/Utilities`)

7. `ssh` to tilde.club:

```bash
ssh username@tilde.club
```

where username is your username (~benharri would use `ssh benharri@tilde.club`)

8. profit???

---

### windows

#### Ensure OpenSSH is installed

    1. Open Settings, select Apps, then select Optional Features
    1. Scan the list to see if the OpenSSH is already installed. If not, at the top of the page, select Add a feature, then...
    1. Find OpenSSH Client, then select Install

#### generating your keypair

1. open your command prompt (Start -> Search -> type "cmd")

2. create your keypair:

```bash
ssh-keygen -t ed25519 -a 100
```

3. If you press enter to accept the defaults, your public and private key will be located at %USERPROFILE%\.ssh\id_ed25519.pub and %USERPROFILE%\.ssh\id_ed25519 respectively.

Note: %USERPROFILE% is a short code that the computer expands to mean c:\users\your_name\, or whatever the relevant path is to your user's main folder.

Next we will open up the public key so we can copy its contents. 

```bash
notepad %USERPROFILE%\.ssh\id_ed25519.pub
```

4. Copy the text of the pubkey that opens in Notepad and paste it in the sshkey field on the signup form or email it to the relevant sign-up address for the tilde you are joining. 

#### using your keypair

once an admin approves your signup, you can join the tilde.club

5. open command prompt (Start -> Search -> type "cmd")

6. `ssh` to tilde.club:

```bash
ssh username@tilde.club
```

where username is your username (~benharri would use `ssh benharri@tilde.club`)

7. profit???

---

### linux

there are a lot of linux distros, but `ssh` and `ssh-keygen` should be available
in almost all cases. if they're not, look up how to install ssh for your distro.

#### generating your keypair

1. make sure you have a `~/.ssh` directory

```bash
mkdir -m 700 ~/.ssh
```

2. create your keypair

```bash
ssh-keygen -t ed25519 -a 100
```

3. if you press enter to accept the defaults, your public and private key will
be located at `~/.ssh/id_ed25519.pub` and `~/.ssh/id_ed25519`

```bash
cat ~/.ssh/id_ed25519.pub
```

4. copy the output of the last command and paste it in the sshkey field on the 
signup form (or email it to [root@tilde.club](mailto:root@tilde.club) if you already have an account)

#### using your keypair

once an admin approves your signup, you can join the tilde.club

5. open a terminal (this depends on your distro)

6. `ssh` to tilde.club:

where username is your username (~benharri would use `ssh benharri@tilde.club`)

```bash
ssh username@tilde.club
```

Note: If you generated your key to the location above (%USERPROFILE%\ssh\...) then you will be able to SSH to your tilde server without having to specify the location of the key. That folder is the default used by SSH and it will be found automatically. If you generated your keys in a different location or moved them, you will need to specify the full path to the private key.

```bash
ssh -i c:\path\to\my\private\key username@your.tilde
```

7. profit???

---

this tutorial is based on and uses parts of [the tilde.club ssh primer](https://github.com/tildeclub/tilde.club/blob/master/docs/ssh.md) and [the tilde.town ssh guide](https://tilde.town/wiki/getting-started/ssh.html).
