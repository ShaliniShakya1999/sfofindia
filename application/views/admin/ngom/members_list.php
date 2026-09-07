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
	.members-action-btn { min-width: 32px; padding: 0.35rem 0.45rem; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; }
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
							<tr>
								<td><?php echo html_escape(!empty($m['member_user_id']) ? $m['member_user_id'] : str_pad((string) $m['id'], 4, '0', STR_PAD_LEFT)); ?></td>
								<td>
									<strong><?php echo html_escape($m['name']); ?></strong>
									<?php if (!empty($m['email'])): ?>
										<br><small class="text-muted"><?php echo html_escape($m['email']); ?></small>
									<?php endif; ?>
								</td>
								<td><?php echo html_escape($m['mobile']); ?></td>
								<td><?php echo html_escape(isset($m['district']) ? $m['district'] : ''); ?></td>
								<?php if ($status_mode === 'active'): ?>
									<td><?php echo html_escape(isset($m['authority']) ? $m['authority'] : ''); ?></td>
								<?php else: ?>
									<td><?php echo html_escape(isset($m['created_at']) ? date('j M Y \a\t g:i A', strtotime($m['created_at'])) : ''); ?></td>
								<?php endif; ?>
								<td class="text-end">
									<div class="d-flex gap-1 justify-content-end flex-wrap">
										<?php if ($m['status'] !== 'active'): ?>
											<a class="btn btn-sm btn-success members-action-btn" title="Verify" href="<?php echo site_url('members/form/' . (int) $m['id']); ?>"><i class="material-symbols-rounded" style="font-size:14px;">verified</i></a>
											<a class="btn btn-sm btn-primary members-action-btn" title="Edit" href="<?php echo site_url('members/form/' . (int) $m['id']); ?>"><i class="material-symbols-rounded" style="font-size:14px;">edit</i></a>
										<?php else: ?>
											<a class="btn btn-sm btn-warning members-action-btn" title="ID" target="_blank" href="<?php echo site_url('members/pdf_id_card/' . (int) $m['id']); ?>"><i class="material-symbols-rounded" style="font-size:14px;">badge</i></a>
											<a class="btn btn-sm btn-info members-action-btn" title="Letter" target="_blank" href="<?php echo site_url('members/pdf_appointment/' . (int) $m['id']); ?>"><i class="material-symbols-rounded" style="font-size:14px;">description</i></a>
											<a class="btn btn-sm btn-secondary members-action-btn" title="Certificate" target="_blank" href="<?php echo site_url('members/pdf_certificate/' . (int) $m['id']); ?>"><i class="material-symbols-rounded" style="font-size:14px;">workspace_premium</i></a>
											<a class="btn btn-sm btn-dark members-action-btn" title="Print" target="_blank" href="<?php echo site_url('members/pdf_id_card/' . (int) $m['id']); ?>"><i class="material-symbols-rounded" style="font-size:14px;">print</i></a>
											<a class="btn btn-sm btn-primary members-action-btn" title="Edit" href="<?php echo site_url('members/form/' . (int) $m['id']); ?>"><i class="material-symbols-rounded" style="font-size:14px;">edit</i></a>
											<a class="btn btn-sm btn-success members-action-btn" title="WhatsApp" target="_blank" href="https://wa.me/<?php echo preg_replace('/\D+/', '', (string) $m['mobile']); ?>"><i class="fab fa-whatsapp" style="font-size:14px;"></i></a>
										<?php endif; ?>
										<a href="<?php echo site_url('members/delete/' . (int) $m['id']); ?>" class="btn btn-sm btn-danger members-action-btn" title="Delete" onclick="return confirm('Delete permanently?');"><i class="material-symbols-rounded" style="font-size:14px;">delete</i></a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
						<?php if (empty($members)): ?>
							<tr><td colspan="6" class="text-center text-muted">No members found.</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endif; ?>
</div>
