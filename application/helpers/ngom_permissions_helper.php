<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NGO role permissions (admin_users.role).
 * Roles: super_admin, admin, manager, coordinator, member
 */
if (!function_exists('ngom_roles')) {
	function ngom_roles()
	{
		return array('super_admin', 'admin', 'member');
	}
}

if (!function_exists('ngom_can_edit_site_cms')) {
	function ngom_can_edit_site_cms($role)
	{
		return in_array((string) $role, array('super_admin', 'admin'), true);
	}
}

if (!function_exists('ngom_can_generate_member_pdfs')) {
	function ngom_can_generate_member_pdfs($role)
	{
		return in_array((string) $role, array('super_admin', 'admin'), true);
	}
}

if (!function_exists('ngom_can_add_members')) {
	function ngom_can_add_members($role)
	{
		return in_array((string) $role, array('super_admin', 'admin'), true);
	}
}

if (!function_exists('ngom_coordinator_requires_referral')) {
	function ngom_coordinator_requires_referral($role)
	{
		return ((string) $role) === 'coordinator';
	}
}

if (!function_exists('ngom_can_view_ngom_reports')) {
	function ngom_can_view_ngom_reports($role)
	{
		return in_array((string) $role, array('super_admin', 'admin'), true);
	}
}

if (!function_exists('ngom_can_manage_ngom_content')) {
	function ngom_can_manage_ngom_content($role)
	{
		return in_array((string) $role, array('super_admin', 'admin'), true);
	}
}

if (!function_exists('ngom_log_activity')) {
	function ngom_log_activity($action, $detail = '')
	{
		$CI =& get_instance();
		if (!isset($CI->session)) {
			$CI->load->library('session');
		}
		$uid = (int) $CI->session->userdata('cms_admin_id');
		if ($uid < 1 || !$CI->db->table_exists('ngom_admin_activity')) {
			return;
		}
		$CI->db->insert('ngom_admin_activity', array(
			'admin_user_id' => $uid,
			'action' => substr((string) $action, 0, 64),
			'detail' => $detail !== '' ? substr((string) $detail, 0, 500) : null,
		));
	}
}
