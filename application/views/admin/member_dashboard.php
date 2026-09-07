<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <!-- --- HEADER SECTION --- -->
    <div class="row mb-4 opacity-0 stagger-item">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8 text-white">
                            <h3 class="text-white mb-1 font-weight-bolder">Welcome, <?php echo html_escape($member['name']); ?>! 👋</h3>
                            <p class="text-white opacity-8 mb-0">Member ID: <?php echo html_escape($member['member_id_code'] ?? 'SFI-' . date('Y') . '-' . $member['id']); ?> | Role: <span class="badge bg-white text-primary text-xs"><?php echo strtoupper($member['role'] ?? 'MEMBER'); ?></span></p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <i class="material-symbols-rounded text-white opacity-2" style="font-size: 80px; position: absolute; right: -10px; top: -10px;">verified</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- --- STATS CARDS --- -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4 opacity-0 stagger-item">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center border-radius-md">
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
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4 opacity-0 stagger-item">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center border-radius-md">
                            <i class="material-symbols-rounded opacity-10">campaign</i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Campaigns</p>
                            <h4 class="font-weight-bolder mb-0"><?php echo is_array($campaigns) ? count($campaigns) : 0; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4 opacity-0 stagger-item">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center border-radius-md">
                            <i class="material-symbols-rounded opacity-10">event</i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Events</p>
                            <h4 class="font-weight-bolder mb-0"><?php echo is_array($events) ? count($events) : 0; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4 opacity-0 stagger-item">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-info shadow-info text-center border-radius-md">
                            <i class="material-symbols-rounded opacity-10">verified</i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Status</p>
                            <h4 class="font-weight-bolder mb-0 text-success">Verified</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- --- QUICK DOCUMENTS --- -->
        <div class="col-lg-8 mb-4 opacity-0 stagger-item">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bolder">My Official Documents</h5>
                    <span class="text-xs text-muted">PDF Ready</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="p-3 text-center border-radius-lg border border-light bg-light-hover transition-all" style="cursor: pointer;">
                                <i class="material-symbols-rounded text-primary mb-2" style="font-size: 40px;">badge</i>
                                <h6 class="mb-1">Identity Card</h6>
                                <p class="text-xs text-muted mb-3">Official member ID with Verification QR</p>
                                <a href="<?php echo site_url('admin/member_document/id-card'); ?>" target="_blank" class="btn btn-sm btn-primary w-100 rounded-pill">Download PDF</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 text-center border-radius-lg border border-light bg-light-hover transition-all" style="cursor: pointer;">
                                <i class="material-symbols-rounded text-success mb-2" style="font-size: 40px;">description</i>
                                <h6 class="mb-1">Appointment</h6>
                                <p class="text-xs text-muted mb-3">Your official joining / appointment letter</p>
                                <a href="<?php echo site_url('admin/member_document/appointment-letter'); ?>" target="_blank" class="btn btn-sm btn-success w-100 rounded-pill">Download PDF</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 text-center border-radius-lg border border-light bg-light-hover transition-all" style="cursor: pointer;">
                                <i class="material-symbols-rounded text-warning mb-2" style="font-size: 40px;">workspace_premium</i>
                                <h6 class="mb-1">Contribution Cert</h6>
                                <p class="text-xs text-muted mb-3">Appreciation certificate for your support</p>
                                <a href="<?php echo site_url('admin/member_document/certificate'); ?>" target="_blank" class="btn btn-sm btn-warning w-100 text-white rounded-pill">Download PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- --- SUPPORT A CAUSE --- -->
        <div class="col-lg-4 mb-4 opacity-0 stagger-item">
            <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 15px; background: #fff;">
                <div class="card-body p-4 text-center">
                    <div class="bg-gradient-primary rounded-circle d-inline-flex p-3 mb-3">
                        <i class="material-symbols-rounded text-white" style="font-size: 32px;">favorite</i>
                    </div>
                    <h5 class="font-weight-bolder mb-2">Support a Mission</h5>
                    <p class="text-sm text-muted mb-4">Every contribution helps us reach more lives. Help us grow the movement.</p>
                    <a href="<?php echo site_url('donation'); ?>" class="btn btn-lg btn-primary w-100 rounded-pill shadow-primary">Donate Now 💰</a>
                    <hr class="my-4 light">
                    <div class="d-flex justify-content-between align-items-center text-start">
                        <div class="ps-1">
                            <p class="text-xs text-muted mb-0">Latest Donation</p>
                            <h6 class="mb-0 text-sm"><?php echo !empty($donations) ? '₹' . number_format($donations[0]['amount'], 0) : 'No donations yet'; ?></h6>
                        </div>
                        <i class="material-symbols-rounded text-muted">arrow_forward_ios</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- --- RECENT CAMPAIGNS --- -->
        <div class="col-md-6 mb-4 opacity-0 stagger-item">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="font-weight-bolder mb-0">Active Campaigns</h6>
                </div>
                <div class="card-body p-3">
                    <?php if (!empty($campaigns)): ?>
                        <?php foreach($campaigns as $camp): ?>
                            <div class="d-flex align-items-center p-3 border-radius-lg bg-light-hover mb-2">
                                <div class="bg-primary border-radius-md p-2 me-3">
                                    <i class="material-symbols-rounded text-white text-xs">campaign</i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-sm"><?php echo html_escape($camp['title'] ?? 'Untitled Campaign'); ?></h6>
                                    <p class="text-xs text-muted mb-0">Live now • Support this cause</p>
                                </div>
                                <a href="<?php echo site_url('donation'); ?>" class="btn btn-sm btn-outline-primary rounded-pill mb-0">Participate</a>
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
        <div class="col-md-6 mb-4 opacity-0 stagger-item">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="font-weight-bolder mb-0">Upcoming Events</h6>
                </div>
                <div class="card-body p-3">
                    <?php if (!empty($events)): ?>
                        <?php foreach($events as $event): ?>
                            <div class="d-flex align-items-center p-3 border-radius-lg bg-light-hover mb-2">
                                <div class="bg-warning border-radius-md p-2 me-3">
                                    <i class="material-symbols-rounded text-white text-xs">event</i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-sm"><?php echo html_escape($event['title'] ?? 'NGO Event'); ?></h6>
                                    <p class="text-xs text-muted mb-0"><?php echo date('d M Y', strtotime($event['date'] ?? 'now')); ?> • Join us</p>
                                </div>
                                <span class="badge badge-sm bg-gradient-success rounded-pill">OPEN</span>
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

