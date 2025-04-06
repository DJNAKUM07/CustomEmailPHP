<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $template_name = trim($_POST['template_name'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $body = $_POST['body'] ?? '';
    $image_path = null;

    // Validate required fields
    if (!$template_name || !$subject || !$body || trim(strip_tags($body)) === '') {
        $_SESSION['error'] = "All fields are required.";
        header("Location: save_template.php");
        exit;
    }

    // File upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $filename = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO email_templates (template_name, subject, body, image_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$template_name, $subject, $body, $image_path]);
        $_SESSION['success'] = "Email template saved successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Failed to save the template. Please try again.";
    }

    header("Location: save_template.php");
    exit;
}
?>
