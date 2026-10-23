<?php
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
    session_start();
}

/** Escapa texto para HTML. */
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

/** Conexão PDO (null em modo demo). */
function db(): ?PDO {
    static $pdo = null;
    if (DEMO_MODE) return null;
    if (!$pdo) {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

/**
 * Lê uma lista (services, team, gallery, reviews, bookings).
 * Com banco: SELECT * FROM <tabela>. Sem banco: dados de demonstração.
 */
function get_list(string $table): array {
    static $demo = null;
    if ($pdo = db()) {
        $allowed = ['services', 'team', 'gallery', 'reviews', 'bookings'];
        if (!in_array($table, $allowed, true)) return [];
        return $pdo->query("SELECT * FROM `$table` ORDER BY id")->fetchAll();
    }
    $demo ??= require __DIR__ . '/demo-data.php';
    return $demo[$table] ?? [];
}

/** Token CSRF para formulários e chamadas AJAX. */
function csrf_token(): string {
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}
function csrf_check(?string $t): bool {
    return $t && isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $t);
}

/** Bloqueia páginas do admin para quem não está logado. */
function require_admin(): void {
    if (empty($_SESSION['is_admin'])) {
        header('Location: login.php');
        exit;
    }
}

function json_out(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}
