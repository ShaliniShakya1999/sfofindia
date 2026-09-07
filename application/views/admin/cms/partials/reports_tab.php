<?php defined('BASEPATH') OR exit('No direct script access allowed');
$rs = isset($report_stats) && is_array($report_stats) ? $report_stats : array();
$log = isset($rs['activity_log']) && is_array($rs['activity_log']) ? $rs['activity_log'] : array();
$complaints = isset($complaints_recent) && is_array($complaints_recent) ? $complaints_recent : array();
$role = isset($cms_role) ? $cms_role : 'admin';
?>
<div class="row g-3 mb-3">
	<?php if (isset($rs['members_total'])): ?>
		<div class="col-sm-6 col-xl-3">
			<div class="card border h-100">
				<div class="card-body">
					<p class="text-xs text-uppercase text-muted mb-1">Members</p>
					<h4 class="mb-0"><?php echo (int) $rs['members_total']; ?></h4>
					<?php if ($role === 'coordinator' && isset($rs['my_members'])): ?>
						<p class="text-xs text-muted mb-0 mt-1">Added by you: <?php echo (int) $rs['my_members']; ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if (isset($rs['donations_total'])): ?>
		<div class="col-sm-6 col-xl-3">
			<div class="card border h-100">
				<div class="card-body">
					<p class="text-xs text-uppercase text-muted mb-1">Donations (paid)</p>
					<h4 class="mb-0">₹ <?php echo number_format((float) $rs['donations_total'], 2); ?></h4>
					<p class="text-xs text-muted mb-0"><?php echo isset($rs['donations_count']) ? (int) $rs['donations_count'] : 0; ?> records</p>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="col-12 col-xl-6">
		<div class="card border h-100">
			<div class="card-body d-flex flex-wrap gap-2 align-items-center">
				<span class="text-sm text-muted me-2">Export:</span>
				<a class="btn btn-sm btn-outline-dark" href="<?php echo site_url('cms/export_report'); ?>?type=members">Members CSV</a>
				<a class="btn btn-sm btn-outline-dark" href="<?php echo site_url('cms/export_report'); ?>?type=donations">Donations CSV</a>
				<?php if (in_array($role, array('super_admin', 'admin', 'manager'), true)): ?>
					<a class="btn btn-sm btn-outline-secondary" href="<?php echo site_url('cms/export_report'); ?>?type=coordinators">Coordinator performance</a>
				<?php endif; ?>
				<a class="btn btn-sm btn-primary" href="<?php echo site_url('members'); ?>">Member admin</a>
				<a class="btn btn-sm btn-primary" href="<?php echo site_url('donations'); ?>">Donations</a>
			</div>
		</div>
	</div>
</div>

<div class="card border mb-3">
	<div class="card-body">
		<h6 class="mb-2">Recent contact / complaints</h6>
		<?php if (empty($complaints)): ?>
			<p class="text-sm text-muted mb-0">No messages yet (or table not installed).</p>
		<?php else: ?>
			<div class="table-responsive">
				<table class="table table-sm mb-0">
					<thead><tr><th>ID</th><th>Name</th><th>Subject</th><th>Status</th><th>Date</th></tr></thead>
					<tbody>
						<?php foreach ($complaints as $c): ?>
							<tr>
								<td><?php echo (int) $c['id']; ?></td>
								<td><?php echo html_escape($c['name']); ?></td>
								<td><?php echo html_escape($c['subject']); ?></td>
								<td><span class="badge bg-light text-dark"><?php echo html_escape($c['status']); ?></span></td>
								<td class="text-xs"><?php echo html_escape($c['created_at']); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
</div>

<div class="card border">
	<div class="card-body">
		<h6 class="mb-2">Manager / admin activity</h6>
		<?php if (empty($log)): ?>
			<p class="text-sm text-muted mb-0">No activity logged yet.</p>
		<?php else: ?>
			<div class="table-responsive" style="max-height:320px;overflow-y:auto;">
				<table class="table table-sm mb-0">
					<thead><tr><th>When</th><th>User</th><th>Action</th><th>Detail</th></tr></thead>
					<tbody>
						<?php foreach ($log as $row): ?>
							<tr>
								<td class="text-xs text-nowrap"><?php echo html_escape($row['created_at']); ?></td>
								<td><?php echo (int) $row['admin_user_id']; ?></td>
								<td><?php echo html_escape($row['action']); ?></td>
								<td class="small"><?php echo html_escape(isset($row['detail']) ? $row['detail'] : ''); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
</div>
