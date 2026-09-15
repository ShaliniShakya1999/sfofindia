<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
/**
 * Online donations (Razorpay) + admin list + PDF receipts.
 */
class Donations extends My_Controller {

	/** @var list<string> */
	private $public_methods = array('create_order', 'verify_payment', 'verify_receipt', 'public_receipt_pdf', 'webhook');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Donation_model', 'donations');
		$this->load->library('session');
		
		$m = $this->router->method;
		if (!in_array($m, $this->public_methods, true)) {
			$this->require_login();
			$this->require_role(array('super_admin', 'admin'));
		}
	}


	private function load_razorpay_config()
	{
		$p = APPPATH . 'views/web/razorpay_config.php';
		if (is_file($p)) {
			include_once $p;
		}
		if (!defined('RAZORPAY_KEY_ID') || RAZORPAY_KEY_ID === '' || RAZORPAY_KEY_ID === 'rzp_test_xxxxxxxx') {
			$this->load->model('Site_model');
			$cms = $this->Site_model->get_all_flat();
			if (!empty($cms['razorpay_key_id']) && !defined('RAZORPAY_KEY_ID')) {
				define('RAZORPAY_KEY_ID', trim($cms['razorpay_key_id']));
			}
			if (!empty($cms['razorpay_key_secret']) && !defined('RAZORPAY_KEY_SECRET')) {
				define('RAZORPAY_KEY_SECRET', trim($cms['razorpay_key_secret']));
			}
		}
		return defined('RAZORPAY_KEY_ID') && RAZORPAY_KEY_ID !== '' && RAZORPAY_KEY_ID !== 'rzp_test_xxxxxxxx' && defined('RAZORPAY_KEY_SECRET') && RAZORPAY_KEY_SECRET !== '';
	}

	/** JSON — create Razorpay order (same contract as legacy create_order.php) */
	public function create_order()
	{
		$this->load->library('session');
		header('Content-Type: application/json; charset=utf-8');
		if (!$this->load_razorpay_config() || RAZORPAY_KEY_ID === 'rzp_test_xxxxxxxx' || RAZORPAY_KEY_SECRET === 'your_secret_key') {
			$this->output->set_output(json_encode(array('success' => false, 'error' => 'Payment gateway not configured.')));
			return;
		}
		$raw = file_get_contents('php://input');
		$input = json_decode($raw, true);
		if (!is_array($input)) {
			$input = array();
		}
		$amount_rupees = isset($input['amount']) ? (float) $input['amount'] : 0;
		if ($amount_rupees < 1) {
			$this->output->set_output(json_encode(array('success' => false, 'error' => 'Minimum donation amount is ₹1')));
			return;
		}
		$amount_paise = (int) round($amount_rupees * 100);
		if ($amount_paise < 100) {
			$amount_paise = 100;
		}
		$receipt = 'donation_' . time() . '_' . substr(uniqid('', true), -4);
		$notes = array();
		if (!empty($input['name'])) {
			$notes['name'] = substr(trim((string) $input['name']), 0, 100);
		}
		if (!empty($input['email'])) {
			$notes['email'] = substr(trim((string) $input['email']), 0, 100);
		}
		if (!empty($input['mobile'])) {
			$notes['mobile'] = substr(trim((string) $input['mobile']), 0, 30);
		}
		if (!empty($input['pan'])) {
			$notes['pan'] = substr(trim((string) $input['pan']), 0, 20);
		}
		if (!empty($input['address'])) {
			$notes['address'] = substr(trim((string) $input['address']), 0, 255);
		}

		$order_payload = array(
			'amount' => $amount_paise,
			'currency' => 'INR',
			'receipt' => $receipt,
		);
		if (!empty($notes)) {
			$order_payload['notes'] = $notes;
		}
		$payload = json_encode($order_payload);
		$ch = curl_init('https://api.razorpay.com/v1/orders');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Basic ' . base64_encode(RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET),
		));
		$response = curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_error = curl_error($ch);
		curl_close($ch);
		if ($response === false || $curl_error !== '') {
			$this->output->set_output(json_encode(array('success' => false, 'error' => 'Payment gateway is temporarily unavailable.')));
			return;
		}
		$data = json_decode($response, true);
		if ($http === 200 && !empty($data['id'])) {
			$this->output->set_output(json_encode(array(
				'success' => true,
				'orderId' => $data['id'],
				'amount' => (int) $data['amount'],
				'currency' => $data['currency'],
			)));
		} else {
			$msg = isset($data['error']['description']) ? $data['error']['description'] : 'Could not create order';
			$this->output->set_output(json_encode(array('success' => false, 'error' => $msg)));
		}
	}

	/** POST JSON — verify signature and save donation */
	public function verify_payment()
	{
		header('Content-Type: application/json; charset=utf-8');
		if (!$this->load_razorpay_config()) {
			$this->output->set_output(json_encode(array('ok' => false, 'error' => 'Gateway not configured')));
			return;
		}

		$raw = file_get_contents('php://input');
		$input = json_decode($raw, true);
		if (!is_array($input)) {
			$this->output->set_output(json_encode(array('ok' => false, 'error' => 'Invalid JSON')));
			return;
		}
		$order_id = isset($input['razorpay_order_id']) ? (string) $input['razorpay_order_id'] : '';
		$payment_id = isset($input['razorpay_payment_id']) ? (string) $input['razorpay_payment_id'] : '';
		$signature = isset($input['razorpay_signature']) ? (string) $input['razorpay_signature'] : '';
		$name = isset($input['name']) ? trim((string) $input['name']) : '';
		$email = isset($input['email']) ? trim((string) $input['email']) : '';
		$mobile = isset($input['mobile']) ? trim((string) $input['mobile']) : '';
		$amount = isset($input['amount']) ? (float) $input['amount'] : 0;
		if ($order_id === '' || $payment_id === '' || $signature === '' || $name === '' || $amount < 1) {
			$this->output->set_output(json_encode(array('ok' => false, 'error' => 'Missing fields')));
			return;
		}
		$expected = hash_hmac('sha256', $order_id . '|' . $payment_id, RAZORPAY_KEY_SECRET);
		if (!hash_equals($expected, $signature)) {
			$this->output->set_output(json_encode(array('ok' => false, 'error' => 'Invalid signature')));
			return;
		}
		$order = $this->fetch_razorpay_order($order_id);
		$expected_paise = (int) ($order['amount'] ?? 0);
		if (!$order || (int) ($order['amount'] ?? 0) !== $expected_paise || ($order['currency'] ?? '') !== 'INR') {
			$this->output->set_output(json_encode(array('ok' => false, 'error' => 'Payment amount could not be verified')));
			return;
		}
		$amount = $expected_paise / 100;
		if ($this->donations->find_by_payment_id($payment_id)) {
			$row = $this->donations->find_by_payment_id($payment_id);
			$this->output->set_output(json_encode(array('ok' => true, 'already' => true, 'donation_id' => (int) $row['id'], 'receipt_no' => $row['receipt_no'])));
			return;
		}

		if (!$this->donations->table_exists()) {
			$this->output->set_output(json_encode(array('ok' => false, 'error' => 'Donations table missing. Run SQL: application/db/ngom_modules.sql')));
			return;
		}
		$receipt_no = $this->donations->next_receipt_no();
		$campaign_id = !empty($input['campaign_id']) ? (int) $input['campaign_id'] : null;
		$insert = array(
			'name' => $name,
			'email' => $email,
			'mobile' => $mobile,
			'amount' => $amount,
			'currency' => 'INR',
			'razorpay_order_id' => $order_id,
			'payment_id' => $payment_id,
			'signature_verified' => 1,
			'status' => 'paid',
			'receipt_no' => $receipt_no,
			'campaign_id' => $campaign_id,
		);
		if (!$this->db->insert('donations', $insert)) {
			log_message('error', 'Donation insert failed for payment ' . $payment_id . ': ' . $this->db->error()['message']);
			$this->output->set_output(json_encode(array('ok' => false, 'error' => 'Payment was verified but could not be recorded. Contact support with your payment ID.')));
			return;
		}
		$did = (int) $this->db->insert_id();

		ngom_notify(
			'Donation Received',
			'₹' . number_format($amount, 2) . ' from ' . ($name !== '' ? $name : 'Anonymous') . ' (Receipt #' . $receipt_no . ').',
			'success',
			'donations'
		);

		$row = $this->donations->find_by_id($did);
		if ($row) {
			$this->send_receipt_email($row);
		}

		$this->output->set_output(json_encode(array(
			'ok' => true,
			'donation_id' => $did,
			'receipt_no' => $receipt_no,
			'receipt_url' => site_url('donations/public_receipt_pdf/' . rawurlencode($receipt_no)),
		)));
	}

	public function webhook()
	{
		$secret = trim((string) getenv('SFOF_RAZORPAY_WEBHOOK_SECRET'));
		$signature = (string) $this->input->get_request_header('X-Razorpay-Signature', true);
		$payload = (string) file_get_contents('php://input');
		if ($secret === '' || $signature === '' || !hash_equals(hash_hmac('sha256', $payload, $secret), $signature)) {
			$this->output->set_status_header(403)->set_content_type('application/json')
				->set_output(json_encode(array('ok' => false, 'error' => 'Invalid webhook signature.')));
			return;
		}

		$data = json_decode($payload, true);
		if (!is_array($data)) {
			$this->output->set_status_header(400)->set_content_type('application/json')
				->set_output(json_encode(array('ok' => false, 'error' => 'Invalid webhook payload.')));
			return;
		}
		$event_id = trim((string) ($data['id'] ?? ''));
		if ($event_id === '') {
			$event_id = 'sha256:' . hash('sha256', $payload);
		}
		if ($this->db->table_exists('razorpay_webhook_events')) {
			$event_inserted = $this->db->insert('razorpay_webhook_events', array(
				'event_id' => $event_id,
				'payment_id' => null,
				'status' => 'received',
			));
			if (!$event_inserted) {
				$error = $this->db->error();
				if ((int) ($error['code'] ?? 0) === 1062) {
					$this->output->set_content_type('application/json')->set_output(json_encode(array('ok' => true, 'already' => true)));
					return;
				}
				log_message('error', 'Razorpay webhook event insert failed: ' . ($error['message'] ?? 'unknown error'));
				$this->output->set_status_header(500)->set_content_type('application/json')
					->set_output(json_encode(array('ok' => false, 'error' => 'Webhook could not be recorded.')));
				return;
			}
		}
		$payment = isset($data['payload']['payment']['entity']) && is_array($data['payload']['payment']['entity'])
			? $data['payload']['payment']['entity'] : array();
		if (!in_array((string) ($data['event'] ?? ''), array('payment.captured', 'order.paid'), true) || empty($payment['id'])) {
			if ($this->db->table_exists('razorpay_webhook_events')) {
				$this->db->where('event_id', $event_id)->update('razorpay_webhook_events', array('status' => 'ignored'));
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('ok' => true)));
			return;
		}
		$payment_id = (string) $payment['id'];
		if ($this->db->table_exists('razorpay_webhook_events')) {
			$this->db->where('event_id', $event_id)->update('razorpay_webhook_events', array('payment_id' => $payment_id));
		}
		if ($this->donations->find_by_payment_id($payment_id)) {
			if ($this->db->table_exists('razorpay_webhook_events')) {
				$this->db->where('event_id', $event_id)->update('razorpay_webhook_events', array('status' => 'processed'));
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('ok' => true, 'already' => true)));
			return;
		}
		$amount = ((int) ($payment['amount'] ?? 0)) / 100;
		if ($amount < 1 || (string) ($payment['currency'] ?? '') !== 'INR') {
			if ($this->db->table_exists('razorpay_webhook_events')) {
				$this->db->where('event_id', $event_id)->update('razorpay_webhook_events', array('status' => 'rejected'));
			}
			$this->output->set_status_header(422)->set_content_type('application/json')
				->set_output(json_encode(array('ok' => false, 'error' => 'Unsupported payment.')));
			return;
		}
		$donor_name = trim((string) ($payment['notes']['name'] ?? ''));
		if ($donor_name === '') {
			$donor_name = 'Online donor';
		}
		$donor_email = trim((string) (!empty($payment['email']) ? $payment['email'] : ($payment['notes']['email'] ?? '')));
		$donor_mobile = trim((string) (!empty($payment['contact']) ? $payment['contact'] : ($payment['notes']['mobile'] ?? '')));

		$inserted = $this->db->insert('donations', array(
			'name' => $donor_name,
			'email' => $donor_email,
			'mobile' => $donor_mobile,
			'amount' => $amount,
			'currency' => 'INR',
			'razorpay_order_id' => (string) ($payment['order_id'] ?? ''),
			'payment_id' => $payment_id,
			'signature_verified' => 1,
			'status' => 'paid',
			'receipt_no' => $this->donations->next_receipt_no(),
		));
		if (!$inserted) {
			if ($this->db->table_exists('razorpay_webhook_events')) {
				$this->db->where('event_id', $event_id)->update('razorpay_webhook_events', array('status' => 'failed'));
			}
			$this->output->set_status_header(500)->set_content_type('application/json')
				->set_output(json_encode(array('ok' => false, 'error' => 'Could not record payment.')));
			return;
		}
		$row = $this->donations->find_by_payment_id($payment_id);
		if ($row) {
			ngom_notify('Donation Received', '₹' . number_format($amount, 2) . ' from ' . $row['name'] . ' (Receipt #' . $row['receipt_no'] . ').', 'success', 'donations');
			$this->send_receipt_email($row);
		}
		if ($this->db->table_exists('razorpay_webhook_events')) {
			$this->db->where('event_id', $event_id)->update('razorpay_webhook_events', array('status' => 'processed'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode(array('ok' => true)));
	}

	private function fetch_razorpay_order($order_id)
	{
		$ch = curl_init('https://api.razorpay.com/v1/orders/' . rawurlencode($order_id));
		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 15,
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic ' . base64_encode(RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET),
			),
		));
		$response = curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$order = json_decode((string) $response, true);
		return $http === 200 && is_array($order) ? $order : null;
	}

	/** Public: simple receipt validation page */
	public function verify_receipt($receipt_no = '')
	{
		$receipt_no = rawurldecode($receipt_no);
		if ($receipt_no === '' || !$this->donations->table_exists()) {
			show_404();
		}
		$this->db->where('receipt_no', $receipt_no);
		$this->db->where('status', 'paid');
		$q = $this->db->get('donations', 1);
		$row = $q->row_array();
		$data['donation'] = $row ?: null;
		$this->load->view('web/donation_receipt_verify', $data);
	}

	/**
	 * Public receipt download using the high-entropy receipt number as the
	 * capability token. Numeric donation IDs remain admin-only.
	 */
	public function public_receipt_pdf($receipt_no = '')
	{
		$receipt_no = rawurldecode((string) $receipt_no);
		if ($receipt_no === '' || !$this->donations->table_exists()) {
			show_404();
		}

		$row = $this->donations->find_paid_by_receipt_no($receipt_no);
		if (!$row) {
			show_404();
		}

		$this->render_receipt_pdf($row, 'receipt-' . preg_replace('/[^A-Za-z0-9_-]/', '', $receipt_no) . '.pdf');
	}

	public function index()
	{
		if (!$this->donations->table_exists()) {
			show_error('Donations table is missing. Run migration.');
		}

		$status_filter = $this->input->get('status');
		$date_from = $this->input->get('date_from');
		$date_to = $this->input->get('date_to');
		$view = (string) $this->input->get('view');
		if (!in_array($view, array('all', 'successful'), true)) {
			$view = 'recent';
		}
		$month_year = (string) $this->input->get('month');
		if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $month_year)) {
			$month_year = '';
		}
		$data['donation_view'] = $view;
		$data['show_donation_details'] = in_array($view, array('all', 'successful'), true);
		$data['month_year'] = $month_year;

		$this->db->where('status', 'paid');
		$data['total_count'] = $this->db->count_all_results('donations');
		$this->db->select_sum('amount');
		$this->db->where('status', 'paid');
		$q = $this->db->get('donations')->row_array();
		$data['total_amount'] = isset($q['amount']) ? (float) $q['amount'] : 0.0;

		if ($view === 'successful') {
			$status_filter = 'paid';
		}
		if ($view === 'all') {
			$status_filter = '';
		}
		if (!empty($status_filter)) {
			$this->db->where('status', $status_filter);
		}
		if (!empty($date_from)) {
			$this->db->where('created_at >=', $date_from . ' 00:00:00');
		}
		if (!empty($date_to)) {
			$this->db->where('created_at <=', $date_to . ' 23:59:59');
		}
		if ($month_year !== '') {
			$this->db->where("DATE_FORMAT(created_at, '%Y-%m') =", $month_year);
		}
		$this->db->order_by('id', 'DESC');
		$this->db->limit(500);
		$data['rows'] = $this->db->get('donations')->result_array();

		$chart_months = (int) $this->input->get('chart_months');
		if (!in_array($chart_months, array(3, 6, 12), true)) {
			$chart_months = 6;
		}
		$data['chart_months'] = $chart_months;

		// Chart Data for the selected number of months.
		$chart_labels = array();
		$chart_data = array();
		for ($i = $chart_months - 1; $i >= 0; $i--) {
			$month = date('Y-m', strtotime("-$i months"));
			$chart_labels[] = date('M Y', strtotime("-$i months"));
			
			$this->db->select_sum('amount');
			$this->db->where("DATE_FORMAT(created_at, '%Y-%m') =", $month);
			$this->db->where('status', 'paid');
			$res = $this->db->get('donations')->row_array();
			$chart_data[] = empty($res['amount']) ? 0 : (float) $res['amount'];
		}

		$data['chart_labels'] = json_encode($chart_labels);
		$data['chart_data'] = json_encode($chart_data);
		$data['monthly_summary'] = array();
		for ($i = $chart_months - 1; $i >= 0; $i--) {
			$month = date('Y-m', strtotime("-$i months"));
			$this->db->select('COUNT(*) AS donation_count, COALESCE(SUM(amount), 0) AS donation_total');
			$this->db->where("DATE_FORMAT(created_at, '%Y-%m') =", $month);
			$this->db->where('status', 'paid');
			$summary = $this->db->get('donations')->row_array();
			$data['monthly_summary'][] = array(
				'label' => date('M Y', strtotime($month . '-01')),
				'count' => (int) ($summary['donation_count'] ?? 0),
				'total' => (float) ($summary['donation_total'] ?? 0),
			);
		}
		$data['table_ok'] = true;

		$this->adminloadview('admin/ngom/donations_list', $data);
	}

	public function export_csv()
	{
		$this->require_role(array('super_admin', 'admin'));
		$this->load->dbutil();
		$this->load->helper('download');
		
		$query = $this->db->order_by('id', 'DESC')->get('donations');
		$csv = $this->dbutil->csv_from_result($query);
		
		$filename = 'donations_export_' . date('Y-m-d') . '.csv';
		force_download($filename, $csv);
	}

	public function add_manual()
	{
		$this->require_role(array('super_admin', 'admin'));
		
		$name = trim((string) $this->input->post('name'));
		$amount = (float) $this->input->post('amount');
		
		if ($name === '' || $amount <= 0) {
			$this->session->set_flashdata('cms_error', 'Name and valid amount are required.');
			redirect('donations');
		}
		
		$data = array(
			'name' => $name,
			'email' => trim((string) $this->input->post('email')),
			'mobile' => trim((string) $this->input->post('mobile')),
			'amount' => $amount,
			'currency' => 'INR',
			'status' => 'paid',
			'payment_id' => 'MANUAL_' . strtoupper(bin2hex(random_bytes(8))),
			'receipt_no' => $this->donations->next_receipt_no(),
			'created_at' => date('Y-m-d H:i:s'),
		);
		
		if (!$this->db->insert('donations', $data)) {
			$this->session->set_flashdata('cms_error', 'Could not save the manual donation.');
			redirect('donations');
			return;
		}
		$did = (int) $this->db->insert_id();
		ngom_log_activity('manual_donation', 'Added manual donation for ' . $name . ' (₹' . $amount . ')');

		ngom_notify(
			'Donation Received',
			'₹' . number_format($amount, 2) . ' from ' . $name . ' (Receipt #' . $data['receipt_no'] . ').',
			'success',
			'donations'
		);

		$row = $this->donations->find_by_id($did);
		if ($row) {
			$this->send_receipt_email($row);
		}

		$this->session->set_flashdata('cms_success', 'Manual donation added successfully.');
		redirect('donations');
	}

	/**
	 * Generate the receipt PDF and email it to the donor. Failure is logged, never fatal —
	 * the donation itself has already been recorded and should not be blocked by mail issues.
	 */
	private function send_receipt_email(array $row)
	{
		if (!empty($row['email'])) {
			try {
				$this->load->model('Site_model');
				$c = $this->Site_model->get_all_flat();
				$org = !empty($c['site_name']) ? $c['site_name'] : 'NGO';
				$this->load->library('Ngom_documents', array(), 'ngomdoc');
				$pdf = $this->ngomdoc->donation_receipt_pdf($row, $org);
				$this->load->library('Ngom_mailer', array(), 'ngommailer');
				$this->ngommailer->send_donation_receipt($row, $pdf);
			} catch (\Throwable $e) {
				log_message('error', 'Donation receipt email failed for donation #' . ($row['id'] ?? '?') . ': ' . $e->getMessage());
			}
		}

		// WhatsApp notification dispatch
		if (!empty($row['mobile'])) {
			try {
				$this->load->library('Ngom_whatsapp', array(), 'ngomwhatsapp');
				$receipt_url = !empty($row['receipt_no']) ? site_url('donations/public_receipt_pdf/' . rawurlencode($row['receipt_no'])) : null;
				$this->ngomwhatsapp->send_donation_whatsapp($row, $receipt_url);
			} catch (\Throwable $we) {
				log_message('error', 'Donation WhatsApp notice error for donation #' . ($row['id'] ?? '?') . ': ' . $we->getMessage());
			}
		}
	}

	public function receipt_pdf($id)
	{
		$row = $this->donations->find_by_id((int) $id);
		if (!$row || $row['status'] !== 'paid') {
			show_404();
		}
		$this->render_receipt_pdf($row, 'receipt-' . (int) $id . '.pdf');
	}

	private function render_receipt_pdf(array $row, $filename)
	{
		$this->load->model('Site_model');
		$c = $this->Site_model->get_all_flat();
		$org = !empty($c['site_name']) ? $c['site_name'] : 'NGO';
		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$bin = $this->ngomdoc->donation_receipt_pdf($row, $org);
		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: inline; filename="' . $filename . '"')
			->set_output($bin);
	}
}
