<?php

class My_Controller extends CI_Controller
{
   
    function loadview($view, $data = [])
    {
        $this->load->database();
        $this->load->model('Site_model');
        $this->load->library('session');
        $this->load->helper('cms');
        $cms = $this->Site_model->get_all_flat();
        $data = array_merge(array(
            'cms' => $cms,
            'web_hide_repeater_sidebar' => cms_web_hide_repeater_sidebar(),
        ), $data);
        $this->load->view($view, $data);
    }
    function adminloadview($view, $data = [])
    {
        $this->load->view("admin/admin", compact("view", "data"));
    }

    /**
     * Enforce role-based access control.
     * @param string|array $allowed_roles
     */
    protected function require_role($allowed_roles)
    {
        $this->load->library('session');
        $role = $this->session->userdata('cms_admin_role');

        if (!is_array($allowed_roles)) {
            $allowed_roles = array($allowed_roles);
        }

        // super_admin always has access
        if ($role === 'super_admin') {
            return true;
        }

        if (!in_array($role, $allowed_roles)) {
            $this->session->set_flashdata('cms_error', 'Access denied: Insufficient permissions.');
            redirect('admin');
            return false;
        }

        return true;
    }

    /**
     * Check if user is logged in.
     */
    protected function require_login()
    {
        $this->load->library('session');
        if (!$this->session->userdata('cms_admin_id')) {
            redirect('admin/login');
            return false;
        }
        return true;
    }
}
