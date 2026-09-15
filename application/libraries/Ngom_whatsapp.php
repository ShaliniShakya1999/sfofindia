<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ngom_whatsapp
 * 
 * Modular and extensible WhatsApp Notification Service for Shaheed Foundation India.
 * Ready for plug-and-play integration with:
 *   - Meta WhatsApp Cloud API (Graph API)
 *   - Twilio WhatsApp API
 *   - Custom REST Webhooks / SMS-WhatsApp Gateways (Fast2SMS, WATI, Aisensy, MSG91, UltraMsg, etc.)
 * 
 * Features:
 *   - Standby mode by default (logs formatted notifications without erroring when disabled)
 *   - Automatic Indian & International mobile number normalization (e.g. 9876543210 -> 919876543210)
 *   - Pre-formatted, professional template messages for donations, member onboarding, renewals, and birthdays
 *   - Safe error handling that never blocks core application transactions
 */
class Ngom_whatsapp {

    protected $CI;
    protected $config = array();

    public function __construct($config = array())
    {
        $this->CI =& get_instance();
        $this->load_config($config);
    }

    /**
     * Load WhatsApp settings from database (site_settings) or environment variables.
     */
    public function load_config($custom_config = array())
    {
        $db_settings = array();
        if (isset($this->CI->db) && $this->CI->db->table_exists('site_settings')) {
            $this->CI->load->model('Site_model');
            $db_settings = $this->CI->Site_model->get_all_flat();
        }

        $this->config = array(
            'enabled' => !empty($custom_config['enabled']) 
                ? (bool) $custom_config['enabled'] 
                : (!empty($db_settings['whatsapp_enabled']) ? ($db_settings['whatsapp_enabled'] === '1' || $db_settings['whatsapp_enabled'] === true) : (strtolower((string) getenv('WHATSAPP_ENABLED')) === 'true')),
            'provider' => !empty($custom_config['provider']) 
                ? $custom_config['provider'] 
                : (!empty($db_settings['whatsapp_provider']) ? $db_settings['whatsapp_provider'] : (getenv('WHATSAPP_PROVIDER') ?: 'meta_cloud')),
            'api_url' => !empty($custom_config['api_url']) 
                ? $custom_config['api_url'] 
                : (!empty($db_settings['whatsapp_api_url']) ? $db_settings['whatsapp_api_url'] : (getenv('WHATSAPP_API_URL') ?: '')),
            'api_key' => !empty($custom_config['api_key']) 
                ? $custom_config['api_key'] 
                : (!empty($db_settings['whatsapp_api_key']) ? $db_settings['whatsapp_api_key'] : (getenv('WHATSAPP_ACCESS_TOKEN') ?: getenv('WHATSAPP_API_KEY') ?: '')),
            'sender_id' => !empty($custom_config['sender_id']) 
                ? $custom_config['sender_id'] 
                : (!empty($db_settings['whatsapp_phone_number_id']) ? $db_settings['whatsapp_phone_number_id'] : (getenv('WHATSAPP_PHONE_NUMBER_ID') ?: '')),
            'site_name' => !empty($db_settings['site_name']) ? $db_settings['site_name'] : 'Shaheed Foundation India',
            'template_donation' => !empty($db_settings['whatsapp_template_donation']) ? $db_settings['whatsapp_template_donation'] : (getenv('WHATSAPP_TEMPLATE_DONATION') ?: 'donation_receipt'),
            'template_welcome' => !empty($db_settings['whatsapp_template_welcome']) ? $db_settings['whatsapp_template_welcome'] : (getenv('WHATSAPP_TEMPLATE_NAME') ?: 'member_welcome'),
        );
    }

    /**
     * Check if WhatsApp notifications are currently active and ready.
     *
     * @return bool
     */
    public function is_enabled()
    {
        return !empty($this->config['enabled']) && !empty($this->config['api_url']) && !empty($this->config['api_key']);
    }

