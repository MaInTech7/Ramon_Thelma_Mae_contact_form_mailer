<?php
// These lines are necessary to include the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; // Needed if you're using SMTP

require 'PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/PHPMailer-master/src/SMTP.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // --- START: Save to database ---
    include 'db.php';
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // true enables exceptions

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'thelmamaeramon@gmail.com';
        $mail->Password   = 'fjbr dnww tzwc ylpg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('thelmamaeramon@gmail.com', 'OTP Verification');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = "New Contact Form Submission: " . $subject;
        $mail->Body    = "
            <h2>Contact Form Submission</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Subject:</strong> {$subject}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nSubject: {$subject}\nMessage: {$message}"; // Plain text for non-HTML email clients

        $mail->send();
        // Redirect back to index.php with success status
        header('Location: index.php?status=success');
        exit();
    } catch (Exception $e) {
        // Redirect back to index.php with error status and optional error message
        header('Location: index.php?status=error&msg=' . urlencode($mail->ErrorInfo));
        exit();
    }
} else {
    // If someone tries to access send_email.php directly
    header('Location: index.php');
    exit();
}
?>