<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
/**
 * Material admin shell: shared panel for admins and verified members.
 *
 * @property Member_model $member_m
 * @property Ngom_documents $ngomdoc
 */
class Admin extends My_Controller {

	/** @var list<string> */
	private $public_methods = array('login', 'do_login', 'logout', 'setup_password', 'save_setup_password');

	/** Fixed membership renewal fee, in INR. */
	const RENEWAL_FEE_INR = 2000;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Admin_user_model', 'admin_user');
		$this->load->model('Member_model', 'member_m');
		$this->member_m->ensure_extended_schema();
		$this->member_m->ensure_renewals_table();

		$m = $this->router->method;
		if (!in_array($m, $this->public_methods, true)) {
			$this->require_login();
			$this->sync_cms_role_from_db();
		}
	}

	private function sync_cms_role_from_db()
	{
		if ($this->panel_user_type() === 'member') {
			$this->session->set_userdata('cms_admin_role', 'member');
			return;
		}
		$id = (int) $this->session->userdata('cms_admin_id');
		if ($id < 1) {
			return;
		}
		$row = $this->admin_user->find_by_id($id);
		if (!$row || (isset($row['status']) && (int) $row['status'] === 0)) {
			$this->session->sess_destroy();
			redirect('admin/login');
			return;
		}
		$this->session->set_userdata('cms_admin_role', $row['role']);
	}

	private function panel_user_type()
	{
		$type = $this->session->userdata('panel_user_type');
		return ($type !== null && $type !== '') ? (string) $type : 'admin';
	}

	private function current_member()
	{
		$id = (int) $this->session->userdata('cms_member_id');
		return $id > 0 ? $this->member_m->find_by_id($id) : null;
	}

	/**
	 * @param bool $allow_inactive Set true for pages a lapsed (inactive) member
	 *   should still be able to reach — currently: profile and renew/payment pages.
	 *   Any other status (pending, rejected, etc.) is never allowed here.
	 */
	private function require_member_panel($allow_inactive = false)
	{
		if ($this->panel_user_type() !== 'member') {
			$this->session->set_flashdata('cms_error', 'This section is available for member login only.');
			redirect('admin');
			return null;
		}
		$member = $this->current_member();
		if (!$member) {
			$this->logout();
			return null;
		}
		$status = $member['status'] ?? '';
		if ($status === 'active') {
			return $member;
		}
		if ($status === 'inactive' && $allow_inactive) {
			return $member;
		}
		if ($status === 'inactive') {
			$this->session->set_flashdata('cms_error', 'Your membership has expired. Please renew to continue.');
			redirect('admin/renew');
			return null;
		}
		$this->logout();
		return null;
	}

	public function login()
	{
		// If admin is already logged in
		if ($this->session->userdata('cms_admin_id') && $this->session->userdata('panel_user_type') === 'admin') {
			redirect('admin');
		}

		// If member is already logged in
		if ($this->session->userdata('cms_member_id') && $this->session->userdata('panel_user_type') === 'member') {
			redirect('admin');
		}
		$this->load->view('admin/cms/login_page', array(
			'form_action'     => site_url('admin/do_login'),
			'login_title'     => 'Admin / Member Panel',
			'login_subtitle'  => 'Admins and verified members can sign in here. The same panel opens with role-based sidebar and dashboard.',
		));
	}

	public function setup_password()
	{
		$token = trim((string) $this->input->get('token', true));
		$configured_token = trim((string) getenv('SFOF_ADMIN_SETUP_TOKEN'));
		if ($configured_token === '' || $token === '' || !hash_equals($configured_token, $token)) {
			show_404();
			return;
		}
		$this->session->set_userdata('admin_setup_token', hash('sha256', $token));
		$this->load->view('admin/cms/setup_password', array(
			'form_action' => site_url('admin/save_setup_password'),
		));
	}

	public function save_setup_password()
	{
		if ($this->input->method() !== 'post') {
			show_404();
			return;
		}
		$setup_token = (string) $this->session->userdata('admin_setup_token');
		$configured_token = trim((string) getenv('SFOF_ADMIN_SETUP_TOKEN'));
		if ($configured_token === '' || $setup_token === '' || !hash_equals($setup_token, hash('sha256', $configured_token))) {
			show_404();
			return;
		}

		$password = (string) $this->input->post('password');
		$confirmation = (string) $this->input->post('password_confirm');
		$email = trim((string) $this->input->post('email', true));
		if (strlen($password) < 12 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || $password !== $confirmation) {
			$this->session->set_flashdata('setup_error', 'Use matching passwords with at least 12 characters, including uppercase, lowercase, and a number.');
			redirect('admin/setup_password?token=' . rawurlencode($configured_token));
			return;
		}

		$admin = $this->admin_user->find_by_username('admin');
		if (!$admin || !filter_var($email, FILTER_VALIDATE_EMAIL)
			|| !$this->admin_user->update_password((int) $admin['id'], password_hash($password, PASSWORD_DEFAULT))
			|| !$this->admin_user->update_email((int) $admin['id'], $email)) {
			$this->session->set_flashdata('setup_error', 'Administrator password could not be updated.');
			redirect('admin/setup_password?token=' . rawurlencode($configured_token));
			return;
		}
		$this->session->unset_userdata('admin_setup_token');
		$this->session->set_flashdata('cms_success', 'Administrator password updated. You can now sign in.');
		redirect('admin/login');
	}

	public function do_login()
	{
		$u = trim((string) ($this->input->post('username', true) ?: $this->input->post('user_id', true)));
		$p = (string) $this->input->post('password');
		if (!$u || $p === '') {
			$this->session->set_flashdata('cms_error', 'Username and password required.');
			redirect('admin/login');
		}
		$lock_until = (int) $this->session->userdata('login_locked_until');
		if ($lock_until > time()) {
			$this->session->set_flashdata('cms_error', 'Too many failed attempts. Please try again later.');
			redirect('admin/login');
			return;
		}

		// 1. Check Administrator credentials (Username OR Email)
		$row = $this->admin_user->find_by_identifier($u);
		$default_admin_hash = '$2y$10$ZYU3mN95iXZDS4Lr9sDGIuCkum2T3a91R7ln2eiJH3BQaFSic9L7m';
		if (ENVIRONMENT === 'production' && $row && ($u === 'admin' || (isset($row['username']) && $row['username'] === 'admin')) && hash_equals($default_admin_hash, (string) $row['password_hash'])) {
			$this->session->set_flashdata('cms_error', 'The default administrator password is disabled in production. Set a unique password.');
			redirect('admin/login');
			return;
		}

		$admin_auth = false;
		if ($row && !empty($row['password_hash']) && password_verify($p, $row['password_hash'])) {
			$admin_auth = true;
		} elseif (ENVIRONMENT !== 'production' && $row && ($p === 'admin123' || $p === 'Admin@123')) {
			// In development, auto-sync standard credentials into the database
			$admin_auth = true;
			$this->admin_user->update_password((int) $row['id'], password_hash($p, PASSWORD_DEFAULT));
		}

		if ($admin_auth) {
			// Account Status check
			if (($row['status'] ?? 1) == 0) {
				$this->session->set_flashdata('cms_error', 'Your account has been suspended. Please contact the administrator.');
				redirect('admin/login');
				return;
			}

			// Ensure primary admin account retains super_admin role
			$admin_role = isset($row['role']) && $row['role'] !== '' ? $row['role'] : 'super_admin';
			if (($row['username'] === 'admin' || $row['id'] == 1) && $admin_role === 'admin') {
				$admin_role = 'super_admin';
				$this->admin_user->update_role((int) $row['id'], 'super_admin');
			}

			$this->session->sess_regenerate(true);
			$this->session->unset_userdata(array('login_failures', 'login_locked_until', 'otp_pending_admin_id', 'otp_hash', 'otp_expires_at', 'otp_attempts'));
			$this->db->where('id', (int) $row['id']);
			$this->db->update('admin_users', array('last_login' => date('Y-m-d H:i:s')));
			$this->session->set_userdata('panel_user_type', 'admin');
			$this->session->set_userdata('cms_admin_id', (int) $row['id']);
			$this->session->set_userdata('cms_admin_name', (string) $row['username']);
			$this->session->set_userdata('cms_admin_role', $admin_role);
			$this->session->unset_userdata(array('cms_member_id', 'cms_member_user_id', 'member_portal_id', 'member_portal_name'));
			redirect('admin');
			return;
		}

		// 2. Check Member credentials (User ID OR Email OR Mobile OR ID Code)
		$member = $this->member_m->find_by_identifier($u);
		$member_auth = false;
		if ($member && !empty($member['member_password_hash']) && password_verify($p, $member['member_password_hash'])) {
			$member_auth = true;
		} elseif (ENVIRONMENT !== 'production' && $member && ($p === '123456' || $p === 'member123' || $p === 'Member@123' || empty($member['member_password_hash']))) {
			// In development, allow default testing password and sync hash
			$member_auth = true;
			$this->member_m->update_member((int) $member['id'], array('member_password_hash' => password_hash($p, PASSWORD_DEFAULT)));
		}

		if ($member_auth) {
			$member_status = $member['status'] ?? '';
			if ($member_status !== 'active' && $member_status !== 'inactive') {
				$this->session->set_flashdata('cms_error', 'Your membership is not active yet.');
				redirect('admin/login');
				return;
			}
			$this->session->sess_regenerate(true);
			$this->session->unset_userdata(array('login_failures', 'login_locked_until'));
			$this->session->set_userdata('panel_user_type', 'member');
			$this->session->set_userdata('cms_admin_id', 'member-' . (int) $member['id']);
			$this->session->set_userdata('cms_admin_name', (string) $member['name']);
			$this->session->set_userdata('cms_admin_role', 'member');
			$this->session->set_userdata('cms_member_id', (int) $member['id']);
			$this->session->set_userdata('cms_member_user_id', (string) ($member['member_user_id'] ?? ''));
			$this->session->set_userdata('member_portal_id', (int) $member['id']);
			$this->session->set_userdata('member_portal_name', (string) $member['name']);
			if ($member_status === 'inactive') {
				$this->session->set_flashdata('cms_error', 'Your membership has expired. Please renew to continue.');
				redirect('admin/renew');
				return;
			}
			redirect('admin');
			return;
		}

		$failures = (int) $this->session->userdata('login_failures') + 1;
		$this->session->set_userdata('login_failures', $failures);
		if ($failures >= 5) {
			$this->session->set_userdata('login_locked_until', time() + 900);
		}
		$this->session->set_flashdata('cms_error', 'Invalid login.');
		redirect('admin/login');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin/login');
	}

	public function index()
	{
		if ($this->panel_user_type() === 'member') {
			$member = $this->require_member_panel();
			if (!$member) {
				return;
			}
			$this->load->model('Donation_model', 'donation_m');
			$email = isset($member['email']) ? $member['email'] : '';
			$donations = array();
			if ($email !== '' && $this->donation_m->table_exists()) {
				$this->db->where('email', $email);
				$this->db->order_by('id', 'DESC');
				$donations = $this->db->get('donations')->result_array();
			}

			// Birthday check for popup
			$is_birthday = false;
			if (!empty($member['dob'])) {
				$is_birthday = (date('m-d', strtotime($member['dob'])) === date('m-d'));
			}

			// Fetch more data for member dashboard
			$this->load->model('Site_model');
			$campaigns = array();
			if ($this->db->table_exists('ngom_campaigns')) {
				$this->db->order_by('id', 'DESC')->limit(3);
				$campaigns = $this->db->get('ngom_campaigns')->result_array();
			}
			$events = array();
			if ($this->db->table_exists('ngom_events')) {
				$this->db->order_by('id', 'DESC')->limit(3);
				$events = $this->db->get('ngom_events')->result_array();
			}

			$this->adminloadview('admin/member_dashboard', array(
				'member' => $member,
				'donations' => $donations,
				'campaigns' => $campaigns,
				'events' => $events,
				'is_birthday_today' => $is_birthday
			));
			return;
		}

		$data = array();
		$this->load->model('Donation_model', 'donation_m');
		$this->load->model('Site_model');
		
		if ($this->member_m->table_exists()) {
			$data['ngom_members_count'] = $this->member_m->count_all();
		}
		if ($this->donation_m->table_exists()) {
			$data['ngom_donations_count'] = $this->donation_m->count_all();
			$data['ngom_donations_total_inr'] = $this->donation_m->sum_amount_success();
		}
		
		// Active Campaigns
		if ($this->db->table_exists('ngom_campaigns')) {
			$this->db->where('status', 'active');
			$data['active_campaigns_count'] = $this->db->count_all_results('ngom_campaigns');
		} else {
			$data['active_campaigns_count'] = 0;
		}

		// Recent Activities
		if ($this->db->table_exists('ngom_admin_activity')) {
			$this->db->order_by('id', 'DESC');
			$this->db->limit(10);
			$data['recent_activities'] = $this->db->get('ngom_admin_activity')->result_array();
		} else {
			$data['recent_activities'] = array();
		}

		// Real Chart Datasets
		$member_labels = array();
		$member_data = array();
		for ($i = 6; $i >= 0; $i--) {
			$d = date('Y-m-d', strtotime("-$i days"));
			$member_labels[] = date('D (d)', strtotime($d));
			$count = 0;
			if ($this->member_m->table_exists()) {
				$this->db->where('DATE(created_at)', $d);
				$count = (int)$this->db->count_all_results('members');
			}
			$member_data[] = $count;
		}
		$data['chart_members_labels'] = $member_labels;
		$data['chart_members_data'] = $member_data;

		$donation_labels = array();
		$donation_data = array();
		for ($i = 5; $i >= 0; $i--) {
			$m = date('Y-m', strtotime("-$i month"));
			$donation_labels[] = date('M Y', strtotime("-$i month"));
			$sum = 0;
			if ($this->donation_m->table_exists()) {
				$this->db->select_sum('amount');
				$this->db->where('status', 'paid');
				$this->db->like('created_at', $m, 'after');
				$res = $this->db->get('donations')->row_array();
				$sum = !empty($res['amount']) ? (float)$res['amount'] : 0;
			}
			$donation_data[] = $sum;
		}
		$data['chart_donations_labels'] = $donation_labels;
		$data['chart_donations_data'] = $donation_data;

		$camp_labels = array();
		$camp_data = array();
		$this->load->model('Ngom_table_model', 'ngom_t');
		$top_camps = $this->ngom_t->get_campaigns_with_totals(5, true);
		foreach ($top_camps as $tc) {
			$camp_labels[] = mb_strimwidth($tc['title'], 0, 14, '..');
			$camp_data[] = (float)($tc['raised_amount'] ?? 0);
		}
		if (empty($camp_labels)) {
			$camp_labels = array('Support', 'Medical', 'Education');
			$camp_data = array(0, 0, 0);
		}
		$data['chart_campaigns_labels'] = $camp_labels;
		$data['chart_campaigns_data'] = $camp_data;

		$this->adminloadview('admin/dashboard', $data);
	}

	public function navbar()
	{
		$this->adminloadview('admin/addnavbar');
	}

	public function profile()
	{
		$member = $this->require_member_panel(true);
		if (!$member) {
			return;
		}
		$this->adminloadview('admin/member_profile', array('member' => $member));
	}

	/**
	 * Send random 6-digit OTP to member's email for password change authorization.
	 */
	public function send_profile_otp()
	{
		$member = $this->require_member_panel(true);
		if (!$member) {
			if ($this->input->is_ajax_request()) {
				$this->output->set_content_type('application/json')->set_output(json_encode(array(
					'success' => false,
					'message' => 'Session expired. Please log in again.'
				)));
				return;
			}
			redirect('admin/login');
			return;
		}

		$email = trim((string) ($member['email'] ?? ''));
		if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$msg = 'No valid email address found on your profile to send the OTP. Please contact administration.';
			if ($this->input->is_ajax_request()) {
				$this->output->set_content_type('application/json')->set_output(json_encode(array(
					'success' => false,
					'message' => $msg
				)));
				return;
			}
			$this->session->set_flashdata('cms_error', $msg);
			$this->session->set_flashdata('active_tab', 'security');
			redirect('admin/profile');
			return;
		}

		// Rate limit: 1 OTP per 45 seconds
		$last_sent = (int) $this->session->userdata('member_profile_otp_last_sent');
		if (time() - $last_sent < 45) {
			$wait = 45 - (time() - $last_sent);
			$msg = "Please wait {$wait} seconds before requesting a new OTP.";
			if ($this->input->is_ajax_request()) {
				$this->output->set_content_type('application/json')->set_output(json_encode(array(
					'success' => false,
					'message' => $msg
				)));
				return;
			}
			$this->session->set_flashdata('cms_error', $msg);
			$this->session->set_flashdata('active_tab', 'security');
			redirect('admin/profile');
			return;
		}

		// Generate cryptographically secure random 6-digit OTP
		$otp = (string) random_int(100000, 999999);

		$this->session->set_userdata(array(
			'member_profile_otp' => password_hash($otp, PASSWORD_DEFAULT),
			'member_profile_otp_expires' => time() + 600, // 10 minutes
			'member_profile_otp_email' => $email,
			'member_profile_otp_last_sent' => time()
		));

		log_message('info', 'Member profile OTP generated: ' . $otp . ' for email: ' . $email);

		// Send email via Ngom_mailer
		$this->load->library('Ngom_mailer', array(), 'ngommailer');
		$site_name = 'Shaheed Foundation India';
		if ($this->db->table_exists('site_settings')) {
			$this->load->model('Site_model');
			$site_name = $this->Site_model->get_all_flat()['site_name'] ?? $site_name;
		}

		$subject = 'Your Security Verification Code: ' . $otp . ' - ' . $site_name;
		$html = '<div style="font-family: Arial, sans-serif; max-width: 550px; margin: auto; padding: 25px; border: 1px solid #e5e7eb; border-radius: 12px; background: #ffffff;">'
			. '<h3 style="color: #1f2937; margin-top: 0;">Security Verification Code</h3>'
			. '<p style="color: #4b5563; font-size: 14px;">Hello <b>' . html_escape($member['name'] ?? 'Member') . '</b>,</p>'
			. '<p style="color: #4b5563; font-size: 14px;">We received a request to change your account password on <b>' . html_escape($site_name) . '</b>.</p>'
			. '<p style="color: #4b5563; font-size: 14px;">Use the following 6-digit One-Time Password (OTP) to authorize your new password:</p>'
			. '<div style="margin: 24px 0; text-align: center;">'
			. '  <span style="font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #4f46e5; background: #e0e7ff; padding: 12px 28px; border-radius: 10px; display: inline-block; font-family: monospace;">' . $otp . '</span>'
			. '</div>'
			. '<p style="color: #6b7280; font-size: 12px;">This code is valid for <b>10 minutes</b>. If you did not request this password change, please ignore this email or contact administration.</p>'
			. '<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">'
			. '<p style="color: #9ca3af; font-size: 12px; margin-bottom: 0;">' . html_escape($site_name) . ' Security Team</p>'
			. '</div>';

		$this->ngommailer->send_html($email, $subject, $html, $member['name'] ?? '');

		// Mask email for display: e.g. s***a@gmail.com
		$parts = explode('@', $email);
		$user_part = $parts[0];
		$domain_part = $parts[1] ?? '';
		if (strlen($user_part) > 2) {
			$masked_user = substr($user_part, 0, 1) . str_repeat('*', max(3, strlen($user_part) - 2)) . substr($user_part, -1);
		} else {
			$masked_user = $user_part . '***';
		}
		$masked_email = $masked_user . '@' . $domain_part;

		$success_msg = 'A 6-digit OTP verification code has been sent to your registered email (' . $masked_email . '). It is valid for 10 minutes.';

		if ($this->input->is_ajax_request()) {
			$this->output->set_content_type('application/json')->set_output(json_encode(array(
				'success' => true,
				'message' => $success_msg
			)));
			return;
		}

		$this->session->set_flashdata('cms_success', $success_msg);
		$this->session->set_flashdata('active_tab', 'security');
		redirect('admin/profile');
	}

	public function update_profile()
	{
		if (!$this->require_post()) {
			return;
		}
		$member = $this->require_member_panel(true);
		if (!$member) {
			return;
		}

		$data = array();
		$possible_fields = array('name', 'mobile', 'email', 'gender', 'dob', 'profession', 'blood_group', 'address', 'aadhar_no');
		foreach ($possible_fields as $f) {
			if ($this->input->post($f) !== null) {
				$val = trim((string) $this->input->post($f));
				if ($f === 'dob' && $val === '') {
					$val = null;
				}
				$data[$f] = $val;
			}
		}

		// Handle Password Change with Old Password OR Email OTP Verification
		$new_pass = (string) $this->input->post('password');
		$confirm_pass = (string) ($this->input->post('confirm_password') !== null ? $this->input->post('confirm_password') : $this->input->post('confirm_pass'));
		$old_pass = (string) $this->input->post('current_password');
		$entered_otp = trim((string) $this->input->post('otp_code'));

		if ($new_pass !== '') {
			if (strlen($new_pass) < 6) {
				$this->session->set_flashdata('cms_error', 'The new password must be at least 6 characters long.');
				$this->session->set_flashdata('active_tab', 'security');
				redirect('admin/profile');
				return;
			}

			if ($confirm_pass !== '' && $new_pass !== $confirm_pass) {
				$this->session->set_flashdata('cms_error', 'The new password and confirm password do not match.');
				$this->session->set_flashdata('active_tab', 'security');
				redirect('admin/profile');
				return;
			}

			$auth_verified = false;

			// Path A: User supplied Current Password
			if ($old_pass !== '') {
				$curr_hash = (string) ($member['member_password_hash'] ?? '');
				if ($curr_hash !== '' && password_verify($old_pass, $curr_hash)) {
					$auth_verified = true;
				} elseif (ENVIRONMENT !== 'production' && ($old_pass === '123456' || $old_pass === 'member123' || empty($curr_hash))) {
					// In dev mode, allow standard dev fallback
					$auth_verified = true;
				} else {
					$this->session->set_flashdata('cms_error', 'The current password you entered is incorrect.');
					$this->session->set_flashdata('active_tab', 'security');
					redirect('admin/profile');
					return;
				}
			}
			// Path B: User supplied 6-digit Email OTP
			elseif ($entered_otp !== '') {
				$stored_hash = (string) $this->session->userdata('member_profile_otp');
				$expires = (int) $this->session->userdata('member_profile_otp_expires');
				$otp_email = (string) $this->session->userdata('member_profile_otp_email');

				if (!$stored_hash || time() > $expires || $otp_email !== ($member['email'] ?? '')) {
					$this->session->set_flashdata('cms_error', 'Your 6-digit OTP verification code has expired. Please request a new OTP.');
					$this->session->set_flashdata('active_tab', 'security');
					redirect('admin/profile');
					return;
				}

				if (!password_verify($entered_otp, $stored_hash)) {
					$this->session->set_flashdata('cms_error', 'The 6-digit OTP verification code you entered is incorrect. Please check your email.');
					$this->session->set_flashdata('active_tab', 'security');
					redirect('admin/profile');
					return;
				}

				// Verified via OTP! Clear session OTP
				$this->session->unset_userdata(array('member_profile_otp', 'member_profile_otp_expires', 'member_profile_otp_email', 'member_profile_otp_last_sent'));
				$auth_verified = true;
			} else {
				// Neither Current Password nor OTP was provided
				$this->session->set_flashdata('cms_error', 'To set a new password, you must enter your Current Password OR verify using the 6-digit OTP sent to your email.');
				$this->session->set_flashdata('active_tab', 'security');
				redirect('admin/profile');
				return;
			}

			if ($auth_verified) {
				$data['member_password_hash'] = password_hash($new_pass, PASSWORD_DEFAULT);
			}
		}

		if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
			$this->load->library('upload', array(
				'upload_path' => FCPATH . 'uploads/members/',
				'allowed_types' => 'jpg|jpeg|png|webp|gif',
				'max_size' => 4096,
				'encrypt_name' => true,
			));
			if (!is_dir(FCPATH . 'uploads/members/')) {
				@mkdir(FCPATH . 'uploads/members/', 0775, true);
			}
			if ($this->upload->do_upload('photo')) {
				$udata = $this->upload->data();
				$photo_path = FCPATH . 'uploads/members/' . $udata['file_name'];
				if (!$this->validate_uploaded_file($photo_path, array('image/jpeg', 'image/png', 'image/gif', 'image/webp'))) {
					@unlink($photo_path);
					$this->session->set_flashdata('cms_error', 'The uploaded photo is not a valid image.');
					$this->session->set_flashdata('active_tab', 'edit');
					redirect('admin/profile');
					return;
				}
				$data['photo'] = 'uploads/members/' . $udata['file_name'];
			} else {
				$this->session->set_flashdata('cms_error', $this->upload->display_errors('', ''));
				$this->session->set_flashdata('active_tab', 'edit');
				redirect('admin/profile');
				return;
			}
		}

		if (!empty($data)) {
			$this->member_m->update_member($member['id'], $data);
		}

		if ($new_pass !== '') {
			$this->session->set_flashdata('active_tab', 'security');
			$this->session->set_flashdata('cms_success', 'Security settings and password updated successfully.');
		} else {
			$this->session->set_flashdata('cms_success', 'Profile updated successfully.');
		}
		redirect('admin/profile');
	}

	public function member_document($type)
	{
		$member = $this->require_member_panel();
		if (!$member) {
			return;
		}

		$doc_titles = array(
			'id-card' => 'ID Card',
			'appointment-letter' => 'Appointment Letter',
			'certificate' => 'Certificate',
		);
		if (!isset($doc_titles[$type])) {
			show_404();
			return;
		}

		$this->load->model('Site_model');
		$cms = $this->Site_model->get_all_flat();
		$org_name = !empty($cms['site_name']) ? (string) $cms['site_name'] : 'Shaheed Foundation India';

		// Verification URL
		$pid = isset($member['public_id']) && $member['public_id'] !== '' ? $member['public_id'] : md5((string)($member['id'] ?? 'guest'));
		$verify_url = site_url('member_verify/' . rawurlencode($pid));

		// Generate QR code SVG / base64 data URI (use getBarcodeSVGcode so no HTTP headers are emitted)
		$qr_data_uri = '';
		if (!class_exists('TCPDF2DBarcode') && file_exists(FCPATH . 'vendor/tecnickcom/tcpdf/tcpdf_barcodes_2d.php')) {
			require_once FCPATH . 'vendor/tecnickcom/tcpdf/tcpdf_barcodes_2d.php';
		}
		if (class_exists('TCPDF2DBarcode')) {
			$barcode = new TCPDF2DBarcode($verify_url, 'QRCODE,H');
			$svg = $barcode->getBarcodeSVGcode(3, 3, '#1a237e');
			if (!empty($svg)) {
				$qr_data_uri = 'data:image/svg+xml;base64,' . base64_encode($svg);
			}
		}

		// Member photo data URI or URL
		$member_photo = '';
		if (!empty($member['photo'])) {
			$photo_rel = ltrim(str_replace(array('/', '\\'), '/', $member['photo']), '/');
			$photo_abs = FCPATH . $photo_rel;
			if (is_file($photo_abs)) {
				$mime = function_exists('mime_content_type') ? mime_content_type($photo_abs) : 'image/jpeg';
				$member_photo = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($photo_abs));
			} else {
				$member_photo = base_url($photo_rel);
			}
		}

		// Logo data URI or URL
		$logo_uri = '';
		$possible_logos = array(
			FCPATH . 'assetsA/img/ngo-logo.png',
			FCPATH . 'assetsW/img/logo1.png',
			FCPATH . 'assetsA/img/logo-ct-dark.png'
		);
		foreach ($possible_logos as $pl) {
			if (is_file($pl)) {
				$mime = function_exists('mime_content_type') ? mime_content_type($pl) : 'image/png';
				$logo_uri = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($pl));
				break;
			}
		}
		if ($logo_uri === '') {
			$logo_uri = base_url('assetsA/img/ngo-logo.png');
		}

		// Formatted metadata
		$date_verified = !empty($member['verified_at']) ? $member['verified_at'] : (!empty($member['created_at']) ? $member['created_at'] : date('Y-m-d H:i:s'));
		$issue_date = date('d M, Y', strtotime($date_verified));
		$ref_no = 'SFOI/' . date('Y/m', strtotime($date_verified)) . '/' . str_pad((string)$member['id'], 3, '0', STR_PAD_LEFT);
		
		$member_code = !empty($member['member_id_code']) 
			? $member['member_id_code'] 
			: (!empty($member['member_user_id']) ? $member['member_user_id'] : 'MBR' . str_pad((string)$member['id'], 4, '0', STR_PAD_LEFT));

		$valid_from = !empty($member['validity_start']) ? date('M Y', strtotime($member['validity_start'])) : date('M Y', strtotime($date_verified));
		$valid_thru = !empty($member['validity_end']) ? date('M Y', strtotime($member['validity_end'])) : date('M Y', strtotime($date_verified . ' +1 year'));

		if (function_exists('header_remove')) {
			header_remove('Content-Disposition');
		}
		$this->output->set_content_type('text/html; charset=UTF-8');

		$this->adminloadview('admin/member_document_viewer', array(
			'member'          => $member,
			'document_type'   => $type,
			'document_title'  => $doc_titles[$type],
			'document_url'    => site_url('admin/member_document_file/' . rawurlencode((string) $type)),
			'download_url'    => site_url('admin/member_document_download/' . rawurlencode((string) $type)),
			'org_name'        => $org_name,
			'verify_url'      => $verify_url,
			'qr_data_uri'     => $qr_data_uri,
			'member_photo'    => $member_photo,
			'logo_uri'        => $logo_uri,
			'issue_date'      => $issue_date,
			'ref_no'          => $ref_no,
			'member_code'     => $member_code,
			'valid_from'      => $valid_from,
			'valid_thru'      => $valid_thru,
			'back_url'        => site_url('admin'),
			'cms'             => $cms,
		));
	}

	public function member_document_file($type)
	{
		$member = $this->require_member_panel();
		if (!$member) {
			return;
		}
		if ($this->input->get('stream') !== '1') {
			redirect('admin/member_document/' . rawurlencode((string) $type));
			return;
		}
		$this->render_member_document_pdf($member, $type, false);
	}

	public function member_document_download($type)
	{
		$member = $this->require_member_panel();
		if (!$member) {
			return;
		}
		$this->render_member_document_pdf($member, $type, true);
	}

	private function render_member_document_pdf($member, $type, $download)
	{
		$download = (bool) $download;

		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$ngomdoc = $this->ngomdoc;
		$org_name = 'NGO';
		$this->load->model('Site_model');
		$cms = $this->Site_model->get_all_flat();
		if (!empty($cms['site_name'])) {
			$org_name = (string) $cms['site_name'];
		}

		if ($type === 'id-card') {
			$bin = $ngomdoc->id_card_pdf($member, $org_name);
			$filename = 'member-id-card.pdf';
		} elseif ($type === 'appointment-letter') {
			$bin = $ngomdoc->appointment_pdf($member, $org_name, '');
			$filename = 'appointment-letter.pdf';
		} elseif ($type === 'certificate') {
			$bin = $ngomdoc->certificate_pdf($member, 'Certificate of Appreciation', 'This certificate is presented in recognition of valuable support and commitment towards our mission.', $org_name);
			$filename = 'certificate.pdf';
		} else {
			show_404();
			return;
		}

		$this->output->set_content_type('application/pdf');
		if ($download) {
			$this->output->set_header('Content-Disposition: attachment; filename="' . $filename . '"');
		} else {
			$this->output->set_header('Content-Disposition: inline; filename="' . $filename . '"');
		}
		$this->output->set_output($bin);
	}

	public function donation()
	{
		$member = $this->require_member_panel();
		if (!$member) return;

		$this->load->model('Donation_model', 'donations_m');
		$summary = $this->donations_m->get_stats_by_email($member['email']);

		// Load Razorpay config so key is available in view
		$rzp_key = '';
		$rzp_config = APPPATH . 'views/web/razorpay_config.php';
		if (is_file($rzp_config)) {
			include $rzp_config;
			if (defined('RAZORPAY_KEY_ID')) {
				$rzp_key = RAZORPAY_KEY_ID;
			}
		}

		$this->adminloadview('admin/member_donate', array(
			'member'       => $member,
			'total_amount' => $summary['total_amount'],
			'total_count'  => $summary['count'],
			'rzp_key'      => $rzp_key,
		));
	}

	/**
	 * Member-facing "Renew Now" page. Reachable while active (early renewal)
	 * or inactive (lapsed) — this is the one payment page a lapsed member
	 * can always get to.
	 */
	public function renew()
	{
		$member = $this->require_member_panel(true);
		if (!$member) {
			return;
		}

		$rzp_key = '';
		$rzp_config = APPPATH . 'views/web/razorpay_config.php';
		if (is_file($rzp_config)) {
			include $rzp_config;
			if (defined('RAZORPAY_KEY_ID')) {
				$rzp_key = RAZORPAY_KEY_ID;
			}
		}

		$this->adminloadview('admin/member_renew', array(
			'member'  => $member,
			'fee'     => self::RENEWAL_FEE_INR,
			'rzp_key' => $rzp_key,
		));
	}

	/** JSON — create a Razorpay order for the fixed renewal fee. */
	public function renew_create_order()
	{
		$member = $this->require_member_panel(true);
		header('Content-Type: application/json; charset=utf-8');
		if (!$member) {
			echo json_encode(array('success' => false, 'error' => 'Not logged in.'));
			return;
		}

		$rzp_config = APPPATH . 'views/web/razorpay_config.php';
		if (is_file($rzp_config)) {
			include $rzp_config;
		}
		if (!defined('RAZORPAY_KEY_ID') || !defined('RAZORPAY_KEY_SECRET') || RAZORPAY_KEY_ID === 'rzp_test_xxxxxxxx' || RAZORPAY_KEY_SECRET === 'your_secret_key') {
			echo json_encode(array('success' => false, 'error' => 'Payment gateway not configured.'));
			return;
		}

		// Amount is fixed server-side — never trust a client-supplied renewal amount.
		$amount_paise = (int) round(self::RENEWAL_FEE_INR * 100);
		$receipt = 'renewal_' . (int) $member['id'] . '_' . strtoupper(bin2hex(random_bytes(6)));
		$payload = json_encode(array(
			'amount'   => $amount_paise,
			'currency' => 'INR',
			'receipt'  => $receipt,
		));
		$ch = curl_init('https://api.razorpay.com/v1/orders');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Basic ' . base64_encode(RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET),
		));
		$response = curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$data = json_decode($response, true);

		if ($http === 200 && !empty($data['id'])) {
			echo json_encode(array(
				'success'  => true,
				'orderId'  => $data['id'],
				'amount'   => (int) $data['amount'],
				'currency' => $data['currency'],
			));
		} else {
			$msg = isset($data['error']['description']) ? $data['error']['description'] : 'Could not create order';
			echo json_encode(array('success' => false, 'error' => $msg));
		}
	}

	/** JSON — verify signature, extend membership, and reactivate the member. */
	public function renew_verify_payment()
	{
		$member = $this->require_member_panel(true);
		header('Content-Type: application/json; charset=utf-8');
		if (!$member) {
			echo json_encode(array('ok' => false, 'error' => 'Not logged in.'));
			return;
		}

		$rzp_config = APPPATH . 'views/web/razorpay_config.php';
		if (is_file($rzp_config)) {
			include $rzp_config;
		}
		if (!defined('RAZORPAY_KEY_SECRET')) {
			echo json_encode(array('ok' => false, 'error' => 'Gateway not configured'));
			return;
		}

		$raw = file_get_contents('php://input');
		$input = json_decode($raw, true);
		if (!is_array($input)) {
			echo json_encode(array('ok' => false, 'error' => 'Invalid JSON'));
			return;
		}

		$order_id = isset($input['razorpay_order_id']) ? (string) $input['razorpay_order_id'] : '';
		$payment_id = isset($input['razorpay_payment_id']) ? (string) $input['razorpay_payment_id'] : '';
		$signature = isset($input['razorpay_signature']) ? (string) $input['razorpay_signature'] : '';
		if ($order_id === '' || $payment_id === '' || $signature === '') {
			echo json_encode(array('ok' => false, 'error' => 'Missing fields'));
			return;
		}

		$expected = hash_hmac('sha256', $order_id . '|' . $payment_id, RAZORPAY_KEY_SECRET);
		if (!hash_equals($expected, $signature)) {
			echo json_encode(array('ok' => false, 'error' => 'Invalid signature'));
			return;
		}
		$order = $this->fetch_razorpay_order($order_id);
		if (!$order || (int) ($order['amount'] ?? 0) !== self::RENEWAL_FEE_INR * 100 || ($order['currency'] ?? '') !== 'INR') {
			echo json_encode(array('ok' => false, 'error' => 'Payment amount could not be verified'));
			return;
		}

		// Idempotency: a payment_id can only ever apply once.
		$existing = $this->member_m->find_renewal_by_payment_id($payment_id);
		if ($existing) {
			$refreshed = $this->member_m->find_by_id($member['id']);
			echo json_encode(array(
				'ok'            => true,
				'already'       => true,
				'validity_end'  => $refreshed['validity_end'] ?? null,
			));
			return;
		}

		$base_date = !empty($member['validity_end']) && $member['validity_end'] > date('Y-m-d')
			? $member['validity_end']
			: date('Y-m-d');
		$new_validity_end = date('Y-m-d', strtotime($base_date . ' +1 year'));
		$applied = $this->member_m->apply_renewal($member['id'], array(
			'amount'            => self::RENEWAL_FEE_INR,
			'razorpay_order_id' => $order_id,
			'payment_id'        => $payment_id,
			'new_validity_end'  => $new_validity_end,
		));

		if (!$applied) {
			echo json_encode(array('ok' => false, 'error' => 'Could not update membership. Please contact support.'));
			return;
		}

		ngom_notify(
			'Membership Renewed',
			($member['name'] ?? 'A member') . ' renewed their membership — active until ' . $new_validity_end . '.',
			'success',
			'members?status=active'
		);

		if (!empty($member['email'])) {
			$this->load->library('Ngom_mailer', array(), 'ngommailer');
			$this->ngommailer->send_renewal_confirmation($member, $new_validity_end, self::RENEWAL_FEE_INR);
		}

		echo json_encode(array(
			'ok'           => true,
			'validity_end' => $new_validity_end,
		));
	}

	private function fetch_razorpay_order($order_id)
	{
		$ch = curl_init('https://api.razorpay.com/v1/orders/' . rawurlencode($order_id));
		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 15,
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic ' . base64_encode(RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET),
			),
		));
		$response = curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$order = json_decode((string) $response, true);
		return $http === 200 && is_array($order) ? $order : null;
	}

	public function donation_history()
	{
		$member = $this->require_member_panel();
		if (!$member) return;

		$this->load->model('Donation_model', 'donations_m');
		$history = $this->donations_m->list_by_email($member['email'], 100);

		$this->adminloadview('admin/member_donation_history', array(
			'member' => $member,
			'history' => $history
		));
	}

	public function campaigns()
	{
		$member = $this->require_member_panel();
		if (!$member) return;

		$campaigns = array();
		if ($this->db->table_exists('ngom_campaigns')) {
			$this->db->order_by('id', 'DESC');
			$campaigns = $this->db->get('ngom_campaigns')->result_array();
		}

		$this->adminloadview('admin/member_campaigns', array(
			'member' => $member,
			'campaigns' => $campaigns
		));
	}

	public function events()
	{
		$member = $this->require_member_panel();
		if (!$member) return;

		$events = array();
		if ($this->db->table_exists('ngom_events')) {
			$this->db->order_by('id', 'DESC');
			$events = $this->db->get('ngom_events')->result_array();
		}

		$this->adminloadview('admin/member_events', array(
			'member' => $member,
			'events' => $events
		));
	}

	public function notifications()
	{
		$member = $this->require_member_panel();
		if (!$member) return;

		$this->load->model('Donation_model', 'donations_m');
		$recent_donations = $this->donations_m->list_by_email($member['email'], 5);

		$notifications = array();

		// Birthday notification
		if (!empty($member['dob']) && $member['dob'] !== '0000-00-00') {
			if (date('m-d', strtotime($member['dob'])) === date('m-d')) {
				$notifications[] = array(
					'icon' => 'cake',
					'color' => 'warning',
					'title' => 'Happy Birthday!',
					'body' => 'The entire NGO team wishes you a wonderful birthday! 🎂',
					'time' => 'Today'
				);
			}
		}

		// Donations notifications
		foreach ($recent_donations as $don) {
			if ($don['status'] === 'paid') {
				$notifications[] = array(
					'icon' => 'payments',
					'color' => 'success',
					'title' => 'Donation Successful',
					'body' => 'Your donation of ₹' . number_format($don['amount'], 0) . ' was received. Receipt: ' . $don['receipt_no'],
					'time' => date('d M Y', strtotime($don['created_at']))
				);
			}
		}

		// Welcome notification
		$notifications[] = array(
			'icon' => 'verified',
			'color' => 'primary',
			'title' => 'Account Verified',
			'body' => 'Welcome to Shaheed Foundation! Your member account is active.',
			'time' => !empty($member['verified_at']) ? date('d M Y', strtotime($member['verified_at'])) : 'Recently'
		);

		$this->adminloadview('admin/member_notifications', array(
			'member' => $member,
			'notifications' => $notifications
		));
	}

	public function activity()
	{
		$member = $this->require_member_panel();
		if (!$member) return;

		$this->load->model('Donation_model', 'donations_m');
		$donations = $this->donations_m->list_by_email($member['email'], 50);

		$this->adminloadview('admin/member_activity', array(
			'member' => $member,
			'donations' => $donations
		));
	}

	public function support()
	{
		$member = $this->require_member_panel();
		if (!$member) return;

		$this->adminloadview('admin/member_support', array(
			'member' => $member
		));
	}
}
