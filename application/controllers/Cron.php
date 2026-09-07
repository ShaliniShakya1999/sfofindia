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
		$this->load->helper('cms');
	}

	/**
	 * Send personal email wishes to members whose birthday is today.
	 */
	public function birthday_wishes()
	{
		$today_month = date('m');
		$today_day = date('d');

		$this->db->where('MONTH(dob)', $today_month);
		$this->db->where('DAY(dob)', $today_day);
		$this->db->where('status', 'active');
		$query = $this->db->get('members');
		$members = $query->result_array();

		echo "Found " . count($members) . " birthdays today.\n";

		foreach ($members as $m) {
			$to = $m['email'];
			if (empty($to)) continue;

			$name = $m['name'];
			$subject = "Happy Birthday, " . $name . "! 🎉";
			$message = "Dear " . $name . ",\n\nHappy Birthday from the entire NGO Team! ❤️\n\nWe wish you a wonderful year ahead. Thank you for being a part of our family.\n\nBest regards,\nNGO Team";

			if (ngom_send_email($to, $subject, $message)) {
				echo "Sent to " . $to . "\n";
			} else {
				echo "Failed for " . $to . "\n";
			}
		}
	}
}
