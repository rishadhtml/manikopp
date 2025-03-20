<?php
session_start();
require_once __DIR__ . "/database.php"; // Ensure correct path

function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

function getUser() {
    global $database;
    if (!isLoggedIn()) return null;
    
    try {
        $stmt = $database->prepare("SELECT id, email FROM users WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database Error (getUser): " . $e->getMessage());
        return null;
    }
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: /login.php"); // Ensure proper path
        exit;
    }
}

function isAdmin() {
    $user = getUser();
    return $user && strtolower($user["email"]) === "shaaxaal@gmail.com"; // Case-insensitive check
}
?>
