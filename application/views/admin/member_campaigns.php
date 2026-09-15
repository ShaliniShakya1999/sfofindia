<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 font-weight-bolder">Active Campaigns</h5>
                        <p class="text-xs text-muted mb-0">Support an ongoing cause below.</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($campaigns)): ?>
                        <div class="row g-4">
                        <?php foreach($campaigns as $camp): ?>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100" style="border-radius:12px; overflow:hidden;">
                                    <div class="card-body p-4">
                                        <div class="border-radius-md p-3 mb-3 d-inline-block" style="background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%); color: #fff; box-shadow: 0 4px 10px rgba(26, 104, 91, 0.25);">
                                            <i class="material-symbols-rounded text-white">campaign</i>
                                        </div>
                                        <h6 class="font-weight-bolder mb-1"><?php echo html_escape($camp['title'] ?? 'Campaign'); ?></h6>
                                        <p class="text-xs text-muted mb-3"><?php echo html_escape($camp['description'] ?? 'Support this cause.'); ?></p>
                                        <a href="<?php echo site_url('donation'); ?>" class="btn btn-sm w-100 rounded-pill" style="background: #1a685b; color: #fff; border: none; box-shadow: 0 2px 6px rgba(26, 104, 91, 0.25);">Donate Now</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="material-symbols-rounded text-muted" style="font-size:60px;">campaign</i>
                            <h6 class="mt-3 text-secondary">No active campaigns right now.</h6>
                            <p class="text-sm text-muted">Check back soon for new opportunities to make an impact!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
