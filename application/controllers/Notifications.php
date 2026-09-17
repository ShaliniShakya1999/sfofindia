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
        $this->sync_recent_system_events();
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
            
            $counts['unread'] = (int)$this->db->where('is_read', 0)->count_all_results('ngom_notifications');

            $counts['members'] = (int)$this->db->group_start()
                ->like('title', 'Member')
                ->or_like('message', 'member')
            ->group_end()->count_all_results('ngom_notifications');

            $counts['donations'] = (int)$this->db->group_start()
                ->like('title', 'Donation')
                ->or_like('message', 'donation')
                ->or_like('message', 'Receipt')
            ->group_end()->count_all_results('ngom_notifications');

            // Apply selected filter
            if ($filter === 'unread') {
                $this->db->where('is_read', 0);
            } elseif ($filter === 'members') {
                $this->db->group_start()
                    ->like('title', 'Member')
                    ->or_like('message', 'member')
                ->group_end();
            } elseif ($filter === 'donations') {
                $this->db->group_start()
                    ->like('title', 'Donation')
                    ->or_like('message', 'donation')
                    ->or_like('message', 'Receipt')
                ->group_end();
            } elseif ($filter === 'system') {
                $this->db->group_start()
                    ->not_like('title', 'Member')
                    ->not_like('message', 'member')
                ->group_end();
                $this->db->group_start()
                    ->not_like('title', 'Donation')
                    ->not_like('message', 'donation')
                    ->not_like('message', 'Receipt')
                ->group_end();
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

    /**
     * Synchronizes real database events (donations, members, contact) into notifications
     * so that the notification center and top navbar always reflect real activity.
     */
    private function sync_recent_system_events() {
        if (!$this->db->table_exists('ngom_notifications')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `ngom_notifications` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `type` VARCHAR(32) NOT NULL DEFAULT 'info',
                `title` VARCHAR(191) NOT NULL,
                `message` TEXT NULL,
                `link` VARCHAR(255) NULL,
                `is_read` TINYINT(1) NOT NULL DEFAULT 0,
                `created_at` DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } else {
            if (!$this->db->field_exists('link', 'ngom_notifications')) {
                $this->db->query("ALTER TABLE `ngom_notifications` ADD COLUMN `link` VARCHAR(255) NULL AFTER `message`");
            }
        }

        // 1. Sync Paid Donations
        if ($this->db->table_exists('donations')) {
            $donations = $this->db->where('status', 'paid')->order_by('id', 'DESC')->limit(50)->get('donations')->result_array();
            foreach ($donations as $d) {
                $receipt = trim((string)($d['receipt_no'] ?? ''));
                $did = (int)($d['id'] ?? 0);
                $exists = false;
                if ($receipt !== '') {
                    $exists = ($this->db->like('message', $receipt)->count_all_results('ngom_notifications') > 0);
                }
                if (!$exists && $did > 0) {
                    $exists = ($this->db->where('link', 'donations')->like('message', (string)$d['amount'])->count_all_results('ngom_notifications') > 0);
                }
                if (!$exists) {
                    $amount_fmt = '₹' . number_format((float)($d['amount'] ?? 0), 2);
                    $donor = !empty($d['name']) ? trim($d['name']) : 'Anonymous Donor';
                    $created = !empty($d['created_at']) ? $d['created_at'] : date('Y-m-d H:i:s');
                    $is_unread = (strtotime($created) >= strtotime('-14 days')) ? 0 : 1;
                    $this->db->insert('ngom_notifications', [
                        'type'       => 'success',
                        'title'      => 'Donation Received',
                        'message'    => $amount_fmt . ' received from ' . $donor . ($receipt ? ' (Receipt #' . $receipt . ')' : '') . '.',
                        'link'       => 'donations',
                        'is_read'    => $is_unread,
                        'created_at' => $created
                    ]);
                }
            }
        }

        // 2. Sync Pending Member Applications
        if ($this->db->table_exists('members')) {
            $pending_m = $this->db->where('status', 'pending')->order_by('id', 'DESC')->limit(30)->get('members')->result_array();
            foreach ($pending_m as $pm) {
                $name = trim($pm['name'] ?? '');
                $pm_id = (int)($pm['id'] ?? 0);
                $exists = false;
                if ($name !== '') {
                    $exists = ($this->db->like('message', $name)->like('title', 'Member')->count_all_results('ngom_notifications') > 0);
                }
                if (!$exists) {
                    $contact = !empty($pm['email']) ? $pm['email'] : ($pm['mobile'] ?? '');
                    $created = !empty($pm['created_at']) ? $pm['created_at'] : date('Y-m-d H:i:s');
                    $this->db->insert('ngom_notifications', [
                        'type'       => 'warning',
                        'title'      => 'New Member Pending',
                        'message'    => $name . ($contact ? ' (' . $contact . ')' : '') . ' applied for membership and is waiting for verification.',
                        'link'       => 'members?status=pending',
                        'is_read'    => 0,
                        'created_at' => $created
                    ]);
                }
            }
        }

        // 3. Sync Recent Active Members (created in last 30 days)
        if ($this->db->table_exists('members')) {
            $since = date('Y-m-d H:i:s', strtotime('-30 days'));
            $recent_m = $this->db->where('status', 'active')
                ->where('created_at >=', $since)
                ->order_by('id', 'DESC')
                ->limit(20)
                ->get('members')
                ->result_array();
            foreach ($recent_m as $rm) {
                $name = trim($rm['name'] ?? '');
                $rm_id = (int)($rm['id'] ?? 0);
                $exists = false;
                if ($name !== '') {
                    $exists = ($this->db->like('message', $name)->count_all_results('ngom_notifications') > 0);
                }
                if (!$exists) {
                    $created = !empty($rm['created_at']) ? $rm['created_at'] : date('Y-m-d H:i:s');
                    $this->db->insert('ngom_notifications', [
                        'type'       => 'info',
                        'title'      => 'New Member Registered',
                        'message'    => $name . ' joined as a verified member' . (!empty($rm['city']) ? ' from ' . $rm['city'] : '') . '.',
                        'link'       => 'members/form/' . $rm_id,
                        'is_read'    => 0,
                        'created_at' => $created
                    ]);
                }
            }
        }

        // 4. Sync Contact Inquiries
        if ($this->db->table_exists('contact')) {
            $recent_c = $this->db->order_by('id', 'DESC')->limit(10)->get('contact')->result_array();
            foreach ($recent_c as $c) {
                $c_name = trim($c['name'] ?? '');
                $exists = false;
                if ($c_name !== '') {
                    $exists = ($this->db->like('message', $c_name)->like('title', 'Inquiry')->count_all_results('ngom_notifications') > 0);
                }
                if (!$exists && $c_name !== '') {
                    $created = !empty($c['created_at']) ? $c['created_at'] : date('Y-m-d H:i:s');
                    $this->db->insert('ngom_notifications', [
                        'type'       => 'info',
                        'title'      => 'New Contact Inquiry',
                        'message'    => 'Inquiry from ' . $c_name . (!empty($c['subject']) ? ': ' . $c['subject'] : '') . '.',
                        'link'       => 'admin/support',
                        'is_read'    => 0,
                        'created_at' => $created
                    ]);
                }
            }
        }
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
        $this->sync_recent_system_events();
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

    public function preview_list() {
        $this->sync_recent_system_events();
        $list = [];
        if ($this->db->table_exists('ngom_notifications')) {
            $this->db->order_by('id', 'DESC');
            $this->db->limit(6);
            $rows = $this->db->get('ngom_notifications')->result_array();
            foreach ($rows as $r) {
                $time_str = date('d M, h:i A', strtotime($r['created_at']));
                $diff = time() - strtotime($r['created_at']);
                if ($diff < 60) {
                    $time_str = 'Just now';
                } elseif ($diff < 3600) {
                    $time_str = floor($diff / 60) . 'm ago';
                } elseif ($diff < 86400) {
                    $time_str = floor($diff / 3600) . 'h ago';
                } elseif ($diff < 172800) {
                    $time_str = 'Yesterday';
                }

                $icon = 'notifications';
                $color = 'text-secondary';
                if (stripos($r['title'], 'donation') !== false || stripos($r['message'], 'receipt') !== false) {
                    $icon = 'payments';
                    $color = 'text-success';
                } elseif (stripos($r['title'], 'member') !== false) {
                    $icon = 'person_add';
                    $color = 'text-info';
                }

                $list[] = [
                    'id'         => (int)$r['id'],
                    'title'      => $r['title'],
                    'message'    => mb_strimwidth($r['message'], 0, 80, '...'),
                    'link'       => !empty($r['link']) ? site_url($r['link']) : site_url('notifications'),
                    'is_unread'  => empty($r['is_read']),
                    'icon'       => $icon,
                    'color'      => $color,
                    'time_ago'   => $time_str,
                ];
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'ok',
                'items'  => $list
            ]));
    }
}
