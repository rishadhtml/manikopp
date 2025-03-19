<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$uploadDir = 'uploads/' . $_SESSION['user_email'] . '/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_POST['upload'])) {
    $fileName = basename($_FILES['uploaded_file']['name']);
    $targetFilePath = $uploadDir . $fileName;

    if (file_exists($targetFilePath)) {
        $uploadError = "File already exists. Please rename and try again.";
    } else {
        if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $targetFilePath)) {
            $uploadSuccess = true;
        } else {
            $uploadError = "Upload failed. Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>File Upload</title>
</head>
<body>
    <a href="logout.php">Logout</a> | <a href="myfiles.php">My Files</a>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="uploaded_file" required>
        <button type="submit" name="upload">Upload</button>
    </form>
    <?php if (isset($uploadSuccess)): ?>
        <p>File uploaded successfully!</p>
    <?php elseif (isset($uploadError)): ?>
        <p style="color:red;"><?= $uploadError ?></p>
    <?php endif; ?>
</body>
</html>
