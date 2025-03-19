<?php
require_once "../config/auth.php";
requireLogin();
if (!isAdmin()) {
    die("Access Denied");
}

$users = $database->query("SELECT * FROM users");
$uploads = $database->query("SELECT * FROM uploads");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel</h2>
    <h3>Users</h3>
    <ul>
        <?php while ($user = $users->fetchArray()) { echo "<li>{$user['email']}</li>"; } ?>
    </ul>
    
    <h3>Uploaded Files</h3>
    <ul>
        <?php while ($file = $uploads->fetchArray()) { echo "<li>{$file['file_name']} - Uploaded by User ID: {$file['user_id']}</li>"; } ?>
    </ul>
</body>
</html>
