<?php
/**
 * Router script for PHP built-in server.
 *
 * Run:
 *   php -S 127.0.0.1:8000 router.php
 */

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$fullPath = __DIR__ . $path;

// Never execute arbitrary PHP files directly through the development server.
if ($path !== '/index.php' && preg_match('/\.php$/i', (string) $path)) {
    http_response_code(404);
    exit;
}

// Member uploads contain identity documents and must never be served directly.
if (preg_match('#^/uploads/members(?:/|$)#i', (string) $path)) {
    http_response_code(404);
    exit;
}

// Serve existing files/directories as-is (assets, images, etc.)
if ($path !== '/' && (is_file($fullPath) || is_dir($fullPath))) {
    return false;
}

require __DIR__ . '/index.php';
