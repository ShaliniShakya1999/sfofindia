<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-0 font-weight-bolder">Organization Analytics</h4>
            <p class="text-sm text-muted mb-4">Deep dive into membership growth and financial performance.</p>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-xs mb-0 text-capitalize font-weight-bold">Total Members</p>
                            <h5 class="font-weight-bolder mb-0"><?php echo number_format($total_members); ?></h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 mt-2">groups</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-xs mb-0 text-capitalize font-weight-bold">Active Users</p>
                            <h5 class="font-weight-bolder mb-0"><?php echo number_format($active_members); ?></h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 mt-2">verified</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-xs mb-0 text-capitalize font-weight-bold">Total Raised</p>
                            <h5 class="font-weight-bolder mb-0">₹<?php echo number_format($total_donations, 2); ?></h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 mt-2">payments</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-xs mb-0 text-capitalize font-weight-bold">Campaigns</p>
                            <h5 class="font-weight-bolder mb-0"><?php echo number_format($total_campaigns); ?></h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="material-symbols-rounded opacity-10 mt-2">campaign</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <!-- Revenue Chart -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header pb-0 bg-transparent border-0 pt-4 px-4">
                    <h6 class="mb-0 font-weight-bold">Donation Growth (Last 6 Months)</h6>
                    <p class="text-xs text-muted mb-0">Track monthly contribution trends.</p>
                </div>
                <div class="card-body p-4">
                    <div style="height: 300px;">
                        <canvas id="donationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Member Growth Chart -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header pb-0 bg-transparent border-0 pt-4 px-4">
                    <h6 class="mb-0 font-weight-bold">New Member Acquisitions</h6>
                    <p class="text-xs text-muted mb-0">System additions over time.</p>
                </div>
                <div class="card-body p-4">
                    <div style="height: 300px;">
                        <canvas id="memberChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- campaigns summary -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header pb-0 bg-transparent border-0 pt-4 px-4">
                    <h6 class="mb-0 font-weight-bold">Top Active Campaigns</h6>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Budget</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Completion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($campaigns as $c): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><?php echo html_escape($c['title']); ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">₹<?php echo number_format($c['goal_amount'], 2); ?></span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">0%</span> <!-- Placeholder -->
                                                </div>
                                            </div>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-info w-0" role="progressbar"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- Donation Trend Chart ---
        var ctx1 = document.getElementById("donationChart").getContext("2d");
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: <?php echo $months_js; ?>,
                datasets: [{
                    label: "Donations (₹)",
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    borderColor: "#4bb2ff",
                    backgroundColor: "transparent",
                    fill: false,
                    data: <?php echo $donation_trends_js; ?>,
                    maxBarThickness: 6
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { borderDash: [5, 5], drawBorder: false }, ticks: { padding: 10, color: '#b2b9bf', font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { padding: 10, color: '#b2b9bf', font: { size: 11 } } },
                },
            },
        });

        // --- Member Acquisition Chart ---
        var ctx2 = document.getElementById("memberChart").getContext("2d");
        new Chart(ctx2, {
            type: "bar",
            data: {
                labels: <?php echo $months_js; ?>,
                datasets: [{
                    label: "Members",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "#cb0c9f",
                    data: <?php echo $member_growth_js; ?>,
                    maxBarThickness: 10
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { borderDash: [5, 5], drawBorder: false }, ticks: { padding: 10, color: '#b2b9bf', font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { padding: 10, color: '#b2b9bf', font: { size: 11 } } },
                },
            },
        });
    });
</script>
