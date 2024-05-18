<?php
include 'auth.php'; // Include the isLoggedIn() function
?>


<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Select Email Template and Enter Recipient</h2>
            </div>
            <!-- Button to redirect to "Add new Template" page -->
            <div class="col-md-4">
            <a href="index.php" class="btn btn-primary mb-3">Template List</a>
                <a href="save_template.php" class="btn btn-primary mb-3">Add New Template</a>
            </div>
        </div>
        <form action="send_email_process.php" method="post">
            <div class="form-group">
                <label for="template">Choose a template:</label>
                <select name="template" class="form-control" required>
                    <option value="">Select Template</option>
                    <?php
                    try {
                        // Connect to your database (assuming using PDO)
                        include 'db_connection.php';
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Fetch templates from database
                        $stmt = $pdo->query("SELECT id, template_name FROM email_templates");
                        while ($template = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $template['id'] . '">' . $template['template_name'] . '</option>';
                        }
                    } catch (PDOException $e) {
                        die("Error: " . $e->getMessage());
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="credential">Choose email credentials:</label>
                <select name="credential" class="form-control" required>
                    <option value="">Select Email Credentials</option>
                    <?php
                    try {
                        // Fetch email credentials from the database
                        $stmt = $pdo->query("SELECT id, sender_name FROM credentials");
                        while ($credential = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $credential['id'] . '">' . $credential['sender_name'] . '</option>';
                        }
                    } catch (PDOException $e) {
                        die("Error: " . $e->getMessage());
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="recipient_email">Recipient Email:</label>
                <input type="email" name="recipient_email" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Send Email</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
