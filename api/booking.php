<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_out(['message' => 'Method not allowed.'], 405);
if (!csrf_check($_POST['csrf'] ?? null))   json_out(['message' => 'Session expired. Please refresh the page.'], 403);
if (!empty($_POST['website']))             json_out(['message' => 'Thank you!']); // honeypot: bot

$d = [
    'name'    => trim($_POST['name'] ?? ''),
    'phone'   => trim($_POST['phone'] ?? ''),
    'email'   => trim($_POST['email'] ?? ''),
    'service' => trim($_POST['service'] ?? ''),
    'date'    => trim($_POST['date'] ?? ''),
    'time'    => trim($_POST['time'] ?? ''),
    'notes'   => trim($_POST['notes'] ?? ''),
];

if (in_array('', [$d['name'], $d['phone'], $d['email'], $d['service'], $d['date'], $d['time']], true)
    || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)
    || !($ts = strtotime("{$d['date']} {$d['time']}"))
    || $ts < time()) {
    json_out(['message' => 'Please check your details and try again.'], 422);
}

$weekday = (int)date('w', $ts);              // 0 = domingo, 1 = segunda
$hour    = (int)date('G', $ts);
if ($weekday < 2 || $hour < 9 || $hour >= 18) {
    json_out(['message' => 'We are open Tuesday to Saturday, 9am to 6pm.'], 422);
}

if ($pdo = db()) {
    // Tabela prevista: bookings (name, phone, email, service, date, notes, status, created_at)
    $st = $pdo->prepare('INSERT INTO bookings (name, phone, email, service, date, notes, status, created_at)
                         VALUES (?, ?, ?, ?, ?, ?, "pending", NOW())');
    $st->execute([$d['name'], $d['phone'], $d['email'], $d['service'], date('Y-m-d H:i:s', $ts), $d['notes']]);
    // TODO: enviar e-mail de aviso para SITE_EMAIL
}

json_out(['message' => 'Thank you, ' . $d['name'] . '! We will confirm your appointment shortly.']);
