<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4 min-vh-80">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-6">
            <h4 class="mb-0 font-weight-bolder text-dark">Photo Gallery 🖼️</h4>
            <p class="text-sm text-muted mb-0">Manage visual memories of your events, campaigns, and social work.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="d-flex justify-content-md-end gap-2">
                <button onclick="document.getElementById('galleryUpload').click()" class="btn bg-gradient-primary mb-0">
                    <i class="material-symbols-rounded align-middle me-1">upload_file</i> Upload Photos
                </button>
                <input type="file" id="galleryUpload" class="d-none" multiple accept="image/*">
            </div>
        </div>
    </div>

    <!-- Upload Progress Bar (Hidden by default) -->
    <div id="progressWrapper" class="row mb-4 d-none">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-xs font-weight-bold">Uploading...</span>
                        <span class="text-xs font-weight-bold" id="progressText">0%</span>
                    </div>
                    <div class="progress progress-md">
                        <div class="progress-bar bg-gradient-primary" id="progressBar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:15px; background: rgba(255,255,255,0.6); backdrop-filter: blur(10px);">
        <div class="card-body p-4">
            <div class="row g-4" id="galleryGrid">
                <?php if(!empty($images)): foreach($images as $img): ?>
                <div class="col-6 col-md-4 col-lg-3 gallery-item">
                    <div class="position-relative overflow-hidden border-radius-lg shadow-sm bg-white" style="transition: all 0.3s ease;">
                        <?php 
                            $raw_img = (string)$img['image_path'];
                            $final_src = '';
                            if ($raw_img !== '') {
                                if (strpos($raw_img, 'http') === 0) {
                                    $final_src = $raw_img;
                                } elseif (strpos($raw_img, 'uploads/') === 0 || strpos($raw_img, 'img/') === 0) {
                                    $final_src = base_url($raw_img);
                                } else {
                                    // Default to uploads/ if no prefix
                                    $final_src = base_url('uploads/' . $raw_img);
                                }
                            }
                        ?>
                        <img src="<?php echo $final_src; ?>" class="img-fluid border-radius-lg" alt="gallery" style="width:100%; height:200px; object-fit:cover;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0 hover-overlay" style="background: rgba(0,0,0,0.4); transition: 0.3s; cursor:pointer;">
                             <div class="d-flex gap-2">
                                <a href="<?php echo base_url($img['image_path']); ?>" target="_blank" class="btn btn-icon-only btn-rounded btn-outline-white mb-0">
                                    <i class="material-symbols-rounded">visibility</i>
                                </a>
                                <button onclick="confirmDelete(<?php echo $img['id']; ?>)" class="btn btn-icon-only btn-rounded btn-outline-white mb-0">
                                    <i class="material-symbols-rounded">delete</i>
                                </button>
                             </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <div class="col-12 text-center py-5" id="no-images">
                    <div class="mb-3">
                        <i class="material-symbols-rounded text-6xl text-gray-200">photo_library</i>
                    </div>
                    <h5 class="text-muted">No photos in gallery. Click "Upload" to get started!</h5>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .gallery-item:hover .hover-overlay { opacity: 1 !important; }
    .gallery-item:hover .position-relative { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .bg-gradient-primary { background: linear-gradient(135deg, #e91e63 0%, #9c27b0 100%); border:0; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Remove photo?',
        text: "This will permanently delete the image from the gallery.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e91e63',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?php echo site_url('gallery_manager/delete/'); ?>' + id;
        }
    })
}

// Multi-upload handler
document.getElementById('galleryUpload').onchange = function() {
    const files = Array.from(this.files);
    if (!files.length) return;

    const wrapper = document.getElementById('progressWrapper');
    const bar = document.getElementById('progressBar');
    const text = document.getElementById('progressText');
    const grid = document.getElementById('galleryGrid');
    const emptyMsg = document.getElementById('no-images');

    wrapper.classList.remove('d-none');
    
    let uploadedCount = 0;
    
    const uploadFile = (file) => {
        const formData = new FormData();
        formData.append('file', file);

        return fetch('<?php echo site_url('gallery_manager/upload'); ?>', {
            method: 'POST',
            body: formData
        }).then(res => res.json());
    };

    const processUploads = async () => {
        for (let i = 0; i < files.length; i++) {
            try {
                const res = await uploadFile(files[i]);
                if (res.ok) {
                    if(emptyMsg) emptyMsg.remove();
                    // Just a reload for now to keep it simple and clean, 
                    // or we could append dynamically.
                }
            } catch (err) {
                console.error(err);
            }
            uploadedCount++;
            const percent = Math.round((uploadedCount / files.length) * 100);
            bar.style.width = percent + '%';
            text.innerText = percent + '%';
        }
        
        setTimeout(() => {
            window.location.reload();
        }, 500);
    };

    processUploads();
};
</script>
