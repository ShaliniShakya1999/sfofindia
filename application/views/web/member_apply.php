<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>

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
            border-top: 5px solid #d40000 !important;
        }
        
        .form-section-head {
            background: #f1f5f9;
            padding: 12px 20px;
            margin: 25px -30px 20px -30px;
            border-left: 5px solid var(--primary-blue);
            display: flex;
            align-items: center;
            font-weight: 700;
            color: var(--primary-dark);
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-section-head i { margin-right: 10px; font-size: 1.1rem; }
        .form-section-head.charity-head { border-left-color: var(--charity-pink); color: var(--charity-pink); }

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
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
            outline: none;
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
            max-height: 140px;
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
        .member-upload-preview span { font-size: 0.8rem; color: #64748b; text-align: center; padding: 10px; }

        .btn-submit-premium {
            background: #d40000;
            color: #fff;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 700;
            border: 0;
            box-shadow: 0 8px 16px rgba(212, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        .btn-submit-premium:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(212, 0, 0, 0.3); color: #fff; }

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

                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('join-us/submit'); ?>" class="member-apply-card p-4 p-lg-5">
                    
                    <!-- Section 1: Manual identity details (external Aadhaar API is disabled) -->
                    <div class="form-section-head">
                        <i class="fas fa-shield-alt"></i> 1. Identity Verification
                    </div>
                    
                    <div class="verification-widget" id="aadharWidget">
                        <div class="row g-3 align-items-end" id="aadhar_input_group">
                            <div class="col-12">
                                <label class="form-label">Aadhaar Number *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-address-card text-muted"></i></span>
                                    <input type="text" name="aadhar_no" id="aadhar_no" class="form-control border-start-0" placeholder="0000 0000 0000" maxlength="12" required>
                                </div>
                                <small class="text-muted">Aadhaar will be checked manually from the uploaded documents.</small>
                            </div>
                            <!-- Aadhaar OTP API disabled
                            <div class="col-md-5">
                                <button type="button" class="btn btn-primary w-100 py-2 fw-bold" id="btnSendOtp">
                                    <i class="fas fa-paper-plane me-1"></i> Send OTP
                                </button>
                            </div>
                            -->
                        </div>

                        <!-- Aadhaar OTP API disabled
                        <div id="otpSection" class="mt-4 pt-3 border-top" style="display:none;">
                            <div class="row g-3 align-items-end justify-content-center">
                                <div class="col-md-8 text-center">
                                    <div class="alert alert-info py-2 small mb-3">
                                        <i class="fas fa-info-circle me-1"></i> OTP has been sent to your Aadhaar-linked mobile.
                                    </div>
                                    <label class="form-label text-primary fw-bold">Enter 6-digit OTP</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="aadhar_otp" class="form-control text-center fs-4 fw-bold border-primary" placeholder="••••••" maxlength="6">
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
                        -->

                        <!-- Aadhaar OTP API disabled
                        <div id="verifiedBadge" class="mt-3 text-center" style="display:none;">
                            <div class="d-inline-flex align-items-center bg-success bg-opacity-10 text-success rounded-pill px-4 py-2 border border-success">
                                <i class="fas fa-check-circle me-2 fs-5"></i> <strong>Aadhaar Authenticated</strong>
                            </div>
                        </div>
                        -->
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="aadhar_verified" id="aadhar_verified" value="0">
                    <!-- Aadhaar OTP API disabled
                    <input type="hidden" name="aadhar_data" id="aadhar_data" value="">
                    <input type="hidden" id="aadhar_client_id" value="">
                    -->

                    <!-- Aadhaar OTP API disabled
                    <div id="aadharVerifiedData" class="alert alert-light border shadow-sm mb-4" style="display:none;">
                         <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:45px; height:45px;">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 text-primary small fw-bold">VERIFIED PROFILE</h6>
                                <p class="mb-0 text-muted small">Name: <strong id="verifiedNameDisplay">...</strong> | DOB: <strong id="verifiedDobDisplay">...</strong></p>
                            </div>
                         </div>
                    </div>
                    -->

                    <!-- Section 2: Personal Details -->
                    <div class="form-section-head">
                        <i class="fas fa-user-circle"></i> 2. Personal Information
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="As per documents" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender *</label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date of Birth *</label>
                            <input type="date" name="dob" id="dob" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Relation</label>
                            <select name="relation_type" class="form-select">
                                <option value="">Select</option>
                                <option value="S/O">Son of</option>
                                <option value="D/O">Daughter of</option>
                                <option value="W/O">Wife of</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Relation Name</label>
                            <input type="text" name="relation_name" class="form-control" placeholder="Father/Husband Name">
                        </div>
                    </div>

                    <!-- Section 3: Contact Details -->
                    <div class="form-section-head">
                        <i class="fas fa-phone-alt"></i> 3. Communication & Location
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number *</label>
                            <input type="text" name="mobile" class="form-control" placeholder="+91" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="example@mail.com">
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

                    <!-- Section 4: Documents -->
                    <div class="form-section-head">
                        <i class="fas fa-file-upload"></i> 4. Professional Documents
                    </div>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label">Profile Image *</label>
                            <input type="file" name="photo" class="form-control member-file-input" accept="image/*" data-preview-id="photoPreview" required>
                            <div class="member-upload-preview mt-2" id="photoPreview"><span><i class="fas fa-camera d-block mb-1"></i>Passport Photo</span></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Aadhaar Front *</label>
                            <input type="file" name="aadhar_front" class="form-control member-file-input" accept="image/*" data-preview-id="frontPreview" required>
                            <div class="member-upload-preview mt-2" id="frontPreview"><span>Front Side</span></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Aadhaar Back *</label>
                            <input type="file" name="aadhar_back" class="form-control member-file-input" accept="image/*" data-preview-id="backPreview" required>
                            <div class="member-upload-preview mt-2" id="backPreview"><span>Back Side</span></div>
                        </div>
                    </div>

                    <!-- Section 5: Donation & Charity Support -->
                    <div class="form-section-head charity-head">
                        <i class="fas fa-heart"></i> 5. Donation & Charity Support
                    </div>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="bank-details-card">
                                <h5 class="text-white mb-3"><i class="fas fa-university me-2"></i> Bank Transfer Details</h5>
                                <div class="bank-row">
                                    <span class="bank-label">Account Name</span>
                                    <span class="bank-value">SHAHEED FOUNDATION</span>
                                </div>
                                <div class="bank-row">
                                    <span class="bank-label">Bank Name</span>
                                    <span class="bank-value">AXIS BANK</span>
                                </div>
                                <div class="bank-row">
                                    <span class="bank-label">Account Number</span>
                                    <span class="bank-value">925010034361992</span>
                                </div>
                                <div class="bank-row">
                                    <span class="bank-label">IFSC Code</span>
                                    <span class="bank-value">UTIB0001970</span>
                                </div>
                                <div class="bank-row">
                                    <span class="bank-label">Branch</span>
                                    <span class="bank-value">Sector 29, Gurgaon</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Optional Donation Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="donation_amount" class="form-control" placeholder="Contribution Amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Mode</label>
                            <input type="text" name="payment_mode" class="form-control" placeholder="UPI / PhonePe / Cash / Bank">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Upload Payment Receipt</label>
                            <input type="file" name="payment_receipt" class="form-control member-file-input" accept="image/*,application/pdf" data-preview-id="payPreview">
                            <div class="member-upload-preview mt-2" id="payPreview" style="height: 100px;"><span>Click to upload transaction receipt</span></div>
                        </div>
                    </div>

                    <div class="col-12 text-center pt-5">
                        <button type="submit" class="btn btn-submit-premium">Submit Registration</button>
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
                        preview.html('<img src="' + e.target.result + '" style="max-height:100%">');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            /* Aadhaar OTP API disabled
            // --- Aadhaar OTP Logic ---
            var btnSendOtp = $('#btnSendOtp');
            var btnVerifyOtp = $('#btnVerifyOtp');
            var btnChangeAadhar = $('#btnChangeAadhar');
            var aadharNoInput = $('#aadhar_no');
            var otpSection = $('#otpSection');
            var aadharInputGroup = $('#aadhar_input_group');
            var verifiedBadge = $('#verifiedBadge');
            var aadharWidget = $('#aadharWidget');

            function resetBtn(btn, text) {
                btn.prop('disabled', false).html(text);
            }

            btnSendOtp.on('click', function() {
                var aadharNo = aadharNoInput.val().replace(/\s/g, '');
                if (aadharNo.length !== 12) { alert('Please enter a 12-digit Aadhaar number.'); return; }

                btnSendOtp.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
                $.ajax({
                    url: '<?php echo site_url("join-us/send_aadhaar_otp"); ?>',
                    type: 'POST',
                    data: { id_number: aadharNo },
                    dataType: 'json'
                }).done(function(res) {
                    resetBtn(btnSendOtp, '<i class="fas fa-paper-plane me-1"></i> Send OTP');
                    if (res.statuscode === 200 && res.data && res.data.otp_sent) {
                        $('#aadhar_client_id').val(res.data.client_id);
                        aadharInputGroup.fadeOut(300, function() {
                            otpSection.fadeIn(300);
                            $('#aadhar_otp').focus();
                        });
                    } else { alert(res.message || 'Error sending OTP'); }
                }).fail(function() {
                    resetBtn(btnSendOtp, '<i class="fas fa-paper-plane me-1"></i> Send OTP');
                    alert('Server error. Please try again.');
                });
            });

            btnChangeAadhar.on('click', function() {
                otpSection.fadeOut(300, function() {
                    aadharInputGroup.fadeIn(300);
                });
            });

            btnVerifyOtp.on('click', function() {
                var otp = $('#aadhar_otp').val();
                var clientId = $('#aadhar_client_id').val();
                if (otp.length < 4) { alert('Enter valid OTP'); return; }

                $('#verifyingMsg').show();
                btnVerifyOtp.prop('disabled', true);

                $.ajax({
                    url: '<?php echo site_url("join-us/verify_aadhaar_otp"); ?>',
                    type: 'POST',
                    data: { client_id: clientId, otp: otp },
                    dataType: 'json'
                }).done(function(res) {
                    $('#verifyingMsg').hide();
                    btnVerifyOtp.prop('disabled', false);
                    if (res.statuscode === 200 && res.status === true) {
                        var d = res.data;
                        $('#aadhar_verified').val(1);
                        $('#aadhar_data').val(JSON.stringify(d));
                        
                        // Auto-fill and Animate
                        if (d.full_name) $('#name').val(d.full_name).addClass('field-updated');
                        if (d.dob) $('#dob').val(d.dob).addClass('field-updated');
                        if (d.gender) $('#gender').val(d.gender === 'M' ? 'Male' : 'Female').addClass('field-updated');
                        if (d.zip) $('#pin_code').val(d.zip).addClass('field-updated');

                        // Complex Address Parsing
                        if (d.address) {
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
                            
                            $('#address').val(addrParts.join(', ')).addClass('field-updated');
                            if (a.state) $('#state').val(a.state).addClass('field-updated');
                            if (a.dist) $('#district').val(a.dist).addClass('field-updated');
                        }

                        otpSection.hide();
                        verifiedBadge.fadeIn();
                        aadharWidget.addClass('verified');
                        $('#verifiedNameDisplay').text(d.full_name);
                        $('#verifiedDobDisplay').text(d.dob);
                        $('#aadharVerifiedData').fadeIn();
                        
                        setTimeout(function() { $('.field-updated').removeClass('field-updated'); }, 2000);
                    } else { alert(res.message || 'OTP Verification Failed'); }
                }).fail(function() {
                    $('#verifyingMsg').hide();
                    btnVerifyOtp.prop('disabled', false);
                    alert('Server error during verification. Please try again.');
                });
            });
            */
        })();
    </script>
</body>
</html>
