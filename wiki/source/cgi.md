---
title: "CGI: Making web applications like it's 90s"
category: tutorials
author: xwindows
---

Web programming today is a mess:
gazillion of frameworks and libraries
thrown on top of each other,
runaway complexity so rampant,
while the whole setup teetering closer
to the state of house of cards than ever.
You know it had become so bad
because people have now started shipping you their computers
(a la Docker)
just for you to be able to run their web applications...

Don't you ever hate your middleware for pulling in millions of dependencies?
Feeling so done with juggling between multiple web programming libraries?
Getting tired of seeing your PHP script break
on every single PHP update that arrived?
Looking for alternatives that could shine
even in lowly environments like routers and single board computers?
Would like something more retro and longer-standing for a change?

If so,
**welcome to the olden world of CGI programming!**

Introduction
------------

At the most basic level of web-serving,
when your browser sent a request to the web server,
the server would check for a file residing on that URI path requested;
if exists,
it would give that file's content to your browser,
the end.
The point of CGI is to extend that
with the following idea:
if that path is not pointing to a file,
but rather to an executable program;
instead of serving the program binary to the client,
we run that program,
with request body piped to its standard input,
and pipe its standard output back to the client as a response.
(Lawyers will say this is a sly oversimplification,
but you get an idea)

> By the way,
> CGI stands for <q>Common Gateway Interface</q>.
> Of course,
> a very common question that follows would be
> why is it being called <em>gateway</em>:
> it was because in early 1990s,
> the main use of this kind of server-executed program
> was not web application,
> but for writing glue logic
> to access institution's already-existing in-house infosystem,
> which previously only accessible as command line programs
> run via on-premise terminal
> or over telnet/dial-in shell session.
> 
> Such glue logic programs would accept the request,
> invoke the on-server infosystem programs with correct parameters,
> dress its output a bit
> before sending that result to web browser;
> making them <em>gateways</em>
> to let users from the web
> access those in-house information systems.
> These were in fact,
> the main uses that pushed for the effort
> to standardize web servers
> into using the same _common interface_ for running such _gateway_ programs;
> and that's where the name came from.

Anyway,
by using just standard input/output and some environment variables,
it means you can use **virtually any** compiled **programming language**,
and any shebang-compatible interpreted programming language
for server-side web development.
There would be no complicated protocol you need to grok;
and when you chose your language wisely,
there would be no dependency hell to watch out for,
no API/ABI breakage to rewrite around,
and no upgrade treadmill forced on you.
Life was definitely simpler back in the days;
and by using CGI,
your life could be simple _today_ too.

For these reasons,
while having limited amount of bling and bang to offer,
CGI has been standing through time,
as the lowest common denominator,
programming language-agnostic,
platform-independent scheme for running web applications;
from its first standardization at the dawn of World Wide Web era
nearly 3 decades ago,
to today.
And... did you know that the development of PHP was originally
become possible because of CGI too?

Tilde.club have been supporting CGI programming
on user web space since 17 May 2020.
As CGI was originally conceived
in shared institutional Unix server environment;
on a tilde,
it means we are experiencing it
in its natural habitat.

Hello World!
------------

As simple as it is,
everybody has to start somewhere;
so the following are example <q>Hello World</q> CGI programs
in many programming languages that Tilde.club supports.
All of them produce HTTP response with status code 200,
<q>`text/plain`</q> MIME type,
and simple <q>Hello World</q> text as a response body.
Note that **every example scripts here
all work under <q>`.cgi`</q> file extension**;
other language-specific file extension that work
would be noted in each example.

- Perl
	(also works with <q><samp>.pl</samp></q> file extension):
	
		#!/usr/bin/perl
		print "Status: 200";
		print "Content-Type: text/plain";
		print "";
		print "Hello World!";
	
	Note that Perl was the main language of choice
	back in the heyday of CGI programming.
- Bourne shell script
	(also works with <q><samp>.sh</samp></q> file extension):
	
		#!/bin/sh
		echo "Status: 200"
		echo "Content-Type: text/plain"
		echo
		echo "Hello World!"
- Python
	(usable under both 3.x and 2.x,
	also works with <q><samp>.py</samp></q> file extension):
	
		#!/usr/bin/python
		print("Status: 200")
		print("Content-Type: text/plain")
		print("")
		print("Hello World!")
- AWK:
	
		#!/usr/bin/awk -E
		BEGIN {
			print "Status: 200"
			print "Content-Type: text/plain"
			print
			print "Hello World!"
		}
