<?php
declare(strict_types=1);

$config = require __DIR__ . '/form-config.php';
$recipient = filter_var($config['recipient'] ?? '', FILTER_VALIDATE_EMAIL);
$escape = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Please use the enquiry form on the website.');
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$phone = trim((string) ($_POST['phone'] ?? ''));
$topic = trim((string) ($_POST['topic'] ?? 'Website enquiry'));
$interest = trim((string) ($_POST['interest'] ?? ''));
$organisation = trim((string) ($_POST['organisation'] ?? ''));
$sourcePage = trim((string) ($_POST['source_page'] ?? 'Website'));
$message = trim((string) ($_POST['message'] ?? ''));
$honeypot = trim((string) ($_POST['website'] ?? ''));
$name = str_replace(["\r", "\0"], '', $name);
$email = str_replace(["\r", "\n", "\0"], '', $email);
$phone = str_replace(["\r", "\0"], '', $phone);
$topic = str_replace(["\r", "\n", "\0"], '', $topic);
$interest = str_replace(["\r", "\0"], '', $interest);
$organisation = str_replace(["\r", "\0"], '', $organisation);
$sourcePage = str_replace(["\r", "\0"], '', $sourcePage);
$message = str_replace("\0", '', $message);
$returnTo = (string) ($_POST['return_to'] ?? '');
$allowedReturns = [
    'contact.html?sent=1#contact-form',
    'events.html?sent=1#event-interest',
    'donate.html?sent=1#support-form',
    'marketplace.html?sent=1#marketplace-enquiry',
];
if (!in_array($returnTo, $allowedReturns, true)) {
    $returnTo = 'contact.html?sent=1#contact-form';
}

// Quietly accept the hidden spam field without forwarding it.
if ($honeypot !== '') {
    header('Location: ' . $returnTo);
    exit;
}

$errors = [];
if ($name === '' || strlen($name) > 100) {
    $errors[] = 'Please enter your name.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 180 || preg_match('/[\r\n]/', $email)) {
    $errors[] = 'Please enter a valid email address.';
}
if ($message === '' || strlen($message) > 5000) {
    $errors[] = 'Please include a message of up to 5,000 characters.';
}
if (!$recipient) {
    $errors[] = 'The website enquiry inbox is not configured yet.';
}

if ($errors) {
    http_response_code(422);
    $errorList = implode('', array_map(static fn ($error) => '<li>' . $escape($error) . '</li>', $errors));
    echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="site.css"><title>Check your message | SOPNG</title><body><main class="standalone-response"><section class="response-card"><p class="eyebrow">SPECIAL OLYMPICS PAPUA NEW GUINEA</p><h1>Check your <em>message.</em></h1><p>We could not send this enquiry yet:</p><ul>' . $errorList . '</ul><p><a class="button button-red" href="javascript:history.back()">Return to the form</a></p></section></main></body></html>';
    exit;
}

$host = strtolower((string) ($_SERVER['SERVER_NAME'] ?? ''));
$host = preg_replace('/[^a-z0-9.-]/', '', $host) ?: 'localhost';
$safeTopic = preg_replace('/[^a-zA-Z0-9 &-]/', '', $topic) ?: 'Website enquiry';
$subject = 'SOPNG website enquiry: ' . substr($safeTopic, 0, 100);
$body = "A new enquiry was sent from the SOPNG website.\n\n"
    . "Name: {$name}\nEmail: {$email}\n"
    . ($phone !== '' ? "Phone: {$phone}\n" : '')
    . ($interest !== '' ? "Interested in: {$interest}\n" : '')
    . ($organisation !== '' ? "Organisation: {$organisation}\n" : '')
    . "Page: {$sourcePage}\nTopic: {$topic}\n\nMessage:\n{$message}\n";
$headers = [
    'From: SOPNG website <website@' . $host . '>',
    'Reply-To: ' . $email,
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . PHP_VERSION,
];

$sent = @mail($recipient, $subject, $body, implode("\r\n", $headers));
if (!$sent) {
    http_response_code(503);
    echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="site.css"><title>Message not sent | SOPNG</title><body><main class="standalone-response"><section class="response-card"><p class="eyebrow">SPECIAL OLYMPICS PAPUA NEW GUINEA</p><h1>We could not send<br><em>that message.</em></h1><p>Please try again later or call SOPNG at <a href="tel:+67574197066">+675 741 97066</a>.</p><p><a class="button button-red" href="javascript:history.back()">Return to the form</a></p></section></main></body></html>';
    exit;
}

header('Location: ' . $returnTo);
exit;

