<?php
include 'auth.php';
include 'db_connection.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo "Invalid request.";
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT body FROM email_logs WHERE id = ?");
$stmt->execute([$id]);
$email = $stmt->fetch(PDO::FETCH_ASSOC);

if ($email) {
    echo nl2br(htmlspecialchars_decode($email['body']));
} else {
    echo "Email content not found.";
}
