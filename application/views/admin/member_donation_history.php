<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 font-weight-bolder">My Donation History</h5>
                        <p class="text-xs text-muted mb-0">Track all your contributions to the foundation.</p>
                    </div>
                    <a href="<?php echo site_url('admin/donation'); ?>" class="btn btn-sm bg-gradient-indigo rounded-pill shadow-primary mb-0">+ New Donation</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2 mt-4">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="text-uppercase text-indigo text-xxs font-weight-bolder opacity-7 px-4">Receipt No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Method</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Document</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($history)): ?>
                                    <?php foreach ($history as $row): ?>
                                        <tr class="border-bottom border-light">
                                            <td class="px-4">
                                                <div class="d-flex px-0 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm font-weight-bold text-dark"><?php echo html_escape($row['receipt_no'] ?: '—'); ?></h6>
                                                        <p class="text-xxs text-muted mb-0">Ref: <?php echo html_escape($row['payment_id'] ?: 'N/A'); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 text-secondary"><?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                                                <p class="text-xxs text-muted mb-0"><?php echo date('h:i A', strtotime($row['created_at'])); ?></p>
                                            </td>
                                            <td>
                                                <span class="text-sm font-weight-bolder text-dark">₹<?php echo number_format($row['amount'], 2); ?></span>
                                            </td>
                                            <td>
                                                <span class="text-xs bg-light rounded-pill px-2 py-1 text-secondary font-weight-bold">
                                                    <?php echo strpos($row['payment_id'], 'MANUAL') !== false ? 'Manual' : 'Online'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($row['status'] === 'paid'): ?>
                                                    <span class="badge badge-sm bg-gradient-success rounded-pill px-3">Success</span>
                                                <?php else: ?>
                                                    <span class="badge badge-sm bg-gradient-secondary rounded-pill px-3"><?php echo html_escape($row['status']); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php if ($row['status'] === 'paid'): ?>
                                                    <a href="<?php echo site_url('donations/receipt_pdf/' . (int) $row['id']); ?>" target="_blank" class="btn btn-link text-indigo px-3 mb-0" style="text-decoration: none;">
                                                        <i class="material-symbols-rounded text-sm me-1">picture_as_pdf</i> PDF Receipt
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-xs text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="p-3">
                                                <i class="material-symbols-rounded text-muted" style="font-size: 64px;">history</i>
                                                <h6 class="mt-3 text-secondary">No donation history found.</h6>
                                                <p class="text-sm text-muted">Start your contribution journey today!</p>
                                                <a href="<?php echo site_url('admin/donation'); ?>" class="btn btn-indigo rounded-pill mt-2">Make a Donation</a>
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
    </div>
</div>

<style>
.bg-gradient-indigo { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
.text-indigo { color: #4f46e5 !important; }
.btn-indigo { background-color: #4f46e5; color: #fff; }
.shadow-primary { box-shadow: 0 4px 6px rgba(79, 70, 229, 0.4); }
</style>
