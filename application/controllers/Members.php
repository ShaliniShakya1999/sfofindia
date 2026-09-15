<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');

/**
 * NGO Member management (admin — requires CMS login; blocks CMS "member" role).
 *
 * @property CI_Upload $member_id_upload
 * @property CI_Upload $member_other_upload
 * @property CI_Upload $member_receipt_upload
 * @property Ngom_documents $ngomdoc
 * @property Ngom_mailer $ngommailer
 */
class Members extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Member_model', 'members');
		$this->load->model('Admin_user_model', 'admin_user');
		$this->members->ensure_extended_schema();
		if (!$this->session->userdata('cms_admin_id')) {
			redirect('admin/login');
		}
		if ($this->session->userdata('panel_user_type') !== 'member') {
			$admin_id = (int) $this->session->userdata('cms_admin_id');
			$admin = $admin_id > 0 ? $this->admin_user->find_by_id($admin_id) : null;
			if (!$admin || (isset($admin['status']) && (int) $admin['status'] === 0)) {
				$this->session->sess_destroy();
				redirect('admin/login');
				return;
			}
			$this->session->set_userdata('cms_admin_role', (string) $admin['role']);
		}
		if ($this->cms_role() === 'member') {
			$this->session->set_flashdata('cms_error', 'Members module is not available for your role.');
			redirect('cms/dashboard?tab=blog');
		}
	}

	private function cms_role()
	{
		$r = $this->session->userdata('cms_admin_role');
		return ($r !== null && $r !== '') ? (string) $r : 'admin';
	}

	private function mark_member_notification_read($id)
	{
		if (
			$this->db->table_exists('ngom_notifications') &&
			$this->db->field_exists('link', 'ngom_notifications') &&
			$this->db->field_exists('title', 'ngom_notifications')
		) {
			$this->db
				->where('is_read', 0)
				->group_start()
					->where('link', 'members/view/' . (int) $id)
					->or_group_start()
						->where('title', 'New Membership Application')
						->where('link IS NULL', null, false)
					->group_end()
				->group_end()
				->update('ngom_notifications', array('is_read' => 1));
		}
	}

	private function upload_member_document($field_name, $allowed_mimes, $config)
	{
		$this->load->library('upload', $config, 'member_' . $field_name . '_upload');
		$uploader = $this->{'member_' . $field_name . '_upload'};
		if (!$uploader->do_upload($field_name)) {
			$this->session->set_flashdata('error', strip_tags((string) $uploader->display_errors('', '')));
			return false;
		}
		$data = $uploader->data();
		$path = $config['upload_path'] . $data['file_name'];
		if (!$this->validate_uploaded_file($path, $allowed_mimes)) {
			@unlink($path);
			$this->session->set_flashdata('error', 'The uploaded document type is not supported.');
			return false;
		}
		return 'uploads/members/' . $data['file_name'];
	}

	private function org_name()
	{
		$this->load->model('Site_model');
		$c = $this->Site_model->get_all_flat();
		return !empty($c['site_name']) ? $c['site_name'] : 'NGO';
	}

	public function index()
	{
		$status = strtolower(trim((string) $this->input->get('status', true)));
		if (
			$status === 'pending' &&
			$this->db->table_exists('ngom_notifications') &&
			$this->db->field_exists('link', 'ngom_notifications') &&
			$this->db->field_exists('title', 'ngom_notifications')
		) {
			$this->db
				->where('is_read', 0)
				->group_start()
					->where('title', 'New Membership Application')
					->or_where('link', 'members?status=pending')
				->group_end()
				->update('ngom_notifications', array('is_read' => 1));
		}
		$this->load->model('Admin_user_model', 'admin_user');
		$filters = array(
			'date_from' => $this->input->get('date_from', true),
			'date_to' => $this->input->get('date_to', true),
			'status' => $this->input->get('status', true),
			'q' => $this->input->get('q', true),
			'name' => $this->input->get('name', true),
			'mobile' => $this->input->get('mobile', true),
			'district' => $this->input->get('district', true),
			'address' => $this->input->get('address', true),
			'authority' => $this->input->get('authority', true),
			'role' => $this->input->get('role', true),
			'manager_id' => $this->input->get('manager_id', true),
			'coordinator_id' => $this->input->get('coordinator_id', true),
		);
		$data['members'] = $this->members->search($filters);
		$data['filters'] = $filters;
		$data['table_ok'] = $this->members->table_exists();
		$users = $this->admin_user->all_ordered();
		$data['manager_users'] = array_values(array_filter($users, function ($u) {
			return isset($u['role']) && $u['role'] === 'manager';
		}));
		$data['coordinator_users'] = array_values(array_filter($users, function ($u) {
			return isset($u['role']) && $u['role'] === 'coordinator';
		}));
		$status = strtolower(trim((string) $filters['status']));
		$data['status_mode'] = $status;
		if ($status === 'pending') {
			$data['page_title'] = 'Unverified Members';
			$data['page_subtitle'] = 'Review pending member applications and verify them.';
		} elseif ($status === 'active') {
			$data['page_title'] = 'Verified User';
			$data['page_subtitle'] = 'Manage active members, generated documents, and authority details.';
		} elseif ($status === 'inactive') {
			$data['page_title'] = 'Pending Renewals';
			$data['page_subtitle'] = 'Track inactive members and pending renewals.';
		} else {
			$data['page_title'] = 'Members';
			$data['page_subtitle'] = 'Add, edit, verify, and manage member records.';
		}
		$this->adminloadview('admin/ngom/members_list', $data);
	}

	public function report()
	{
		$this->index();
	}

	public function birthdays()
	{
		$data['members'] = $this->members->search(array('status' => 'active'));
		$this->adminloadview('admin/ngom/birthdays_list', $data);
	}

	public function view($id = null)
	{
		$member = $this->members->find_by_id((int) $id);
		if (!$member) {
			show_404();
		}
		$this->mark_member_notification_read($id);

		$this->adminloadview('admin/ngom/member_detail', array('member' => $member));
	}

	public function photo($id = null)
	{
		$this->document($id, 'photo');
	}

	public function document($id = null, $field = 'photo')
	{
		$allowed_fields = array('photo', 'id_document', 'other_document', 'payment_receipt', 'aadhar_front', 'aadhar_back');
		if (!in_array($field, $allowed_fields, true)) {
			show_404();
		}
		$member = $this->members->find_by_id((int) $id);
		if (!$member || empty($member[$field])) {
			show_404();
		}

		$relative_path = ltrim(str_replace('\\', '/', (string) $member[$field]), '/');
		if (strpos($relative_path, 'uploads/members/') !== 0 || strpos($relative_path, '..') !== false) {
			show_404();
		}

		$path = realpath(FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $relative_path));
		$upload_root = realpath(FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'members');
		if (!$path || !$upload_root || strpos($path, $upload_root . DIRECTORY_SEPARATOR) !== 0 || !is_file($path)) {
			show_404();
		}

		$mime_type = function_exists('mime_content_type') ? mime_content_type($path) : '';
		$allowed_types = array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf');
		if (!in_array($mime_type, $allowed_types, true)) {
			show_404();
		}

		$this->output
			->set_content_type($mime_type)
			->set_header('Content-Disposition: inline; filename="' . basename($path) . '"')
			->set_output(file_get_contents($path));
	}

	public function form($id = null)
	{
		$row = array(
			'name' => '',
			'gender' => '',
			'dob' => '',
			'relation_type' => '',
			'relation_name' => '',
			'profession' => '',
			'blood_group' => '',
			'state' => '',
			'district' => '',
			'mobile' => '',
			'aadhar_no' => '',
			'address' => '',
			'pin_code' => '',
			'email' => '',
			'photo' => '',
			'id_type' => '',
			'id_document' => '',
			'other_document' => '',
			'authority' => '',
			'validity_start' => '',
			'validity_end' => '',
			'payment_mode' => '',
			'payment_receipt' => '',
			'member_user_id' => '',
			'role' => 'member',
			'status' => 'pending',
			'joining_date' => date('Y-m-d'),
			'referral_code' => '',
			'join_source' => '',
			'notes' => '',
		);
		if ($id !== null && $id !== '') {
			$ex = $this->members->find_by_id((int) $id);
			if (!$ex) {
				show_404();
			}
			$this->mark_member_notification_read($id);
			$row = array_merge($row, $ex);
		}
		$data['member'] = $row;
		$data['is_edit'] = ($id !== null && $id !== '');
		$this->adminloadview('admin/ngom/member_form', $data);
	}

	public function save()
	{
		if ($this->input->method() !== 'post') {
			show_404();
		}
		$id = (int) $this->input->post('id');
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
			'address' => trim((string) $this->input->post('address', true)),
			'pin_code' => trim((string) $this->input->post('pin_code', true)),
			'email' => trim((string) $this->input->post('email', true)),
			'id_type' => trim((string) $this->input->post('id_type', true)),
			'authority' => trim((string) $this->input->post('authority', true)),
			'validity_start' => trim((string) $this->input->post('validity_start', true)) ?: null,
			'validity_end' => trim((string) $this->input->post('validity_end', true)) ?: null,
			'payment_mode' => trim((string) $this->input->post('payment_mode', true)),
			'role' => trim((string) $this->input->post('role', true)) ?: 'member',
			'status' => trim((string) $this->input->post('status', true)) ?: 'pending',
			'joining_date' => ($this->input->post('joining_date', true) !== '' && $this->input->post('joining_date', true) !== null)
				? $this->input->post('joining_date', true) : null,
			'referral_code' => strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $this->input->post('referral_code', true))),
			'join_source' => trim((string) $this->input->post('join_source', true)),
			'notes' => $this->input->post('notes', false),
			'added_by' => (int) $this->session->userdata('cms_admin_id'),
		);
		if ($fields['name'] === '') {
			$this->session->set_flashdata('error', 'Name is required.');
			redirect($id ? 'members/form/' . $id : 'members/form');
		}
		if ($fields['referral_code'] === '') {
			unset($fields['referral_code']);
		}
		$config = array(
			'upload_path' => FCPATH . 'uploads/members/',
			'allowed_types' => 'jpg|jpeg|png|gif|webp',
			'max_size' => 2048,
			'encrypt_name' => true,
		);
		if (!is_dir($config['upload_path'])) {
			@mkdir($config['upload_path'], 0775, true);
		}
		if (!empty($_FILES['photo']['name'])) {
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('photo')) {
				$ud = $this->upload->data();
				if ($this->validate_uploaded_file($config['upload_path'] . $ud['file_name'], array('image/jpeg', 'image/png', 'image/gif', 'image/webp'))) {
					$fields['photo'] = 'uploads/members/' . $ud['file_name'];
				} else {
					@unlink($config['upload_path'] . $ud['file_name']);
				}
			}
		}
		if (!empty($_FILES['id_document']['name'])) {
			$path = $this->upload_member_document('id_document', array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'), $config);
			if ($path !== false) $fields['id_document'] = $path;
		}
		if (!empty($_FILES['aadhar_front']['name'])) {
			$path = $this->upload_member_document('aadhar_front', array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'), $config);
			if ($path !== false) $fields['aadhar_front'] = $path;
		}
		if (!empty($_FILES['aadhar_back']['name'])) {
			$path = $this->upload_member_document('aadhar_back', array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'), $config);
			if ($path !== false) $fields['aadhar_back'] = $path;
		}
		if (!empty($_FILES['other_document']['name'])) {
			$path = $this->upload_member_document('other_document', array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'), $config);
			if ($path !== false) $fields['other_document'] = $path;
		}
		if (!empty($_FILES['payment_receipt']['name'])) {
			$path = $this->upload_member_document('payment_receipt', array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'), $config);
			if ($path !== false) $fields['payment_receipt'] = $path;
		}
		if ($id > 0) {
			if (empty($fields['referral_code'])) {
				unset($fields['referral_code']);
			}
			unset($fields['added_by']);
			$ok = $this->members->update_member($id, $fields);
			$this->session->set_flashdata($ok ? 'success' : 'error', $ok ? 'Member updated.' : 'Could not update (check referral code unique).');
			redirect('members');
		}
		$ok = $this->members->insert_member($fields);
		if ($ok) {
			$new_id = (int)$this->db->insert_id();
			ngom_notify(
				'New Member Registered',
				$fields['name'] . ' was registered as a member.',
				'info',
				$new_id > 0 ? 'members/form/' . $new_id : 'members'
			);
		}
		$this->session->set_flashdata($ok ? 'success' : 'error', $ok ? 'Member created.' : 'Could not create (check referral code).');
		redirect('members');
	}

	public function verify_member()
	{
		if ($this->input->method() !== 'post') {
			show_404();
		}

		$id = (int) $this->input->post('id');
		$member = $this->members->find_by_id($id);
		if (!$member) {
			show_404();
		}

		$plain_password = $this->generate_member_password();
		$user_id = !empty($member['member_user_id']) ? (string) $member['member_user_id'] : $this->generate_member_user_id($id);

		$fields = array(
			'authority' => trim((string) $this->input->post('authority', true)),
			'validity_start' => trim((string) $this->input->post('validity_start', true)) ?: null,
			'validity_end' => trim((string) $this->input->post('validity_end', true)) ?: null,
			'payment_mode' => trim((string) $this->input->post('payment_mode', true)),
			'status' => 'active',
			'member_user_id' => $user_id,
			'member_password_hash' => password_hash($plain_password, PASSWORD_DEFAULT),
			'verified_at' => date('Y-m-d H:i:s'),
			'verified_by' => (int) $this->session->userdata('cms_admin_id'),
		);

		$config = array(
			'upload_path' => FCPATH . 'uploads/members/',
			'allowed_types' => 'jpg|jpeg|png|gif|webp|pdf',
			'max_size' => 4096,
			'encrypt_name' => true,
		);
		if (!is_dir($config['upload_path'])) {
			@mkdir($config['upload_path'], 0775, true);
		}
		if (!empty($_FILES['payment_receipt']['name'])) {
			$path = $this->upload_member_document('payment_receipt', array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'), $config);
			if ($path !== false) $fields['payment_receipt'] = $path;
		}

		$ok = $this->members->update_member($id, $fields);
		if (!$ok) {
			$this->session->set_flashdata('error', 'Could not verify member.');
			redirect('members/form/' . $id);
		}

		$member_updated = $this->members->find_by_id($id);
		$mail_note = 'Member verified.';
		if (!empty($member_updated['email'])) {
			try {
				$this->load->library('Ngom_mailer', array(), 'ngommailer');
				$this->load->library('Ngom_documents', array(), 'ngomdoc');
				
				// Generate ID Card PDF in memory for attachment
				$id_card_pdf = $this->ngomdoc->id_card_pdf($member_updated, $this->org_name());
				
				$this->ngommailer->send_member_login($member_updated, $plain_password, site_url('member-login'), $id_card_pdf);
				
				// Mark ID card as sent
				$this->members->update_member($id, array('id_card_sent' => 1));
				
				$mail_note = 'Member verified and ID card sent via email.';
			} catch (Exception $e) {
				$mail_note = 'Member verified, but email could not be sent: ' . $e->getMessage();
			}
		}

		if (!empty($member_updated['mobile'])) {
			try {
				$this->load->library('Ngom_whatsapp', array(), 'ngomwhatsapp');
				$this->ngomwhatsapp->send_member_verified_whatsapp(
					$member_updated,
					$plain_password,
					site_url('member-login'),
					site_url('admin/member_document/id-card')
				);
			} catch (\Throwable $we) {
				log_message('error', 'Member verification WhatsApp notice error: ' . $we->getMessage());
			}
		}

		ngom_notify(
			'Member Verified',
			$member_updated['name'] . ' has been approved and verified as an active member.',
			'success',
			'members/form/' . $id
		);

		$this->session->set_flashdata('success', $mail_note);
		redirect('members/form/' . $id);
	}

	public function delete($id)
	{
		if (strtoupper((string) $this->input->server('REQUEST_METHOD')) !== 'POST') {
			show_error('This action requires a POST request.', 405);
			return;
		}
		if (!in_array($this->cms_role(), array('super_admin', 'admin'), true)) {
			show_error('Access denied.', 403);
			return;
		}
		$this->members->delete_member((int) $id);
		$this->session->set_flashdata('success', 'Member deleted.');
		redirect('members');
	}

	public function set_status()
	{
		if ($this->input->method() !== 'post') {
			show_404();
		}
		$id = (int) $this->input->post('id');
		$status = $this->input->post('status', true);
		$allowed = array('pending', 'active', 'blocked', 'inactive');
		if (!in_array($status, $allowed, true)) {
			$status = 'active';
		}
		$this->members->update_member($id, array('status' => $status));
		$this->session->set_flashdata('success', 'Status updated.');
		redirect('members');
	}

	public function document_view($id, $type = 'id-card')
	{
		$member = $this->members->find_by_id((int) $id);
		if (!$member) {
			show_404();
			return;
		}

		$doc_titles = array(
			'id-card' => 'Identity Card',
			'appointment-letter' => 'Appointment Letter',
			'certificate' => 'Certificate of Appreciation',
		);
		if (!isset($doc_titles[$type])) {
			$type = 'id-card';
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

		$pdf_action = ($type === 'id-card') ? 'pdf_id_card' : (($type === 'appointment-letter') ? 'pdf_appointment' : 'pdf_certificate');

		if (function_exists('header_remove')) {
			header_remove('Content-Disposition');
		}
		$this->output->set_content_type('text/html; charset=UTF-8');

		$this->adminloadview('admin/member_document_viewer', array(
			'member'          => $member,
			'document_type'   => $type,
			'document_title'  => $doc_titles[$type],
			'document_url'    => site_url('members/' . $pdf_action . '/' . (int)$id . '?stream=1'),
			'download_url'    => site_url('members/' . $pdf_action . '/' . (int)$id . '?download=1'),
			'back_url'        => site_url('members/detail/' . (int)$id),
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
			'cms'             => $cms,
		));
	}

	public function pdf_id_card($id)
	{
		$is_download = ($this->input->get('download') === '1');
		$is_stream = ($this->input->get('stream') === '1' || $this->input->get('raw') === '1');
		if (!$is_download && !$is_stream) {
			redirect('members/document_view/' . (int) $id . '/id-card');
			return;
		}

		$m = $this->members->find_by_id((int) $id);
		if (!$m) {
			show_404();
		}
		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$ngomdoc = $this->ngomdoc;
		$bin = $ngomdoc->id_card_pdf($m, $this->org_name());
		$disposition = $is_download ? 'attachment' : 'inline';
		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: ' . $disposition . '; filename="member-id-' . (int) $id . '.pdf"')
			->set_output($bin);
	}

	public function pdf_appointment($id)
	{
		$is_download = ($this->input->get('download') === '1');
		$is_stream = ($this->input->get('stream') === '1' || $this->input->get('raw') === '1');
		if (!$is_download && !$is_stream) {
			redirect('members/document_view/' . (int) $id . '/appointment-letter');
			return;
		}

		$m = $this->members->find_by_id((int) $id);
		if (!$m) {
			show_404();
		}
		$body = (string) $this->input->get('text', false);
		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$ngomdoc = $this->ngomdoc;
		$bin = $ngomdoc->appointment_pdf($m, $this->org_name(), $body);
		$disposition = $is_download ? 'attachment' : 'inline';
		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: ' . $disposition . '; filename="appointment-' . (int) $id . '.pdf"')
			->set_output($bin);
	}

	public function pdf_certificate($id)
	{
		$is_download = ($this->input->get('download') === '1');
		$is_stream = ($this->input->get('stream') === '1' || $this->input->get('raw') === '1');
		if (!$is_download && !$is_stream) {
			redirect('members/document_view/' . (int) $id . '/certificate');
			return;
		}

		$m = $this->members->find_by_id((int) $id);
		if (!$m) {
			show_404();
		}
		$title = $this->input->get('title', true) ?: 'Certificate of Appreciation';
		$body = $this->input->get('body', false) ?: 'This certificate is presented in recognition of valuable support and commitment towards our mission.';
		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$ngomdoc = $this->ngomdoc;
		$bin = $ngomdoc->certificate_pdf($m, $title, $body, $this->org_name());
		$disposition = $is_download ? 'attachment' : 'inline';
		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: ' . $disposition . '; filename="certificate-' . (int) $id . '.pdf"')
			->set_output($bin);
	}

	public function export()
	{
		$status = trim((string) $this->input->get('status', true));
		$members = $this->members->search(array('status' => $status));
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=members_' . ($status !== '' ? $status : 'all') . '.csv');
		$out = fopen('php://output', 'w');
		fputcsv($out, array('User ID', 'Name', 'Mobile', 'Email', 'District', 'State', 'Authority', 'Status'));
		foreach ($members as $m) {
			fputcsv($out, array(
				!empty($m['member_user_id']) ? $m['member_user_id'] : str_pad((string) $m['id'], 4, '0', STR_PAD_LEFT),
				$m['name'],
				$m['mobile'],
				isset($m['email']) ? $m['email'] : '',
				isset($m['district']) ? $m['district'] : '',
				isset($m['state']) ? $m['state'] : '',
				isset($m['authority']) ? $m['authority'] : '',
				isset($m['status']) ? $m['status'] : '',
			));
		}
		fclose($out);
		exit;
	}

	private function generate_member_user_id($id)
	{
		return 'MBR' . str_pad((string) $id, 4, '0', STR_PAD_LEFT);
	}

	private function generate_member_password()
	{
		$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
		$out = '';
		for ($i = 0; $i < 10; $i++) {
			$out .= $chars[random_int(0, strlen($chars) - 1)];
		}
		return $out;
	}
}
