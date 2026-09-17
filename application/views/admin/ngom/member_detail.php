<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$member = isset($member) && is_array($member) ? $member : array();
$member_id = (int) ($member['id'] ?? 0);
$status = strtolower((string) ($member['status'] ?? 'pending'));
$status_class = $status === 'active' ? 'success' : ($status === 'blocked' ? 'dark' : ($status === 'inactive' ? 'warning' : 'secondary'));
$display_id = !empty($member['member_user_id']) ? $member['member_user_id'] : str_pad((string) $member_id, 4, '0', STR_PAD_LEFT);
$format_date = function ($value) {
	if (!$value || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
		return 'Not provided';
	}
	$timestamp = strtotime($value);
	return $timestamp ? date('d M Y', $timestamp) : html_escape((string) $value);
};
$value = function ($key, $fallback = 'Not provided') use ($member) {
	$value = isset($member[$key]) ? trim((string) $member[$key]) : '';
	return $value !== '' ? html_escape($value) : $fallback;
};
$masked_aadhaar = preg_replace('/\D+/', '', (string) ($member['aadhar_no'] ?? ''));
$masked_aadhaar = strlen($masked_aadhaar) >= 4 ? 'XXXX-XXXX-' . substr($masked_aadhaar, -4) : 'Not provided';
?>
<div class="container-fluid py-4">
	<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
		<div>
			<a href="<?php echo site_url('members'); ?>" class="text-sm text-muted text-decoration-none">
				<i class="material-symbols-rounded align-middle me-1" style="font-size:16px;">arrow_back</i> Back to members
			</a>
			<h4 class="mb-0 mt-2 font-weight-bolder">Member details</h4>
			<p class="text-sm text-muted mb-0">Review the member record and available actions.</p>
		</div>
		<div class="d-flex flex-wrap gap-2">
			<a class="btn btn-sm mb-0 d-inline-flex align-items-center gap-1 shadow-sm text-white" href="<?php echo site_url('members/form/' . $member_id); ?>" style="background-color: #1a685b; border-radius: 8px; font-weight: 600;">
				<i class="material-symbols-rounded align-middle" style="font-size:16px;">edit</i> Edit member
			</a>
			<?php if ($status === 'active'): ?>
				<a class="btn btn-outline-warning btn-sm mb-0 d-inline-flex align-items-center gap-1" href="<?php echo site_url('members/document_view/' . $member_id . '/id-card'); ?>" style="border-radius: 8px;">
					<i class="material-symbols-rounded align-middle" style="font-size:16px;">badge</i> ID Card
				</a>
				<a class="btn btn-outline-info btn-sm mb-0 d-inline-flex align-items-center gap-1" href="<?php echo site_url('members/document_view/' . $member_id . '/appointment-letter'); ?>" style="border-radius: 8px;">
					<i class="material-symbols-rounded align-middle" style="font-size:16px;">description</i> Appointment Letter
				</a>
				<a class="btn btn-outline-secondary btn-sm mb-0 d-inline-flex align-items-center gap-1" href="<?php echo site_url('members/document_view/' . $member_id . '/certificate'); ?>" style="border-radius: 8px;">
					<i class="material-symbols-rounded align-middle" style="font-size:16px;">workspace_premium</i> Certificate
				</a>
			<?php else: ?>
				<a class="btn btn-sm mb-0 d-inline-flex align-items-center gap-1 shadow-sm text-white" href="<?php echo site_url('members/form/' . $member_id); ?>" style="background-color: #0f766e; border-radius: 8px; font-weight: 600;">
					<i class="material-symbols-rounded align-middle" style="font-size:16px;">verified</i> Review / verify
				</a>
			<?php endif; ?>
		</div>
	</div>

	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success text-white border-0"><?php echo html_escape($this->session->flashdata('success')); ?></div>
	<?php endif; ?>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger text-white border-0"><?php echo html_escape($this->session->flashdata('error')); ?></div>
	<?php endif; ?>

	<div class="row g-4">
		<div class="col-xl-4">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-body text-center">
					<?php $photo = trim((string) ($member['photo'] ?? '')); ?>
					<?php
					$name_parts = preg_split('/\s+/', trim((string) ($member['name'] ?? '')));
					$initials = !empty($name_parts[0]) ? substr($name_parts[0], 0, 1) : '?';
					if (count($name_parts) > 1) {
						$initials .= substr($name_parts[count($name_parts) - 1], 0, 1);
					}
					?>
					<?php if ($photo !== ''): ?>
						<img src="<?php echo html_escape(site_url('members/photo/' . $member_id)); ?>" alt="" data-initials="<?php echo html_escape(strtoupper($initials)); ?>" class="member-photo rounded-circle shadow-sm mb-3" style="width:120px;height:120px;object-fit:cover;">
					<?php else: ?>
						<div class="member-initials rounded-circle bg-gradient-secondary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width:120px;height:120px;font-size:42px;font-weight:700;"><?php echo html_escape(strtoupper($initials)); ?></div>
					<?php endif; ?>
					<h4 class="mb-1"><?php echo $value('name', 'Unnamed member'); ?></h4>
					<p class="text-sm text-muted mb-2">Member ID: <strong><?php echo html_escape($display_id); ?></strong></p>
					<span class="badge bg-<?php echo $status_class; ?>"><?php echo html_escape(ucfirst($status)); ?></span>
					<hr>
					<div class="text-start">
						<p class="text-xs text-uppercase font-weight-bolder text-muted mb-1">Role</p>
						<p class="mb-3"><?php echo $value('role', 'Member'); ?></p>
						<p class="text-xs text-uppercase font-weight-bolder text-muted mb-1">Joining date</p>
						<p class="mb-0"><?php echo $format_date($member['joining_date'] ?? ''); ?></p>
					</div>
				</div>
				<script>
				document.querySelectorAll('.member-photo').forEach(function (photo) {
					photo.addEventListener('error', function () {
						var fallback = document.createElement('div');
						fallback.className = 'member-initials rounded-circle bg-gradient-secondary text-white d-inline-flex align-items-center justify-content-center mb-3';
						fallback.style.cssText = 'width:120px;height:120px;font-size:42px;font-weight:700;';
						fallback.textContent = photo.getAttribute('data-initials') || '?';
						photo.replaceWith(fallback);
					}, { once: true });
				});
				</script>
			</div>
		</div>

		<div class="col-xl-8">
			<div class="card border-0 shadow-sm mb-4">
				<div class="card-header pb-0"><h6>Member information</h6></div>
				<div class="card-body">
					<div class="row g-3">
						<div class="col-md-6"><small class="text-muted d-block">Mobile</small><strong><?php echo $value('mobile'); ?></strong></div>
						<div class="col-md-6"><small class="text-muted d-block">Email</small><strong><?php echo $value('email'); ?></strong></div>
						<div class="col-md-6"><small class="text-muted d-block">Date of birth</small><strong><?php echo $format_date($member['dob'] ?? ''); ?></strong></div>
						<div class="col-md-6"><small class="text-muted d-block">Gender</small><strong><?php echo $value('gender'); ?></strong></div>
						<div class="col-md-6"><small class="text-muted d-block">Profession</small><strong><?php echo $value('profession'); ?></strong></div>
						<div class="col-md-6"><small class="text-muted d-block">Blood group</small><strong><?php echo $value('blood_group'); ?></strong></div>
						<div class="col-md-6"><small class="text-muted d-block">State / City</small><strong><?php echo $value('state', '') . ($value('state', '') !== '' && $value('district', '') !== '' ? ' / ' : '') . $value('district', 'Not provided'); ?></strong></div>
						<div class="col-12"><small class="text-muted d-block">Address</small><strong><?php echo nl2br($value('address')); ?></strong></div>
					</div>
				</div>
			</div>
			<div class="card border-0 shadow-sm mb-4">
				<div class="card-header pb-0"><h6>Membership and verification</h6></div>
				<div class="card-body">
					<div class="row g-3">
						<div class="col-md-4"><small class="text-muted d-block">Authority</small><strong><?php echo $value('authority'); ?></strong></div>
						<div class="col-md-4"><small class="text-muted d-block">Valid from</small><strong><?php echo $format_date($member['validity_start'] ?? ''); ?></strong></div>
						<div class="col-md-4"><small class="text-muted d-block">Valid until</small><strong><?php echo $format_date($member['validity_end'] ?? ''); ?></strong></div>
						<div class="col-md-4"><small class="text-muted d-block">Aadhaar</small><strong><?php echo html_escape($masked_aadhaar); ?></strong></div>
						<div class="col-md-4"><small class="text-muted d-block">Payment mode</small><strong><?php echo $value('payment_mode'); ?></strong></div>
						<div class="col-md-4"><small class="text-muted d-block">Verified at</small><strong><?php echo $format_date($member['verified_at'] ?? ''); ?></strong></div>
					</div>
				</div>
			</div>
			<div class="card border-0 shadow-sm" style="border-radius: 12px;">
				<div class="card-header pb-0"><h6>Quick actions</h6></div>
				<div class="card-body d-flex flex-wrap align-items-center gap-2 pt-2">
					<?php if ($member['mobile'] ?? ''): ?>
						<a class="btn btn-sm mb-0 text-nowrap d-inline-flex align-items-center justify-content-center shadow-none"
						   style="height: 38px; min-height: 38px; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 8px; font-weight: 600; font-size: 0.8125rem; padding: 0 1rem; transition: all 0.2s;"
						   target="_blank"
						   href="https://wa.me/<?php echo preg_replace('/\D+/', '', (string) $member['mobile']); ?>">
							<i class="fab fa-whatsapp me-1" style="color: #16a34a; font-size: 15px;"></i> WhatsApp member
						</a>
					<?php endif; ?>
					<form method="post" action="<?php echo site_url('members/set_status'); ?>" class="d-inline-flex align-items-center gap-2 mb-0">
						<input type="hidden" name="id" value="<?php echo $member_id; ?>">
						<select name="status" class="form-select form-select-sm"
								style="height: 38px; min-height: 38px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.8125rem; font-weight: 500; min-width: 120px; width: auto; padding: 0.35rem 2rem 0.35rem 0.75rem;">
							<?php foreach (array('active', 'inactive', 'blocked', 'pending') as $option): ?>
								<option value="<?php echo $option; ?>" <?php echo $status === $option ? 'selected' : ''; ?>><?php echo ucfirst($option); ?></option>
							<?php endforeach; ?>
						</select>
						<button type="submit" class="btn btn-sm mb-0 text-nowrap d-inline-flex align-items-center justify-content-center shadow-sm text-white"
								style="height: 38px; min-height: 38px; background-color: #1a685b; border-radius: 8px; font-size: 0.8125rem; font-weight: 600; padding: 0 1rem; border: none;">
							<i class="material-symbols-rounded align-middle me-1" style="font-size: 16px;">sync</i> Update status
						</button>
					</form>
					<form method="post" action="<?php echo site_url('members/delete/' . $member_id); ?>" class="d-inline-flex align-items-center mb-0" onsubmit="return confirm('Delete this member permanently?');">
						<button type="submit" class="btn btn-sm mb-0 text-nowrap d-inline-flex align-items-center justify-content-center shadow-none"
								style="height: 38px; min-height: 38px; background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 8px; font-size: 0.8125rem; font-weight: 600; padding: 0 1rem;">
							<i class="material-symbols-rounded align-middle me-1" style="font-size: 16px;">delete</i> Delete member
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
