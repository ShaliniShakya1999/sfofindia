<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Activity_logs extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->require_login();
		$this->load->database();
		$this->load->model('Admin_user_model', 'admin_user');
		
		$role = (string) $this->session->userdata('cms_admin_role');
		if ($role !== 'super_admin' && $role !== 'admin') {
			$this->session->set_flashdata('cms_error', 'You do not have permission to view activity logs.');
			redirect('admin');
		}
	}

	public function index()
	{
		if (!$this->db->table_exists('ngom_admin_activity')) {
			show_error('Activity table not installed.');
		}

		$this->db->select('ngom_admin_activity.*, admin_users.username, admin_users.role');
		$this->db->from('ngom_admin_activity');
		$this->db->join('admin_users', 'admin_users.id = ngom_admin_activity.admin_user_id', 'left');
		$this->db->order_by('ngom_admin_activity.id', 'DESC');
		$this->db->limit(500);
		$logs = $this->db->get()->result_array();

		$data = array(
			'title' => 'System Activity Logs',
			'logs' => $logs
		);

		$this->adminloadview('admin/activity_logs', $data);
	}

	public function clear()
	{
		$role = (string) $this->session->userdata('cms_admin_role');
		if ($role !== 'super_admin') {
			$this->session->set_flashdata('cms_error', 'Only Super Admins can clear logs.');
			redirect('activity_logs');
		}

		$this->db->empty_table('ngom_admin_activity');
		$this->session->set_flashdata('cms_success', 'Audit trail cleared successfully.');
		redirect('activity_logs');
	}
}
