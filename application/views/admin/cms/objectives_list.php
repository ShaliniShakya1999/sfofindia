<?php defined('BASEPATH') OR exit('No direct script access allowed');
$items = isset($items) ? $items : array();
$cms = isset($cms) ? $cms : array();
?>
<div class="container-fluid py-3">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<div>
			<h4 class="mb-0">Objective List</h4>
			<p class="text-sm text-muted mb-0">Available CMS page objective/content blocks.</p>
		</div>
		<a class="btn btn-primary btn-sm" href="<?php echo site_url('cms/dashboard'); ?>?tab=pages">Manage Pages</a>
	</div>
	<div class="card border">
		<div class="table-responsive">
			<table class="table align-items-center mb-0">
				<thead>
					<tr>
						<th>Key</th>
						<th>Label</th>
						<th>Saved Content</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($items as $key => $label): ?>
						<tr>
							<td><code><?php echo html_escape($key); ?></code></td>
							<td><?php echo html_escape($label); ?></td>
							<td><?php echo !empty($cms[$key]) ? 'Yes' : 'No'; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
