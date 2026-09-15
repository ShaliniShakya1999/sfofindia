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
        if (!class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
            throw new RuntimeException('PHPMailer is not installed.');
        }
        $mail = new PHPMailer(true);

        $host = !empty($this->config['smtp_host'])
            ? $this->config['smtp_host']
            : (string) getenv('SFOF_SMTP_HOST');

        $user = !empty($this->config['smtp_user'])
            ? $this->config['smtp_user']
            : (string) getenv('SFOF_SMTP_USER');

        $pass = !empty($this->config['smtp_pass'])
            ? $this->config['smtp_pass']
            : (string) getenv('SFOF_SMTP_PASSWORD');

        $port = !empty($this->config['smtp_port'])
            ? (int) $this->config['smtp_port']
            : (int) (getenv('SFOF_SMTP_PORT') ?: 465);

        $crypto = !empty($this->config['smtp_crypto'])
            ? strtolower(trim($this->config['smtp_crypto']))
            : strtolower((string) (getenv('SFOF_SMTP_CRYPTO') ?: 'ssl'));

        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $user;
        $mail->Password = $pass;

        if ($crypto === 'ssl' || $crypto === 'smtps') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }

        $mail->Port = $port;
        $mail->Timeout = 15;

        $from_email = '';
        if (!empty($this->config['smtp_from_email']) && filter_var(trim($this->config['smtp_from_email']), FILTER_VALIDATE_EMAIL)) {
            $from_email = trim($this->config['smtp_from_email']);
        } elseif (($env_from = getenv('SFOF_SMTP_FROM_EMAIL')) && filter_var(trim((string)$env_from), FILTER_VALIDATE_EMAIL)) {
            $from_email = trim((string)$env_from);
        } elseif (filter_var(trim($user), FILTER_VALIDATE_EMAIL)) {
            $from_email = trim($user);
        } elseif (!empty($this->config['contact_email']) && filter_var(trim($this->config['contact_email']), FILTER_VALIDATE_EMAIL)) {
            $from_email = trim($this->config['contact_email']);
        } elseif (!empty($this->config['email']) && filter_var(trim($this->config['email']), FILTER_VALIDATE_EMAIL)) {
            $from_email = trim($this->config['email']);
        } else {
            $host_domain = !empty($_SERVER['HTTP_HOST']) ? preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']) : 'sfofindia.org';
            $from_email = 'noreply@' . ($host_domain === 'localhost' ? 'sfofindia.org' : $host_domain);
        }

        $from_name = !empty($this->config['site_name'])
            ? $this->config['site_name']
            : 'NGO Member Portal';

        $mail->setFrom($from_email, $from_name);

        if (
            !empty($this->config['contact_email']) &&
            filter_var($this->config['contact_email'], FILTER_VALIDATE_EMAIL) &&
            $this->config['contact_email'] !== $from_email
        ) {
            $mail->addReplyTo(
                $this->config['contact_email'],
                $from_name
            );
        }

        return $mail;
    }

    /**
     * Send a generic HTML message using the same transport as transactional mail.
     */
    public function send_html($to, $subject, $html, $recipient_name = '')
    {
        if (!filter_var((string) $to, FILTER_VALIDATE_EMAIL)) {
            log_message('error', 'Email delivery skipped: invalid recipient address.');
            return false;
        }

        try {
            $mail = $this->setup_mail();
            $mail->addAddress((string) $to, (string) $recipient_name);
            $mail->isHTML(true);
            $mail->Subject = (string) $subject;
            $mail->Body = (string) $html;
            return $mail->send();
        } catch (\Throwable $e) {
            log_message('error', 'Email delivery failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send membership verification/login details.
     */
    public function send_member_login(
        array $member,
        $plain_password,
        $login_url,
        $attachment_path = null
    ) {
        if (empty($member['email'])) {
            return false;
        }

        $mail = $this->setup_mail();

        $mail->addAddress(
            $member['email'],
            $member['name'] ?? ''
        );

        $mail->isHTML(true);

        $mail->Subject =
            'Official Membership Verification - ' .
            ($this->config['site_name'] ?? 'NGO');

        $body = "<h3>Verification Successful!</h3>";

        $body .= "<p>Hello <b>" .
            htmlspecialchars($member['name'] ?? 'Member') .
            "</b>,</p>";

        $body .= "<p>We are pleased to inform you that your membership application has been verified.</p>";

        $body .= "<p><b>Login Details:</b><br>";

        $body .= "User ID: " .
            htmlspecialchars($member['member_user_id'] ?? '') .
            "<br>";

        $body .= "Password: " .
            htmlspecialchars($plain_password) .
            "</p>";

        $body .= "<p>Click here to login: ";
        $body .= "<a href=\"" .
            htmlspecialchars($login_url) .
            "\">" .
            htmlspecialchars($login_url) .
            "</a></p>";

        if ($attachment_path) {
            $body .= "<p>Please find your official E-Identity Card attached to this email.</p>";

            $mail->addStringAttachment(
                $attachment_path,
                'Identity_Card.pdf'
            );
        }

        $body .= "<p>Warm Regards,<br>Management Team</p>";

        $mail->Body = $body;

        return $mail->send();
    }

    /**
     * Send birthday wishes.
     */
    public function send_birthday_wish(array $member)
    {
        if (empty($member['email'])) {
            return false;
        }

        $mail = $this->setup_mail();

        $mail->addAddress(
            $member['email'],
            $member['name'] ?? ''
        );

        $mail->isHTML(true);

        $mail->Subject =
            'Happy Birthday from ' .
            ($this->config['site_name'] ?? 'NGO') .
            '! 🎂';

        $body = "<h3>Happy Birthday " .
            htmlspecialchars($member['name'] ?? 'Member') .
            "!</h3>";

        $body .= "<p>On behalf of the entire team at <b>" .
            htmlspecialchars($this->config['site_name'] ?? 'our NGO') .
            "</b>, we wish you a very happy birthday!</p>";

        $body .= "<p>Thank you for being a valued member and for your continued support towards our mission.</p>";

        $body .= "<p>May your day be filled with joy and success.</p>";

        $body .= "<p>Best Wishes,<br>Team " .
            htmlspecialchars($this->config['site_name'] ?? 'NGO') .
            "</p>";

        $mail->Body = $body;

        return $mail->send();
    }

    /**
     * Send membership renewal reminder.
     */
    public function send_renewal_reminder(array $member)
    {
        if (empty($member['email'])) {
            return false;
        }

        $mail = $this->setup_mail();

        $mail->addAddress(
            $member['email'],
            $member['name'] ?? ''
        );

        $mail->isHTML(true);

        $mail->Subject = 'Membership Renewal Reminder ⚠️';

        $body = "<h3>Membership Renewal Notice</h3>";

        $body .= "<p>Dear " .
            htmlspecialchars($member['name'] ?? 'Member') .
            ",</p>";

        $body .= "<p>This is a friendly reminder that your membership with <b>" .
            htmlspecialchars($this->config['site_name'] ?? 'our NGO') .
            "</b> is set to expire on " .
            htmlspecialchars($member['validity_end'] ?? '') .
            ".</p>";

        $body .= "<p>To continue enjoying uninterrupted benefits and supporting our causes, please renew your membership at your earliest convenience.</p>";

        $renew_url = site_url('admin/renew');
        $body .= "<p style='text-align:center;margin:24px 0;'>" .
            "<a href='" . htmlspecialchars($renew_url) . "' style='background:#4f46e5;color:#ffffff;padding:12px 28px;border-radius:30px;text-decoration:none;font-weight:bold;display:inline-block;'>Renew Now</a>" .
            "</p>";

        $body .= "<p>If the button above doesn't work, log in to your member panel and click <b>\"Renew Membership\"</b> in the sidebar, or visit: <a href='" . htmlspecialchars($renew_url) . "'>" . htmlspecialchars($renew_url) . "</a></p>";

        $body .= "<p>Warm Regards,<br>Administration Team</p>";

        $mail->Body = $body;

        return $mail->send();
    }

    /**
     * Send a confirmation after a membership renewal payment succeeds.
     */
    public function send_renewal_confirmation(array $member, $new_validity_end, $amount)
    {
        if (empty($member['email'])) {
            return false;
        }

        try {
            $mail = $this->setup_mail();
            $name = !empty($member['name']) ? $member['name'] : 'Member';
            $site_name = !empty($this->config['site_name']) ? $this->config['site_name'] : 'NGO';
            $mail->addAddress($member['email'], $name);
            $mail->isHTML(true);
            $mail->Subject = 'Membership Renewed - ' . $site_name;
            $renew_url = site_url('admin/renew');
            $mail->Body = '<h3>Membership Renewal Successful</h3>'
                . '<p>Dear <b>' . htmlspecialchars($name) . '</b>,</p>'
                . '<p>Thank you for renewing your membership with <b>' . htmlspecialchars($site_name) . '</b>.</p>'
                . '<p><b>Renewal amount:</b> INR ' . number_format((float) $amount, 2) . '<br>'
                . '<b>Membership valid until:</b> ' . htmlspecialchars((string) $new_validity_end) . '</p>'
                . '<p>You can access your member panel here: <a href="' . htmlspecialchars($renew_url) . '">' . htmlspecialchars($renew_url) . '</a></p>'
                . '<p>Warm Regards,<br>Management Team<br>' . htmlspecialchars($site_name) . '</p>';
            return $mail->send();
        } catch (\Throwable $e) {
            log_message('error', 'Renewal confirmation email failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a foundation event announcement to a member.
     */
    public function send_event_announcement(array $member, array $event)
    {
        if (empty($member['email'])) {
            return false;
        }

        try {
            $mail = $this->setup_mail();
            $name = !empty($member['name']) ? $member['name'] : 'Member';
            $site_name = !empty($this->config['site_name']) ? $this->config['site_name'] : 'NGO';
            $title = !empty($event['title']) ? $event['title'] : 'Foundation Event';
            $event_date = !empty($event['event_date']) ? $event['event_date'] : 'Date to be announced';
            $mail->addAddress($member['email'], $name);
            $mail->isHTML(true);
            $mail->Subject = 'Foundation Event: ' . $title;
            $body = '<h3>' . htmlspecialchars($title) . '</h3>'
                . '<p>Dear <b>' . htmlspecialchars($name) . '</b>,</p>'
                . '<p>We are pleased to share an upcoming event from <b>' . htmlspecialchars($site_name) . '</b>.</p>'
                . '<p><b>Date:</b> ' . htmlspecialchars((string) $event_date) . '</p>';
            if (!empty($event['body'])) {
                $body .= '<div>' . nl2br(htmlspecialchars((string) $event['body'])) . '</div>';
            }
            $body .= '<p>We look forward to your participation.</p>'
                . '<p>Warm Regards,<br>Management Team<br>' . htmlspecialchars($site_name) . '</p>';
            $mail->Body = $body;
            return $mail->send();
        } catch (\Throwable $e) {
            log_message('error', 'Event announcement email failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send registration/application received email.
     */
    public function send_registration_welcome(array $member)
    {
        if (empty($member['email'])) {
            return false;
        }

        try {
            $mail = $this->setup_mail();

            $name = !empty($member['name'])
                ? $member['name']
                : 'Member';

            $site_name = !empty($this->config['site_name'])
                ? $this->config['site_name']
                : 'NGO';

            $mail->addAddress(
                $member['email'],
                $name
            );

            $mail->isHTML(true);

            $mail->Subject =
                'Membership Application Received - ' .
                $site_name;

            $body = "<h3>Thank You for Your Application!</h3>";

            $body .= "<p>Dear <b>" .
                htmlspecialchars($name) .
                "</b>,</p>";

            $body .= "<p>We have successfully received your membership application for <b>" .
                htmlspecialchars($site_name) .
                "</b>.</p>";

            if (!empty($member['member_id_code'])) {
                $body .= "<p><b>Application / Member ID:</b> " .
                    htmlspecialchars($member['member_id_code']) .
                    "</p>";
            }

            $body .= "<p>Your application is currently <b>under review</b> by our administration team.</p>";

            $body .= "<p>Once your application has been reviewed and approved, you will receive another email with your membership verification details.</p>";

            $body .= "<p>Thank you for your interest in joining us.</p>";

            $body .= "<p>Warm Regards,<br>" .
                "Management Team<br>" .
                htmlspecialchars($site_name) .
                "</p>";

            $mail->Body = $body;

            return $mail->send();

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Registration email failed: ' . $e->getMessage()
            );

            return false;
        }
    }

    /**
     * Send donation receipt (with PDF attached) to the donor.
     *
     * @param array       $donation   Donation row (name, email, amount, receipt_no, created_at, ...)
     * @param string|null $pdf_binary Raw PDF bytes (e.g. from Ngom_documents::donation_receipt_pdf()).
     *                                If null, the email is sent without an attachment.
     */
    public function send_donation_receipt(array $donation, $pdf_binary = null)
    {
        if (empty($donation['email'])) {
            return false;
        }

        try {
            $mail = $this->setup_mail();

            $name = !empty($donation['name'])
                ? $donation['name']
                : 'Donor';

            $site_name = !empty($this->config['site_name'])
                ? $this->config['site_name']
                : 'NGO';

            $mail->addAddress(
                $donation['email'],
                $name
            );

            $mail->isHTML(true);

            $mail->Subject =
                'Donation Receipt #' .
                ($donation['receipt_no'] ?? '') .
                ' - ' .
                $site_name;

            $amount = 'INR ' . number_format((float) ($donation['amount'] ?? 0), 2);
            $when = !empty($donation['created_at'])
                ? date('d M Y, H:i', strtotime($donation['created_at']))
                : date('d M Y, H:i');

            $body = "<h3>Thank You for Your Donation!</h3>";

            $body .= "<p>Dear <b>" .
                htmlspecialchars($name) .
                "</b>,</p>";

            $body .= "<p>We gratefully acknowledge receipt of your donation to <b>" .
                htmlspecialchars($site_name) .
                "</b>. Your support makes a real difference.</p>";

            $body .= "<p><b>Donation Details:</b><br>";
            $body .= "Receipt No: " . htmlspecialchars((string) ($donation['receipt_no'] ?? '')) . "<br>";
            $body .= "Date: " . htmlspecialchars($when) . "<br>";
            $body .= "Amount: " . htmlspecialchars($amount) . "<br>";

            if (!empty($donation['payment_id'])) {
                $body .= "Payment ID: " . htmlspecialchars($donation['payment_id']) . "<br>";
            }

            if (!empty($donation['mobile'])) {
                $body .= "Mobile: " . htmlspecialchars($donation['mobile']) . "<br>";
            }

            $body .= "</p>";

            if ($pdf_binary !== null) {
                $body .= "<p>Your official donation receipt is attached to this email as a PDF.</p>";

                $mail->addStringAttachment(
                    $pdf_binary,
                    'Donation_Receipt_' . ($donation['receipt_no'] ?? 'receipt') . '.pdf'
                );
            }

            $body .= "<p>Warm Regards,<br>" .
                "Management Team<br>" .
                htmlspecialchars($site_name) .
                "</p>";

            $mail->Body = $body;

            return $mail->send();

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Donation receipt email failed: ' . $e->getMessage()
            );

            return false;
        }
    }

    /**
     * Send registration notification through Meta WhatsApp Cloud API.
     */
    public function send_registration_whatsapp(array $member)
    {
        if (empty($member['mobile'])) {
            return false;
        }

        // Keep WhatsApp disabled until the provider credentials and template are configured.
        if (strtolower((string) getenv('WHATSAPP_ENABLED')) !== 'true') {
            return false;
        }

        $api_url = getenv('WHATSAPP_API_URL');
        $access_token = getenv('WHATSAPP_ACCESS_TOKEN');
        $template_name = getenv('WHATSAPP_TEMPLATE_NAME');
        $template_language = getenv('WHATSAPP_TEMPLATE_LANGUAGE');

        if (empty($template_language)) {
            $template_language = 'en_US';
        }

        if (
            empty($api_url) ||
            empty($access_token) ||
            empty($template_name)
        ) {
            log_message(
                'error',
                'WhatsApp registration notification failed: API configuration is missing.'
            );

            return false;
        }

        $phone = $this->normalize_whatsapp_number(
            $member['mobile']
        );

        if (empty($phone)) {
            log_message(
                'error',
                'WhatsApp registration notification failed: Invalid mobile number.'
            );

            return false;
        }

        $name = !empty($member['name'])
            ? $member['name']
            : 'Member';

        $payload = array(
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'template',
            'template' => array(
                'name' => $template_name,
                'language' => array(
                    'code' => $template_language
                ),
                'components' => array(
                    array(
                        'type' => 'body',
                        'parameters' => array(
                            array(
                                'type' => 'text',
                                'text' => $name
                            )
                        )
                    )
                )
            )
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ),
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
        ));

        $response = curl_exec($curl);
        $curl_error = curl_error($curl);
        $http_code = (int) curl_getinfo(
            $curl,
            CURLINFO_HTTP_CODE
        );

        curl_close($curl);

        if ($curl_error) {
            log_message(
                'error',
                'WhatsApp API CURL error: ' . $curl_error
            );

            return false;
        }

        if ($http_code < 200 || $http_code >= 300) {
            log_message(
                'error',
                'WhatsApp API error. HTTP ' .
                $http_code .
                ' Response: ' .
                (string) $response
            );

            return false;
        }

        log_message(
            'info',
            'WhatsApp registration notification sent successfully to ' .
            $phone
        );

        return true;
    }

    /**
     * Convert mobile number to WhatsApp international format.
     * Example: 9876543210 -> 919876543210
     */
    private function normalize_whatsapp_number($number)
    {
        $number = preg_replace(
            '/\D+/',
            '',
            (string) $number
        );

        // Indian 10-digit mobile number
        if (strlen($number) === 10) {
            $number = '91' . $number;
        }

        // Basic international number validation
        if (strlen($number) < 10 || strlen($number) > 15) {
            return false;
        }

        return $number;
    }
}
