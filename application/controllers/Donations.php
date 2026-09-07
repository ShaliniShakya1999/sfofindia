<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
/**
 * Online donations (Razorpay) + admin list + PDF receipts.
 */
class Donations extends My_Controller {

	/** @var list<string> */
	private $public_methods = array('create_order', 'verify_payment', 'verify_receipt');

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
			include $p;
		}
		return defined('RAZORPAY_KEY_ID') && defined('RAZORPAY_KEY_SECRET');
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
		$payload = json_encode(array(
			'amount' => $amount_paise,
			'currency' => 'INR',
			'receipt' => $receipt,
		));
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
		curl_close($ch);
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
		);
		$this->db->insert('donations', $insert);
		$did = (int) $this->db->insert_id();
		$this->output->set_output(json_encode(array(
			'ok' => true,
			'donation_id' => $did,
			'receipt_no' => $receipt_no,
			'receipt_url' => site_url('donations/receipt_pdf/' . $did),
		)));
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

	public function index()
	{
		if (!$this->donations->table_exists()) {
			show_error('Donations table is missing. Run migration.');
		}

		$status_filter = $this->input->get('status');
		$date_from = $this->input->get('date_from');
		$date_to = $this->input->get('date_to');

		$this->db->start_cache();
		if (!empty($status_filter)) {
			$this->db->where('status', $status_filter);
		}
		if (!empty($date_from)) {
			$this->db->where('created_at >=', $date_from . ' 00:00:00');
		}
		if (!empty($date_to)) {
			$this->db->where('created_at <=', $date_to . ' 23:59:59');
		}
		$this->db->stop_cache();

		$data['total_count'] = $this->db->count_all_results('donations');
		
		$this->db->select_sum('amount');
		$this->db->where('status', 'paid');
		$q = $this->db->get('donations')->row_array();
		$data['total_amount'] = isset($q['amount']) ? (float) $q['amount'] : 0.0;

		$this->db->order_by('id', 'DESC');
		$this->db->limit(500);
		$data['rows'] = $this->db->get('donations')->result_array();
		$this->db->flush_cache();

		// Chart Data (Last 6 Months)
		$chart_labels = array();
		$chart_data = array();
		for ($i = 5; $i >= 0; $i--) {
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
			'payment_id' => 'MANUAL_' . time(),
			'receipt_no' => $this->donations->next_receipt_no(),
			'created_at' => date('Y-m-d H:i:s'),
		);
		
		$this->db->insert('donations', $data);
		ngom_log_activity('manual_donation', 'Added manual donation for ' . $name . ' (₹' . $amount . ')');
		$this->session->set_flashdata('cms_success', 'Manual donation added successfully.');
		redirect('donations');
	}

	public function receipt_pdf($id)
	{
		$row = $this->donations->find_by_id((int) $id);
		if (!$row || $row['status'] !== 'paid') {
			show_404();
		}
		$this->load->model('Site_model');
		$c = $this->Site_model->get_all_flat();
		$org = !empty($c['site_name']) ? $c['site_name'] : 'NGO';
		$this->load->library('Ngom_documents', array(), 'ngomdoc');
		$bin = $this->ngomdoc->donation_receipt_pdf($row, $org);
		$this->output
			->set_content_type('application/pdf')
			->set_header('Content-Disposition: inline; filename="receipt-' . (int) $id . '.pdf"')
			->set_output($bin);
	}
}
