<?php
// Include PHPMailer autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection parameters
$host = 'roundhouse.proxy.rlwy.net';
$dbname = 'railway';
$username = 'root';
$password = 'swfDsQzVUPpWYATaWGWYIaCqfpltgipo';

// Email sending parameters
$fromEmail = 'satishchau2002@gmail.com'; // Sender's email address
$fromName = 'Sahil Chau'; // Sender's name

// Initialize PHPMailer
$mail = new PHPMailer(true); // Passing true enables exceptions

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {
        $templateId = $_POST['template'];
        $recipientEmail = $_POST['recipient_email'];

        // Fetch selected template from database
        $stmt = $pdo->prepare("SELECT * FROM email_templates WHERE id = ?");
        $stmt->execute([$templateId]);
        $template = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($template) {
            $subject = $template['subject'];
            $body = $template['body'];
            $imagePath = $template['image_path'];

            // Set SMTP settings for Gmail SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'satishchau2002@gmail.com'; // Your Gmail address
            $mail->Password = 'llblttzdrjltjnre'; // Your Gmail password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Email content
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($recipientEmail);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $body;

            // Attach image if available
            if ($imagePath && file_exists($imagePath)) {
                $mail->addAttachment($imagePath, $imagePath);
            }

            // Send email
            $mail->send();
            echo "Email sent successfully!";
        } else {
            echo "Template not found!";
        }
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Email sending failed: " . $mail->ErrorInfo;
}
?>
