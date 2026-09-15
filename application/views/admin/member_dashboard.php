<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$status_raw = strtolower($member['status'] ?? 'pending');
$validity_end = !empty($member['validity_end']) ? $member['validity_end'] : null;
$is_expired = ($validity_end && strtotime($validity_end) < time());

if ($is_expired || $status_raw === 'inactive') {
    $status_label = 'Expired';
    $status_class = 'text-danger';
    $status_icon = 'error';
    $status_badge_bg = 'bg-gradient-danger shadow-danger';
    $status_sub = $validity_end ? 'Ended ' . date('d M, Y', strtotime($validity_end)) : 'Renewal needed';
    $status_link = site_url('admin/renew');
    $status_action_text = 'Renew Membership';
    $status_action_color = 'text-danger';
} elseif ($status_raw === 'active') {
    $status_label = 'Active';
    $status_class = 'text-success';
    $status_icon = 'verified';
    $status_badge_bg = 'bg-gradient-success shadow-success';
    $status_sub = $validity_end ? 'Till ' . date('d M, Y', strtotime($validity_end)) : 'Lifetime / Active';
    $status_link = site_url('admin/profile');
    $status_action_text = 'View Profile';
    $status_action_color = 'text-success';
} else {
    $status_label = ucfirst($status_raw);
    $status_class = 'text-warning';
    $status_icon = 'pending';
    $status_badge_bg = 'bg-gradient-warning shadow-warning';
    $status_sub = 'Verification in review';
    $status_link = site_url('admin/profile');
    $status_action_text = 'Check Status';
    $status_action_color = 'text-warning';
}
?>
<div class="container-fluid py-4">
    <!-- --- HEADER SECTION --- -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?php echo site_url('admin/profile'); ?>" class="text-decoration-none text-reset d-block" title="Click to view and edit your profile">
                <div class="card border-0 shadow-sm overflow-hidden welcome-banner-interactive" style="border-radius: 15px; background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%); cursor: pointer;">
                    <div class="card-body p-4 position-relative">
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-7 text-white">
                                <h3 class="text-white mb-1 font-weight-bolder">Welcome, <?php echo html_escape($member['name']); ?>!</h3>
                                <p class="text-white opacity-8 mb-0">
                                    Member ID: <strong><?php echo html_escape($member['member_id_code'] ?? 'SFI-' . date('Y') . '-' . $member['id']); ?></strong> | 
                                    Role: <span class="badge bg-white text-xs" style="color: #1a685b;"><?php echo strtoupper($member['role'] ?? 'MEMBER'); ?></span>
                                    <?php if ($validity_end): ?>
                                    | Validity: <span class="badge <?php echo $is_expired ? 'bg-danger text-white' : 'bg-success text-white'; ?> text-xs"><?php echo date('d M, Y', strtotime($validity_end)); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-5 text-end d-flex align-items-center justify-content-end position-relative z-index-1 mt-3 mt-md-0">
                                <span class="btn btn-sm btn-white rounded-pill mb-0 font-weight-bold shadow-sm d-inline-flex align-items-center me-2 banner-profile-btn" style="color: #1a685b !important;">
                                    <i class="material-symbols-rounded text-sm me-1">person</i> View Profile <i class="material-symbols-rounded text-sm ms-1">arrow_forward</i>
                                </span>
                                <i class="material-symbols-rounded text-white opacity-2 d-none d-md-block" style="font-size: 80px; position: absolute; right: -15px; top: -35px; pointer-events: none;">verified</i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <?php if ($is_expired || $status_raw === 'inactive'): ?>
    <!-- --- MEMBERSHIP EXPIRY WARNING --- -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning text-white d-flex align-items-center justify-content-between p-3" style="border-radius: 12px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="d-flex align-items-center">
                    <i class="material-symbols-rounded fs-3 me-3">warning</i>
                    <div>
                        <strong class="d-block">Membership Validity Expired</strong>
                        <span>Your membership expired on <?php echo $validity_end ? date('d M, Y', strtotime($validity_end)) : 'recently'; ?>. Please renew your membership to keep your verified standing and download official certificates.</span>
                    </div>
                </div>
                <a href="<?php echo site_url('admin/renew'); ?>" class="btn btn-sm btn-white text-dark mb-0 font-weight-bold ms-3 shadow-sm text-nowrap">Renew Membership</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- --- STATS CARDS --- -->
    <div class="row mb-4">
        <!-- 1. Total Donated -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="<?php echo site_url('admin/donation_history'); ?>" class="text-decoration-none text-reset d-block h-100" title="Click to view full donation history">
                <div class="card border-0 shadow-sm h-100 stat-card-interactive" style="border-radius: 14px;">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape text-center border-radius-md" style="background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%); box-shadow: 0 4px 10px rgba(26, 104, 91, 0.25); color: #fff;">
                                    <i class="material-symbols-rounded opacity-10">payments</i>
                                </div>
                                <div class="ms-3">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Donated</p>
                                    <?php 
                                        $total_sum = 0;
                                        foreach($donations as $dn) { if($dn['status'] === 'paid') $total_sum += $dn['amount']; }
                                    ?>
                                    <h4 class="font-weight-bolder mb-0">₹<?php echo number_format($total_sum, 0); ?></h4>
                                </div>
                            </div>
                            <span class="badge bg-light rounded-circle p-2 stat-arrow-badge" style="color: #1a685b !important;">
                                <i class="material-symbols-rounded text-xs d-block">arrow_forward</i>
                            </span>
                        </div>
                        <div class="border-top border-light mt-3 pt-2 d-flex align-items-center justify-content-between text-xs font-weight-bold" style="color: #1a685b !important;">
                            <span>View Donation History</span>
                            <i class="material-symbols-rounded text-xs">arrow_forward</i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- 2. Campaigns -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="<?php echo site_url('admin/campaigns'); ?>" class="text-decoration-none text-reset d-block h-100" title="Click to explore active campaigns">
                <div class="card border-0 shadow-sm h-100 stat-card-interactive" style="border-radius: 14px;">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center border-radius-md">
                                    <i class="material-symbols-rounded opacity-10">campaign</i>
                                </div>
                                <div class="ms-3">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Campaigns</p>
                                    <h4 class="font-weight-bolder mb-0"><?php echo is_array($campaigns) ? count($campaigns) : 0; ?></h4>
                                </div>
                            </div>
                            <span class="badge bg-light text-success rounded-circle p-2 stat-arrow-badge">
                                <i class="material-symbols-rounded text-xs d-block">arrow_forward</i>
                            </span>
                        </div>
                        <div class="border-top border-light mt-3 pt-2 d-flex align-items-center justify-content-between text-xs text-success font-weight-bold">
                            <span>Explore Active Causes</span>
                            <i class="material-symbols-rounded text-xs">arrow_forward</i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3. Events -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="<?php echo site_url('admin/events'); ?>" class="text-decoration-none text-reset d-block h-100" title="Click to see upcoming events">
                <div class="card border-0 shadow-sm h-100 stat-card-interactive" style="border-radius: 14px;">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center border-radius-md">
                                    <i class="material-symbols-rounded opacity-10">event</i>
                                </div>
                                <div class="ms-3">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Events</p>
                                    <h4 class="font-weight-bolder mb-0"><?php echo is_array($events) ? count($events) : 0; ?></h4>
                                </div>
                            </div>
                            <span class="badge bg-light text-warning rounded-circle p-2 stat-arrow-badge">
                                <i class="material-symbols-rounded text-xs d-block">arrow_forward</i>
                            </span>
                        </div>
                        <div class="border-top border-light mt-3 pt-2 d-flex align-items-center justify-content-between text-xs text-warning font-weight-bold">
                            <span>View Events & Schedule</span>
                            <i class="material-symbols-rounded text-xs">arrow_forward</i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- 4. Status -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="<?php echo $status_link; ?>" class="text-decoration-none text-reset d-block h-100" title="Click to view membership details">
                <div class="card border-0 shadow-sm h-100 stat-card-interactive" style="border-radius: 14px;">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape <?php echo $status_badge_bg; ?> text-center border-radius-md">
                                    <i class="material-symbols-rounded opacity-10"><?php echo $status_icon; ?></i>
                                </div>
                                <div class="ms-3">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Status</p>
                                    <h4 class="font-weight-bolder mb-0 <?php echo $status_class; ?>"><?php echo $status_label; ?></h4>
                                    <small class="text-xs text-muted"><?php echo $status_sub; ?></small>
                                </div>
                            </div>
                            <span class="badge bg-light <?php echo $status_action_color; ?> rounded-circle p-2 stat-arrow-badge">
                                <i class="material-symbols-rounded text-xs d-block">arrow_forward</i>
                            </span>
                        </div>
                        <div class="border-top border-light mt-3 pt-2 d-flex align-items-center justify-content-between text-xs <?php echo $status_action_color; ?> font-weight-bold">
                            <span><?php echo $status_action_text; ?></span>
                            <i class="material-symbols-rounded text-xs">arrow_forward</i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- --- QUICK DOCUMENTS --- -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bolder">My Official Documents</h5>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">Verified & Active</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="p-3 text-center border-radius-lg border border-light bg-light-hover transition-all h-100 d-flex flex-column justify-content-between doc-item-card" style="cursor: pointer;" onclick="window.location.href='<?php echo site_url('admin/member_document/id-card'); ?>';">
                                <div>
                                    <i class="material-symbols-rounded mb-2" style="font-size: 40px; color: #1a685b;">badge</i>
                                    <h6 class="mb-1 font-weight-bold">Identity Card</h6>
                                    <p class="text-xs text-muted mb-3">Official member ID with Verification QR</p>
                                </div>
                                <a href="<?php echo site_url('admin/member_document/id-card'); ?>" class="btn btn-sm w-100 rounded-pill doc-action-btn" style="background: #1a685b; color: #fff; box-shadow: 0 2px 8px rgba(26, 104, 91, 0.25);"><i class="material-symbols-rounded align-middle me-1" style="font-size: 16px;">visibility</i> View &amp; Download Card</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 text-center border-radius-lg border border-light bg-light-hover transition-all h-100 d-flex flex-column justify-content-between doc-item-card" style="cursor: pointer;" onclick="window.location.href='<?php echo site_url('admin/member_document/appointment-letter'); ?>';">
                                <div>
                                    <i class="material-symbols-rounded text-success mb-2" style="font-size: 40px;">description</i>
                                    <h6 class="mb-1 font-weight-bold">Appointment Letter</h6>
                                    <p class="text-xs text-muted mb-3">Your official joining &amp; appointment letter</p>
                                </div>
                                <a href="<?php echo site_url('admin/member_document/appointment-letter'); ?>" class="btn btn-sm btn-success w-100 rounded-pill doc-action-btn"><i class="material-symbols-rounded align-middle me-1" style="font-size: 16px;">visibility</i> View Appointment Letter</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 text-center border-radius-lg border border-light bg-light-hover transition-all h-100 d-flex flex-column justify-content-between doc-item-card" style="cursor: pointer;" onclick="window.location.href='<?php echo site_url('admin/member_document/certificate'); ?>';">
                                <div>
                                    <i class="material-symbols-rounded mb-2" style="font-size: 40px; color: #d97706;">workspace_premium</i>
                                    <h6 class="mb-1 font-weight-bold">Contribution Certificate</h6>
                                    <p class="text-xs text-muted mb-3">Official appreciation certificate for support</p>
                                </div>
                                <a href="<?php echo site_url('admin/member_document/certificate'); ?>" class="btn btn-sm btn-doc-cert w-100 rounded-pill doc-action-btn"><i class="material-symbols-rounded align-middle me-1" style="font-size: 16px;">visibility</i> View &amp; Download Certificate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- --- SUPPORT A CAUSE --- -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 15px; background: #fff;">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle d-inline-flex p-3 mb-3" style="background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%);">
                        <i class="material-symbols-rounded text-white" style="font-size: 32px;">favorite</i>
                    </div>
                    <h5 class="font-weight-bolder mb-2">Support a Mission</h5>
                    <p class="text-sm text-muted mb-4">Every contribution helps us reach more lives. Help us grow the movement.</p>
                    <a href="<?php echo site_url('donation'); ?>" class="btn btn-lg w-100 rounded-pill" style="background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%); color: #fff; box-shadow: 0 4px 12px rgba(26, 104, 91, 0.25); border: none;">Donate Now</a>
                    <hr class="my-4 light">
                    <a href="<?php echo site_url('admin/donation_history'); ?>" class="d-flex justify-content-between align-items-center text-start text-decoration-none text-reset p-2 rounded bg-light-hover transition-all" title="View donation history">
                        <div class="ps-1">
                            <p class="text-xs text-muted mb-0">Latest Donation</p>
                            <h6 class="mb-0 text-sm font-weight-bold text-dark"><?php echo !empty($donations) ? '₹' . number_format($donations[0]['amount'], 0) : 'No donations yet'; ?></h6>
                        </div>
                        <i class="material-symbols-rounded text-muted text-sm">arrow_forward_ios</i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- --- RECENT CAMPAIGNS --- -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bolder mb-0">Active Campaigns</h6>
                    <a href="<?php echo site_url('admin/campaigns'); ?>" class="text-xs font-weight-bold text-decoration-none d-inline-flex align-items-center gap-1 hover-opacity" style="color: #1a685b !important;">
                        <span>View All</span>
                        <i class="material-symbols-rounded text-xs">arrow_forward</i>
                    </a>
                </div>
                <div class="card-body p-3">
                    <?php if (!empty($campaigns)): ?>
                        <?php foreach($campaigns as $camp): ?>
                            <?php 
                                $c_title = $camp['title'] ?? 'Untitled Campaign';
                                $c_desc = $camp['description'] ?? 'Support this cause.';
                                $c_img = !empty($camp['image']) ? base_url($camp['image']) : '';
                                $c_json = html_escape(json_encode(array(
                                    'title' => $c_title,
                                    'description' => $c_desc,
                                    'image' => $c_img,
                                    'donate_url' => site_url('donation'),
                                    'view_url' => site_url('admin/campaigns')
                                )));
                            ?>
                            <div class="d-flex align-items-center p-3 border-radius-lg bg-light-hover mb-2 transition-all campaign-clickable-item" 
                                 role="button" 
                                 tabindex="0"
                                 onclick='showCampaignModal(<?php echo $c_json; ?>)'
                                 title="Click to view campaign details"
                                 style="cursor: pointer;">
                                <div class="border-radius-md p-2 me-3 shadow-xs d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0; background-color: #1a685b !important;">
                                    <i class="material-symbols-rounded text-white text-sm">campaign</i>
                                </div>
                                <div class="flex-grow-1 min-w-0 me-2">
                                    <h6 class="mb-1 text-sm text-truncate font-weight-bold text-dark"><?php echo html_escape($c_title); ?></h6>
                                    <p class="text-xs text-muted mb-0">Live now • Support this cause</p>
                                </div>
                                <a href="<?php echo site_url('donation'); ?>" class="btn btn-sm rounded-pill mb-0 text-xs px-3 py-1 flex-shrink-0" style="color: #1a685b; border: 1px solid #1a685b;" onclick="event.stopPropagation();">Participate</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-sm text-muted">No active campaigns at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- --- UPCOMING EVENTS --- -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bolder mb-0">Upcoming Events</h6>
                    <a href="<?php echo site_url('admin/events'); ?>" class="text-xs font-weight-bold text-decoration-none d-inline-flex align-items-center gap-1 hover-opacity" style="color: #1a685b !important;">
                        <span>View All</span>
                        <i class="material-symbols-rounded text-xs">arrow_forward</i>
                    </a>
                </div>
                <div class="card-body p-3">
                    <?php if (!empty($events)): ?>
                        <?php foreach($events as $event): ?>
                            <?php 
                                $ev_date_raw = !empty($event['event_date']) ? $event['event_date'] : (!empty($event['date']) ? $event['date'] : 'now');
                                $ev_date_formatted = date('d M Y', strtotime($ev_date_raw));
                                $ev_title = $event['title'] ?? 'NGO Event';
                                $ev_desc = !empty($event['body']) ? $event['body'] : (!empty($event['description']) ? $event['description'] : 'Join our foundation event to make an impact.');
                                $ev_img = !empty($event['image']) ? base_url($event['image']) : '';
                                $ev_json = html_escape(json_encode(array(
                                    'title' => $ev_title,
                                    'date' => $ev_date_formatted,
                                    'description' => $ev_desc,
                                    'image' => $ev_img,
                                    'view_url' => site_url('admin/events#event-' . (int)($event['id'] ?? 0)),
                                    'contact_url' => site_url('contact')
                                )));
                            ?>
                            <div class="d-flex align-items-center p-3 border-radius-lg bg-light-hover mb-2 transition-all event-clickable-item" 
                                 role="button" 
                                 tabindex="0"
                                 onclick='showEventModal(<?php echo $ev_json; ?>)'
                                 title="Click to view event details"
                                 style="cursor: pointer;">
                                <div class="border-radius-md p-2 me-3 shadow-xs d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0; background-color: #d97706 !important;">
                                    <i class="material-symbols-rounded text-white text-sm">event</i>
                                </div>
                                <div class="flex-grow-1 min-w-0 me-2">
                                    <h6 class="mb-1 text-sm text-truncate font-weight-bold text-dark"><?php echo html_escape($ev_title); ?></h6>
                                    <p class="text-xs text-muted mb-0">
                                        <i class="material-symbols-rounded text-xxs align-middle">calendar_month</i>
                                        <b><?php echo $ev_date_formatted; ?></b> • Join us
                                    </p>
                                </div>
                                <span class="badge badge-sm bg-gradient-success rounded-pill px-3 py-2 flex-shrink-0 d-inline-flex align-items-center gap-1 shadow-xs">
                                    <span>OPEN</span>
                                    <i class="material-symbols-rounded text-xs">arrow_forward</i>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-sm text-muted">Stay tuned for upcoming events!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Event Details Quick View -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div id="eventModalImgContainer" style="display: none; height: 200px; overflow: hidden; position: relative;">
                <img id="eventModalImg" src="" alt="Event" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, transparent 60%);"></div>
                <div style="position: absolute; bottom: 12px; left: 16px;">
                    <span class="badge bg-warning text-dark font-weight-bold rounded-pill px-3 py-1 text-xxs">
                        <i class="material-symbols-rounded text-xxs align-middle me-1">event</i> Event
                    </span>
                </div>
            </div>
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <span class="badge bg-gradient-success rounded-pill px-3 py-1 mb-2 text-xxs font-weight-bold">
                                <i class="material-symbols-rounded text-xxs align-middle me-1">calendar_month</i>
                                <span id="eventModalDate">Upcoming</span>
                            </span>
                            <h5 class="modal-title font-weight-bolder text-dark mb-0" id="eventModalTitle">Event Details</h5>
                        </div>
                        <button type="button" class="btn-close text-dark shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body p-4">
                <p class="text-sm text-secondary mb-3" id="eventModalDesc" style="white-space: pre-line; line-height: 1.6;"></p>
                <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3">
                    <div class="bg-gradient-success rounded-circle p-2 text-white d-flex align-items-center justify-content-center shadow-xs" style="width: 38px; height: 38px; flex-shrink: 0;">
                        <i class="material-symbols-rounded text-sm">how_to_reg</i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-xs font-weight-bold text-dark">Open for Member Participation</h6>
                        <p class="mb-0 text-xxs text-muted">All active foundation members are welcome to attend and participate.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between align-items-center">
                <a id="eventModalFullLink" href="<?php echo site_url('admin/events'); ?>" class="btn btn-outline-secondary rounded-pill btn-sm mb-0 px-3">
                    View All Events
                </a>
                <a href="<?php echo site_url('contact'); ?>" class="btn rounded-pill btn-sm mb-0 px-4" style="background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%); color: #fff;">
                    Register / Contact NGO
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Campaign Details Quick View -->
<div class="modal fade" id="campaignDetailsModal" tabindex="-1" aria-labelledby="campaignDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div id="campModalImgContainer" style="display: none; height: 200px; overflow: hidden; position: relative;">
                <img id="campModalImg" src="" alt="Campaign" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, transparent 60%);"></div>
                <div style="position: absolute; bottom: 12px; left: 16px;">
                    <span class="badge text-white font-weight-bold rounded-pill px-3 py-1 text-xxs" style="background-color: #1a685b;">
                        <i class="material-symbols-rounded text-xxs align-middle me-1">campaign</i> Mission
                    </span>
                </div>
            </div>
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <span class="badge text-white rounded-pill px-3 py-1 mb-2 text-xxs font-weight-bold" style="background-color: #1a685b;">
                                Active Cause
                            </span>
                            <h5 class="modal-title font-weight-bolder text-dark mb-0" id="campModalTitle">Campaign Details</h5>
                        </div>
                        <button type="button" class="btn-close text-dark shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body p-4">
                <p class="text-sm text-secondary mb-3" id="campModalDesc" style="white-space: pre-line; line-height: 1.6;"></p>
            </div>
            <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between align-items-center">
                <a href="<?php echo site_url('admin/campaigns'); ?>" class="btn btn-outline-secondary rounded-pill btn-sm mb-0 px-3">
                    View All Campaigns
                </a>
                <a href="<?php echo site_url('donation'); ?>" class="btn rounded-pill btn-sm mb-0 px-4" style="background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%); color: #fff;">
                    Donate & Support
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.bg-light-hover { transition: background 0.2s; }
.bg-light-hover:hover { background: #f8f9fa; }
.transition-all { transition: all 0.2s; }

/* Grounded Stat Cards without Jumping */
.stat-card-interactive {
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
    cursor: pointer;
    border: 1px solid rgba(0, 0, 0, 0.06) !important;
}
.stat-card-interactive:hover {
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07) !important;
    border-color: rgba(0, 0, 0, 0.12) !important;
}
.stat-card-interactive .stat-arrow-badge {
    transition: background-color 0.2s ease, color 0.2s ease;
}
.stat-card-interactive:hover .stat-arrow-badge {
    background-color: #1e293b !important;
    color: #ffffff !important;
}

