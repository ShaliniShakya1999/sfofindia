<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NGO Member management (admin — requires CMS login; blocks CMS "member" role).
 *
 * @property CI_Upload $member_id_upload
 * @property CI_Upload $member_other_upload
 * @property CI_Upload $member_receipt_upload
 * @property Ngom_documents $ngomdoc
 * @property Ngom_mailer $ngommailer
 */
class Members extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Member_model', 'members');
		$this->members->ensure_extended_schema();
		if (!$this->session->userdata('cms_admin_id')) {
			redirect('admin/login');
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

	private function org_name()
	{
		$this->load->model('Site_model');
		$c = $this->Site_model->get_all_flat();
		return !empty($c['site_name']) ? $c['site_name'] : 'NGO';
	}

	public function index()
	{
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
				$fields['photo'] = 'uploads/members/' . $ud['file_name'];
			}
		}
		if (!empty($_FILES['id_document']['name'])) {
			$this->load->library('upload', $config, 'member_id_upload');
			$member_id_upload = $this->member_id_upload;
			if ($member_id_upload->do_upload('id_document')) {
				$ud = $member_id_upload->data();
				$fields['id_document'] = 'uploads/members/' . $ud['file_name'];
			}
		}
		if (!empty($_FILES['aadhar_front']['name'])) {
			$this->load->library('upload', $config, 'member_af_upload');
			$member_af_upload = $this->member_af_upload;
			if ($member_af_upload->do_upload('aadhar_front')) {
				$ud = $member_af_upload->data();
				$fields['aadhar_front'] = 'uploads/members/' . $ud['file_name'];
			}
		}
		if (!empty($_FILES['aadhar_back']['name'])) {
			$this->load->library('upload', $config, 'member_ab_upload');
			$member_ab_upload = $this->member_ab_upload;
			if ($member_ab_upload->do_upload('aadhar_back')) {
				$ud = $member_ab_upload->data();
				$fields['aadhar_back'] = 'uploads/members/' . $ud['file_name'];
			}
		}
		if (!empty($_FILES['other_document']['name'])) {
			$this->load->library('upload', $config, 'member_other_upload');
			$member_other_upload = $this->member_other_upload;
			if ($member_other_upload->do_upload('other_document')) {
				$ud = $member_other_upload->data();
				$fields['other_document'] = 'uploads/members/' . $ud['file_name'];
			}
		}
		if (!empty($_FILES['payment_receipt']['name'])) {
			$this->load->library('upload', $config, 'member_receipt_upload');
			$member_receipt_upload = $this->member_receipt_upload;
			if ($member_receipt_upload->do_upload('payment_receipt')) {
				$ud = $member_receipt_upload->data();
				$fields['payment_receipt'] = 'uploads/members/' . $ud['file_name'];
			}
		}
		if ($id > 0) {
			if (empty($fields['referral_code'])) {
				unset($fields['referral_code']);
			}
			unset($fields['added_by']);
			$ok = $this->members->update_member($id, $fields);
			$this->session->set_flashdata($ok ? 'success' : 'error', $ok ? 'Member updated.' : 'Could not update (check referral code unique).');
			redirect('members/form/' . $id);
		}
		$ok = $this->members->insert_member($fields);
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
			$this->load->library('upload', $config, 'member_receipt_upload');
			$member_receipt_upload = $this->member_receipt_upload;
			if ($member_receipt_upload->do_upload('payment_receipt')) {
				$ud = $member_receipt_upload->data();
				$fields['payment_receipt'] = 'uploads/members/' . $ud['file_name'];
			}
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

		$this->session->set_flashdata('success', $mail_note);
		redirect('members/form/' . $id);
	}

	public function delete($id)
	{
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

	public function pdf_id_card($id)
	{
		$m = $this->members->find_by_id((int) $id);
		if (!$m) {
			show_404();
		}
		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$ngomdoc = $this->ngomdoc;
		$bin = $ngomdoc->id_card_pdf($m, $this->org_name());
		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: inline; filename="member-id-' . (int) $id . '.pdf"')
			->set_output($bin);
	}

	public function pdf_appointment($id)
	{
		$m = $this->members->find_by_id((int) $id);
		if (!$m) {
			show_404();
		}
		$body = (string) $this->input->get('text', false);
		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$ngomdoc = $this->ngomdoc;
		$bin = $ngomdoc->appointment_pdf($m, $this->org_name(), $body);
		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: inline; filename="appointment-' . (int) $id . '.pdf"')
			->set_output($bin);
	}

	public function pdf_certificate($id)
	{
		$m = $this->members->find_by_id((int) $id);
		if (!$m) {
			show_404();
		}
		$title = $this->input->get('title', true) ?: 'Certificate of Appreciation';
		$body = $this->input->get('body', false) ?: 'This certificate is presented in recognition of valuable support and commitment towards our mission.';
		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$ngomdoc = $this->ngomdoc;
		$bin = $ngomdoc->certificate_pdf($m, $title, $body, $this->org_name());
		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: inline; filename="certificate-' . (int) $id . '.pdf"')
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

	private function adminloadview($view, $data = array())
	{
		$this->load->view('admin/admin', array('view' => $view, 'data' => $data));
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
