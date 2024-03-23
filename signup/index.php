<?php
$title = "sign up for the tilde.club!";
include __DIR__."/../header.php";

function esc($v) {
    return isset($_REQUEST[$v]) ? htmlspecialchars($_REQUEST[$v]) : "";
}

function isGmail($email) {
    return substr(strrchr($email, "@"), 1) === 'gmail.com';
}

$gmailError = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isGmail($_REQUEST['email'])) {
        $gmailError = true;
    } else {
        // Process the form here only if the email is not a Gmail address
        include 'signup-handler.php';
    }
}
?>
            <?php if ($gmailError): ?>
                <div class="alert alert-warning">
                    <strong>We don't accept Gmail addresses due to Google not allowing emails to go through due to a recent spam issue.</>                </div>
            <?php endif; ?>

<h1 id="fancyboi">sign up to join tilde.club</h1>

<div class="grid">
    <div class="row">
        <div class="col">


                    <p>Sorry Signups are currently closed.  Come back soon!</p>

		</td>
	</tr>
</table>

	</div>
</div>

<?php include __DIR__."/../footer.php";
