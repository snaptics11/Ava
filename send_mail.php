<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Enable error reporting for debugging (optional in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get and sanitize form data from your HTML form
        $name    = isset($_POST['contact-name']) ? htmlspecialchars(trim($_POST['contact-name'])) : '';
        $email   = isset($_POST['contact-email']) ? htmlspecialchars(trim($_POST['contact-email'])) : '';
        $company = isset($_POST['company-name']) ? htmlspecialchars(trim($_POST['company-name'])) : '';
        $message = isset($_POST['user-message']) ? htmlspecialchars(trim($_POST['user-message'])) : '';

        // Basic email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<script>alert("Invalid email format!"); window.history.back();</script>';
            exit;
        }

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'maddurinaresh3@gmail.com';      // Your Gmail
        $mail->Password   = 'dmcr peuz cmbq dnsy';            // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Who it's from and going to
        $mail->setFrom('maddurinaresh3@gmail.com', 'Website Contact Form');
        $mail->addAddress('maddurinaresh3@gmail.com', 'Naresh');
        $mail->addReplyTo($email, $name);

        // Prepare Email Body
        $emailBody = "<h2>New Contact Form Submission</h2>";
        $emailBody .= "<p><strong>Name:</strong> {$name}</p>";
        $emailBody .= "<p><strong>Email:</strong> {$email}</p>";
        $emailBody .= "<p><strong>Company:</strong> {$company}</p>";
        $emailBody .= "<p><strong>Message:</strong><br>" . nl2br($message) . "</p>";

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission from $name";
        $mail->Body    = $emailBody;

        // Try to send the email
        if ($mail->send()) {
            echo '<script>
                    alert("Your message has been sent successfully!");
                    window.location.href = "index.html"; // Change if needed
                  </script>';
        } else {
            echo '<script>
                    alert("Something went wrong :(");
                    window.history.back();
                  </script>';
        }

    } catch (Exception $e) {
        echo '<script>
                alert("Message could not be sent. Error: ' . addslashes($mail->ErrorInfo) . '");
                window.history.back();
              </script>';
    }
}
?>
