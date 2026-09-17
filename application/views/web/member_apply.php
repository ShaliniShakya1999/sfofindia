<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<?php
$razorpay_enabled = false;
if (file_exists(__DIR__ . '/razorpay_config.php')) {
    include_once __DIR__ . '/razorpay_config.php';
    $razorpay_enabled = defined('RAZORPAY_KEY_ID') && RAZORPAY_KEY_ID !== '' && RAZORPAY_KEY_ID !== 'rzp_test_xxxxxxxx' && defined('RAZORPAY_KEY_SECRET') && RAZORPAY_KEY_SECRET !== '';
}
if (!$razorpay_enabled && !empty($cms['razorpay_key_id']) && $cms['razorpay_key_id'] !== 'rzp_test_xxxxxxxx') {
    $razorpay_enabled = true;
    if (!defined('RAZORPAY_KEY_ID')) define('RAZORPAY_KEY_ID', $cms['razorpay_key_id']);
}
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<body>
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-dark: #1e3a8a;
            --soft-blue: #f8fafc;
            --success-green: #10b981;
            --error-red: #ef4444;
            --charity-pink: #db2777;
        }
        .member-apply-shell { position: relative; }
        .member-apply-card {
            border: 0 !important;
            border-radius: 0 0 24px 24px;
            background: #fff;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            border-top: 4px solid var(--primary-dark) !important;
        }
        
        .form-section-head {
            background: #f8fafc;
            padding: 13px 22px;
            margin: 25px -30px 20px -30px;
            border-left: 5px solid var(--primary-dark);
            display: flex;
            align-items: center;
            font-weight: 700;
            color: var(--primary-dark);
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-section-head i { margin-right: 10px; font-size: 1.1rem; }
        .form-section-head.charity-head { border-left-color: var(--primary-dark); color: var(--primary-dark); }

        .verification-widget {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .verification-widget.verified {
            border-color: var(--success-green);
            background: #f0fdf4;
        }

        .form-label { font-weight: 600; color: #4b5563; margin-bottom: 7px; font-size: 0.88rem; }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .bank-details-card {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: #fff;
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
            position: relative;
            overflow: hidden;
        }
        .bank-details-card::after {
            content: "\f19c";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 120px;
            opacity: 0.1;
            transform: rotate(-15deg);
        }
        .bank-row { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 5px; }
        .bank-label { font-size: 0.8rem; text-transform: uppercase; opacity: 0.8; }
        .bank-value { font-weight: 700; font-family: monospace; font-size: 1.05rem; }

        .member-upload-preview {
            height: 90px;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
            display: flex;
            align-items: center; justify-content: center;
            overflow: hidden; cursor: pointer;
            transition: all 0.2s;
        }
        .member-upload-preview:hover { border-color: var(--primary-blue); background: #f1f5f9; }
        .member-upload-preview img { width: 100%; height: 100%; object-fit: contain; }
        .member-upload-preview span { font-size: 0.82rem; color: #64748b; text-align: center; padding: 8px; line-height: 1.3; font-weight: 500; }

        /* Registration & Payment Submit Button */
        .btn-submit-premium {
            background-color: #0f172a;
            color: #ffffff !important;
            padding: 13px 38px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.2px;
            border: 1px solid #0f172a;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-submit-premium:hover {
            background-color: #1e293b;
            border-color: #1e293b;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.18);
        }
        .btn-submit-premium:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.12);
        }

        .member-popup { position: fixed; inset: 0; z-index: 9999; display: none; align-items: center; justify-content: center; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); }
        .member-popup.is-visible { display: flex; }
        .member-popup-card { background: #fff; padding: 35px; border-radius: 24px; text-align: center; max-width: 400px; width: 90%; box-shadow: 0 20px 40px rgba(0,0,0,0.2); }

        /* Animations */
        @keyframes highlightFill {
            0% { background: #fff; }
            50% { background: #dcfce7; }
            100% { background: #fff; }
        }
        .field-updated { animation: highlightFill 0.8s ease; }

        .cursor-pointer { cursor: pointer; }
    </style>

    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>

    <?php include 'topbar.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Membership Registration</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Join Us</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">
            <?php $ci =& get_instance(); $success_message = $ci->session->flashdata('success'); $error_message = $ci->session->flashdata('error'); ?>

            <div class="mx-auto member-apply-shell" style="max-width: 1000px;">
                <div class="text-center rounded-top py-4 shadow-sm" style="background:#1e3a8a; margin-bottom: -1px;">
                    <h2 class="text-white mb-0">Join Our Mission</h2>
                    <p class="text-white-50 mb-0">Become a certified member of Shaheed Foundation India</p>
                </div>

                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('join-us/submit'); ?>" class="member-apply-card p-4 p-lg-5" id="memberApplyForm">
                    <input type="text" name="website" value="" autocomplete="off" tabindex="-1" aria-hidden="true" style="position:absolute;left:-10000px;width:1px;height:1px;">
                    
                    <!-- Section 1: Identity Verification (PaySprint Aadhaar API) -->
                    <div class="form-section-head">
                        <i class="fas fa-shield-alt"></i> 1. Identity Verification
                    </div>
                    
                    <div class="verification-widget" id="aadharWidget">
                        <div id="aadhar_input_group">
                            <label class="form-label fw-semibold">Aadhaar Number <span class="text-danger">*</span></label>
                            <div class="row g-2 align-items-center">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="height: 48px;"><i class="fas fa-address-card text-muted"></i></span>
                                        <input type="text" name="aadhar_no" id="aadhar_no" class="form-control border-start-0" placeholder="Enter 12-digit Aadhaar number" maxlength="14" style="height: 48px; font-size: 1.05rem;" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-warning w-100 fw-bold d-flex align-items-center justify-content-center shadow-sm" id="btnSendOtp" style="height: 48px; background: #eab308; border-color: #eab308; color: #000; font-size: 0.95rem;">
                                        <i class="fas fa-paper-plane me-2"></i> Send OTP
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Enter 12-digit Aadhaar number to verify with OTP.</small>
                            <div id="aadhar_feedback" class="small mt-1" style="display:none;"></div>
                        </div>

                        <div id="otpSection" class="mt-4 pt-3 border-top" style="display:none;">
                            <div class="row g-3 align-items-end justify-content-center">
                                <div class="col-md-8 text-center">
                                    <div class="alert alert-info py-2 small mb-3">
                                        <i class="fas fa-info-circle me-1"></i> OTP has been sent to your Aadhaar-linked mobile.
                                    </div>
                                    <label class="form-label text-primary fw-bold">Enter 6-digit OTP</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="aadhar_otp" class="form-control text-center fs-4 fw-bold border-primary" placeholder="Enter 6-digit OTP" maxlength="6">
                                    </div>
                                    <div id="verifyingMsg" class="mt-2 text-primary small" style="display:none;">
                                        <i class="fas fa-circle-notch fa-spin me-1"></i> Authenticating with UIDAI...
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-secondary w-100 py-2" id="btnChangeAadhar">Change Number</button>
                                        <button type="button" class="btn btn-primary w-100 py-2 fw-bold shadow-sm" id="btnVerifyOtp">Verify Identity</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="verifiedBadge" style="display:none;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 bg-white rounded-3 border border-success shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.3rem;">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="badge bg-success text-white px-2 py-1"><i class="fas fa-check-circle me-1"></i> Aadhaar Authenticated</span>
                                            <small class="text-muted fw-bold" id="verifiedAadharMasked">XXXX-XXXX-XXXX</small>
                                        </div>
                                        <div class="text-secondary small">
                                            Name: <strong id="verifiedNameDisplay" class="text-dark">...</strong> &nbsp;|&nbsp;
                                            DOB: <strong id="verifiedDobDisplay" class="text-dark">...</strong> &nbsp;|&nbsp;
                                            Gender: <strong id="verifiedGenderDisplay" class="text-dark">...</strong>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" id="btnReVerifyAadhar" style="font-size: 0.82rem;">
                                        <i class="fas fa-redo me-1"></i> Change Number
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="aadhar_verified" id="aadhar_verified" value="0">
                    <input type="hidden" name="aadhar_data" id="aadhar_data" value="">
                    <input type="hidden" id="aadhar_client_id" value="">

                    <!-- Section 2: Personal Details -->
                    <div class="form-section-head">
                        <i class="fas fa-user-circle"></i> 2. Personal Information
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="As per documents" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Gender *</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Relation Type</label>
                            <select name="relation_type" class="form-select">
                                <option value="S/O">Son Of (S/O)</option>
                                <option value="D/O">Daughter Of (D/O)</option>
                                <option value="W/O">Wife Of (W/O)</option>
                                <option value="C/O">Care Of (C/O)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Relation Name</label>
                            <input type="text" name="relation_name" class="form-control" placeholder="Father/Husband Name">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Profession</label>
                            <input type="text" name="profession" class="form-control" placeholder="e.g. Engineer, Business">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Blood Group</label>
                            <select name="blood_group" class="form-select">
                                <option value="">Select Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section 3: Contact Details -->
                    <div class="form-section-head">
                        <i class="fas fa-phone-alt"></i> 3. Communication & Location
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number *</label>
                            <input type="text" name="mobile" id="member_mobile" class="form-control" placeholder="10-digit mobile number" maxlength="15" required>
                            <div id="mobile_feedback" class="small mt-1" style="display:none;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" id="member_email" class="form-control" placeholder="example@mail.com" required autocomplete="email">
                            <div id="email_feedback" class="small mt-1" style="display:none;"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Residential Address *</label>
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Full address" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State *</label>
                            <input type="text" name="state" id="state" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">District *</label>
                            <input type="text" name="district" id="district" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pin Code *</label>
                            <input type="text" name="pin_code" id="pin_code" class="form-control" maxlength="6" required>
                        </div>
                    </div>

                    <!-- Section 4: Identity Documents -->
                    <div class="form-section-head">
                        <i class="fas fa-file-upload"></i> 4. Identity Documents
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Aadhaar Front <span class="text-danger">*</span></label>
                            <input type="file" name="aadhar_front" class="form-control member-file-input" accept="image/*" data-preview-id="frontPreview" required>
                            <div class="member-upload-preview mt-2" id="frontPreview">
                                <span><i class="fas fa-id-card d-block mb-1 text-primary fs-5"></i>Front Side</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Aadhaar Back <span class="text-danger">*</span></label>
                            <input type="file" name="aadhar_back" class="form-control member-file-input" accept="image/*" data-preview-id="backPreview" required>
                            <div class="member-upload-preview mt-2" id="backPreview">
                                <span><i class="fas fa-id-card-alt d-block mb-1 text-primary fs-5"></i>Back Side</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small">
                        <i class="fas fa-info-circle text-primary me-1"></i> Profile photo is not required during initial registration. Members can upload and update their profile photo anytime later from their dashboard.
                    </div>

                    <!-- Section 5: Membership Fee & Payment Method -->
                    <div class="form-section-head">
                        <i class="fas fa-hand-holding-heart"></i> 5. Membership Fee & Payment Method
                    </div>
                    <div class="row g-4">
                        <?php 
                        $fixed_fee = (int) cms_val($cms, 'membership_fee', '5000'); 
                        if ($fixed_fee <= 0) { $fixed_fee = 5000; }
                        ?>
                        <div class="col-md-6">
                            <label class="form-label">Annual Membership Fee <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 fw-bold text-primary">₹</span>
                                <input type="text" name="donation_amount" id="donation_amount_input" class="form-control border-start-0 fw-bold" value="<?php echo $fixed_fee; ?>" readonly>
                                <span class="input-group-text bg-light text-muted small">Fixed (1 Year)</span>
                            </div>
                            <small class="text-muted d-block mt-2">Standard mandatory annual membership contribution (valid 1 year from approval).</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_mode" id="selected_payment_mode" class="form-select" required>
                                <option value="UPI / QR Code" selected>UPI / QR Code (Google Pay, PhonePe, Paytm, BHIM)</option>
                                <option value="Credit / Debit Card">Credit / Debit Card (Visa, MasterCard, RuPay)</option>
                                <option value="Netbanking">Netbanking (All Major Indian Banks)</option>
                                <option value="Bank Transfer">Direct Bank Transfer (NEFT / RTGS / IMPS)</option>
                            </select>
                            <small class="text-muted d-block mt-2">Choose how you wish to pay the membership registration fee.</small>
                        </div>

                        <div class="col-12">
                            <!-- 1. UPI Payment Mode Details -->
                            <div class="verification-widget" id="panel_upi">
                                <div class="row g-4 align-items-center">
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold mb-2"><i class="fas fa-qrcode text-primary me-2"></i>UPI / QR Code Payment</label>
                                        <p class="text-muted small mb-3">Scan the official QR code or copy the UPI ID below to pay directly from Google Pay, PhonePe, Paytm, or BHIM.</p>
                                        
                                        <div class="mb-3">
                                            <label class="form-label small text-muted mb-1">Official Foundation UPI ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-white font-monospace fw-bold" value="<?php echo html_escape(cms_val($cms, 'bank_upi_id', 'shaheedfoundation@axisbank')); ?>" id="upiIdText" readonly>
                                                <button type="button" class="btn btn-outline-primary" id="btnCopyUpi"><i class="fas fa-copy me-1"></i> Copy UPI ID</button>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label small text-muted mb-1">UPI Transaction Reference / UTR Number <span class="text-muted fw-normal">(Optional)</span></label>
                                            <input type="text" name="upi_utr" id="upi_utr" class="form-control" placeholder="12-digit UTR number after payment">
                                        </div>
                                        <small class="text-muted d-block mt-1"><i class="fas fa-shield-alt text-success me-1"></i> Verified Merchant: <strong><?php echo html_escape(cms_val($cms, 'bank_account_name', 'SHAHEED FOUNDATION')); ?></strong></small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="p-3 bg-white rounded-3 border d-inline-block text-center shadow-sm">
                                            <img id="upiQrPreview" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode('upi://pay?pa=' . cms_val($cms, 'bank_upi_id', 'shaheedfoundation@axisbank') . '&pn=Shaheed%20Foundation&am=' . $fixed_fee . '&cu=INR'); ?>" alt="UPI QR" class="img-fluid rounded" style="width: 130px; height: 130px;">
                                            <small class="text-muted d-block fw-bold mt-2">Scan & Pay ₹<?php echo number_format($fixed_fee); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Credit / Debit Cards Panel -->
                            <div class="verification-widget d-none" id="panel_card">
                                <label class="form-label fw-semibold mb-2"><i class="fas fa-credit-card text-primary me-2"></i>Credit / Debit Card Payment</label>
                                <p class="text-muted small mb-3">Accepts all major Visa, MasterCard, RuPay, and Maestro cards.</p>
                                <div class="alert alert-info py-2 small mb-0 d-flex align-items-center gap-2">
                                    <i class="fas fa-shield-alt text-primary fs-5"></i>
                                    <div>
                                        <strong>256-Bit SSL Encrypted:</strong> After clicking Submit, the secure card payment gateway will open for OTP authentication with your bank.
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Netbanking Panel -->
                            <div class="verification-widget d-none" id="panel_netbanking">
                                <label class="form-label fw-semibold mb-2"><i class="fas fa-laptop text-primary me-2"></i>Netbanking</label>
                                <p class="text-muted small mb-3">Support for 50+ Indian banks including SBI, HDFC, ICICI, Axis, Kotak, and PNB.</p>
                                <div class="alert alert-info py-2 small mb-0 d-flex align-items-center gap-2">
                                    <i class="fas fa-info-circle text-primary fs-5"></i>
                                    <div>
                                        You will be securely routed to your bank's authentication gateway to complete the ₹<?php echo number_format($fixed_fee); ?> transaction.
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Direct Bank Transfer Panel -->
                            <div class="verification-widget d-none" id="panel_bank_transfer">
                                <label class="form-label fw-semibold mb-3"><i class="fas fa-university text-primary me-2"></i>Foundation Official Bank Account Details</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 bg-white rounded-3 border small">
                                            <div class="mb-1"><span class="text-muted">Account Name:</span> <strong class="text-dark"><?php echo html_escape(cms_val($cms, 'bank_account_name', 'SHAHEED FOUNDATION')); ?></strong></div>
                                            <div class="mb-1"><span class="text-muted">Bank Name:</span> <strong class="text-dark"><?php echo html_escape(cms_val($cms, 'bank_name', 'AXIS BANK')); ?></strong></div>
                                            <div class="mb-1"><span class="text-muted">Account Number:</span> <strong class="text-dark font-monospace"><?php echo html_escape(cms_val($cms, 'bank_account_no', '925010034361992')); ?></strong></div>
                                            <div class="mb-1"><span class="text-muted">IFSC Code:</span> <strong class="text-dark font-monospace"><?php echo html_escape(cms_val($cms, 'bank_ifsc', 'UTIB0001970')); ?></strong></div>
                                            <div><span class="text-muted">Branch:</span> <strong class="text-dark"><?php echo html_escape(cms_val($cms, 'bank_branch', 'Sector 29, Gurgaon')); ?></strong></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">NEFT / RTGS / UTR Reference Number</label>
                                        <input type="text" name="bank_utr" id="bank_utr" class="form-control mb-3" placeholder="Enter 12 or 16-digit UTR number">

                                        <label class="form-label">Upload Payment Receipt</label>
                                        <input type="file" name="payment_receipt" class="form-control member-file-input" accept="image/*,application/pdf" data-preview-id="payPreview">
                                        <div class="member-upload-preview mt-2" id="payPreview" style="height: 70px;">
                                            <span>Click to upload transaction receipt (screenshot or PDF)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center pt-5">
                        <button type="submit" class="btn btn-submit-premium" id="btnSubmitForm">
                            <i class="fas fa-shield-alt me-2"></i> Submit Registration &bull; Pay ₹<?php echo number_format($fixed_fee); ?>
                        </button>
                    </div>
                </form>

                <div class="member-popup" id="memberStatusPopup">
                    <div class="member-popup-card">
                        <div id="popupIconBox"></div>
                        <h3 id="popupTitle">...</h3>
                        <p id="popupMsg">...</p>
                        <button type="button" class="btn btn-primary rounded-pill px-4" id="memberPopupClose">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script>
        (function () {
            var popup = document.getElementById('memberStatusPopup');
            var popupClose = document.getElementById('memberPopupClose');
            if (popup) {
                <?php if (!empty($success_message) || !empty($error_message)): ?>
                var isSuccess = <?php echo !empty($success_message) ? 'true' : 'false'; ?>;
                var msg = "<?php echo addslashes((string)(!empty($success_message) ? $success_message : $error_message)); ?>";
                document.getElementById('popupTitle').innerText = isSuccess ? 'Success!' : 'Oops!';
                document.getElementById('popupMsg').innerText = msg;
                document.getElementById('popupIconBox').innerHTML = isSuccess ? '<i class="fas fa-check-circle text-success fs-1"></i>' : '<i class="fas fa-times-circle text-danger fs-1"></i>';
                popup.classList.add('is-visible');
                <?php endif; ?>

                popupClose.addEventListener('click', function() { popup.classList.remove('is-visible'); });
            }

            $('.member-file-input').on('change', function() {
                var preview = $('#' + $(this).data('preview-id'));
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.html('<img src="' + e.target.result + '" style="max-height:100%; border-radius:10px;">');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $('.member-upload-preview').on('click', function() {
                $(this).siblings('.member-file-input').trigger('click');
            });

            // --- Unique Email Real-time Verification ---
            var emailInput = $('#member_email');
            var emailFeedback = $('#email_feedback');
            var emailAvailable = true;
            var emailTimer = null;

            function validateEmailFormat(email) {
                var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            function checkEmailUniqueness(callback) {
                var email = $.trim(emailInput.val());
                if (!email) {
                    emailFeedback.hide().removeClass('text-danger text-success text-muted').text('');
                    emailInput.removeClass('is-invalid is-valid');
                    emailAvailable = false;
                    if (typeof callback === 'function') callback(false);
                    return;
                }
                if (!validateEmailFormat(email)) {
                    emailFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-exclamation-circle me-1"></i> Please enter a valid email format.');
                    emailInput.removeClass('is-valid').addClass('is-invalid');
                    emailAvailable = false;
                    if (typeof callback === 'function') callback(false);
                    return;
                }

                emailFeedback.show().removeClass('text-danger text-success').addClass('text-muted').html('<i class="fas fa-spinner fa-spin me-1"></i> Checking email availability...');

                $.ajax({
                    url: '<?php echo site_url("join-us/check-email"); ?>',
                    type: 'GET',
                    data: { email: email },
                    dataType: 'json',
                    success: function(res) {
                        if (res && res.status === 'success') {
                            if (res.available) {
                                emailFeedback.show().removeClass('text-danger text-muted').addClass('text-success').html('<i class="fas fa-check-circle me-1"></i> ' + res.message);
                                emailInput.removeClass('is-invalid').addClass('is-valid');
                                emailAvailable = true;
                                if (typeof callback === 'function') callback(true);
                            } else {
                                emailFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-times-circle me-1"></i> ' + res.message);
                                emailInput.removeClass('is-valid').addClass('is-invalid');
                                emailAvailable = false;
                                if (typeof callback === 'function') callback(false);
                            }
                        } else {
                            emailFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-exclamation-circle me-1"></i> ' + (res.message || 'Error checking email.'));
                            emailInput.removeClass('is-valid').addClass('is-invalid');
                            emailAvailable = false;
                            if (typeof callback === 'function') callback(false);
                        }
                    },
                    error: function() {
                        emailFeedback.hide();
                        if (typeof callback === 'function') callback(true);
                    }
                });
            }

            emailInput.on('blur', function() {
                checkEmailUniqueness();
            });

            emailInput.on('input', function() {
                clearTimeout(emailTimer);
                emailTimer = setTimeout(checkEmailUniqueness, 500);
            });

            // --- Unique Mobile Real-time Verification ---
            var mobileInput = $('#member_mobile');
            var mobileFeedback = $('#mobile_feedback');
            var mobileAvailable = true;
            var mobileTimer = null;

            function checkMobileUniqueness(callback) {
                var mob = $.trim(mobileInput.val());
                var digits = mob.replace(/\D/g, '');
                if (!mob) {
                    mobileFeedback.hide().removeClass('text-danger text-success text-muted').text('');
                    mobileInput.removeClass('is-invalid is-valid');
                    mobileAvailable = false;
                    if (typeof callback === 'function') callback(false);
                    return;
                }
                if (digits.length < 10) {
                    mobileFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-exclamation-circle me-1"></i> Please enter a valid 10-digit mobile number.');
                    mobileInput.removeClass('is-valid').addClass('is-invalid');
                    mobileAvailable = false;
                    if (typeof callback === 'function') callback(false);
                    return;
                }

                mobileFeedback.show().removeClass('text-danger text-success').addClass('text-muted').html('<i class="fas fa-spinner fa-spin me-1"></i> Checking mobile availability...');

                $.ajax({
                    url: '<?php echo site_url("join-us/check-mobile"); ?>',
                    type: 'GET',
                    data: { mobile: mob },
                    dataType: 'json',
                    success: function(res) {
                        if (res && res.status === 'success') {
                            if (res.available) {
                                mobileFeedback.show().removeClass('text-danger text-muted').addClass('text-success').html('<i class="fas fa-check-circle me-1"></i> ' + res.message);
                                mobileInput.removeClass('is-invalid').addClass('is-valid');
                                mobileAvailable = true;
                                if (typeof callback === 'function') callback(true);
                            } else {
                                mobileFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-times-circle me-1"></i> ' + res.message);
                                mobileInput.removeClass('is-valid').addClass('is-invalid');
                                mobileAvailable = false;
                                if (typeof callback === 'function') callback(false);
                            }
                        } else {
                            mobileFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-exclamation-circle me-1"></i> ' + (res.message || 'Error checking mobile.'));
                            mobileInput.removeClass('is-valid').addClass('is-invalid');
                            mobileAvailable = false;
                            if (typeof callback === 'function') callback(false);
                        }
                    },
                    error: function() {
                        mobileFeedback.hide();
                        if (typeof callback === 'function') callback(true);
                    }
                });
            }

            mobileInput.on('blur', function() {
                checkMobileUniqueness();
            });

            mobileInput.on('input', function() {
                clearTimeout(mobileTimer);
                mobileTimer = setTimeout(checkMobileUniqueness, 500);
            });

            // --- Aadhaar OTP Logic (PaySprint API) ---
            var btnSendOtp = $('#btnSendOtp');
            var btnVerifyOtp = $('#btnVerifyOtp');
            var btnChangeAadhar = $('#btnChangeAadhar');
            var aadharNoInput = $('#aadhar_no');
            var aadharFeedback = $('#aadhar_feedback');
            var otpSection = $('#otpSection');
            var aadharInputGroup = $('#aadhar_input_group');
            var verifiedBadge = $('#verifiedBadge');
            var aadharWidget = $('#aadharWidget');
            var aadharAvailable = true;
            var aadharTimer = null;

            function checkAadharUniqueness(callback) {
                var aadhar = $.trim(aadharNoInput.val()).replace(/\D/g, '');
                if (!aadhar) {
                    aadharFeedback.hide().removeClass('text-danger text-success text-muted').text('');
                    aadharNoInput.removeClass('is-invalid is-valid');
                    btnSendOtp.prop('disabled', false);
                    aadharAvailable = false;
                    if (typeof callback === 'function') callback(false);
                    return;
                }
                if (aadhar.length !== 12) {
                    aadharFeedback.hide();
                    aadharNoInput.removeClass('is-valid');
                    aadharAvailable = false;
                    if (typeof callback === 'function') callback(false);
                    return;
                }

                aadharFeedback.show().removeClass('text-danger text-success').addClass('text-muted').html('<i class="fas fa-spinner fa-spin me-1"></i> Checking Aadhaar registration...');

                $.ajax({
                    url: '<?php echo site_url("join-us/check-aadhar"); ?>',
                    type: 'GET',
                    data: { aadhar_no: aadhar },
                    dataType: 'json',
                    success: function(res) {
                        if (res && res.status === 'success') {
                            if (res.available) {
                                aadharFeedback.show().removeClass('text-danger text-muted').addClass('text-success').html('<i class="fas fa-check-circle me-1"></i> ' + res.message);
                                aadharNoInput.removeClass('is-invalid').addClass('is-valid');
                                btnSendOtp.prop('disabled', false);
                                aadharAvailable = true;
                                if (typeof callback === 'function') callback(true);
                            } else {
                                aadharFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-times-circle me-1"></i> ' + res.message);
                                aadharNoInput.removeClass('is-valid').addClass('is-invalid');
                                btnSendOtp.prop('disabled', true);
                                aadharAvailable = false;
                                if (typeof callback === 'function') callback(false);
                            }
                        } else {
                            aadharFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-exclamation-circle me-1"></i> ' + (res.message || 'Error checking Aadhaar.'));
                            aadharNoInput.removeClass('is-valid').addClass('is-invalid');
                            aadharAvailable = false;
                            if (typeof callback === 'function') callback(false);
                        }
                    },
                    error: function() {
                        aadharFeedback.hide();
                        btnSendOtp.prop('disabled', false);
                        if (typeof callback === 'function') callback(true);
                    }
                });
            }

            aadharNoInput.on('blur', function() {
                checkAadharUniqueness();
            });

            aadharNoInput.on('input', function() {
                clearTimeout(aadharTimer);
                btnSendOtp.prop('disabled', false);
                aadharTimer = setTimeout(checkAadharUniqueness, 500);
            });

            $('#memberApplyForm').on('submit', function(e) {
                var email = $.trim(emailInput.val());
                var mob = $.trim(mobileInput.val());
                var aadhar = $.trim(aadharNoInput.val()).replace(/\D/g, '');

                if (!email) {
                    e.preventDefault();
                    alert('Please enter your email address.');
                    emailInput.focus();
                    return false;
                }
                if (!validateEmailFormat(email)) {
                    e.preventDefault();
                    alert('Please enter a valid email address.');
                    emailInput.focus();
                    return false;
                }
                if (!emailAvailable) {
                    e.preventDefault();
                    alert('The email address you entered is already registered. Each member must have a unique email address.');
                    emailInput.focus();
                    return false;
                }
                if (!mob || mob.replace(/\D/g, '').length < 10) {
                    e.preventDefault();
                    alert('Please enter a valid 10-digit mobile number.');
                    mobileInput.focus();
                    return false;
                }
                if (!mobileAvailable) {
                    e.preventDefault();
                    alert('The mobile number you entered is already registered. Each member must have a unique contact number.');
                    mobileInput.focus();
                    return false;
                }
                if (aadhar && !aadharAvailable) {
                    e.preventDefault();
                    alert('The Aadhaar card number you entered is already registered. Each member must have a unique Aadhaar number.');
                    aadharNoInput.focus();
                    return false;
                }
            });

            function resetBtn(btn, text) {
                btn.prop('disabled', false).html(text);
            }

            btnSendOtp.on('click', function() {
                var aadharNo = aadharNoInput.val().replace(/\D/g, '');
                if (aadharNo.length !== 12) {
                    alert('Please enter a valid 12-digit Aadhaar number.');
                    aadharNoInput.focus();
                    return;
                }

                if (!aadharAvailable) {
                    alert('This Aadhaar card number is already registered with an existing member. Each member must have a unique Aadhaar number.');
                    aadharNoInput.focus();
                    return;
                }

                btnSendOtp.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Sending OTP...');
                $.ajax({
                    url: '<?php echo site_url("join-us/send_aadhaar_otp"); ?>',
                    type: 'POST',
                    data: { id_number: aadharNo },
                    dataType: 'json'
                }).done(function(res) {
                    resetBtn(btnSendOtp, '<i class="fas fa-paper-plane me-1"></i> Send OTP');
                    if (res && (res.statuscode === 200 || res.status === true) && res.data && res.data.client_id) {
                        $('#aadhar_client_id').val(res.data.client_id);
                        aadharInputGroup.fadeOut(300, function() {
                            otpSection.fadeIn(300);
                            $('#aadhar_otp').val('').focus();
                        });
                    } else if (res && res.statuscode === 409) {
                        aadharFeedback.show().removeClass('text-success text-muted').addClass('text-danger').html('<i class="fas fa-times-circle me-1"></i> ' + (res.message || 'This Aadhaar card is already registered.'));
                        aadharNoInput.removeClass('is-valid').addClass('is-invalid');
                        btnSendOtp.prop('disabled', true);
                        aadharAvailable = false;
                        alert(res.message);
                    } else {
                        var msg = (res && (res.message || res.msg)) ? (res.message || res.msg) : 'Error sending OTP. Please try again.';
                        alert(msg);
                    }
                }).fail(function(xhr) {
                    resetBtn(btnSendOtp, '<i class="fas fa-paper-plane me-1"></i> Send OTP');
                    var errMsg = 'Server error while sending OTP. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    alert(errMsg);
                });
            });

            btnChangeAadhar.on('click', function() {
                otpSection.fadeOut(300, function() {
                    aadharInputGroup.fadeIn(300);
                    aadharNoInput.focus();
                });
            });

            $('#btnReVerifyAadhar').on('click', function() {
                verifiedBadge.fadeOut(200, function() {
                    aadharWidget.removeClass('verified');
                    $('#aadhar_verified').val(0);
                    $('#aadhar_data').val('');
                    aadharInputGroup.fadeIn(300);
                    aadharNoInput.focus();
                });
            });

            btnVerifyOtp.on('click', function() {
                var otp = $('#aadhar_otp').val().replace(/\D/g, '');
                var clientId = $('#aadhar_client_id').val();
                if (otp.length < 4) {
                    alert('Please enter the OTP received on your Aadhaar-linked mobile number.');
                    $('#aadhar_otp').focus();
                    return;
                }

                $('#verifyingMsg').show();
                btnVerifyOtp.prop('disabled', true);

                $.ajax({
                    url: '<?php echo site_url("join-us/verify_aadhaar_otp"); ?>',
                    type: 'POST',
                    data: { client_id: clientId, otp: otp, refid: String(Date.now()) },
                    dataType: 'json'
                }).done(function(res) {
                    $('#verifyingMsg').hide();
                    btnVerifyOtp.prop('disabled', false);

                    if (res && (res.statuscode === 200 || res.status === true) && res.data) {
                        var d = res.data;
                        $('#aadhar_verified').val(1);
                        $('#aadhar_data').val(typeof d === 'object' ? JSON.stringify(d) : String(d));
                        
                        // Auto-fill applicant details
                        if (d.full_name) $('#name').val(d.full_name).addClass('field-updated');
                        if (d.dob) $('#dob').val(d.dob).addClass('field-updated');
                        if (d.gender) {
                            var gen = d.gender.toUpperCase();
                            if (gen === 'M' || gen === 'MALE') $('#gender').val('Male').addClass('field-updated');
                            else if (gen === 'F' || gen === 'FEMALE') $('#gender').val('Female').addClass('field-updated');
                            else $('#gender').val(d.gender).addClass('field-updated');
                        }
                        if (d.zip) $('#pin_code').val(d.zip).addClass('field-updated');

                        // Address Parsing
                        if (d.address && typeof d.address === 'object') {
                            var a = d.address;
                            var addrParts = [];
                            if (a.house) addrParts.push(a.house);
                            if (a.street) addrParts.push(a.street);
                            if (a.loc) addrParts.push(a.loc);
                            if (a.po) addrParts.push(a.po);
                            if (a.vtc) addrParts.push(a.vtc);
                            if (a.subdist) addrParts.push(a.subdist);
                            if (a.dist) addrParts.push(a.dist);
                            if (a.state) addrParts.push(a.state);
                            
                            if (addrParts.length > 0) {
                                $('#address').val(addrParts.join(', ')).addClass('field-updated');
                            }
                            if (a.state) $('#state').val(a.state).addClass('field-updated');
                            if (a.dist) $('#district').val(a.dist).addClass('field-updated');
                        } else if (typeof d.address === 'string' && d.address) {
                            $('#address').val(d.address).addClass('field-updated');
                        }

                        otpSection.hide();
                        verifiedBadge.fadeIn();
                        aadharWidget.addClass('verified');
                        if (d.full_name) $('#verifiedNameDisplay').text(d.full_name);
                        if (d.dob) $('#verifiedDobDisplay').text(d.dob);
                        var genText = 'Not specified';
                        if (d.gender) {
                            var gUpper = d.gender.toUpperCase();
                            genText = (gUpper === 'M' || gUpper === 'MALE') ? 'Male' : ((gUpper === 'F' || gUpper === 'FEMALE') ? 'Female' : d.gender);
                        }
                        $('#verifiedGenderDisplay').text(genText);

                        var rawAadhar = $('#aadhar_no').val().replace(/\D/g, '');
                        if (rawAadhar.length >= 4) {
                            $('#verifiedAadharMasked').text('XXXX-XXXX-' + rawAadhar.slice(-4));
                        }
                        
                        setTimeout(function() { $('.field-updated').removeClass('field-updated'); }, 3000);
                    } else {
                        var msg = (res && (res.message || res.msg)) ? (res.message || res.msg) : 'OTP Verification Failed. Please try again.';
                        alert(msg);
                    }
                }).fail(function(xhr) {
                    $('#verifyingMsg').hide();
                    btnVerifyOtp.prop('disabled', false);
                    var errMsg = 'Server error during verification. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    alert(errMsg);
                });
            });

            // =========================================================================
            // PAYMENT MODE SELECTOR & PAYMENT DISPATCHER (READY BLOCK)
            // =========================================================================
            var selectedPaymentMode = $('#selected_payment_mode');
            var donationAmountInput = $('#donation_amount_input');
            var btnSubmitPremium = $('.btn-submit-premium');
            var upiVpa = <?php echo json_encode(cms_val($cms, 'bank_upi_id', 'shaheedfoundation@axisbank')); ?>;
            var razorpayKeyId = <?php echo $razorpay_enabled ? json_encode(RAZORPAY_KEY_ID) : '""'; ?>;

            // Update Dynamic UI based on Amount & Chosen Mode
            function updatePaymentState() {
                var amt = parseFloat(donationAmountInput.val()) || 0;
                var mode = selectedPaymentMode.val();

                if (amt > 0) {
                    if (mode.indexOf('Bank Transfer') !== -1) {
                        btnSubmitPremium.html('<i class="fas fa-check-circle me-2"></i> Submit Registration (₹' + amt.toLocaleString('en-IN') + ')');
                    } else {
                        btnSubmitPremium.html('<i class="fas fa-shield-alt me-2"></i> Proceed to Pay ₹' + amt.toLocaleString('en-IN') + ' & Register');
                    }
                } else {
                    btnSubmitPremium.html('Submit Registration');
                }

                // Dynamic UPI Intent URL & QR Code
                var upiPayUrl = 'upi://pay?pa=' + encodeURIComponent(upiVpa) + '&pn=' + encodeURIComponent('Shaheed Foundation') + '&cu=INR';
                if (amt > 0) {
                    upiPayUrl += '&am=' + amt.toFixed(2);
                    $('#btnUpiDeepLink').removeClass('d-none').attr('href', upiPayUrl);
                } else {
                    $('#btnUpiDeepLink').addClass('d-none');
                }
                var qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(upiPayUrl);
                $('#upiQrPreview').attr('src', qrUrl);
            }

            donationAmountInput.on('input change', updatePaymentState);
            // Initialize payment UI immediately on page load
            updatePaymentState();

            // Payment Mode Dropdown Change
            selectedPaymentMode.on('change', function() {
                var mode = $(this).val() || '';
                $('#panel_upi, #panel_card, #panel_netbanking, #panel_bank_transfer').addClass('d-none');

                if (mode.indexOf('UPI') !== -1) {
                    $('#panel_upi').removeClass('d-none');
                } else if (mode.indexOf('Card') !== -1) {
                    $('#panel_card').removeClass('d-none');
                } else if (mode.indexOf('Netbanking') !== -1) {
                    $('#panel_netbanking').removeClass('d-none');
                } else if (mode.indexOf('Bank Transfer') !== -1) {
                    $('#panel_bank_transfer').removeClass('d-none');
                }

                updatePaymentState();
            });

            // 1-Click Copy UPI ID
            $('#btnCopyUpi').on('click', function() {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(upiVpa).then(function() {
                        $('#btnCopyUpi').html('<i class="fas fa-check text-success me-1"></i> Copied!');
                        setTimeout(function() {
                            $('#btnCopyUpi').html('<i class="fas fa-copy me-1"></i> Copy UPI ID');
                        }, 2000);
                    });
                }
            });

            /* =========================================================================
             * READY PAYMENT GATEWAY DISPATCHER BLOCK
             * When live payment gateway credentials (Razorpay, etc.) are activated,
             * this block automatically engages for online payments (Card/Netbanking/UPI).
             * ========================================================================= */
            var paymentHandledOnline = false;
            $('#memberApplyForm').on('submit', function(e) {
                if (paymentHandledOnline) {
                    return true;
                }

                var amt = parseFloat(donationAmountInput.val()) || 0;
                var mode = selectedPaymentMode.val();
                var isOnlineMode = (mode.indexOf('Card') !== -1 || mode.indexOf('Netbanking') !== -1 || mode === 'Online Gateway');

                // If an online payment mode is selected with an amount and live gateway is present:
                if (amt > 0 && isOnlineMode && razorpayKeyId && razorpayKeyId !== '' && razorpayKeyId !== 'rzp_test_xxxxxxxx') {
                    e.preventDefault();
                    var formEl = this;

                    try {
                        var rzpOptions = {
                            key: razorpayKeyId,
                            amount: Math.round(amt * 100),
                            currency: "INR",
                            name: "Shaheed Foundation",
                            description: "Membership Contribution (" + mode + ")",
                            image: "<?php echo html_escape(web_asset('img/logo1.png')); ?>",
                            prefill: {
                                name: $('#name').val(),
                                email: $('#email').val(),
                                contact: $('#mobile').val()
                            },
                            theme: {
                                color: "#1e3a8a"
                            },
                            handler: function(response) {
                                paymentHandledOnline = true;
                                $('<input>').attr({type: 'hidden', name: 'razorpay_payment_id', value: response.razorpay_payment_id}).appendTo(formEl);
                                if (response.razorpay_order_id) {
                                    $('<input>').attr({type: 'hidden', name: 'razorpay_order_id', value: response.razorpay_order_id}).appendTo(formEl);
                                }
                                formEl.submit();
                            }
                        };
                        var rzp = new Razorpay(rzpOptions);
                        rzp.open();
                        return false;
                    } catch(err) {
                        console.warn("Payment gateway notice: ", err);
                        // Fallback: Continue normal submission with pending status
                    }
                }
            });
        })();
    </script>
</body>
</html>
