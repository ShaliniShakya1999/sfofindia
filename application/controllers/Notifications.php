<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Notifications extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->load->database();
    }

    public function index() {
        $this->db->order_by('id', 'DESC');
        $this->db->limit(100);
        $data['notifications'] = $this->db->get('ngom_notifications')->result_array();
        
        $data['title'] = 'System Notifications';
        $this->adminloadview('admin/notifications', $data);
    }

    public function mark_read($id) {
        $this->db->where('id', (int)$id);
        $this->db->update('ngom_notifications', ['is_read' => 1]);
        redirect('notifications');
    }

    public function delete($id) {
        $this->db->where('id', (int)$id);
        $this->db->delete('ngom_notifications');
        redirect('notifications');
    }
}
