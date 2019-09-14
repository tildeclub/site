<?php include "header.php"; ?>

	<h1>$ welcome to tilde.club</h1>
	<p><a href="/~faq">Questions? See the official FAQ.</a></p>

	<p class="advisory">SERVICE ADVISORY: New Server, New Owners, New lease on life for tilde.club.  Welcome!. The Expected SSH Hostkey is SHA256:duamOATgnGcfRFFkotCwrAWzZtRjwxm64WAhq5tQRwE and will match the SSHFP records in DNS. You can use ssh -o "VerifyHostKeyDNS yes" user@tilde.club to verify that the key matches DNS.</p>

	<table>
		<tr>
			<td>
				<p>
					tilde.club is not a social network it is one tiny totally 
					standard unix computer that people respectfully use together 
					in their shared quest to build awesome web pages
				</p>

				<h2>tilde.club is rebuilding and will be accepting new members soon!</h2>
				<p>
					If you would like a list of <a href="http://tilde.club/~delfuego/tilde.24h.html">
					RECENTLY CHANGED PAGES</a> you can see that too
				</p>

				<h3>here are the home pages of our users</h3>

				<ol>
					<?php foreach (glob("/home/*") as $user) {
						$user = basename($user); ?>
						<li><a href="/~<?=$user?>/">~<?=$user?></a></li>
					<?php } ?>
				</ol>
			</td>

			<td valign="top">
				<h2>tilde.club gold star supporters</h2>

				<p>Tilde.Club is supported by a global community of good people. We
				don't rank people by the amount they give, only by the fact that they
				gave. Here's who has donated! When you're on the server, THANK
				THEM.</p>

				<pre>
				10/5/2014 | <a href="/~beau">~beau</a>
				10/5/2014 | <a href="/~skk">~skk</a>
				10/5/2014 | <a href="/~joeld">~joeld</a>
				10/5/2014 | <a href="/~john">~john</a>
				10/5/2014 | <a href="/~brendn">~brendn</a>
				10/5/2014 | <a href="/~droob">~droob</a>
				10/5/2014 | <a href="/~delfuego">~delfuego</a>
				10/5/2014 | <a href="/~jonathan">~jonathan</a>
				10/5/2014 | <a href="/~coldmode">~coldmode</a>
				10/5/2014 | <a href="/~jemal">~jemal</a>
				10/5/2014 | <a href="/~jonbell">~jonbell</a>
				10/5/2014 | <a href="/~_">~_</a>
				10/5/2014 | <a href="/~dvd">~dvd</a>
				10/5/2014 | <a href="/~whitneymcn">~whitneymcn</a>
				10/5/2014 | <a href="/~jimray">~jimray</a>
				10/5/2014 | <a href="/~schussat">~schussat</a>
				10/5/2014 | <a href="/~macdiva">~macdiva</a>
				10/3/2014 | <a href="/~extraface">~extraface</a>
				10/3/2014 | <a href="/~joshuag">~joshuag</a>
				10/3/2014 | <a href="/~zarate">~zarate</a>
				10/3/2014 | <a href="/~englishm">~englishm</a>
				10/3/2014 | <a href="/~danbri">~danbri</a>
				</pre>
			</td>
		</tr>
	</table>

<?php include "footer.php";
