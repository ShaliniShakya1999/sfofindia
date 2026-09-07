<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <form action="<?php echo site_url('blog_manager/save'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="old_image" value="<?php echo $blog['image']; ?>">

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center">
                            <a href="<?php echo site_url('blog_manager'); ?>" class="btn btn-link text-secondary p-0 mb-0 me-3">
                                <i class="material-symbols-rounded text-lg">arrow_back</i>
                            </a>
                            <h4 class="mb-0 font-weight-bolder"><?php echo $title; ?></h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label font-weight-bold text-dark">Blog Heading <span class="text-danger">*</span></label>
                            <input type="text" name="heading" class="form-control form-control-lg border shadow-xs" 
                                   placeholder="Enter catchy headline..." value="<?php echo html_escape($blog['heading']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold text-dark">URL Slug</label>
                            <input type="text" name="slug" class="form-control border shadow-xs" 
                                   placeholder="url-friendly-slug (optional)" value="<?php echo html_escape($blog['slug']); ?>">
                            <small class="text-muted">If left blank, it will be auto-generated from heading.</small>
                        </div>

                        <div class="mb-0">
                            <label class="form-label font-weight-bold text-dark">Description / Content</label>
                            <textarea name="description" id="editor" class="form-control border shadow-xs" rows="15"><?php echo $blog['description']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h6 class="mb-0 font-weight-bold"><i class="material-symbols-rounded align-middle me-2 text-primary">search</i> Search Engine Optimization (SEO)</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-dark text-xs">Meta Title</label>
                            <input type="text" name="metaTitle" class="form-control border shadow-xs" value="<?php echo html_escape($blog['metaTitle']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-dark text-xs">Meta Description</label>
                            <textarea name="metaDescription" class="form-control border shadow-xs" rows="3"><?php echo html_escape($blog['metaDescription']); ?></textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label font-weight-bold text-dark text-xs">Meta Keywords</label>
                            <input type="text" name="metaKeyword" class="form-control border shadow-xs" value="<?php echo html_escape($blog['metaKeyword']); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h6 class="mb-0 font-weight-bold"><i class="material-symbols-rounded align-middle me-2 text-primary">publish</i> Status & Publishing</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-dark text-xs">Publishing Status</label>
                            <select name="status" class="form-select border shadow-xs">
                                <option value="Active" <?php echo ($blog['status'] == 'Active') ? 'selected' : ''; ?>>Published (Live)</option>
                                <option value="Inactive" <?php echo ($blog['status'] == 'Inactive') ? 'selected' : ''; ?>>Draft (Hidden)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-dark text-xs">Posted By</label>
                            <input type="text" name="postedBy" class="form-control border shadow-xs" value="<?php echo html_escape($blog['postedBy']); ?>">
                        </div>
                        <div class="mb-0">
                            <label class="form-label font-weight-bold text-dark text-xs">Posted Date</label>
                            <input type="date" name="postedDate" class="form-control border shadow-xs" value="<?php echo $blog['postedDate']; ?>">
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h6 class="mb-0 font-weight-bold"><i class="material-symbols-rounded align-middle me-2 text-primary">image</i> Featured Image</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <?php if(!empty($blog['image'])): ?>
                                <img src="<?php echo base_url('uploads/'.$blog['image']); ?>" id="preview" class="img-fluid border-radius-lg shadow-sm" alt="preview">
                            <?php else: ?>
                                <div id="preview-placeholder" class="border-2 border-dashed border-radius-lg p-5 text-center bg-light">
                                    <i class="material-symbols-rounded text-4xl text-secondary">add_photo_alternate</i>
                                    <p class="text-xs text-muted mb-0">Selection preview will appear here</p>
                                </div>
                                <img src="" id="preview" class="img-fluid border-radius-lg shadow-sm d-none" alt="preview">
                            <?php endif; ?>
                        </div>
                        <div class="mb-0">
                            <input type="file" name="image" id="fileInput" class="form-control border shadow-xs" accept="image/*">
                            <p class="text-xxs text-muted mt-2 mb-0">Recommended size: 1200x630px. Max size: 2MB.</p>
                        </div>
                    </div>
                </div>

                <div class="sticky-top" style="top: 20px; z-index: 1;">
                    <button type="submit" class="btn bg-gradient-primary btn-lg w-100 mb-0 shadow-md">
                        <i class="material-symbols-rounded align-middle me-2">save</i> Save Publication
                    </button>
                    <a href="<?php echo site_url('blog_manager'); ?>" class="btn btn-outline-secondary btn-lg w-100 mt-2">Discard Changes</a>
                </div>
            </div>
        </div>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
<script>
    // Initialize Quill
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Mirror Quill data to hidden textarea on form submit
    document.querySelector('form').onsubmit = function() {
        document.querySelector('textarea[name=description]').value = quill.root.innerHTML;
    };

    // File Preview
    document.getElementById('fileInput').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('preview-placeholder');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
            if(placeholder) placeholder.classList.add('d-none');
        }
    }
</script>
<style>
    .ql-container { min-height: 350px; font-size: 16px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; }
    .ql-toolbar { border-top-left-radius: 10px; border-top-right-radius: 10px; }
</style>
