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
        var tooltipConfig = {
            backgroundColor: "#0f172a",
            titleColor: "#ffffff",
            bodyColor: "#e2e8f0",
            borderColor: "rgba(255, 255, 255, 0.08)",
            borderWidth: 1,
            cornerRadius: 8,
            padding: { top: 8, bottom: 8, left: 12, right: 12 },
            displayColors: false,
            titleFont: { size: 11, weight: "600", family: "'Inter', -apple-system, sans-serif" },
            bodyFont: { size: 12, weight: "500", family: "'Inter', -apple-system, sans-serif" }
        };

        // --- Donation Trend Chart ---
        var elD = document.getElementById("donationChart");
        if (elD) {
            var ctx1 = elD.getContext("2d");
            new Chart(ctx1, {
                type: "line",
                data: {
                    labels: <?php echo $months_js; ?>,
                    datasets: [{
                        label: "Donations (₹)",
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 3.5,
                        pointHoverRadius: 6,
                        pointBackgroundColor: "#ffffff",
                        pointHoverBackgroundColor: "#0d9488",
                        pointBorderColor: "#0d9488",
                        pointHoverBorderColor: "#ffffff",
                        borderColor: "#0d9488",
                        backgroundColor: function(context) {
                            var chart = context.chart;
                            var ctx = chart.ctx;
                            var chartArea = chart.chartArea;
                            if (!chartArea) return "rgba(13, 148, 136, 0.1)";
                            var gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, "rgba(13, 148, 136, 0.28)");
                            gradient.addColorStop(0.7, "rgba(13, 148, 136, 0.06)");
                            gradient.addColorStop(1, "rgba(13, 148, 136, 0.00)");
                            return gradient;
                        },
                        fill: true,
                        data: <?php echo $donation_trends_js; ?>
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: Object.assign({}, tooltipConfig, {
                            callbacks: {
                                label: function(c) {
                                    return "Donations: ₹" + Number(c.raw || 0).toLocaleString("en-IN");
                                }
                            }
                        })
                    },
                    scales: {
                        y: {
                            min: 0,
                            beginAtZero: true,
                            grid: { borderDash: [4, 4], drawBorder: false, color: '#f1f5f9' },
                            ticks: {
                                padding: 8,
                                color: '#94a3b8',
                                font: { size: 11, family: "'Inter', -apple-system, sans-serif" },
                                callback: function(val) {
                                    if (val < 0) return '';
                                    if (val === 0) return '₹0';
                                    if (val >= 1000) return '₹' + (val / 1000) + 'k';
                                    return '₹' + val;
                                }
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { padding: 8, color: '#94a3b8', font: { size: 11, family: "'Inter', -apple-system, sans-serif" } }
                        },
                    },
                },
            });
        }

        // --- Member Acquisition Chart ---
        var elM = document.getElementById("memberChart");
        if (elM) {
            var ctx2 = elM.getContext("2d");
            new Chart(ctx2, {
                type: "bar",
                data: {
                    labels: <?php echo $months_js; ?>,
                    datasets: [{
                        label: "Members",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 6,
                        borderSkipped: false,
                        backgroundColor: function(context) {
                            var chart = context.chart;
                            var ctx = chart.ctx;
                            var chartArea = chart.chartArea;
                            if (!chartArea) return "rgba(26, 104, 91, 0.85)";
                            var gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, "rgba(26, 104, 91, 0.95)");
                            gradient.addColorStop(1, "rgba(26, 104, 91, 0.45)");
                            return gradient;
                        },
                        hoverBackgroundColor: "#134e4a",
                        data: <?php echo $member_growth_js; ?>,
                        barThickness: 16,
                        maxBarThickness: 22
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: Object.assign({}, tooltipConfig, {
                            callbacks: {
                                label: function(c) {
                                    var count = Number(c.raw || 0);
                                    return count + (count === 1 ? " member" : " members");
                                }
                            }
                        })
                    },
                    scales: {
                        y: {
                            min: 0,
                            beginAtZero: true,
                            grid: { borderDash: [4, 4], drawBorder: false, color: '#f1f5f9' },
                            ticks: { precision: 0, stepSize: 1, padding: 8, color: '#94a3b8', font: { size: 11, family: "'Inter', -apple-system, sans-serif" } }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { padding: 8, color: '#94a3b8', font: { size: 11, family: "'Inter', -apple-system, sans-serif" } }
                        },
                    },
                },
            });
        }
    });
</script>
