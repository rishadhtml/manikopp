<?php
session_start();
require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/database.php"; 

requireLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    global $database;
    $user = getUser();
    $fileName = basename($_FILES["file"]["name"]);
    $filePath = "uploads/" . $fileName;

    // Check for duplicate file
    $stmt = $database->prepare("SELECT * FROM uploads WHERE file_name = :file_name AND user_id = :user_id");
    $stmt->execute(["file_name" => $fileName, "user_id" => $user["id"]]);
    $existingFile = $stmt->fetch();

    if ($existingFile) {
        $uploadError = "❌ File already exists!";
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);
        $stmt = $database->prepare("INSERT INTO uploads (user_id, file_name, file_path) VALUES (:user_id, :file_name, :file_path)");
        $stmt->execute(["user_id" => $user["id"], "file_name" => $fileName, "file_path" => $filePath]);
        $uploadSuccess = true;
    }
}

// Handle file deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_file"])) {
    $fileId = $_POST["file_id"];
    $stmt = $database->prepare("SELECT file_path FROM uploads WHERE id = :id AND user_id = :user_id");
    $stmt->execute(["id" => $fileId, "user_id" => getUser()["id"]]);
    $file = $stmt->fetch();

    if ($file) {
        unlink($file["file_path"]); // Delete the file from the server
        $stmt = $database->prepare("DELETE FROM uploads WHERE id = :id");
        $stmt->execute(["id" => $fileId]);
        $deleteSuccess = "✅ File deleted successfully!";
    }
}

// Fetch user files
$stmt = $database->prepare("SELECT * FROM uploads WHERE user_id = :user_id");
$stmt->execute(["user_id" => getUser()["id"]]);
$userFiles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Hosting</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete(fileId) {
            if (confirm("Are you sure you want to delete this file?")) {
                document.getElementById("delete-form-" + fileId).submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Jerry PHP Hosting</h1>

        <form method="POST" enctype="multipart/form-data">
            <label>Select File:</label>
            <input type="file" name="file" required><br>
            <button type="submit">UPLOAD</button>
        </form>

        <?php if (isset($uploadSuccess)): ?>
            <p class="info">✅ File Uploaded Successfully!</p>
        <?php elseif (isset($uploadError)): ?>
            <p class="info" style="color: red;"><?= $uploadError ?></p>
        <?php elseif (isset($deleteSuccess)): ?>
            <p class="info" style="color: green;"><?= $deleteSuccess ?></p>
        <?php endif; ?>

        <h2>My Files</h2>
        <ul>
            <?php foreach ($userFiles as $file): ?>
                <li>
                    <a href="<?= $file['file_path'] ?>" target="_blank"><?= $file['file_name'] ?></a>
                    <form id="delete-form-<?= $file['id'] ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="file_id" value="<?= $file['id'] ?>">
                        <button type="button" onclick="confirmDelete(<?= $file['id'] ?>)">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        <a class="join-now" href="https://t.me/jerryfromrussian" target="_blank">Join our Channel</a>
    </div>
</body>
</html>
