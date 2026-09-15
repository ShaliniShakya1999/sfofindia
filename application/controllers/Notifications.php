<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Notifications extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->require_admin_role();
        $this->load->database();
    }

    public function index() {
        $filter = strtolower(trim((string)$this->input->get('filter')));
        $counts = [
            'total'     => 0,
            'unread'    => 0,
            'members'   => 0,
            'donations' => 0,
        ];
        $notifications = [];

        if ($this->db->table_exists('ngom_notifications')) {
            $counts['total'] = (int)$this->db->count_all('ngom_notifications');
            
            $this->db->where('is_read', 0);
            $counts['unread'] = (int)$this->db->count_all_results('ngom_notifications');

            $this->db->like('title', 'Member');
            $counts['members'] = (int)$this->db->count_all_results('ngom_notifications');

            $this->db->like('title', 'Donation');
            $counts['donations'] = (int)$this->db->count_all_results('ngom_notifications');

            // Apply selected filter
            if ($filter === 'unread') {
                $this->db->where('is_read', 0);
            } elseif ($filter === 'members') {
                $this->db->like('title', 'Member');
            } elseif ($filter === 'donations') {
                $this->db->like('title', 'Donation');
            } elseif ($filter === 'system') {
                $this->db->not_like('title', 'Member');
                $this->db->not_like('title', 'Donation');
            }

            $this->db->order_by('id', 'DESC');
            $this->db->limit(150);
            $notifications = $this->db->get('ngom_notifications')->result_array();
        }

        $data = [
            'title'         => 'System Notifications',
            'notifications' => $notifications,
            'counts'        => $counts,
            'active_filter' => $filter ?: 'all',
        ];

        $this->adminloadview('admin/notifications', $data);
    }

    public function mark_read($id) {
        $this->require_post();
        $this->require_admin_role();
        $this->db->where('id', (int)$id);
        $this->db->update('ngom_notifications', ['is_read' => 1]);

        if ($this->input->is_ajax_request()) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'id' => (int)$id]));
        }

        $this->session->set_flashdata('success', 'Notification marked as read.');
        redirect('notifications');
    }

    public function mark_all_read() {
        $this->require_post();
        $this->require_admin_role();
        if ($this->db->table_exists('ngom_notifications')) {
            $this->db->update('ngom_notifications', ['is_read' => 1]);
        }

        if ($this->input->is_ajax_request()) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true]));
        }

        $this->session->set_flashdata('success', 'All notifications have been marked as read.');
        redirect('notifications');
    }

    public function delete($id) {
        $this->require_post();
        $this->require_admin_role();
        $this->db->where('id', (int)$id);
        $this->db->delete('ngom_notifications');

        if ($this->input->is_ajax_request()) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'id' => (int)$id]));
        }

        $this->session->set_flashdata('success', 'Notification deleted successfully.');
        redirect('notifications');
    }

    public function clear_all_read() {
        $this->require_post();
        $this->require_admin_role();
        if ($this->db->table_exists('ngom_notifications')) {
            $this->db->where('is_read', 1)->delete('ngom_notifications');
        }

        if ($this->input->is_ajax_request()) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true]));
        }

        $this->session->set_flashdata('success', 'Cleared all read notifications.');
        redirect('notifications');
    }

    public function unread_count() {
        $unread = 0;
        if ($this->db->table_exists('ngom_notifications')) {
            $this->db->where('is_read', 0);
            $unread = (int)$this->db->count_all_results('ngom_notifications');
        }

        $pending_members = 0;
        $inactive_renewals = 0;
        if ($this->db->table_exists('members')) {
            $pending_members = (int)$this->db->where('status', 'pending')->count_all_results('members');
            $inactive_renewals = (int)$this->db->where('status', 'inactive')->count_all_results('members');
        }

        $donations = 0;
        if ($this->db->table_exists('donations')) {
            $donations = (int)$this->db->count_all_results('donations');
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'              => 'ok',
                'unread_notifications'=> $unread,
                'pending_members'     => $pending_members,
                'inactive_renewals'   => $inactive_renewals,
                'people_pending_total'=> ($pending_members + $inactive_renewals),
                'donations'           => $donations
            ]));
    }
}
