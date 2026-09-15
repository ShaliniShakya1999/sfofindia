<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_users extends CI_Controller {

	public function index()
	{
		if (PHP_SAPI !== 'cli') {
			show_404();
			return;
		}
		// Was missing: $this->db is used below (directly, and inside the
		// models via CI_Model's __get proxy) but 'database' isn't
		// autoloaded (see application/config/autoload.php), so without
		// this the very first $this->db call fatals.
		$this->load->database();

		$this->load->model('Admin_user_model', 'admin_m');
		$this->load->model('Member_model', 'member_m');
		// Make sure extended member columns (blood_group, aadhar_no,
		// district, etc.) exist before the test-member insert below runs
		// against a fresh/older copy of the database.
		$this->member_m->ensure_extended_schema();

		echo "<h1>System User Setup</h1>";

		$args = isset($_SERVER['argv']) ? $_SERVER['argv'] : array();
		$username = isset($args[1]) ? trim((string) $args[1]) : '';
		$password = isset($args[2]) ? (string) $args[2] : '';
		$email = isset($args[3]) ? trim((string) $args[3]) : '';
		if ($username === '' || strlen($password) < 12 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo "Usage: php index.php setup_users <username> <password-min-12-chars> <email>" . PHP_EOL;
			return;
		}
		if ($this->admin_m->find_by_username($username)) {
			echo "Administrator already exists." . PHP_EOL;
			return;
		}
		if ($this->admin_m->insert_user($username, password_hash($password, PASSWORD_DEFAULT), $email, 'super_admin')) {
			echo "Administrator created successfully." . PHP_EOL;
		} else {
			echo "Administrator creation failed." . PHP_EOL;
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