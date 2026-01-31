<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// FORM KE NAMES (SAME AS YOUR HTML FORM)
$name    = $_POST['username'];
$email   = $_POST['email'];
$phone   = $_POST['phone'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$mail = new PHPMailer(true);

try {
    // SMTP SETTINGS
    $mail->isSMTP();
    $mail->Host       = 'send.one.com';
    $mail->SMTPAuth   = true;

    // Yaha apna Gmail + App Password
    $mail->Username   = 'contact@jinlindia.com';
    $mail->Password   = '@jinlindia.com';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Sender Email
    $mail->setFrom('contact@jinlindia.com', 'Contact Form');

    // Receiver Email
    $mail->addAddress('contact@jinlindia.com', 'Form Message');

    // Email Format HTML
    $mail->isHTML(true);
    $mail->Subject = "New Contact Form Message: $subject";

    // BODY DESIGN
    $mail->Body = "
        <h3>New Contact Message</h3>
        <p><b>Name:</b> $name</p>
        <p><b>Email:</b> $email</p>
        <p><b>Phone:</b> $phone</p>
        <p><b>Subject:</b> $subject</p>
        <p><b>Message:</b><br>$message</p>
    ";

    $mail->send();
    echo "OK";  
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
?>
