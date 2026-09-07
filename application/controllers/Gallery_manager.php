<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
/**
 * Premium Standalone Gallery Management
 * Handles multi-image uploads and management for the NGO gallery.
 */
class Gallery_manager extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->require_login();
        $this->load->model('Ngom_table_model', 'ngom_t');
        $this->load->helper('file');
    }

    public function index() {
        $data['title'] = 'Photo Gallery 🖼️';
        $data['images'] = $this->ngom_t->all('ngom_gallery', 500);
        $this->adminloadview('admin/gallery/index', $data);
    }

    public function upload() {
        header('Content-Type: application/json');
        
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 8192; // 8MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            echo json_encode(['ok' => false, 'error' => strip_tags($this->upload->display_errors())]);
            return;
        }

        $ud = $this->upload->data();
        $rel_path = 'uploads/' . $ud['file_name'];

        $row = [
            'title' => 'Gallery Image',
            'image_path' => $rel_path,
            'sort_order' => 0
        ];

        $ok = $this->ngom_t->insert_row('ngom_gallery', $row);
        
        if ($ok) {
            echo json_encode(['ok' => true, 'path' => base_url($rel_path)]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Database save failed.']);
        }
    }

    public function delete($id) {
        $existing = $this->db->get_where('ngom_gallery', ['id' => (int)$id])->row_array();
        if ($existing) {
            $path = FCPATH . $existing['image_path'];
            if (is_file($path)) @unlink($path);
            $this->ngom_t->delete_id('ngom_gallery', $id);
        }
        $this->session->set_flashdata('cms_success', 'Image removed from gallery.');
        redirect('gallery_manager');
    }
}
