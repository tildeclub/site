<?php include "header.php"; ?>

<h1 id="fancyboi">welcome to tilde.club</h1>

<p><a href="/wiki/faq.html">Questions? See the official FAQ.</a></p>

	<p class="advisory">GMAIL USERS: We no longer accept gmail.com addresses for signups since you would not receive your account information email.</p>
<div class="grid">
    <div class="row">

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
            <p>
                Or Check out the <a href="https://tilde.club/~tweska/gallery" target="blank">tilde.club gallery</a> created by <a href="/~tweska" target="_blank">~tweska</a>
            </p>

            <hr>
            <h2>tilde.club gold star supporters</h2>
            <p>Tilde.Club is supported by a global community of
            good people. We don't rank people by the amount
            they give, only by the fact that they gave.
            Here's who has donated! When you're on the
            server, THANK THEM.</p>
            <ul>
                <?php
                $supporters = json_decode(file_get_contents('supporters.json'), true);
                foreach ($supporters as $supporter) {
                    echo '<li>' . htmlspecialchars($supporter['date']) . ' | <a href="' . htmlspecialchars($supporter['url']) . '">' . htmlspecialchars($supporter['name']) . '</a></li>';
                }
                ?>
            </ul>

        </div>

<div class="col">
    <?php if (new DateTime() >= new DateTime('2024-09-30')): ?>
        <h2>UPDATE: September 2024:</h2>
        <h3>Happy 10th Birthday, Tilde.Club!</h3>
        <p>
        Tilde.Club turned 10! This cozy corner of the internet has become a haven for creativity and community. Members have crafted quirky personal pages, shared knowledge through the wiki, and supported each other in countless projects. It's a space where everyone's unique contributions shine, making it truly special. Here's to a decade of fun and friendship, and many more to come!
        </p>
        <hr>
    <?php endif; ?>
    <h2>UPDATE: August 2024:</h2>
    <h3>Hey Everyone, Disk Quotas are Here!</h3>
    <p>
        Just a heads up: we've rolled out disk quotas to keep things running smoothly for everyone. This will help us share space fairly and make sure the system stays in good shape.
    </p>
    <p>
        Here's the scoop:
        <ul>
            <li><strong>Soft Limit:</strong> 1 GB – You’ll get a nudge if you go over this, but no worries, you can still go up to the hard limit.</li>
            <li><strong>Hard Limit:</strong> 3 GB – This is the max. Once you hit this, you won’t be able to save more files until you clean up.</li>
            <li><strong>Grace Period:</strong> 1 week – If you go over the soft limit, you’ll have a week to get back under before things get strict.</li>
        </ul>
    </p>
    <p>
        You can check your usage and see how much space you’ve got left by running the <code>resources-used</code> script in your home directory. It’s easy!
    </p>
    <hr>
    <h2>UPDATE: March 2024:</h2>
    <h3>Hey everyone, we've leveled up to Fedora 39!</h3>
    <p>
    Big shoutout to all of you who've been part of this journey with tilde.club. Your contributions, big and small, have really made a difference. We couldn't keep this going without all of you.
    Fedora 39 is here, and it's packed with cool updates and features. Just a heads-up for those of you working with PHP, there's been an update, so you might want to check your scripts to make sure everything's still running smoothly.
    </p>
    <p>
    Looking forward, 2024 is shaping up to be an exciting year, and we're just getting started. We're all about fostering a community that's innovative, supportive, and fun. Together, we're not just keeping tilde.club alive; we're making it thrive.
    Thanks again to every single one of you. Your creativity, support, and collaboration are what make this community special. Here's to more adventures and achievements together in 2024 and beyond!
    </p>
    <hr>
    <h2>UPDATE: September 2022:</h2>
    <h3>OS Upgrade to Fedora 36</h3>
    <p>
        Fedora 36 has been installed and things should be back to normal.
        <strong>**NOTE** SSH client requires SHA2 support since SHA1 support is now disabled.</strong>
    </p>
    <hr>
    <h2>UPDATE: November 2021:</h2>
    <h3>OS Upgrade to Fedora 35</h3>
    <p>
        We have upgraded our OS to Fedora 35. All updates installed without error or any issues.
        If you encounter any issues please let ben or deepend know.
        One notable update that may affect your programs is php is now version 8.  
        Please check your php scripts to ensure they still work.
    </p>
    <p>
        Webmail has also been upgraded as well and we have enabled the ability for our users to use 2-Factor Authentication
        with it.  You can find 2-Factor Authentication inside webmail/settings/security
    </p>
    <hr>
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
                "b0eb2bf442e52b98714456b2f8a6662ba4c1f443",
                "0b4f272852e3391e97f0ebb7b5d734a765958eeb",
                "59e857ec585d6d34ed21e027164b3c3c36a95f0f",
                "9da422e8759799cce29327024fc77b6aa2ace484",
                "e5da596bd5f72aa583839bcefd28e988c9d4fcbe",
                "adc83b19e793491b1c6ea0fd8b46cd9f32e592fc",
                "3f51b25206c137593124a16d8b881079352cd1c4",
                "051b45fb2da9b15c523dfafd2a1dd33cc8b54e87",
                "5a1cf2f88acb15da43f5d18a13fe638d175a44cc",
                "0066d512c24f4ada7ad925fd0856b6b68334a93c",
                "da39a3ee5e6b4b0d3255bfef95601890afd80709",
                "f032fa07b3f4d9c1264a5a9369bff19f231bff45",
                "259969faeba97eb16a675bb66427efd168406c92",
                "75b7ce715379312bcc0b24696b9406e10b97cedc",
                "e28aa091c26528a4084b8fad2a2ddb72bee3db75",
                "12608ff7f6d222d97d2e02c1a13496e1d79713bb",
                "22d29b83dc93b925bee08d090b0ea0fffdeb57f2",
                "4706d8acdd74efd5c6d8f9e69ec215928d9ff165",
                "385212d5ea557a21b77af992ea1b3c1ea71d22c9",
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
