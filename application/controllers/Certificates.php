<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Certificates extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->require_login();
		$this->load->database();
		$role = (string) $this->session->userdata('cms_admin_role');
		if ($role === 'member') {
			$this->session->set_flashdata('cms_error', 'Permission denied.');
			redirect('admin');
		}
	}

	public function index()
	{
		$data['title'] = 'Manage Certificates';
		$this->adminloadview('admin/certificates', $data);
	}

	public function generate_custom()
	{
		$name = $this->input->post('name', true);
		$title = $this->input->post('title', true) ?: 'Certificate of Appreciation';
		$body = $this->input->post('body', true) ?: 'This certificate is presented in recognition of valuable support and commitment towards our mission.';
		
		if (empty($name)) {
			$this->session->set_flashdata('cms_error', 'Name is required.');
			redirect('certificates');
			return;
		}

		$this->load->model('Site_model');
		$c = $this->Site_model->get_all_flat();
		$org = !empty($c['site_name']) ? $c['site_name'] : 'NGO';

		$member = array(
			'id' => rand(10000, 99999),
			'name' => $name,
		);

		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		// Handle internal dependency (member_user_id is generally used)
		$member['member_user_id'] = 'CUST-' . $member['id'];

		$bin = $this->ngomdoc->certificate_pdf($member, $title, $body, $org);

		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: inline; filename="certificate-' . md5($name) . '.pdf"')
			->set_output($bin);
	}
}
