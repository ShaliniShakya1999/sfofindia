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
		if (!$this->table_exists() || $member_user_id === '') {
			return null;
		}
		$q = $this->db->get_where('members', array('member_user_id' => $member_user_id), 1);
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
		$prefix = 'NGO';
		$year = date('Y');
		$pattern = $prefix . '-' . $year . '-%';
		
		$this->db->select('member_id_code');
		$this->db->like('member_id_code', $prefix . '-' . $year . '-', 'after');
		$this->db->order_by('member_id_code', 'DESC');
		$this->db->limit(1);
		$row = $this->db->get('members')->row_array();
		
		$last_serial = 0;
		if ($row && !empty($row['member_id_code'])) {
			$parts = explode('-', $row['member_id_code']);
			$last_serial = (int) end($parts);
		}
		
		$next_serial = str_pad((string)($last_serial + 1), 4, '0', STR_PAD_LEFT);
		return $prefix . '-' . $year . '-' . $next_serial;
	}

	public function insert_member($data)
	{
		if (!$this->table_exists()) {
			return false;
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
}
