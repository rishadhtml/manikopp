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
    
    $userId = intval($_SESSION["user_id"]); // Prevent SQL Injection
    return $database->querySingle("SELECT id, email FROM users WHERE id = $userId", true);
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../public/login.php"); // Ensure correct path
        exit;
    }
}

// Check if user is admin
function isAdmin() {
    $user = getUser();
    return getUser()["email"] == "shaaxaal@gmail.com"; // Ensure user exists before checking
}
?>
