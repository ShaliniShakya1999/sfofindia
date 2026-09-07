<?php defined('BASEPATH') OR exit('No direct script access allowed');
$rows = isset($ngom_campaigns) && is_array($ngom_campaigns) ? $ngom_campaigns : array();
$role = isset($cms_role) ? $cms_role : 'admin';
$can = function_exists('ngom_can_manage_ngom_content') ? ngom_can_manage_ngom_content($role) : false;
?>
<?php if ($can): ?>
<div class="card border mb-3">
	<div class="card-body">
		<h6 class="mb-2">Add campaign</h6>
		<form method="post" action="<?php echo site_url('cms/ngom_save'); ?>" class="row g-2">
			<input type="hidden" name="table" value="ngom_campaigns">
			<input type="hidden" name="redirect_tab" value="campaigns">
			<div class="col-md-6">
				<label class="form-label">Title</label>
				<input type="text" name="title" class="form-control" required>
			</div>
			<div class="col-md-3">
				<label class="form-label">Goal amount (₹)</label>
				<input type="number" step="0.01" name="goal_amount" class="form-control" value="0">
			</div>
			<div class="col-md-3">
				<label class="form-label">Raised (display text)</label>
				<input type="text" name="raised_display" class="form-control" placeholder="e.g. ₹2.5L">
			</div>
			<div class="col-md-4">
				<label class="form-label">Image path</label>
				<input type="text" name="image" class="form-control">
			</div>
			<div class="col-md-4">
				<label class="form-label">Status</label>
				<select name="status" class="form-select"><option value="active">active</option><option value="ended">ended</option></select>
			</div>
			<div class="col-12">
				<label class="form-label">Description</label>
				<textarea name="description" class="form-control" rows="3"></textarea>
			</div>
			<div class="col-12">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
	</div>
</div>
<?php endif; ?>

<div class="card border">
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table align-items-center mb-0">
				<thead><tr><th>ID</th><th>Title</th><th>Goal</th><th>Status</th><?php if ($can): ?><th></th><?php endif; ?></tr></thead>
				<tbody>
						<?php foreach ($rows as $r): ?>
							<?php 
								$goal = (float) $r['goal_amount'];
								$raised = (float) ($r['raised_amount'] ?? 0);
								$percent = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
							?>
							<tr>
								<td><?php echo (int) $r['id']; ?></td>
								<td>
									<strong><?php echo html_escape($r['title']); ?></strong>
									<div class="progress mt-1" style="height: 6px; width: 150px;">
										<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percent; ?>%;" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									<small class="text-xs text-muted"><?php echo $percent; ?>% (₹<?php echo number_format($raised); ?> of ₹<?php echo number_format($goal); ?>)</small>
								</td>
								<td>₹<?php echo number_format($goal); ?></td>
								<td><span class="badge bg-<?php echo $r['status'] === 'active' ? 'success' : 'secondary'; ?>"><?php echo html_escape($r['status']); ?></span></td>
								<?php if ($can): ?>
									<td class="text-end"><a href="<?php echo site_url('cms/ngom_delete'); ?>?table=ngom_campaigns&amp;id=<?php echo (int) $r['id']; ?>&amp;tab=campaigns" class="btn btn-sm btn-outline-danger mb-0" onclick="return confirm('Delete?');">Delete</a></td>
								<?php endif; ?>
							</tr>
						<?php endforeach; ?>
					<?php if (empty($rows)): ?>
						<tr><td colspan="<?php echo $can ? 5 : 4; ?>" class="text-muted text-sm">No campaigns.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
