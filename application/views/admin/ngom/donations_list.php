<?php defined('BASEPATH') OR exit('No direct script access allowed');
$table_ok = isset($table_ok) ? $table_ok : false;
$rows = isset($rows) ? $rows : array();
$total_count = isset($total_count) ? (int) $total_count : 0;
$total_amount = isset($total_amount) ? (float) $total_amount : 0.0;
$chart_labels = isset($chart_labels) ? $chart_labels : '[]';
$chart_data = isset($chart_data) ? $chart_data : '[]';
?>
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 font-weight-bolder">Donations & Financials</h4>
            <p class="text-sm text-muted mb-0">Total donation dashboard, tracking, and analytics.</p>
        </div>
        <div>
            <a href="<?php echo site_url('donations/export_csv'); ?>" class="btn btn-outline-dark btn-sm mb-0">Export CSV</a>
            <button type="button" class="btn bg-gradient-primary btn-sm mb-0 ms-2" data-bs-toggle="modal" data-bs-target="#manualDonationModal">
                <i class="material-symbols-rounded text-sm align-middle me-1">add</i> Add Manual
            </button>
        </div>
    </div>

    <!-- Analytics Dashboard Top Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg mx-auto mb-3">
                        <i class="material-symbols-rounded opacity-10 mt-2">account_balance_wallet</i>
                    </div>
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Paid Amount</p>
                    <h4 class="mb-0 font-weight-bolder">₹<?php echo number_format($total_amount, 2); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg mx-auto mb-3">
                        <i class="material-symbols-rounded opacity-10 mt-2">receipt_long</i>
                    </div>
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Successful Transactions</p>
                    <h4 class="mb-0 font-weight-bolder"><?php echo number_format($total_count); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px; overflow:hidden;">
                <div class="card-body p-3">
                    <h6 class="mb-0">Revenue (Last 6 Months)</h6>
                    <div style="height: 120px; width: 100%;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtering Panel -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
        <div class="card-body p-3">
            <form method="get" action="<?php echo site_url('donations'); ?>" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label text-xs font-weight-bold mb-0">Status</label>
                    <select name="status" class="form-select border px-2 py-1">
                        <option value="">All</option>
                        <option value="paid" <?php echo ($this->input->get('status') === 'paid') ? 'selected' : ''; ?>>Paid</option>
                        <option value="created" <?php echo ($this->input->get('status') === 'created') ? 'selected' : ''; ?>>Pending / Failed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-xs font-weight-bold mb-0">From Date</label>
                    <input type="date" name="date_from" class="form-control border px-2 py-1" value="<?php echo html_escape($this->input->get('date_from')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-xs font-weight-bold mb-0">To Date</label>
                    <input type="date" name="date_to" class="form-control border px-2 py-1" value="<?php echo html_escape($this->input->get('date_to')); ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark btn-sm mb-0 w-100">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <?php if ($table_ok): ?>
        <div class="card border-0 shadow-sm" style="border-radius:15px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Donor Details</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $r): ?>
                                <tr class="border-bottom border-light">
                                    <td class="px-4">
                                        <p class="text-xs font-weight-bold mb-0"><?php echo date('d M Y', strtotime($r['created_at'])); ?></p>
                                        <p class="text-xxs text-muted mb-0"><?php echo date('h:i A', strtotime($r['created_at'])); ?></p>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><?php echo html_escape($r['name']); ?></h6>
                                                <p class="text-xs text-secondary mb-0"><?php echo html_escape($r['email']); ?> | <?php echo html_escape($r['mobile']); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">₹<?php echo number_format((float) $r['amount'], 2); ?></p>
                                        <p class="text-xxs text-secondary mb-0">Receipt: <?php echo html_escape($r['receipt_no'] ?? 'N/A'); ?></p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-<?php echo ($r['status'] === 'paid') ? 'success' : 'secondary'; ?> rounded-pill">
                                            <?php echo html_escape(ucfirst($r['status'])); ?>
                                        </span>
                                    </td>
                                    <td class="text-end px-4">
                                        <?php if ($r['status'] === 'paid'): ?>
                                            <a class="btn btn-link text-dark px-2 mb-0" target="_blank" href="<?php echo site_url('donations/receipt_pdf/' . (int) $r['id']); ?>" title="Download Receipt PDF">
                                                <i class="material-symbols-rounded text-sm me-1">download</i> PDF
                                            </a>
                                            <a href="javascript:;" onclick="alert('Refund API not linked yet');" class="btn btn-link text-danger px-2 mb-0" title="Issue Refund">
                                                <i class="material-symbols-rounded text-sm me-1">money_off</i> Refund
                                            </a>
                                        <?php else: ?>
                                            <span class="text-xs text-muted">No Actions</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($rows)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="p-3">
                                            <i class="material-symbols-rounded text-muted" style="font-size: 48px;">receipt_long</i>
                                            <h6 class="mt-3 text-secondary">No donations found.</h6>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Manual Donation Modal -->
<div class="modal fade" id="manualDonationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-radius-lg border-0 shadow-lg">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold"><i class="material-symbols-rounded align-middle text-primary me-1">add_circle</i> Add Manual Donation</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close" style="font-size: 1.5rem;">&times;</button>
            </div>
            <form action="<?php echo site_url('donations/add_manual'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold mb-1">Donor Name</label>
                        <input type="text" name="name" class="form-control border px-2 py-2" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-xs font-weight-bold mb-1">Email</label>
                            <input type="email" name="email" class="form-control border px-2 py-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-xs font-weight-bold mb-1">Mobile</label>
                            <input type="text" name="mobile" class="form-control border px-2 py-2">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold mb-1">Amount (₹)</label>
                        <input type="number" name="amount" class="form-control border px-2 py-2" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Save Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var chartLabels = <?php echo $chart_labels; ?>;
    var chartData = <?php echo $chart_data; ?>;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: "Revenue (₹)",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 2,
                pointBackgroundColor: "#cb0c9f",
                borderColor: "#cb0c9f",
                borderWidth: 3,
                backgroundColor: 'rgba(203, 12, 159, 0.2)',
                fill: true,
                data: chartData,
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            interaction: { intersect: false, mode: 'index' },
            scales: {
                y: {
                    grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false },
                    ticks: { display: false }
                },
                x: {
                    grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false },
                    ticks: { display: true, color: '#b2b9bf', padding: 10, font: { size: 10 } }
                },
            },
        },
    });
});
</script>
