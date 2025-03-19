<?php
// Connect to SQLite database
$database = new SQLite3(__DIR__ . '/../database.sqlite');

// Enable foreign keys
$database->exec("PRAGMA foreign_keys = ON;");

// Create `users` table
$database->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    email TEXT UNIQUE NOT NULL, 
    password TEXT NOT NULL
)");

// Create `uploads` table with a foreign key reference to `users`
$database->exec("CREATE TABLE IF NOT EXISTS uploads (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    user_id INTEGER NOT NULL, 
    file_name TEXT NOT NULL, 
    file_path TEXT NOT NULL, 
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");
?>
