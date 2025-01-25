<?php
session_start();
require_once 'db.php'; // Ensures $db is available and the database is set up

// Array to store poll IDs that the user has voted on in this session
if (!isset($_SESSION['voted_polls'])) {
    $_SESSION['voted_polls'] = [];
}

// Helper function: Fetch poll details by ID
function getPollById($db, $pollId) {
    $stmt = $db->prepare("SELECT * FROM poll_questions WHERE id = :id LIMIT 1");
    $stmt->bindValue(':id', $pollId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Helper function: Fetch poll options (and their results) by poll ID
function getPollOptions($db, $pollId) {
    $stmt = $db->prepare("
        SELECT
            po.id AS option_id,
            po.option_text,
            IFNULL(pr.vote_count, 0) AS vote_count
        FROM poll_options po
        LEFT JOIN poll_results pr ON po.id = pr.option_id
        WHERE po.question_id = :question_id
        ORDER BY po.id ASC
    ");
    $stmt->bindValue(':question_id', $pollId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// If a vote is being cast
if (isset($_POST['vote']) && isset($_POST['option_id']) && isset($_POST['poll_id'])) {
    $pollId = (int)$_POST['poll_id'];
    $optionId = (int)$_POST['option_id'];

    // Ensure this user hasn't already voted on this poll in this session
    if (!in_array($pollId, $_SESSION['voted_polls'], true)) {
        // Update the vote count
        $updateStmt = $db->prepare("
            UPDATE poll_results
            SET vote_count = vote_count + 1
            WHERE question_id = :question_id
              AND option_id = :option_id
        ");
        $updateStmt->bindValue(':question_id', $pollId, PDO::PARAM_INT);
        $updateStmt->bindValue(':option_id', $optionId, PDO::PARAM_INT);
        $updateStmt->execute();

        // Mark the user as having voted
        $_SESSION['voted_polls'][] = $pollId;
    }

    // Redirect back to the same poll to show results
    header("Location: index.php?poll_id=" . $pollId);
    exit;
}

// Check if a specific poll is requested
$pollId = isset($_GET['poll_id']) ? (int)$_GET['poll_id'] : null;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Poll Application</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .poll-list, .poll-detail {
            max-width: 600px; 
            margin: 0 auto;
        }
        h2, h3 { margin-bottom: 10px; }
        .poll-item { 
            margin-bottom: 15px; 
            padding: 10px; 
            border: 1px solid #ccc;
        }
        .poll-options ul { list-style-type: none; padding: 0; }
        .poll-options li { margin-bottom: 8px; }
        .vote-button { margin-top: 10px; }
        .results { margin-top: 10px; }
        .results li { margin-bottom: 5px; }
        .back-link { margin-top: 20px; display: inline-block; }
    </style>
</head>
<body>

<?php
// If no poll_id given, show all polls
if ($pollId === null) {
    ?>
    <div class="poll-list">
        <h2>Available Polls</h2>
        <?php
        // Fetch all polls
        $allPollsStmt = $db->query("SELECT id, question_text, created_at FROM poll_questions ORDER BY id DESC");
        $allPolls = $allPollsStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($allPolls) {
            foreach ($allPolls as $poll) {
                ?>
                <div class="poll-item">
                    <strong>Question:</strong> <?php echo htmlspecialchars($poll['question_text']); ?><br>
                    <em>Created at: <?php echo htmlspecialchars($poll['created_at']); ?></em><br>
                    <a href="index.php?poll_id=<?php echo $poll['id']; ?>">View Poll</a>
                </div>
                <?php
            }
        } else {
            ?>
            <p>No polls available.</p>
            <?php
        }
        ?>
    </div>
    <?php
} else {
    // Display a single poll
    $poll = getPollById($db, $pollId);

    ?>
    <div class="poll-detail">
        <?php
        if (!$poll) {
            echo "<p>Poll not found.</p>";
        } else {
            $options = getPollOptions($db, $pollId);
            $hasVoted = in_array($pollId, $_SESSION['voted_polls'], true);
            ?>
            <h2><?php echo htmlspecialchars($poll['question_text']); ?></h2>

            <?php
            // If not voted yet, show the vote form
            if (!$hasVoted) {
                if (!empty($options)) {
                    ?>
                    <form method="post" action="index.php">
                        <div class="poll-options">
                            <ul>
                                <?php foreach ($options as $option) { ?>
                                    <li>
                                        <label>
                                            <input type="radio" name="option_id" 
                                                   value="<?php echo $option['option_id']; ?>" 
                                                   required>
                                            <?php echo htmlspecialchars($option['option_text']); ?>
                                        </label>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <input type="hidden" name="poll_id" value="<?php echo $poll['id']; ?>">
                        <button type="submit" name="vote" class="vote-button">Vote</button>
                    </form>
                    <?php
                } else {
                    echo "<p>No options available for this poll.</p>";
                }
            } else {
                // Show the results if user has already voted
                ?>
                <h3>Results</h3>
                <div class="results">
                    <ul>
                        <?php
                        $totalVotes = 0;
                        foreach ($options as $opt) {
                            $totalVotes += $opt['vote_count'];
                        }

                        foreach ($options as $opt) {
                            $voteCount = (int) $opt['vote_count'];
                            $percentage = ($totalVotes > 0) ? ($voteCount / $totalVotes) * 100 : 0;
                            ?>
                            <li>
                                <?php echo htmlspecialchars($opt['option_text']); ?>:
                                <?php echo $voteCount; ?> votes
                                (<?php echo round($percentage, 1); ?>%)
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <p>Total votes: <?php echo $totalVotes; ?></p>
                </div>
                <?php
            }
        }
        ?>
        <a href="index.php" class="back-link">Back to Poll List</a>
    </div>
    <?php
}
?>

</body>
</html>
