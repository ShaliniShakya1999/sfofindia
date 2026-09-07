<?php
/**
 * Router script for PHP built-in server.
 *
 * Run:
 *   php -S 127.0.0.1:8000 router.php
 */

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$fullPath = __DIR__ . $path;

// Serve existing files/directories as-is (assets, images, etc.)
if ($path !== '/' && (is_file($fullPath) || is_dir($fullPath))) {
    return false;
}

require __DIR__ . '/index.php';

