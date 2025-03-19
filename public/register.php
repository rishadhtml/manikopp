<?php
require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    
    try {
        $database->exec("INSERT INTO users (email, password) VALUES ('$email', '$password')");
        header("Location: login.php");
    } catch (Exception $e) {
        $error = "Email already registered!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit">Register</button>
    </form>
    <a href="login.php">Login</a>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