- Lua
	(also works with <q><samp>.lua</samp></q> extension):
	
		#!/usr/bin/lua
		print("Status: 200")
		print("Content-Type: text/plain")
		print("")
		print("Hello World!")
- Tcl:
	
		#!/usr/bin/tclsh
		puts "Status: 200"
		puts "Content-Type: text/plain"
		puts ""
		puts "Hello World!"
- Common Lisp:
	
		#!/usr/bin/sbcl --script
		(progn
			(princ "Status: 200") (terpri)
			(princ "Content-Type: text/plain") (terpri)
			(terpri)
			(princ "Hello World!") (terpri)
		)

Pick the language you like,
put the script (or executable) in a file anywhere inside your <q>`public_html`</q> subdirectory
of your Tilde.club home directory,
with appropriate file extension;
and also make sure that the thing is **world-readable** _and_ **world-executable**
(something like <q>`chmod o+rx YOURFILE.EXT`</q> would do).
If you use other language that compiles to a binary executable,
just world-executable permission will suffice.

The URL for accessing a CGI program from a web browser
is no different from accessing
regular file hosted on your Tilde.club web space.

Note that there are no assembly,
C,
and C++ example here,
and that is intentional:
you are supposed to already know such languages well already
&mdash;including how to program it _safely_ and _defensively_&mdash;
before even thinking about trying them in this task.

Program Output
--------------

Output of your CGI programs is expected to have two parts:

1. Lines you printed before the first blank line
   will be treated as HTTP response headers fields:
   
   - The only exception is the <q>`Status:`</q> pseudo-header,
     which will not be output as a real response header,
     but its value will be rather used as HTTP status code of the response.
     - When <q>`Status:`</q> pseudo-header is omitted,
       the HTTP status code of your response would be 200.
     - Your program ought **NOT** to output this as a real HTTP response line
       (<q>`HTTP/1.0 200 OK`</q> and suchlike).
       Doing so is off-spec;
       and while some servers handle this okay,
       Tilde.club doesn't.
   - You **MUST** output <q>`Content-Type:`</q> header;
     or else the server would reject your program's output
     and give HTTP 502 error to the client instead.
   - A blank line ends the headers section.
   - You should output headers
     (including the blank line terminating the headers)
     in platform's native line ending,
     which is LF in case of Tilde.club and other GNU/Linux hosts;
     but in practice,
     CR/LF is accepted as well.
   
1. And what you output after the first blank line
   is your response body (i.e. content).
   This part can use any line ending in case of text,
   or it could even be binary;
   as long as it fits
   with the <q>`Content-Type:`</q> header value you had just printed.
   Empty response body is allowed as well;
   by not outputting anything after that first blank line.

Program Input
-------------

Information from HTTP request
arrive at your CGI program in two different channels:

1. Request line,
   request headers,
   misc request information,
   and server information:
   these arrive as environment variables.
1. Request body:
   this arrives verbatim as standard input data.

Unless you are processing HTTP POST or PUT request
(which are quite advanced stuff),
you don't really need to look at request body at all.
So the information of interest are mostly contained
in the environment variables:

- The HTTP request method used
  would be passed to your program as a value of environment variable `REQUEST_METHOD`.
- The part after <q>`?`</q> of request URI
  would be passed to your CGI program
  as the value of environment variable `QUERY_STRING`.
  - This variable will always be present.
    If the request URI had no <q>`?`</q>,
    or there was nothing after <q>`?`</q>;
    the value would be empty.
- Each request headers field's name would be converted to uppercase,
  prepended with <q>`HTTP_`</q>,
  and set as environment variable
  with value equals to the header value received from the client.
  For example,
  <q>`Host: tilde.club`</q> header line
  would be converted to an environment variable `HTTP_HOST`
  with value <q>`tilde.club`</q>.

The following are environment variables from the CGI 1.1 specification
which are set for CGI programs in Tilde.club,
in alphabetical order:

> `CONTENT_LENGTH`,
> `CONTENT_TYPE`,
> `GATEWAY_INTERFACE`,
> `QUERY_STRING`,
> `REMOTE_ADDR`,
> `REMOTE_PORT`,
> `REQUEST_METHOD`,
> `SCRIPT_NAME`,
> `SERVER_NAME`,
> `SERVER_PORT`,
> `SERVER_PROTOCOL`,
> `SERVER_SOFTWARE`

