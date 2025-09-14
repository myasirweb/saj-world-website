<?php

// Define Host Info || Who is sending emails?
define("HOST_NAME", "SAJ World");
define("HOST_EMAIL", "info@sajworld.com");

// Define Recipent Info ||  Who will get this email?
define("RECIPIENT_NAME", "SAJ World");
define("RECIPIENT_EMAIL", "info@sajworld.com");

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isMail(); // ✅ Use PHP's built-in mail() function (no SMTP)

    // Recipients
    $mail->setFrom(HOST_EMAIL, HOST_NAME);
    $mail->addAddress(RECIPIENT_EMAIL, RECIPIENT_NAME); // Recipient

    // Content
    $name = isset($_POST['name']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['name']) : "";
    $senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
    $phone = isset($_POST['phone']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone']) : "";
    $services = isset($_POST['services']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['services']) : "";
    $subject = isset($_POST['subject']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject']) : "";
    $address = isset($_POST['address']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['address']) : "";
    $website = isset($_POST['website']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['website']) : "";
    $message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";

    $mail->isHTML(true); // Send as HTML
    $mail->Subject = 'A contact request sent by ' . $name;
    $mail->Body    = 'Name: ' . $name . "<br>";
    $mail->Body   .= 'Email: ' . $senderEmail . "<br>";

    if ($phone) {
        $mail->Body .= 'Phone: ' . $phone . "<br>";
    }
    if ($services) {
        $mail->Body .= 'Services: ' . $services . "<br>";
    }
    if ($subject) {
        $mail->Body .= 'Subject: ' . $subject . "<br>";
    }
    if ($address) {
        $mail->Body .= 'Address: ' . $address . "<br>";
    }
    if ($website) {
        $mail->Body .= 'Website: ' . $website . "<br>";
    }

    $mail->Body .= 'Message: <br>' . nl2br($message);

    $mail->send();
    echo "<div class='inner success'><p class='success'>Thanks for contacting us. We will contact you ASAP!</p></div>";
} catch (Exception $e) {
    echo "<div class='inner error'><p class='error'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p></div>";
}