/* Grounded Welcome Banner */
.welcome-banner-interactive {
    transition: box-shadow 0.2s ease !important;
}
.welcome-banner-interactive:hover {
    box-shadow: 0 8px 24px rgba(26, 104, 91, 0.22) !important;
}
.welcome-banner-interactive:hover .banner-profile-btn {
    background: #ffffff !important;
}
.banner-profile-btn {
    transition: background 0.2s ease;
}

/* Clean Event & Campaign Items */
.event-clickable-item, .campaign-clickable-item {
    transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease !important;
    border: 1px solid transparent !important;
}
.event-clickable-item:hover, .campaign-clickable-item:hover {
    background-color: #f8fafc !important;
    border-color: rgba(0, 0, 0, 0.06) !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
}

/* My Official Documents Card & Buttons */
.doc-item-card {
    background: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.07) !important;
    border-radius: 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.doc-item-card:hover {
    border-color: rgba(0, 0, 0, 0.15) !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
}
.doc-action-btn {
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 600;
    line-height: 1.3;
    padding: 0.45rem 0.75rem;
    border: none !important;
}
.btn-doc-cert {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(217, 119, 6, 0.25) !important;
}
.btn-doc-cert:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(217, 119, 6, 0.32) !important;
}
.hover-opacity:hover { opacity: 0.8; }
</style>

