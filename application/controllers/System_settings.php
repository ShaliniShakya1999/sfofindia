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
		
		$this->require_role(array('super_admin', 'admin'));
	}

	public function index()
	{
		$data['title'] = 'Website Global Settings';
		$data['cms'] = $this->Site_model->get_all_flat();
		$this->adminloadview('admin/system_settings', $data);
	}

	public function save()
	{
		if (!$this->require_post()) {
			return;
		}
		$allowed_keys = array(
			'site_name',
			'meta_title',
			'meta_description',
			'contact_phone',
			'contact_email',
			'contact_address',
			'google_map_embed',
			'bank_name',
			'bank_account_name',
			'bank_account_no',
			'bank_ifsc',
			'bank_branch',
			'bank_upi_id',
			'social_facebook',
			'social_twitter',
			'social_instagram',
			'social_youtube',
			'social_linkedin',
			'office_hours',
			'razorpay_key_id',
			'razorpay_key_secret',
			'stripe_public_key',
			'stripe_secret_key',
			'smtp_host',
			'smtp_port',
			'smtp_crypto',
			'smtp_user',
			'smtp_pass',
			'smtp_from_email',
			'whatsapp_enabled',
			'whatsapp_provider',
			'whatsapp_api_url',
			'whatsapp_api_key',
			'whatsapp_phone_number_id',
			'whatsapp_template_donation',
			'whatsapp_template_welcome',
		);
		$post = $this->input->post();
		$filtered = array();
		foreach ($allowed_keys as $key) {
			if (isset($post[$key])) {
				$val = trim((string) $post[$key]);
				// Do not overwrite existing secrets with blank if submitted empty
				if (in_array($key, array('smtp_pass', 'razorpay_key_secret', 'stripe_secret_key', 'whatsapp_api_key'), true) && $val === '') {
					continue;
				}
				$filtered[$key] = $val;
			}
		}
		if (!empty($filtered)) {
			$this->Site_model->save_batch($filtered);
			$this->session->set_flashdata('cms_success', 'Global settings updated successfully.');
		}
		redirect('system_settings');
	}
}
