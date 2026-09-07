<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
	<div class="row justify-content-center">
		<div class="col-lg-10">
			
			<!-- Success Message -->
			<?php if ($this->session->flashdata('cms_success')): ?>
				<div class="alert alert-success alert-dismissible text-white" role="alert">
					<span class="text-sm"><?php echo html_escape($this->session->flashdata('cms_success')); ?></span>
					<button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>

			<div class="card border-0 shadow-sm">
				<div class="card-header pb-0 p-3">
					<ul class="nav nav-pills nav-fill p-1" id="profile-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-overview" role="tab" aria-controls="profile-overview" aria-selected="true">
								<i class="material-symbols-rounded align-middle me-1">visibility</i>
								Overview
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#profile-edit" role="tab" aria-controls="profile-edit" aria-selected="false">
								<i class="material-symbols-rounded align-middle me-1">edit_square</i>
								Edit Info
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#profile-security" role="tab" aria-controls="profile-security" aria-selected="false">
								<i class="material-symbols-rounded align-middle me-1">security</i>
								Security & KYC
							</a>
						</li>
					</ul>
				</div>

				<div class="card-body p-4">
					<div class="tab-content" id="profile-tab-content">
						
						<!-- Tab 1: Overview -->
						<div class="tab-pane fade show active" id="profile-overview" role="tabpanel">
							<div class="row g-4 align-items-center mb-4">
								<div class="col-auto">
									<?php
									$photo = isset($member['photo']) ? trim((string) $member['photo']) : '';
									$photo_url = '';
									if ($photo !== '') {
										$photo_url = (preg_match('#^https?://#i', $photo) || $photo[0] === '/') ? $photo : base_url($photo);
									}
									?>
									<div class="border rounded-circle overflow-hidden bg-light shadow-sm" style="width:120px;height:120px; border: 3px solid #4f46e5 !important;">
										<?php if ($photo_url !== ''): ?>
											<img src="<?php echo html_escape($photo_url); ?>" alt="" class="w-100 h-100" style="object-fit:cover;">
										<?php else: ?>
											<div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted badge-pill"><i class="material-symbols-rounded" style="font-size: 48px;">person</i></div>
										<?php endif; ?>
									</div>
								</div>
								<div class="col">
									<h4 class="mb-1 font-weight-bolder text-dark"><?php echo html_escape($member['name'] ?? ''); ?></h4>
									<p class="mb-0 text-sm font-weight-bold text-muted">Member ID: <span class="text-primary"><?php echo html_escape($member['member_id_code'] ?? 'PENDING'); ?></span></p>
									<span class="badge bg-gradient-indigo mt-2"><?php echo html_escape(strtoupper($member['role'] ?? 'MEMBER')); ?></span>
								</div>
							</div>

							<div class="row g-4">
								<div class="col-md-6 col-xl-4">
									<div class="p-3 border-radius-lg border border-light h-100 bg-gray-100">
										<h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3 text-indigo">Contact Details</h6>
										<ul class="list-group list-group-flush list-group-no-border bg-transparent">
											<li class="list-group-item px-0 py-2 bg-transparent">
												<strong class="text-dark text-xs">Mobile:</strong> <br> <span class="text-sm"><?php echo html_escape($member['mobile'] ?: 'N/A'); ?></span>
											</li>
											<li class="list-group-item px-0 py-2 bg-transparent">
												<strong class="text-dark text-xs">Email:</strong> <br> <span class="text-sm"><?php echo html_escape($member['email'] ?: 'N/A'); ?></span>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-6 col-xl-4">
									<div class="p-3 border-radius-lg border border-light h-100 bg-gray-100">
										<h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3 text-indigo">Personal Info</h6>
										<ul class="list-group list-group-flush list-group-no-border bg-transparent">
											<li class="list-group-item px-0 py-2 bg-transparent">
												<strong class="text-dark text-xs">Birth Date:</strong> <br> <span class="text-sm"><?php echo html_escape($member['dob'] !== '0000-00-00' ? date('d M, Y', strtotime($member['dob'])) : 'N/A'); ?></span>
											</li>
											<li class="list-group-item px-0 py-2 bg-transparent">
												<strong class="text-dark text-xs">Profession:</strong> <br> <span class="text-sm"><?php echo html_escape($member['profession'] ?: 'N/A'); ?></span>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-12 col-xl-4">
									<div class="p-3 border-radius-lg border border-light h-100 bg-gray-100">
										<h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3 text-indigo">KYC Status</h6>
										<ul class="list-group list-group-flush list-group-no-border bg-transparent">
											<li class="list-group-item px-0 py-2 bg-transparent">
												<strong class="text-dark text-xs">Aadhar No:</strong> <br> 
												<span class="text-sm"><?php 
													$aadhar = $member['aadhar_no'] ?? '';
													echo $aadhar !== '' ? 'XXXX-XXXX-' . substr($aadhar, -4) : '<span class="text-danger">Not Provided</span>';
												?></span>
											</li>
											<li class="list-group-item px-0 py-2 bg-transparent">
												<strong class="text-dark text-xs">Verification:</strong> <br> 
												<span class="badge badge-sm rounded-pill bg-success-soft text-success border border-success">Verified</span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<!-- Tab 2: Edit Info -->
						<div class="tab-pane fade" id="profile-edit" role="tabpanel">
							<form action="<?php echo site_url('admin/update_profile'); ?>" method="post" enctype="multipart/form-data">
								<h6 class="text-indigo text-xs text-uppercase font-weight-bolder mb-4">Basic Information</h6>
								<div class="row g-4 mb-4">
									<div class="col-12">
										<div class="d-flex align-items-center gap-4">
											<div class="position-relative">
												<div class="border rounded-circle overflow-hidden bg-light shadow-sm" style="width:100px;height:100px; border: 2px solid #4f46e5 !important;">
													<img id="edit_photo_preview" src="<?php echo $photo_url !== '' ? html_escape($photo_url) : ''; ?>" alt="" class="w-100 h-100" style="object-fit:cover;<?php echo $photo_url === '' ? 'display:none;' : ''; ?>">
													<?php if ($photo_url === ''): ?>
														<div id="edit_photo_placeholder" class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="material-symbols-rounded" style="font-size: 32px;">person</i></div>
													<?php endif; ?>
												</div>
												<label for="photo_input" class="btn btn-sm btn-icon-only bg-gradient-indigo rounded-circle mb-0 position-absolute bottom-0 end-0" style="width: 32px; height: 32px; cursor: pointer;">
													<i class="material-symbols-rounded text-white text-xs">camera_alt</i>
												</label>
												<input type="file" name="photo" id="photo_input" class="d-none" accept="image/*">
											</div>
											<div>
												<h6 class="mb-1 text-sm">Update Avatar</h6>
												<p class="text-xs text-muted mb-0">Clear square photo works best.</p>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<label class="form-label form-control-label">Full Name</label>
										<div class="input-group input-group-outline">
											<input type="text" name="name" class="form-control" value="<?php echo html_escape($member['name'] ?? ''); ?>" required>
										</div>
									</div>
									<div class="col-md-6">
										<label class="form-label form-control-label">Mobile Number</label>
										<div class="input-group input-group-outline">
											<input type="text" name="mobile" class="form-control" value="<?php echo html_escape($member['mobile'] ?? ''); ?>">
										</div>
									</div>
									<div class="col-md-6">
										<label class="form-label form-control-label">Profession / Specialization</label>
										<div class="input-group input-group-outline">
											<input type="text" name="profession" class="form-control" value="<?php echo html_escape($member['profession'] ?? ''); ?>">
										</div>
									</div>
									<div class="col-md-6">
										<label class="form-label form-control-label">Blood Group</label>
										<select name="blood_group" class="form-select border px-2 py-1">
											<?php $bg = $member['blood_group'] ?? ''; ?>
											<option value="">Select</option>
											<option value="A+" <?= $bg === 'A+' ? 'selected' : '' ?>>A+</option>
											<option value="B+" <?= $bg === 'B+' ? 'selected' : '' ?>>B+</option>
											<option value="O+" <?= $bg === 'O+' ? 'selected' : '' ?>>O+</option>
											<option value="AB+" <?= $bg === 'AB+' ? 'selected' : '' ?>>AB+</option>
										</select>
									</div>
									<div class="col-12">
										<label class="form-label form-control-label">Communication Address</label>
										<div class="input-group input-group-outline">
											<textarea name="address" class="form-control" rows="3"><?php echo html_escape($member['address'] ?? ''); ?></textarea>
										</div>
									</div>
								</div>
								
								<div class="text-end">
									<button type="submit" class="btn bg-gradient-indigo rounded-pill px-4">Update Details</button>
								</div>
							</form>
						</div>

						<!-- Tab 3: Security & KYC -->
						<div class="tab-pane fade" id="profile-security" role="tabpanel">
							<form action="<?php echo site_url('admin/update_profile'); ?>" method="post">
								<div class="row g-4">
									<div class="col-md-6">
										<div class="p-4 border-radius-lg border border-light h-100 shadow-sm">
											<h6 class="text-indigo text-xs text-uppercase font-weight-bolder mb-4">Identity Verification (KYC)</h6>
											<div class="mb-3">
												<label class="form-label form-control-label">Aadhar Card Number</label>
												<div class="input-group input-group-outline mb-1">
													<input type="text" name="aadhar_no" class="form-control" placeholder="1234 5678 9012" value="<?php echo html_escape($member['aadhar_no'] ?? ''); ?>">
												</div>
												<small class="text-xs text-muted"><i class="material-symbols-rounded text-xs align-middle">lock</i> Data is encrypted for your security.</small>
											</div>
											<div class="p-3 bg-indigo-soft rounded">
												<p class="text-xs text-indigo mb-0"><b>Note:</b> Accurate KYC details are required for generating official certificates and letters correctly.</p>
											</div>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="p-4 border-radius-lg border border-light h-100 shadow-sm">
											<h6 class="text-indigo text-xs text-uppercase font-weight-bolder mb-4">Account Security</h6>
											<div class="mb-3">
												<label class="form-label form-control-label">Change Password</label>
												<div class="input-group input-group-outline mb-3">
													<input type="password" name="password" id="new_pass" class="form-control" placeholder="New Password">
												</div>
												<div class="input-group input-group-outline">
													<input type="password" id="confirm_pass" class="form-control" placeholder="Confirm New Password">
												</div>
												<p id="pass_match_msg" class="text-xs mt-2 d-none"></p>
											</div>
											<div class="bg-gray-100 p-2 rounded text-center">
												<p class="text-xxs text-muted mb-0">Leave blank if you do not wish to change your password.</p>
											</div>
										</div>
									</div>
									
									<div class="col-12 text-end mt-4">
										<button type="submit" id="sec_submit_btn" class="btn bg-gradient-indigo rounded-pill px-5">Save Security Settings</button>
									</div>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<style>
