<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$active_tab = $this->session->flashdata('active_tab') ?: 'overview';
$raw_email = trim((string)($member['email'] ?? ''));
$masked_email = '';
if ($raw_email !== '') {
	$eparts = explode('@', $raw_email);
	$u = $eparts[0];
	$d = $eparts[1] ?? '';
	if (strlen($u) > 2) {
		$masked_u = substr($u, 0, 1) . str_repeat('*', max(3, strlen($u) - 2)) . substr($u, -1);
	} else {
		$masked_u = $u . '***';
	}
	$masked_email = $masked_u . '@' . $d;
}
?>
<div class="container-fluid py-4">
	<div class="row justify-content-center">
		<div class="col-lg-10">
			
			<!-- Success Message -->
			<?php if ($this->session->flashdata('cms_success')): ?>
				<div class="alert alert-success alert-dismissible text-white mb-3" role="alert">
					<span class="text-sm"><i class="material-symbols-rounded align-middle me-1">check_circle</i> <?php echo html_escape($this->session->flashdata('cms_success')); ?></span>
					<button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>

			<!-- Error Message -->
			<?php if ($this->session->flashdata('cms_error')): ?>
				<div class="alert alert-danger alert-dismissible text-white mb-3" role="alert">
					<span class="text-sm"><i class="material-symbols-rounded align-middle me-1">error</i> <?php echo html_escape($this->session->flashdata('cms_error')); ?></span>
					<button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>

			<div class="card border-0 shadow-sm">
				<div class="card-header pb-0 p-3">
					<ul class="nav nav-pills nav-fill p-1" id="profile-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link mb-0 px-0 py-1 <?php echo $active_tab === 'overview' ? 'active' : ''; ?>" data-bs-toggle="tab" href="#profile-overview" role="tab" aria-controls="profile-overview" aria-selected="<?php echo $active_tab === 'overview' ? 'true' : 'false'; ?>">
								<i class="material-symbols-rounded align-middle me-1">visibility</i>
								Overview
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link mb-0 px-0 py-1 <?php echo $active_tab === 'edit' ? 'active' : ''; ?>" data-bs-toggle="tab" href="#profile-edit" role="tab" aria-controls="profile-edit" aria-selected="<?php echo $active_tab === 'edit' ? 'true' : 'false'; ?>">
								<i class="material-symbols-rounded align-middle me-1">edit_square</i>
								Edit Info
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link mb-0 px-0 py-1 <?php echo $active_tab === 'security' ? 'active' : ''; ?>" data-bs-toggle="tab" href="#profile-security" role="tab" aria-controls="profile-security" aria-selected="<?php echo $active_tab === 'security' ? 'true' : 'false'; ?>">
								<i class="material-symbols-rounded align-middle me-1">security</i>
								Security & KYC
							</a>
						</li>
					</ul>
				</div>

				<div class="card-body p-4">
					<div class="tab-content" id="profile-tab-content">
						
						<!-- Tab 1: Overview -->
						<div class="tab-pane fade <?php echo $active_tab === 'overview' ? 'show active' : ''; ?>" id="profile-overview" role="tabpanel">

							<?php
								$mstatus = $member['status'] ?? '';
								$vend = $member['validity_end'] ?? '';
								$days_left = $vend ? (int) ceil((strtotime($vend) - strtotime(date('Y-m-d'))) / 86400) : null;
							?>
							<?php if ($mstatus === 'inactive'): ?>
								<div class="alert alert-danger text-white d-flex justify-content-between align-items-center flex-wrap gap-2" role="alert">
									<span class="text-sm">Your membership expired<?php echo $vend ? ' on <b>' . html_escape(date('d M, Y', strtotime($vend))) . '</b>' : ''; ?>. Renew now to restore full access.</span>
									<a href="<?php echo site_url('admin/renew'); ?>" class="btn btn-sm btn-white text-danger mb-0">Renew Now</a>
								</div>
							<?php elseif ($vend && $days_left !== null && $days_left <= 14): ?>
								<div class="alert alert-warning text-white d-flex justify-content-between align-items-center flex-wrap gap-2" role="alert">
									<span class="text-sm">Your membership expires in <b><?php echo (int) $days_left; ?> day<?php echo $days_left === 1 ? '' : 's'; ?></b> (<?php echo html_escape(date('d M, Y', strtotime($vend))); ?>). Renew early to avoid interruption.</span>
									<a href="<?php echo site_url('admin/renew'); ?>" class="btn btn-sm btn-white text-warning mb-0">Renew Now</a>
								</div>
							<?php endif; ?>

							<div class="row g-4 align-items-center mb-4">
								<div class="col-auto">
									<?php
									$photo = isset($member['photo']) ? trim((string) $member['photo']) : '';
									$photo_url = '';
									if ($photo !== '') {
										$photo_url = (preg_match('#^https?://#i', $photo) || $photo[0] === '/') ? $photo : base_url($photo);
									}
									?>
									<div class="border rounded-circle overflow-hidden bg-light shadow-sm" style="width:120px;height:120px; border: 3px solid #1a685b !important;">
										<?php if ($photo_url !== ''): ?>
											<img src="<?php echo html_escape($photo_url); ?>" alt="" class="w-100 h-100" style="object-fit:cover;">
										<?php else: ?>
											<div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted badge-pill"><i class="material-symbols-rounded" style="font-size: 48px;">person</i></div>
										<?php endif; ?>
									</div>
								</div>
								<div class="col">
									<h4 class="mb-1 font-weight-bolder text-dark"><?php echo html_escape($member['name'] ?? ''); ?></h4>
									<p class="mb-0 text-sm font-weight-bold text-muted">Member ID: <span style="color: #1a685b; font-weight: 700;"><?php echo html_escape($member['member_id_code'] ?? 'PENDING'); ?></span></p>
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
						<div class="tab-pane fade <?php echo $active_tab === 'edit' ? 'show active' : ''; ?>" id="profile-edit" role="tabpanel">
							<form action="<?php echo site_url('admin/update_profile'); ?>" method="post" enctype="multipart/form-data">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<h6 class="text-indigo text-xs text-uppercase font-weight-bolder mb-4">Basic Information</h6>
								<div class="row g-4 mb-4">
									<div class="col-12">
										<div class="d-flex align-items-center gap-4">
											<div class="position-relative">
												<div class="border rounded-circle overflow-hidden bg-light shadow-sm" style="width:100px;height:100px; border: 2px solid #1a685b !important;">
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
						<div class="tab-pane fade <?php echo $active_tab === 'security' ? 'show active' : ''; ?>" id="profile-security" role="tabpanel">
							<form action="<?php echo site_url('admin/update_profile'); ?>" method="post" id="security_form">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<input type="hidden" name="auth_mode" id="auth_mode_input" value="password">
								
								<div class="row g-4">
									<div class="col-md-5">
										<div class="p-4 border-radius-lg border border-light h-100 shadow-sm bg-white">
											<h6 class="text-indigo text-xs text-uppercase font-weight-bolder mb-3">Identity Verification (KYC)</h6>
											<div class="mb-3">
												<label class="form-label form-control-label">Aadhar Card Number</label>
												<div class="input-group input-group-outline mb-1">
													<input type="text" name="aadhar_no" class="form-control" placeholder="1234 5678 9012" value="<?php echo html_escape($member['aadhar_no'] ?? ''); ?>">
												</div>
												<small class="text-xs text-muted"><i class="material-symbols-rounded text-xs align-middle">lock</i> Securely recorded for official documentation.</small>
											</div>
											<div class="p-3 bg-indigo-soft rounded">
												<p class="text-xs text-indigo mb-0"><b>Note:</b> Accurate KYC details are required for generating official certificates, identity cards, and appointment letters.</p>
											</div>
										</div>
									</div>
									
									<div class="col-md-7">
										<div class="p-4 border-radius-lg border border-light h-100 shadow-sm bg-white">
											<div class="d-flex justify-content-between align-items-center mb-3">
												<h6 class="text-indigo text-xs text-uppercase font-weight-bolder mb-0">Account Security</h6>
												<span class="badge bg-indigo-soft text-indigo text-xxs font-weight-bold">Password & Authorization</span>
											</div>

											<p class="text-xs text-muted mb-3">
												To change your password, verify using your <b>Current Password</b>, or request a <b>6-digit Email OTP</b> if you forgot it.
											</p>

											<!-- Verification Mode Switcher -->
											<div class="d-flex p-1 bg-gray-100 rounded-3 mb-3 border">
												<button type="button" id="tab_btn_password" class="btn btn-sm btn-white flex-grow-1 mb-0 shadow-xs border-0 font-weight-bold text-xs active-auth-tab" onclick="switchAuthMode('password')">
													<i class="material-symbols-rounded text-xs align-middle me-1">key</i> Current Password
												</button>
												<button type="button" id="tab_btn_otp" class="btn btn-sm flex-grow-1 mb-0 shadow-none border-0 font-weight-bold text-xs text-secondary" onclick="switchAuthMode('otp')">
													<i class="material-symbols-rounded text-xs align-middle me-1">mark_email_read</i> Email OTP
												</button>
											</div>

											<!-- Mode A: Current Password -->
											<div id="auth_mode_password" class="mb-3">
												<label class="form-label form-control-label" for="current_pass">Current Password <span class="text-danger">*</span></label>
												<div class="input-group input-group-outline mb-1">
													<input type="password" name="current_password" id="current_pass" class="form-control" placeholder="Enter your current password" autocomplete="current-password">
												</div>
												<div class="d-flex justify-content-between align-items-center">
													<small class="text-xxs text-muted">Required to authorize new password</small>
													<button type="button" class="btn btn-link text-indigo text-xxs p-0 m-0 text-decoration-underline" onclick="switchAuthMode('otp')">
														Forgot current password? Use OTP
													</button>
												</div>
											</div>

											<!-- Mode B: Email OTP -->
											<div id="auth_mode_otp" class="mb-3 p-3 rounded-3 border" style="display: none; background-color: #f8faff; border-color: #c7d2fe !important;">
												<div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
													<div>
														<div class="text-xs font-weight-bold text-indigo">
															<i class="material-symbols-rounded text-xs align-middle">email</i> 6-Digit Email OTP
														</div>
														<div class="text-xxs text-muted">
															Send to: <strong class="text-dark"><?php echo html_escape($masked_email ?: 'registered email'); ?></strong>
														</div>
													</div>
													<button type="button" id="send_otp_btn" class="btn btn-sm bg-gradient-indigo text-white mb-0 px-3 d-inline-flex align-items-center gap-1" onclick="requestProfileOtp()">
														<span id="send_otp_spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" style="width: 0.85rem; height: 0.85rem;"></span>
														<i class="material-symbols-rounded text-xs" id="send_otp_icon">send</i>
														<span id="send_otp_text">Send OTP</span>
													</button>
												</div>

												<div>
													<label class="form-label form-control-label" for="otp_code">Enter 6-Digit OTP</label>
													<div class="input-group input-group-outline mb-1">
														<input type="text" name="otp_code" id="otp_code" class="form-control text-center font-weight-bolder" placeholder="• • • • • •" maxlength="6" pattern="[0-9]{6}" autocomplete="one-time-code" style="letter-spacing: 6px; font-size: 1.15rem; font-family: monospace;">
													</div>
													<div class="d-flex justify-content-between align-items-center">
														<small class="text-xxs text-muted">Code valid for 10 minutes</small>
														<button type="button" class="btn btn-link text-muted text-xxs p-0 m-0 text-decoration-underline" onclick="switchAuthMode('password')">
															Use Current Password instead
														</button>
													</div>
												</div>

												<div id="otp_alert_box" class="mt-2 text-xs p-2 rounded d-none"></div>
											</div>

											<hr class="horizontal dark my-3">

											<!-- New Password Fields -->
											<div class="row g-2 mb-2">
												<div class="col-sm-6">
													<label class="form-label form-control-label" for="new_pass">New Password</label>
													<div class="input-group input-group-outline">
														<input type="password" name="password" id="new_pass" class="form-control" placeholder="Min. 6 characters" autocomplete="new-password">
													</div>
												</div>
												<div class="col-sm-6">
													<label class="form-label form-control-label" for="confirm_pass">Confirm New Password</label>
													<div class="input-group input-group-outline">
														<input type="password" name="confirm_password" id="confirm_pass" class="form-control" placeholder="Repeat new password" autocomplete="new-password">
													</div>
												</div>
											</div>
											<p id="pass_match_msg" class="text-xs mb-2 d-none"></p>

											<div class="bg-gray-100 p-2 rounded text-center">
												<p class="text-xxs text-muted mb-0">Leave password fields blank if you do not wish to change your password.</p>
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
.bg-gradient-indigo { background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%); }
.text-indigo { color: #1a685b !important; }
.bg-indigo-soft { background: #e6f0ee; }
.bg-success-soft { background: #ecfdf5; }
.bg-danger-soft { background: #fef2f2; }
.form-control-label { font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px; color: #7b809a; }
.nav-pills .nav-link { font-weight: 600; border-radius: 10px; transition: 0.2s; }
.nav-pills .nav-link.active { background: #1a685b !important; color: #fff; box-shadow: 0 4px 6px rgba(26, 104, 91, 0.3); }
.active-auth-tab { background: #fff !important; color: #1a685b !important; box-shadow: 0 2px 4px rgba(0,0,0,0.06); }
.letter-spacing-2 { letter-spacing: 2px; }
</style>

<script>
let otpCountdownTimer = null;

function switchAuthMode(mode) {
	const passBlock = document.getElementById('auth_mode_password');
	const otpBlock = document.getElementById('auth_mode_otp');
	const btnPass = document.getElementById('tab_btn_password');
	const btnOtp = document.getElementById('tab_btn_otp');
	const authInput = document.getElementById('auth_mode_input');

	if (mode === 'otp') {
		passBlock.style.display = 'none';
		otpBlock.style.display = 'block';
		authInput.value = 'otp';

		btnOtp.classList.add('btn-white', 'shadow-xs', 'active-auth-tab');
		btnOtp.classList.remove('shadow-none', 'text-secondary');
		btnPass.classList.remove('btn-white', 'shadow-xs', 'active-auth-tab');
		btnPass.classList.add('shadow-none', 'text-secondary');

		const otpCode = document.getElementById('otp_code');
		if (otpCode && otpCode.value.trim() === '') {
			otpCode.focus();
		}
	} else {
		passBlock.style.display = 'block';
		otpBlock.style.display = 'none';
		authInput.value = 'password';

		btnPass.classList.add('btn-white', 'shadow-xs', 'active-auth-tab');
		btnPass.classList.remove('shadow-none', 'text-secondary');
		btnOtp.classList.remove('btn-white', 'shadow-xs', 'active-auth-tab');
		btnOtp.classList.add('shadow-none', 'text-secondary');

		const currPass = document.getElementById('current_pass');
		if (currPass) {
			currPass.focus();
		}
	}
}

function requestProfileOtp() {
	const btn = document.getElementById('send_otp_btn');
	const spinner = document.getElementById('send_otp_spinner');
	const icon = document.getElementById('send_otp_icon');
	const label = document.getElementById('send_otp_text');
	const alertBox = document.getElementById('otp_alert_box');

	btn.disabled = true;
	spinner.classList.remove('d-none');
	icon.classList.add('d-none');
	label.textContent = 'Sending...';

	fetch('<?php echo site_url('admin/send_profile_otp'); ?>', {
		method: 'POST',
		headers: {
			'X-Requested-With': 'XMLHttpRequest'
		}
	})
	.then(response => response.json())
	.then(data => {
		spinner.classList.add('d-none');
		icon.classList.remove('d-none');

		if (data.success) {
			alertBox.classList.remove('d-none', 'alert-danger', 'bg-danger-soft', 'text-danger');
			alertBox.classList.add('alert-success', 'bg-success-soft', 'text-success');
			alertBox.innerHTML = '<i class="material-symbols-rounded text-xs align-middle me-1">check_circle</i> ' + data.message;

			const otpInput = document.getElementById('otp_code');
			if (otpInput) otpInput.focus();

			// 45s countdown
			let countdown = 45;
			label.textContent = 'Resend in ' + countdown + 's';
			if (otpCountdownTimer) clearInterval(otpCountdownTimer);

			otpCountdownTimer = setInterval(function() {
				countdown--;
				if (countdown <= 0) {
					clearInterval(otpCountdownTimer);
					btn.disabled = false;
					label.textContent = 'Resend OTP';
				} else {
					label.textContent = 'Resend in ' + countdown + 's';
				}
			}, 1000);
		} else {
			alertBox.classList.remove('d-none', 'alert-success', 'bg-success-soft', 'text-success');
			alertBox.classList.add('alert-danger', 'bg-danger-soft', 'text-danger');
			alertBox.innerHTML = '<i class="material-symbols-rounded text-xs align-middle me-1">error</i> ' + (data.message || 'Failed to send OTP.');
			btn.disabled = false;
			label.textContent = 'Send OTP';
		}
	})
	.catch(err => {
		spinner.classList.add('d-none');
		icon.classList.remove('d-none');
		btn.disabled = false;
		label.textContent = 'Send OTP';

		alertBox.classList.remove('d-none', 'alert-success', 'bg-success-soft', 'text-success');
		alertBox.classList.add('alert-danger', 'bg-danger-soft', 'text-danger');
		alertBox.innerHTML = '<i class="material-symbols-rounded text-xs align-middle me-1">error</i> Network error sending OTP. Please try again.';
	});
}

document.addEventListener("DOMContentLoaded", function() {
	// Photo Preview for Edit Info
	const photoInput = document.getElementById('photo_input');
	const previewImg = document.getElementById('edit_photo_preview');
	const placeholder = document.getElementById('edit_photo_placeholder');

	if (photoInput && previewImg) {
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

	// Live Password Match Validation
	const newPass = document.getElementById('new_pass');
	const confPass = document.getElementById('confirm_pass');
	const msg = document.getElementById('pass_match_msg');
	const btn = document.getElementById('sec_submit_btn');

	if (newPass && confPass) {
		const validatePassMatch = () => {
			if (newPass.value === '' && confPass.value === '') {
				msg.classList.add('d-none');
				btn.disabled = false;
				return true;
			}
			msg.classList.remove('d-none');
			if (newPass.value === confPass.value) {
				msg.innerHTML = '<i class="material-symbols-rounded text-xs align-middle">check_circle</i> Passwords Match';
				msg.className = 'text-xs mb-2 text-success';
				btn.disabled = false;
				return true;
			} else {
				msg.innerHTML = '<i class="material-symbols-rounded text-xs align-middle">cancel</i> Passwords do not match';
				msg.className = 'text-xs mb-2 text-danger';
				btn.disabled = true;
				return false;
			}
		};
		newPass.addEventListener('keyup', validatePassMatch);
		confPass.addEventListener('keyup', validatePassMatch);
	}

	// Form Submission Client-Side Checks
	const secForm = document.getElementById('security_form');
	if (secForm) {
		secForm.addEventListener('submit', function(e) {
			const nPass = document.getElementById('new_pass').value;
			const cPass = document.getElementById('confirm_pass').value;
			const authMode = document.getElementById('auth_mode_input').value;
			const curPass = document.getElementById('current_pass').value.trim();
			const otpCode = document.getElementById('otp_code').value.trim();

			if (nPass !== '') {
				if (nPass.length < 6) {
					e.preventDefault();
					alert('The new password must be at least 6 characters long.');
					document.getElementById('new_pass').focus();
					return false;
				}
				if (nPass !== cPass) {
					e.preventDefault();
					alert('The new password and confirm password do not match.');
					document.getElementById('confirm_pass').focus();
					return false;
				}
				if (authMode === 'password' && curPass === '') {
					e.preventDefault();
					alert('Please enter your Current Password, or switch to "Email OTP" if you do not remember it.');
					document.getElementById('current_pass').focus();
					return false;
				}
				if (authMode === 'otp' && (otpCode === '' || otpCode.length !== 6)) {
					e.preventDefault();
					alert('Please enter the 6-digit OTP code sent to your registered email.');
					document.getElementById('otp_code').focus();
					return false;
				}
			}
		});
	}

	// URL Hash Tab Navigation Preservation
	const hash = window.location.hash;
	if (hash) {
		const targetTrigger = document.querySelector('#profile-tabs a[href="' + hash + '"]');
		if (targetTrigger && typeof bootstrap !== 'undefined' && bootstrap.Tab) {
			new bootstrap.Tab(targetTrigger).show();
		}
	}

	// Keep hash in URL when clicking tabs
	const tabLinks = document.querySelectorAll('#profile-tabs a[data-bs-toggle="tab"]');
	tabLinks.forEach(tab => {
		tab.addEventListener('shown.bs.tab', function(e) {
			if (history.replaceState) {
				history.replaceState(null, null, e.target.getAttribute('href'));
			}
		});
	});
});
</script>
