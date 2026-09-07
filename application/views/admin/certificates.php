<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4 min-vh-80">
    <div class="row align-items-center mb-4">
        <div class="col-12">
            <h4 class="mb-0 font-weight-bolder">Generate Certificates 📜</h4>
            <p class="text-sm text-muted mb-0">Create custom ad-hoc certificates for volunteers, donors, or guests instantly.</p>
        </div>
    </div>

    <div class="row">
        <!-- Generator Form -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                <div class="card-header pb-0 bg-transparent border-0 px-4 pt-4">
                    <h6 class="mb-0 font-weight-bold"><i class="material-symbols-rounded align-middle me-2 text-primary">universal_currency_alt</i> Instant Generator</h6>
                </div>
                <div class="card-body p-4">
                    <!-- Form targets a hidden iframe for same-page generation -->
                    <form action="<?php echo site_url('certificates/generate_custom'); ?>" method="post" target="pdf_frame" id="certForm">
                        <div class="mb-3">
                            <label class="form-label text-dark font-weight-bold text-xs text-uppercase">Recipient Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control border px-3 py-2" placeholder="e.g. Shalini Shakya" required id="nameInput">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-dark font-weight-bold text-xs text-uppercase">Certificate Title</label>
                            <input type="text" name="title" class="form-control border px-3 py-2" placeholder="e.g. Certificate of Appreciation">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark font-weight-bold text-xs text-uppercase">Certificate Description Body</label>
                            <textarea name="body" class="form-control border px-3 py-2" rows="4" placeholder="This certificate is presented in recognition of valuable support..."></textarea>
                        </div>

                        <div class="alert alert-info border-0 text-white shadow-sm mt-4 p-3 d-none d-lg-block" style="border-radius:12px;">
                            <div class="d-flex align-items-center">
                                <i class="material-symbols-rounded me-2">info</i>
                                <p class="text-xs mb-0">PDF will be generated and previewed instantly on the right side.</p>
                            </div>
                        </div>

                        <button type="submit" class="btn bg-gradient-primary w-100 mt-3 py-3" id="generateBtn">
                            <i class="material-symbols-rounded align-middle me-1">workspace_premium</i> Generate & Preview
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4 border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3 text-center">
                    <p class="text-xs text-muted mb-0">Need member certificates? <a href="<?php echo site_url('members/verified'); ?>" class="text-primary font-weight-bold">Go to Verified Members</a></p>
                </div>
            </div>
        </div>

        <!-- Live Preview Pane -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100 mb-4" style="border-radius:15px; min-height: 600px;">
                <!-- Empty State -->
                <div id="previewPlaceholder" class="card-body d-flex flex-column justify-content-center align-items-center text-center p-5">
                    <div class="mb-4 bg-gray-100 rounded-circle d-flex align-items-center justify-content-center" style="width:100px; height:100px;">
                        <i class="material-symbols-rounded text-gray-400 display-4">picture_as_pdf</i>
                    </div>
                    <h5 class="font-weight-bold text-dark">Live Certificate Preview</h5>
                    <p class="text-sm text-muted px-lg-5">Fill in the form on the left and click Generate. Your certificate will appear here instantly for review.</p>
                </div>

                <!-- Loading State -->
                <div id="previewLoader" class="card-body d-none flex-column justify-content-center align-items-center text-center p-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h6>Generating your PDF...</h6>
                </div>

                <!-- Iframe Preview -->
                <div id="previewFrameContainer" class="card-body d-none p-0 h-100">
                    <iframe name="pdf_frame" id="pdf_frame" class="w-100 border-0" style="height: 600px; border-radius:15px;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('certForm').onsubmit = function() {
    if(document.getElementById('nameInput').value.trim() === '') return false;
    
    // Switch UI states
    document.getElementById('previewPlaceholder').classList.add('d-none');
    document.getElementById('previewLoader').classList.remove('d-none');
    document.getElementById('previewFrameContainer').classList.add('d-none');
    
    // The target="pdf_frame" will handle the iframe load
    return true;
};

document.getElementById('pdf_frame').onload = function() {
    // Only show the container if it's not the initial blank load
    if (document.getElementById('certForm').getAttribute('target') === 'pdf_frame') {
        document.getElementById('previewLoader').classList.add('d-none');
        document.getElementById('previewFrameContainer').classList.remove('d-none');
    }
};
</script>

<style>
#pdf_frame {
    background: #f8f9fa;
}
.form-control:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
}
</style>
