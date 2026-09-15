<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_verify extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Was missing: 'database' isn't autoloaded (see
		// application/config/autoload.php) and Member_model's constructor
		// doesn't connect it either, so $this->db below was undefined —
		// this public verification page (routed from member_verify/(:any),
		// likely linked from ID-card QR codes) fatal-errored on every visit.
		$this->load->database();
		$this->load->model('Member_model', 'member_m');
	}

	public function index($public_id = '')
	{
		if (empty($public_id)) {
			show_404();
		}

		$member = $this->db->get_where('members', array('public_id' => $public_id))->row_array();
		if (!$member) {
			$this->load->view('web/member_verify', array('status' => 'not_found'));
			return;
		}

		$this->load->view('web/member_verify', array(
			'status' => 'verified',
			'member' => $member
		));
	}
}