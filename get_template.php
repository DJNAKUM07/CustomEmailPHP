<?php
if (isset($_GET['id'])) {
    try {
        // Connect to your database (assuming using PDO)
        include 'db_connection.php';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch template from database
        $stmt = $pdo->prepare("SELECT * FROM email_templates WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $template = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($template);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