- You can find out more what each of these variables mean
  in the original CGI 1.1 specification,
  linked in the [Further Reading](#further-reading) section below.

And the following are other environment variables
that which are not in CGI 1.1 specification,
but are set for CGI programs in Tilde.club:

> `DOCUMENT_ROOT`,
> `DOCUMENT_URI`,
> `HTTPS`,
> `REDIRECT_STATUS`,
> `REQUEST_SCHEME`,
> `REQUEST_URI`,
> `SCRIPT_FILENAME`,
> `SERVER_ADDR`

**Notes:**

- `REMOTE_HOST` variable is always absent;
  including when the remote host does have a valid reverse-DNS address.
- `REMOTE_IDENT` variable is always absent;
  including when the remote client does connect
  from a host with Identd service.
- While both `HTTPS` and `REQUEST_SCHEME` variables
  could be used for discerning HTTPS from plain old HTTP request;
  checking for `HTTPS` value <q>`on`</q> is to be used
  if you expect your CGI program to be portable to Apache HTTP Server.
  - This can be used for ensuring a correct version of Atom or RSS feed
    got served on a right protocol.

Program Execution
-----------------

These are conditions that your CGI programs would be running in:

- One instance of CGI program would be executed to service one request;
  and that instance would terminate at the end of response.
- Multiple instances of a CGI program could be run at the same time.
- Your CGI program would start after the server
  had read the entire request header from the client
  (but not the request body, if any);
  and only when the request URI matched your CGI program of course.
- Your CGI program would be run inside its directory
  (and not other location like server binary's directory).
- Once your CGI program runs,
  its standard input would be fed with the request body
  (if any).
- If you are going to process request body,
  you ought to do so before producing any output.
  (HTTP is a request-response protocol,
  remember?)
- Everything your program output on standard error stream
  would go into the server's error log.
- CGI program that did not finish running for too long
  will cause the server to return HTTP 504 <q>Gateway Time-out</q> error
  to the client instead of its response.

Tips
----

- Avoid making your CGI program a time hog;
  good CGI programs start quickly and finish quickly.
- Avoid making your CGI program a resource hog;
  just like everything else you do on Tilde.club shell.
- Avoid making your CGI program a security hole.
  For this reason,
  using C or C++ for a non-trivial CGI program are **not** recommended
  unless you actually know your craft.
- Remember:
  it costs Tilde.club 1 program execution
  to service one HTTP request to a CGI program;
  use it responsibly
  and for things that matter.

Setup-Specific Notes
--------------------

Following are tidbits specific
to the CGI setup used in Tilde.club:

- If you would like to make CGI program a directory index,
  name it <q><samp>index.cgi</samp></q>.
  (<q><samp>index.sh</samp></q> works too in case of shell script)
- There is no database daemon of any kind.
  (If you would like to use SQLite,
  see below for a caveat about credential and files)

And some caveats:

- There is no support for <var>PATH_INFO</var> environment variable;
  you can blame Nginx for this one.
  
  This mean you cannot simulate files and directory-like URIs
  (like <q>`/~SOMEONE/category.cgi/automobile/ev`</q>)
  under your CGI program;
  the server will simply return HTTP 404 error for such URIs
  even when <q>`category.cgi`</q> exist and being executable.
- Avoid leaving files with following extensions in your web space
  when you don't intend for them to be run as CGI:
  
  - `.cgi`
  - `.pl`
  - `.sh`
  - `.py`
  - `.lua`
  
  This is because in current setup,
  requests to these files will be forwarded to a CGI handler anyway,
  even when their corresponding executable bit is not set;
  while it would not really run such script,
  it would result in HTTP 502 error being sent to client.
  If you would like to distribute these verbatim as source files,
  you might want to workaround by renaming such files
  to add <q><samp>.txt</samp></q> at the end.
- CGI programs here run under web server's credentials:
  user <q><samp>nginx</samp></q>
  and group <q><samp>nginx</samp></q>
  (user ID <samp>994</samp>,
  group ID <samp>990</samp>);
  tread carefully if you need to make your program read/write
  private files.

Further Reading
---------------

- [Common Gateway Interface version 1.1 specification (RFC 3875)](https://www.rfc-editor.org/rfc/rfc3875.html),
  which is [also available in text version](https://www.rfc-editor.org/rfc/rfc3875.txt).
- [Ten Million Users and Ten Years Later](https://dl.acm.org/doi/10.1145/3472749.3474819),
  a case study of CGI being a secret ingredient
  for developing web application that could stay in-service
  more than a decade.
