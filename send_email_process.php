<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $templateId = $_POST['template'] ?? '';
    $credentialId = $_POST['credential'] ?? '';
    $recipientEmail = $_POST['recipient_email'] ?? '';

    if (empty($templateId) || empty($credentialId) || empty($recipientEmail)) {
        echo '<div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header">
                    <strong class="mr-auto">Error</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">Please fill in all required fields.</div>
              </div>';
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM email_templates WHERE id = ?");
    $stmt->execute([$templateId]);
    $template = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$template) {
        echo '<div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header">
                    <strong class="mr-auto">Error</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">Template not found.</div>
              </div>';
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM credentials WHERE id = ?");
    $stmt->execute([$credentialId]);
    $credentials = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$credentials) {
        echo '<div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header">
                    <strong class="mr-auto">Error</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">Email credentials not found.</div>
              </div>';
        exit();
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $credentials['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $credentials['username'];
        $mail->Password = $credentials['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $credentials['smtp_port'];

        $mail->setFrom($credentials['sender_email'], $credentials['sender_name']);
        $mail->addAddress($recipientEmail);
        $mail->Subject = $template['subject'];
        $mail->isHTML(true);
        $mail->Body = $template['body'];

        if (!empty($template['image_path']) && file_exists($template['image_path'])) {
            $mail->addAttachment($template['image_path']);
        }

        if ($mail->send()) {
            $stmt = $pdo->prepare("INSERT INTO email_logs (recipient_email, subject, body) VALUES (?, ?, ?)");
            $stmt->execute([$recipientEmail, $template['subject'], $template['body']]);

            echo '<div class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                    <div class="toast-header">
                        <strong class="mr-auto">Success</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body">Email sent successfully!</div>
                  </div>';
        } else {
            echo '<div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                    <div class="toast-header">
                        <strong class="mr-auto">Error</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body">Email sending failed.</div>
                  </div>';
        }
    } catch (Exception $e) {
        echo '<div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header">
                    <strong class="mr-auto">Error</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">Mailer Error: ' . htmlspecialchars($mail->ErrorInfo) . '</div>
              </div>';
    }
} else {
    echo '<div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
            <div class="toast-header">
                <strong class="mr-auto">Error</strong>
                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">Invalid request.</div>
          </div>';
    exit();
}
?>
