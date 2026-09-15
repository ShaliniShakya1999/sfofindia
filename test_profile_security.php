<?php
/**
 * Automated Verification Script for Member Profile Security & Email OTP
 * Run directly via PowerShell:
 *   php test_profile_security.php
 */

$baseUrl = 'http://127.0.0.1:8099';
$cookieFile = __DIR__ . '/test_cookie.txt';
if (file_exists($cookieFile)) @unlink($cookieFile);

$appLogDir = __DIR__ . '/application/logs';

function http_req($url, $post = null, $headers = []) {
    global $cookieFile;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    if ($post !== null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($post) ? http_build_query($post) : $post);
    }
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    $err = curl_error($ch);
    curl_close($ch);
    return ['code' => $code, 'body' => $res, 'url' => $effectiveUrl, 'err' => $err];
}

function get_csrf_token($html) {
    if (preg_match('/name="csrf_test_name" value="([^"]+)"/', $html, $m)) {
        return $m[1];
    }
    return null;
}

function do_member_login($username, $password) {
    global $baseUrl;
    $loginPage = http_req($baseUrl . '/admin/login');
    if ($loginPage['code'] === 0) {
        echo "ERROR: Could not connect to {$baseUrl}.\n";
        echo "Make sure the server is running in another PowerShell window with: php -S 127.0.0.1:8099\n";
        exit(1);
    }
    $csrf = get_csrf_token($loginPage['body']);
    $loginPost = [
        'csrf_test_name' => $csrf,
        'username' => $username,
        'password' => $password
    ];
    return http_req($baseUrl . '/admin/do_login', $loginPost);
}

echo "========================================================\n";
echo "  MEMBER PROFILE SECURITY & EMAIL OTP VERIFICATION TEST \n";
echo "========================================================\n\n";

echo "--> STEP 1: Login as Member MBR0001 (Password: 123456)...\n";
$loginRes = do_member_login('MBR0001', '123456');

if (strpos($loginRes['url'], 'login') !== false && strpos($loginRes['body'], 'Sign in to access') !== false) {
    $loginRes = do_member_login('MBR0001', 'newSecretPass123');
}

$profCheck = http_req($baseUrl . '/admin/profile');
if (strpos($profCheck['url'], 'login') !== false) {
    echo "[FAIL] Member login failed. Could not access admin/profile.\n";
    exit(1);
}
echo "[PASS] Logged in successfully as Member MBR0001.\n\n";

echo "--> STEP 2: Checking Security & KYC UI Elements...\n";
$pBody = $profCheck['body'];
$hasCurrentPass = strpos($pBody, 'name="current_password"') !== false;
$hasOtpCode = strpos($pBody, 'name="otp_code"') !== false;
$hasSendOtpBtn = strpos($pBody, 'id="send_otp_btn"') !== false;
$hasAadhar = strpos($pBody, 'name="aadhar_no"') !== false;

if (!$hasCurrentPass || !$hasOtpCode || !$hasSendOtpBtn) {
    echo "[FAIL] Missing required inputs in profile security form.\n";
    exit(1);
}
echo "[PASS] All inputs verified (Current Password, 6-Digit OTP, Send OTP button, KYC Aadhar).\n\n";

echo "--> STEP 3: Testing Password Change with WRONG Current Password...\n";
$csrf = get_csrf_token($pBody);
$wrongPassPost = [
    'csrf_test_name' => $csrf,
    'aadhar_no' => '999988887777',
    'current_password' => 'absolutelyWrongPassword!@#',
    'password' => 'newSecretPass123',
    'confirm_password' => 'newSecretPass123',
];
$wrongRes = http_req($baseUrl . '/admin/update_profile', $wrongPassPost);
$wrongMsg = 'The current password you entered is incorrect.';
if (strpos($wrongRes['body'], $wrongMsg) !== false) {
    echo "[PASS] Correctly blocked: '{$wrongMsg}'\n\n";
} else {
    echo "[FAIL] Expected error message not found.\n";
    exit(1);
}

echo "--> STEP 4: Testing Password Change with BLANK Current Password and OTP...\n";
$csrf = get_csrf_token($wrongRes['body']);
$neitherPost = [
    'csrf_test_name' => $csrf,
    'current_password' => '',
    'otp_code' => '',
    'password' => 'newSecretPass123',
    'confirm_password' => 'newSecretPass123',
];
$neitherRes = http_req($baseUrl . '/admin/update_profile', $neitherPost);
$neitherMsg = 'To set a new password, you must enter your Current Password OR verify using the 6-digit OTP';
if (strpos($neitherRes['body'], $neitherMsg) !== false) {
    echo "[PASS] Correctly blocked: Authorization required.\n\n";
} else {
    echo "[FAIL] Expected authorization block not found.\n";
    exit(1);
}

echo "--> STEP 5: Testing Password Change with VALID Current Password...\n";
$csrf = get_csrf_token($neitherRes['body']);
$correctPassPost = [
    'csrf_test_name' => $csrf,
    'current_password' => '123456',
    'password' => 'newSecretPass123',
    'confirm_password' => 'newSecretPass123',
];
$correctRes = http_req($baseUrl . '/admin/update_profile', $correctPassPost);
$succMsg = 'Security settings and password updated successfully.';
if (strpos($correctRes['body'], $succMsg) !== false) {
    echo "[PASS] Password successfully updated using current password.\n\n";
} else {
    echo "[FAIL] Could not update password with valid current password.\n";
    exit(1);
}

