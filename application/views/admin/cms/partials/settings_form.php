<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (!isset($embed)) {
	$embed = false;
}
?>
<form method="post" action="<?php echo site_url('cms/save_settings'); ?>" class="card card-body border">
	<h6 class="text-uppercase text-xs text-muted">Branding &amp; SEO</h6>
	<div class="mb-3">
		<label class="form-label">Site name</label>
		<input type="text" name="site_name" class="form-control" value="<?php echo html_escape(cms_val($cms, 'site_name', '')); ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Meta title</label>
		<input type="text" name="meta_title" class="form-control" value="<?php echo html_escape(cms_val($cms, 'meta_title', '')); ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Meta description</label>
		<textarea name="meta_description" class="form-control" rows="2"><?php echo html_escape(cms_val($cms, 'meta_description', '')); ?></textarea>
	</div>
	<div class="mb-3">
		<label class="form-label">Meta keywords</label>
		<input type="text" name="meta_keywords" class="form-control" value="<?php echo html_escape(cms_val($cms, 'meta_keywords', '')); ?>">
	</div>
	<h6 class="text-uppercase text-xs text-muted mt-3">Contact (footer / pages)</h6>
	<div class="mb-3">
		<label class="form-label">Phone</label>
		<input type="text" name="contact_phone" class="form-control" value="<?php echo html_escape(cms_val($cms, 'contact_phone', '')); ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Email</label>
		<input type="email" name="contact_email" class="form-control" value="<?php echo html_escape(cms_val($cms, 'contact_email', '')); ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Address</label>
		<textarea name="contact_address" class="form-control" rows="2"><?php echo html_escape(cms_val($cms, 'contact_address', '')); ?></textarea>
	</div>
	<h6 class="text-uppercase text-xs text-muted mt-3">Newsletter block</h6>
	<div class="mb-3">
		<label class="form-label">Title</label>
		<input type="text" name="newsletter_title" class="form-control" value="<?php echo html_escape(cms_val($cms, 'newsletter_title', '')); ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Subtitle</label>
		<input type="text" name="newsletter_subtitle" class="form-control" value="<?php echo html_escape(cms_val($cms, 'newsletter_subtitle', '')); ?>">
	</div>
	<h6 class="text-uppercase text-xs text-muted mt-3">Integrations</h6>
	<div class="mb-3">
		<label class="form-label">Google Analytics (Measurement ID)</label>
		<input type="text" name="google_analytics_id" class="form-control" placeholder="G-XXXXXXXXXX" value="<?php echo html_escape(cms_val($cms, 'google_analytics_id', '')); ?>">
		<p class="text-xs text-muted mb-0">Inserted in the public site layout when non-empty.</p>
	</div>
	<div class="mb-3">
		<label class="form-label">Google Map embed (iframe HTML)</label>
		<textarea name="google_map_embed" class="form-control font-monospace" rows="3" placeholder="&lt;iframe ...&gt;&lt;/iframe&gt;"><?php echo html_escape(cms_val($cms, 'google_map_embed', '')); ?></textarea>
	</div>
	<div class="mb-3">
		<label class="form-label">WhatsApp float (full international number, no +)</label>
		<input type="text" name="whatsapp_float_number" class="form-control" placeholder="919876543210" value="<?php echo html_escape(cms_val($cms, 'whatsapp_float_number', '')); ?>">
	</div>
	<div class="mb-3 form-check">
		<input type="checkbox" name="pwa_enabled" value="1" class="form-check-input" id="pwa_enabled" <?php echo cms_val($cms, 'pwa_enabled', '0') === '1' ? 'checked' : ''; ?>>
		<label class="form-check-label" for="pwa_enabled">Enable PWA (manifest + service worker hooks)</label>
	</div>

	<h6 class="text-uppercase text-xs text-muted mt-3">Payment Gateway (Razorpay / Stripe)</h6>
	<div class="row g-2">
		<div class="col-md-6 mb-3">
			<label class="form-label">Razorpay Key ID</label>
			<input type="text" name="razorpay_key_id" class="form-control" value="<?php echo html_escape(cms_val($cms, 'razorpay_key_id', '')); ?>">
		</div>
		<div class="col-md-6 mb-3">
			<label class="form-label">Razorpay Secret</label>
			<input type="password" name="razorpay_key_secret" class="form-control" value="<?php echo html_escape(cms_val($cms, 'razorpay_key_secret', '')); ?>">
		</div>
		<div class="col-md-6 mb-3">
			<label class="form-label">Stripe Public Key</label>
			<input type="text" name="stripe_public_key" class="form-control" value="<?php echo html_escape(cms_val($cms, 'stripe_public_key', '')); ?>">
		</div>
		<div class="col-md-6 mb-3">
			<label class="form-label">Stripe Secret Key</label>
			<input type="password" name="stripe_secret_key" class="form-control" value="<?php echo html_escape(cms_val($cms, 'stripe_secret_key', '')); ?>">
		</div>
	</div>

	<h6 class="text-uppercase text-xs text-muted mt-3">Email (SMTP) Settings</h6>
	<div class="row g-2">
		<div class="col-md-6 mb-3">
			<label class="form-label">SMTP Host</label>
			<input type="text" name="smtp_host" class="form-control" value="<?php echo html_escape(cms_val($cms, 'smtp_host', '')); ?>">
		</div>
		<div class="col-md-3 mb-3">
			<label class="form-label">SMTP Port</label>
			<input type="text" name="smtp_port" class="form-control" value="<?php echo html_escape(cms_val($cms, 'smtp_port', '')); ?>">
		</div>
		<div class="col-md-3 mb-3">
			<label class="form-label">Encryption</label>
			<select name="smtp_crypto" class="form-select">
				<option value="" <?php echo cms_val($cms, 'smtp_crypto', '') === '' ? 'selected' : ''; ?>>None</option>
				<option value="tls" <?php echo cms_val($cms, 'smtp_crypto', '') === 'tls' ? 'selected' : ''; ?>>TLS</option>
				<option value="ssl" <?php echo cms_val($cms, 'smtp_crypto', '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
			</select>
		</div>
		<div class="col-md-6 mb-3">
			<label class="form-label">SMTP User</label>
			<input type="text" name="smtp_user" class="form-control" value="<?php echo html_escape(cms_val($cms, 'smtp_user', '')); ?>">
		</div>
		<div class="col-md-6 mb-3">
			<label class="form-label">SMTP Password</label>
			<input type="password" name="smtp_pass" class="form-control" value="<?php echo html_escape(cms_val($cms, 'smtp_pass', '')); ?>">
		</div>
	</div>

	<button type="submit" class="btn btn-primary mt-3">Save All Settings</button>
	<?php if (!$embed): ?>
		<a href="<?php echo site_url('cms/dashboard'); ?>" class="btn btn-link">Back</a>
	<?php endif; ?>
</form>
