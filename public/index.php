<?php
require_once "../config/auth.php";
requireLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    global $database;
    $user = getUser();
    $fileName = basename($_FILES["file"]["name"]);
    $filePath = "../uploads/" . $fileName;

    // Check for duplicate file
    $existingFile = $database->querySingle("SELECT * FROM uploads WHERE file_name = '$fileName'");
    if ($existingFile) {
        $error = "File already exists!";
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);
        $database->exec("INSERT INTO uploads (user_id, file_name, file_path) VALUES ({$user['id']}, '$fileName', '$filePath')");
        $success = "File uploaded successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload</title>
</head>
<body>
    <h2>Upload File</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
</body>
</html>
