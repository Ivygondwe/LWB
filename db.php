<?php
$host = 'localhost';      // MySQL server (usually 'localhost' in XAMPP)
$db   = 'lwb_accounts';   // Your database name
$user = 'root';           // Default XAMPP username
$pass = '';               // Default XAMPP password (empty)
$charset = 'utf8mb4';     // Character encoding

// Set up the database connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If connection fails, show error message
    die("Database connection failed: " . $e->getMessage());
}
?>