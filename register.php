<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $query = "INSERT INTO users (email) VALUES ('$email')";
    if (mysqli_query($conn, $query)) {
        echo "Registered successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<form method="POST">
    <input type="email" name="email" required placeholder="Enter email">
    <button type="submit">Register</button>
</form>
