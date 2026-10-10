<?php
declare(strict_types=1);
require_once __DIR__ . '/database.php';
$token = (string) ($_GET['token'] ?? '');
$message = 'This unsubscribe link is not valid. You can contact SOPNG if you need help.';
if (preg_match('/^[a-f0-9]{64}$/', $token)) {
    try {
        $statement = site_database()->prepare("UPDATE newsletter_subscribers SET status = 'unsubscribed' WHERE unsubscribe_token = :token");
        $statement->execute(['token' => $token]);
        if ($statement->rowCount() > 0) $message = 'You have been unsubscribed from SOPNG email updates.';
    } catch (Throwable $error) {
        error_log('SOPNG newsletter unsubscribe could not be completed: ' . $error->getMessage());
        http_response_code(503);
        $message = 'We could not process this request right now. Please contact SOPNG for help.';
    }
}
$safe = htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="site.css"><title>Email preferences | SOPNG</title><body><main class="standalone-response"><section class="response-card"><p class="eyebrow">SPECIAL OLYMPICS PAPUA NEW GUINEA</p><h1>Email <em>preferences.</em></h1><p>' . $safe . '</p><p><a class="button button-red" href="index.html">Return to SOPNG</a></p></section></main></body></html>';

