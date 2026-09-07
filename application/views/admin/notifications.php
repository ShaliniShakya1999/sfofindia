<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-0 font-weight-bolder">System Notifications</h4>
            <p class="text-sm text-muted mb-4">Stay updated with automatic system events and administrative alerts.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <h6 class="mb-0 font-weight-bold"><i class="material-symbols-rounded align-middle me-2">notifications_active</i> All Alerts</h6>
                </div>
                <div class="card-body p-4">
                    <?php if(empty($notifications)): ?>
                        <div class="text-center py-5">
                            <i class="material-symbols-rounded text-muted opacity-3" style="font-size: 60px;">mail_outline</i>
                            <p class="text-muted mt-3">No new notifications at this time.</p>
                        </div>
                    <?php else: ?>
                        <div class="timeline timeline-one-side">
                            <?php foreach($notifications as $n): 
                                $color = $n['type'] ?? 'info';
                                $icon = 'info';
                                if($color === 'success') $icon = 'check_circle';
                                if($color === 'warning') $icon = 'warning';
                                if($color === 'danger') $icon = 'error';
                            ?>
                            <div class="timeline-block mb-4 <?php echo $n['is_read'] ? 'opacity-6' : ''; ?>">
                                <span class="timeline-step bg-gradient-<?php echo $color; ?> shadow-sm">
                                    <i class="material-symbols-rounded text-white text-sm"><?php echo $icon; ?></i>
                                </span>
                                <div class="timeline-content">
                                    <div class="d-flex align-items-center">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">
                                            <?php echo html_escape($n['title']); ?>
                                            <?php if(!$n['is_read']): ?>
                                                <span class="badge badge-xs bg-gradient-primary ms-2">New</span>
                                            <?php endif; ?>
                                        </h6>
                                        <div class="ms-auto">
                                            <?php if(!$n['is_read']): ?>
                                                <a href="<?php echo site_url('notifications/mark_read/'.$n['id']); ?>" class="btn btn-link text-secondary text-xs mb-0 p-0 me-2" title="Mark as Read">
                                                    <i class="material-symbols-rounded text-sm">done_all</i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?php echo site_url('notifications/delete/'.$n['id']); ?>" class="btn btn-link text-danger text-xs mb-0 p-0" title="Delete" onclick="return confirm('Remove notification?');">
                                                <i class="material-symbols-rounded text-sm">delete</i>
                                            </a>
                                        </div>
                                    </div>
                                    <p class="text-xs text-secondary mt-1 mb-2">
                                        <?php echo date('d M Y, h:i A', strtotime($n['created_at'])); ?>
                                    </p>
                                    <p class="text-sm text-dark mb-0">
                                        <?php echo html_escape($n['message']); ?>
                                    </p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.timeline-one-side .timeline-step {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    left: 0;
    z-index: 1;
}
.timeline-one-side .timeline-content {
    margin-left: 55px;
    padding-bottom: 25px;
    position: relative;
    border-bottom: 1px solid #f8f9fa;
}
.timeline-one-side .timeline-block {
    position: relative;
    display: flex;
}
.timeline-one-side .timeline-block:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 38px;
    left: 18px;
    height: calc(100% - 38px);
    width: 2px;
    background: #e9ecef;
}
</style>
