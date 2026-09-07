<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
/**
 * Premium Standalone Blog Management
 * Handles listing, adding, editing, and deleting blog posts.
 */
class Blog_manager extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->require_login();
        $this->load->model('Common_model', 'c_model');
        $this->load->library('form_validation');
        $this->load->helper('cms');
    }

    public function index() {
        $data['title'] = 'Manage Blog Posts 📝';
        $data['blogs'] = $this->c_model->getAll('blog', 'id DESC');
        $this->adminloadview('admin/blog/index', $data);
    }

    public function form($id = null) {
        $data['title'] = $id ? 'Edit Blog Post' : 'Add New Blog Post';
        $data['id'] = $id;
        
        $row = [
            'slug' => '', 'metaTitle' => '', 'metaDescription' => '', 'metaKeyword' => '',
            'heading' => '', 'description' => '', 'postedBy' => 'Admin', 'postedDate' => date('Y-m-d'),
            'image' => '', 'status' => 'Active'
        ];

        if ($id) {
            $existing = $this->c_model->getSingle('blog', ['md5(id)' => $id]);
            if (!$existing) show_404();
            $row = array_merge($row, $existing);
        }

        $data['blog'] = $row;
        $this->adminloadview('admin/blog/form', $data);
    }

    public function save() {
        $id = $this->input->post('id');
        $pdata = $this->input->post();
        
        $this->form_validation->set_rules('heading', 'Heading', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('cms_error', validation_errors());
            redirect($id ? 'blog_manager/form/' . $id : 'blog_manager/form');
        }

        $saveData = [
            'slug' => !empty($pdata['slug']) ? seourl(trim($pdata['slug'])) : seourl(trim($pdata['heading'])),
            'metaTitle' => $pdata['metaTitle'],
            'metaDescription' => $pdata['metaDescription'],
            'metaKeyword' => $pdata['metaKeyword'],
            'heading' => $pdata['heading'],
            'description' => $pdata['description'],
            'postedBy' => $pdata['postedBy'],
            'postedDate' => $pdata['postedDate'],
            'status' => $pdata['status'],
        ];

        // Handle Image Upload
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $saveData['image'] = $uploadData['file_name'];
                
                // Cleanup old image
                if (!empty($pdata['old_image'])) {
                    $old_path = FCPATH . 'uploads/' . $pdata['old_image'];
                    if (is_file($old_path)) @unlink($old_path);
                }
            }
        }

        if ($id) {
            $saveData['updationDate'] = date('Y-m-d H:i:s');
            $this->c_model->saveupdate('blog', $saveData, null, ['md5(id)' => $id]);
            $this->session->set_flashdata('cms_success', 'Blog post updated successfully.');
        } else {
            $saveData['creationDate'] = date('Y-m-d H:i:s');
            $this->c_model->saveupdate('blog', $saveData);
            $this->session->set_flashdata('cms_success', 'Blog post added successfully.');
        }

        redirect('blog_manager');
    }

    public function delete($id) {
        $existing = $this->c_model->getSingle('blog', ['md5(id)' => $id]);
        if ($existing && !empty($existing['image'])) {
            $path = FCPATH . 'uploads/' . $existing['image'];
            if (is_file($path)) @unlink($path);
        }
        $this->c_model->delete('blog', ['md5(id)' => $id]);
        $this->session->set_flashdata('cms_success', 'Blog post deleted.');
        redirect('blog_manager');
    }

    public function toggle_status($id) {
        $existing = $this->c_model->getSingle('blog', ['md5(id)' => $id]);
        $new_status = ($existing['status'] == 'Active') ? 'Inactive' : 'Active';
        $this->c_model->saveupdate('blog', ['status' => $new_status], null, ['md5(id)' => $id]);
        echo $new_status;
    }
}
