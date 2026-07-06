<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ==============================
    // GET FORM DATA (SAFE)
    // ==============================
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone   = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $project = htmlspecialchars(trim($_POST['project'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? 'No Subject'));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    $mail = new PHPMailer(true);

    try {

        // ==============================
        // SMTP SETTINGS
        // ==============================
        $mail->isSMTP();
        $mail->Host       = 'mail4.dynamail.asia';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'service@ableace.com';
        $mail->Password   = 'Ableace@2026';

        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // FIX SSL ISSUE (Dynamail compatibility)
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'   => false,
                'allow_self_signed'  => true,
            ],
        ];

        // ==============================
        // EMAIL SETTINGS
        // ==============================
        $mail->setFrom('service@ableace.com', 'Able Ace Website');
        $mail->addAddress('service@ableace.com');

        // reply to user
        $mail->addReplyTo($email, $name);

        // ==============================
        // CONTENT
        // ==============================
        $mail->isHTML(true);
        $mail->Subject = $subject;

        $mail->Body = "
        <h2>New Contact Form Submission</h2>
        <table border='1' cellpadding='10' cellspacing='0' width='100%'>
            <tr><td><strong>Name</strong></td><td>$name</td></tr>
            <tr><td><strong>Email</strong></td><td>$email</td></tr>
            <tr><td><strong>Phone</strong></td><td>$phone</td></tr>
            <tr><td><strong>Project</strong></td><td>$project</td></tr>
            <tr><td><strong>Subject</strong></td><td>$subject</td></tr>
            <tr><td><strong>Message</strong></td><td>$message</td></tr>
        </table>
        ";

        // ==============================
        // SEND EMAIL
        // ==============================
        if ($mail->send()) {
            header("Location: contact.php?status=success");
            exit();
        } else {
            header("Location: contact.php?status=error");
            exit();
        }

    } catch (Exception $e) {

        // log real error (optional)
        error_log("Mail Error: " . $mail->ErrorInfo);

        header("Location: contact.php?status=error");
        exit();
    }

} else {
    header("Location: contact.php");
    exit();
}
?>