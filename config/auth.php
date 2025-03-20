<?php
session_start();
require_once "database.php";

function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

function getUser() {
    global $database;
    if (!isLoggedIn()) return null;
    
    $stmt = $database->prepare("SELECT id, email FROM users WHERE id = :id");
    $stmt->bindParam(":id", $_SESSION["user_id"], PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit;
    }
}

function isAdmin() {
    $user = getUser();
    return $user && $user["email"] === "shaaxaal@gmail.com";
}
?>
