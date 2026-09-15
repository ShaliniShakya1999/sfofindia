<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CLI controller for scheduled tasks (Cron Jobs).
 * Usage: php index.php cron birthday_wishes
 */
class Cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!is_cli()) {
			show_error('CLI access only.');
		}
		$this->load->database();
		$this->load->model('Member_model', 'member_m');
		$this->load->library('Ngom_mailer', array(), 'ngommailer');
	}

	/**
	 * Send personal email wishes to members whose birthday is today.
	 */
	public function birthday_wishes()
	{
		$today_month = date('m');
		$today_day = date('d');
		$current_year = date('Y');

		$this->db->where('MONTH(dob)', $today_month);
		$this->db->where('DAY(dob)', $today_day);
		$this->db->where('status', 'active');
		$this->db->group_start();
		$this->db->where('last_birthday_wish_year IS NULL');
		$this->db->or_where('last_birthday_wish_year !=', $current_year);
		$this->db->group_end();
		$query = $this->db->get('members');
		$members = $query->result_array();

		echo "Found " . count($members) . " birthdays today.\n";

		foreach ($members as $m) {
			if ($this->ngommailer->send_birthday_wish($m)) {
				$this->db->where('id', (int) $m['id']);
				$this->db->update('members', array('last_birthday_wish_year' => $current_year));
				echo "Sent to " . ($m['email'] ?? '') . "\n";
			} else {
				echo "Failed for " . ($m['email'] ?? '') . "\n";
			}
		}
	}
}
