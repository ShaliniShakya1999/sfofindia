<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Media_manager extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->load->helper('directory');
        $this->load->helper('file');
    }

    public function index() {
        $requested_path = (string) $this->input->get('path');
        // Security: Prevent directory traversal
        $requested_path = str_replace(['..', './'], '', $requested_path);
        $requested_path = trim($requested_path, '/');

        $base_upload_path = FCPATH . 'uploads/';
        $current_system_path = $base_upload_path;
        if ($requested_path !== '') {
            $current_system_path .= $requested_path . '/';
        }

        if (!is_dir($current_system_path)) {
            @mkdir($base_upload_path, 0775, true);
            $current_system_path = $base_upload_path;
            $requested_path = '';
        }

        $map = directory_map($current_system_path, 1);
        $directories = [];
        $files = [];

        if ($map) {
            foreach ($map as $item) {
                $full_item_path = $current_system_path . $item;
                if (is_dir($full_item_path)) {
                    $dir_item = trim($item, DIRECTORY_SEPARATOR);
                    $directories[] = [
                        'name' => $dir_item,
                        'path' => ($requested_path !== '' ? $requested_path . '/' : '') . $dir_item
                    ];
                } else if (is_file($full_item_path)) {
                    $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'zip'])) {
                        $files[] = [
                            'name' => $item,
                            'path' => 'uploads/' . ($requested_path !== '' ? $requested_path . '/' : '') . $item,
                            'size' => filesize($full_item_path),
                            'ext' => $ext
                        ];
                    }
                }
            }
        }

        $data['directories'] = $directories;
        $data['files'] = $files;
        $data['current_path'] = $requested_path;
        $data['title'] = 'Media Assets';
        
        $this->adminloadview('admin/media_manager', $data);
    }

    public function delete() {
        $role = (string) $this->session->userdata('cms_admin_role');
        if ($role !== 'super_admin' && $role !== 'admin') {
            $this->session->set_flashdata('cms_error', 'Only Admins can delete media files.');
            redirect('media_manager');
        }

        $file_rel = $this->input->post('file_path');
        // Basic security check
        if (strpos($file_rel, 'uploads/') === 0 && !str_contains($file_rel, '..')) {
            $full_path = FCPATH . $file_rel;
            if (is_file($full_path)) {
                unlink($full_path);
                $this->session->set_flashdata('cms_success', 'File deleted successfully.');
            }
        }
        
        $back_path = dirname($file_rel);
        $back_path = str_replace('uploads', '', $back_path);
        $back_path = trim($back_path, '/\\');
        
        redirect('media_manager' . ($back_path !== '' ? '?path=' . rawurlencode($back_path) : ''));
    }
}
