<?php defined('BASEPATH') OR exit('No direct script access allowed');
$members = isset($members) ? $members : array();
?>
<div class="container-fluid py-3">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<div>
			<h4 class="mb-0">Birthday List</h4>
			<p class="text-sm text-muted mb-0">Active members with available birth dates.</p>
		</div>
	</div>
	<div class="card border">
		<div class="table-responsive">
			<table class="table align-items-center mb-0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Mobile</th>
						<th>Date of Birth</th>
						<th>City</th>
					</tr>
				</thead>
				<tbody>
					<?php $has = false; foreach ($members as $m): ?>
						<?php if (empty($m['dob'])) { continue; } $has = true; ?>
						<tr>
							<td><?php echo html_escape($m['name']); ?></td>
							<td><?php echo html_escape($m['mobile']); ?></td>
							<td><?php echo html_escape($m['dob']); ?></td>
							<td><?php echo html_escape(isset($m['district']) ? $m['district'] : ''); ?></td>
						</tr>
					<?php endforeach; ?>
					<?php if (!$has): ?>
						<tr><td colspan="4" class="text-center text-muted">No birthday records found.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
