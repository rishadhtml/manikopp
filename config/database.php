<?php
$database = new SQLite3(__DIR__ . '/../database.sqlite');
$database->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT UNIQUE, password TEXT)");
$database->exec("CREATE TABLE IF NOT EXISTS uploads (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, file_name TEXT, file_path TEXT, uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
?>
