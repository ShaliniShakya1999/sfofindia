<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Root-relative asset path for the public site (css/js/img/lib).
 * Use for any href/src that must work on both /ngoweb/ and /ngoweb/some-page.
 * Leaves absolute http(s) URLs and root-absolute paths unchanged.
 */
if (!function_exists('web_asset')) {
	function web_asset($path)
	{
		$path = trim((string) $path);
		if ($path === '') {
			return '';
		}
		if (preg_match('#^https?://#i', $path)) {
			return str_replace('http://sfofindia.org', 'https://sfofindia.org', $path);
		}
		if (isset($path[0]) && $path[0] === '/') {
			return $path;
		}
		$path = ltrim($path, '/');

		// Public theme assets live under assetsW/, while uploads stay at root.
		if (preg_match('#^(css|js|img|lib)/#i', $path)) {
			$url = base_url('assetsW/' . $path);
		} else {
			$url = base_url($path);
		}

		// Force HTTPS on production
		return str_replace('http://sfofindia.org', 'https://sfofindia.org', $url);
	}
}

/**
 * Legacy static .php links -> CodeIgniter routes (see routes.php + Welcome::_remap).
 */
if (!function_exists('web_link')) {
	function web_link($path)
	{
		$path = trim((string) $path);
		$path = preg_replace('/\.php$/i', '', $path);
		if ($path === '' || strcasecmp($path, 'index') === 0) {
			return base_url();
		}
		$legacy = array(
			'privacy_Policy' => 'privacy_policy',
			'legal_Compliance' => 'legal_compliance',
			'refund_Policy' => 'refund_policy',
		);
		if (isset($legacy[$path])) {
			$path = $legacy[$path];
		}
		return site_url($path);
	}
}
