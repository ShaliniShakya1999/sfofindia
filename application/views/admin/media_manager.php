<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4 min-vh-80">
    <div class="row align-items-center mb-4">
        <div class="col-8">
            <h4 class="mb-0 font-weight-bolder">Media Assets</h4>
            <p class="text-sm text-muted mb-0">Browse and manage cloud-stored images, documents, and assets.</p>
        </div>
        <div class="col-4 text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5 justify-content-end text-xs">
                    <li class="breadcrumb-item"><a class="opacity-5 text-dark" href="<?php echo site_url('media_manager'); ?>"><i class="material-symbols-rounded align-middle">home</i></a></li>
                    <?php if(!empty($current_path)): ?>
                        <?php 
                        $parts = explode('/', $current_path); 
                        $accum = '';
                        foreach($parts as $p): $accum .= $p.'/'; 
                        ?>
                            <li class="breadcrumb-item text-dark active font-weight-bold" aria-current="page"><?php echo $p; ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Directories Section -->
    <div class="row mb-5">
        <?php if (!empty($directories)): ?>
            <?php foreach ($directories as $dir): ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4 stagger-item">
                    <a href="<?php echo site_url('media_manager?path=' . rawurlencode($dir['path'])); ?>" class="text-decoration-none">
                        <div class="card glass-folder border-0 shadow-sm overflow-hidden h-100">
                            <div class="card-body p-3 text-center">
                                <div class="folder-icon-wrapper mb-2">
                                    <i class="material-symbols-rounded text-primary display-4 opacity-8">folder</i>
                                </div>
                                <h6 class="text-xs text-dark font-weight-bold mb-0 text-truncate"><?php echo $dir['name']; ?></h6>
                                <p class="text-xxs text-muted mb-0"><?php echo count($dir['children'] ?? []); ?> Items</p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Files Gallery -->
    <div class="row">
        <?php if (!empty($files)): ?>
            <?php foreach ($files as $f): 
                $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                $fullUrl = base_url($f['path']);
            ?>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 stagger-item">
                    <div class="card media-card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="position-relative media-canvas">
                            <?php if ($isImage): ?>
                                <img src="<?php echo $fullUrl; ?>" class="card-img-top media-preview" alt="<?php echo $f['name']; ?>">
                                <div class="media-overlay d-flex align-items-center justify-content-center">
                                    <a href="<?php echo $fullUrl; ?>" target="_blank" class="btn btn-white btn-sm shadow-sm mb-0">
                                        <i class="material-symbols-rounded align-middle me-1">zoom_in</i> View Full
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="card-img-top media-preview bg-gray-100 d-flex align-items-center justify-content-center">
                                    <i class="material-symbols-rounded display-1 text-secondary opacity-3">description</i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Delete Button -->
                            <div class="position-absolute top-0 end-0 p-2 z-index-2">
                                <form action="<?php echo site_url('media_manager/delete'); ?>" method="post" onsubmit="return confirmAction(this, 'Permanently Delete?', 'This file will be removed from your server forever.');">
                                    <input type="hidden" name="file_path" value="<?php echo $f['path']; ?>">
                                    <button type="submit" class="btn btn-dark opacity-4 hover-opacity-10 btn-sm shadow-none p-1 rounded-circle mb-0" style="width:24px; height:24px; line-height:1;">
                                        <i class="material-symbols-rounded text-xs">close</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="text-xs text-dark font-weight-bold mb-0 text-truncate" title="<?php echo $f['name']; ?>">
                                    <?php echo $f['name']; ?>
                                </h6>
                                <span class="badge bg-light text-xxs text-dark border-0"><?php echo round($f['size'] / 1024, 2); ?> KB</span>
                            </div>
                            <div class="input-group input-group-sm mb-0">
                                <input type="text" class="form-control text-xxs p-1 bg-gray-100 border-0" value="<?php echo $fullUrl; ?>" id="url-<?php echo md5($f['name']); ?>" readonly>
                                <button class="btn btn-outline-primary mb-0 p-1 px-2" type="button" onclick="copyToClipboard('url-<?php echo md5($f['name']); ?>')">
                                    <i class="material-symbols-rounded text-xs">content_copy</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-8 stagger-item">
                <div class="mb-4">
                    <i class="material-symbols-rounded text-gray-200 display-1">folder_off</i>
                </div>
                <h5 class="text-muted font-weight-light">No assets found in this folder.</h5>
                <p class="text-sm text-secondary">Upload images or documents via the post editors to see them here.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function copyToClipboard(id) {
    var copyText = document.getElementById(id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    
    // Toast notification
    Swal.fire({
        text: 'URL copied to clipboard!',
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
}
</script>

<style>
.stagger-item { opacity: 0; animation: slideUp 0.5s ease forwards; }
.stagger-item:nth-child(2) { animation-delay: 0.1s; }
.stagger-item:nth-child(3) { animation-delay: 0.2s; }
.stagger-item:nth-child(4) { animation-delay: 0.3s; }
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

.glass-folder {
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
}
.glass-folder:hover {
    transform: translateY(-5px);
    background: white !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.media-card {
    transition: all 0.3s ease;
    border-radius: 12px;
}
.media-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;
}

.media-canvas {
    height: 180px;
    background: #fdfdfd;
}
.media-preview {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 10px;
}
.media-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.2);
    opacity: 0;
    transition: all 0.3s ease;
    backdrop-filter: blur(2px);
}
.media-card:hover .media-overlay { opacity: 1; }

.hover-opacity-10:hover { opacity: 1 !important; }
</style>
