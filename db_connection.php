<?php
// Database connection parameters
$host = 'roundhouse.proxy.rlwy.net';
$dbname = 'railway';
$username = 'root';
$password = 'swfDsQzVUPpWYATaWGWYIaCqfpltgipo';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    die("Connection failed: " . $e->getMessage());
}
?>
