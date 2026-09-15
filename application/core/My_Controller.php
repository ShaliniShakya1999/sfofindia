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
        // Role checks query the administrator record, so always initialize the
        // database before loading the authorization model.
        $this->load->database();
        $role = $this->session->userdata('cms_admin_role');
        if ($this->session->userdata('panel_user_type') === 'member') {
            $role = 'member';
        } else {
            $admin_id = (int) $this->session->userdata('cms_admin_id');
            if ($admin_id > 0) {
                $this->load->model('Admin_user_model', 'admin_user');
                $admin = $this->admin_user->find_by_id($admin_id);
                if (!$admin || (isset($admin['status']) && (int) $admin['status'] === 0)) {
                    $this->session->sess_destroy();
                    redirect('admin/login');
                    return false;
                }
                $role = (string) ($admin['role'] ?? 'admin');
                $this->session->set_userdata('cms_admin_role', $role);
            }
        }

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

    protected function require_post()
    {
        if (strtoupper((string) $this->input->server('REQUEST_METHOD')) !== 'POST') {
            show_error('This action requires a POST request.', 405);
            return false;
        }
        return true;
    }

    protected function require_admin_role()
    {
        return $this->require_role(array('super_admin', 'admin'));
    }

    protected function public_throttle($key, $limit, $window_seconds)
    {
        $this->load->library('session');
        $ip = (string) $this->input->ip_address();
        $session_key = 'throttle_' . sha1((string) $key . '|' . $ip);
        $state = $this->session->userdata($session_key);
        $now = time();
        if (!is_array($state) || !isset($state['started_at']) || $state['started_at'] + (int) $window_seconds <= $now) {
            $state = array('started_at' => $now, 'count' => 0);
        }
        $state['count']++;
        $this->session->set_userdata($session_key, $state);
        return $state['count'] <= (int) $limit;
    }

    protected function validate_uploaded_file($path, array $allowed_mimes)
    {
        if (!is_file($path) || !is_readable($path) || !function_exists('finfo_open')) {
            return false;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = $finfo ? finfo_file($finfo, $path) : false;
        if ($finfo) {
            finfo_close($finfo);
        }
        return is_string($mime) && in_array($mime, $allowed_mimes, true);
    }
}
