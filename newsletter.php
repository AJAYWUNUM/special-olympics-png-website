<?php
declare(strict_types=1);
require_once __DIR__ . '/database.php';

$finish = static function (string $message, int $status = 200): never {
    http_response_code($status);
    $safe = htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="site.css"><title>Newsletter | SOPNG</title><body><main class="standalone-response"><section class="response-card"><p class="eyebrow">SPECIAL OLYMPICS PAPUA NEW GUINEA</p><h1>Stay in <em>touch.</em></h1><p>' . $safe . '</p><p><a class="button button-red" href="index.html#newsletter">Return to the homepage</a></p></section></main></body></html>';
    exit;
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Please use the newsletter form on the website.');
}
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    header('Location: index.html?subscribed=1#newsletter');
    exit;
}

$name = trim(substr(str_replace("\0", '', (string) ($_POST['name'] ?? '')), 0, 100));
$email = str_replace(["\r", "\n"], '', trim(substr((string) ($_POST['email'] ?? ''), 0, 180)));
$consent = (string) ($_POST['consent'] ?? '');
if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $consent !== 'yes') {
    $finish('Please enter your name and a valid email address, then confirm that you would like to receive SOPNG updates.', 422);
}

try {
    $pdo = site_database();
    $token = bin2hex(random_bytes(32));
    $statement = $pdo->prepare("INSERT INTO newsletter_subscribers (name, email, status, consent_at, unsubscribe_token) VALUES (:name, :email, 'subscribed', UTC_TIMESTAMP(), :token) ON DUPLICATE KEY UPDATE name = VALUES(name), status = 'subscribed', consent_at = UTC_TIMESTAMP(), unsubscribe_token = VALUES(unsubscribe_token)");
    $statement->execute(['name' => $name, 'email' => $email, 'token' => $token]);
    $config = require __DIR__ . '/database-config.php';
    $sender = filter_var((string) ($config['sender_email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if (!$sender) throw new RuntimeException('Newsletter sender is not configured.');
    $baseUrl = rtrim((string) ($config['site_url'] ?? ''), '/');
    if (!preg_match('~^https://[a-z0-9.-]+$~i', $baseUrl)) throw new RuntimeException('Website address is not configured.');
    $unsubscribeUrl = $baseUrl . '/unsubscribe.php?token=' . rawurlencode($token);
    $senderName = str_replace(["\r", "\n", '"'], '', (string) ($config['sender_name'] ?? 'SOPNG'));
    $subject = 'You are subscribed to SOPNG updates';
    $body = "Hello {$name},\n\nThank you for subscribing to updates from Special Olympics Papua New Guinea. We will share news about our programs, events and community activities.\n\nIf you no longer want these updates, unsubscribe here:\n{$unsubscribeUrl}\n\nWith thanks,\n{$senderName}\n";
    $headers = [
        'From: "' . $senderName . '" <' . $sender . '>',
        'Content-Type: text/plain; charset=UTF-8',
        'X-Mailer: PHP/' . PHP_VERSION,
    ];
    if (!@mail($email, $subject, $body, implode("\r\n", $headers))) {
        error_log('SOPNG newsletter welcome email could not be sent.');
        $finish('Your subscription has been saved. The welcome email could not be sent right now; please try again later or contact SOPNG.');
    }
} catch (Throwable $error) {
    error_log('SOPNG newsletter subscription could not be completed: ' . $error->getMessage());
    $finish('The newsletter form is not fully connected yet. Please contact SOPNG directly while the website is being set up.', 503);
}

header('Location: index.html?subscribed=1#newsletter');
exit;

