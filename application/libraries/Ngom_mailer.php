<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Enhanced Mailer for NGO Automation.
 * Handles SMTP configuration from DB and supports attachments for ID cards/Certificates.
 */
class Ngom_mailer {

    protected $CI;
    protected $config = [];

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->load_config();
        
        if (!class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
            // Attempt to load from vendor if not already loaded
            if (file_exists(FCPATH . 'vendor/autoload.php')) {
                require_once FCPATH . 'vendor/autoload.php';
            }
        }
    }

    private function load_config()
    {
        $this->CI->load->model('Site_model');
        $this->config = $this->CI->Site_model->get_all_flat();
    }

    /**
     * Internal mail sender with SMTP logic
     */
    private function setup_mail()
    {
        $mail = new PHPMailer(true);
        
        // Use DB settings if available, else fallback to hardcoded (for safety during migration)
        $host = !empty($this->config['smtp_host']) ? $this->config['smtp_host'] : 'send.one.com';
        $user = !empty($this->config['smtp_user']) ? $this->config['smtp_user'] : 'contact@jinlindia.com';
        $pass = !empty($this->config['smtp_pass']) ? $this->config['smtp_pass'] : '@jinlindia.com';
        $port = !empty($this->config['smtp_port']) ? (int)$this->config['smtp_port'] : 465;
        $crypto = !empty($this->config['smtp_crypto']) ? $this->config['smtp_crypto'] : 'ssl';

        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $user;
        $mail->Password = $pass;
        $mail->SMTPSecure = ($crypto === 'ssl') ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $port;
        
        // Important: The 'From' address MUST match the authenticated SMTP user to avoid 550 authorization errors.
        $from_email = $user; 
        $from_name = !empty($this->config['site_name']) ? $this->config['site_name'] : 'NGO Member Portal';
        
        $mail->setFrom($from_email, $from_name);
        
        // Use contact_email for Reply-To so user replies go to the NGO directly.
        if (!empty($this->config['contact_email']) && $this->config['contact_email'] !== $from_email) {
            $mail->addReplyTo($this->config['contact_email'], $from_name);
        }
        return $mail;
    }

    public function send_member_login(array $member, $plain_password, $login_url, $attachment_path = null)
    {
        if (empty($member['email'])) return false;

        $mail = $this->setup_mail();
        $mail->addAddress($member['email'], $member['name']);
        $mail->isHTML(true);
        $mail->Subject = 'Official Membership Verification - ' . ($this->config['site_name'] ?? 'NGO');
        
        $body = "<h3>Verification Successful!</h3>";
        $body .= "<p>Hello <b>" . htmlspecialchars($member['name']) . "</b>,</p>";
        $body .= "<p>We are pleased to inform you that your membership application has been verified.</p>";
        $body .= "<p><b>Login Details:</b><br>";
        $body .= "User ID: " . $member['member_user_id'] . "<br>";
        $body .= "Password: " . $plain_password . "</p>";
        $body .= "<p>Click here to login: <a href='$login_url'>$login_url</a></p>";
        
        if ($attachment_path) {
            $body .= "<p>Please find your official E-Identity Card attached to this email.</p>";
            $mail->addStringAttachment($attachment_path, 'Identity_Card.pdf');
        }
        
        $body .= "<p>Warm Regards,<br>Management Team</p>";
        $mail->Body = $body;
        
        return $mail->send();
    }

    public function send_birthday_wish(array $member)
    {
        if (empty($member['email'])) return false;

        $mail = $this->setup_mail();
        $mail->addAddress($member['email'], $member['name']);
        $mail->isHTML(true);
        $mail->Subject = 'Happy Birthday from ' . ($this->config['site_name'] ?? 'NGO') . '! 🎂';
        
        $body = "<h3>Happy Birthday " . htmlspecialchars($member['name']) . "!</h3>";
        $body .= "<p>On behalf of the entire team at <b>" . ($this->config['site_name'] ?? 'our NGO') . "</b>, we wish you a very happy birthday!</p>";
        $body .= "<p>Thank you for being a valued member and for your continued support towards our mission.</p>";
        $body .= "<p>May your day be filled with joy and success.</p>";
        $body .= "<p>Best Wishes,<br>Team " . ($this->config['site_name'] ?? 'NGO') . "</p>";
        
        $mail->Body = $body;
        return $mail->send();
    }
    
    public function send_renewal_reminder(array $member)
    {
        if (empty($member['email'])) return false;

        $mail = $this->setup_mail();
        $mail->addAddress($member['email'], $member['name']);
        $mail->isHTML(true);
        $mail->Subject = 'Membership Renewal Reminder ⚠️';
        
        $body = "<h3>Membership Renewal Notice</h3>";
        $body .= "<p>Dear " . htmlspecialchars($member['name']) . ",</p>";
        $body .= "<p>This is a friendly reminder that your membership with <b>" . ($this->config['site_name'] ?? 'our NGO') . "</b> is set to expire on " . $member['validity_end'] . ".</p>";
        $body .= "<p>To continue enjoying uninterrupted benefits and supporting our causes, please renew your membership at your earliest convenience.</p>";
        $body .= "<p>Warm Regards,<br>Administration Team</p>";
        
        $mail->Body = $body;
        return $mail->send();
    }
}
