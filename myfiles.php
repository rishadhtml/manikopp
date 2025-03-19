<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$userDir = 'uploads/' . $_SESSION['user_email'] . '/';
$files = is_dir($userDir) ? scandir($userDir) : [];
?>
<a href="index.php">Back</a>
<h2>My Files</h2>
<ul>
<?php foreach ($files as $file): if ($file !== '.' && $file !== '..'): ?>
    <li>
        <a href="<?= $userDir . $file ?>" download><?= $file ?></a>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="delete_file" value="<?= $file ?>">
            <button type="submit">Delete</button>
        </form>
    </li>
<?php endif; endforeach; ?>
</ul>
<?php
if (isset($_POST['delete_file'])) {
    unlink($userDir . $_POST['delete_file']);
    header("Location: myfiles.php");
}
?>
