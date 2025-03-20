<?php
$host = "dpg-cvdfsm9c1ekc73e16vf0-a";
$port = "5432";
$dbname = "hostphpj";
$user = "hostphpj_user";
$password = "uHKT0Wu3zAF5njvOmbKegc4g4BDPUEE1";

try {
    $database = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create `users` table
    $database->exec("CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY, 
        email TEXT UNIQUE NOT NULL, 
        password TEXT NOT NULL
    )");

    // Create `uploads` table
    $database->exec("CREATE TABLE IF NOT EXISTS uploads (
        id SERIAL PRIMARY KEY, 
        user_id INTEGER NOT NULL, 
        file_name TEXT NOT NULL, 
        file_path TEXT NOT NULL, 
        uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
