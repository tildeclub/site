<?php
header('Content-Type: application/json');
require_once 'db.php';

// Quick helper to send JSON responses and exit
function sendJson($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

$action = $_GET['action'] ?? ($_POST['action'] ?? null);

switch ($action) {
    // --------------------------------------------------
    // 1) List all polls (IDs + questions)
    // --------------------------------------------------
    case 'list_polls':
        try {
            $stmt = $db->query("SELECT id, question_text FROM poll_questions ORDER BY id DESC");
            $polls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            sendJson(['success' => true, 'polls' => $polls]);
        } catch (Exception $e) {
            sendJson(['success' => false, 'error' => $e->getMessage()], 500);
        }
        break;

    // --------------------------------------------------
    // 2) Get a single poll (question + options)
    // --------------------------------------------------
    case 'get_poll':
        $pollId = (int)($_GET['poll_id'] ?? 0);
        if ($pollId <= 0) {
            sendJson(['success' => false, 'error' => 'Invalid poll_id'], 400);
        }
        try {
            // Fetch poll question
            $stmt = $db->prepare("SELECT id, question_text FROM poll_questions WHERE id = :id");
            $stmt->execute([':id' => $pollId]);
            $poll = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$poll) {
                sendJson(['success' => false, 'error' => 'Poll not found'], 404);
            }

            // Fetch options
            $optionsStmt = $db->prepare("
                SELECT po.id AS option_id, po.option_text,
                       IFNULL(pr.vote_count, 0) AS vote_count
                FROM poll_options po
                LEFT JOIN poll_results pr ON po.id = pr.option_id
                WHERE po.question_id = :question_id
                ORDER BY po.id ASC
            ");
            $optionsStmt->execute([':question_id' => $pollId]);
            $options = $optionsStmt->fetchAll(PDO::FETCH_ASSOC);

            sendJson([
                'success' => true,
                'poll' => [
                    'id'             => $poll['id'],
                    'question_text'  => $poll['question_text'],
                    'options'        => $options
                ]
            ]);
        } catch (Exception $e) {
            sendJson(['success' => false, 'error' => $e->getMessage()], 500);
        }
        break;

    // --------------------------------------------------
    // 3) Cast a vote
    //    Expects: poll_id, option_id, username
    // --------------------------------------------------
    case 'vote':
        // This can come from POST or GET. We'll assume POST for clarity.
        $pollId    = (int)($_POST['poll_id']    ?? 0);
        $optionId  = (int)($_POST['option_id']  ?? 0);
        $username  = trim($_POST['username']    ?? '');

        if ($pollId <= 0 || $optionId <= 0 || empty($username)) {
            sendJson(['success' => false, 'error' => 'Missing or invalid parameters'], 400);
        }

        // Check if user already voted on this poll
        try {
            // 1) Ensure poll & option exist
            $checkOption = $db->prepare("
                SELECT COUNT(*) 
                FROM poll_options 
                WHERE id = :option_id
                  AND question_id = :poll_id
            ");
            $checkOption->execute([
                ':option_id' => $optionId,
                ':poll_id'   => $pollId
            ]);
            if (!$checkOption->fetchColumn()) {
                sendJson(['success' => false, 'error' => 'Option does not belong to poll or does not exist'], 400);
            }

            // 2) Check if user already voted
            $checkVote = $db->prepare("
                SELECT COUNT(*) 
                FROM user_votes
                WHERE question_id = :poll_id
                  AND user_name = :username
            ");
            $checkVote->execute([
                ':poll_id'  => $pollId,
                ':username' => $username
            ]);
            if ($checkVote->fetchColumn() > 0) {
                // Already voted
                sendJson(['success' => false, 'error' => 'Already voted'], 403);
            }

            // 3) Cast the vote (increment poll_results)
            $updateStmt = $db->prepare("
                UPDATE poll_results
                SET vote_count = vote_count + 1
                WHERE question_id = :poll_id
                  AND option_id   = :option_id
            ");
            $updateStmt->execute([
                ':poll_id'   => $pollId,
                ':option_id' => $optionId
            ]);

            // 4) Record the user vote
            // Ensure user_votes table is created:
            //   CREATE TABLE IF NOT EXISTS user_votes (
            //       id INTEGER PRIMARY KEY AUTOINCREMENT,
            //       question_id INTEGER NOT NULL,
            //       option_id   INTEGER NOT NULL,
            //       user_name   TEXT NOT NULL,
            //       voted_at    DATETIME DEFAULT CURRENT_TIMESTAMP
            //   );
            $insertVote = $db->prepare("
                INSERT INTO user_votes (question_id, option_id, user_name)
                VALUES (:poll_id, :option_id, :username)
            ");
            $insertVote->execute([
                ':poll_id'   => $pollId,
                ':option_id' => $optionId,
                ':username'  => $username
            ]);

            sendJson(['success' => true, 'message' => 'Vote cast successfully']);
        } catch (Exception $e) {
            sendJson(['success' => false, 'error' => $e->getMessage()], 500);
        }
        break;

    // --------------------------------------------------
    // 4) Unknown / default
    // --------------------------------------------------
    default:
        sendJson(['success' => false, 'error' => 'Unknown action'], 400);
        break;
}
