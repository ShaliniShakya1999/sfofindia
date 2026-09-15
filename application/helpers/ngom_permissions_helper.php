<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NGO role permissions (admin_users.role).
 * Roles: super_admin, admin, manager, coordinator, member
 */
if (!function_exists('ngom_roles')) {
	function ngom_roles()
	{
		return array('super_admin', 'admin', 'manager', 'coordinator', 'member');
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
		$activity = array(
			'admin_user_id' => $uid,
			'action' => substr((string) $action, 0, 64),
			'detail' => $detail !== '' ? substr((string) $detail, 0, 500) : null,
		);
		if ($CI->db->field_exists('ip_address', 'ngom_admin_activity')) {
			$activity['ip_address'] = substr((string) $CI->input->ip_address(), 0, 45);
		}
		if ($CI->db->field_exists('user_agent', 'ngom_admin_activity')) {
			$activity['user_agent'] = substr((string) $CI->input->user_agent(), 0, 255);
		}
		$CI->db->insert('ngom_admin_activity', $activity);
	}
}

if (!function_exists('ngom_notify')) {
	/**
	 * Fires a system notification into the admin "Notifications" inbox
	 * (Notifications controller / ngom_notifications table).
	 *
	 * @param string      $title   Short headline, e.g. "New Membership Application"
	 * @param string      $message Body text shown under the headline
	 * @param string      $type    info|success|warning|danger — drives the icon/color in the UI
	 * @param string|null $link    Optional relative admin URL (e.g. "members?status=pending")
	 */
	function ngom_notify($title, $message = '', $type = 'info', $link = null)
	{
		$CI =& get_instance();
		$CI->load->database();

		if (!$CI->db->table_exists('ngom_notifications')) {
			$CI->db->query("CREATE TABLE IF NOT EXISTS `ngom_notifications` (
				`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				`type` VARCHAR(16) NOT NULL DEFAULT 'info',
				`title` VARCHAR(191) NOT NULL,
				`message` TEXT NULL,
				`link` VARCHAR(255) NULL,
				`is_read` TINYINT(1) NOT NULL DEFAULT 0,
				`created_at` DATETIME NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		}

		$allowed_types = array('info', 'success', 'warning', 'danger');
		if (!in_array($type, $allowed_types, true)) {
			$type = 'info';
		}

		$notification = array(
			'type'       => $type,
			'title'      => substr((string) $title, 0, 191),
			'message'    => $message !== '' ? substr((string) $message, 0, 2000) : null,
			'is_read'    => 0,
			'created_at' => date('Y-m-d H:i:s'),
		);
		if ($CI->db->field_exists('link', 'ngom_notifications')) {
			$notification['link'] = $link ? substr((string) $link, 0, 255) : null;
		}
		if (!$CI->db->insert('ngom_notifications', $notification)) {
			log_message('error', 'Notification insert failed: ' . ($CI->db->error()['message'] ?? 'unknown database error'));
			return false;
		}
		return true;
	}
}
