<?php
// Include PHPMailer autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize PHPMailer
$mail = new PHPMailer(true); // Passing true enables exceptions

try {
    // Connect to the database
    include 'db_connection.php';

    if (isset($_POST['submit'])) {
        $templateId = $_POST['template'];
        $recipientEmail = $_POST['recipient_email'];

        // Fetch selected template from the database
        $stmt = $pdo->prepare("SELECT * FROM email_templates WHERE id = ?");
        $stmt->execute([$templateId]);
        $template = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($template) {
            $subject = $template['subject'];
            $body = $template['body'];
            $attachmentPath = $template['image_path'];
            

            // Fetch email credentials from the database
            $stmt = $pdo->query("SELECT * FROM credentials");
            $credentials = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($credentials) {
                // Set SMTP settings
                $mail->isSMTP();
                $mail->Host = $credentials['smtp_host'];
                $mail->SMTPAuth = true;
                $mail->Username = $credentials['username'];
                $mail->Password = $credentials['password'];
                $mail->SMTPSecure = 'ssl';
                $mail->Port = $credentials['smtp_port'];

                // Email content
                $mail->setFrom($credentials['sender_email'], $credentials['sender_name']);
                $mail->addAddress($recipientEmail);
                $mail->Subject = $subject;
                $mail->isHTML(true);

                // Add the body content with image
                $mail->Body = $body;
                // Check if attachment path exists
                if (file_exists($attachmentPath)) {
                    // Add attachment
                    $mail->addAttachment($attachmentPath);
                } else {
                    // Handle error if attachment file does not exist
                    echo "Attachment file not found.";
                }

                // Send email
                $mail->send();

                 // Insert email log into the database
                 try {
                    // Prepare SQL statement to insert into email_logs table
                    $stmt = $pdo->prepare("INSERT INTO email_logs (recipient_email, subject, body) VALUES (?, ?, ?)");
                    // Bind parameters
                    $stmt->bindParam(1, $recipientEmail);
                    $stmt->bindParam(2, $subject);
                    $stmt->bindParam(3, $body);
                    // Execute the statement
                    $stmt->execute();
                } catch (PDOException $e) {
                    // Handle the exception if insertion fails
                    echo "Error inserting email log: " . $e->getMessage();
                }

                // Redirect to Send Email page with success message
                header("Location: send_email.php?success=1");
                exit;
            } else {
                // Redirect to Send Email page with error message
                header("Location: send_email.php?error=1");
                exit;
            }
        } else {
            // Redirect to Send Email page with error message
            header("Location: send_email.php?error=1");
            exit;
        }
    }
} catch (PDOException $e) {
    // Redirect to Send Email page with error message
    header("Location: send_email.php?error=1");
    exit;
} catch (Exception $e) {
    // Redirect to Send Email page with error message
    header("Location: send_email.php?error=1");
    exit;
}
?>