    /**
     * 1. Send Donation Receipt & Thank You message via WhatsApp.
     *
     * @param array  $donation    Donation row (name, mobile, amount, receipt_no, payment_id, etc.)
     * @param string $receipt_url Public download URL for the donation receipt PDF
     * @return bool
     */
    public function send_donation_whatsapp(array $donation, $receipt_url = null)
    {
        if (empty($donation['mobile'])) {
            return false;
        }

        $donor_name = !empty($donation['name']) ? trim($donation['name']) : 'Generous Donor';
        $amount_fmt = '₹' . number_format((float) ($donation['amount'] ?? 0), 2);
        $receipt_no = (string) ($donation['receipt_no'] ?? 'N/A');
        $site_name  = $this->config['site_name'];

        if (!$receipt_url && !empty($donation['receipt_no'])) {
            $receipt_url = site_url('donations/public_receipt_pdf/' . rawurlencode($donation['receipt_no']));
        }

        $message = "🙏 *Thank you for your noble contribution to {$site_name}!*\n\n"
                 . "Dear *{$donor_name}*,\n"
                 . "We gratefully acknowledge receipt of your donation. Your support empowers our martyrs' families with dignity and care.\n\n"
                 . "🧾 *Receipt Details:*\n"
                 . "• *Receipt No:* {$receipt_no}\n"
                 . "• *Amount:* {$amount_fmt}\n"
                 . "• *Date:* " . date('d M Y, h:i A') . "\n";

        if (!empty($donation['payment_id'])) {
            $message .= "• *Payment ID:* " . $donation['payment_id'] . "\n";
        }

        if ($receipt_url) {
            $message .= "\n📥 *Download Official 80G Receipt PDF:*\n" . $receipt_url . "\n";
        }

        $message .= "\n_Warm regards,_\n*Management Team*\n{$site_name}";

        return $this->send_message($donation['mobile'], $message, array(
            'type' => 'donation_receipt',
            'template_name' => $this->config['template_donation'],
            'template_params' => array($donor_name, $amount_fmt, $receipt_no)
        ));
    }

    /**
     * 2. Send Member Approval & Login Credentials via WhatsApp.
     *
     * @param array  $member         Member row (name, mobile, member_user_id, member_id_code, etc.)
     * @param string $plain_password Plain-text initial/temporary password
     * @param string $login_url      Member portal login URL
     * @param string $id_card_url    Official ID card page or download URL
     * @return bool
     */
    public function send_member_verified_whatsapp(array $member, $plain_password, $login_url = null, $id_card_url = null)
    {
        if (empty($member['mobile'])) {
            return false;
        }

        $name = !empty($member['name']) ? trim($member['name']) : 'Member';
        $user_id = !empty($member['member_user_id']) ? $member['member_user_id'] : ($member['member_id_code'] ?? 'MBR');
        $site_name = $this->config['site_name'];
        if (!$login_url) {
            $login_url = site_url('admin/login');
        }
        if (!$id_card_url) {
            $id_card_url = site_url('admin/member_document/id-card');
        }

        $message = "🎉 *Welcome to {$site_name}! Membership Approved* 🎉\n\n"
                 . "Dear *{$name}*,\n"
                 . "Congratulations! Your membership application has been verified and approved by the administration team.\n\n"
                 . "🔐 *Your Member Login Credentials:*\n"
                 . "• *User ID / Mobile:* `{$user_id}`\n"
                 . "• *Password:* `{$plain_password}`\n"
                 . "• *Member Portal:* {$login_url}\n\n"
                 . "🪪 *Access Official Digital ID Card & Certificate:*\n"
                 . "{$id_card_url}\n\n"
                 . "_Please log in and update your password._\n\n"
                 . "Thank you for standing with us!\n"
                 . "*{$site_name}*";

        return $this->send_message($member['mobile'], $message, array(
            'type' => 'member_verification',
            'template_name' => $this->config['template_welcome'],
            'template_params' => array($name, $user_id, $plain_password)
        ));
    }

    /**
     * 3. Send Member Registration Received confirmation via WhatsApp.
     *
     * @param array $member Member application row
     * @return bool
     */
    public function send_registration_whatsapp(array $member)
    {
        if (empty($member['mobile'])) {
            return false;
        }

        $name = !empty($member['name']) ? trim($member['name']) : 'Applicant';
        $site_name = $this->config['site_name'];
        $app_code = !empty($member['member_id_code']) ? $member['member_id_code'] : 'Under Review';

        $message = "📝 *Membership Application Received - {$site_name}*\n\n"
                 . "Dear *{$name}*,\n"
                 . "We have received your membership registration.\n"
                 . "• *Application Ref:* {$app_code}\n"
                 . "• *Status:* Under Review\n\n"
                 . "Our team will verify your details. You will receive your official login credentials and digital ID card as soon as your profile is activated.\n\n"
                 . "*Team {$site_name}*";

        return $this->send_message($member['mobile'], $message, array(
            'type' => 'registration_received',
            'template_name' => $this->config['template_welcome'],
            'template_params' => array($name)
        ));
    }

