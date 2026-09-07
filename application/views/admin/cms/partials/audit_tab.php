<?php defined('BASEPATH') OR exit('No direct script access allowed');
$rows = isset($ngom_audit) && is_array($ngom_audit) ? $ngom_audit : array();
$role = isset($cms_role) ? $cms_role : 'admin';
$can = function_exists('ngom_can_manage_ngom_content') ? ngom_can_manage_ngom_content($role) : false;
?>
<?php if ($can): ?>
<div class="card border mb-3">
	<div class="card-body">
		<h6 class="mb-2">Upload audit report (file path)</h6>
		<p class="text-xs text-muted">Use <strong>CMS → upload</strong> or place file under <code>img/</code> and paste the relative path.</p>
		<form method="post" action="<?php echo site_url('cms/ngom_save'); ?>" class="row g-2">
			<input type="hidden" name="table" value="ngom_audit_reports">
			<input type="hidden" name="redirect_tab" value="audit">
			<div class="col-md-6">
				<label class="form-label">Title</label>
				<input type="text" name="title" class="form-control" required>
			</div>
			<div class="col-md-6">
				<label class="form-label">File path</label>
				<input type="text" name="file_path" class="form-control" required placeholder="documents/audit-2024.pdf">
			</div>
			<div class="col-12">
				<button type="submit" class="btn btn-primary">Add record</button>
			</div>
		</form>
	</div>
</div>
<?php endif; ?>

<div class="card border">
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table align-items-center mb-0">
				<thead><tr><th>ID</th><th>Title</th><th>File</th><th>Uploaded</th><?php if ($can): ?><th></th><?php endif; ?></tr></thead>
				<tbody>
					<?php foreach ($rows as $r): ?>
						<tr>
							<td><?php echo (int) $r['id']; ?></td>
							<td><?php echo html_escape($r['title']); ?></td>
							<td class="small"><a href="<?php echo base_url($r['file_path']); ?>" target="_blank" rel="noopener"><?php echo html_escape($r['file_path']); ?></a></td>
							<td class="text-xs"><?php echo html_escape($r['created_at']); ?></td>
							<?php if ($can): ?>
								<td class="text-end"><a href="<?php echo site_url('cms/ngom_delete'); ?>?table=ngom_audit_reports&amp;id=<?php echo (int) $r['id']; ?>&amp;tab=audit" class="btn btn-sm btn-outline-danger mb-0" onclick="return confirm('Delete?');">Delete</a></td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
					<?php if (empty($rows)): ?>
						<tr><td colspan="<?php echo $can ? 5 : 4; ?>" class="text-muted text-sm">No audit reports.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
