<?php
require_once "database.php";
require_once "auth.php";

$user = isLoggedIn() ? getUser() : null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $fileName = basename($_FILES["file"]["name"]);
    $filePath = "uploads/" . $fileName;

    $stmt = $database->prepare("SELECT * FROM uploads WHERE file_name = :file_name AND user_id = :user_id");
    $stmt->bindParam(":file_name", $fileName);
    $stmt->bindParam(":user_id", $user["id"]);
    $stmt->execute();

    if ($stmt->fetch()) {
        $uploadError = "❌ File already exists!";
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);
        $stmt = $database->prepare("INSERT INTO uploads (user_id, file_name, file_path) VALUES (:user_id, :file_name, :file_path)");
        $stmt->bindParam(":user_id", $user["id"]);
        $stmt->bindParam(":file_name", $fileName);
        $stmt->bindParam(":file_path", $filePath);
        $stmt->execute();

        $uploadSuccess = true;
    }
}

$files = [];
if ($user) {
    $stmt = $database->prepare("SELECT * FROM uploads WHERE user_id = :user_id");
    $stmt->bindParam(":user_id", $user["id"]);
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Hosting</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>PHP Hosting</h1>
        <?php if ($user): ?>
            <p>Welcome, <?= htmlspecialchars($user["email"]) ?></p>
            <a href="logout.php">Logout</a>
            <a href="admin.php">Admin Panel</a>
            <button id="myFilesBtn">My Files</button>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Select File:</label>
            <input type="file" name="file" required><br>
            <button type="submit">UPLOAD</button>
        </form>

        <?php if (isset($uploadSuccess) && $uploadSuccess): ?>
            <p class="info">✅ File Uploaded!</p>
        <?php elseif (isset($uploadError)): ?>
            <p class="info" style="color: red;"><?= $uploadError ?></p>
        <?php endif; ?>

        <div id="myFilesModal" style="display:none;">
            <h2>My Files</h2>
            <ul>
                <?php foreach ($files as $file): ?>
                    <li>
                        <a href="<?= htmlspecialchars($file["file_path"]) ?>" target="_blank"><?= htmlspecialchars($file["file_name"]) ?></a>
                        <button class="deleteBtn" data-id="<?= $file["id"] ?>">❌</button>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        document.getElementById("myFilesBtn")?.addEventListener("click", function() {
            document.getElementById("myFilesModal").style.display = "block";
        });

        function closeModal() {
            document.getElementById("myFilesModal").style.display = "none";
        }

        document.querySelectorAll(".deleteBtn").forEach(button => {
            button.addEventListener("click", function() {
                if (confirm("Are you sure you want to delete this file?")) {
                    fetch("delete_file.php", {
                        method: "POST",
                        body: JSON.stringify({ id: this.dataset.id }),
                        headers: { "Content-Type": "application/json" }
                    }).then(() => location.reload());
                }
            });
        });
    </script>
</body>
</html>
