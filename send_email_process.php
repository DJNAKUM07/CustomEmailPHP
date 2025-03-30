<?php
// Include PHPMailer autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    // Include database connection
    include 'db_connection.php';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $templateId = $_POST['template'];
        $recipientEmail = $_POST['recipient_email'];

        // Validate input
        if (empty($templateId) || empty($recipientEmail)) {
            die("Error: Missing required fields.");
        }

        // Fetch selected email template from the database
        $stmt = $pdo->prepare("SELECT * FROM email_templates WHERE id = ?");
        $stmt->execute([$templateId]);
        $template = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$template) {
            die("Error: Email template not found.");
        }

        $subject = $template['subject'];
        $body = $template['body'];
        $attachmentPath = $template['image_path'] ?? null;

        // Fetch SMTP credentials from the database
        $stmt = $pdo->query("SELECT * FROM credentials LIMIT 1");
        $credentials = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$credentials) {
            die("Error: SMTP credentials not found.");
        }

        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Enable SMTP debugging (Set to 0 in production to disable debug output)
            $mail->SMTPDebug = 2;  // 0 = off, 1 = client, 2 = client & server
            $mail->Debugoutput = 'html';
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = $credentials['smtp_host']; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = $credentials['username']; // SMTP username
            $mail->Password = $credentials['password']; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Change to 'ssl' if required
            $mail->Port = $credentials['smtp_port']; // SMTP port

            // Set email sender
            $mail->setFrom($credentials['sender_email'], $credentials['sender_name']);
            
            // Set recipient email
            $mail->addAddress($recipientEmail);
            
            // Email subject & body
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $body;

            // Attach file if exists
            if (!empty($attachmentPath) && file_exists($attachmentPath)) {
                $mail->addAttachment($attachmentPath);
            }

            // Send email
            if ($mail->send()) {
                // Log email details into the database
                $stmt = $pdo->prepare("INSERT INTO email_logs (recipient_email, subject, body) VALUES (?, ?, ?)");
                $stmt->execute([$recipientEmail, $subject, $body]);

                // Redirect to success page
                header("Location: send_email.php?success=1");
                exit();
            } else {
                die("Error: Email could not be sent.");
            }
        } catch (Exception $e) {
            die("Error: " . $mail->ErrorInfo);
        }
    } else {
        die("Error: Invalid request.");
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}