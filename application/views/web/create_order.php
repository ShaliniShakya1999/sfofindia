<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'razorpay_config.php';

if (empty(RAZORPAY_KEY_ID) || empty(RAZORPAY_KEY_SECRET) || RAZORPAY_KEY_ID === 'rzp_test_xxxxxxxx') {
    echo json_encode(['success' => false, 'error' => 'Payment gateway not configured. Add Razorpay keys in razorpay_config.php']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: [];
$amount_rupees = isset($input['amount']) ? (float) $input['amount'] : 0;

if ($amount_rupees < 1) {
    echo json_encode(['success' => false, 'error' => 'Minimum donation amount is ₹1']);
    exit;
}

$amount_paise = (int) round($amount_rupees * 100);
if ($amount_paise < 100) {
    $amount_paise = 100;
}

$receipt = 'donation_' . time() . '_' . substr(uniqid(), -4);

$payload = json_encode([
    'amount'   => $amount_paise,
    'currency' => 'INR',
    'receipt'  => $receipt,
]);

$ch = curl_init('https://api.razorpay.com/v1/orders');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode(RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET),
]);
$response = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

if ($http === 200 && !empty($data['id'])) {
    echo json_encode([
        'success'   => true,
        'orderId'   => $data['id'],
        'amount'    => (int) $data['amount'],
        'currency'  => $data['currency'],
    ]);
} else {
    $msg = isset($data['error']['description']) ? $data['error']['description'] : 'Could not create order';
    echo json_encode(['success' => false, 'error' => $msg]);
}
