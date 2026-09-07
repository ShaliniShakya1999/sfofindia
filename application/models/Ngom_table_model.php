<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Generic CRUD for ngom_* tables (events, gallery, projects, campaigns, audit_reports).
 */
class Ngom_table_model extends CI_Model {

	/** @var array<string,list<string>> */
	private $allowed = array(
		'ngom_events' => array('title', 'slug', 'body', 'event_date', 'image', 'status'),
		'ngom_gallery' => array('title', 'image_path', 'sort_order'),
		'ngom_projects' => array('title', 'summary', 'body', 'image', 'status'),
		'ngom_campaigns' => array('title', 'goal_amount', 'raised_display', 'description', 'image', 'status'),
		'ngom_audit_reports' => array('title', 'file_path', 'admin_user_id'),
	);

	public function allowed_tables()
	{
		return array_keys($this->allowed);
	}

	public function all($table, $limit = 200)
	{
		if (!$this->is_allowed($table) || !$this->db->table_exists($table)) {
			return array();
		}
		$this->db->order_by('id', 'DESC');
		$this->db->limit((int) $limit);
		$r = $this->db->get($table)->result_array();
		return is_array($r) ? $r : array();
	}

	/**
	 * Fetch campaigns with sum of amounts from donations table.
	 */
	public function get_campaigns_with_totals($limit = 200)
	{
		if (!$this->db->table_exists('ngom_campaigns')) {
			return array();
		}
		
		$sql = "SELECT c.*, 
				(SELECT IFNULL(SUM(amount), 0) FROM donations WHERE campaign_id = c.id AND status = 'paid') as raised_amount
				FROM ngom_campaigns c
				ORDER BY c.id DESC
				LIMIT ?";
		
		return $this->db->query($sql, array((int) $limit))->result_array();
	}

	public function insert_row($table, $row)
	{
		if (!$this->is_allowed($table) || !$this->db->table_exists($table)) {
			return false;
		}
		$row = $this->filter_fields($table, $row);
		return $this->db->insert($table, $row);
	}

	public function delete_id($table, $id)
	{
		if (!$this->is_allowed($table) || !$this->db->table_exists($table)) {
			return false;
		}
		$this->db->where('id', (int) $id);
		return $this->db->delete($table);
	}

	private function is_allowed($table)
	{
		return isset($this->allowed[$table]);
	}

	private function filter_fields($table, $row)
	{
		if (!is_array($row)) {
			return array();
		}
		$out = array();
		foreach ($this->allowed[$table] as $k) {
			if (array_key_exists($k, $row)) {
				$out[$k] = $row[$k];
			}
		}
		return $out;
	}
}
