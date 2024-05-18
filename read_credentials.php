<?php
include 'db_connection.php';

try {
    $stmt = $pdo->query("SELECT * FROM credentials");
    $credentials = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
