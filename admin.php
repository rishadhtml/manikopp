<?php
session_start();
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM users");
?>
<h2>Admin Panel</h2>
<table border="1">
    <tr><th>Email</th><th>Files</th></tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['email'] ?></td>
            <td><a href="uploads/<?= $row['email'] ?>/">View Files</a></td>
        </tr>
    <?php endwhile; ?>
</table>
