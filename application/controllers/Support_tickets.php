<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Support_tickets extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->load->database();
    }

    public function index() {
        if (!$this->db->table_exists('contact')) {
            $data['tickets'] = [];
            $data['table_missing'] = true;
        } else {
            $this->db->order_by('id', 'DESC');
            $data['tickets'] = $this->db->get('contact')->result_array();
            $data['table_missing'] = false;
        }
        
        $data['title'] = 'Support & Inquiries';
        $this->adminloadview('admin/support_tickets', $data);
    }

    public function delete($id) {
        $this->db->where('id', (int)$id);
        $this->db->delete('contact');
        $this->session->set_flashdata('cms_success', 'Message deleted.');
        redirect('support_tickets');
    }
}
