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
	private $public_methods = array('login', 'do_login', 'logout');

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Admin_user_model', 'admin_user');
		$this->load->model('Member_model', 'member_m');
		$this->member_m->ensure_extended_schema();

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
		if ($row) {
			$this->session->set_userdata('cms_admin_role', $row['role']);
		}
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

	private function require_member_panel()
	{
		if ($this->panel_user_type() !== 'member') {
			$this->session->set_flashdata('cms_error', 'This section is available for member login only.');
			redirect('admin');
		}
		$member = $this->current_member();
		if (!$member || ($member['status'] ?? '') !== 'active') {
			$this->logout();
			return null;
		}
		return $member;
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

	public function do_login()
	{
		$u = trim((string) $this->input->post('username', true));
		$p = (string) $this->input->post('password', true);
		if (!$u || !$p) {
			$this->session->set_flashdata('cms_error', 'Username and password required.');
			redirect('admin/login');
		}
		$row = $this->admin_user->find_by_username($u);
		if ($row && !empty($row['password_hash']) && password_verify($p, $row['password_hash'])) {
			// Account Status check
			if (($row['status'] ?? 1) == 0) {
				$this->session->set_flashdata('cms_error', 'Your account has been suspended. Please contact the administrator.');
				redirect('admin/login');
				return;
			}

			// Admin login logic
			// Bypass OTP if username is 'admin' OR if email is empty
			if ($u === 'admin' || empty($row['email'])) {
				$this->db->where('id', (int)$row['id'])->update('admin_users', ['last_login' => date('Y-m-d H:i:s')]);
				$this->session->set_userdata('panel_user_type', 'admin');
				$this->session->set_userdata('cms_admin_id', (int) $row['id']);
				$this->session->set_userdata('cms_admin_name', (string) $row['username']);
				$this->session->set_userdata('cms_admin_role', (string) ($row['role'] ?? 'admin'));
				redirect('admin');
				return;
			}

			// Otherwise: Generate OTP for 2FA
			$otp = (string) rand(100000, 999999);
			$expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
			
			$this->db->where('id', $row['id']);
			$this->db->update('admin_users', array(
				'otp_code' => $otp,
				'otp_expiry' => $expiry
			));
			
			$this->load->helper('cms');
			$email = isset($row['email']) ? $row['email'] : '';
			if ($email !== '') {
				ngom_send_email($email, 'Your login OTP', 'Your one-time password is: ' . $otp);
			}
			
			$this->session->set_userdata('otp_pending_admin_id', (int) $row['id']);
			$this->session->set_flashdata('cms_success', 'OTP has been sent to your registered email.');
			redirect('admin/verify_otp');
			return;
		}

		$member = $this->member_m->find_by_member_user_id($u);
		if ($member && !empty($member['member_password_hash']) && password_verify($p, $member['member_password_hash'])) {
			if (($member['status'] ?? '') !== 'active') {
				$this->session->set_flashdata('cms_error', 'Your membership is not active yet.');
				redirect('admin/login');
			}
			$this->session->set_userdata('panel_user_type', 'member');
			$this->session->set_userdata('cms_admin_id', 'member-' . (int) $member['id']);
			$this->session->set_userdata('cms_admin_name', (string) $member['name']);
			$this->session->set_userdata('cms_admin_role', 'member');
			$this->session->set_userdata('cms_member_id', (int) $member['id']);
			$this->session->set_userdata('cms_member_user_id', (string) ($member['member_user_id'] ?? ''));
			$this->session->set_userdata('member_portal_id', (int) $member['id']);
			$this->session->set_userdata('member_portal_name', (string) $member['name']);
			redirect('admin');
			return;
		}

		$this->session->set_flashdata('cms_error', 'Invalid login.');
		redirect('admin/login');
	}

	public function verify_otp()
	{
		$admin_id = (int) $this->session->userdata('otp_pending_admin_id');
		if ($admin_id < 1) {
			redirect('admin/login');
		}
		
		if ($this->input->method() === 'post') {
			$otp = trim((string) $this->input->post('otp'));
			$row = $this->admin_user->find_by_id($admin_id);
			
			if ($row && $row['otp_code'] === $otp && strtotime($row['otp_expiry']) > time()) {
				// Clear OTP and update Last Login
				$this->db->where('id', $admin_id);
				$this->db->update('admin_users', array(
					'otp_code' => null, 
					'otp_expiry' => null,
					'last_login' => date('Y-m-d H:i:s')
				));
				
				$this->session->unset_userdata('otp_pending_admin_id');
				$this->session->set_userdata('panel_user_type', 'admin');
				$this->session->set_userdata('cms_admin_id', (int) $row['id']);
				$this->session->set_userdata('cms_admin_name', $row['username']);
				$this->session->set_userdata('cms_admin_role', isset($row['role']) ? $row['role'] : 'admin');
				$this->session->unset_userdata(array('cms_member_id', 'cms_member_user_id', 'member_portal_id', 'member_portal_name'));
				
				ngom_log_activity('login', 'Admin logged in via OTP');
				redirect('admin');
				return;
			} else {
				$this->session->set_flashdata('cms_error', 'Invalid or expired OTP.');
			}
		}
		
		$this->load->view('admin/verify_otp');
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

		$this->adminloadview('admin/dashboard', $data);
	}

	public function navbar()
	{
		$this->adminloadview('admin/addnavbar');
	}

	public function profile()
	{
		$member = $this->require_member_panel();
		if (!$member) {
			return;
		}
		$this->adminloadview('admin/member_profile', array('member' => $member));
	}

	public function update_profile()
	{
		$member = $this->require_member_panel();
		if (!$member) {
			return;
		}

		$data = array(
			'name' => trim((string) $this->input->post('name')),
			'mobile' => trim((string) $this->input->post('mobile')),
			'email' => trim((string) $this->input->post('email')),
			'gender' => trim((string) $this->input->post('gender')),
			'dob' => trim((string) $this->input->post('dob')),
			'profession' => trim((string) $this->input->post('profession')),
			'blood_group' => trim((string) $this->input->post('blood_group')),
			'address' => trim((string) $this->input->post('address')),
			'aadhar_no' => trim((string) $this->input->post('aadhar_no')),
		);

		if ($data['dob'] === '') {
			$data['dob'] = null;
		}

		// Handle Password Change
		$pass = (string) $this->input->post('password');
		if ($pass !== '') {
			$data['member_password_hash'] = password_hash($pass, PASSWORD_DEFAULT);
		}

		if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
			$this->load->library('upload', array(
				'upload_path' => FCPATH . 'uploads/member/',
				'allowed_types' => 'jpg|jpeg|png|webp|gif',
				'max_size' => 4096,
				'encrypt_name' => true,
			));
			if (!is_dir(FCPATH . 'uploads/member/')) {
				@mkdir(FCPATH . 'uploads/member/', 0775, true);
			}
			if ($this->upload->do_upload('photo')) {
				$udata = $this->upload->data();
				$data['photo'] = 'uploads/member/' . $udata['file_name'];
			} else {
				$this->session->set_flashdata('cms_error', $this->upload->display_errors('', ''));
				redirect('admin/profile');
				return;
			}
		}

		$this->member_m->update_member($member['id'], $data);
		$this->session->set_flashdata('cms_success', 'Profile updated successfully.');
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

		$this->adminloadview('admin/member_document_viewer', array(
			'member' => $member,
			'document_type' => $type,
			'document_title' => $doc_titles[$type],
			'document_url' => site_url('admin/member_document_file/' . rawurlencode((string) $type)),
			'download_url' => site_url('admin/member_document_download/' . rawurlencode((string) $type)),
		));
	}

	public function member_document_file($type)
	{
		$member = $this->require_member_panel();
		if (!$member) {
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
