<?php
include 'db_connection.php'; // Include the database connection

if (isset($_POST['id'])) {
    $Id = $_POST['id'];

    try {
        // Prepare SQL statement to delete template
        $stmt = $pdo->prepare("DELETE FROM credentials WHERE id = ?");
        // Bind parameters
        $stmt->bindParam(1, $Id);
        // Execute the statement
        $stmt->execute();

        // Send a success response
        echo "credentials deleted successfully!";
    } catch (PDOException $e) {
        // Handle the exception if deletion fails
        echo "Error deleting credentials: " . $e->getMessage();
    }
} else {
    // Handle case where template ID is not provided
    echo "credentials ID not provided.";
}
?>
