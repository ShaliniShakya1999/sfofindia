<?php
/**
 * Run once: NGO Step 1 tables (members, donations).
 * Usage: php application/db/install_ngom.php
 */
define('BASEPATH', true);
if (!defined('ENVIRONMENT')) {
	define('ENVIRONMENT', 'development');
}
require __DIR__ . '/../config/database.php';

$c = $db['default'];
$mysqli = @new mysqli($c['hostname'], $c['username'], $c['password'], $c['database'], isset($c['port']) ? (int) $c['port'] : 3306);
if ($mysqli->connect_errno) {
	fwrite(STDERR, 'DB connect failed: ' . $mysqli->connect_error . PHP_EOL);
	exit(1);
}
$mysqli->set_charset($c['char_set']);

$sql = file_get_contents(__DIR__ . '/ngom_modules.sql');
if (!$mysqli->multi_query($sql)) {
	fwrite(STDERR, 'SQL error: ' . $mysqli->error . PHP_EOL);
	exit(1);
}
while ($mysqli->more_results() && $mysqli->next_result()) {
}

echo 'NGO modules installed (members, donations).' . PHP_EOL;
