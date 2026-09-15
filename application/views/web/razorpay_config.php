<?php
/**
 * ============================================================
 * ONLINE PAYMENT ENABLE KARNE KE LIYE YE DO CHEEZEIN DALNI HAIN
 * ============================================================
 *
 * 1. Razorpay par account banao: https://razorpay.com
 * 2. Login karke jao: https://dashboard.razorpay.com/app/keys
 * 3. "Generate Key" click karo (pehli baar) - Key ID aur Key Secret milega
 * 4. Neeche KEY_ID ki jagah apna Key ID paste karo (e.g. rzp_test_AbCdEfGh)
 * 5. KEY_SECRET ki jagah apna Key Secret paste karo (e.g. XyZ123AbC...)
 *
 * Test mode: rzp_test_... keys use karo (testing ke liye)
 * Live mode: rzp_live_... keys use karo (real payment ke liye, KYC ke baad)
 *
 * ============================================================
 */

$razorpay_key_id = trim((string) getenv('SFOF_RAZORPAY_KEY_ID'));
$razorpay_key_secret = trim((string) getenv('SFOF_RAZORPAY_KEY_SECRET'));

if ($razorpay_key_id !== '') {
    defined('RAZORPAY_KEY_ID') or define('RAZORPAY_KEY_ID', $razorpay_key_id);
}
if ($razorpay_key_secret !== '') {
    defined('RAZORPAY_KEY_SECRET') or define('RAZORPAY_KEY_SECRET', $razorpay_key_secret);
}

