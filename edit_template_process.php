<?php
if (isset($_POST['template_id'])) {
    $templateId = $_POST['template_id'];
    $templateName = $_POST['template_name'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $imagePath = '';

    // Handle file upload if a new image is provided
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $imagePath = $targetFile;
    }

    try {
        // Connect to your database (assuming using PDO)
        include 'db_connection.php';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update template in the database
        if ($imagePath) {
            $stmt = $pdo->prepare("UPDATE email_templates SET template_name = ?, subject = ?, body = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$templateName, $subject, $body, $imagePath, $templateId]);
        } else {
            $stmt = $pdo->prepare("UPDATE email_templates SET template_name = ?, subject = ?, body = ? WHERE id = ?");
            $stmt->execute([$templateName, $subject, $body, $templateId]);
        }

        echo "Template updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<?php
if (isset($_POST['template_id'])) {
    // Your existing code to update the template

    // After updating the template, redirect to the list page
    echo '<script>window.location.href = "index.php";</script>';
}
?>
