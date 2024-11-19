<?php
// Database configuration
$host = 'localhost';       // Hostname for the database server
$dbname = 'ngo_system';    // Name of the database
$username = 'root';        // Database username
$password = '';            // Database password

try {
    // create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // set error mode 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // handle connection error
    die("Database connection failed: " . $e->getMessage());
}
?>
