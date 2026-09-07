<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Legacy admin helpers (Add_blog / old admin modules).
 */
if (!function_exists('adminlogincheck')) {
	/**
	 * Define ADMINURL and optional auth later.
	 */
	function adminlogincheck()
	{
		if (defined('ADMINURL')) {
			return;
		}
		$CI =& get_instance();
		$base = $CI->config->slash_item('base_url');
		$idx = $CI->config->item('index_page');
		define('ADMINURL', $base . ($idx !== '' ? $idx . '/' : ''));
		// TODO: redirect to login if not authenticated
	}
}

if (!function_exists('seourl')) {
	/**
	 * Simple slug helper for blog URLs.
	 */
	function seourl($str)
	{
		$str = trim((string) $str);
		$str = preg_replace('/[^a-z0-9]+/i', '-', $str);
		return strtolower(trim($str, '-'));
	}
}

if (!function_exists('sview')) {
	/**
	 * Load inner view inside admin shell (admin/admin.php).
	 */
	function sview($view, $data = array())
	{
		$CI =& get_instance();
		adminlogincheck();
		$CI->load->view('admin/admin', array('view' => $view, 'data' => $data));
	}
}
