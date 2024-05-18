<?php
include 'db_connection.php'; // Include the database connection

if (isset($_POST['id'])) {
    $templateId = $_POST['id'];

    try {
        // Prepare SQL statement to delete template
        $stmt = $pdo->prepare("DELETE FROM email_templates WHERE id = ?");
        // Bind parameters
        $stmt->bindParam(1, $templateId);
        // Execute the statement
        $stmt->execute();

        // Send a success response
        echo "Template deleted successfully!";
    } catch (PDOException $e) {
        // Handle the exception if deletion fails
        echo "Error deleting template: " . $e->getMessage();
    }
} else {
    // Handle case where template ID is not provided
    echo "Template ID not provided.";
}
?>
