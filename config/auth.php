<?php
session_start();
require_once "database.php";

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

// Get logged-in user
function getUser() {
    global $database;
    if (!isLoggedIn()) return null;
    $userId = $_SESSION["user_id"];
    return $database->querySingle("SELECT * FROM users WHERE id = $userId", true);
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

// Check if user is admin
function isAdmin() {
    return getUser()["email"] === getenv("ADMIN_EMAIL");
}
?>
