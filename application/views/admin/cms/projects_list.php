<?php defined('BASEPATH') OR exit('No direct script access allowed');
$rows = isset($rows) ? $rows : array();
?>
<div class="container-fluid py-3">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<div>
			<h4 class="mb-0">Projects List</h4>
			<p class="text-sm text-muted mb-0">Dedicated project listing page for admin.</p>
		</div>
		<a class="btn btn-primary btn-sm" href="<?php echo site_url('cms/dashboard'); ?>?tab=projects">Manage Projects</a>
	</div>
	<div class="card border">
		<div class="table-responsive">
			<table class="table align-items-center mb-0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Status</th>
						<th>Summary</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($rows as $r): ?>
						<tr>
							<td><?php echo (int) $r['id']; ?></td>
							<td><?php echo html_escape($r['title']); ?></td>
							<td><?php echo html_escape($r['status']); ?></td>
							<td><?php echo html_escape(isset($r['summary']) ? $r['summary'] : ''); ?></td>
						</tr>
					<?php endforeach; ?>
					<?php if (empty($rows)): ?>
						<tr><td colspan="4" class="text-center text-muted">No projects found.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
