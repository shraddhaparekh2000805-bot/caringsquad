<?php

/**
 * SMTP settings for Contact Us form emails.
 *
 * Option 1: Edit the values below directly.
 * Option 2: Create mail_config.local.php (same folder) to override settings
 *          without changing this file.
 */

$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;

$smtpUsername = 'info.caringsquad@gmail.com';

$smtpPassword = 'Caringsquad@2025';

$mailFromEmail = 'info.caringsquad@gmail.com';

$mailFromName = 'Caring Squad';

$mailToEmail = 'info.caringsquad@gmail.com';

$mailDevFallback = false;

if (is_readable(__DIR__ . '/mail_config.local.php')) {
    require __DIR__ . '/mail_config.local.php';
}

if ($mailFromEmail === '' && $smtpUsername !== '') {
    $mailFromEmail = $smtpUsername;
}

function mailSettings()
{
    global $smtpHost, $smtpPort, $smtpUsername, $smtpPassword;
    global $mailFromEmail, $mailFromName, $mailToEmail, $mailDevFallback;

    return [
        'host' => $smtpHost,
        'port' => (int) $smtpPort,
        'username' => $smtpUsername,
        'password' => $smtpPassword,
        'from_email' => $mailFromEmail,
        'from_name' => $mailFromName,
        'to_email' => $mailToEmail,
        'dev_fallback' => (bool) $mailDevFallback,
    ];
}

function mailIsConfigured(array $settings)
{
    $placeholders = ['SMTP_HOST', 'SMTP_PORT', 'SMTP_USERNAME', 'SMTP_PASSWORD'];

    if ($settings['username'] === '' || $settings['password'] === '') {
        return false;
    }

    if (in_array($settings['host'], $placeholders, true)) {
        return false;
    }

    if (in_array($settings['username'], $placeholders, true)) {
        return false;
    }

    if (in_array($settings['password'], $placeholders, true)) {
        return false;
    }

    if (!filter_var($settings['from_email'], FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    return true;
}

function mailIsLocalhost()
{
    $host = strtolower($_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost');
    $host = preg_replace('/:\d+$/', '', $host);

    return in_array($host, ['localhost', '127.0.0.1'], true);
}
