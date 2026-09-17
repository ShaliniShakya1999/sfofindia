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
		$this->load->helper(array('form', 'url', 'cms'));
		$this->load->model('Member_model', 'members');
		// Make sure every column the form/submit() relies on actually exists,
		// even on a freshly restored/older copy of the database.
		$this->members->ensure_extended_schema();
	}

	public function index()
	{
		// Use loadview() (not a bare load->view) so the public page picks up
		// the CMS-managed $cms data (site name, contact info, meta tags, etc.)
		// instead of silently falling back to hardcoded defaults everywhere.
		$this->loadview('web/member_apply');
	}

	// =====================================================================
	// PAYSPRINT AADHAAR VERIFICATION API
	// =====================================================================

	public function send_aadhaar_otp()
	{
		if (!$this->input->is_ajax_request() && strtoupper((string)$this->input->server('REQUEST_METHOD')) !== 'POST') {
			show_404();
		}
		$id_number = preg_replace('/\D+/', '', (string) $this->input->post('id_number', true));
		if (strlen($id_number) !== 12) {
			$this->output->set_content_type('application/json')->set_output(json_encode(array(
				'status' => false,
				'statuscode' => 422,
				'message' => 'Please enter a valid 12-digit Aadhaar number.'
			)));
			return;
		}

		if ($this->members->aadhar_exists($id_number)) {
			$this->output->set_content_type('application/json')->set_output(json_encode(array(
				'status' => false,
				'statuscode' => 409,
				'message' => 'This Aadhaar card number is already registered with an existing member. Each member must have a unique Aadhaar number.'
			)));
			return;
		}

		$response = $this->call_paysprint_api('verification/aadhaar_sendotp', array('id_number' => $id_number));
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function verify_aadhaar_otp()
	{
		if (!$this->input->is_ajax_request() && strtoupper((string)$this->input->server('REQUEST_METHOD')) !== 'POST') {
			show_404();
		}
		$client_id = trim((string) $this->input->post('client_id', true));
		$otp = trim((string) $this->input->post('otp', true));
		$refid = trim((string) $this->input->post('refid', true)) ?: (string) time();

		if (!$client_id || !$otp) {
			$this->output->set_content_type('application/json')->set_output(json_encode(array(
				'status' => false,
				'statuscode' => 422,
				'message' => 'Missing client_id or OTP'
			)));
			return;
		}

		$response = $this->call_paysprint_api('verification/aadhaar_verifyotp', array(
			'client_id' => $client_id,
			'otp' => $otp,
			'refid' => $refid
		));
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	private function get_paysprint_token()
	{
		$secret = (string) $this->config->item('pay_sprint_secret');
		$partner_id = (string) ($this->config->item('pay_sprint_partner_id') ?: $this->config->item('pay_sprint_ua'));

		// Dynamically generate HS256 JWT if partner secret is configured
		if (!empty($secret) && !empty($partner_id)) {
			$header = json_encode(array('alg' => 'HS256', 'typ' => 'JWT'));
			$payload = json_encode(array(
				'timestamp' => time(),
				'partnerId' => $partner_id,
				'reqid' => (string) (time() . mt_rand(100, 999))
			));

			$b64Header = rtrim(strtr(base64_encode($header), '+/', '-_'), '=');
			$b64Payload = rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');
			$sig = rtrim(strtr(base64_encode(hash_hmac('sha256', "$b64Header.$b64Payload", $secret, true)), '+/', '-_'), '=');

			return "$b64Header.$b64Payload.$sig";
		}

		return (string) $this->config->item('pay_sprint_token');
	}

	private function call_paysprint_api($endpoint, $data)
	{
		// Optional sandbox/mock mode for testing UI and form auto-fill without live API
		if ($this->config->item('pay_sprint_mock_mode') === true) {
			if (strpos($endpoint, 'aadhaar_sendotp') !== false) {
				return array(
					'status' => true,
					'statuscode' => 200,
					'message' => 'OTP sent successfully to registered mobile number.',
					'data' => array(
						'client_id' => 'aadhaar_v3_DEMO_' . time(),
						'otp_sent' => true,
						'if_number' => true,
						'valid_aadhaar' => true
					)
				);
			} elseif (strpos($endpoint, 'aadhaar_verifyotp') !== false) {
				return array(
					'status' => true,
					'statuscode' => 200,
					'message' => 'Aadhaar verified successfully',
					'data' => array(
						'client_id' => $data['client_id'] ?? 'aadhaar_v3_demo',
						'full_name' => 'Demo Applicant',
						'dob' => '1995-05-20',
						'gender' => 'M',
						'zip' => '110001',
						'address' => array(
							'house' => 'House No. 12',
							'street' => 'Parliament Street',
							'loc' => 'Connaught Place',
							'vtc' => 'New Delhi',
							'dist' => 'Central Delhi',
							'state' => 'Delhi'
						)
					)
				);
			}
		}

		$base_url = (string) ($this->config->item('pay_sprint_base_url') ?: 'https://sit.paysprint.in/sprintverify-uat/api/v1/');
		$url = rtrim($base_url, '/') . '/' . ltrim($endpoint, '/');

		$token = $this->get_paysprint_token();
		$key = (string) $this->config->item('pay_sprint_key');
		$ua = (string) ($this->config->item('pay_sprint_ua') ?: 'CORP00001');

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false, // Required for UAT environments
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				'Token: ' . $token,
				'Authorisedkey: ' . $key,
				'User-Agent: ' . $ua,
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			return array('status' => false, 'statuscode' => 500, 'message' => 'CURL Error: ' . $err);
		}

		$res = json_decode((string) $response, true);
		if (!$res) {
			return array('status' => false, 'statuscode' => 500, 'message' => 'Invalid API Response from server');
		}

		return $res;
	}

	public function submit()
	{
		if (strtoupper((string) $this->input->server('REQUEST_METHOD')) !== 'POST') {
			show_404();
		}
		if (!$this->public_throttle('member_apply', 3, 3600)) {
			$this->session->set_flashdata('error', 'Too many applications were submitted. Please try again later.');
			redirect('join-us');
			return;
		}
		if (trim((string) $this->input->post('website', true)) !== '') {
			redirect('join-us');
			return;
		}

		// Field names below match the real `members` table columns
		// (see Member_model::ensure_extended_schema()) and the input
		// `name="..."` attributes actually used in web/member_apply.php.
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
			'email' => strtolower(trim((string) $this->input->post('email', true))),
			'id_type' => trim((string) $this->input->post('id_type', true)),
			'payment_mode' => trim((string) $this->input->post('payment_mode', true)),
			'role' => 'member',
			'status' => 'pending',
			'joining_date' => date('Y-m-d'),
			'join_source' => 'website',
			'notes' => $this->input->post('notes', false),
			'added_by' => null,
			'photo' => null,
		);

		if ($fields['name'] === '' || $fields['gender'] === '' || $fields['mobile'] === '' || $fields['address'] === '') {
			$this->session->set_flashdata('error', 'Please fill all required fields.');
			redirect('join-us');
			return;
		}

		if ($fields['email'] === '') {
			$this->session->set_flashdata('error', 'Email address is required.');
			redirect('join-us');
			return;
		}

		if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
			$this->session->set_flashdata('error', 'Please provide a valid email address.');
			redirect('join-us');
			return;
		}

		if ($this->members->email_exists($fields['email'])) {
			$this->session->set_flashdata('error', 'This email address is already registered. Each member must have a unique email address.');
			redirect('join-us');
			return;
		}

		if (!empty($fields['mobile']) && $this->members->mobile_exists($fields['mobile'])) {
			$this->session->set_flashdata('error', 'This contact number is already registered with an existing member. Each member must have a unique mobile number.');
			redirect('join-us');
			return;
		}

		if (!empty($fields['aadhar_no']) && $this->members->aadhar_exists($fields['aadhar_no'])) {
			$this->session->set_flashdata('error', 'This Aadhaar card number is already registered with an existing member. Each member must have a unique Aadhaar number.');
			redirect('join-us');
			return;
		}

		if (strtolower(trim((string)$fields['payment_mode'])) === 'cash') {
			$this->session->set_flashdata('error', 'Cash payment mode is only accepted for in-person administrative applications. Please select an online or bank payment mode.');
			redirect('join-us');
			return;
		}

		$this->load->model('Site_model');
		$cms_data = $this->Site_model->get_all_flat();
		$min_fee = (float) (cms_val($cms_data, 'membership_fee', '5000') ?: 5000);
		if ($fields['donation_amount'] < $min_fee) {
			$this->session->set_flashdata('error', 'A fixed membership fee of ₹' . number_format($min_fee) . ' is required to register as a member.');
			redirect('join-us');
			return;
		}

		// Ready block: Capture UTR reference or online gateway payment ID if submitted
		$utr = trim((string) ($this->input->post('upi_utr', true) ?: $this->input->post('bank_utr', true)));
		$razorpay_payment_id = trim((string) $this->input->post('razorpay_payment_id', true));
		$extra_notes = array();
		if ($utr !== '') {
			$extra_notes[] = 'UTR / Ref No: ' . $utr;
		}
		if ($razorpay_payment_id !== '') {
			$extra_notes[] = 'Online Payment ID: ' . $razorpay_payment_id;
		}
		if (!empty($extra_notes)) {
			$existing = (string) ($fields['notes'] ?? '');
			$fields['notes'] = trim($existing . "\n" . implode("\n", $extra_notes));
		}

		// Handle uploads — one field per document type, matching the
		// dedicated columns the schema provides for each.
		$upload_fields = array('photo', 'id_document', 'other_document', 'payment_receipt', 'aadhar_front', 'aadhar_back');
		foreach ($upload_fields as $f) {
			if (!empty($_FILES[$f]['name'])) {
				$path = $this->upload_member_file($f);
				if ($path) $fields[$f] = $path;
			}
		}

		$ok = $this->members->insert_member($fields);

		/*
		 * -------------------------------------------------------
		 * Send notifications only after successful registration.
		 *
		 * Email:    registration/welcome email.
		 * WhatsApp: registration notification.
		 *
		 * A notification failure must NOT make the registration
		 * itself fail — the member record is already saved.
		 * -------------------------------------------------------
		 */
		if ($ok) {
			$new_id = (int) $this->db->insert_id();
			$notification_link = $new_id > 0 ? 'members/view/' . $new_id : 'members?status=pending';
			try {
				// insert_member() returns a plain bool, so $fields doesn't
				// carry the auto-generated member_id_code/public_id/
				// referral_code back. Re-fetch the just-inserted row so the
				// welcome email can include the member ID code.
				$new_member = $fields;
				if ($new_id > 0) {
					$saved = $this->members->find_by_id($new_id);
					if (!empty($saved)) {
						$new_member = (array) $saved;
					}
				}

				$this->load->library('Ngom_mailer', array(), 'ngommailer');

				if (!empty($new_member['email'])) {
					$this->ngommailer->send_registration_welcome($new_member);
				}

				if (!empty($new_member['mobile'])) {
					$this->load->library('Ngom_whatsapp', array(), 'ngomwhatsapp');
					$this->ngomwhatsapp->send_registration_whatsapp($new_member);
				}
			} catch (Exception $e) {
				log_message('error', 'Registration notification error: ' . $e->getMessage());
			}

			ngom_notify(
				'New Membership Application',
				trim((string) ($new_member['name'] ?? $fields['name'])) . ' applied for membership.',
				'info',
				$notification_link
			);
		}

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
		$allowed_mimes = in_array($field_name, array('photo', 'aadhar_front', 'aadhar_back'), true)
			? array('image/jpeg', 'image/png', 'image/gif', 'image/webp')
			: array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf');
		$uploaded_path = $config['upload_path'] . $data['file_name'];
		if (!$this->validate_uploaded_file($uploaded_path, $allowed_mimes)) {
			@unlink($uploaded_path);
			$this->session->set_flashdata('error', 'The uploaded file type is not supported.');
			redirect('join-us');
			return false;
		}
		return 'uploads/members/' . $data['file_name'];
	}

	public function check_email()
	{
		$email = strtolower(trim((string) $this->input->post_get('email', true)));
		if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status' => 'error',
					'available' => false,
					'message' => 'Please enter a valid email address.'
				)));
			return;
		}

		$exists = $this->members->email_exists($email);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'status' => 'success',
				'available' => !$exists,
				'message' => $exists
					? 'This email address is already registered.'
					: 'Email address is available.'
			)));
	}

	public function check_mobile()
	{
		$mobile = trim((string) $this->input->post_get('mobile', true));
		$digits = preg_replace('/\D+/', '', $mobile);
		if (strlen($digits) < 10) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status' => 'error',
					'available' => false,
					'message' => 'Please enter a valid 10-digit mobile number.'
				)));
			return;
		}

		$exists = $this->members->mobile_exists($mobile);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'status' => 'success',
				'available' => !$exists,
				'message' => $exists
					? 'This contact number is already registered.'
					: 'Contact number is available.'
			)));
	}

	public function check_aadhar()
	{
		$aadhar = trim((string) $this->input->post_get('aadhar_no', true));
		$digits = preg_replace('/\D+/', '', $aadhar);
		if (strlen($digits) !== 12) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status' => 'error',
					'available' => false,
					'message' => 'Please enter a valid 12-digit Aadhaar number.'
				)));
			return;
		}

		$exists = $this->members->aadhar_exists($digits);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'status' => 'success',
				'available' => !$exists,
				'message' => $exists
					? 'This Aadhaar card number is already registered.'
					: 'Aadhaar number is available.'
			)));
	}
}