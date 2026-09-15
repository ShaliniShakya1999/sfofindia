<?php defined('BASEPATH') OR exit('No direct script access allowed');
$table_ok = isset($table_ok) ? $table_ok : false;
$members = isset($members) ? $members : array();
$filters = isset($filters) ? $filters : array();
$page_title = isset($page_title) ? $page_title : 'Members';
$page_subtitle = isset($page_subtitle) ? $page_subtitle : 'Add, edit, block, and generate ID / letters / certificates.';
$status_mode = isset($status_mode) ? $status_mode : '';
$manager_users = isset($manager_users) ? $manager_users : array();
$coordinator_users = isset($coordinator_users) ? $coordinator_users : array();
?>
<style>
	.members-action-menu { position: relative; display: inline-block; }
	.members-action-menu summary { list-style: none; cursor: pointer; }
	.members-action-menu summary::-webkit-details-marker { display: none; }
	.members-action-menu[open] summary { background-color: #344767; color: #fff; }
	.members-action-dropdown { position: absolute; right: 0; top: calc(100% + 0.35rem); z-index: 10; min-width: 190px; padding: 0.4rem; background: #fff; border-radius: 0.65rem; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.14); text-align: left; }
	.members-action-dropdown a { display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.65rem; color: #344767; border-radius: 0.4rem; font-size: 0.8rem; text-decoration: none; white-space: nowrap; }
	.members-action-dropdown a:hover { background: #f1f3f5; }
	.members-action-dropdown a.text-danger:hover { background: #fff1f2; }
	.members-action-dropdown i { font-size: 16px; }
	.member-row-link { cursor: pointer; }
	.member-row-link:hover { background-color: rgba(79, 70, 229, 0.04); }
</style>
<div class="container-fluid py-4">
	<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
		<div>
			<h4 class="mb-0 font-weight-bolder text-capitalize"><?php echo html_escape($page_title); ?></h4>
			<p class="text-sm text-muted mb-0"><?php echo html_escape($page_subtitle); ?></p>
		</div>
		<div class="d-flex gap-2">
			<?php if ($status_mode === 'active'): ?>
				<a class="btn btn-outline-dark btn-sm mb-0 d-flex align-items-center" href="<?php echo site_url('members/export'); ?>?status=<?php echo rawurlencode($status_mode); ?>">
					<i class="material-symbols-rounded text-sm me-1">download</i> Export
				</a>
			<?php endif; ?>
			<a class="btn bg-gradient-primary btn-sm mb-0 d-flex align-items-center" href="<?php echo site_url('members/form'); ?>">
				<i class="material-symbols-rounded text-sm me-1">add</i> Add member
			</a>
		</div>
	</div>

	<?php if ($table_ok): ?>
		<div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
			<div class="card-body p-3">
				<form method="get" action="<?php echo site_url('members'); ?>" class="row g-2 align-items-end">
					<input type="hidden" name="status" value="<?php echo html_escape(isset($filters['status']) ? $filters['status'] : ''); ?>">
					<div class="col-md-2">
						<label class="form-label text-xs font-weight-bold mb-0">Start Date</label>
						<input type="date" name="date_from" class="form-control border px-2 py-1" value="<?php echo html_escape(isset($filters['date_from']) ? $filters['date_from'] : ''); ?>">
					</div>
					<div class="col-md-2">
						<label class="form-label text-xs font-weight-bold mb-0">End Date</label>
						<input type="date" name="date_to" class="form-control border px-2 py-1" value="<?php echo html_escape(isset($filters['date_to']) ? $filters['date_to'] : ''); ?>">
					</div>
					<div class="col-md-2">
						<label class="form-label text-xs font-weight-bold mb-0">Name</label>
						<input type="text" name="name" class="form-control border px-2 py-1" placeholder="Search Name" value="<?php echo html_escape(isset($filters['name']) ? $filters['name'] : ''); ?>">
					</div>
					<div class="col-md-2">
						<label class="form-label text-xs font-weight-bold mb-0">Mobile Number</label>
						<input type="text" name="mobile" class="form-control border px-2 py-1" placeholder="Mobile Number" value="<?php echo html_escape(isset($filters['mobile']) ? $filters['mobile'] : ''); ?>">
					</div>
					<div class="col-md-2">
						<label class="form-label text-xs font-weight-bold mb-0">City</label>
						<input type="text" name="district" class="form-control border px-2 py-1" placeholder="City" value="<?php echo html_escape(isset($filters['district']) ? $filters['district'] : ''); ?>">
					</div>
					<div class="col-md-2">
						<label class="form-label text-xs font-weight-bold mb-0">Address</label>
						<div class="d-flex gap-2">
							<input type="text" name="address" class="form-control border px-2 py-1" placeholder="Address" value="<?php echo html_escape(isset($filters['address']) ? $filters['address'] : ''); ?>">
						</div>
					</div>
					<?php if ($status_mode === 'active'): ?>
						<div class="col-md-3 mt-2">
							<label class="form-label text-xs font-weight-bold mb-0">Membership Status</label>
							<select name="role" class="form-select border px-2 py-1">
								<option value="">All Member</option>
								<option value="member" <?php echo (isset($filters['role']) && $filters['role'] === 'member') ? 'selected' : ''; ?>>Member</option>
								<option value="manager" <?php echo (isset($filters['role']) && $filters['role'] === 'manager') ? 'selected' : ''; ?>>Manager</option>
								<option value="coordinator" <?php echo (isset($filters['role']) && $filters['role'] === 'coordinator') ? 'selected' : ''; ?>>Coordinator</option>
							</select>
						</div>
						<div class="col-md-3 mt-2">
							<label class="form-label text-xs font-weight-bold mb-0">Manager</label>
							<select name="manager_id" class="form-select border px-2 py-1">
								<option value="">None</option>
								<?php foreach ($manager_users as $u): ?>
									<option value="<?php echo (int) $u['id']; ?>" <?php echo ((string) ($filters['manager_id'] ?? '') === (string) $u['id']) ? 'selected' : ''; ?>>
										<?php echo html_escape($u['username']); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-3 mt-2">
							<label class="form-label text-xs font-weight-bold mb-0">Coordinator</label>
							<select name="coordinator_id" class="form-select border px-2 py-1">
								<option value="">None</option>
								<?php foreach ($coordinator_users as $u): ?>
									<option value="<?php echo (int) $u['id']; ?>" <?php echo ((string) ($filters['coordinator_id'] ?? '') === (string) $u['id']) ? 'selected' : ''; ?>>
										<?php echo html_escape($u['username']); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php else: ?>
						<div class="col-md-3 mt-2">
							<label class="form-label text-xs font-weight-bold mb-0">Quick Search</label>
							<input type="text" name="q" class="form-control border px-2 py-1" placeholder="Name / Mobile" value="<?php echo html_escape(isset($filters['q']) ? $filters['q'] : ''); ?>">
						</div>
					<?php endif; ?>
					<div class="col-md-3 mt-2 d-flex gap-2">
						<button type="submit" class="btn bg-gradient-dark btn-sm w-100 mb-0">Apply Filter</button>
						<a href="<?php echo site_url('members'); ?><?php echo $status_mode !== '' ? '?status=' . rawurlencode($status_mode) : ''; ?>" class="btn btn-outline-secondary btn-sm w-100 mb-0">Reset</a>
					</div>
				</form>
			</div>
		</div>

		<?php $ci =& get_instance(); ?>
		<?php if ($ci->session->flashdata('success')): ?>
			<div class="alert alert-success text-white border-0 shadow-sm"><i class="material-symbols-rounded align-middle me-2">check_circle</i> <?php echo $ci->session->flashdata('success'); ?></div>
		<?php endif; ?>
		<?php if ($ci->session->flashdata('error')): ?>
			<div class="alert alert-danger text-white border-0 shadow-sm"><i class="material-symbols-rounded align-middle me-2">error</i> <?php echo $ci->session->flashdata('error'); ?></div>
		<?php endif; ?>

		<div class="card border-0 shadow-sm" style="border-radius:15px;">
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table align-items-center mb-0">
					<thead>
						<tr>
							<th class="text-uppercase text-xxs font-weight-bolder">PHOTO</th>
							<th class="text-uppercase text-xxs font-weight-bolder">USER ID</th>
							<th class="text-uppercase text-xxs font-weight-bolder">NAME</th>
							<th class="text-uppercase text-xxs font-weight-bolder">MOBILE NO.</th>
							<th class="text-uppercase text-xxs font-weight-bolder">CITY</th>
							<?php if ($status_mode === 'active'): ?>
								<th class="text-uppercase text-xxs font-weight-bolder">AUTHORITY</th>
							<?php else: ?>
								<th class="text-uppercase text-xxs font-weight-bolder">APPLY DATE</th>
							<?php endif; ?>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($members as $m): ?>
							<tr class="member-row-link" role="link" tabindex="0" data-member-url="<?php echo html_escape(site_url('members/view/' . (int) $m['id'])); ?>">
								<td>
									<?php
									$name_parts = preg_split('/\s+/', trim((string) $m['name']));
									$initials = !empty($name_parts[0]) ? substr($name_parts[0], 0, 1) : '?';
									if (count($name_parts) > 1) {
										$initials .= substr($name_parts[count($name_parts) - 1], 0, 1);
									}
									$initials = strtoupper($initials);
									?>
									<?php if (!empty($m['photo'])): ?>
										<img src="<?php echo html_escape(site_url('members/photo/' . (int) $m['id'])); ?>" alt="<?php echo html_escape($m['name']); ?>" data-initials="<?php echo html_escape($initials); ?>" class="member-photo rounded-circle shadow-sm" style="width:42px;height:42px;object-fit:cover;">
									<?php else: ?>
										<span class="member-initials rounded-circle bg-gradient-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:42px;height:42px;font-size:14px;font-weight:700;"><?php echo html_escape($initials); ?></span>
									<?php endif; ?>
								</td>
								<td>
									<a class="text-decoration-none text-dark" href="<?php echo site_url('members/view/' . (int) $m['id']); ?>">
										<?php echo html_escape(!empty($m['member_user_id']) ? $m['member_user_id'] : str_pad((string) $m['id'], 4, '0', STR_PAD_LEFT)); ?>
									</a>
								</td>
								<td>
									<a class="text-decoration-none text-dark" href="<?php echo site_url('members/view/' . (int) $m['id']); ?>">
										<strong><?php echo html_escape($m['name']); ?></strong>
									<?php if (!empty($m['email'])): ?>
										<br><small class="text-muted"><?php echo html_escape($m['email']); ?></small>
									<?php endif; ?>
									</a>
								</td>
								<td><?php echo html_escape($m['mobile']); ?></td>
								<td><?php echo html_escape(isset($m['district']) ? $m['district'] : ''); ?></td>
								<?php if ($status_mode === 'active'): ?>
									<td><?php echo html_escape(isset($m['authority']) ? $m['authority'] : ''); ?></td>
								<?php else: ?>
									<td><?php echo html_escape(isset($m['created_at']) ? date('j M Y \a\t g:i A', strtotime($m['created_at'])) : ''); ?></td>
								<?php endif; ?>
								<td class="text-end" onclick="event.stopPropagation();">
									<div class="d-flex gap-2 justify-content-end align-items-center">
										<a class="btn btn-sm btn-outline-primary mb-0" href="<?php echo site_url('members/view/' . (int) $m['id']); ?>">
											<i class="material-symbols-rounded align-middle me-1" style="font-size:15px;">visibility</i> View
										</a>
										<details class="members-action-menu" onclick="event.stopPropagation();">
											<summary class="btn btn-sm btn-outline-secondary mb-0">Actions <i class="material-symbols-rounded align-middle ms-1" style="font-size:15px;">expand_more</i></summary>
											<div class="members-action-dropdown">
												<?php if ($m['status'] !== 'active'): ?>
													<a href="<?php echo site_url('members/form/' . (int) $m['id']); ?>"><i class="material-symbols-rounded text-success">verified</i> Review / verify</a>
													<a href="<?php echo site_url('members/form/' . (int) $m['id']); ?>"><i class="material-symbols-rounded text-primary">edit</i> Edit member</a>
												<?php else: ?>
													<a href="<?php echo site_url('members/document_view/' . (int) $m['id'] . '/id-card'); ?>"><i class="material-symbols-rounded text-warning">badge</i> ID card</a>
													<a href="<?php echo site_url('members/document_view/' . (int) $m['id'] . '/appointment-letter'); ?>"><i class="material-symbols-rounded text-info">description</i> Appointment letter</a>
													<a href="<?php echo site_url('members/document_view/' . (int) $m['id'] . '/certificate'); ?>"><i class="material-symbols-rounded text-secondary">workspace_premium</i> Certificate</a>
													<a href="<?php echo site_url('members/form/' . (int) $m['id']); ?>"><i class="material-symbols-rounded text-primary">edit</i> Edit member</a>
													<?php if (!empty($m['mobile'])): ?>
														<a target="_blank" href="https://wa.me/<?php echo preg_replace('/\D+/', '', (string) $m['mobile']); ?>"><i class="fab fa-whatsapp text-success"></i> WhatsApp member</a>
													<?php endif; ?>
												<?php endif; ?>
												<form method="post" action="<?php echo site_url('members/delete/' . (int) $m['id']); ?>" onsubmit="return confirm('Delete permanently?');">
													<button type="submit" class="dropdown-item text-danger"><i class="material-symbols-rounded">delete</i> Delete member</button>
												</form>
											</div>
										</details>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
						<?php if (empty($members)): ?>
							<tr><td colspan="7" class="text-center text-muted">No members found.</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endif; ?>
</div>
<script>
document.querySelectorAll('.member-photo').forEach(function (photo) {
	photo.addEventListener('error', function () {
		var fallback = document.createElement('span');
		fallback.className = 'member-initials rounded-circle bg-gradient-secondary text-white d-inline-flex align-items-center justify-content-center';
		fallback.style.cssText = 'width:42px;height:42px;font-size:14px;font-weight:700;';
		fallback.textContent = photo.getAttribute('data-initials') || '?';
		photo.replaceWith(fallback);
	}, { once: true });
});
document.querySelectorAll('.member-row-link').forEach(function (row) {
	row.addEventListener('click', function (event) {
		if (event.target.closest('a, button, input, select, textarea, form, summary, .members-action-menu')) {
			return;
		}
		window.location.href = row.getAttribute('data-member-url');
	});
	row.addEventListener('keydown', function (event) {
		if (event.key === 'Enter' || event.key === ' ') {
			event.preventDefault();
			window.location.href = row.getAttribute('data-member-url');
		}
	});
});
document.querySelectorAll('.members-action-menu').forEach(function (menu) {
	menu.addEventListener('click', function (event) {
		event.stopPropagation();
	});
	menu.addEventListener('toggle', function () {
		if (!menu.open) {
			return;
		}
		document.querySelectorAll('.members-action-menu[open]').forEach(function (otherMenu) {
			if (otherMenu !== menu) {
				otherMenu.removeAttribute('open');
			}
		});
	});
});
</script>
