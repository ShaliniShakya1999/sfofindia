 <div class="container-fluid py-2">
      <!-- Title Section -->
      <div class="row mb-3 stagger-item" style="animation-delay: 0.1s">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">NGO Dashboard</h3>
          <p class="mb-0 text-muted">
            Overview & Management Hub
          </p>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 stagger-item" style="animation-delay: 0.15s">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <a href="<?php echo site_url('members'); ?>" class="text-decoration-none text-dark d-block" title="Open members">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Total Members</p>
                  <h4 class="mb-0"><?php echo isset($ngom_members_count) ? (int) $ngom_members_count : 0; ?></h4>
                </div>
                </a>
                <div class="icon icon-md icon-shape btn-primary shadow-primary text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">group</i>
                </div>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
              <p class="mb-0 text-sm"><a href="<?php echo site_url('members'); ?>" class="text-primary font-weight-bold">Manage members</a></p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 stagger-item" style="animation-delay: 0.2s">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <a href="<?php echo site_url('donations'); ?>" class="text-decoration-none text-dark d-block" title="Open donation history">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Donations</p>
                  <h4 class="mb-0"><?php echo isset($ngom_donations_count) ? (int) $ngom_donations_count : 0; ?></h4>
                </div>
                </a>
                <div class="icon icon-md icon-shape btn-primary shadow-primary text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">receipt_long</i>
                </div>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
              <p class="mb-0 text-sm">
                <?php if (isset($ngom_donations_total_inr)): ?>
                  <a href="<?php echo site_url('donations'); ?>" class="text-success font-weight-bolder">Total: ₹<?php echo number_format((float) $ngom_donations_total_inr, 2); ?></a>
                <?php else: ?>
                  <a href="<?php echo site_url('donations'); ?>" class="text-primary font-weight-bold">View donations</a>
                <?php endif; ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 stagger-item" style="animation-delay: 0.25s">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Website CMS</p>
                  <h4 class="mb-0">Live</h4>
                </div>
                <div class="icon icon-md icon-shape btn-primary shadow-primary text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">language</i>
                </div>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
              <p class="mb-0 text-sm"><a href="<?php echo site_url('cms/dashboard'); ?>?tab=settings" class="text-primary font-weight-bold">Website settings</a></p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 stagger-item" style="animation-delay: 0.3s">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Campaigns</p>
                  <h4 class="mb-0"><?php echo isset($active_campaigns_count) ? (int) $active_campaigns_count : 0; ?></h4>
                </div>
                <div class="icon icon-md icon-shape btn-primary shadow-primary text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">campaign</i>
                </div>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
              <p class="mb-0 text-sm"><a href="<?php echo site_url('cms/dashboard'); ?>?tab=campaigns" class="text-primary font-weight-bold">Manage campaigns</a></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="row">
        <div class="col-lg-4 col-md-6 mt-4 mb-4 stagger-item" style="animation-delay: 0.35s">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0 ">Member Registrations</h6>
              <p class="text-sm ">Last 7 days activity</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas" height="170"
                    data-labels="<?php echo html_escape(json_encode($chart_members_labels ?? [])); ?>"
                    data-values="<?php echo html_escape(json_encode($chart_members_data ?? [])); ?>"></canvas>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex ">
                <i class="material-symbols-rounded text-sm my-auto me-1">group_add</i>
                <p class="mb-0 text-sm"> Live registration counts </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4 stagger-item" style="animation-delay: 0.4s">
          <div class="card ">
            <div class="card-body">
              <h6 class="mb-0 "> Monthly Donations </h6>
              <p class="text-sm "> Collections (Last 6 months) </p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-line" class="chart-canvas" height="170"
                    data-labels="<?php echo html_escape(json_encode($chart_donations_labels ?? [])); ?>"
                    data-values="<?php echo html_escape(json_encode($chart_donations_data ?? [])); ?>"></canvas>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex ">
                <i class="material-symbols-rounded text-sm my-auto me-1">currency_rupee</i>
                <p class="mb-0 text-sm"> Verified paid donations </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mb-3 stagger-item" style="animation-delay: 0.45s">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0 ">Campaign Raised</h6>
              <p class="text-sm ">Top campaigns funds (₹)</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-line-tasks" class="chart-canvas" height="170"
                    data-labels="<?php echo html_escape(json_encode($chart_campaigns_labels ?? [])); ?>"
                    data-values="<?php echo html_escape(json_encode($chart_campaigns_data ?? [])); ?>"></canvas>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex ">
                <i class="material-symbols-rounded text-sm my-auto me-1">campaign</i>
                <p class="mb-0 text-sm">Real-time funds tally</p>
              </div>
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
