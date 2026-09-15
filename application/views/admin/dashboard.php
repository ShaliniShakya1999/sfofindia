 <div class="container-fluid py-2">
      <!-- Executive Welcome Header -->
      <div class="row mb-3 stagger-item" style="animation-delay: 0.05s">
        <div class="col-12">
          <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 14px; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #ffffff;">
            <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
              <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                  <span class="badge bg-white text-dark rounded-pill px-2 py-1 text-xxs font-weight-bold">ADMIN PORTAL</span>
                  <span class="text-xs text-light opacity-8"><?= date('l, d F Y'); ?></span>
                </div>
                <h4 class="text-white font-weight-bolder mb-1">Welcome back, <?= html_escape($this->session->userdata('cms_admin_name') ?: 'Administrator'); ?></h4>
                <p class="text-xs text-light opacity-7 mb-0">NGO management hub: memberships, donations, campaigns, and web initiatives.</p>
              </div>
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="<?= site_url('members'); ?>" class="btn btn-sm btn-light mb-0 shadow-none text-nowrap font-weight-bold d-inline-flex align-items-center gap-1" style="border-radius: 8px;">
                  <i class="material-symbols-rounded text-sm">person_add</i>
                  <span>Members</span>
                </a>
                <a href="<?= site_url('donations'); ?>" class="btn btn-sm btn-outline-light mb-0 text-nowrap font-weight-bold d-inline-flex align-items-center gap-1" style="border-radius: 8px;">
                  <i class="material-symbols-rounded text-sm">payments</i>
                  <span>Donations</span>
                </a>
                <a href="<?= site_url('notifications'); ?>" class="btn btn-sm btn-outline-light mb-0 text-nowrap font-weight-bold d-inline-flex align-items-center gap-1" style="border-radius: 8px;">
                  <i class="material-symbols-rounded text-sm">notifications</i>
                  <span>Alerts</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Cards (Fully Clickable) -->
      <div class="row g-3">
        <!-- 1. Members -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-3 stagger-item" style="animation-delay: 0.1s">
          <a href="<?= site_url('members'); ?>" class="text-decoration-none text-reset d-block h-100 stat-card-link" title="Open member management">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border: 1px solid #edf2f7 !important;">
              <div class="card-body p-3 d-flex flex-column justify-content-between h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div>
                    <span class="text-xxs text-uppercase font-weight-bolder text-muted d-block mb-1">Total Members</span>
                    <h3 class="mb-0 font-weight-bolder text-dark"><?= isset($ngom_members_count) ? number_format((int)$ngom_members_count) : 0; ?></h3>
                  </div>
                  <div class="rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                    <i class="material-symbols-rounded" style="font-size: 22px;">group</i>
                  </div>
                </div>
                <div class="pt-2 border-top d-flex align-items-center justify-content-between mt-auto">
                  <span class="text-xs font-weight-bold text-primary d-inline-flex align-items-center gap-1 stat-card-action">
                    <span>Manage members</span>
                    <i class="material-symbols-rounded text-xs">arrow_forward</i>
                  </span>
                  <span class="badge bg-light text-secondary rounded-pill text-xxs font-weight-normal px-2">Registered</span>
                </div>
              </div>
            </div>
          </a>
        </div>

        <!-- 2. Donations -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-3 stagger-item" style="animation-delay: 0.15s">
          <a href="<?= site_url('donations'); ?>" class="text-decoration-none text-reset d-block h-100 stat-card-link" title="Open donation history & records">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border: 1px solid #edf2f7 !important;">
              <div class="card-body p-3 d-flex flex-column justify-content-between h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div>
                    <span class="text-xxs text-uppercase font-weight-bolder text-muted d-block mb-1">Donations</span>
                    <h3 class="mb-0 font-weight-bolder text-dark">
                      <?php if (isset($ngom_donations_total_inr)): ?>
                        ₹<?= number_format((float)$ngom_donations_total_inr, 0); ?>
                      <?php else: ?>
                        <?= isset($ngom_donations_count) ? (int)$ngom_donations_count : 0; ?>
                      <?php endif; ?>
                    </h3>
                  </div>
                  <div class="rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); color: #059669;">
                    <i class="material-symbols-rounded" style="font-size: 22px;">payments</i>
                  </div>
                </div>
                <div class="pt-2 border-top d-flex align-items-center justify-content-between mt-auto">
                  <span class="text-xs font-weight-bold text-success d-inline-flex align-items-center gap-1 stat-card-action">
                    <span>View donations</span>
                    <i class="material-symbols-rounded text-xs">arrow_forward</i>
                  </span>
                  <span class="badge bg-light text-secondary rounded-pill text-xxs font-weight-normal px-2"><?= isset($ngom_donations_count) ? (int)$ngom_donations_count . ' receipts' : 'Verified'; ?></span>
                </div>
              </div>
            </div>
          </a>
        </div>

        <!-- 3. Website CMS -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-3 stagger-item" style="animation-delay: 0.2s">
          <a href="<?= site_url('cms/dashboard?tab=settings'); ?>" class="text-decoration-none text-reset d-block h-100 stat-card-link" title="Open website settings">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border: 1px solid #edf2f7 !important;">
              <div class="card-body p-3 d-flex flex-column justify-content-between h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div>
                    <span class="text-xxs text-uppercase font-weight-bolder text-muted d-block mb-1">Website CMS</span>
                    <div class="d-flex align-items-center gap-2">
                      <h3 class="mb-0 font-weight-bolder text-dark">Live</h3>
                      <span class="badge rounded-pill text-xxs font-weight-bold px-2 py-1" style="background: rgba(16, 185, 129, 0.12); color: #059669;">● Online</span>
                    </div>
                  </div>
                  <div class="rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: rgba(14, 165, 233, 0.1); color: #0284c7;">
                    <i class="material-symbols-rounded" style="font-size: 22px;">language</i>
                  </div>
                </div>
                <div class="pt-2 border-top d-flex align-items-center justify-content-between mt-auto">
                  <span class="text-xs font-weight-bold text-info d-inline-flex align-items-center gap-1 stat-card-action">
                    <span>Website settings</span>
                    <i class="material-symbols-rounded text-xs">arrow_forward</i>
                  </span>
                  <span class="badge bg-light text-secondary rounded-pill text-xxs font-weight-normal px-2">CMS</span>
                </div>
              </div>
            </div>
          </a>
        </div>

        <!-- 4. Active Campaigns -->
        <div class="col-xl-3 col-sm-6 mb-3 stagger-item" style="animation-delay: 0.25s">
          <a href="<?= site_url('cms/dashboard?tab=campaigns'); ?>" class="text-decoration-none text-reset d-block h-100 stat-card-link" title="Open campaign management">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border: 1px solid #edf2f7 !important;">
              <div class="card-body p-3 d-flex flex-column justify-content-between h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div>
                    <span class="text-xxs text-uppercase font-weight-bolder text-muted d-block mb-1">Campaigns</span>
                    <h3 class="mb-0 font-weight-bolder text-dark"><?= isset($active_campaigns_count) ? (int)$active_campaigns_count : 0; ?></h3>
                  </div>
                  <div class="rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1); color: #d97706;">
                    <i class="material-symbols-rounded" style="font-size: 22px;">campaign</i>
                  </div>
                </div>
                <div class="pt-2 border-top d-flex align-items-center justify-content-between mt-auto">
                  <span class="text-xs font-weight-bold text-warning d-inline-flex align-items-center gap-1 stat-card-action">
                    <span>Manage campaigns</span>
                    <i class="material-symbols-rounded text-xs">arrow_forward</i>
                  </span>
                  <span class="badge bg-light text-secondary rounded-pill text-xxs font-weight-normal px-2">Active</span>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>

      <!-- Charts Section (Interactive) -->
      <div class="row mt-1">
        <!-- 1. Member Registrations Chart -->
        <div class="col-lg-4 col-md-6 mt-3 mb-3 stagger-item" style="animation-delay: 0.3s">
          <div class="card border-0 shadow-sm h-100 chart-card" style="border-radius: 14px; border: 1px solid #edf2f7 !important;">
            <div class="card-body p-3 pb-2 d-flex flex-column justify-content-between h-100">
              <div>
                <a href="<?= site_url('members'); ?>" class="text-decoration-none text-reset d-flex justify-content-between align-items-center mb-1 chart-card-header" title="Open member management">
                  <div>
                    <h6 class="mb-0 font-weight-bold text-dark chart-card-title">Member Registrations</h6>
                    <p class="text-xs text-muted mb-0">Daily registrations</p>
                  </div>
                  <span class="badge bg-light text-secondary rounded-pill px-2 py-1 text-xxs font-weight-bold border">Last 7 days</span>
                </a>
                <div class="d-flex align-items-baseline gap-2 mb-2 mt-1">
                  <span class="h4 font-weight-bolder text-dark mb-0"><?= number_format(array_sum($chart_members_data ?? [])); ?></span>
                  <span class="text-xxs text-muted text-uppercase font-weight-bold">new this week</span>
                </div>
                <div class="pe-1">
                  <div class="chart" style="height: 165px; position: relative;">
                    <canvas id="chart-bars" class="chart-canvas" height="165"
                      data-labels="<?php echo html_escape(json_encode($chart_members_labels ?? [])); ?>"
                      data-values="<?php echo html_escape(json_encode($chart_members_data ?? [])); ?>"></canvas>
                  </div>
                </div>
              </div>
              <a href="<?= site_url('members'); ?>" class="d-flex align-items-center justify-content-between text-xs text-muted pt-2 mt-2 border-top text-decoration-none chart-card-footer" title="Manage all registered members">
                <span class="d-inline-flex align-items-center">
                  <i class="material-symbols-rounded text-xs me-1" style="color: #1a685b;">group_add</i>
                  <span>Live registration counts</span>
                </span>
                <span class="font-weight-bold d-inline-flex align-items-center gap-1" style="color: #1a685b;">
                  <span>View members</span>
                  <i class="material-symbols-rounded text-xs">arrow_forward</i>
                </span>
              </a>
            </div>
          </div>
        </div>

        <!-- 2. Monthly Donations Chart -->
        <div class="col-lg-4 col-md-6 mt-3 mb-3 stagger-item" style="animation-delay: 0.35s">
          <div class="card border-0 shadow-sm h-100 chart-card" style="border-radius: 14px; border: 1px solid #edf2f7 !important;">
            <div class="card-body p-3 pb-2 d-flex flex-column justify-content-between h-100">
              <div>
                <a href="<?= site_url('donations'); ?>" class="text-decoration-none text-reset d-flex justify-content-between align-items-center mb-1 chart-card-header" title="Open donation history">
                  <div>
                    <h6 class="mb-0 font-weight-bold text-dark chart-card-title">Monthly Donations</h6>
                    <p class="text-xs text-muted mb-0">Collections (₹)</p>
                  </div>
                  <span class="badge bg-light text-secondary rounded-pill px-2 py-1 text-xxs font-weight-bold border">Last 6 months</span>
                </a>
                <div class="d-flex align-items-baseline gap-2 mb-2 mt-1">
                  <span class="h4 font-weight-bolder text-dark mb-0">₹<?= number_format(array_sum($chart_donations_data ?? [])); ?></span>
                  <span class="text-xxs text-muted text-uppercase font-weight-bold">total collected</span>
                </div>
                <div class="pe-1">
                  <div class="chart" style="height: 165px; position: relative;">
                    <canvas id="chart-line" class="chart-canvas" height="165"
                      data-labels="<?php echo html_escape(json_encode($chart_donations_labels ?? [])); ?>"
                      data-values="<?php echo html_escape(json_encode($chart_donations_data ?? [])); ?>"></canvas>
                  </div>
                </div>
              </div>
              <a href="<?= site_url('donations'); ?>" class="d-flex align-items-center justify-content-between text-xs text-muted pt-2 mt-2 border-top text-decoration-none chart-card-footer" title="Open donation receipts and records">
                <span class="d-inline-flex align-items-center">
                  <i class="material-symbols-rounded text-xs me-1 text-success">verified</i>
                  <span>Verified paid donations</span>
                </span>
                <span class="text-success font-weight-bold d-inline-flex align-items-center gap-1">
                  <span>View donations</span>
                  <i class="material-symbols-rounded text-xs">arrow_forward</i>
                </span>
              </a>
            </div>
          </div>
        </div>

        <!-- 3. Campaign Raised Chart -->
        <div class="col-lg-4 mt-3 mb-3 stagger-item" style="animation-delay: 0.4s">
          <div class="card border-0 shadow-sm h-100 chart-card" style="border-radius: 14px; border: 1px solid #edf2f7 !important;">
            <div class="card-body p-3 pb-2 d-flex flex-column justify-content-between h-100">
              <div>
                <a href="<?= site_url('cms/dashboard?tab=campaigns'); ?>" class="text-decoration-none text-reset d-flex justify-content-between align-items-center mb-1 chart-card-header" title="Open campaign management">
                  <div>
                    <h6 class="mb-0 font-weight-bold text-dark chart-card-title">Campaign Raised</h6>
                    <p class="text-xs text-muted mb-0">Top campaign funds</p>
                  </div>
                  <span class="badge bg-light text-secondary rounded-pill px-2 py-1 text-xxs font-weight-bold border">Top Funds</span>
                </a>
                <div class="d-flex align-items-baseline gap-2 mb-2 mt-1">
                  <span class="h4 font-weight-bolder text-dark mb-0">₹<?= number_format(array_sum($chart_campaigns_data ?? [])); ?></span>
                  <span class="text-xxs text-muted text-uppercase font-weight-bold">top campaigns tally</span>
                </div>
                <div class="pe-1">
                  <div class="chart" style="height: 165px; position: relative;">
                    <canvas id="chart-line-tasks" class="chart-canvas" height="165"
                      data-labels="<?php echo html_escape(json_encode($chart_campaigns_labels ?? [])); ?>"
                      data-values="<?php echo html_escape(json_encode($chart_campaigns_data ?? [])); ?>"></canvas>
                  </div>
                </div>
              </div>
              <a href="<?= site_url('cms/dashboard?tab=campaigns'); ?>" class="d-flex align-items-center justify-content-between text-xs text-muted pt-2 mt-2 border-top text-decoration-none chart-card-footer" title="Open campaigns in CMS">
                <span class="d-inline-flex align-items-center">
                  <i class="material-symbols-rounded text-xs me-1 text-warning">campaign</i>
                  <span>Real-time funds tally</span>
                </span>
                <span class="text-warning font-weight-bold d-inline-flex align-items-center gap-1">
                  <span>Manage campaigns</span>
                  <i class="material-symbols-rounded text-xs">arrow_forward</i>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Projects & Activity -->
      <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4 stagger-item" style="animation-delay: 0.5s">
          <div class="card">
            <div class="card-header pb-0 bg-transparent">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6 class="font-weight-bold">NGO Projects</h6>
                  <p class="text-sm mb-0">
                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                    <span class="font-weight-bold ms-1">Active initiatives</span> for the month
                  </p>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Feature</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Priority</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Goal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="dashboard-project-row" onclick="window.location.href='<?php echo html_escape(site_url('cms/dashboard?tab=projects')); ?>'" title="Open project management">
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><a href="<?php echo html_escape(site_url('cms/dashboard?tab=projects')); ?>" class="text-dark text-decoration-none">Martyr Family Support</a></h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-sm bg-gradient-info">Active</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> High </span>
                      </td>
                      <td class="align-middle">
                        <div class="progress-wrapper w-75 mx-auto">
                          <div class="progress">
                            <div class="progress-bar btn-primary w-85" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="dashboard-project-row" onclick="window.location.href='<?php echo html_escape(site_url('cms/dashboard?tab=projects')); ?>'" title="Open project management">
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><a href="<?php echo html_escape(site_url('cms/dashboard?tab=projects')); ?>" class="text-dark text-decoration-none">Education Initiative</a></h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-sm bg-gradient-success">Complete</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> Medium </span>
                      </td>
                      <td class="align-middle">
                        <div class="progress-wrapper w-75 mx-auto">
                          <div class="progress">
                            <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <style>
          .stat-card-link {
            cursor: pointer;
            display: block;
            outline: none;
          }
          .stat-card-link .card {
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
          }
          .stat-card-link:hover .card,
          .stat-card-link:focus .card {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
            border-color: rgba(79, 70, 229, 0.3) !important;
          }
          .stat-card-link:hover .stat-card-action {
            text-decoration: underline;
          }
          .chart-card {
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
            background: #ffffff;
          }
          .chart-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06) !important;
            border-color: rgba(26, 104, 91, 0.2) !important;
          }
          .chart-card-header {
            cursor: pointer;
            transition: opacity 0.15s ease;
          }
          .chart-card-header:hover .chart-card-title {
            color: #1a685b !important;
          }
          .chart-card-footer {
            cursor: pointer;
            transition: opacity 0.15s ease, background-color 0.15s ease;
          }
          .chart-card-footer:hover {
            opacity: 0.8;
          }
          .dashboard-project-row {
            cursor: pointer;
            transition: background-color 0.2s ease;
          }
          .dashboard-project-row:hover {
            background-color: #f1f5f9;
          }
        </style>

          <!-- Activity Feed -->
        <div class="col-lg-4 col-md-6 stagger-item" style="animation-delay: 0.55s">
          <div class="card h-100">
            <div class="card-header pb-0 bg-transparent">
              <h6 class="font-weight-bold">Recent Activity</h6>
              <p class="text-sm">
                Latest actions by admin users
              </p>
            </div>
            <div class="card-body p-3">
              <div class="timeline timeline-one-side">
                <?php if (!empty($recent_activities)): ?>
                  <?php foreach ($recent_activities as $act): ?>
                    <?php
                      $activity_action = strtolower((string) ($act['action'] ?? ''));
                      $activity_url = site_url('activity_logs');
                      if (strpos($activity_action, 'donation') !== false) {
                        $activity_url = site_url('donations');
                      } elseif (strpos($activity_action, 'campaign') !== false || strpos($activity_action, 'project') !== false) {
                        $activity_url = site_url('cms/dashboard') . '?tab=campaigns';
                      } elseif (strpos($activity_action, 'homepage') !== false || strpos($activity_action, 'settings') !== false) {
                        $activity_url = site_url('cms/dashboard') . '?tab=settings';
                      } elseif (strpos($activity_action, 'user') !== false) {
                        $activity_url = site_url('admin_users');
                      } elseif (strpos($activity_action, 'member') !== false) {
                        $activity_url = site_url('members');
                      }
                    ?>
                    <div class="timeline-block mb-3">
                      <span class="timeline-step">
                        <i class="material-symbols-rounded text-primary text-gradient">history</i>
                      </span>
                      <div class="timeline-content">
                        <a href="<?php echo html_escape($activity_url); ?>" class="d-block text-decoration-none" title="Open related section">
                          <h6 class="text-dark text-sm font-weight-bold mb-0"><?php echo html_escape($act['action']); ?>: <?php echo html_escape($act['detail']); ?></h6>
                          <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"><?php echo date('d M Y H:i', strtotime($act['created_at'])); ?></p>
                        </a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-muted text-sm">No recent activity.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Branded Footer -->
      <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>document.write(new Date().getFullYear())</script> 
                <strong>Shaheed Foundation Of India</strong>. 
                All Rights Reserved.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="<?= base_url(); ?>" class="nav-link text-muted" target="_blank">View Website</a>
                </li>
                <li class="nav-item">
                  <a href="<?= site_url('cms/dashboard'); ?>?tab=settings" class="nav-link text-muted">Portal Settings</a>
                </li>
                <li class="nav-item">
                  <a href="javascript:;" class="nav-link pe-0 text-muted">Help & Support</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div> 
