<?php
require_once "../config/auth.php";
require_once "../config/database.php"; // Ensure database connection is included

requireLogin();

if (!isAdmin()) {
    die("Access Denied");
}

// Fetch users
$users = $database->query("SELECT id, email FROM users");

// Fetch uploaded files
$uploads = $database->query("SELECT file_name, user_id FROM uploads");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { color: #333; }
        ul { list-style-type: none; padding: 0; }
        li { margin: 5px 0; padding: 5px; background: #f4f4f4; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Admin Panel</h2>

    <h3>Users</h3>
    <ul>
        <?php while ($user = $users->fetchArray(SQLITE3_ASSOC)) { ?>
            <li>User ID: <?= htmlspecialchars($user['id']) ?> - <?= htmlspecialchars($user['email']) ?></li>
        <?php } ?>
    </ul>
    
    <h3>Uploaded Files</h3>
    <ul>
        <?php while ($file = $uploads->fetchArray(SQLITE3_ASSOC)) { ?>
            <li><?= htmlspecialchars($file['file_name']) ?> - Uploaded by User ID: <?= htmlspecialchars($file['user_id']) ?></li>
        <?php } ?>
    </ul>
</body>
</html>
