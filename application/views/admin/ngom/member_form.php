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
                                <label class="form-label text-xs font-weight-bold">Email Address</label>
                                <input type="email" name="email" class="form-control px-3 border" value="<?php echo html_escape($m['email'] ?? ''); ?>">
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
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Role Title</label>
                                <input type="text" name="role" class="form-control px-3 border" placeholder="member / volunteer / manager" value="<?php echo html_escape($m['role'] ?? 'member'); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs font-weight-bold">Current Status</label>
                                <select name="status" class="form-select px-3 border">
                                    <?php foreach (array('pending', 'active', 'blocked', 'inactive') as $st): ?>
                                        <option value="<?php echo $st; ?>" <?php echo (($m['status'] ?? 'active') === $st) ? 'selected' : ''; ?>><?php echo ucfirst($st); ?></option>
                                    <?php endforeach; ?>
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
                                $ph_url = (preg_match('#^https?://#i', $ph) || $ph[0] === '/') ? $ph : base_url($ph);
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
                            $af_url = ($af !== '') ? base_url($af) : '';
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
                            $ab_url = ($ab !== '') ? base_url($ab) : '';
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
                            $pr_url = ($pr !== '') ? ((preg_match('#^https?://#i', $pr) || $pr[0] === '/') ? $pr : base_url($pr)) : '';
                            $pr_is_img = (bool) preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $pr);
                            ?>
                            <div class="position-relative border-radius-lg overflow-hidden bg-white mb-2 shadow-sm" style="height:150px;">
                                <?php if ($pr_url && $pr_is_img): ?>
                                    <img src="<?php echo html_escape($pr_url); ?>" class="w-100 h-100" style="object-fit:contain;">
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

                <!-- Action Hub -->
                <div class="card shadow-primary bg-gradient-dark">
                    <div class="card-body p-3">
                        <h6 class="text-white mb-3">Verification Hub</h6>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn bg-gradient-info mb-1">Update Member Profile</button>
                            <?php if ($is_edit && $m['status'] !== 'active'): ?>
                                <button type="submit" class="btn bg-gradient-success mb-1" formaction="<?php echo site_url('members/verify_member'); ?>">✅ Verify & Approve</button>
                            <?php endif; ?>
                            <a href="<?php echo site_url('members'); ?>" class="btn btn-secondary mb-0">Back to Database</a>
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
});
</script>
