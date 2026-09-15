<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('cms_val')) {
	/**
	 * Read a CMS field from the $cms array passed into views.
	 */
	function cms_val($cms, $key, $default = '')
	{
		if (!is_array($cms)) {
			return $default;
		}
		if (!isset($cms[$key]) || $cms[$key] === '') {
			return $default;
		}
		return $cms[$key];
	}
}

if (!function_exists('cms_session_role')) {
	/**
	 * Current CMS user role (requires session + login). Defaults to admin if missing.
	 */
	function cms_session_role()
	{
		$CI =& get_instance();
		if (!isset($CI->session)) {
			$CI->load->library('session');
		}
		if (!$CI->session->userdata('cms_admin_id')) {
			return '';
		}
		$r = $CI->session->userdata('cms_admin_role');
		return ($r !== null && $r !== '') ? (string) $r : 'admin';
	}
}

if (!function_exists('cms_web_hide_repeater_sidebar')) {
	/**
	 * NGO member role: hide left "title" column (repeater sidebar) on public website.
	 */
	function cms_web_hide_repeater_sidebar()
	{
		return cms_session_role() === 'member';
	}
}

if (!function_exists('cms_page_override')) {
	/**
	 * If CMS has custom HTML for this page key, render it and return true (skip default layout).
	 */
	function cms_page_override($cms, $key)
	{
		if (!is_array($cms) || !isset($cms[$key]) || trim((string) $cms[$key]) === '') {
			return false;
		}
		echo '<div class="container-fluid py-5"><div class="container cms-page-html">'.$cms[$key].'</div></div>';
		return true;
	}
}
if (!function_exists('ngom_send_email')) {
	/**
	 * Send email using stored SMTP settings.
	 */
	function ngom_send_email($to, $subject, $message)
	{
		$CI =& get_instance();
		$CI->load->library('Ngom_mailer', array(), 'ngommailer');
		return $CI->ngommailer->send_html($to, $subject, $message);
	}
}
