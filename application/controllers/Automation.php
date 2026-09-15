<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NGO Automation Controller
 * Triggers background tasks like Birthday wishes and Membership renewals.
 */
class Automation extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Member_model', 'members');
        $this->load->library('Ngom_mailer', [], 'ngommailer');
        $this->load->library('Ngom_whatsapp', [], 'ngomwhatsapp');
    }

    /**
     * Unified endpoint for daily cron job.
     * Suggested Cron: 0 9 * * * curl https://yourdomain.com/index.php/automation/daily
     */
    public function daily()
    {
        $configured_key = (string) getenv('SFOF_AUTOMATION_KEY');
        $provided_key = (string) $this->input->get_request_header('X-SFOF-Automation-Key', true);
        $authorized_cli = (PHP_SAPI === 'cli');
        if (!$authorized_cli && ($configured_key === '' || !hash_equals($configured_key, $provided_key))) {
            $this->output->set_status_header(403);
            $this->output->set_content_type('text/plain')->set_output('Forbidden');
            return;
        }

        $results = [];
        $results['birthdays'] = $this->send_birthday_wishes();
        $results['renewals'] = $this->process_member_renewals();
        
        $this->log_automation_activity($results);

        echo "Daily automation completed.<br>";
        echo "Birthdays processed: " . $results['birthdays'] . "<br>";
        echo "Expirations processed: " . $results['renewals'] . "<br>";
    }

    /**
     * Sends wishes to active members celebrating birthdays today.
     */
    private function send_birthday_wishes()
    {
        $today_m = date('m');
        $today_d = date('d');
        $current_year = date('Y');

        // Find members whose birthday is today and haven't been wished this year
        $this->db->where('status', 'active');
        $this->db->where('MONTH(dob)', $today_m);
        $this->db->where('DAY(dob)', $today_d);
        $this->db->group_start();
            $this->db->where('last_birthday_wish_year IS NULL');
            $this->db->or_where('last_birthday_wish_year !=', $current_year);
        $this->db->group_end();
        
        $members = $this->db->get('members')->result_array();
        $count = 0;

        foreach ($members as $m) {
            $sent = false;
            if ($this->ngommailer->send_birthday_wish($m)) {
                $sent = true;
            }
            if (!empty($m['mobile'])) {
                $this->ngomwhatsapp->send_birthday_wish_whatsapp($m);
                $sent = true;
            }
            if ($sent) {
                $this->db->where('id', $m['id']);
                $this->db->update('members', ['last_birthday_wish_year' => $current_year]);
                $count++;
            }
        }
        return $count;
    }

    /**
     * Flags expired memberships and sends reminders.
     */
    private function process_member_renewals()
    {
        $today = date('Y-m-d');
        $count = 0;

        // 1. Mark expired as inactive
        $this->db->where('status', 'active');
        $this->db->where('validity_end <', $today);
        $expired = $this->db->get('members')->result_array();
        
        foreach ($expired as $m) {
            $this->db->where('id', $m['id']);
            $this->db->update('members', ['status' => 'inactive']);
        }

        // 2. Send reminders for those expiring in 7 days
        $reminder_date = date('Y-m-d', strtotime('+7 days'));
        $this->db->where('status', 'active');
        $this->db->where('validity_end', $reminder_date);
        $expiring_soon = $this->db->get('members')->result_array();

        foreach ($expiring_soon as $m) {
             $sent = false;
             if ($this->ngommailer->send_renewal_reminder($m)) {
                 $sent = true;
             }
             if (!empty($m['mobile'])) {
                 $this->ngomwhatsapp->send_renewal_reminder_whatsapp($m);
                 $sent = true;
             }
             if ($sent) {
                 $this->db->where('id', $m['id']);
                 $this->db->update('members', ['last_renewal_reminder_date' => $today]);
                 $count++;
             }
        }

        return count($expired) + $count;
    }

    /**
     * Logs automation activity to the system logs.
     */
    private function log_automation_activity($results)
    {
        if ($this->db->table_exists('ngom_admin_activity')) {
             $log = "Automation summary: Birthdays[{$results['birthdays']}], Renewals[{$results['renewals']}]";
             $this->db->insert('ngom_admin_activity', [
                 'action' => 'automation_run',
                 'detail' => $log,
                 'created_at' => date('Y-m-d H:i:s'),
                 'admin_user_id' => 0 // System user
             ]);
        }
    }
}
