<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class System_settings extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->require_login();
		$this->load->database();
		$this->load->model('Site_model');
		
		$role = (string) $this->session->userdata('cms_admin_role');
		if ($role !== 'super_admin' && $role !== 'admin') {
			$this->session->set_flashdata('cms_error', 'Permission denied.');
			redirect('admin');
		}
	}

	public function index()
	{
		$data['title'] = 'Website Global Settings';
		$data['cms'] = $this->Site_model->get_all_flat();
		$this->adminloadview('admin/system_settings', $data);
	}

	public function save()
	{
		$post = $this->input->post();
		if (!empty($post)) {
			$this->Site_model->save_batch($post);
			$this->session->set_flashdata('cms_success', 'Global settings updated successfully.');
		}
		redirect('system_settings');
	}
}