    /**
     * 4. Send Membership Renewal Reminder via WhatsApp.
     *
     * @param array  $member    Member row
     * @param string $renew_url Renewal URL
     * @return bool
     */
    public function send_renewal_reminder_whatsapp(array $member, $renew_url = null)
    {
        if (empty($member['mobile'])) {
            return false;
        }

        $name = !empty($member['name']) ? trim($member['name']) : 'Member';
        $site_name = $this->config['site_name'];
        $validity_end = !empty($member['validity_end']) ? date('d M, Y', strtotime($member['validity_end'])) : 'Soon';
        if (!$renew_url) {
            $renew_url = site_url('admin/renew');
        }

        $message = "⚠️ *Membership Renewal Notice - {$site_name}*\n\n"
                 . "Dear *{$name}*,\n"
                 . "This is a friendly reminder that your membership validity ends on *{$validity_end}*.\n\n"
                 . "To maintain your active member standing and continue supporting our welfare initiatives, please renew your membership:\n"
                 . "👉 *Renew Now:* {$renew_url}\n\n"
                 . "_Thank you for your valued support._\n"
                 . "*{$site_name}*";

        return $this->send_message($member['mobile'], $message, array(
            'type' => 'renewal_reminder',
            'template_name' => 'membership_renewal',
            'template_params' => array($name, $validity_end)
        ));
    }

    /**
     * 5. Send Birthday Greeting via WhatsApp.
     *
     * @param array $member Member row
     * @return bool
     */
    public function send_birthday_wish_whatsapp(array $member)
    {
        if (empty($member['mobile'])) {
            return false;
        }

        $name = !empty($member['name']) ? trim($member['name']) : 'Member';
        $site_name = $this->config['site_name'];

        $message = "🎂 *Happy Birthday, {$name}!* 🎉\n\n"
                 . "On behalf of the entire team and trustees at *{$site_name}*, we wish you a joyous and blessed birthday!\n\n"
                 . "Thank you for being an inspiring part of our mission and standing strong with our martyrs' families.\n\n"
                 . "Warmest wishes,\n"
                 . "*{$site_name} Team*";

        return $this->send_message($member['mobile'], $message, array(
            'type' => 'birthday_wish',
            'template_name' => 'birthday_greeting',
            'template_params' => array($name)
        ));
    }

