<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_users extends CI_Controller {

	public function index()
	{
		$this->load->model('Admin_user_model', 'admin_m');
		$this->load->model('Member_model', 'member_m');

		echo "<h1>System User Setup</h1>";

		// 1. Ensure Super Admin exists
		$admin = $this->admin_m->find_by_username('admin');
		if (!$admin) {
			$hash = password_hash('admin123', PASSWORD_BCRYPT);
			if ($this->admin_m->insert_user('admin', $hash, 'admin@example.com', 'super_admin')) {
				echo "✅ Default Admin Created: <strong>admin / admin123</strong><br>";
			}
		} else {
			echo "ℹ️ Admin account already exists.<br>";
		}

		// 2. Ensure at least one Member exists for testing
		$member_email = 'testmember@example.com';
		$this->db->where('email', $member_email);
		$member = $this->db->get('members')->row_array();

		if (!$member) {
			$member_data = array(
				'name' => 'Test Member',
				'email' => $member_email,
				'mobile' => '9999999999',
				'dob' => '1995-01-01',
				'status' => 'active'
			);
			if ($this->member_m->insert_member($member_data)) {
				echo "✅ Test Member Created: <strong>testmember@example.com</strong> (Password is 123456 by default)<br>";
			}
		} else {
			echo "ℹ️ Test member already exists.<br>";
		}

		echo "<p>Please delete this controller after use for security.</p>";
	}
}
