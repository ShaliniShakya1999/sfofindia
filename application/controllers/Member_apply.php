<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
/**
 * @property CI_Upload $member_apply_upload
 */
class Member_apply extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Member_model', 'members');
		$this->members->ensure_extended_schema();
	}

	public function index()
	{
		$this->loadview('web/member_apply');
	}

	// =====================================================================
	// PAYSPRINT AADHAAR API - TEMPORARILY DISABLED
	// Uncomment below functions when Paysprint API credentials are ready
	// =====================================================================

	/*
	public function send_aadhaar_otp()
	{
		if (!$this->input->is_ajax_request()) { show_404(); }
		$id_number = trim((string) $this->input->post('id_number', true));
		if (strlen($id_number) !== 12) {
			echo json_encode(array('status' => false, 'message' => 'Invalid Aadhaar Number'));
			return;
		}

		$response = $this->call_paysprint_api('verification/aadhaar_sendotp', array('id_number' => $id_number));
		echo json_encode($response);
	}

	public function verify_aadhaar_otp()
	{
		if (!$this->input->is_ajax_request()) { show_404(); }
		$client_id = $this->input->post('client_id', true);
		$otp = $this->input->post('otp', true);
		if (!$client_id || !$otp) {
			echo json_encode(array('status' => false, 'message' => 'Missing client_id or OTP'));
			return;
		}

		$response = $this->call_paysprint_api('verification/aadhaar_verifyotp', array(
			'client_id' => $client_id,
			'otp' => $otp,
			'refid' => time()
		));
		echo json_encode($response);
	}

	private function call_paysprint_api($endpoint, $data)
	{
		$url = 'https://uat.paysprint.in/sprintverify-uat/api/v1/' . $endpoint;
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false, // Required for some UAT environments
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				'Token: ' . $this->config->item('pay_sprint_token'),
				'Authorisedkey: ' . $this->config->item('pay_sprint_key'),
				'User-Agent: ' . $this->config->item('pay_sprint_ua'),
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) { return array('status' => false, 'statuscode' => 500, 'message' => 'CURL Error: ' . $err); }
		$res = json_decode((string)$response, true);
		return $res ?: array('status' => false, 'statuscode' => 500, 'message' => 'Invalid API Response');
	}
	*/

	public function submit()
	{
		if (strtoupper((string) $this->input->server('REQUEST_METHOD')) !== 'POST') {
			show_404();
		}

		$fields = array(
			'name' => trim((string) $this->input->post('name', true)),
			'gender' => trim((string) $this->input->post('gender', true)),
			'dob' => trim((string) $this->input->post('dob', true)) ?: null,
			'relation_type' => trim((string) $this->input->post('relation_type', true)),
			'relation_name' => trim((string) $this->input->post('relation_name', true)),
			'profession' => trim((string) $this->input->post('profession', true)),
			'blood_group' => trim((string) $this->input->post('blood_group', true)),
			'state' => trim((string) $this->input->post('state', true)),
			'district' => trim((string) $this->input->post('district', true)),
			'mobile' => trim((string) $this->input->post('mobile', true)),
			'aadhar_no' => trim((string) $this->input->post('aadhar_no', true)),
			'aadhar_verified' => (int) $this->input->post('aadhar_verified', true),
			'aadhar_data' => $this->input->post('aadhar_data', false),
			'donation_amount' => (float) $this->input->post('donation_amount', true),
			'address' => trim((string) $this->input->post('address', true)),
			'pin_code' => trim((string) $this->input->post('pin_code', true)),
			'email' => trim((string) $this->input->post('email', true)),
			'id_type' => trim((string) $this->input->post('id_type', true)),
			'payment_mode' => trim((string) $this->input->post('payment_mode', true)),
			'role' => 'member',
			'status' => 'pending',
			'joining_date' => date('Y-m-d'),
			'join_source' => 'website',
			'notes' => $this->input->post('notes', false),
			'added_by' => null,
		);

		if ($fields['name'] === '' || $fields['gender'] === '' || $fields['mobile'] === '' || $fields['address'] === '') {
			$this->session->set_flashdata('error', 'Please fill all required fields.');
			redirect('join-us');
		}

		// Handle uploads
		$upload_fields = array('photo', 'id_document', 'other_document', 'payment_receipt', 'aadhar_front', 'aadhar_back');
		foreach ($upload_fields as $f) {
			if (!empty($_FILES[$f]['name'])) {
				$path = $this->upload_member_file($f);
				if ($path) $fields[$f] = $path;
			}
		}

		$ok = $this->members->insert_member($fields);
		$this->session->set_flashdata($ok ? 'success' : 'error', $ok ? 'Application submitted successfully. Admin will review it soon.' : 'Could not submit your application. Please try again.');
		redirect('join-us');
	}

	private function upload_member_file($field_name)
	{
		$config = array(
			'upload_path' => FCPATH . 'uploads/members/',
			'allowed_types' => 'jpg|jpeg|png|gif|webp|pdf',
			'max_size' => 4096,
			'encrypt_name' => true,
		);

		if (!is_dir($config['upload_path'])) {
			@mkdir($config['upload_path'], 0775, true);
		}

		$this->load->library('upload', $config, 'member_apply_upload');
		$uploader = $this->member_apply_upload;
		if (!$uploader->do_upload($field_name)) {
			$this->session->set_flashdata('error', strip_tags((string) $uploader->display_errors('', '')));
			redirect('join-us');
			return false;
		}

		$data = $uploader->data();
		return 'uploads/members/' . $data['file_name'];
	}
}