<style>
.stagger-item { transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); transform: translateY(20px); }
.stagger-item.show { opacity: 1 !important; transform: translateY(0); }
.bg-light-hover { transition: background 0.3s; }
.bg-light-hover:hover { background: #f8f9fa; }
.transition-all { transition: all 0.3s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.stagger-item');
    items.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add('show');
        }, index * 100);
    });
});
</script>

<?php if (isset($is_birthday_today) && $is_birthday_today): ?>
<!-- Premium Birthday Popup -->
<div class="modal fade" id="birthdayModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center border-0 overflow-hidden" style="border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
            <div class="modal-header border-0 pb-0 position-relative" style="background: linear-gradient(135deg, #FFD54F 0%, #FFB300 100%); padding: 50px;">
                 <div class="w-100 text-center">
                    <i class="material-symbols-rounded text-danger pulse-animation" style="font-size: 80px;">cake</i>
                 </div>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 15px;"></button>
            </div>
            <div class="modal-body p-4 pt-5">
                <h2 class="font-weight-800 mb-2">Happy Birthday, <?php echo html_escape($member['name']); ?>! 🎂</h2>
                <p class="text-muted mb-4 px-3">The entire NGO Team wishes you a fantastic day ahead. Thank you for being a part of our journey and supporting the cause! ❤️</p>
                <div class="d-grid">
                    <button type="button" class="btn btn-primary rounded-pill py-2 font-weight-bold" data-bs-dismiss="modal">Thank You! 🎉</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.pulse-animation { animation: pulse 2s infinite; }
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var bdayModal = new bootstrap.Modal(document.getElementById('birthdayModal'));
    setTimeout(() => { bdayModal.show(); }, 1000);
});
</script>
<?php endif; ?>
