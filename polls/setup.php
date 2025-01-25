<?php
session_start();

// Include the database setup/connection
require_once 'db.php';

// Initialize variables
$error = '';
$success = '';

// Count how many users already exist in the database
$checkTotal = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();

// If at least one user exists, show a message and no form
if ($checkTotal > 0) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Setup Admin User</title>
        <style>
            body {
                font-family: Arial, sans-serif; 
                margin: 20px;
            }
            .container {
                max-width: 500px; 
                margin: 0 auto;
            }
            .info {
                color: #333;
            }
            a {
                color: blue;
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h2>Admin User Already Exists</h2>
        <p class="info">
            An admin user has already been created. No additional admins can be set up here.
        </p>
        <p>
            Go back to the <a href="index.php">Polls site</a>.
        </p>
    </div>
    </body>
    </html>
    <?php
    exit;
}

// If we are here, no user exists yet, so show the form
if (isset($_POST['setup'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    // Basic validation
    if ($username === '' || $password === '' || $confirmPassword === '') {
        $error = 'All fields are required.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        // Create the first (and only) admin user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertStmt = $db->prepare("
            INSERT INTO users (username, password)
            VALUES (:username, :password)
        ");
        $insertStmt->bindValue(':username', $username, PDO::PARAM_STR);
        $insertStmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $insertStmt->execute();

        $success = "Admin user '$username' created successfully.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Setup Admin User</title>
    <style>
        body {
            font-family: Arial, sans-serif; 
            margin: 20px;
        }
        .container {
            max-width: 500px; 
            margin: 0 auto;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        label {
            display: inline-block; 
            width: 120px;
        }
        input[type=text], 
        input[type=password] {
            width: 250px;
            margin-bottom: 10px;
        }
        button {
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Setup Admin User</h2>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <p>You can now <a href="admin.php">go to the Admin page</a> to log in.</p>
    <?php else: ?>
        <form action="setup.php" method="post">
            <div>
                <label for="username">Admin Username:</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                    required
                />
            </div>

            <div>
                <label for="password">Password:</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required
                />
            </div>

            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input 
                    type="password" 
                    name="confirm_password" 
                    id="confirm_password" 
                    required
                />
            </div>

            <div>
                <button type="submit" name="setup">Save Admin User</button>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
