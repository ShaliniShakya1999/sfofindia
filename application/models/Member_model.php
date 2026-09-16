<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}


	public function table_exists()
	{
		return $this->db->table_exists('members');
	}

	public function ensure_extended_schema()
	{
		if (ENVIRONMENT === 'production' && getenv('SFOF_ALLOW_RUNTIME_SCHEMA') !== 'true') {
			return false;
		}
		if (!$this->table_exists()) {
			return false;
		}

		$columns = array(
			'gender' => "ALTER TABLE `members` ADD COLUMN `gender` VARCHAR(16) NULL AFTER `name`",
			'dob' => "ALTER TABLE `members` ADD COLUMN `dob` DATE NULL AFTER `gender`",
			'relation_type' => "ALTER TABLE `members` ADD COLUMN `relation_type` VARCHAR(16) NULL AFTER `dob`",
			'relation_name' => "ALTER TABLE `members` ADD COLUMN `relation_name` VARCHAR(191) NULL AFTER `relation_type`",
			'profession' => "ALTER TABLE `members` ADD COLUMN `profession` VARCHAR(100) NULL AFTER `relation_name`",
			'blood_group' => "ALTER TABLE `members` ADD COLUMN `blood_group` VARCHAR(16) NULL AFTER `profession`",
			'state' => "ALTER TABLE `members` ADD COLUMN `state` VARCHAR(100) NULL AFTER `blood_group`",
			'district' => "ALTER TABLE `members` ADD COLUMN `district` VARCHAR(100) NULL AFTER `state`",
			'aadhar_no' => "ALTER TABLE `members` ADD COLUMN `aadhar_no` VARCHAR(32) NULL AFTER `district`",
			'address' => "ALTER TABLE `members` ADD COLUMN `address` TEXT NULL AFTER `aadhar_no`",
			'pin_code' => "ALTER TABLE `members` ADD COLUMN `pin_code` VARCHAR(16) NULL AFTER `address`",
			'id_type' => "ALTER TABLE `members` ADD COLUMN `id_type` VARCHAR(64) NULL AFTER `pin_code`",
			'id_document' => "ALTER TABLE `members` ADD COLUMN `id_document` VARCHAR(255) NULL AFTER `id_type`",
			'other_document' => "ALTER TABLE `members` ADD COLUMN `other_document` VARCHAR(255) NULL AFTER `id_document`",
			'authority' => "ALTER TABLE `members` ADD COLUMN `authority` VARCHAR(191) NULL AFTER `other_document`",
			'validity_start' => "ALTER TABLE `members` ADD COLUMN `validity_start` DATE NULL AFTER `authority`",
			'validity_end' => "ALTER TABLE `members` ADD COLUMN `validity_end` DATE NULL AFTER `validity_start`",
			'payment_mode' => "ALTER TABLE `members` ADD COLUMN `payment_mode` VARCHAR(64) NULL AFTER `validity_end`",
			'payment_receipt' => "ALTER TABLE `members` ADD COLUMN `payment_receipt` VARCHAR(255) NULL AFTER `payment_mode`",
			'member_user_id' => "ALTER TABLE `members` ADD COLUMN `member_user_id` VARCHAR(64) NULL AFTER `payment_receipt`",
			'member_password_hash' => "ALTER TABLE `members` ADD COLUMN `member_password_hash` VARCHAR(255) NULL AFTER `member_user_id`",
			'member_id_code' => "ALTER TABLE `members` ADD COLUMN `member_id_code` VARCHAR(32) NULL UNIQUE AFTER `member_password_hash`",
			'achievements' => "ALTER TABLE `members` ADD COLUMN `achievements` TEXT NULL AFTER `member_id_code`",
			'verified_at' => "ALTER TABLE `members` ADD COLUMN `verified_at` DATETIME NULL AFTER `achievements`",
			'verified_by' => "ALTER TABLE `members` ADD COLUMN `verified_by` INT UNSIGNED NULL AFTER `verified_at`",
			'aadhar_verified' => "ALTER TABLE `members` ADD COLUMN `aadhar_verified` TINYINT(1) DEFAULT 0 AFTER `aadhar_no`",
			'aadhar_data' => "ALTER TABLE `members` ADD COLUMN `aadhar_data` TEXT NULL AFTER `aadhar_verified`",
			'aadhar_front' => "ALTER TABLE `members` ADD COLUMN `aadhar_front` VARCHAR(255) NULL AFTER `aadhar_data`",
			'aadhar_back' => "ALTER TABLE `members` ADD COLUMN `aadhar_back` VARCHAR(255) NULL AFTER `aadhar_front`",
			'donation_amount' => "ALTER TABLE `members` ADD COLUMN `donation_amount` DECIMAL(10,2) DEFAULT 0.00 AFTER `aadhar_back`",
			'join_source' => "ALTER TABLE `members` ADD COLUMN `join_source` VARCHAR(64) NULL AFTER `added_by`",
			'last_birthday_wish_year' => "ALTER TABLE `members` ADD COLUMN `last_birthday_wish_year` INT NULL",
			'last_renewal_reminder_date' => "ALTER TABLE `members` ADD COLUMN `last_renewal_reminder_date` DATE NULL",
			'id_card_sent' => "ALTER TABLE `members` ADD COLUMN `id_card_sent` TINYINT(1) DEFAULT 0",
		);

		foreach ($columns as $field => $sql) {
			if (!$this->db->field_exists($field, 'members')) {
				$this->db->query($sql);
			}
		}

		// Ensure index on email for quick uniqueness checks
		try {
			$idx_check = $this->db->query("SHOW INDEX FROM `members` WHERE Key_name = 'idx_email'")->num_rows();
			if ($idx_check === 0 && $this->db->field_exists('email', 'members')) {
				$this->db->query("ALTER TABLE `members` ADD INDEX `idx_email` (`email`)");
			}
		} catch (Throwable $e) {
			// Ignore if index already exists or schema modification is restricted
		}

		return true;
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	public function search($filters = array())
	{
		if (!$this->table_exists()) {
			return array();
		}
		if (!empty($filters['date_from'])) {
			$this->db->where('joining_date >=', $filters['date_from']);
		}
		if (!empty($filters['date_to'])) {
			$this->db->where('joining_date <=', $filters['date_to']);
		}
		if (!empty($filters['status'])) {
			$this->db->where('status', $filters['status']);
		}
		if (!empty($filters['name'])) {
			$this->db->like('name', $filters['name']);
		}
		if (!empty($filters['mobile'])) {
			$this->db->like('mobile', $filters['mobile']);
		}
		if (!empty($filters['district']) && $this->db->field_exists('district', 'members')) {
			$this->db->like('district', $filters['district']);
		}
		if (!empty($filters['address']) && $this->db->field_exists('address', 'members')) {
			$this->db->like('address', $filters['address']);
		}
		if (!empty($filters['authority']) && $this->db->field_exists('authority', 'members')) {
			$this->db->like('authority', $filters['authority']);
		}
		if (!empty($filters['role'])) {
			$this->db->where('role', $filters['role']);
		}
		if (!empty($filters['manager_id'])) {
			$this->db->where('added_by', (int) $filters['manager_id']);
		}
		if (!empty($filters['coordinator_id'])) {
			$this->db->where('added_by', (int) $filters['coordinator_id']);
		}
		if (!empty($filters['q'])) {
			$q = $filters['q'];
			$this->db->group_start();
			$this->db->like('name', $q);
			$this->db->or_like('mobile', $q);
			$this->db->or_like('email', $q);
			$this->db->or_like('referral_code', $q);
			if ($this->db->field_exists('district', 'members')) {
				$this->db->or_like('district', $q);
			}
			if ($this->db->field_exists('state', 'members')) {
				$this->db->or_like('state', $q);
			}
			if ($this->db->field_exists('aadhar_no', 'members')) {
				$this->db->or_like('aadhar_no', $q);
			}
			$this->db->group_end();
		}
		$this->db->order_by('id', 'DESC');
		$rows = $this->db->get('members')->result_array();
		return is_array($rows) ? $rows : array();
	}

	public function count_all()
	{
		if (!$this->table_exists()) {
			return 0;
		}
		return (int) $this->db->count_all('members');
	}

	public function find_by_id($id)
	{
		if (!$this->table_exists()) {
			return null;
		}
		$q = $this->db->get_where('members', array('id' => (int) $id), 1);
		$r = $q->row_array();
		return $r ?: null;
	}

	public function find_by_public_id($public_id)
	{
		if (!$this->table_exists() || $public_id === '') {
			return null;
		}
		$q = $this->db->get_where('members', array('public_id' => $public_id), 1);
		$r = $q->row_array();
		return $r ?: null;
	}

	public function find_by_member_user_id($member_user_id)
	{
		return $this->find_by_identifier($member_user_id);
	}

	public function find_by_identifier($identifier)
	{
		if (!$this->table_exists() || trim((string) $identifier) === '') {
			return null;
		}
		$clean = trim((string) $identifier);
		$digits = preg_replace('/\D/', '', $clean);

		$this->db->group_start();
		$this->db->where('member_user_id', $clean);
		$this->db->or_where('email', $clean);
		$this->db->or_where('mobile', $clean);
		if ($this->db->field_exists('member_id_code', 'members')) {
			$this->db->or_where('member_id_code', $clean);
		}
		if (strlen($digits) >= 10) {
			$last10 = substr($digits, -10);
			$this->db->or_like('mobile', $last10);
		}
		$this->db->group_end();
		$q = $this->db->get('members', 1);
		$r = $q->row_array();
		return $r ?: null;
	}

	public function referral_exists($code, $exclude_id = null)
	{
		if (!$this->table_exists()) {
			return false;
		}
		$this->db->where('referral_code', $code);
		if ($exclude_id !== null) {
			$this->db->where('id !=', (int) $exclude_id);
		}
		return $this->db->count_all_results('members') > 0;
	}

	public function email_exists($email, $exclude_id = null)
	{
		if (!$this->table_exists()) {
			return false;
		}
		$clean = strtolower(trim((string) $email));
		if ($clean === '') {
			return false;
		}
		$this->db->where('LOWER(email)', $clean);
		if ($exclude_id !== null) {
			$this->db->where('id !=', (int) $exclude_id);
		}
		return $this->db->count_all_results('members') > 0;
	}

	public function find_by_email($email)
	{
		if (!$this->table_exists() || trim((string) $email) === '') {
			return null;
		}
		$clean = strtolower(trim((string) $email));
		$this->db->where('LOWER(email)', $clean);
		$q = $this->db->get('members', 1);
		$r = $q->row_array();
		return $r ?: null;
	}

	private function generate_public_id()
	{
		return bin2hex(random_bytes(16));
	}

	private function generate_referral_code()
	{
		$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		do {
			$s = '';
			for ($i = 0; $i < 8; $i++) {
				$s .= $chars[random_int(0, strlen($chars) - 1)];
			}
		} while ($this->referral_exists($s));
		return $s;
	}

	private function generate_member_id_code()
	{
		return 'NGO-' . date('Y') . '-' . strtoupper(bin2hex(random_bytes(4)));
	}

	public function insert_member($data)
	{
		if (!$this->table_exists()) {
			return false;
		}
		if (isset($data['email'])) {
			$data['email'] = strtolower(trim((string) $data['email']));
			if ($data['email'] !== '' && $this->email_exists($data['email'])) {
				return false;
			}
		}
		$data['public_id'] = $this->generate_public_id();
		if (empty($data['member_id_code'])) {
			$data['member_id_code'] = $this->generate_member_id_code();
		}
		if (empty($data['referral_code'])) {
			$data['referral_code'] = $this->generate_referral_code();
		} elseif ($this->referral_exists($data['referral_code'])) {
			return false;
		}
		return $this->db->insert('members', $data);
	}

	public function update_member($id, $data)
	{
		if (!$this->table_exists()) {
			return false;
		}
		if (isset($data['email'])) {
			$data['email'] = strtolower(trim((string) $data['email']));
			if ($data['email'] !== '' && $this->email_exists($data['email'], $id)) {
				return false;
			}
		}
		if (isset($data['referral_code'])) {
			if ($this->referral_exists($data['referral_code'], $id)) {
				return false;
			}
		}
		$this->db->where('id', (int) $id);
		return $this->db->update('members', $data);
	}

	public function delete_member($id)
	{
		if (!$this->table_exists()) {
			return false;
		}
		$this->db->where('id', (int) $id);
		return $this->db->delete('members');
	}

	/**
	 * Creates the member_renewals audit table if it doesn't exist yet.
	 * Mirrors the runtime-migration pattern used by ensure_extended_schema().
	 */
	public function ensure_renewals_table()
	{
		if (ENVIRONMENT === 'production' && getenv('SFOF_ALLOW_RUNTIME_SCHEMA') !== 'true') {
			return false;
		}
		if ($this->db->table_exists('member_renewals')) {
			return true;
		}
		$this->db->query("CREATE TABLE IF NOT EXISTS `member_renewals` (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`member_id` INT UNSIGNED NOT NULL,
			`amount` DECIMAL(10,2) NOT NULL,
			`currency` VARCHAR(8) NOT NULL DEFAULT 'INR',
			`razorpay_order_id` VARCHAR(64) NULL,
			`payment_id` VARCHAR(64) NULL UNIQUE,
			`signature_verified` TINYINT(1) DEFAULT 0,
			`old_validity_end` DATE NULL,
			`new_validity_end` DATE NULL,
			`created_at` DATETIME NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		return true;
	}

	public function find_renewal_by_payment_id($payment_id)
	{
		$this->ensure_renewals_table();
		$q = $this->db->get_where('member_renewals', array('payment_id' => (string) $payment_id), 1);
		$r = $q->row_array();
		return $r ?: null;
	}

	/**
	 * Records a verified renewal payment and applies it to the member record
	 * (activates the member and pushes validity_end forward).
	 */
	public function apply_renewal($member_id, $data)
	{
		$this->ensure_renewals_table();
		$member = $this->find_by_id($member_id);
		if (!$member) {
			return false;
		}

		$this->db->insert('member_renewals', array(
			'member_id'           => (int) $member_id,
			'amount'               => $data['amount'],
			'currency'             => 'INR',
			'razorpay_order_id'    => $data['razorpay_order_id'],
			'payment_id'           => $data['payment_id'],
			'signature_verified'   => 1,
			'old_validity_end'     => $member['validity_end'] ?? null,
			'new_validity_end'     => $data['new_validity_end'],
			'created_at'           => date('Y-m-d H:i:s'),
		));

		return $this->update_member($member_id, array(
			'status'          => 'active',
			'validity_end'    => $data['new_validity_end'],
			'payment_mode'    => 'online',
			'payment_receipt' => $data['payment_id'],
		));
	}

	/**
	 * Returns unified list of notifications belonging specifically to a member.
	 * Admin-access notifications (ngom_notifications) are strictly excluded.
	 *
	 * @param array $member
	 * @param int|null $limit
	 * @return array
	 */
	public function get_member_notifications($member, $limit = null)
	{
		if (empty($member) || !is_array($member)) {
			return array();
		}

		$notifications = array();

		// 1. Birthday greeting
		if (!empty($member['dob']) && $member['dob'] !== '0000-00-00') {
			if (date('m-d', strtotime($member['dob'])) === date('m-d')) {
				$notifications[] = array(
					'id'             => 'bday',
					'category'       => 'account',
					'category_label' => 'BIRTHDAY',
					'icon'           => 'cake',
					'color'          => '#f59e0b',
					'badge_bg'       => '#fef3c7',
					'title'          => 'Happy Birthday, ' . ($member['name'] ?? 'Member') . '! 🎂',
					'body'           => 'On behalf of Shaheed Foundation of India, we wish you a joyous, blessed, and victorious birthday!',
					'message'        => 'On behalf of Shaheed Foundation of India, we wish you a joyous, blessed, and victorious birthday!',
					'time'           => 'Today',
					'link'           => site_url('admin/profile'),
					'link_text'      => 'View Profile',
					'is_new'         => true,
					'is_read'        => 0,
					'sort_time'      => time() + 500,
					'created_at'     => date('Y-m-d H:i:s'),
				);
			}
		}

		// 2. Member Official E-ID Card
		$notifications[] = array(
			'id'             => 'doc_id_card',
			'category'       => 'account',
			'category_label' => 'E-IDENTITY CARD',
			'icon'           => 'badge',
			'color'          => '#0d9488',
			'badge_bg'       => '#ccfbf1',
			'title'          => 'Official Member E-Identity Card Ready',
			'body'           => 'Your authenticated Shaheed Foundation Identity Card is ready to download and print. Keep it with you during official foundation activities.',
			'message'        => 'Your authenticated Shaheed Foundation Identity Card is ready to download and print.',
			'time'           => 'Instant Access',
			'link'           => site_url('admin/member_document/id-card'),
			'link_text'      => 'Download ID Card',
			'is_new'         => false,
			'is_read'        => 1,
			'sort_time'      => strtotime($member['verified_at'] ?? ($member['joining_date'] ?? 'now')),
			'created_at'     => !empty($member['verified_at']) ? $member['verified_at'] : (!empty($member['joining_date']) ? $member['joining_date'] : date('Y-m-d H:i:s')),
		);

		// 3. Member Official Appointment Letter
		$notifications[] = array(
			'id'             => 'doc_appointment',
			'category'       => 'account',
			'category_label' => 'APPOINTMENT',
			'icon'           => 'assignment_turned_in',
			'color'          => '#2563eb',
			'badge_bg'       => '#dbeafe',
			'title'          => 'Member Appointment Letter Available',
			'body'           => 'Access your official appointment documentation confirming your role and volunteer authority.',
			'message'        => 'Access your official appointment documentation confirming your role and volunteer authority.',
			'time'           => 'Available',
			'link'           => site_url('admin/member_document/appointment-letter'),
			'link_text'      => 'View Appointment Letter',
			'is_new'         => false,
			'is_read'        => 1,
			'sort_time'      => strtotime($member['verified_at'] ?? ($member['joining_date'] ?? 'now')) - 10,
			'created_at'     => !empty($member['verified_at']) ? $member['verified_at'] : (!empty($member['joining_date']) ? $member['joining_date'] : date('Y-m-d H:i:s')),
		);

		// 4. Membership Profile Active & Verified
		$member_code = !empty($member['member_id_code']) ? $member['member_id_code'] : (!empty($member['member_user_id']) ? $member['member_user_id'] : 'MBR000' . $member['id']);
		$notifications[] = array(
			'id'             => 'account_verified',
			'category'       => 'account',
			'category_label' => 'MEMBERSHIP',
			'icon'           => 'verified',
			'color'          => '#1a685b',
			'badge_bg'       => '#e6f0ee',
			'title'          => 'Membership Profile Verified & Active',
			'body'           => 'Welcome to Shaheed Foundation of India! Your member ID is ' . $member_code . '. Thank you for standing with our nation\'s heroes.',
			'message'        => 'Welcome to Shaheed Foundation of India! Member ID: ' . $member_code,
			'time'           => !empty($member['verified_at']) ? date('d M Y', strtotime($member['verified_at'])) : (!empty($member['joining_date']) ? date('d M Y', strtotime($member['joining_date'])) : 'Recently'),
			'link'           => site_url('admin/profile'),
			'link_text'      => 'My Profile',
			'is_new'         => false,
			'is_read'        => 1,
			'sort_time'      => strtotime($member['verified_at'] ?? ($member['joining_date'] ?? 'now')) - 20,
			'created_at'     => !empty($member['verified_at']) ? $member['verified_at'] : (!empty($member['joining_date']) ? $member['joining_date'] : date('Y-m-d H:i:s')),
		);

		// 5. Membership Validity / Renewal Alert
		if (!empty($member['validity_end'])) {
			$v_end = strtotime($member['validity_end']);
			if ($v_end < time()) {
				$notifications[] = array(
					'id'             => 'validity_alert',
					'category'       => 'account',
					'category_label' => 'ACTION REQUIRED',
					'icon'           => 'warning',
					'color'          => '#dc2626',
					'badge_bg'       => '#fee2e2',
					'title'          => 'Membership Renewal Required',
					'body'           => 'Your membership expired on ' . date('d M Y', $v_end) . '. Renew your membership now to continue accessing benefits.',
					'message'        => 'Your membership expired on ' . date('d M Y', $v_end) . '. Renew now to continue accessing benefits.',
					'time'           => 'Expired',
					'link'           => site_url('admin/renew'),
					'link_text'      => 'Renew Membership',
					'is_new'         => true,
					'is_read'        => 0,
					'sort_time'      => time() + 1000,
					'created_at'     => date('Y-m-d H:i:s'),
				);
			} else {
				$days_left = ceil(($v_end - time()) / 86400);
				$notifications[] = array(
					'id'             => 'validity_notice',
					'category'       => 'account',
					'category_label' => 'VALIDITY',
					'icon'           => 'verified_user',
					'color'          => '#0284c7',
					'badge_bg'       => '#e0f2fe',
					'title'          => 'Membership Valid (' . $days_left . ' days remaining)',
					'body'           => 'Your annual membership is active and valid until ' . date('d M Y', $v_end) . '.',
					'message'        => 'Annual membership active and valid until ' . date('d M Y', $v_end) . '.',
					'time'           => 'Until ' . date('d M Y', $v_end),
					'link'           => site_url('admin/profile'),
					'link_text'      => 'View Details',
					'is_new'         => false,
					'is_read'        => 1,
					'sort_time'      => $v_end - (300 * 86400),
					'created_at'     => $member['validity_start'] ?? date('Y-m-d H:i:s'),
				);
			}
		}

		// 6. Member's Own Donations (Strictly belonging to this member's email)
		$email = isset($member['email']) ? trim($member['email']) : '';
		if ($email !== '' && $this->db->table_exists('donations')) {
			$this->db->where('email', $email);
			$this->db->where('status', 'paid');
			$this->db->order_by('id', 'DESC');
			$recent_donations = $this->db->get('donations', 10)->result_array();
			foreach ($recent_donations as $don) {
				$don_amt = '₹' . number_format((float)$don['amount'], 2);
				$is_new_don = (time() - strtotime($don['created_at'])) < 86400 * 7;
				$notifications[] = array(
					'id'             => 'don_' . $don['id'],
					'category'       => 'donations',
					'category_label' => 'DONATION',
					'icon'           => 'payments',
					'color'          => '#16a34a',
					'badge_bg'       => '#dcfce7',
					'title'          => 'Donation Contribution Received (' . $don_amt . ')',
					'body'           => 'Your contribution of ' . $don_amt . ' was received successfully. Receipt No: ' . $don['receipt_no'] . '. Thank you for supporting our welfare programs!',
					'message'        => 'Your contribution of ' . $don_amt . ' received. Receipt #' . $don['receipt_no'],
					'time'           => date('d M Y, h:i A', strtotime($don['created_at'])),
					'link'           => site_url('admin/donation_history'),
					'link_text'      => 'Donation History',
					'is_new'         => $is_new_don,
					'is_read'        => $is_new_don ? 0 : 1,
					'sort_time'      => strtotime($don['created_at']),
					'created_at'     => $don['created_at'],
				);
			}
		}

		// 7. Active Causes & Fundraising Campaigns (Beneficial for members)
		if ($this->db->table_exists('ngom_campaigns')) {
			$this->db->where('status', 'active');
			$this->db->order_by('id', 'DESC');
			$campaigns = $this->db->get('ngom_campaigns', 5)->result_array();
			foreach ($campaigns as $camp) {
				$goal_txt = !empty($camp['goal_amount']) ? '₹' . number_format((float)$camp['goal_amount'], 0) : 'Fundraising Goal';
				$raised_txt = !empty($camp['raised_display']) ? $camp['raised_display'] : 'Active';
				$raw_desc = strip_tags($camp['description'] ?? '');
				$short_desc = mb_substr($raw_desc, 0, 130);
				if (mb_strlen($raw_desc) > 130) $short_desc .= '...';

				$created_ts = !empty($camp['created_at']) ? strtotime($camp['created_at']) : time();
				$is_new_camp = (time() - $created_ts) < (86400 * 14);

				$notifications[] = array(
					'id'             => 'camp_' . $camp['id'],
					'category'       => 'campaigns',
					'category_label' => 'NEW CAMPAIGN',
					'icon'           => 'volunteer_activism',
					'color'          => '#f59e0b',
					'badge_bg'       => '#fef3c7',
					'title'          => 'Active Cause: ' . $camp['title'],
					'body'           => 'Target: ' . $goal_txt . ' (Raised: ' . $raised_txt . ') • ' . $short_desc,
					'message'        => 'Target: ' . $goal_txt . ' (Raised: ' . $raised_txt . ')',
					'time'           => !empty($camp['created_at']) ? date('d M Y', strtotime($camp['created_at'])) : 'Active Initiative',
					'link'           => site_url('admin/campaigns'),
					'link_text'      => 'Support Campaign',
					'is_new'         => $is_new_camp,
					'is_read'        => $is_new_camp ? 0 : 1,
					'sort_time'      => $created_ts,
					'created_at'     => !empty($camp['created_at']) ? $camp['created_at'] : date('Y-m-d H:i:s'),
				);
			}
		}

		// 8. Upcoming Foundation Events & Programs (Beneficial for members)
		if ($this->db->table_exists('ngom_events')) {
			$this->db->order_by('event_date', 'ASC');
			$events = $this->db->get('ngom_events', 5)->result_array();
			foreach ($events as $evt) {
				$event_date_txt = !empty($evt['event_date']) ? date('d M Y', strtotime($evt['event_date'])) : 'Upcoming';
				$raw_body = strip_tags($evt['body'] ?? '');
				$short_body = mb_substr($raw_body, 0, 130);
				if (mb_strlen($raw_body) > 130) $short_body .= '...';

				$evt_ts = !empty($evt['event_date']) ? strtotime($evt['event_date']) : time();
				$is_upcoming = $evt_ts >= (time() - 86400);

				$notifications[] = array(
					'id'             => 'evt_' . $evt['id'],
					'category'       => 'events',
					'category_label' => 'UPCOMING EVENT',
					'icon'           => 'event_available',
					'color'          => '#6366f1',
					'badge_bg'       => '#ede9fe',
					'title'          => 'Program Scheduled: ' . $evt['title'],
					'body'           => 'Date: ' . $event_date_txt . ' • ' . $short_body,
					'message'        => 'Date: ' . $event_date_txt . ' • ' . $short_body,
					'time'           => $event_date_txt,
					'link'           => site_url('admin/events'),
					'link_text'      => 'Event Details',
					'is_new'         => $is_upcoming,
					'is_read'        => $is_upcoming ? 0 : 1,
					'sort_time'      => $evt_ts,
					'created_at'     => !empty($evt['created_at']) ? $evt['created_at'] : date('Y-m-d H:i:s'),
				);
			}
		}

		// 9. Latest Foundation Announcements & Blog Articles (Beneficial for members)
		if ($this->db->table_exists('blog')) {
			$this->db->where('status', 'Active');
			$this->db->order_by('id', 'DESC');
			$articles = $this->db->get('blog', 5)->result_array();
			foreach ($articles as $art) {
				$art_date = !empty($art['postedDate']) ? date('d M Y', strtotime($art['postedDate'])) : (!empty($art['creationDate']) ? date('d M Y', strtotime($art['creationDate'])) : 'Recent');
				$raw_text = strip_tags($art['description'] ?? ($art['heading'] ?? ''));
				$short_text = mb_substr($raw_text, 0, 130);
				if (mb_strlen($raw_text) > 130) $short_text .= '...';

				$art_ts = !empty($art['creationDate']) ? strtotime($art['creationDate']) : time();
				$is_new_art = (time() - $art_ts) < (86400 * 14);

				$notifications[] = array(
					'id'             => 'blog_' . $art['id'],
					'category'       => 'updates',
					'category_label' => 'ANNOUNCEMENT',
					'icon'           => 'newspaper',
					'color'          => '#0891b2',
					'badge_bg'       => '#cffafe',
					'title'          => 'Foundation News: ' . $art['title'],
					'body'           => $short_text,
					'message'        => $short_text,
					'time'           => $art_date,
					'link'           => site_url('blog/' . ($art['slug'] ?? $art['id'])),
					'link_text'      => 'Read Article',
					'is_new'         => $is_new_art,
					'is_read'        => $is_new_art ? 0 : 1,
					'sort_time'      => $art_ts,
					'created_at'     => !empty($art['creationDate']) ? $art['creationDate'] : date('Y-m-d H:i:s'),
				);
			}
		}

		// STRICT PRIVACY: ngom_notifications (admin system alerts) is excluded.
		// Admin alerts like "New Member Registered" or general donations are NEVER shown to members.

		// Sort all chronologically descending
		usort($notifications, function($a, $b) {
			return ($b['sort_time'] ?? 0) <=> ($a['sort_time'] ?? 0);
		});

		if ($limit !== null && $limit > 0) {
			return array_slice($notifications, 0, $limit);
		}

		return $notifications;
	}
}

