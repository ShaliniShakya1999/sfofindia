<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (!isset($embed)) {
	$embed = false;
}
?>
<form method="post" action="<?php echo site_url('cms/save_homepage'); ?>" class="card card-body border">
	<?php for ($s = 1; $s <= 3; $s++): ?>
		<?php $slide_img = cms_val($cms, 'slide'.$s.'_img', 'img/soldier1.avif'); ?>
		<h6 class="text-uppercase text-muted">Slide <?php echo $s; ?></h6>
		<div class="row">
			<div class="col-md-6 mb-2">
				<label class="form-label">Title</label>
				<input type="text" name="slide<?php echo $s; ?>_title" class="form-control" value="<?php echo html_escape(cms_val($cms, 'slide'.$s.'_title', '')); ?>">
			</div>
			<div class="col-md-6 mb-2">
				<label class="form-label">Slide image</label>
				<div class="d-flex gap-2 align-items-start flex-wrap">
					<div style="width:110px;">
						<img
							class="rounded border"
							style="width:110px;height:70px;object-fit:cover;"
							data-preview-for="slide<?php echo $s; ?>_img"
							alt=""
							src="<?php echo html_escape(preg_match('#^https?://#i', $slide_img) ? $slide_img : base_url($slide_img)); ?>"
						>
					</div>
					<div class="flex-grow-1" style="min-width:220px;">
						<input type="file" class="form-control cms-img-upload" accept="image/jpeg,image/png,image/gif,image/webp" data-target-input="slide<?php echo $s; ?>_img" data-max-bytes="4194304">
						<small class="text-muted d-block">Pehle preview dikhega — JPG / PNG / GIF / WEBP, max 4 MB.</small>
						<span class="cms-img-upload-msg text-danger small d-block mt-1"></span>
						<input type="text" name="slide<?php echo $s; ?>_img" class="form-control mt-2" readonly value="<?php echo html_escape(cms_val($cms, 'slide'.$s.'_img', '')); ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="mb-2">
			<label class="form-label">Text</label>
			<textarea name="slide<?php echo $s; ?>_text" class="form-control" rows="2"><?php echo html_escape(cms_val($cms, 'slide'.$s.'_text', '')); ?></textarea>
		</div>
		<div class="row mb-4">
			<div class="col-md-6 mb-2">
				<label class="form-label">Button 1 label</label>
				<input type="text" name="slide<?php echo $s; ?>_btn1" class="form-control" value="<?php echo html_escape(cms_val($cms, 'slide'.$s.'_btn1', '')); ?>">
			</div>
			<div class="col-md-6 mb-2">
				<label class="form-label">Button 2 label</label>
				<input type="text" name="slide<?php echo $s; ?>_btn2" class="form-control" value="<?php echo html_escape(cms_val($cms, 'slide'.$s.'_btn2', '')); ?>">
			</div>
		</div>
	<?php endfor; ?>

	<?php $about_img = cms_val($cms, 'about_image', 'img/images.jpg'); ?>
	<h6 class="text-uppercase text-muted">About section</h6>
	<div class="mb-2">
		<label class="form-label">Section label</label>
		<input type="text" name="about_label" class="form-control" value="<?php echo html_escape(cms_val($cms, 'about_label', '')); ?>">
	</div>
	<div class="mb-2">
		<label class="form-label">Heading</label>
		<input type="text" name="about_heading" class="form-control" value="<?php echo html_escape(cms_val($cms, 'about_heading', '')); ?>">
	</div>
	<div class="mb-2">
		<label class="form-label">Paragraph</label>
		<textarea name="about_p1" class="form-control" rows="3"><?php echo html_escape(cms_val($cms, 'about_p1', '')); ?></textarea>
	</div>
	<div class="mb-2">
		<label class="form-label">Quote</label>
		<input type="text" name="about_quote" class="form-control" value="<?php echo html_escape(cms_val($cms, 'about_quote', '')); ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">About image</label>
		<div class="d-flex gap-2 align-items-start flex-wrap">
			<div style="width:110px;">
				<img
					class="rounded border"
					style="width:110px;height:70px;object-fit:cover;"
					data-preview-for="about_image"
					alt=""
					src="<?php echo html_escape(preg_match('#^https?://#i', $about_img) ? $about_img : base_url($about_img)); ?>"
				>
			</div>
			<div class="flex-grow-1" style="min-width:220px;">
				<input type="file" class="form-control cms-img-upload" accept="image/jpeg,image/png,image/gif,image/webp" data-target-input="about_image" data-max-bytes="4194304">
				<small class="text-muted d-block">Preview — JPG / PNG / GIF / WEBP, max 4 MB.</small>
				<span class="cms-img-upload-msg text-danger small d-block mt-1"></span>
				<input type="text" name="about_image" class="form-control mt-2" readonly value="<?php echo html_escape(cms_val($cms, 'about_image', '')); ?>">
			</div>
		</div>
	</div>

	<h6 class="text-uppercase text-muted">What we do (4 lines)</h6>
	<?php for ($w = 1; $w <= 4; $w++): ?>
		<div class="mb-2">
			<input type="text" name="what_we_do_<?php echo $w; ?>" class="form-control" value="<?php echo html_escape(cms_val($cms, 'what_we_do_'.$w, '')); ?>">
		</div>
	<?php endfor; ?>

	<div class="mb-3">
		<label class="form-label">Donation box text</label>
		<textarea name="donation_box_text" class="form-control" rows="2"><?php echo html_escape(cms_val($cms, 'donation_box_text', '')); ?></textarea>
	</div>

	<button type="submit" class="btn btn-primary">Save homepage</button>
	<?php if (!$embed): ?>
		<a href="<?php echo site_url('cms/dashboard'); ?>" class="btn btn-link">Back</a>
	<?php endif; ?>
</form>

<script>
(function () {
	var uploadUrl = <?php echo json_encode(site_url('cms/upload_image')); ?>;
	if (window.NgomImageUpload) {
		window.NgomImageUpload.bindAjaxUploads('.cms-img-upload', uploadUrl);
	}
})();
</script>
