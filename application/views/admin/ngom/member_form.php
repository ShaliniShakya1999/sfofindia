<?php defined('BASEPATH') OR exit('No direct script access allowed');
$m = isset($member) ? $member : array();
$is_edit = !empty($is_edit);
?>
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 me-3">
            <i class="material-symbols-rounded opacity-10">person_add</i>
        </div>
        <div>
            <h4 class="mb-0 font-weight-bolder"><?php echo $is_edit ? 'Member Verification Hub' : 'Register New Member'; ?></h4>
            <p class="text-sm mb-0">Verify identities, documents, and membership status.</p>
        </div>
    </div>

    <?php $ci =& get_instance(); ?>
    <?php if ($ci->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text text-white"><strong>Success!</strong> <?php echo $ci->session->flashdata('success'); ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if ($ci->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-text text-white"><strong>Error!</strong> <?php echo $ci->session->flashdata('error'); ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('members/save'); ?>" id="memberMainForm">
        <?php if ($is_edit): ?>
            <input type="hidden" name="id" value="<?php echo (int) ($m['id'] ?? 0); ?>">
        <?php endif; ?>

        <div class="row">
            <!-- Left Column: Personal & Address -->
            <div class="col-lg-8">
                <!-- Section: Personal Information -->
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0 text-primary font-weight-bold"><i class="material-symbols-rounded align-middle me-2">badge</i>Personal Information</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label text-xs font-weight-bold">Full Name *</label>
                                <input type="text" name="name" class="form-control px-3 border" required value="<?php echo html_escape($m['name'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Gender</label>
                                <select name="gender" class="form-select px-3 border">
                                    <option value="">Select Gender</option>
                                    <?php foreach (array('Male', 'Female', 'Other') as $g): ?>
                                        <option value="<?php echo html_escape($g); ?>" <?php echo (($m['gender'] ?? '') === $g) ? 'selected' : ''; ?>><?php echo html_escape($g); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Date of Birth</label>
                                <input type="date" name="dob" class="form-control px-3 border" value="<?php echo html_escape($m['dob'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Relation Type</label>
                                <input type="text" name="relation_type" class="form-control px-3 border" placeholder="S/O, D/O, W/O" value="<?php echo html_escape($m['relation_type'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Relation Name</label>
                                <input type="text" name="relation_name" class="form-control px-3 border" value="<?php echo html_escape($m['relation_name'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Profession</label>
                                <input type="text" name="profession" class="form-control px-3 border" value="<?php echo html_escape($m['profession'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Blood Group</label>
                                <input type="text" name="blood_group" class="form-control px-3 border" value="<?php echo html_escape($m['blood_group'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Contact & Identity Details -->
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0 text-primary font-weight-bold"><i class="material-symbols-rounded align-middle me-2">contact_page</i>Contact & Identity</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control px-3 border" value="<?php echo html_escape($m['mobile'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Email Address <span class="text-muted font-weight-normal">(Must be unique)</span></label>
                                <input type="email" name="email" id="admin_member_email" class="form-control px-3 border" value="<?php echo html_escape($m['email'] ?? ''); ?>">
                                <div id="admin_email_feedback" class="text-xxs mt-1" style="display:none;"></div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label text-xs font-weight-bold">Aadhar Card Number</label>
                                <input type="text" name="aadhar_no" class="form-control px-3 border" value="<?php echo html_escape($m['aadhar_no'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-xs font-weight-bold">Pin Code</label>
                                <input type="text" name="pin_code" class="form-control px-3 border" value="<?php echo html_escape($m['pin_code'] ?? ''); ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-xs font-weight-bold">Full Residential Address</label>
                                <textarea name="address" class="form-control px-3 border" rows="3"><?php echo html_escape($m['address'] ?? ''); ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">State</label>
                                <input type="text" name="state" class="form-control px-3 border" value="<?php echo html_escape($m['state'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">District</label>
                                <input type="text" name="district" class="form-control px-3 border" value="<?php echo html_escape($m['district'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Admin & Status -->
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0 text-primary font-weight-bold"><i class="material-symbols-rounded align-middle me-2">settings_account_box</i>Status & Membership</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-xs font-weight-bold">Role Title</label>
                                <input type="text" name="role" class="form-control px-3 border" placeholder="e.g. member, volunteer, manager" value="<?php echo html_escape($m['role'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-xs font-weight-bold">Current Status</label>
                                <select name="status" class="form-select px-3 border">
                                    <?php foreach (array('pending', 'active', 'blocked', 'inactive') as $st): ?>
                                        <option value="<?php echo $st; ?>" <?php echo (($m['status'] ?? 'active') === $st) ? 'selected' : ''; ?>><?php echo ucfirst($st); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-xs font-weight-bold">Payment Mode <span class="badge bg-gradient-info text-xxs ms-1">Admin</span></label>
                                <select name="payment_mode" class="form-select px-3 border">
                                    <option value="">Select Payment Mode</option>
                                    <option value="Cash" <?php echo (strcasecmp($m['payment_mode'] ?? '', 'Cash') === 0) ? 'selected' : ''; ?>>Cash (Admin Only)</option>
                                    <option value="UPI / QR Code" <?php echo (stripos($m['payment_mode'] ?? '', 'UPI') !== false) ? 'selected' : ''; ?>>UPI / QR Code</option>
                                    <option value="Bank Transfer" <?php echo (stripos($m['payment_mode'] ?? '', 'Bank') !== false) ? 'selected' : ''; ?>>Bank Transfer (NEFT/RTGS/IMPS)</option>
                                    <option value="Online Gateway" <?php echo (stripos($m['payment_mode'] ?? '', 'Online') !== false) ? 'selected' : ''; ?>>Online Gateway / Net Banking</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-xs font-weight-bold">Authority Name</label>
                                <input type="text" name="authority" class="form-control px-3 border" value="<?php echo html_escape($m['authority'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-xs font-weight-bold">Validity Start</label>
                                <input type="date" name="validity_start" class="form-control px-3 border" value="<?php echo html_escape($m['validity_start'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-xs font-weight-bold">Validity End</label>
                                <input type="date" name="validity_end" class="form-control px-3 border" value="<?php echo html_escape($m['validity_end'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Previews & Documents -->
            <div class="col-lg-4">
                <!-- Profile Image Card -->
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3 text-center">
                        <h6 class="mb-0 text-primary font-weight-bold">Profile Photo</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="mx-auto border rounded-pill overflow-hidden bg-gray-100 shadow-sm mb-3" style="width:160px;height:160px;">
                            <?php
                            $ph = isset($m['photo']) ? trim((string) $m['photo']) : '';
                            $ph_url = '';
                            if ($ph !== '') {
                                $ph_url = (!empty($m['id'])) ? site_url('members/document/' . (int)$m['id'] . '/photo') : ((preg_match('#^https?://#i', $ph) || $ph[0] === '/') ? $ph : base_url($ph));
                            }
                            ?>
                            <img id="profile_photo_preview" src="<?php echo $ph_url !== '' ? html_escape($ph_url) : 'https://ui-avatars.com/api/?name=User&background=random'; ?>" alt="Profile" class="w-100 h-100" style="object-fit:cover;">
                        </div>
                        <input type="file" name="photo" id="profile_photo_input" class="form-control border mb-2 text-xs" accept="image/*">
                        <p class="text-xs text-muted">Upload high-res profile photo for ID card generation.</p>
                    </div>
                </div>

                <!-- Document Uploads -->
                <div class="card mb-4 bg-gray-100">
                    <div class="card-header pb-0 p-3 bg-transparent">
                        <h6 class="mb-0 text-primary font-weight-bold">Verification Documents</h6>
                    </div>
                    <div class="card-body p-3">
                        <!-- Aadhar Front Side -->
                        <div class="mb-4">
                            <label class="form-label text-xs font-weight-bold d-block">Aadhar Front Side</label>
                            <?php
                            $af = isset($m['aadhar_front']) ? trim((string)$m['aadhar_front']) : '';
                            $af_url = ($af !== '') ? ((!empty($m['id'])) ? site_url('members/document/' . (int)$m['id'] . '/aadhar_front') : base_url($af)) : '';
                            ?>
                            <div class="position-relative border-radius-lg overflow-hidden bg-white mb-2 shadow-sm" style="height:120px;">
                                <?php if ($af_url): ?>
                                    <img src="<?php echo html_escape($af_url); ?>" class="w-100 h-100" style="object-fit:contain;">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted text-xs border border-dashed">No Front Photo</div>
                                <?php endif; ?>
                            </div>
                            <input type="file" name="aadhar_front" class="form-control border text-xs bg-white">
                        </div>

                        <!-- Aadhar Back Side -->
                        <div class="mb-4">
                            <label class="form-label text-xs font-weight-bold d-block">Aadhar Back Side</label>
                            <?php
                            $ab = isset($m['aadhar_back']) ? trim((string)$m['aadhar_back']) : '';
                            $ab_url = ($ab !== '') ? ((!empty($m['id'])) ? site_url('members/document/' . (int)$m['id'] . '/aadhar_back') : base_url($ab)) : '';
                            ?>
                            <div class="position-relative border-radius-lg overflow-hidden bg-white mb-2 shadow-sm" style="height:120px;">
                                <?php if ($ab_url): ?>
                                    <img src="<?php echo html_escape($ab_url); ?>" class="w-100 h-100" style="object-fit:contain;">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted text-xs border border-dashed">No Back Photo</div>
                                <?php endif; ?>
                            </div>
                            <input type="file" name="aadhar_back" class="form-control border text-xs bg-white">
                        </div>

                        <!-- Payment Receipt -->
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold d-block">Fee Payment Receipt</label>
                            <?php
                            $pr = isset($m['payment_receipt']) ? trim((string) $m['payment_receipt']) : '';
                            $pr_url = ($pr !== '') ? ((!empty($m['id'])) ? site_url('members/document/' . (int)$m['id'] . '/payment_receipt') : base_url($pr)) : '';
                            $pr_is_img = (bool) preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $pr);
                            ?>
                            <div class="position-relative border-radius-lg overflow-hidden bg-white mb-2 shadow-sm" style="height:150px;">
                                <?php if ($pr_url && $pr_is_img): ?>
                                    <img src="<?php echo html_escape($pr_url); ?>" class="w-100 h-100" style="object-fit:contain;">
                                <?php elseif ($pr_url): ?>
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted border border-dashed">
                                        <i class="material-symbols-rounded fs-2">receipt_long</i>
                                        <a href="<?php echo html_escape($pr_url); ?>" target="_blank" class="text-xs text-primary mt-1">View Receipt (PDF/Doc)</a>
                                    </div>
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted border border-dashed">
                                        <i class="material-symbols-rounded fs-2">receipt_long</i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <input type="file" name="payment_receipt" class="form-control border text-xs bg-white">
                        </div>
                    </div>
                </div>

                <!-- Verification & Action Hub -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0 !important;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: #e6f4f1; color: #1a685b;">
                                <i class="material-symbols-rounded" style="font-size: 18px;">verified_user</i>
                            </span>
                            <div>
                                <h6 class="mb-0 text-sm font-weight-bold" style="color: #1e293b;">Verification Hub</h6>
                                <p class="text-xxs text-muted mb-0">Save details or approve status</p>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn mb-1 d-flex align-items-center justify-content-center gap-2 shadow-sm" style="background-color: #1a685b; color: #ffffff; border: none; border-radius: 8px; font-weight: 600; font-size: 0.825rem; padding: 10px 16px;">
                                <i class="material-symbols-rounded" style="font-size: 18px;">save</i> Update Member Profile
                            </button>
                            <?php if ($is_edit && $m['status'] !== 'active'): ?>
                                <button type="submit" class="btn mb-1 d-flex align-items-center justify-content-center gap-2 shadow-sm" formaction="<?php echo site_url('members/verify_member'); ?>" style="background-color: #0f766e; color: #ffffff; border: none; border-radius: 8px; font-weight: 600; font-size: 0.825rem; padding: 10px 16px;">
                                    <i class="material-symbols-rounded" style="font-size: 18px;">check_circle</i> Verify & Approve
                                </button>
                            <?php endif; ?>
                            <a href="<?php echo site_url('members'); ?>" class="btn btn-outline-secondary mb-0 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; font-weight: 500; font-size: 0.825rem; padding: 8px 16px; border: 1px solid #cbd5e1; color: #475569;">
                                <i class="material-symbols-rounded" style="font-size: 18px;">arrow_back</i> Back to Members
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic preview for profile photo
    const photoInput = document.getElementById('profile_photo_input');
    const photoPreview = document.getElementById('profile_photo_preview');
    
    if (photoInput) {
        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Dynamic unique email verification
    const emailInput = document.getElementById('admin_member_email');
    const emailFeedback = document.getElementById('admin_email_feedback');
    const excludeId = <?php echo (int)($m['id'] ?? 0); ?>;
    let emailTimer = null;

    function checkAdminEmail() {
        if (!emailInput || !emailFeedback) return;
        const val = emailInput.value.trim();
        if (!val) {
            emailFeedback.style.display = 'none';
            emailFeedback.innerText = '';
            emailInput.classList.remove('is-invalid', 'is-valid');
            return;
        }

        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!re.test(val)) {
            emailFeedback.style.display = 'block';
            emailFeedback.className = 'text-xxs mt-1 text-danger';
            emailFeedback.innerHTML = '<i class="material-symbols-rounded text-xs align-middle">error</i> Invalid email format';
            emailInput.classList.remove('is-valid');
            emailInput.classList.add('is-invalid');
            return;
        }

        fetch('<?php echo site_url("members/check_email"); ?>?email=' + encodeURIComponent(val) + '&exclude_id=' + excludeId)
            .then(res => res.json())
            .then(data => {
                if (data && data.status === 'success') {
                    if (data.available) {
                        emailFeedback.style.display = 'block';
                        emailFeedback.className = 'text-xxs mt-1 text-success';
                        emailFeedback.innerHTML = '<i class="material-symbols-rounded text-xs align-middle">check_circle</i> ' + data.message;
                        emailInput.classList.remove('is-invalid');
                        emailInput.classList.add('is-valid');
                    } else {
                        emailFeedback.style.display = 'block';
                        emailFeedback.className = 'text-xxs mt-1 text-danger';
                        emailFeedback.innerHTML = '<i class="material-symbols-rounded text-xs align-middle">cancel</i> ' + data.message;
                        emailInput.classList.remove('is-valid');
                        emailInput.classList.add('is-invalid');
                    }
                }
            })
            .catch(() => {
                emailFeedback.style.display = 'none';
            });
    }

    if (emailInput) {
        emailInput.addEventListener('blur', checkAdminEmail);
        emailInput.addEventListener('input', function() {
            clearTimeout(emailTimer);
            emailTimer = setTimeout(checkAdminEmail, 500);
        });
    }
});
</script>
