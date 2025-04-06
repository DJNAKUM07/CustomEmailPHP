<?php
require 'auth.php';
requireLogin();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM email_templates WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo 'success';
        } else {
            echo 'fail';
        }
    } catch (PDOException $e) {
        echo 'fail';
    }
} else {
    echo 'invalid';
}
?>
