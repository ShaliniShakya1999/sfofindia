<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Reports extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->load->database();
        
        $role = (string) $this->session->userdata('cms_admin_role');
        if ($role === 'member') {
            redirect('admin');
        }
    }

    public function index() {
        // --- 1. Top Level Stats ---
        $data['total_members'] = $this->db->count_all('members');
        $data['active_members'] = $this->db->where('status', 'active')->count_all_results('members');
        
        $this->db->select_sum('amount');
        $this->db->where('status', 'paid');
        $q_don = $this->db->get('donations')->row_array();
        $data['total_donations'] = (float) ($q_don['amount'] ?? 0);

        $data['total_campaigns'] = $this->db->count_all('ngom_campaigns');

        // --- 2. Member Growth (Last 6 Months) ---
        $months = [];
        $member_stats = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = date('Y-m', strtotime("-$i months"));
            $months[] = date('M Y', strtotime("-$i months"));
            
            $this->db->where("DATE_FORMAT(created_at, '%Y-%m') =", $m);
            $member_stats[] = $this->db->count_all_results('members');
        }
        $data['months_js'] = json_encode($months);
        $data['member_growth_js'] = json_encode($member_stats);

        // --- 3. Donation Trends (Last 6 Months) ---
        $donation_stats = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = date('Y-m', strtotime("-$i months"));
            $this->db->select_sum('amount');
            $this->db->where('status', 'paid');
            $this->db->where("DATE_FORMAT(created_at, '%Y-%m') =", $m);
            $res = $this->db->get('donations')->row_array();
            $donation_stats[] = (float) ($res['amount'] ?? 0);
        }
        $data['donation_trends_js'] = json_encode($donation_stats);

        // --- 4. Campaign Performance ---
        $this->db->select('title, goal_amount');
        $this->db->from('ngom_campaigns');
        $this->db->limit(5);
        $campaigns = $this->db->get()->result_array();
        
        foreach ($campaigns as &$c) {
            // This is a placeholder for actual campaign-linkage if exists
            // For now just random progress or real if donations table has campaign_id
            $c['raised'] = 0; // Simplified for now
        }
        $data['campaigns'] = $campaigns;

        $data['title'] = 'Advanced Performance Analytics';
        $this->adminloadview('admin/reports', $data);
    }
}
