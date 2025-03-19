<?php
session_start();
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['user_email'] = $email;
        header("Location: index.php");
    } else {
        $error = "Invalid email";
    }
}
?>
<form method="POST">
    <input type="email" name="email" required placeholder="Enter email">
    <button type="submit">Login</button>
</form>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
