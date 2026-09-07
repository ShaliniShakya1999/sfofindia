<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (!isset($embed)) {
	$embed = false;
}
?>
<?php echo form_open('cms/save_pages'); ?>
	<?php foreach ($page_fields as $key => $label): ?>
		<div class="card border mb-3">
			<div class="card-header py-2">
				<strong><?php echo html_escape($label); ?></strong>
				<span class="text-muted small ms-2"><code><?php echo html_escape($key); ?></code></span>
			</div>
			<div class="card-body p-2">
				<textarea name="<?php echo html_escape($key); ?>" class="form-control font-monospace" rows="6" placeholder="(optional)"><?php echo isset($cms[$key]) ? htmlspecialchars($cms[$key], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
			</div>
		</div>
	<?php endforeach; ?>
	<button type="submit" class="btn btn-primary">Save all</button>
	<?php if (!$embed): ?>
		<a class="btn btn-outline-secondary" href="<?php echo site_url('cms/dashboard'); ?>">Back</a>
	<?php endif; ?>
<?php echo form_close(); ?>