.bg-gradient-indigo { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
.text-indigo { color: #4f46e5 !important; }
.bg-indigo-soft { background: #e0e7ff; }
.bg-success-soft { background: #ecfdf5; }
.form-control-label { font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px; color: #7b809a; }
.nav-pills .nav-link { font-weight: 600; border-radius: 10px; transition: 0.3s; }
.nav-pills .nav-link.active { background: #4f46e5 !important; color: #fff; box-shadow: 0 4px 6px rgba(79, 70, 229, 0.4); }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Photo Preview
	const photoInput = document.getElementById('photo_input');
	const previewImg = document.getElementById('edit_photo_preview');
	const placeholder = document.getElementById('edit_photo_placeholder');

	if (photoInput) {
		photoInput.addEventListener('change', function() {
			if (this.files && this.files[0]) {
				const reader = new FileReader();
				reader.onload = function(e) {
					previewImg.src = e.target.result;
					previewImg.style.display = 'block';
					if (placeholder) placeholder.style.display = 'none';
				}
				reader.readAsDataURL(this.files[0]);
			}
		});
	}

	// Password Match Validation
	const newPass = document.getElementById('new_pass');
	const confPass = document.getElementById('confirm_pass');
	const msg = document.getElementById('pass_match_msg');
	const btn = document.getElementById('sec_submit_btn');

	if (newPass && confPass) {
		const validate = () => {
			if (newPass.value === '' && confPass.value === '') {
				msg.classList.add('d-none');
				btn.disabled = false;
				return;
			}
			msg.classList.remove('d-none');
			if (newPass.value === confPass.value) {
				msg.innerHTML = '<i class="material-symbols-rounded text-xs align-middle">check_circle</i> Passwords Match';
				msg.className = 'text-xs mt-2 text-success';
				btn.disabled = false;
			} else {
				msg.innerHTML = '<i class="material-symbols-rounded text-xs align-middle">cancel</i> Passwords do not match';
				msg.className = 'text-xs mt-2 text-danger';
				btn.disabled = true;
			}
		};
		newPass.addEventListener('keyup', validate);
		confPass.addEventListener('keyup', validate);
	}
});
</script>
			</div>
			
		</div>
	</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
	var photoInput = document.getElementById('photo_input');
	var previewImg = document.getElementById('edit_photo_preview');
	var placeholder = document.getElementById('edit_photo_placeholder');

	if (photoInput && previewImg) {
		photoInput.addEventListener('change', function() {
			if (this.files && this.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					previewImg.src = e.target.result;
					previewImg.style.display = 'block';
					if (placeholder) placeholder.style.display = 'none';
				}
				reader.readAsDataURL(this.files[0]);
			}
		});
	}
});
</script>
<style>
.form-control-label {
	font-weight: 600;
	font-size: 0.85rem;
	margin-bottom: 0.3rem;
	color: #344767;
}
.list-group-no-border .list-group-item {
	padding-left: 0 !important;
	padding-right: 0 !important;
	border: none;
}
</style>
