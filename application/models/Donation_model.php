<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donation_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function table_exists()
	{
		return $this->db->table_exists('donations');
	}

	public function insert_pending($row)
	{
		if (!$this->table_exists()) {
			return false;
		}
		return $this->db->insert('donations', $row);
	}

	public function find_by_payment_id($payment_id)
	{
		if (!$this->table_exists() || $payment_id === '') {
			return null;
		}
		$q = $this->db->get_where('donations', array('payment_id' => $payment_id), 1);
		$r = $q->row_array();
		return $r ?: null;
	}

	public function find_by_id($id)
	{
		if (!$this->table_exists()) {
			return null;
		}
		$q = $this->db->get_where('donations', array('id' => (int) $id), 1);
		$r = $q->row_array();
		return $r ?: null;
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	public function list_all($limit = 500)
	{
		if (!$this->table_exists()) {
			return array();
		}
		$this->db->order_by('id', 'DESC');
		$this->db->limit((int) $limit);
		$rows = $this->db->get('donations')->result_array();
		return is_array($rows) ? $rows : array();
	}

	public function count_all()
	{
		if (!$this->table_exists()) {
			return 0;
		}
		return (int) $this->db->count_all('donations');
	}

	public function sum_amount_success()
	{
		if (!$this->table_exists()) {
			return 0.0;
		}
		$this->db->select_sum('amount');
		$this->db->where('status', 'paid');
		$q = $this->db->get('donations');
		$row = $q->row_array();
		return isset($row['amount']) ? (float) $row['amount'] : 0.0;
	}

	public function next_receipt_no()
	{
		if (!$this->table_exists()) {
			return 'RCP-' . date('Y') . '-00001';
		}
		$prefix = 'RCP-' . date('Y') . '-';
		$this->db->like('receipt_no', $prefix, 'after');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$last = $this->db->get('donations')->row_array();
		$n = 1;
		if (!empty($last['receipt_no']) && preg_match('/-(\d+)$/', $last['receipt_no'], $m)) {
			$n = (int) $m[1] + 1;
		}
		return $prefix . str_pad((string) $n, 5, '0', STR_PAD_LEFT);
	}

	public function update_by_id($id, $data)
	{
		if (!$this->table_exists()) {
			return false;
		}
		$this->db->where('id', (int) $id);
		return $this->db->update('donations', $data);
	}

	public function list_by_email($email, $limit = 100)
	{
		if (!$this->table_exists() || $email === '') return array();
		$this->db->where('email', $email);
		$this->db->order_by('id', 'DESC');
		$this->db->limit($limit);
		return $this->db->get('donations')->result_array();
	}

	public function get_stats_by_email($email)
	{
		if (!$this->table_exists() || $email === '') return array('total_amount' => 0, 'count' => 0);
		$this->db->select_sum('amount');
		$this->db->select('count(*) as count');
		$this->db->where('email', $email);
		$this->db->where('status', 'paid');
		$row = $this->db->get('donations')->row_array();
		return array(
			'total_amount' => (float) ($row['amount'] ?? 0),
			'count' => (int) ($row['count'] ?? 0)
		);
	}
}
