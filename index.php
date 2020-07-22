<?php include "header.php"; ?>

<h1 id="fancyboi">welcome to tilde.club</h1>

<p><a href="/wiki/faq.html">Questions? See the official FAQ.</a></p>

<div class="grid">
    <div class="row">

        <div class="col">
            <h2>UPDATE: March 2020:</h2>
            <p>
            Things at tilde.club are going well, Thank you to all our new and existing users.
            Lets make 2020 a great one for ~club and the wider tildeverse!
            </p>
            <p>so what's new?</p>
            <ul>
                <li>We have reached 1985 users! and many more signing up daily.  Welcome everyone.</li>
                <li>Users can now utilize more to make their pages unique, such as PHP.</li>
                <li>~club now has a Mastodon page you can follow us at <a href="https://tilde.zone/@tildeclub" target="_blank">https://tilde.zone/@tildeclub</a></li>
                <li>Users can now setup Two-Factor Authentication (2FA) to use for SSH logins instead of only public key auth <a href="https://tilde.club/wiki/2fa.html">More Info</a></li>
            </ul>
            <hr>
            <h2>UPDATE: September 2019:</h2>
            <p>
            tilde.club is back!! as of september 20th, we're now accepting
            signups and operating as normal!
            </p>
            <p>
            your new admins are: <a href="/~deepend/">~deepend</a> and
            <a href="/~benharri/">~benharri</a>. if you need anything,
            reach out via email (root AT tilde DOT club) or on <a href="/wiki/irc.html">irc</a>.
            </p>
            <p>so what's new?</p>
            <ul>
                <li>~club is joining the <a href="https://tildeverse.org">
                        tildeverse</a>, a collective of like-minded tilde communities with a <a href="https://tilde.chat">shared irc network</a></li>
                <li>we now have a <a href="https://lists.tildeverse.org/postorius/lists/tildeclub.lists.tildeverse.org/">mailing list</a> and a full-fledged <a href="/wiki/email.html">mailserver</a>. new users are automatically subscribed to the list with their @tilde.club address.</li>
                <li>we're on a new vm with more ram and disk space to grow. check the expected ssh hostkey at the top of the page.</li>
                <li>to keep up with updates, stop by irc (via <a href="https://web.tilde.chat/?join=club">webchat</a> or at your shell by running "chat"), check the mailing list, or follow our projects on our <a href="https://github.com/tildeclub">github org</a></li>
                <li>most of the info from previous wiki iterations are now consolidated on our new <a href="/wiki/">wiki</a></li>
                <li>we have a new donation page set up on <a href="https://liberapay.com/tilde.club">liberapay</a></li>
            </ul>

        </div>

        <div class="col">
            <p>
            tilde.club is not a social network it is one tiny totally
            standard unix computer that people respectfully use together
            in their shared quest to build awesome web pages
            </p>

            <p>
            If you would like a list of <a href="http://tilde.club/tilde.24h.php">
                RECENTLY CHANGED PAGES</a> you can see that too
            </p>

            <hr>
            <h2>tilde.club gold star supporters</h2>
            <p>Tilde.Club is supported by a global community of
            good people. We don't rank people by the amount
            they give, only by the fact that they gave.
            Here's who has donated! When you're on the
            server, THANK THEM.</p>
            <ul>
                <li>7/15/2020 | <a href="/~necrotechno">~necrotechno</a></li>
                <li>7/10/2020 | <a href="/~snowdusk">~snowdusk</a></li>
                <li>5/31/2020 | <a href="/~melyanna">~melyanna</a></li>
                <li>4/21/2020 | <a href="/~cano">~cano</a></li>
                <li>11/9/2019 | <a href="/~sneak">~sneak</a></li>
                <li>10/5/2014 | <a href="/~beau">~beau</a></li>
                <li>10/5/2014 | <a href="/~skk">~skk</a></li>
                <li>10/5/2014 | <a href="/~joeld">~joeld</a></li>
                <li>10/5/2014 | <a href="/~john">~john</a></li>
                <li>10/5/2014 | <a href="/~brendn">~brendn</a></li>
                <li>10/5/2014 | <a href="/~droob">~droob</a></li>
                <li>10/5/2014 | <a href="/~delfuego">~delfuego</a></li>
                <li>10/5/2014 | <a href="/~jonathan">~jonathan</a></li>
                <li>10/5/2014 | <a href="/~coldmode">~coldmode</a></li>
                <li>10/5/2014 | <a href="/~jemal">~jemal</a></li>
                <li>10/5/2014 | <a href="/~jonbell">~jonbell</a></li>
                <li>10/5/2014 | <a href="/~_">~_</a></li>
                <li>10/5/2014 | <a href="/~dvd">~dvd</a></li>
                <li>10/5/2014 | <a href="/~whitneymcn">~whitneymcn</a></li>
                <li>10/5/2014 | <a href="/~jimray">~jimray</a></li>
                <li>10/5/2014 | <a href="/~schussat">~schussat</a></li>
                <li>10/5/2014 | <a href="/~macdiva">~macdiva</a></li>
                <li>10/3/2014 | <a href="/~extraface">~extraface</a></li>
                <li>10/3/2014 | <a href="/~joshuag">~joshuag</a></li>
                <li>10/3/2014 | <a href="/~zarate">~zarate</a></li>
                <li>10/3/2014 | <a href="/~englishm">~englishm</a></li>
                <li>10/3/2014 | <a href="/~danbri">~danbri</a></li>
            </ul>


        </div>

    </div>

    <div class="col">

        <h3>here are the home pages of our users</h3>
        <p>this list does not include people who haven't changed their page yet</p>
        <p>if you're not seeing yourself listed here, change your page from the default.</p>
        <p><a href="/users/">list all users</a></p>
        <ul class="user-list">
            <?php
            // these are the hashes of previous and current default pages
            $page_shas = [
                "0eb53dab435e2e6e401921146bed85a80e9ad3a1",
                "61eff8202777bae134ac4b11f1e16ec23dfc97d3",
                "e9d41eab6edb7cd375c63ecb4a23bca928992547",
                "cb2ce535ab34edebc225e88a321f972ba55763c3",
                "13af6898f536265af7dbbe2935b591f5e2ee0d7d",
                "b51a889545b5f065fd1ac2b8760cab0088a9dc22"
            ];
            foreach (glob("/home/*") as $user) {
                $index = "$user/public_html/index.html";
                if (!file_exists($index) || in_array(sha1_file($index), $page_shas)) continue;
                $user = basename($user); ?>
                <li><a href="/~<?=$user?>/">~<?=$user?></a></li>
            <?php } ?>
        </ul>

    </div>


</div>

<?php include "footer.php"; ?>
