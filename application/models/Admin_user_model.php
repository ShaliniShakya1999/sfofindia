<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user_model extends CI_Model {

	/** @var list<string> */
	public static $roles = array('super_admin', 'admin', 'member');

	public function find_by_username($username)
	{
		if (!$this->db->table_exists('admin_users')) {
			return null;
		}
		$q = $this->db->get_where('admin_users', array('username' => $username), 1);
		$row = $q->row_array();
		return $this->normalize_row($row);
	}

	public function find_by_id($id)
	{
		if (!$this->db->table_exists('admin_users')) {
			return null;
		}
		$q = $this->db->get_where('admin_users', array('id' => (int) $id), 1);
		$row = $q->row_array();
		return $this->normalize_row($row);
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	public function all_ordered()
	{
		if (!$this->db->table_exists('admin_users')) {
			return array();
		}
		$this->db->order_by('id', 'asc');
		$rows = $this->db->get('admin_users')->result_array();
		foreach ($rows as &$r) {
			$r = $this->normalize_row($r);
		}
		return $rows;
	}

	public function insert_user($username, $password_hash, $email, $role)
	{
		if (!$this->db->table_exists('admin_users')) {
			return false;
		}
		$role = $this->normalize_role($role);
		return $this->db->insert('admin_users', array(
			'username' => $username,
			'password_hash' => $password_hash,
			'email' => $email,
			'role' => $role,
		));
	}

	public function delete_by_id($id)
	{
		if (!$this->db->table_exists('admin_users')) {
			return false;
		}
		$this->db->where('id', (int) $id);
		return $this->db->delete('admin_users');
	}

	public function update_password($id, $password_hash)
	{
		if (!$this->db->table_exists('admin_users')) {
			return false;
		}
		$this->db->where('id', (int) $id);
		return $this->db->update('admin_users', array('password_hash' => $password_hash));
	}

	public function update_role($id, $role)
	{
		if (!$this->db->table_exists('admin_users')) {
			return false;
		}
		$role = $this->normalize_role($role);
		$this->db->where('id', (int) $id);
		return $this->db->update('admin_users', array('role' => $role));
	}

	/**
	 * @param array<string,mixed>|null $row
	 * @return array<string,mixed>|null
	 */
	private function normalize_row($row)
	{
		if (!is_array($row)) {
			return null;
		}
		if (!isset($row['role']) || $row['role'] === '') {
			$row['role'] = 'admin';
		}
		return $row;
	}

	private function normalize_role($role)
	{
		$r = strtolower(trim((string) $role));
		return in_array($r, self::$roles, true) ? $r : 'member';
	}
}
