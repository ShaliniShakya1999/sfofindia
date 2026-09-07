<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 font-weight-bolder">Activity Logs</h4>
                <p class="text-sm text-muted mb-0">System audit trail tracking admin and system actions.</p>
            </div>
            <?php if($this->session->userdata('cms_admin_role') === 'super_admin'): ?>
                <a href="javascript:void(0);" 
                   onclick="return confirmDelete('<?php echo site_url('activity_logs/clear'); ?>', 'This will wipe the entire history permanently!');" 
                   class="btn btn-outline-danger mb-0">
                    <i class="material-symbols-rounded align-middle me-1">delete_sweep</i> Clear History
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <h6 class="mb-0"><i class="material-symbols-rounded align-middle me-2 text-primary">history</i> Timeline</h6>
                </div>
                <div class="card-body p-4">
                    <div class="timeline timeline-one-side">
                        <?php if(empty($logs)): ?>
                            <div class="text-center py-4">
                                <i class="material-symbols-rounded text-muted" style="font-size:48px;">pending_actions</i>
                                <p class="text-muted mt-2">No activity logged yet.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($logs as $log): 
                                $action = strtolower($log['action']);
                                $icon = 'check_circle';
                                $color = 'info';

                                if (strpos($action, 'login') !== false) {
                                    $icon = 'login';
                                    $color = 'success';
                                } elseif (strpos($action, 'delete') !== false) {
                                    $icon = 'delete';
                                    $color = 'danger';
                                } elseif (strpos($action, 'insert') !== false || strpos($action, 'created') !== false) {
                                    $icon = 'add_circle';
                                    $color = 'primary';
                                } elseif (strpos($action, 'update') !== false) {
                                    $icon = 'edit';
                                    $color = 'warning';
                                }
                            ?>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step border-0 bg-<?php echo $color; ?> shadow-sm">
                                    <i class="material-symbols-rounded text-white text-sm"><?php echo $icon; ?></i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">
                                        <?php echo html_escape(ucwords(str_replace('_', ' ', $log['action']))); ?>
                                    </h6>
                                    <p class="text-xs text-muted mb-1 mt-1">
                                        <?php echo html_escape($log['detail'] ?? 'No additional details provided.'); ?>
                                    </p>
                                    <div class="d-flex align-items-center mt-2 flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-light text-dark border-radius-sm py-1 px-2 font-weight-bold" style="font-size:10px; border:1px solid #eee;">
                                                <i class="material-symbols-rounded text-xs align-middle me-1">person</i> <?php echo html_escape($log['username'] ?? 'System'); ?>
                                            </span>
                                            <?php if(isset($log['role'])): ?>
                                                <span class="text-xxs text-uppercase font-weight-bolder text-muted"><?php echo html_escape($log['role']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-xs text-secondary font-weight-bold ms-auto mb-0">
                                            <i class="material-symbols-rounded text-xs align-middle me-1">history</i> <?php echo date('d M, h:i A', strtotime($log['created_at'])); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* Simple CSS timeline overrides for Material Dashboard */
.timeline-one-side .timeline-step {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    left: 0;
    z-index: 1;
}
.timeline-one-side .timeline-content {
    margin-left: 45px;
    padding-bottom: 2rem;
    position: relative;
}
.timeline-one-side .timeline-block {
    position: relative;
    display: flex;
}
.timeline-one-side .timeline-block:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 32px;
    left: 15.5px;
    height: calc(100% - 32px);
    width: 2px;
    background: #e9ecef;
}
</style>
