<?php
declare(strict_types=1);
require_once __DIR__ . '/database.php';

$escape = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$fail = static function (array $messages, int $status = 422) use ($escape): never {
    http_response_code($status);
    $items = implode('', array_map(static fn ($message) => '<li>' . $escape((string) $message) . '</li>', $messages));
    echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="site.css"><title>Check your message | SOPNG</title><body><main class="standalone-response"><section class="response-card"><p class="eyebrow">SPECIAL OLYMPICS PAPUA NEW GUINEA</p><h1>Check your <em>message.</em></h1><ul>' . $items . '</ul><p><a class="button button-red" href="javascript:history.back()">Return to the form</a></p></section></main></body></html>';
    exit;
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Please use the enquiry form on the website.');
}

$honeypot = trim((string) ($_POST['website'] ?? ''));
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
if ($honeypot !== '') {
    header('Location: ' . $returnTo);
    exit;
}

$clean = static fn (string $key, int $limit): string => substr(trim(str_replace("\0", '', (string) ($_POST[$key] ?? ''))), 0, $limit);
$name = $clean('name', 100);
$email = str_replace(["\r", "\n"], '', $clean('email', 180));
$phone = $clean('phone', 60);
$organisation = $clean('organisation', 180);
$topic = $clean('topic', 180) ?: 'Website enquiry';
$interest = $clean('interest', 180);
$sourcePage = $clean('source_page', 120) ?: 'Website';
$message = trim((string) ($_POST['message'] ?? ''));
$message = substr(str_replace("\0", '', $message), 0, 5000);
$errors = [];
if ($name === '') $errors[] = 'Please enter your name.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
if ($message === '') $errors[] = 'Please include a message.';
if ($errors) $fail($errors);

try {
    $statement = site_database()->prepare('INSERT INTO website_enquiries (name, email, phone, organisation, topic, interest, source_page, message) VALUES (:name, :email, :phone, :organisation, :topic, :interest, :source_page, :message)');
    $statement->execute([
        'name' => $name,
        'email' => $email,
        'phone' => $phone !== '' ? $phone : null,
        'organisation' => $organisation !== '' ? $organisation : null,
        'topic' => $topic,
        'interest' => $interest !== '' ? $interest : null,
        'source_page' => $sourcePage,
        'message' => $message,
    ]);
} catch (Throwable $error) {
    error_log('SOPNG enquiry could not be saved: ' . $error->getMessage());
    $fail(['The enquiry form is not connected yet. Please call SOPNG at +675 741 97066.'], 503);
}

header('Location: ' . $returnTo);
exit;

