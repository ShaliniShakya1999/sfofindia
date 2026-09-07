<?php
/**
 * Run once: creates CMS tables + default admin (admin / admin123).
 * Usage: php application/db/install_cms.php
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

$sql = file_get_contents(__DIR__ . '/cms_install.sql');
if (!$mysqli->multi_query($sql)) {
	fwrite(STDERR, 'SQL error: ' . $mysqli->error . PHP_EOL);
	exit(1);
}
while ($mysqli->more_results() && $mysqli->next_result()) {
	// flush
}

$r = $mysqli->query("SHOW COLUMNS FROM `admin_users` LIKE 'role'");
if ($r && $r->num_rows === 0) {
	$mysqli->query("ALTER TABLE `admin_users` ADD COLUMN `role` VARCHAR(32) NOT NULL DEFAULT 'admin' AFTER `password_hash`");
}
$mysqli->query("UPDATE `admin_users` SET `role`='super_admin' WHERE `username`='admin' AND (`role`='' OR `role`='admin')");

echo 'CMS tables installed. Login: admin / admin123 (change password in DB after login).' . PHP_EOL;
