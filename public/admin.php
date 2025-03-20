<?php
require_once "../config/auth.php";
requireLogin();

if (!isAdmin()) {
    header("Location: index.php");
    exit;
}

$stmt = $database->query("SELECT users.email, uploads.file_name, uploads.file_path FROM users 
                          LEFT JOIN uploads ON users.id = uploads.user_id");

$uploads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>
        <table border="1">
            <tr>
                <th>User Email</th>
                <th>File Name</th>
                <th>File Path</th>
            </tr>
            <?php foreach ($uploads as $upload): ?>
                <tr>
                    <td><?= htmlspecialchars($upload["email"]) ?></td>
                    <td><?= htmlspecialchars($upload["file_name"]) ?></td>
                    <td><a href="<?= htmlspecialchars($upload["file_path"]) ?>" target="_blank">Download</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
