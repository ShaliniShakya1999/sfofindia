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

define('RAZORPAY_KEY_ID', 'rzp_test_xxxxxxxx');    // YAHAN APNA KEY ID DALO (Razorpay dashboard se copy karke)
define('RAZORPAY_KEY_SECRET', 'your_secret_key');   // YAHAN APNA KEY SECRET DALO (Razorpay dashboard se copy karke)
