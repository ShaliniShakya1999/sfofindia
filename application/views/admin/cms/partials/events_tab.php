<?php defined('BASEPATH') OR exit('No direct script access allowed');
$rows = isset($ngom_events) && is_array($ngom_events) ? $ngom_events : array();
$role = isset($cms_role) ? $cms_role : 'admin';
$can = function_exists('ngom_can_manage_ngom_content') ? ngom_can_manage_ngom_content($role) : false;
?>
<?php if ($can): ?>
<div class="card border mb-3">
	<div class="card-body">
		<h6 class="mb-2">Add event</h6>
		<form method="post" action="<?php echo site_url('cms/ngom_save'); ?>" class="row g-2" enctype="multipart/form-data">
			<input type="hidden" name="table" value="ngom_events">
			<input type="hidden" name="redirect_tab" value="events">
			<div class="col-md-6">
				<label class="form-label">Title</label>
				<input type="text" name="title" class="form-control" required>
			</div>
			<div class="col-md-6">
				<label class="form-label">Slug (optional)</label>
				<input type="text" name="slug" class="form-control" placeholder="auto from title">
			</div>
			<div class="col-md-4">
				<label class="form-label">Event date</label>
				<input type="date" name="event_date" class="form-control">
			</div>
			<div class="col-md-4">
				<label class="form-label">Image upload</label>
				<input type="file" name="image" class="form-control" accept="image/*">
			</div>
			<div class="col-md-4">
				<label class="form-label">Status</label>
				<select name="status" class="form-select"><option value="published">published</option><option value="draft">draft</option></select>
			</div>
			<div class="col-12">
				<label class="form-label">Body</label>
				<textarea name="body" class="form-control" rows="4"></textarea>
			</div>
			<div class="col-12">
				<button type="submit" class="btn btn-primary">Save event</button>
			</div>
		</form>
	</div>
</div>
<?php endif; ?>

<div class="card border">
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table align-items-center mb-0">
				<thead><tr><th>ID</th><th>Title</th><th>Image</th><th>Date</th><th>Status</th><?php if ($can): ?><th></th><?php endif; ?></tr></thead>
				<tbody>
					<?php foreach ($rows as $r): ?>
						<tr>
							<td><?php echo (int) $r['id']; ?></td>
							<td><?php echo html_escape($r['title']); ?></td>
							<td>
								<?php if (!empty($r['image'])): ?>
									<img src="<?php echo base_url($r['image']); ?>" alt="event" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
								<?php endif; ?>
							</td>
							<td><?php echo html_escape(isset($r['event_date']) ? $r['event_date'] : ''); ?></td>
							<td><?php echo html_escape($r['status']); ?></td>
							<?php if ($can): ?>
								<td class="text-end"><a href="<?php echo site_url('cms/ngom_delete'); ?>?table=ngom_events&amp;id=<?php echo (int) $r['id']; ?>&amp;tab=events" class="btn btn-sm btn-outline-danger mb-0" onclick="return confirm('Delete?');">Delete</a></td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
					<?php if (empty($rows)): ?>
						<tr><td colspan="<?php echo $can ? 6 : 5; ?>" class="text-muted text-sm">No events.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
