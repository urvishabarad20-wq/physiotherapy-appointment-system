<?php
// Admin bootstrap
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config.php';

function is_admin_logged_in(): bool {
    return isset($_SESSION['admin_username']) && is_string($_SESSION['admin_username']) && $_SESSION['admin_username'] !== '';
}

function require_admin(): void {
    if (!is_admin_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string {
    if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token']) || $_SESSION['csrf_token'] === '') {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf_token'];
}

function csrf_verify(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        echo "Invalid CSRF token.";
        exit();
    }
}

