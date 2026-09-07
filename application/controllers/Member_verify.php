<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_verify extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
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
