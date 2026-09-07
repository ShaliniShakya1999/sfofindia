<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Member_portal extends My_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		redirect('admin/login');
	}

	public function do_login()
	{
		redirect('admin/do_login');
	}

	public function dashboard()
	{
		redirect('admin');
	}

	public function document($type)
	{
		redirect('admin/member_document/' . rawurlencode((string) $type));
	}

	public function logout()
	{
		redirect('admin/logout');
	}
}