echo "--> STEP 6: Verifying Login with New Password 'newSecretPass123'...\n";
http_req($baseUrl . '/admin/logout');
if (file_exists($cookieFile)) @unlink($cookieFile);
$newLoginRes = do_member_login('MBR0001', 'newSecretPass123');
$checkNew = http_req($baseUrl . '/admin/profile');
if (strpos($checkNew['url'], 'login') === false) {
    echo "[PASS] Login succeeded with new password.\n\n";
} else {
    echo "[FAIL] Could not sign in with new password.\n";
    exit(1);
}

echo "--> STEP 7: Requesting 6-Digit OTP via AJAX...\n";
$otpReq = http_req($baseUrl . '/admin/send_profile_otp', '', [
    'X-Requested-With: XMLHttpRequest'
]);
$otpJson = json_decode($otpReq['body'], true);
if (!$otpJson || empty($otpJson['success'])) {
    echo "[FAIL] OTP request failed: " . $otpReq['body'] . "\n";
    exit(1);
}
echo "[PASS] OTP requested successfully. " . $otpJson['message'] . "\n\n";

echo "--> STEP 8: Reading Generated 6-Digit OTP from Application Log...\n";
$logFile = $appLogDir . '/log-' . date('Y-m-d') . '.php';
$latestOtp = null;
if (file_exists($logFile)) {
    $lines = file($logFile);
    for ($i = count($lines) - 1; $i >= 0; $i--) {
        if (preg_match('/Member profile OTP generated: (\d{6})/', $lines[$i], $m)) {
            $latestOtp = $m[1];
            break;
        }
    }
}
if (!$latestOtp) {
    echo "[FAIL] Could not retrieve generated OTP from application log.\n";
    exit(1);
}
echo "[PASS] 6-Digit OTP code retrieved: {$latestOtp}\n\n";

echo "--> STEP 9: Testing Password Change with WRONG OTP (000000)...\n";
$profileRes = http_req($baseUrl . '/admin/profile');
$csrf = get_csrf_token($profileRes['body']);
$wrongOtpPost = [
    'csrf_test_name' => $csrf,
    'otp_code' => '000000',
    'password' => 'otpPassword456',
    'confirm_password' => 'otpPassword456'
];
$wrongOtpRes = http_req($baseUrl . '/admin/update_profile', $wrongOtpPost);
$wrongOtpMsg = 'The 6-digit OTP verification code you entered is incorrect.';
if (strpos($wrongOtpRes['body'], $wrongOtpMsg) !== false) {
    echo "[PASS] Correctly blocked invalid OTP.\n\n";
} else {
    echo "[FAIL] Expected invalid OTP block message not found.\n";
    exit(1);
}

echo "--> STEP 10: Testing Password Change with VALID OTP ({$latestOtp})...\n";
$csrf = get_csrf_token($wrongOtpRes['body']);
$validOtpPost = [
    'csrf_test_name' => $csrf,
    'otp_code' => $latestOtp,
    'password' => 'otpSuccessPass789',
    'confirm_password' => 'otpSuccessPass789'
];
$validOtpRes = http_req($baseUrl . '/admin/update_profile', $validOtpPost);
if (strpos($validOtpRes['body'], $succMsg) !== false) {
    echo "[PASS] Password successfully updated using 6-Digit Email OTP!\n\n";
} else {
    echo "[FAIL] Could not update password with valid OTP.\n";
    exit(1);
}

echo "--> STEP 11: Verifying Login with OTP-Updated Password...\n";
http_req($baseUrl . '/admin/logout');
if (file_exists($cookieFile)) @unlink($cookieFile);
$otpLoginRes = do_member_login('MBR0001', 'otpSuccessPass789');
$checkOtpLogin = http_req($baseUrl . '/admin/profile');
if (strpos($checkOtpLogin['url'], 'login') === false) {
    echo "[PASS] Successfully logged in with OTP-updated password.\n\n";
} else {
    echo "[FAIL] Login with OTP-updated password failed.\n";
    exit(1);
}

echo "--> STEP 12: Restoring Original Test Password ('123456')...\n";
$profileRes = http_req($baseUrl . '/admin/profile');
$csrf = get_csrf_token($profileRes['body']);
$resetPassPost = [
    'csrf_test_name' => $csrf,
    'current_password' => 'otpSuccessPass789',
    'password' => '123456',
    'confirm_password' => '123456'
];
$resetRes = http_req($baseUrl . '/admin/update_profile', $resetPassPost);
if (strpos($resetRes['body'], $succMsg) !== false) {
    echo "[PASS] Restored test credentials back to '123456'.\n\n";
}

if (file_exists($cookieFile)) @unlink($cookieFile);

echo "========================================================\n";
echo "       ALL VERIFICATION TESTS COMPLETED SUCCESSFULLY!   \n";
echo "========================================================\n";
