<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $smtp_host = $_POST['smtp_host'];
    $smtp_port = $_POST['smtp_port'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sender_name = $_POST['sender_name'];
    $sender_email = $_POST['sender_email'];

    try {
        $stmt = $pdo->prepare("INSERT INTO credentials (smtp_host, smtp_port, username, password, sender_name, sender_email) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$smtp_host, $smtp_port, $username, $password, $sender_name, $sender_email]);
        header("Location: list_credentials.php");
    exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