    /**
     * Primary dispatcher: Sends the WhatsApp message using the configured provider or safely logs in standby mode.
     *
     * @param string $to              Recipient phone number
     * @param string $text_message    Human-readable plain/markdown text message
     * @param array  $options         Additional provider options (template name, components, etc.)
     * @return bool
     */
    public function send_message($to, $text_message, $options = array())
    {
        $normalized_phone = $this->normalize_phone_number($to);
        if (!$normalized_phone) {
            log_message('error', "WhatsApp skipped: invalid phone number '{$to}'");
            return false;
        }

        // --- STANDBY / READY MODE ---
        // If credentials are not yet entered or enabled is 0, safely log the outgoing notification.
        if (!$this->is_enabled()) {
            log_message('info', "[WhatsApp Standby - API Ready] Would send to: {$normalized_phone}\nMessage Content:\n" . $text_message);
            return false;
        }

        $provider = strtolower(trim($this->config['provider'] ?? 'meta_cloud'));

        try {
            switch ($provider) {
                case 'meta_cloud':
                    return $this->dispatch_meta_cloud($normalized_phone, $text_message, $options);

                case 'twilio':
                    return $this->dispatch_twilio($normalized_phone, $text_message, $options);

                case 'generic_webhook':
                case 'custom_gateway':
                default:
                    return $this->dispatch_custom_webhook($normalized_phone, $text_message, $options);
            }
        } catch (\Throwable $e) {
            log_message('error', "WhatsApp dispatch error ({$provider}): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Meta WhatsApp Cloud API (Graph API) Dispatcher
     */
    protected function dispatch_meta_cloud($phone, $text_message, $options = array())
    {
        $api_url = $this->config['api_url'];
        // If user entered just phone_number_id, construct standard Graph API endpoint
        if (!empty($this->config['sender_id']) && strpos($api_url, 'graph.facebook.com') === false) {
            $api_url = "https://graph.facebook.com/v18.0/" . trim($this->config['sender_id']) . "/messages";
        }

        $template_name = !empty($options['template_name']) ? $options['template_name'] : '';

        // If template parameters are supplied, send template message; otherwise send text message
        if ($template_name !== '') {
            $params_payload = array();
            if (!empty($options['template_params']) && is_array($options['template_params'])) {
                foreach ($options['template_params'] as $param) {
                    $params_payload[] = array('type' => 'text', 'text' => (string) $param);
                }
            }

            $payload = array(
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'template',
                'template' => array(
                    'name' => $template_name,
                    'language' => array('code' => 'en_US'),
                    'components' => array(
                        array('type' => 'body', 'parameters' => $params_payload)
                    )
                )
            );
        } else {
            $payload = array(
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $phone,
                'type' => 'text',
                'text' => array('preview_url' => true, 'body' => $text_message)
            );
        }

        return $this->execute_http_post($api_url, json_encode($payload), array(
            'Authorization: Bearer ' . $this->config['api_key'],
            'Content-Type: application/json'
        ));
    }

    /**
     * Twilio WhatsApp Dispatcher
     */
    protected function dispatch_twilio($phone, $text_message, $options = array())
    {
        $api_url = $this->config['api_url'];
        $from_number = $this->config['sender_id'] ?: 'whatsapp:+14155238886'; // Twilio sandbox default

        $post_data = array(
            'From' => (strpos($from_number, 'whatsapp:') === 0) ? $from_number : 'whatsapp:' . $from_number,
            'To' => 'whatsapp:+' . $phone,
            'Body' => $text_message
        );

        return $this->execute_http_post($api_url, http_build_query($post_data), array(
            'Authorization: Basic ' . base64_encode($this->config['api_key']),
            'Content-Type: application/x-www-form-urlencoded'
        ));
    }

    /**
     * Generic Webhook / Custom Gateway Dispatcher (Fast2SMS, WATI, Aisensy, UltraMsg, Gupshup, etc.)
     */
    protected function dispatch_custom_webhook($phone, $text_message, $options = array())
    {
        $api_url = $this->config['api_url'];

        $payload = array(
            'phone' => $phone,
            'mobile' => $phone,
            'to' => $phone,
            'message' => $text_message,
            'event' => $options['type'] ?? 'notification',
            'api_key' => $this->config['api_key'],
            'timestamp' => time()
        );

        return $this->execute_http_post($api_url, json_encode($payload), array(
            'Authorization: Bearer ' . $this->config['api_key'],
            'Content-Type: application/json'
        ));
    }

    /**
     * Standard cURL HTTP POST executor.
     */
    protected function execute_http_post($url, $body, $headers = array())
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => true
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($err) {
            log_message('error', "WhatsApp cURL request failed: {$err}");
            return false;
        }

        if ($code < 200 || $code >= 300) {
            log_message('error', "WhatsApp API HTTP {$code} response: " . substr((string) $response, 0, 255));
            return false;
        }

        log_message('info', "WhatsApp message dispatched successfully to {$url} (HTTP {$code})");
        return true;
    }

    /**
     * Clean and normalize phone numbers into international WhatsApp standard (e.g. 91XXXXXXXXXX).
     *
     * @param string $number Raw phone input
     * @return string|false Normalized number or false if invalid
     */
    public function normalize_phone_number($number)
    {
        $clean = preg_replace('/\D+/', '', (string) $number);

        // Remove leading zeros
        $clean = ltrim($clean, '0');

        // Standard 10-digit Indian mobile numbers (prepend 91)
        if (strlen($clean) === 10) {
            return '91' . $clean;
        }

        // Already has 91 country code (12 digits)
        if (strlen($clean) === 12 && substr($clean, 0, 2) === '91') {
            return $clean;
        }

        // Basic E.164 length check (between 10 and 15 digits)
        if (strlen($clean) >= 10 && strlen($clean) <= 15) {
            return $clean;
        }

        return false;
    }
}
