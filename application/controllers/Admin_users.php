<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Admin_users extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->require_login();
		$this->load->database();
		$this->load->model('Admin_user_model', 'admin_user');
		
		$role = (string) $this->session->userdata('cms_admin_role');
		if ($role !== 'super_admin') {
			$this->session->set_flashdata('cms_error', 'Permission denied. Only Super Admins can manage users.');
			redirect('admin');
		}
	}

	public function index()
	{
		$users = $this->admin_user->all_ordered();
		
		// Calculate stats
		$stats = [
			'total' => count($users),
			'active' => 0,
			'inactive' => 0,
			'super' => 0
		];
		
		foreach ($users as $u) {
			if (($u['status'] ?? 1) == 1) $stats['active']++;
			else $stats['inactive']++;
			if ($u['role'] === 'super_admin') $stats['super']++;
		}

		$data['users'] = $users;
		$data['stats'] = $stats;
		$data['roles'] = Admin_user_model::$roles;
		$data['title'] = 'Admin Management';
		$this->adminloadview('admin/admin_users', $data);
	}

	public function save()
	{
		$username = trim((string) $this->input->post('username', true));
		$password = (string) $this->input->post('password');
		$role = (string) $this->input->post('role');
		$email = trim((string) $this->input->post('email', true));

		if ($username === '' || strlen($password) < 6) {
			$this->session->set_flashdata('cms_error', 'Username and valid Password required.');
			redirect('admin_users');
			return;
		}

		$hash = password_hash($password, PASSWORD_DEFAULT);
		$res = $this->admin_user->insert_user($username, $hash, $email, $role);
		
		if ($res) {
			$this->log_admin_activity('user_created', "Created new admin user: $username");
			$this->session->set_flashdata('cms_success', 'User created successfully.');
		} else {
			$this->session->set_flashdata('cms_error', 'Failed to create user. Duplicate username?');
		}
		redirect('admin_users');
	}

	public function update($id)
	{
		$role = (string) $this->input->post('role');
		$password = (string) $this->input->post('new_password');

		if ($password !== '') {
			if (strlen($password) < 6) {
				$this->session->set_flashdata('cms_error', 'Password too short.');
				redirect('admin_users');
				return;
			}
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$this->admin_user->update_password($id, $hash);
		}

		$this->admin_user->update_role($id, $role);
		$this->log_admin_activity('user_updated', "Updated profile/role for user ID: $id");
		$this->session->set_flashdata('cms_success', 'User updated.');
		redirect('admin_users');
	}

	public function toggle_status($id)
	{
		$self_id = (int) $this->session->userdata('cms_admin_id');
		if ((int)$id === $self_id) {
			$this->session->set_flashdata('cms_error', 'You cannot disable your own account.');
			redirect('admin_users');
			return;
		}

		$user = $this->admin_user->find_by_id($id);
		if ($user) {
			$new_status = ($user['status'] ?? 1) == 1 ? 0 : 1;
			$this->db->where('id', (int)$id)->update('admin_users', ['status' => $new_status]);
			$this->log_admin_activity('user_status_toggle', "Toggled status for user $id to " . ($new_status ? 'Active' : 'Inactive'));
			$this->session->set_flashdata('cms_success', 'Account status updated.');
		}
		redirect('admin_users');
	}

	public function delete($id)
	{
		$self_id = (int) $this->session->userdata('cms_admin_id');
		if ((int)$id === $self_id) {
			$this->session->set_flashdata('cms_error', 'Cannot delete self.');
			redirect('admin_users');
			return;
		}

		$this->admin_user->delete_by_id($id);
		$this->log_admin_activity('user_deleted', "Permanently deleted admin user ID: $id");
		$this->session->set_flashdata('cms_success', 'User removed.');
		redirect('admin_users');
	}

	private function logger($action, $detail) {
		$this->load->model('Activity_logs_model'); // Need to ensure it's not log_admin_activity if that's also model-based
	}
}
