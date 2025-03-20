<?php
require_once "../config/database.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT);

    $stmt = $database->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $stmt->bindValue(":email", $email, SQLITE3_TEXT);
    $stmt->bindValue(":password", $password, SQLITE3_TEXT);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Registration failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #00ff00;
            background: black;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #CD7F32;
            border-radius: 10px;
            box-shadow: 0 0 20px #CD7F32;
        }
        h1 { color: #CD7F32; }
        input, button {
            display: block;
            width: 80%;
            margin: 10px auto;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
        }
        input { background: #222; color: #fff; border: 1px solid #CD7F32; }
        button {
            background: #CD7F32;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Register</button>
        </form>
        <a href="login.php">Already have an account? Login</a>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>
</html>

