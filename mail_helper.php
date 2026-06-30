<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/mail_config.php';

function sendContactInquiryEmail(array $inquiry)
{
    $settings = mailSettings();

    if (!mailIsConfigured($settings)) {
        if (mailIsLocalhost() && $settings['dev_fallback']) {
            return mailDevFallbackSend($inquiry, $settings);
        }

        return [
            'success' => false,
            'message' => 'Email service is not configured. Please add Gmail SMTP credentials in mail_config.php.',
        ];
    }

    $mail = new PHPMailer(true);

$mail->SMTPDebug = SMTP::DEBUG_OFF;
$mail->Debugoutput = 'html';
   // $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
   // $mail->Debugoutput = 'html';
   // $mail->SMTPDebug = PHPMailer::DEBUG_SERVER;
   // $mail->Debugoutput = 'html';

    try {
        $port = $settings['port'] > 0 ? $settings['port'] : 587;

        $mail->isSMTP();
        $mail->Host = $settings['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $settings['username'];
        $mail->Password = $settings['password'];
        $mail->SMTPSecure = ($port === 465)
            ? PHPMailer::ENCRYPTION_SMTPS
            : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $port;
        $mail->CharSet = 'UTF-8';
        $mail->Timeout = 20;

        $mail->setFrom($settings['from_email'], $settings['from_name']);
        $mail->addAddress($settings['to_email']);
        $mail->addReplyTo($inquiry['email'], $inquiry['fullname']);

        $body = buildContactInquiryEmailBody($inquiry);

        $mail->isHTML(true);
        $mail->Subject = 'New Inquiry from Caring Squad Website';
        $mail->Body = $body['html'];
        $mail->AltBody = $body['text'];

        $mail->send();

        return [
            'success' => true,
            'message' => 'Thank you! Your inquiry has been submitted successfully. Our team will get back to you soon.',
        ];
    } catch (Exception $e) {
        error_log('Contact form mail error: ' . $mail->ErrorInfo);

        if (mailIsLocalhost() && $settings['dev_fallback']) {
            $fallback = mailDevFallbackSend($inquiry, $settings);
            if ($fallback['success']) {
                return $fallback;
            }
        }

        return [
            'success' => false,
            'message' => $mail->ErrorInfo ?: $e->getMessage()
        ];
    }
}

function buildContactInquiryEmailBody(array $inquiry)
{
    $safeFullname = htmlspecialchars($inquiry['fullname'], ENT_QUOTES, 'UTF-8');
    $safeMobile = htmlspecialchars($inquiry['mobile'], ENT_QUOTES, 'UTF-8');
    $safeEmail = htmlspecialchars($inquiry['email'], ENT_QUOTES, 'UTF-8');
    $safeCity = htmlspecialchars($inquiry['city'], ENT_QUOTES, 'UTF-8');
    $safeAddress = htmlspecialchars($inquiry['address'], ENT_QUOTES, 'UTF-8');
    $safeWhoami = htmlspecialchars($inquiry['whoami'], ENT_QUOTES, 'UTF-8');
    $safeInquiryfor = htmlspecialchars($inquiry['inquiryfor'], ENT_QUOTES, 'UTF-8');
    $safeDescription = nl2br(htmlspecialchars($inquiry['description'], ENT_QUOTES, 'UTF-8'));

    $html = "
    <h2>New Inquiry Received</h2>
    <table border='1' cellpadding='10' cellspacing='0' width='100%'>
        <tr><td><b>Full Name</b></td><td>{$safeFullname}</td></tr>
        <tr><td><b>Mobile</b></td><td>{$safeMobile}</td></tr>
        <tr><td><b>Email</b></td><td>{$safeEmail}</td></tr>
        <tr><td><b>City</b></td><td>{$safeCity}</td></tr>
        <tr><td><b>Address</b></td><td>{$safeAddress}</td></tr>
        <tr><td><b>Who Am I?</b></td><td>{$safeWhoami}</td></tr>
        <tr><td><b>Inquiry For</b></td><td>{$safeInquiryfor}</td></tr>
        <tr><td><b>Description</b></td><td>{$safeDescription}</td></tr>
    </table>
    ";

    $text =
        "New Inquiry Received\n\n" .
        "Full Name: {$inquiry['fullname']}\n" .
        "Mobile: {$inquiry['mobile']}\n" .
        "Email: {$inquiry['email']}\n" .
        "City: {$inquiry['city']}\n" .
        "Address: {$inquiry['address']}\n" .
        "Who Am I?: {$inquiry['whoami']}\n" .
        "Inquiry For: {$inquiry['inquiryfor']}\n" .
        "Description: {$inquiry['description']}\n";

    return ['html' => $html, 'text' => $text];
}

function mailDevFallbackSend(array $inquiry, array $settings)
{
    $logDir = __DIR__ . '/storage';
    $logFile = $logDir . '/contact_mail.log';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $body = buildContactInquiryEmailBody($inquiry);
    $entry = str_repeat('-', 60) . PHP_EOL .
        'Time: ' . date('Y-m-d H:i:s') . PHP_EOL .
        'To: ' . $settings['to_email'] . PHP_EOL .
        'Mode: localhost dev fallback (SMTP not configured or failed)' . PHP_EOL .
        $body['text'] . PHP_EOL;

    if (file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX) === false) {
        return [
            'success' => false,
            'message' => 'Sorry, we could not save your inquiry right now. Please try again later or call us at 1800 571 1929.',
        ];
    }

    error_log('Contact inquiry saved to storage/contact_mail.log (localhost dev fallback).');

    return [
        'success' => true,
        'message' => 'Thank you! Your inquiry has been submitted successfully. Our team will get back to you soon.',
    ];
}

function saveContactInquiry($conn, array $inquiry)
{
    if (!$conn) {
        return false;
    }

    ensureContactInquiriesTable($conn);

    $stmt = mysqli_prepare(
        $conn,
        'INSERT INTO contact_inquiries
        (fullname, mobile, email, city, address, whoami, inquiryfor, description)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );

    if (!$stmt) {
        error_log('Contact inquiry prepare failed: ' . mysqli_error($conn));
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'ssssssss',
        $inquiry['fullname'],
        $inquiry['mobile'],
        $inquiry['email'],
        $inquiry['city'],
        $inquiry['address'],
        $inquiry['whoami'],
        $inquiry['inquiryfor'],
        $inquiry['description']
    );

    $saved = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$saved) {
        error_log('Contact inquiry insert failed: ' . mysqli_error($conn));
    }

    return $saved;
}

function ensureContactInquiriesTable($conn)
{
    static $checked = false;

    if ($checked || !$conn) {
        return;
    }

    $sql = "CREATE TABLE IF NOT EXISTS contact_inquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(120) NOT NULL,
        mobile VARCHAR(20) NOT NULL,
        email VARCHAR(255) NOT NULL,
        city VARCHAR(100) NOT NULL,
        address VARCHAR(300) NOT NULL,
        whoami VARCHAR(120) NOT NULL,
        inquiryfor VARCHAR(200) NOT NULL,
        description TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    mysqli_query($conn, $sql);
    $checked = true;
}
