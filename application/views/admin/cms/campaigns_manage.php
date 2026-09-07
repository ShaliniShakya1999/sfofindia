<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$rows = isset($ngom_campaigns) && is_array($ngom_campaigns) ? $ngom_campaigns : array();
$role = isset($cms_role) ? $cms_role : 'admin';
$can = function_exists('ngom_can_manage_ngom_content') ? ngom_can_manage_ngom_content($role) : false;
?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 font-weight-bolder">Crowdfunding Campaigns</h4>
            <p class="text-sm text-muted mb-0">Manage campaign cards for the public site.</p>
        </div>
    </div>

    <?php if ($can): ?>
    <div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
        <div class="card-header bg-transparent border-0 pb-0">
            <h6 class="mb-0">Add New Campaign</h6>
        </div>
        <div class="card-body p-4">
            <form method="post" action="<?php echo site_url('cms/ngom_save'); ?>" class="row g-3" id="campaignForm">
                <input type="hidden" name="table" value="ngom_campaigns">
                <!-- Redirect back to the standalone page instead of tab -->
                <input type="hidden" name="redirect_custom" value="cms/campaigns_manage">
                
                <div class="col-md-6">
                    <label class="form-label form-control-label">Title</label>
                    <div class="input-group input-group-outline">
                        <input type="text" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label form-control-label">Goal Amount (₹)</label>
                    <div class="input-group input-group-outline">
                        <input type="number" step="0.01" name="goal_amount" class="form-control" value="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label form-control-label">Raised (display text)</label>
                    <div class="input-group input-group-outline">
                        <input type="text" name="raised_display" class="form-control" placeholder="e.g. ₹2.5L">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label form-control-label">Image Upload</label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="hidden" name="image" id="campaign_image_path">
                        <input type="file" id="campaign_image_file" accept=".jpg,.jpeg,.png,.webp" style="display:none;">
                        <button type="button" class="btn btn-outline-primary btn-sm mb-0 rounded-pill d-flex align-items-center" onclick="document.getElementById('campaign_image_file').click();">
                            <i class="material-symbols-rounded me-1 text-sm">cloud_upload</i> Browse File
                        </button>
                        <span id="upload_status" class="text-xs text-muted">No file selected</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label form-control-label">Status</label>
                    <div class="input-group input-group-outline">
                        <select name="status" class="form-select border px-2 py-2 w-100">
                            <option value="active">Active</option>
                            <option value="ended">Ended</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-12">
                    <label class="form-label form-control-label">Description</label>
                    <div class="input-group input-group-outline">
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="col-12 text-end">
                    <button type="submit" class="btn bg-gradient-primary rounded-pill px-5 mb-0">Save Campaign</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="border-radius:15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">ID / Title</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Goal</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Progress</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                            <?php if ($can): ?><th class="text-secondary opacity-7"></th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($rows as $r): ?>
                                <?php 
                                    $goal = (float) $r['goal_amount'];
                                    $raised = (float) ($r['raised_amount'] ?? 0);
                                    $percent = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
                                ?>
                                <tr class="border-bottom border-light">
                                    <td class="px-4">
                                        <div class="d-flex px-0 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold text-dark">#<?php echo (int) $r['id']; ?> - <?php echo html_escape($r['title']); ?></h6>
                                                <?php if(!empty($r['image'])): ?>
                                                    <a href="<?php echo base_url($r['image']); ?>" target="_blank" class="text-xxs text-primary"><i class="material-symbols-rounded text-xxs align-middle">image</i> View Image</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bolder text-dark">₹<?php echo number_format($goal); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="text-xs font-weight-bold me-2"><?php echo $percent; ?>%</span>
                                            <div class="progress w-100" style="height:6px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percent; ?>%;"></div>
                                            </div>
                                        </div>
                                        <small class="text-xxs text-muted">₹<?php echo number_format($raised); ?> Raised</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-gradient-<?php echo $r['status'] === 'active' ? 'success' : 'secondary'; ?> rounded-pill px-3"><?php echo html_escape(ucfirst($r['status'])); ?></span>
                                    </td>
                                    <?php if ($can): ?>
                                        <td class="text-end px-4">
                                            <a href="<?php echo site_url('cms/ngom_delete'); ?>?table=ngom_campaigns&amp;id=<?php echo (int) $r['id']; ?>&amp;redirect_custom=cms/campaigns_manage" class="text-danger font-weight-bold text-xs" onclick="return confirm('Are you sure you want to delete this campaign?');">
                                                <i class="material-symbols-rounded text-sm align-middle">delete</i> Delete
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php if (empty($rows)): ?>
                            <tr>
                                <td colspan="<?php echo $can ? 5 : 4; ?>" class="text-center py-5">
                                    <div class="p-3">
                                        <i class="material-symbols-rounded text-muted" style="font-size: 64px;">campaign</i>
                                        <h6 class="mt-3 text-secondary">No campaigns found.</h6>
                                        <p class="text-sm text-muted">Start adding campaigns to see them here.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var fileInput = document.getElementById('campaign_image_file');
    var pathInput = document.getElementById('campaign_image_path');
    var statusText = document.getElementById('upload_status');

    if(fileInput) {
        fileInput.addEventListener('change', function() {
            var file = this.files[0];
            if (!file) return;

            statusText.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Uploading...';
            
            var fd = new FormData();
            fd.append('image', file);

            fetch('<?php echo site_url("cms/upload_image"); ?>', {
                method: 'POST',
                body: fd
            })
            .then(res => res.json())
            .then(data => {
                if (data.ok) {
                    pathInput.value = data.path;
                    statusText.innerHTML = '<span class="text-success"><i class="material-symbols-rounded text-sm align-middle">check_circle</i> Uploaded!</span>';
                } else {
                    statusText.innerHTML = '<span class="text-danger">' + (data.error || 'Upload failed') + '</span>';
                }
            })
            .catch(err => {
                statusText.innerHTML = '<span class="text-danger">Network error</span>';
            });
        });
    }
});
</script>
<style>
.form-control-label { font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px; color: #7b809a; }
</style>
