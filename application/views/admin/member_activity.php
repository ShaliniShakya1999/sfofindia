<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:15px; background: linear-gradient(135deg,#0ea5e9,#6366f1);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                            <i class="material-symbols-rounded text-white" style="font-size:32px;">history</i>
                        </div>
                        <div>
                            <h4 class="text-white mb-0 font-weight-bolder">My Activity</h4>
                            <p class="text-white opacity-8 mb-0 text-sm">A full timeline of your contributions & actions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Stats Row -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius:12px;">
                <div class="icon icon-shape bg-gradient-primary shadow-primary border-radius-md mx-auto mb-3">
                    <i class="material-symbols-rounded opacity-10">payments</i>
                </div>
                <h3 class="font-weight-bolder mb-0">
                    ₹<?php
                        $tot = 0;
                        foreach ($donations as $d) { if ($d['status'] === 'paid') $tot += $d['amount']; }
                        echo number_format($tot, 0);
                    ?>
                </h3>
                <p class="text-sm text-muted mb-0">Total Donated</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius:12px;">
                <div class="icon icon-shape bg-gradient-success shadow-success border-radius-md mx-auto mb-3">
                    <i class="material-symbols-rounded opacity-10">receipt_long</i>
                </div>
                <h3 class="font-weight-bolder mb-0"><?php echo count($donations); ?></h3>
                <p class="text-sm text-muted mb-0">Total Donations</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius:12px;">
                <div class="icon icon-shape bg-gradient-warning shadow-warning border-radius-md mx-auto mb-3">
                    <i class="material-symbols-rounded opacity-10">verified</i>
                </div>
                <h3 class="font-weight-bolder mb-0 text-success">Active</h3>
                <p class="text-sm text-muted mb-0">Membership Status</p>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="font-weight-bolder mb-0">Activity Timeline</h6>
                    <p class="text-xs text-muted mb-0">All your recorded actions</p>
                </div>
                <div class="card-body p-4">
                    <div class="timeline timeline-one-side">

                        <!-- Member Join Event -->
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-symbols-rounded text-success text-gradient">how_to_reg</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Joined as Member</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    <?php echo !empty($member['verified_at']) ? date('d M Y', strtotime($member['verified_at'])) : 'Account Created'; ?>
                                </p>
                                <p class="text-sm mt-1 mb-0 text-secondary">
                                    Your membership was activated. Member ID: <b><?php echo html_escape($member['member_id_code'] ?? 'N/A'); ?></b>
                                </p>
                            </div>
                        </div>

                        <?php if (!empty($donations)): ?>
                            <?php foreach ($donations as $don): ?>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-<?php echo $don['status'] === 'paid' ? 'success' : 'secondary'; ?> text-gradient">
                                            <?php echo $don['status'] === 'paid' ? 'payments' : 'pending'; ?>
                                        </i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">
                                            Donation <?php echo $don['status'] === 'paid' ? 'Successful' : ucfirst($don['status']); ?>
                                        </h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            <?php echo date('d M Y, h:i A', strtotime($don['created_at'])); ?>
                                        </p>
                                        <p class="text-sm mt-1 mb-0 text-secondary">
                                            Amount: <b>₹<?php echo number_format($don['amount'], 2); ?></b>
                                            &nbsp;|&nbsp; Receipt: <b><?php echo html_escape($don['receipt_no'] ?: 'N/A'); ?></b>
                                            <?php if ($don['status'] === 'paid'): ?>
                                                &nbsp;<a href="<?php echo site_url('donations/receipt_pdf/' . (int)$don['id']); ?>" target="_blank" class="text-xs text-primary">
                                                    <i class="material-symbols-rounded text-xs align-middle">picture_as_pdf</i> PDF
                                                </a>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="material-symbols-rounded text-muted" style="font-size:48px;">hourglass_empty</i>
                                <p class="text-sm text-muted mt-2">No donation activity yet. Start contributing!</p>
                                <a href="<?php echo site_url('admin/donation'); ?>" class="btn btn-sm btn-primary rounded-pill">Make a Donation</a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
