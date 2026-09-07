<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
/**
 * NGO website CMS (dynamic content for public site).
 */
class Cms extends My_Controller {

	private $public_methods = array('login', 'do_login', 'logout');
	private $upload_dir = 'uploads/cms';

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'cms', 'ngom_permissions'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Site_model');
		$this->load->model('Admin_user_model', 'admin_user');

		$m = $this->router->method;
		if (!in_array($m, $this->public_methods, true)) {
			$this->require_login();
			$this->sync_cms_role_from_db();
		}
	}


	/** Keep session role in sync with DB (role changes apply without re-login). */
	private function sync_cms_role_from_db()
	{
		$id = (int) $this->session->userdata('cms_admin_id');
		if ($id < 1) {
			return;
		}
		$row = $this->admin_user->find_by_id($id);
		if ($row) {
			$this->session->set_userdata('cms_admin_role', $row['role']);
		}
	}

	/** @return string */
	private function cms_role()
	{
		$r = $this->session->userdata('cms_admin_role');
		return ($r !== null && $r !== '') ? (string) $r : 'admin';
	}

	private function cms_can_edit_site()
	{
		return ngom_can_edit_site_cms($this->cms_role());
	}

	/**
	 * @return list<string>
	 */
	private function cms_allowed_tabs()
	{
		$r = $this->cms_role();
		$core = array('settings', 'homepage', 'pages');
		$ngom = array('reports', 'events', 'projects', 'audit');
		
		if ($r === 'member') {
			return array('reports'); // Members can view reports
		}
		if ($r === 'super_admin' || $r === 'admin') {
			return array_merge($core, $ngom, array('users', 'web_update'));
		}
		if ($r === 'manager' || $r === 'coordinator') {
			return $ngom;
		}
		return array_merge($core, $ngom);
	}

	private function cms_default_tab($role)
	{
		if ($role === 'member') {
			return 'blog';
		}
		if (in_array($role, array('manager', 'coordinator'), true)) {
			return 'reports';
		}
		return 'settings';
	}

	private function cms_is_super_admin()
	{
		return $this->cms_role() === 'super_admin';
	}

	private function cms_require_site_editor()
	{
		if (!$this->cms_can_edit_site()) {
			$this->session->set_flashdata('cms_error', 'You do not have permission to change website settings.');
			redirect('cms/dashboard?tab=blog');
		}
	}

	private function cms_require_super_admin()
	{
		$this->require_role('super_admin');
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		$tab = $this->input->get('tab');
		$role = $this->cms_role();
		$allowed = $this->cms_allowed_tabs();
		$default = $this->cms_default_tab($role);
		$active = in_array($tab, $allowed, true) ? $tab : $default;
		if ($tab !== null && $tab !== '' && $active !== $tab) {
			redirect(site_url('cms/dashboard') . '?tab=' . rawurlencode($active));
		}
		$data['active_tab'] = $active;
		$data['cms_role'] = $role;
		$data['cms_tabs'] = $allowed;
		$data['title'] = 'Website CMS';
		$data['cms'] = $this->Site_model->get_all_flat();
		$data['page_fields'] = $this->page_html_field_map();
		$data['blog'] = $this->blog_form_vars();
		$data['blog_rows'] = $this->blog_list_rows();
		$data['cms_users'] = $this->cms_is_super_admin() ? $this->admin_user->all_ordered() : array();
		$data['cms_role_options'] = Admin_user_model::$roles;
		$data['report_stats'] = $this->dashboard_report_stats($role);
		$this->load->model('Ngom_table_model', 'ngom_t');
		$data['ngom_events'] = in_array('events', $allowed, true) ? $this->ngom_t->all('ngom_events') : array();
		$data['ngom_gallery'] = in_array('gallery', $allowed, true) ? $this->ngom_t->all('ngom_gallery') : array();
		$data['ngom_projects'] = in_array('projects', $allowed, true) ? $this->ngom_t->all('ngom_projects') : array();
		$data['ngom_campaigns'] = in_array('campaigns', $allowed, true) ? $this->ngom_t->get_campaigns_with_totals() : array();
		$data['ngom_audit'] = in_array('audit', $allowed, true) ? $this->ngom_t->all('ngom_audit_reports') : array();
		$data['complaints_recent'] = $this->dashboard_complaints_preview();
		$this->adminloadview('admin/cms/dashboard', $data);
	}

	public function objectives()
	{
		$data = array(
			'items' => $this->page_html_field_map(),
			'cms' => $this->Site_model->get_all_flat(),
		);
		$this->adminloadview('admin/cms/objectives_list', $data);
	}

	public function projects_list()
	{
		$this->load->model('Ngom_table_model', 'ngom_t');
		$data = array(
			'rows' => $this->ngom_t->all('ngom_projects'),
		);
		$this->adminloadview('admin/cms/projects_list', $data);
	}

	public function campaigns_manage()
	{
		$this->load->model('Ngom_table_model', 'ngom_t');
		$data = array(
			'ngom_campaigns' => $this->ngom_t->get_campaigns_with_totals(),
			'cms_role' => $this->cms_role()
		);
		$this->adminloadview('admin/cms/campaigns_manage', $data);
	}

	/**
	 * @return array<string,mixed>
	 */
	private function dashboard_report_stats($role)
	{
		$out = array();
		$this->load->model('Member_model', 'member_m');
		$this->load->model('Donation_model', 'don_m');
		if ($this->db->table_exists('members')) {
			$out['members_total'] = $this->member_m->count_all();
			if ($role === 'coordinator') {
				$uid = (int) $this->session->userdata('cms_admin_id');
				$this->db->where('added_by', $uid);
				$out['my_members'] = $this->db->count_all_results('members');
			}
		}
		if ($this->db->table_exists('donations')) {
			$out['donations_total'] = $this->don_m->sum_amount_success();
			$out['donations_count'] = $this->don_m->count_all();
		}
		if ($this->db->table_exists('ngom_admin_activity')) {
			$this->db->order_by('id', 'DESC');
			$this->db->limit(30);
			$out['activity_log'] = $this->db->get('ngom_admin_activity')->result_array();
		} else {
			$out['activity_log'] = array();
		}
		return $out;
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	private function dashboard_complaints_preview()
	{
		if (!$this->db->table_exists('complaints')) {
			return array();
		}
		$this->db->order_by('id', 'DESC');
		$this->db->limit(15);
		$r = $this->db->get('complaints')->result_array();
		return is_array($r) ? $r : array();
	}

	/**
	 * Blog add/edit form fields (same as Add_blog::index).
	 *
	 * @return array<string,mixed>
	 */
	private function blog_form_vars()
	{
		$this->load->model('Common_model', 'c_model');
		$table = 'blog';
		$id = $this->input->get('id');
		$getdata = array();
		if (!empty($id) && $this->db->table_exists($table)) {
			$getdata = $this->c_model->getSingle($table, array('md5(id)' => $id));
		}
		if (!is_array($getdata)) {
			$getdata = array();
		}
		return array(
			'stitle' => !empty($id) ? 'Update Blog' : 'Add Blog',
			'slug' => !empty($getdata['slug']) ? $getdata['slug'] : '',
			'metaTitle' => !empty($getdata['metaTitle']) ? $getdata['metaTitle'] : '',
			'metaDescription' => !empty($getdata['metaDescription']) ? $getdata['metaDescription'] : '',
			'metaKeyword' => !empty($getdata['metaKeyword']) ? $getdata['metaKeyword'] : '',
			'heading' => !empty($getdata['heading']) ? $getdata['heading'] : '',
			'description' => !empty($getdata['description']) ? $getdata['description'] : '',
			'postedBy' => !empty($getdata['postedBy']) ? $getdata['postedBy'] : '',
			'postedDate' => !empty($getdata['postedDate']) ? $getdata['postedDate'] : '',
			'subject' => !empty($getdata['subject']) ? $getdata['subject'] : '',
			'title' => !empty($getdata['title']) ? $getdata['title'] : '',
			'image' => !empty($getdata['image']) ? $getdata['image'] : '',
			'status' => !empty($getdata['status']) ? $getdata['status'] : '',
			'id' => !empty($id) ? $id : '',
			'button' => !empty($id) ? 'Update' : 'Submit',
		);
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	private function blog_list_rows()
	{
		if (!$this->db->table_exists('blog')) {
			return array();
		}
		$this->load->model('Common_model', 'c_model');
		return $this->c_model->getAll('blog', 'id DESC', null, null, 50);
	}

	public function login()
	{
		redirect('admin/login');
	}

	public function do_login()
	{
		$u = $this->input->post('username');
		$p = $this->input->post('password');
		if (!$u || !$p) {
			$this->session->set_flashdata('cms_error', 'Username and password required.');
			redirect('admin/login');
		}
		$row = $this->admin_user->find_by_username($u);
		if (!$row || !password_verify($p, $row['password_hash'])) {
			$this->session->set_flashdata('cms_error', 'Invalid login.');
			redirect('admin/login');
		}
		$this->session->set_userdata('cms_admin_id', (int) $row['id']);
		$this->session->set_userdata('cms_admin_name', $row['username']);
		$this->session->set_userdata('cms_admin_role', isset($row['role']) ? $row['role'] : 'admin');
		redirect('admin');
	}

	public function logout()
	{
		$this->session->unset_userdata(array('cms_admin_id', 'cms_admin_name', 'cms_admin_role'));
		redirect('admin/login');
	}

	public function settings()
	{
		redirect(site_url('cms/dashboard') . '?tab=settings');
	}

	public function save_settings()
	{
		$this->cms_require_site_editor();
		$keys = array(
			'site_name', 'meta_title', 'meta_description', 'meta_keywords',
			'contact_phone', 'contact_email', 'contact_address',
			'newsletter_title', 'newsletter_subtitle',
			'google_analytics_id', 'google_map_embed', 'whatsapp_float_number',
			'razorpay_key_id', 'razorpay_key_secret',
			'stripe_public_key', 'stripe_secret_key',
			'smtp_host', 'smtp_port', 'smtp_crypto', 'smtp_user', 'smtp_pass'
		);
		$save = array();
		foreach ($keys as $k) {
			$save[$k] = $this->input->post($k, true);
		}
		$save['pwa_enabled'] = $this->input->post('pwa_enabled') ? '1' : '0';
		$this->Site_model->save_batch($save);
		ngom_log_activity('settings_update', 'Updated site settings (Payment/SMTP/Branding)');
		$this->session->set_flashdata('cms_success', 'Site settings saved.');
		$tab = (string) $this->input->post('redirect_tab');
		if ($tab === '') { $tab = 'settings'; }
		redirect('cms/dashboard?tab=' . rawurlencode($tab));
	}

	/**
	 * Insert row into ngom_* table (events, gallery, projects, campaigns, audit).
	 */
	public function ngom_save()
	{
		$this->cms_require_ngom_manage();
		$this->load->helper('url');
		$this->load->model('Ngom_table_model', 'ngom_t');
		$table = (string) $this->input->post('table');
		$tab = (string) $this->input->post('redirect_tab');
		if ($tab === '') {
			$tab = 'events';
		}
		$row = array();
		if ($table === 'ngom_events') {
			$row['title'] = (string) $this->input->post('title');
			$row['slug'] = trim((string) $this->input->post('slug'));
			if ($row['slug'] === '' && $row['title'] !== '') {
				$row['slug'] = url_title($row['title'], '-', true);
			}
			$row['body'] = (string) $this->input->post('body');
			$row['event_date'] = $this->input->post('event_date') ?: null;
			
			$row['image'] = '';
			if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
				$this->load->helper('file');
				$dir = FCPATH . trim($this->upload_dir, '/\\') . DIRECTORY_SEPARATOR;
				if (!is_dir($dir)) {
					@mkdir($dir, 0775, true);
				}
				$this->load->library('upload', array(
					'upload_path' => $dir,
					'allowed_types' => 'jpg|jpeg|png|gif|webp',
					'max_size' => 8192,
					'encrypt_name' => true,
				));
				if ($this->upload->do_upload('image')) {
					$data = $this->upload->data();
					$row['image'] = rtrim($this->upload_dir, '/\\') . '/' . $data['file_name'];
				}
			}
			
			$row['status'] = (string) $this->input->post('status') ?: 'published';
		} elseif ($table === 'ngom_gallery') {
			$row['title'] = (string) $this->input->post('title') ?: 'Gallery Image';
			$row['sort_order'] = (int) $this->input->post('sort_order');
			$row['image_path'] = '';
			
			if (isset($_FILES['gallery_image']) && $_FILES['gallery_image']['error'] == 0) {
				$this->load->helper('file');
				$dir = FCPATH . trim($this->upload_dir, '/\\') . DIRECTORY_SEPARATOR;
				if (!is_dir($dir)) {
					@mkdir($dir, 0775, true);
				}
				$this->load->library('upload', array(
					'upload_path' => $dir,
					'allowed_types' => 'jpg|jpeg|png|gif|webp',
					'max_size' => 8192,
					'encrypt_name' => true,
				));
				if ($this->upload->do_upload('gallery_image')) {
					$data = $this->upload->data();
					$row['image_path'] = rtrim($this->upload_dir, '/\\') . '/' . $data['file_name'];
				} else {
					$this->session->set_flashdata('cms_error', 'Image upload failed: ' . strip_tags($this->upload->display_errors()));
					redirect('cms/dashboard?tab=' . rawurlencode($tab));
					return;
				}
			} else {
				$this->session->set_flashdata('cms_error', 'Please select an image to upload.');
				redirect('cms/dashboard?tab=' . rawurlencode($tab));
				return;
			}
		} elseif ($table === 'ngom_projects') {
			$row['title'] = (string) $this->input->post('title');
			$row['summary'] = (string) $this->input->post('summary');
			$row['body'] = (string) $this->input->post('body');
			$row['image'] = trim((string) $this->input->post('image'));
			$row['status'] = (string) $this->input->post('status') ?: 'active';
		} elseif ($table === 'ngom_campaigns') {
			$row['title'] = (string) $this->input->post('title');
			$row['goal_amount'] = (float) $this->input->post('goal_amount');
			$row['raised_display'] = (string) $this->input->post('raised_display');
			$row['description'] = (string) $this->input->post('description');
			$row['image'] = trim((string) $this->input->post('image'));
			$row['status'] = (string) $this->input->post('status') ?: 'active';
		} elseif ($table === 'ngom_audit_reports') {
			$row['title'] = (string) $this->input->post('title');
			$row['file_path'] = trim((string) $this->input->post('file_path'));
			$row['admin_user_id'] = (int) $this->session->userdata('cms_admin_id');
		} else {
			$this->session->set_flashdata('cms_error', 'Invalid module.');
			redirect('cms/dashboard?tab=' . rawurlencode($tab));
		}
		$ok = $this->ngom_t->insert_row($table, $row);
		if ($ok) {
			ngom_log_activity('ngom_insert', $table);
			$this->session->set_flashdata('cms_success', 'Saved.');
		} else {
			$this->session->set_flashdata('cms_error', 'Could not save (check required fields / DB).');
		}

		$custom_redirect = (string) $this->input->post('redirect_custom');
		if ($custom_redirect !== '') {
			redirect($custom_redirect);
		} else {
			redirect('cms/dashboard?tab=' . rawurlencode($tab));
		}
	}

	public function ngom_delete()
	{
		$this->cms_require_ngom_manage();
		$this->load->model('Ngom_table_model', 'ngom_t');
		$table = (string) $this->input->get('table');
		$id = (int) $this->input->get('id');
		$tab = (string) $this->input->get('tab');
		if ($tab === '') {
			$tab = 'events';
		}
		if ($id < 1) {
			show_404();
		}
		$ok = $this->ngom_t->delete_id($table, $id);
		if ($ok) {
			ngom_log_activity('ngom_delete', $table . '#' . $id);
			$this->session->set_flashdata('cms_success', 'Deleted.');
		} else {
			$this->session->set_flashdata('cms_error', 'Could not delete.');
		}

		$custom_redirect = (string) $this->input->get('redirect_custom');
		if ($custom_redirect !== '') {
			redirect($custom_redirect);
		} else {
			redirect('cms/dashboard?tab=' . rawurlencode($tab));
		}
	}

	/**
	 * CSV export for reports (members, donations, coordinator summary).
	 */
	public function export_report()
	{
		if (!ngom_can_view_ngom_reports($this->cms_role())) {
			$this->session->set_flashdata('cms_error', 'No permission.');
			redirect('cms/dashboard?tab=reports');
		}
		$type = (string) $this->input->get('type');
		$role = $this->cms_role();
		if ($type === 'members' && $this->db->table_exists('members')) {
			$this->db->order_by('id', 'DESC');
			if ($role === 'coordinator') {
				$this->db->where('added_by', (int) $this->session->userdata('cms_admin_id'));
			}
			$q = $this->db->get('members');
			$this->_csv_response($q, 'members_' . date('Y-m-d') . '.csv');
			return;
		}
		if ($type === 'donations' && $this->db->table_exists('donations')) {
			$this->db->order_by('id', 'DESC');
			$q = $this->db->get('donations');
			$this->_csv_response($q, 'donations_' . date('Y-m-d') . '.csv');
			return;
		}
		if ($type === 'coordinators' && $this->db->table_exists('members') && $this->db->table_exists('admin_users')) {
			$sql = 'SELECT au.id, au.username, au.role, COUNT(m.id) AS members_added
				FROM admin_users au
				LEFT JOIN members m ON m.added_by = au.id
				WHERE au.role = ?
				GROUP BY au.id, au.username, au.role
				ORDER BY members_added DESC';
			$q = $this->db->query($sql, array('coordinator'));
			$this->_csv_response($q, 'coordinator_performance_' . date('Y-m-d') . '.csv');
			return;
		}
		show_404();
	}

	/**
	 * @param object $query CI DB result
	 */
	private function _csv_response($query, $filename)
	{
		$this->load->dbutil();
		$data = $this->dbutil->csv_from_result($query);
		if ($data === false) {
			$data = '';
		}
		$this->output
			->set_content_type('text/csv; charset=UTF-8')
			->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
			->set_output("\xEF\xBB\xBF" . $data);
	}

	private function cms_require_ngom_manage()
	{
		if (!ngom_can_manage_ngom_content($this->cms_role())) {
			$this->session->set_flashdata('cms_error', 'You do not have permission to manage this content.');
			redirect('cms/dashboard?tab=reports');
		}
	}

	public function homepage()
	{
		redirect(site_url('cms/dashboard') . '?tab=homepage');
	}

	public function save_homepage()
	{
		$this->cms_require_site_editor();
		$keys = array(
			'slide1_title', 'slide1_text', 'slide1_btn1', 'slide1_btn2', 'slide1_img',
			'slide2_title', 'slide2_text', 'slide2_btn1', 'slide2_btn2', 'slide2_img',
			'slide3_title', 'slide3_text', 'slide3_btn1', 'slide3_btn2', 'slide3_img',
			'about_label', 'about_heading', 'about_p1', 'about_quote',
			'donation_box_text', 'about_image',
			'what_we_do_1', 'what_we_do_2', 'what_we_do_3', 'what_we_do_4',
		);
		$save = array();
		foreach ($keys as $k) {
			$save[$k] = $this->input->post($k, true);
		}
		$this->Site_model->save_batch($save);
		ngom_log_activity('homepage_update', 'Updated homepage content');
		$this->session->set_flashdata('cms_success', 'Homepage content saved.');
		redirect('cms/dashboard?tab=homepage');
	}

	/**
	 * Upload an image and return a relative path (JSON).
	 * Used by the CMS UI for hero/about images.
	 */
	public function upload_image()
	{
		$this->load->helper('file');
		$dir = FCPATH . trim($this->upload_dir, '/\\') . DIRECTORY_SEPARATOR;
		if (!is_dir($dir)) {
			@mkdir($dir, 0775, true);
		}

		$config = array(
			'upload_path' => $dir,
			'allowed_types' => 'jpg|jpeg|png|gif|webp',
			'max_size' => 4096,
			'encrypt_name' => true,
		);
		$this->load->library('upload', $config);

		$field = 'image';
		if (!$this->upload->do_upload($field)) {
			$this->output
				->set_content_type('application/json')
				->set_status_header(400)
				->set_output(json_encode(array('ok' => false, 'error' => strip_tags($this->upload->display_errors('', '')))));
			return;
		}

		$data = $this->upload->data();
		$rel = rtrim($this->upload_dir, '/\\') . '/' . $data['file_name'];
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('ok' => true, 'path' => $rel, 'url' => base_url($rel))));
	}

	/**
	 * Optional full-page HTML overrides (replaces default layout for that URL when non-empty).
	 *
	 * @return array<string,string>
	 */
	private function page_html_field_map()
	{
		return array(
			'page_about_html' => 'About Us',
			'page_contact_html' => 'Contact',
			'page_service_html' => 'Services',
			'page_donation_html' => 'Donation',
			'page_financial_html' => 'Financial assistance',
			'page_education_html' => 'Education support',
			'page_disability_html' => 'Medical & health care',
			'page_employment_html' => 'Employment & skills',
			'page_team_html' => 'Team',
			'page_gallery_html' => 'Gallery',
			'page_event_html' => 'Events',
			'page_feature_html' => 'Feature',
			'page_documents_html' => 'Documents',
			'page_terms_html' => 'Terms & conditions',
			'page_privacy_html' => 'Privacy policy',
			'page_legal_html' => 'Legal & compliance',
			'page_refund_html' => 'Refund policy',
		);
	}

	public function pages()
	{
		redirect(site_url('cms/dashboard') . '?tab=pages');
	}

	public function save_pages()
	{
		$this->cms_require_site_editor();
		$save = array();
		foreach (array_keys($this->page_html_field_map()) as $k) {
			$save[$k] = $this->input->post($k, false);
		}
		$this->Site_model->save_batch($save);
		$this->session->set_flashdata('cms_success', 'Page HTML saved. Clear a field and save to show the default template again.');
		redirect('cms/dashboard?tab=pages');
	}

	public function save_user()
	{
		$this->cms_require_super_admin();
		$username = trim((string) $this->input->post('username'));
		$password = (string) $this->input->post('password');
		$role = $this->input->post('role');
		if ($username === '' || $password === '') {
			$this->session->set_flashdata('cms_error', 'Username and password required.');
			redirect('cms/dashboard?tab=users');
		}
		if (strlen($password) < 6) {
			$this->session->set_flashdata('cms_error', 'Password must be at least 6 characters.');
			redirect('cms/dashboard?tab=users');
		}
		$exists = $this->admin_user->find_by_username($username);
		if ($exists) {
			$this->session->set_flashdata('cms_error', 'That username is already taken.');
			redirect('cms/dashboard?tab=users');
		}
		$ok = $this->admin_user->insert_user(
			$username,
			password_hash($password, PASSWORD_DEFAULT),
			null,
			is_string($role) ? $role : 'member'
		);
		$this->session->set_flashdata($ok ? 'cms_success' : 'cms_error', $ok ? 'User created.' : 'Could not create user.');
		redirect('cms/dashboard?tab=users');
	}

	public function update_user()
	{
		$this->cms_require_super_admin();
		$id = (int) $this->input->post('user_id');
		$role = $this->input->post('role');
		$newpass = (string) $this->input->post('new_password');
		if ($id < 1) {
			show_404();
		}
		if (is_string($role) && $role !== '') {
			$this->admin_user->update_role($id, $role);
		}
		if ($newpass !== '') {
			if (strlen($newpass) < 6) {
				$this->session->set_flashdata('cms_error', 'Password must be at least 6 characters.');
				redirect('cms/dashboard?tab=users');
			}
			$this->admin_user->update_password($id, password_hash($newpass, PASSWORD_DEFAULT));
		}
		$this->session->set_flashdata('cms_success', 'User updated.');
		redirect('cms/dashboard?tab=users');
	}

	public function delete_user()
	{
		$this->cms_require_super_admin();
		$id = (int) $this->input->get('id');
		$self = (int) $this->session->userdata('cms_admin_id');
		if ($id < 1 || $id === $self) {
			$this->session->set_flashdata('cms_error', 'Cannot delete this user.');
			redirect('cms/dashboard?tab=users');
		}
		$this->admin_user->delete_by_id($id);
		$this->session->set_flashdata('cms_success', 'User deleted.');
		redirect('cms/dashboard?tab=users');
	}
}
