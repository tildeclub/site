<?php
/**
 * db.php
 *
 * This file checks if the SQLite database file 'poll.db' exists.
 * If not, it creates one and sets up the required tables for:
 *   - Users (including an admin user/password)
 *   - Poll questions
 *   - Poll options
 *   - Poll results
 */

$databaseFile = __DIR__ . '../pollsdb/poll.db';

try {
    // If the database file does not exist, create it and set it up
    $dbExists = file_exists($databaseFile);

    // Initialize the PDO connection
    $db = new PDO('sqlite:' . $databaseFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // If the DB didn't exist before, create the required tables
    if (!$dbExists) {
        // Create 'users' table
        $db->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL
            );
        ");

        // Create 'poll_questions' table
        $db->exec("
            CREATE TABLE IF NOT EXISTS poll_questions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                question_text TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");

        // Create 'poll_options' table
        $db->exec("
            CREATE TABLE IF NOT EXISTS poll_options (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                question_id INTEGER NOT NULL,
                option_text TEXT NOT NULL,
                FOREIGN KEY (question_id) REFERENCES poll_questions(id)
            );
        ");

        // Create 'poll_results' table
        $db->exec("
            CREATE TABLE IF NOT EXISTS poll_results (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                question_id INTEGER NOT NULL,
                option_id INTEGER NOT NULL,
                vote_count INTEGER NOT NULL DEFAULT 0,
                FOREIGN KEY (question_id) REFERENCES poll_questions(id),
                FOREIGN KEY (option_id) REFERENCES poll_options(id)
            );
        ");

        // Create a default admin user with a hashed password
        // NOTE: In production, you should not hardcode these credentials.
        //       Instead, store them outside of your code or set them up once.
        $adminUsername = 'admin';
        $adminPlainPassword = 'password'; // Change this in production
        $adminHashedPassword = password_hash($adminPlainPassword, PASSWORD_DEFAULT);

        $insertUser = $db->prepare("
            INSERT INTO users (username, password)
            VALUES (:username, :password)
        ");
        $insertUser->bindValue(':username', $adminUsername, PDO::PARAM_STR);
        $insertUser->bindValue(':password', $adminHashedPassword, PDO::PARAM_STR);
        $insertUser->execute();
    }

    // Optionally, you can return $db or leave it globally accessible
    // for other parts of your application.
    // Example:
    // return $db;
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>
