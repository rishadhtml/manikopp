<?php
require_once __DIR__ . "/vendor/autoload.php"; // Load .env variables

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV["DB_HOST"];
$port = $_ENV["DB_PORT"];
$dbname = $_ENV["DB_DATABASE"];
$user = $_ENV["DB_USERNAME"];
$password = $_ENV["DB_PASSWORD"];
$sslmode = $_ENV["DB_SSLMODE"] ?? "require"; // Default to "require"

try {
    // Use the environment variables for database connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$sslmode";
    $database = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Ensure tables exist
    $database->exec("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY, 
            email TEXT UNIQUE NOT NULL, 
            password TEXT NOT NULL
        )
    ");

    $database->exec("
        CREATE TABLE IF NOT EXISTS uploads (
            id SERIAL PRIMARY KEY, 
            user_id INTEGER NOT NULL, 
            file_name TEXT NOT NULL, 
            file_path TEXT NOT NULL, 
            uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )
    ");

} catch (PDOException $e) {
    // Log the full error message
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed: " . $e->getMessage());
}
?>
