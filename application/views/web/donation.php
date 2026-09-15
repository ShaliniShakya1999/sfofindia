<!DOCTYPE html>
<html lang="en">

<?php 
include 'head.php';
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
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <?php include 'topbar.php'; ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php include 'navbar.php'; ?>
    <!-- Navbar End -->



    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Donation</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
               
                    <li class="breadcrumb-item active" aria-current="page">Donation</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_donation_html')): ?>

  <!-- Donation Start -->
     <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="section-title bg-white text-center text-primary px-3">Donation</p>
                <h1 class="display-6 mb-3">Your Contribution Brings Hope to Martyrs’ Families</h1>
                <p class="text-muted">
                    Every donation helps us support the families of our brave martyrs with dignity, care, and long-term security.
                </p>
            </div>

            <?php 
            $campaign_list = !empty($campaigns) ? $campaigns : array(
                array(
                    'id' => 2,
                    'title' => "Support for Martyrs' Families",
                    'description' => "Your donation provides monthly ration kits, household essentials, and financial assistance to the families of our brave martyrs, ensuring they are never left alone.",
                    'goal_amount' => 1000000,
                    'raised_amount' => 0,
                    'raised_display' => '0',
                    'image' => 'img/army2.jpg',
                ),
                array(
                    'id' => 3,
                    'title' => "Medical & Health Assistance",
                    'description' => "We provide medical treatment, emergency care, medicines, and hospital support to martyrs' families who need immediate and long-term healthcare assistance.",
                    'goal_amount' => 600000,
                    'raised_amount' => 0,
                    'raised_display' => '0',
                    'image' => 'img/sf/15.jpeg',
                ),
                array(
                    'id' => 1,
                    'title' => "Education for Martyrs' Children",
                    'description' => "Your support helps provide school fees, books, uniforms, and quality education to the children of martyrs, helping them build a strong and dignified future.",
                    'goal_amount' => 500000,
                    'raised_amount' => 0,
                    'raised_display' => '0',
                    'image' => 'img/education-child.webp',
                ),
            );
            ?>
            <div class="row g-4 mt-4">
                <?php foreach ($campaign_list as $idx => $camp): 
                    $c_id = (int)($camp['id'] ?? 0);
                    $c_title = (string)($camp['title'] ?? 'Campaign');
                    $c_desc = (string)($camp['description'] ?? '');
                    if (mb_strlen($c_desc) > 150) {
                        $c_desc = mb_substr($c_desc, 0, 147) . '...';
                    }
                    $c_goal = (float)($camp['goal_amount'] ?? 0);
                    $c_raised = (float)($camp['raised_amount'] ?? 0);
                    if ($c_raised <= 0 && !empty($camp['raised_display']) && is_numeric($camp['raised_display'])) {
                        $c_raised = (float)$camp['raised_display'];
                    }
                    $c_percent = ($c_goal > 0) ? min(100, round(($c_raised / $c_goal) * 100)) : 0;
                    
                    $c_img_raw = trim((string)($camp['image'] ?? ''));
                    if ($c_img_raw !== '') {
                        if (preg_match('#^https?://#i', $c_img_raw)) {
                            $c_img = $c_img_raw;
                        } elseif (strpos($c_img_raw, 'img/') === 0) {
                            $c_img = web_asset($c_img_raw);
                        } elseif (file_exists(FCPATH . $c_img_raw)) {
                            $c_img = base_url($c_img_raw);
                        } else {
                            $c_img = web_asset('img/army2.jpg');
                        }
                    } else {
                        $c_img = web_asset('img/army2.jpg');
                    }

                    $c_tag = 'Family Support';
                    $t_lower = strtolower($c_title);
                    if (strpos($t_lower, 'education') !== false || strpos($t_lower, 'child') !== false) {
                        $c_tag = 'Education';
                    } elseif (strpos($t_lower, 'medic') !== false || strpos($t_lower, 'health') !== false) {
                        $c_tag = 'Medical Care';
                    } elseif (strpos($t_lower, 'relief') !== false || strpos($t_lower, 'emergency') !== false) {
                        $c_tag = 'Emergency Relief';
                    }
                    
                    $delay = number_format(0.1 + ($idx * 0.1), 2);
                ?>
                <!-- Dynamic Campaign Box <?php echo $c_id; ?> -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="<?php echo $delay; ?>s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">₹<?php echo number_format($c_raised); ?></span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="<?php echo $c_percent; ?>"
                                    aria-valuemin="0" aria-valuemax="100" style="height: <?php echo max(5, $c_percent); ?>%;">
                                    <span class="fs-4"><?php echo $c_percent; ?>%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>₹<?php echo number_format($c_goal); ?></span>
                        </div>

                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="<?php echo html_escape($c_img); ?>" alt="<?php echo html_escape($c_title); ?>">
                                <a href="#donate-section" onclick="selectCampaign(<?php echo $c_id; ?>)" class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">
                                    <?php echo html_escape($c_tag); ?>
                                </a>
                            </div>
                            <a href="#donate-section" onclick="selectCampaign(<?php echo $c_id; ?>)" class="h3 d-inline-block"><?php echo html_escape($c_title); ?></a>
                            <p>
                                <?php echo html_escape($c_desc); ?>
                            </p>
                            <a href="#donate-section" onclick="selectCampaign(<?php echo $c_id; ?>)" class="btn btn-primary w-100 py-3">
                                <i class="fa fa-heart me-2"></i>Donate Now
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Emotional Line -->
            <div class="text-center mt-5">
                <h4 class="text-primary">
                    “A nation that honors its martyrs must also stand with their families.”
                </h4>
            </div>
        </div>
    </div>

    <!-- Donation End -->
    <style>
      .donation-item {
          align-items: stretch;
          min-height: 402px;
      }
      .donation-item .donation-progress {
          flex: 0 0 64px;
          width: 64px;
          min-height: 354px;
      }
      .donation-item .donation-detail {
          min-width: 0;
          display: flex;
          flex: 1 1 auto;
          flex-direction: column;
      }
      .donation-item .donation-detail .position-relative {
          flex: 0 0 100px;
          margin-bottom: 1rem !important;
      }
      .donation-item .donation-detail .position-relative img {
          display: block;
          height: 100px;
          object-fit: cover;
      }
      .donation-item .donation-detail > p {
          flex: 1 1 auto;
      }
      .donation-item .donation-detail > .h3 {
          line-height: 1.2;
          min-height: 58px;
          margin-bottom: .6rem;
      }
      @media (max-width: 767.98px) {
          .donation-item {
              min-height: 0;
          }
          .donation-item .donation-progress {
              flex-basis: 56px;
              width: 56px;
          }
      }
    </style>


  <!-- Donate Start -->
      <div id="donate-section" class="container-fluid donate py-5">
        <div class="container">
            <div class="row g-4 align-items-stretch">

                <!-- Left Content Section -->
                <div class="col-lg-6 donate-text bg-light py-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="p-4 p-lg-5 h-100 d-flex flex-column">
                        <h1 class="display-6 mb-4">
                            Stand with the Families of Our Fallen Heroes
                        </h1>
                        <p class="fs-5 mb-3">
                            When a soldier lays down their life for the nation, their family carries the pain forever.
                            It is our collective responsibility to ensure they never feel alone.
                        </p>
                        <p class="fs-5 mb-4">
                            Your donation helps provide education for children, medical care for families,
                            monthly essentials, and long-term financial support to the families of our brave martyrs.
                        </p>
                        <!-- Donation Disclaimer (left side - balances layout) -->
                      
                    </div>
                </div>

                <!-- Right Donation Form -->
                <div class="col-lg-6 donate-form bg-primary py-5 text-center wow fadeIn" data-wow-delay="0.5s">
                    <div class="h-100 p-4 p-lg-5 d-flex flex-column">
                        <h3 class="text-white mb-4">
                            Make a Meaningful Contribution
                        </h3>

                        <form id="donation-form">
                            <div class="row g-3 text-start">

                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select" id="campaign_id" name="campaign_id" aria-label="Select Campaign">
                                            <option value="">General Donation (Where Needed Most)</option>
                                            <?php foreach ($campaign_list as $c_opt): ?>
                                                <option value="<?php echo (int)$c_opt['id']; ?>"><?php echo html_escape($c_opt['title']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="campaign_id">Choose Cause / Campaign</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name" required>
                                        <label for="name">Full Name</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Your Email" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="mobile" placeholder="Mobile" maxlength="15">
                                        <label for="mobile">Mobile (optional)</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <p class="text-white mb-2">Choose Donation Amount</p>
                                    <div class="btn-group flex-wrap" role="group">
                                        <input type="radio" class="btn-check" name="donation" id="donate1" value="500" checked>
                                        <label class="btn btn-light m-1" for="donate1">₹500</label>
                                        <input type="radio" class="btn-check" name="donation" id="donate2" value="1000">
                                        <label class="btn btn-light m-1" for="donate2">₹1,000</label>
                                        <input type="radio" class="btn-check" name="donation" id="donate3" value="2000">
                                        <label class="btn btn-light m-1" for="donate3">₹2,000</label>
                                        <input type="radio" class="btn-check" name="donation" id="donate4" value="5000">
                                        <label class="btn btn-light m-1" for="donate4">₹5,000</label>
                                        <input type="radio" class="btn-check" name="donation" id="donate5" value="custom">
                                        <label class="btn btn-light m-1" for="donate5">Custom Amount</label>
                                    </div>
                                    <div id="custom-amount-wrap" class="mt-2 d-none">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">₹</span>
                                            <input type="number" class="form-control" id="custom-amount" placeholder="Enter amount" min="1" step="1">
                                        </div>
                                    </div>
                                </div>

                                <!-- Donation Consent & Compliance Confirmation -->
                                <div class="col-12 text-start">
                                    <h6 class="text-white mb-2">Donation Consent & Compliance Confirmation</h6>
                                    <p class="text-white-50 small mb-2">☑ I confirm and agree that:</p>
                                    <ul class="text-white-50 small ps-3 mb-2 lh-lg" style="list-style:none;">
                                        <li class="mb-1">• I am making this donation voluntarily to SHAHEED FOUNDATION, a Section 8 company registered under the Companies Act, 2013, to support its charitable objectives.</li>
                                        <li class="mb-1">• I understand that online payments are processed through secure third-party payment gateways and that SHAHEED FOUNDATION does not store any card, UPI, or banking information.</li>
                                        <li class="mb-1">• I acknowledge that donations are generally non-refundable, except in cases of duplicate transactions or technical errors, as per the Donation Refund & Cancellation Policy.</li>
                                        <li class="mb-1">• I understand that donations are eligible for tax benefits under Section 80G of the Income Tax Act, 1961, subject to applicable laws, conditions, and validity of approval.</li>
                                        <li class="mb-1">• I confirm that the funds donated are from lawful sources and that this donation complies with all applicable laws of India.</li>
                                    </ul>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="consent-checkbox">
                                        <label class="form-check-label text-white small" for="consent-checkbox">
                                            I agree to the Terms & Conditions, Privacy Policy, and Refund Policy of SHAHEED FOUNDATION. I agree that all matters related to this donation shall be governed by the laws of India, and courts of Gurgaon, Haryana shall have exclusive jurisdiction.
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12" id="pay-button-wrap">
                                    <button class="btn btn-secondary py-3 w-100" type="button" id="btn-donate-pay">
                                        <i class="fa fa-credit-card me-2"></i>Pay Securely (Card / UPI / Net Banking)
                                    </button>
                                </div>

                                <div class="col-12 d-none" id="donation-success-msg">
                                    <div class="alert alert-success mb-0">
                                        <i class="fa fa-check-circle me-2"></i><strong>Thank you!</strong> Your donation was successful. We will use it to support martyrs' families.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <p class="text-white small mt-3">
                                        100% transparency • Secure payment • Direct support to martyrs’ families
                                    </p>
                                </div>

                            </div>
                        </form>

                        <!-- Bank Transfer Details -->
                        <div id="bank-details" class="mt-5 p-4 rounded shadow-sm" style="background:#fff;">
                            <h5 class="mb-3 text-dark"><i class="fa fa-university me-2 text-primary"></i>Or pay via Bank Transfer / UPI</h5>
                            <p class="small text-muted mb-2">Prefer direct transfer? Use our bank details below:</p>
                            <ol class="small text-muted mb-3 ps-3">
                                <li>Transfer the amount to our bank account using UPI, NEFT, or IMPS</li>
                                <li>Use the details below in your bank app or UPI app</li>
                            </ol>
                            <button type="button" class="btn btn-primary btn-sm mb-3" onclick="copyAllBankDetails()"><i class="fa fa-copy me-1"></i> Copy All Details</button>
                            <?php 
                            $bank_account_name = cms_val($cms, 'bank_account_name', 'SHAHEED FOUNDATION');
                            $bank_name = cms_val($cms, 'bank_name', 'AXIS BANK');
                            $bank_account_no = cms_val($cms, 'bank_account_no', '925010034361992');
                            $bank_ifsc = cms_val($cms, 'bank_ifsc', 'UTIB0001970');
                            $bank_branch = cms_val($cms, 'bank_branch', 'Sector 29, Gurgaon, Haryana 122001');
                            $bank_upi_id = cms_val($cms, 'bank_upi_id', 'shaheedfoundation@axisbank');
                            ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0 bg-light rounded">
                                    <tbody class="text-dark">
                                        <tr>
                                            <td class="text-muted fw-medium" style="width:140px;">Account Name</td>
                                            <td><strong class="text-dark"><?php echo html_escape($bank_account_name); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-medium">Bank</td>
                                            <td><strong class="text-dark"><?php echo html_escape($bank_name); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-medium">Account No.</td>
                                            <td class="align-middle">
                                                <strong class="text-dark" id="copy-account"><?php echo html_escape($bank_account_no); ?></strong>
                                                <button type="button" class="btn btn-outline-primary btn-sm ms-2" onclick="copyToClipboard(<?php echo json_encode($bank_account_no); ?>, this)" title="Copy Account No."><i class="fa fa-copy"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-medium">IFSC Code</td>
                                            <td class="align-middle">
                                                <strong class="text-dark" id="copy-ifsc"><?php echo html_escape($bank_ifsc); ?></strong>
                                                <button type="button" class="btn btn-outline-primary btn-sm ms-2" onclick="copyToClipboard(<?php echo json_encode($bank_ifsc); ?>, this)" title="Copy IFSC"><i class="fa fa-copy"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-medium">Branch</td>
                                            <td><strong class="text-dark"><?php echo html_escape($bank_branch); ?></strong></td>
                                        </tr>
                                        <?php if ($bank_upi_id !== ''): ?>
                                        <tr>
                                            <td class="text-muted fw-medium">UPI ID</td>
                                            <td class="align-middle">
                                                <strong class="text-dark" id="copy-upi"><?php echo html_escape($bank_upi_id); ?></strong>
                                                <button type="button" class="btn btn-outline-primary btn-sm ms-2" onclick="copyToClipboard(<?php echo json_encode($bank_upi_id); ?>, this)" title="Copy UPI ID"><i class="fa fa-copy"></i></button>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Donate End -->

    <script>
        var razorpayKeyId = <?php echo $razorpay_enabled ? json_encode(RAZORPAY_KEY_ID) : '""'; ?>;
        var createOrderUrl = <?php echo json_encode(site_url('donations/create_order')); ?>;
        var verifyPaymentUrl = <?php echo json_encode(site_url('donations/verify_payment')); ?>;
        document.getElementById('btn-donate-pay').addEventListener('click', function() {
            var name = document.getElementById('name').value.trim();
            var email = document.getElementById('email').value.trim();
            var mobile = document.getElementById('mobile') ? document.getElementById('mobile').value.trim() : '';
            var campaignId = document.getElementById('campaign_id') ? document.getElementById('campaign_id').value : '';
            var amount = 0;
            if (document.getElementById('donate5').checked) {
                amount = parseFloat(document.getElementById('custom-amount').value) || 0;
            } else {
                amount = parseFloat(document.querySelector('input[name="donation"]:checked').value) || 0;
            }
            if (!name) { alert('Please enter your name.'); return; }
            if (!email) { alert('Please enter your email.'); return; }
            if (amount < 1) { alert('Please choose or enter a valid amount (minimum ₹1).'); return; }
            if (!document.getElementById('consent-checkbox').checked) {
                alert('Please read and accept the Donation Disclaimer & Compliance Notice and check the consent box before proceeding.');
                document.getElementById('consent-checkbox').closest('.col-12').scrollIntoView({ behavior: 'smooth' });
                return;
            }
            if (!razorpayKeyId) {
                document.getElementById('bank-details').scrollIntoView({ behavior: 'smooth' });
                alert('Online payment abhi set nahi hai. Neeche Bank Transfer se donate kar sakte ho.\n\nOnline payment enable karne ke liye: razorpay_config.php file mein Razorpay Key ID aur Key Secret dalo (Razorpay.com se account bana kar keys copy karo).');
                return;
            }
            var btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            fetch(createOrderUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    amount: amount,
                    name: name,
                    email: email,
                    mobile: mobile,
                    campaign_id: campaignId
                })
            }).then(function(r) { return r.json(); }).then(function(res) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-credit-card me-2"></i>Pay Securely (Card / UPI / Net Banking)';
                if (!res.success) {
                    alert(res.error || 'Could not start payment. Use Bank Transfer below.');
                    document.getElementById('bank-details').scrollIntoView({ behavior: 'smooth' });
                    return;
                }
                var options = {
                    key: razorpayKeyId,
                    amount: res.amount,
                    currency: res.currency,
                    order_id: res.orderId,
                    name: 'Shaheed Foundation',
                    description: 'Donation for Martyrs\' Families',
                    prefill: { name: name, email: email, contact: mobile },
                    theme: { color: '#0d6efd' },
                    modal: { ondismiss: function() {} },
                    handler: function (response) {
                        fetch(verifyPaymentUrl, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_signature: response.razorpay_signature,
                                name: name,
                                email: email,
                                mobile: mobile,
                                amount: amount,
                                campaign_id: campaignId
                            })
                        }).then(function(r) { return r.json(); }).then(function(v) {
                            if (!v.ok) {
                                alert(v.error || 'Verification failed. Contact support with payment ID.');
                                return;
                            }
                            document.getElementById('pay-button-wrap').classList.add('d-none');
                            document.getElementById('donation-success-msg').classList.remove('d-none');
                            if (v.receipt_url) {
                                var p = document.createElement('p');
                                p.className = 'small mb-0 mt-2';
                                p.innerHTML = '<a href="' + v.receipt_url + '" target="_blank" rel="noopener">Download receipt (PDF)</a>';
                                document.getElementById('donation-success-msg').appendChild(p);
                            }
                            document.getElementById('donation-success-msg').scrollIntoView({ behavior: 'smooth' });
                        }).catch(function() {
                            alert('Could not verify payment on server. Please save your payment ID from Razorpay email.');
                        });
                    }
                };
                var rzp = new Razorpay(options);
                rzp.on('payment.failed', function(response) {
                    alert('Payment failed. You can try again or use Bank Transfer below.');
                });
                rzp.open();
            }).catch(function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-credit-card me-2"></i>Pay Securely (Card / UPI / Net Banking)';
                alert('Connection error. Please use Bank Transfer below.');
                document.getElementById('bank-details').scrollIntoView({ behavior: 'smooth' });
            });
        });
        function copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(function() {
                var icon = btn.querySelector('i');
                icon.className = 'fa fa-check';
                setTimeout(function() { icon.className = 'fa fa-copy'; }, 1500);
            });
        }
        function copyAllBankDetails() {
            var text = <?php echo json_encode($bank_account_name . "\n" . $bank_name . "\nAccount No: " . $bank_account_no . "\nIFSC: " . $bank_ifsc . "\nBranch: " . $bank_branch . ($bank_upi_id ? "\nUPI ID: " . $bank_upi_id : '')); ?>;
            navigator.clipboard.writeText(text).then(function() {
                var btn = document.querySelector('[onclick="copyAllBankDetails()"]');
                if (btn) { var html = btn.innerHTML; btn.innerHTML = '<i class="fa fa-check me-1"></i> Copied!'; setTimeout(function() { btn.innerHTML = html; }, 2000); }
            });
        }
        document.querySelectorAll('input[name="donation"]').forEach(function(r) {
            r.addEventListener('change', function() {
                var wrap = document.getElementById('custom-amount-wrap');
                wrap.classList.toggle('d-none', this.id !== 'donate5');
            });
        });

        function selectCampaign(id) {
            var sel = document.getElementById('campaign_id');
            if (sel && id) {
                sel.value = id;
            }
        }
        (function() {
            var params = new URLSearchParams(window.location.search);
            var cId = params.get('campaign_id');
            if (cId) {
                selectCampaign(cId);
            }
        })();
    </script>
<?php endif; ?>
  <?php include 'footer.php'; ?>
</body>

</html>