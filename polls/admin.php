<?php
session_start();
require_once 'db.php';  // Ensure the database and $db PDO instance are available

// ------------------------------
// Utility Function: Check if admin is logged in
// ------------------------------
function isAdminLoggedIn()
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// ------------------------------
// Handle Admin Login
// ------------------------------
if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare a query to fetch the user
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = "Invalid credentials. Please try again.";
    }
}

// ------------------------------
// Handle Admin Logout
// ------------------------------
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// ------------------------------
// Handle Creating a New Poll
// ------------------------------
if (isset($_POST['create_poll']) && isAdminLoggedIn()) {
    $questionText = trim($_POST['question_text'] ?? '');

    if (!empty($questionText)) {
        $stmt = $db->prepare("INSERT INTO poll_questions (question_text) VALUES (:question_text)");
        $stmt->bindValue(':question_text', $questionText, PDO::PARAM_STR);
        $stmt->execute();
        $successMsg = "Poll question created successfully!";
    } else {
        $errorMsg = "Please enter a question text.";
    }
}

// ------------------------------
// Handle Adding Options to an Existing Poll
// ------------------------------
if (isset($_POST['add_option']) && isAdminLoggedIn()) {
    $questionId = (int)($_POST['poll_id'] ?? 0);
    $optionText = trim($_POST['option_text'] ?? '');

    if ($questionId > 0 && !empty($optionText)) {
        // Check if poll question exists
        $stmt = $db->prepare("SELECT id FROM poll_questions WHERE id = :id");
        $stmt->bindValue(':id', $questionId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetchColumn()) {
            // Insert the new option
            $insertOption = $db->prepare("
                INSERT INTO poll_options (question_id, option_text)
                VALUES (:question_id, :option_text)
            ");
            $insertOption->bindValue(':question_id', $questionId, PDO::PARAM_INT);
            $insertOption->bindValue(':option_text', $optionText, PDO::PARAM_STR);
            $insertOption->execute();

            // Also initialize poll_results with a 0 vote count for the new option
            $optionId = $db->lastInsertId();
            $insertResult = $db->prepare("
                INSERT INTO poll_results (question_id, option_id, vote_count)
                VALUES (:question_id, :option_id, 0)
            ");
            $insertResult->bindValue(':question_id', $questionId, PDO::PARAM_INT);
            $insertResult->bindValue(':option_id', $optionId, PDO::PARAM_INT);
            $insertResult->execute();

            $successMsg = "Option added successfully!";
        } else {
            $errorMsg = "Poll question does not exist.";
        }
    } else {
        $errorMsg = "Please select a poll and enter an option text.";
    }
}

// ------------------------------
// Handle Editing an Existing Poll
// ------------------------------
if (isset($_POST['edit_poll']) && isAdminLoggedIn()) {
    $pollId = (int)($_POST['poll_id'] ?? 0);
    $newQuestionText = trim($_POST['edit_question_text'] ?? '');

    if ($pollId > 0 && !empty($newQuestionText)) {
        // Check if poll question exists
        $checkStmt = $db->prepare("SELECT id FROM poll_questions WHERE id = :id");
        $checkStmt->bindValue(':id', $pollId, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn()) {
            // Update the poll question
            $updateStmt = $db->prepare("
                UPDATE poll_questions
                SET question_text = :question_text
                WHERE id = :id
            ");
            $updateStmt->bindValue(':question_text', $newQuestionText, PDO::PARAM_STR);
            $updateStmt->bindValue(':id', $pollId, PDO::PARAM_INT);
            $updateStmt->execute();

            $successMsg = "Poll question updated successfully!";
        } else {
            $errorMsg = "Poll question does not exist.";
        }
    } else {
        $errorMsg = "Invalid poll ID or question text.";
    }
}

// ------------------------------
// Handle Deleting an Existing Poll
// ------------------------------
if (isset($_POST['delete_poll']) && isAdminLoggedIn()) {
    $pollId = (int)($_POST['poll_id'] ?? 0);

    if ($pollId > 0) {
        // Check if poll question exists
        $checkStmt = $db->prepare("SELECT id FROM poll_questions WHERE id = :id");
        $checkStmt->bindValue(':id', $pollId, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn()) {
            // Delete poll_results
            $deleteResults = $db->prepare("DELETE FROM poll_results WHERE question_id = :id");
            $deleteResults->bindValue(':id', $pollId, PDO::PARAM_INT);
            $deleteResults->execute();

            // Delete poll_options
            $deleteOptions = $db->prepare("DELETE FROM poll_options WHERE question_id = :id");
            $deleteOptions->bindValue(':id', $pollId, PDO::PARAM_INT);
            $deleteOptions->execute();

            // Finally, delete the poll question
            $deletePoll = $db->prepare("DELETE FROM poll_questions WHERE id = :id");
            $deletePoll->bindValue(':id', $pollId, PDO::PARAM_INT);
            $deletePoll->execute();

            $successMsg = "Poll deleted successfully!";
        } else {
            $errorMsg = "Poll question does not exist.";
        }
    } else {
        $errorMsg = "Invalid poll ID.";
    }
}

// ------------------------------
// Fetch All Polls for Display
// ------------------------------
$polls = [];
if (isAdminLoggedIn()) {
    $pollsQuery = $db->query("SELECT id, question_text, created_at FROM poll_questions ORDER BY id DESC");
    $polls = $pollsQuery->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Poll Admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .login-box, .admin-content { max-width: 600px; margin: 0 auto; }
        .error { color: red; }
        .success { color: green; }
        h2 { border-bottom: 1px solid #ccc; }
        form { margin-bottom: 20px; }
        label { display: inline-block; width: 100px; }
        input[type=text], input[type=password] { width: 200px; }
        .poll-item { border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; }
        .poll-options { margin-top: 10px; }
        .option-result { margin-left: 20px; }
        .inline-form { display: inline-block; margin-right: 10px; }
    </style>
</head>
<body>

<?php if (!isAdminLoggedIn()): ?>
    <div class="login-box">
        <h2>Admin Login</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="post" action="admin.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required />
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required />
            </div>
            <div>
                <button type="submit" name="login">Login</button>
            </div>
        </form>
    </div>

<?php else: ?>
    <div class="admin-content">
        <h2>Poll Administration</h2>
        <p>
            <a href="admin.php?action=logout">Logout</a>
        </p>

        <!-- Display success or error messages -->
        <?php if (!empty($successMsg)): ?>
            <div class="success"><?php echo htmlspecialchars($successMsg); ?></div>
        <?php endif; ?>
        <?php if (!empty($errorMsg)): ?>
            <div class="error"><?php echo htmlspecialchars($errorMsg); ?></div>
        <?php endif; ?>

        <!-- Section: Create a New Poll -->
        <h3>Create a New Poll</h3>
        <form method="post" action="admin.php">
            <div>
                <label for="question_text">Question:</label>
                <input type="text" name="question_text" id="question_text" required>
            </div>
            <div>
                <button type="submit" name="create_poll">Create Poll</button>
            </div>
        </form>

        <!-- Section: Add Options to Existing Poll -->
        <h3>Add Options to a Poll</h3>
        <?php if (count($polls) > 0): ?>
            <form method="post" action="admin.php">
                <div>
                    <label for="poll_id">Select Poll:</label>
                    <select name="poll_id" id="poll_id">
                        <?php foreach ($polls as $poll): ?>
                            <option value="<?php echo $poll['id']; ?>">
                                <?php echo htmlspecialchars($poll['question_text']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="option_text">Option:</label>
                    <input type="text" name="option_text" id="option_text" required>
                </div>
                <div>
                    <button type="submit" name="add_option">Add Option</button>
                </div>
            </form>
        <?php else: ?>
            <p>No polls available. Create a new poll first.</p>
        <?php endif; ?>

        <!-- Section: Existing Polls & Results -->
        <h3>Existing Polls & Results</h3>
        <?php if (count($polls) > 0): ?>
            <?php foreach ($polls as $poll): ?>
                <div class="poll-item">
                    <strong>Question:</strong> 
                    <?php echo htmlspecialchars($poll['question_text']); ?><br>
                    <em>Created at: <?php echo $poll['created_at']; ?></em>

                    <!-- Edit and Delete forms for the poll -->
                    <div style="margin-top: 10px;">
                        <!-- Edit Form (inline) -->
                        <form method="post" class="inline-form">
                            <input type="hidden" name="poll_id" value="<?php echo $poll['id']; ?>">
                            <input type="text" name="edit_question_text" value="<?php echo htmlspecialchars($poll['question_text']); ?>" style="width:250px;">
                            <button type="submit" name="edit_poll">Save</button>
                        </form>

                        <!-- Delete Form (inline) -->
                        <form method="post" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this poll?');">
                            <input type="hidden" name="poll_id" value="<?php echo $poll['id']; ?>">
                            <button type="submit" name="delete_poll">Delete</button>
                        </form>
                    </div>

                    <!-- Display poll options and vote counts -->
                    <?php
                        // Fetch options
                        $optionsStmt = $db->prepare("
                            SELECT po.id as option_id, po.option_text,
                                   pr.vote_count
                            FROM poll_options po
                            LEFT JOIN poll_results pr
                                ON po.id = pr.option_id
                            WHERE po.question_id = :question_id
                            ORDER BY po.id ASC
                        ");
                        $optionsStmt->bindValue(':question_id', $poll['id'], PDO::PARAM_INT);
                        $optionsStmt->execute();
                        $options = $optionsStmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="poll-options">
                        <?php if (!empty($options)): ?>
                            <ul>
                                <?php foreach ($options as $opt): ?>
                                    <li>
                                        <?php echo htmlspecialchars($opt['option_text']); ?> 
                                        <span class="option-result">
                                            (Votes: <?php echo $opt['vote_count']; ?>)
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No options for this poll yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No polls to display.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>
