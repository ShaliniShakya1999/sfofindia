<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <h5 class="mb-3"><?php echo isset($stitle) ? html_escape($stitle) : 'Blog'; ?></h5>
      <?php if ($this->session->flashdata('errors')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('errors'); ?></div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-warning"><?php echo $this->session->flashdata('error'); ?></div>
      <?php endif; ?>

      <form action="<?php echo site_url('add_blog/updsave' . (!empty($id) ? '?id=' . urlencode($id) : '')); ?>" method="post" enctype="multipart/form-data" class="card card-body">
        <?php echo form_hidden('oldlogo', isset($image) ? $image : ''); ?>
        <div class="mb-3">
          <label class="form-label">Heading *</label>
          <input type="text" name="heading" class="form-control" value="<?php echo isset($heading) ? html_escape($heading) : ''; ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Slug</label>
          <input type="text" name="slug" class="form-control" value="<?php echo isset($slug) ? html_escape($slug) : ''; ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Meta title</label>
          <input type="text" name="metaTitle" class="form-control" value="<?php echo isset($metaTitle) ? html_escape($metaTitle) : ''; ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Meta description</label>
          <textarea name="metaDescription" class="form-control" rows="2"><?php echo isset($metaDescription) ? html_escape($metaDescription) : ''; ?></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Meta keywords</label>
          <input type="text" name="metaKeyword" class="form-control" value="<?php echo isset($metaKeyword) ? html_escape($metaKeyword) : ''; ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="6"><?php echo isset($description) ? html_escape($description) : ''; ?></textarea>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Posted by</label>
            <input type="text" name="postedBy" class="form-control" value="<?php echo isset($postedBy) ? html_escape($postedBy) : ''; ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Posted date</label>
            <input type="text" name="postedDate" class="form-control" value="<?php echo isset($postedDate) ? html_escape($postedDate) : ''; ?>">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Image</label>
          <div class="d-flex flex-wrap gap-3 align-items-start">
            <div class="border rounded overflow-hidden bg-light" style="width:140px;height:90px;">
              <?php
              $imgv = isset($image) ? trim((string) $image) : '';
              $imgu = '';
              if ($imgv !== '') {
                $imgu = (preg_match('#^https?://#i', $imgv) || (isset($imgv[0]) && $imgv[0] === '/')) ? $imgv : base_url('uploads/' . $imgv);
              }
              ?>
              <img id="addblog_img_preview" src="<?php echo $imgu !== '' ? html_escape($imgu) : ''; ?>" alt="" class="w-100 h-100" style="object-fit:cover;<?php echo $imgu === '' ? 'display:none;' : ''; ?>">
            </div>
            <div class="flex-grow-1" style="min-width:220px;">
              <input type="file" name="image" id="addblog_img_input" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" data-max-bytes="4194304">
              <small class="text-muted d-block mt-1">JPG / PNG / GIF / WEBP — max 4 MB, preview pehle dikhega.</small>
              <span class="cms-img-upload-msg text-danger small d-block mt-1"></span>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <?php $st = isset($status) ? $status : 'Active'; ?>
            <option value="Active" <?php echo $st === 'Active' ? 'selected' : ''; ?>>Active</option>
            <option value="Inactive" <?php echo $st === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo isset($button) ? html_escape($button) : 'Submit'; ?></button>
        <a href="<?php echo site_url('View_blog'); ?>" class="btn btn-outline-secondary">Back to list</a>
      </form>
    </div>
  </div>
</div>
<script>
(function () {
  var inp = document.getElementById('addblog_img_input');
  var prev = document.getElementById('addblog_img_preview');
  if (!inp || !prev || !window.NgomImageUpload) return;
  var msgEl = inp.closest('.flex-grow-1') && inp.closest('.flex-grow-1').querySelector('.cms-img-upload-msg');
  inp.addEventListener('change', function () {
    if (msgEl) msgEl.textContent = '';
    if (!inp.files || !inp.files[0]) return;
    var f = inp.files[0];
    var maxB = parseInt(inp.getAttribute('data-max-bytes') || '4194304', 10);
    var v = window.NgomImageUpload.validate(f, maxB);
    if (!v.ok) {
      if (msgEl) msgEl.textContent = v.error;
      else alert(v.error);
      inp.value = '';
      return;
    }
    window.NgomImageUpload.preview(f, prev);
  });
})();
</script>