<script>
function showEventModal(data) {
    if (!data) return;
    document.getElementById('eventModalTitle').textContent = data.title || 'NGO Event';
    document.getElementById('eventModalDate').textContent = data.date || 'Upcoming';
    document.getElementById('eventModalDesc').textContent = data.description || 'Details will be announced soon.';
    const imgCont = document.getElementById('eventModalImgContainer');
    const imgElem = document.getElementById('eventModalImg');
    if (data.image && data.image.trim() !== '') {
        imgElem.src = data.image;
        imgCont.style.display = 'block';
    } else {
        imgCont.style.display = 'none';
    }
    const fullLink = document.getElementById('eventModalFullLink');
    if (fullLink && data.view_url) {
        fullLink.href = data.view_url;
    }
    const modalEl = document.getElementById('eventDetailsModal');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

function showCampaignModal(data) {
    if (!data) return;
    document.getElementById('campModalTitle').textContent = data.title || 'Campaign';
    document.getElementById('campModalDesc').textContent = data.description || 'Support this cause.';
    const imgCont = document.getElementById('campModalImgContainer');
    const imgElem = document.getElementById('campModalImg');
    if (data.image && data.image.trim() !== '') {
        imgElem.src = data.image;
        imgCont.style.display = 'block';
    } else {
        imgCont.style.display = 'none';
    }
    const modalEl = document.getElementById('campaignDetailsModal');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}
</script>

<?php if (isset($is_birthday_today) && $is_birthday_today): ?>
<!-- Premium Birthday Popup -->
<div class="modal fade" id="birthdayModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center border-0 overflow-hidden" style="border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
            <div class="modal-header border-0 pb-0 position-relative" style="background: linear-gradient(135deg, #FFD54F 0%, #FFB300 100%); padding: 50px;">
                 <div class="w-100 text-center">
                    <i class="material-symbols-rounded text-danger" style="font-size: 80px;">cake</i>
                 </div>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 15px;"></button>
            </div>
            <div class="modal-body p-4 pt-5">
                <h2 class="font-weight-800 mb-2">Happy Birthday, <?php echo html_escape($member['name']); ?>!</h2>
                <p class="text-muted mb-4 px-3">The entire NGO Team wishes you a fantastic day ahead. Thank you for being a part of our journey and supporting the cause!</p>
                <div class="d-grid">
                    <button type="button" class="btn rounded-pill py-2 font-weight-bold" style="background: #1a685b; color: #fff; border: none;" data-bs-dismiss="modal">Thank You!</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var bdayModal = new bootstrap.Modal(document.getElementById('birthdayModal'));
    setTimeout(() => { bdayModal.show(); }, 1000);
});
</script>
<?php endif; ?>
