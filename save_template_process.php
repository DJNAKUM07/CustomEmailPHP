<?php
// Connect to your database (assuming using PDO)
$pdo = new PDO('mysql:host=roundhouse.proxy.rlwy.net;dbname=railway', 'root', 'swfDsQzVUPpWYATaWGWYIaCqfpltgipo',19474);

// Handle form submission
if (isset($_POST['submit'])) {
    $templateName = $_POST['template_name'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    // Handle uploaded image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imagePath = 'uploads/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = null;
    }

    // Save template to database
    $stmt = $pdo->prepare("INSERT INTO email_templates (template_name, subject, body, image_path) VALUES (?, ?, ?, ?)");
    $stmt->execute([$templateName, $subject, $body, $imagePath]);

    echo "Template saved successfully!";
}
?>
