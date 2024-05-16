<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
</head>
<body>
    <h2>Select Email Template and Enter Recipient</h2>
    <form action="send_email_process.php" method="post">
        <label for="template">Choose a template:</label>
        <select name="template" required>
            <option value="">Select Template</option>
            <?php
            try {
                // Connect to your database (assuming using PDO)
                $pdo = new PDO('mysql:host=localhost;dbname=customemail', 'root', '');
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
        </select><br><br>
        Recipient Email: <input type="email" name="recipient_email" required><br><br>
        <input type="submit" name="submit" value="Send Email">
    </form>
</body>
</html>
