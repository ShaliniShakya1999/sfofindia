<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
// Helper for human-readable relative time
if (!function_exists('time_ago_str')) {
    function time_ago_str($datetime) {
        $timestamp = strtotime($datetime);
        if (!$timestamp) return html_escape($datetime);
        $diff = time() - $timestamp;
        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            $m = floor($diff / 60);
            return $m . ' min' . ($m > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            $h = floor($diff / 3600);
            return $h . ' hr' . ($h > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 172800) {
            return 'Yesterday at ' . date('h:i A', $timestamp);
        } elseif ($diff < 604800) {
            $d = floor($diff / 86400);
            return $d . ' days ago';
        } else {
            return date('d M Y, h:i A', $timestamp);
        }
    }
}
$csrf_name = $this->security->get_csrf_token_name();
$csrf_hash = $this->security->get_csrf_hash();
$active_filter = $active_filter ?? 'all';
?>

<div class="container-fluid py-4">
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible text-white fade show shadow-sm border-0 mb-4" role="alert" style="border-radius:12px;">
            <div class="d-flex align-items-center">
                <i class="material-symbols-rounded me-2">check_circle</i>
                <span class="text-sm font-weight-bold"><?= $this->session->flashdata('success'); ?></span>
            </div>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible text-white fade show shadow-sm border-0 mb-4" role="alert" style="border-radius:12px;">
            <div class="d-flex align-items-center">
                <i class="material-symbols-rounded me-2">error</i>
                <span class="text-sm font-weight-bold"><?= $this->session->flashdata('error'); ?></span>
            </div>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Top Header -->
    <div class="row align-items-center mb-4" style="position: relative; z-index: 5;">
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="<?= site_url('admin'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Notifications</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-2">
                <h3 class="font-weight-bolder mb-0 text-dark">Notification Center</h3>
                <?php if (!empty($counts['unread']) && $counts['unread'] > 0): ?>
                    <span class="badge rounded-pill px-3 py-1 text-xs font-weight-bold" style="background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;">
                        <?= (int)$counts['unread']; ?> Unread
                    </span>
                <?php endif; ?>
            </div>
            <p class="text-sm text-muted mb-0">Real-time alerts for member applications, donations, renewals, and system events.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex gap-2 flex-wrap">
                <?php if (!empty($counts['unread']) && $counts['unread'] > 0): ?>
                    <form method="post" action="<?= site_url('notifications/mark_all_read'); ?>" class="d-inline">
                        <input type="hidden" name="<?= $csrf_name; ?>" value="<?= $csrf_hash; ?>">
                        <button type="submit" class="btn btn-sm mb-0 shadow-sm d-inline-flex align-items-center gap-1 notif-top-btn" style="border-radius:8px;border:1px solid #cbd5e1;background:#fff;color:#1a685b;font-weight:600;">
                            <i class="material-symbols-rounded text-sm">done_all</i>
                            <span>Mark All Read</span>
                        </button>
                    </form>
                <?php endif; ?>

                <?php if (!empty($counts['total']) && ($counts['total'] - ($counts['unread'] ?? 0)) > 0): ?>
                    <form method="post" action="<?= site_url('notifications/clear_all_read'); ?>" class="d-inline" onsubmit="return confirm('Are you sure you want to clear all read notification history?');">
                        <input type="hidden" name="<?= $csrf_name; ?>" value="<?= $csrf_hash; ?>">
                        <button type="submit" class="btn btn-sm mb-0 shadow-sm d-inline-flex align-items-center gap-1 notif-top-clear-btn" style="border-radius:8px;border:1px solid #fecaca;background:#fff;color:#dc2626;font-weight:600;">
                            <i class="material-symbols-rounded text-sm">cleaning_services</i>
                            <span>Clear Read History</span>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards (Interactive Filters) -->
    <div class="row g-3 mb-4" style="position: relative; z-index: 5;">
        <div class="col-xl-3 col-sm-6">
            <a href="<?= site_url('notifications'); ?>" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm stat-filter-card <?= ($active_filter === 'all') ? 'active-stat-card' : ''; ?>" style="border-radius:14px;">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="text-xs text-uppercase font-weight-bolder text-muted mb-1" style="letter-spacing:0.5px;">Total Alerts</p>
                                <h4 class="font-weight-bolder mb-0 text-dark"><?= (int)($counts['total'] ?? 0); ?></h4>
                            </div>
                            <div class="col-4 text-end">
                                <div class="rounded-3 d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#f1f5f9;color:#334155;border:1px solid #e2e8f0;">
                                    <i class="material-symbols-rounded" style="font-size:22px;">notifications</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="<?= site_url('notifications?filter=unread'); ?>" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm stat-filter-card <?= ($active_filter === 'unread') ? 'active-stat-card' : ''; ?>" style="border-radius:14px;">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="text-xs text-uppercase font-weight-bolder text-muted mb-1" style="letter-spacing:0.5px;">Unread</p>
                                <h4 class="font-weight-bolder mb-0 unread-count-num" style="color:#b91c1c;"><?= (int)($counts['unread'] ?? 0); ?></h4>
                            </div>
                            <div class="col-4 text-end">
                                <div class="rounded-3 d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#fef2f2;color:#dc2626;border:1px solid #fee2e2;">
                                    <i class="material-symbols-rounded" style="font-size:22px;">mark_email_unread</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="<?= site_url('notifications?filter=members'); ?>" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm stat-filter-card <?= ($active_filter === 'members') ? 'active-stat-card' : ''; ?>" style="border-radius:14px;">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="text-xs text-uppercase font-weight-bolder text-muted mb-1" style="letter-spacing:0.5px;">Memberships</p>
                                <h4 class="font-weight-bolder mb-0" style="color:#0369a1;"><?= (int)($counts['members'] ?? 0); ?></h4>
                            </div>
                            <div class="col-4 text-end">
                                <div class="rounded-3 d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#f0f9ff;color:#0284c7;border:1px solid #e0f2fe;">
                                    <i class="material-symbols-rounded" style="font-size:22px;">person_add</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="<?= site_url('notifications?filter=donations'); ?>" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm stat-filter-card <?= ($active_filter === 'donations') ? 'active-stat-card' : ''; ?>" style="border-radius:14px;">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="text-xs text-uppercase font-weight-bolder text-muted mb-1" style="letter-spacing:0.5px;">Donations</p>
                                <h4 class="font-weight-bolder mb-0" style="color:#1a685b;"><?= (int)($counts['donations'] ?? 0); ?></h4>
                            </div>
                            <div class="col-4 text-end">
                                <div class="rounded-3 d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#e6f0ee;color:#1a685b;border:1px solid #cce2de;">
                                    <i class="material-symbols-rounded" style="font-size:22px;">payments</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card border-0 shadow-sm" style="border-radius:16px;">
        <!-- Filters & Search Toolbar -->
        <div class="card-header bg-white border-0 py-3 px-4" style="border-radius:16px 16px 0 0;">
            <div class="row g-3 align-items-center">
                <!-- Filter Pills -->
                <div class="col-lg-8">
                    <div class="d-flex flex-wrap gap-2 notif-filter-group">
                        <a href="<?= site_url('notifications'); ?>" 
                           class="btn btn-sm mb-0 px-3 py-2 text-xs font-weight-bold notif-tab-btn <?= ($active_filter === 'all') ? 'active-notif-tab' : ''; ?>">
                            All <span class="badge ms-1 count-pill"><?= (int)($counts['total'] ?? 0); ?></span>
                        </a>
                        <a href="<?= site_url('notifications?filter=unread'); ?>" 
                           class="btn btn-sm mb-0 px-3 py-2 text-xs font-weight-bold notif-tab-btn <?= ($active_filter === 'unread') ? 'active-notif-tab' : ''; ?>">
                            Unread <span class="badge ms-1 count-pill unread-pill-num <?= ($active_filter !== 'unread' && !empty($counts['unread'])) ? 'unread-alert-badge' : ''; ?>"><?= (int)($counts['unread'] ?? 0); ?></span>
                        </a>
                        <a href="<?= site_url('notifications?filter=members'); ?>" 
                           class="btn btn-sm mb-0 px-3 py-2 text-xs font-weight-bold notif-tab-btn <?= ($active_filter === 'members') ? 'active-notif-tab' : ''; ?>">
                            Memberships <span class="badge ms-1 count-pill"><?= (int)($counts['members'] ?? 0); ?></span>
                        </a>
                        <a href="<?= site_url('notifications?filter=donations'); ?>" 
                           class="btn btn-sm mb-0 px-3 py-2 text-xs font-weight-bold notif-tab-btn <?= ($active_filter === 'donations') ? 'active-notif-tab' : ''; ?>">
                            Donations <span class="badge ms-1 count-pill"><?= (int)($counts['donations'] ?? 0); ?></span>
                        </a>
                        <a href="<?= site_url('notifications?filter=system'); ?>" 
                           class="btn btn-sm mb-0 px-3 py-2 text-xs font-weight-bold notif-tab-btn <?= ($active_filter === 'system') ? 'active-notif-tab' : ''; ?>">
                            System & Security
                        </a>
                    </div>
                </div>

                <!-- Instant Search -->
                <div class="col-lg-4">
                    <div class="input-group input-group-outline bg-light rounded-pill px-2 py-1">
                        <span class="input-group-text border-0 bg-transparent ps-2 pe-1 text-muted">
                            <i class="material-symbols-rounded text-sm">search</i>
                        </span>
                        <input type="text" id="notifSearchInput" class="form-control border-0 bg-transparent text-sm py-1 shadow-none" placeholder="Search notifications...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <?php if (empty($notifications)): ?>
                <!-- Empty State -->
                <div class="text-center py-5 px-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-gray-100 rounded-circle mb-3" style="width:84px;height:84px;">
                        <i class="material-symbols-rounded text-muted" style="font-size:42px;">mark_chat_read</i>
                    </div>
                    <h5 class="font-weight-bolder text-dark mb-1">You're All Caught Up!</h5>
                    <p class="text-sm text-muted mb-3">No notifications found matching your current filter.</p>
                    <a href="<?= site_url('notifications'); ?>" class="btn btn-sm btn-outline-dark" style="border-radius:8px;">View All Notifications</a>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush" id="notificationList">
                    <?php foreach ($notifications as $n): 
                        $is_unread = empty($n['is_read']);
                        $title = (string)$n['title'];
                        $msg   = (string)$n['message'];
                        $raw_type = $n['type'] ?? 'info';

                        // Categorize icons and gradient styling
                        $is_member = (stripos($title, 'member') !== false);
                        $is_donation = (stripos($title, 'donation') !== false || stripos($title, 'payment') !== false);
                        $is_renewal = (stripos($title, 'renewal') !== false || stripos($title, 'expire') !== false);

                        if ($is_donation) {
                            $icon = 'payments';
                            $icon_bg = '#e6f0ee';
                            $icon_color = '#1a685b';
                            $icon_border = '#cce2de';
                            $category_label = 'Donation';
                            $badge_bg = '#e6f0ee';
                            $badge_color = '#1a685b';
                            $badge_border = '#cce2de';
                        } elseif ($is_member) {
                            $icon = 'person_add';
                            $icon_bg = '#f0f9ff';
                            $icon_color = '#0284c7';
                            $icon_border = '#e0f2fe';
                            $category_label = 'Membership';
                            $badge_bg = '#f0f9ff';
                            $badge_color = '#0369a1';
                            $badge_border = '#bae6fd';
                        } elseif ($is_renewal) {
                            $icon = 'autorenew';
                            $icon_bg = '#fffbeb';
                            $icon_color = '#d97706';
                            $icon_border = '#fef3c7';
                            $category_label = 'Renewal';
                            $badge_bg = '#fef3c7';
                            $badge_color = '#92400e';
                            $badge_border = '#fde68a';
                        } elseif ($raw_type === 'danger') {
                            $icon = 'error';
                            $icon_bg = '#fef2f2';
                            $icon_color = '#dc2626';
                            $icon_border = '#fee2e2';
                            $category_label = 'Security Alert';
                            $badge_bg = '#fee2e2';
                            $badge_color = '#991b1b';
                            $badge_border = '#fecaca';
                        } elseif ($raw_type === 'warning') {
                            $icon = 'warning';
                            $icon_bg = '#fffbeb';
                            $icon_color = '#d97706';
                            $icon_border = '#fef3c7';
                            $category_label = 'Notice';
                            $badge_bg = '#fef3c7';
                            $badge_color = '#92400e';
                            $badge_border = '#fde68a';
                        } else {
                            $icon = 'notifications';
                            $icon_bg = '#f1f5f9';
                            $icon_color = '#475569';
                            $icon_border = '#e2e8f0';
                            $category_label = 'System';
                            $badge_bg = '#f1f5f9';
                            $badge_color = '#475569';
                            $badge_border = '#e2e8f0';
                        }
                    ?>
                        <div class="list-group-item p-3 border-0 border-bottom notif-item <?= $is_unread ? 'notif-unread' : 'notif-read'; ?>"
                             id="notif-row-<?= $n['id']; ?>"
                             data-title="<?= html_escape(strtolower($title)); ?>"
                             data-message="<?= html_escape(strtolower($msg)); ?>"
                             data-category="<?= html_escape(strtolower($category_label)); ?>"
                             style="transition: background-color 0.2s ease;">
                            <div class="d-flex align-items-start gap-3">
                                <!-- Category Icon Avatar (Balanced Soft Squircle) -->
                                <div class="rounded-3 text-center d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;background:<?= $icon_bg; ?>;color:<?= $icon_color; ?>;border:1px solid <?= $icon_border; ?>;">
                                    <i class="material-symbols-rounded" style="font-size:20px;"><?= $icon; ?></i>
                                </div>

                                <!-- Body -->
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="badge rounded-pill px-2 py-0 text-xxs font-weight-bold" style="background:<?= $badge_bg; ?>;color:<?= $badge_color; ?>;border:1px solid <?= $badge_border; ?>;">
                                                <?= $category_label; ?>
                                            </span>
                                            <h6 class="text-sm font-weight-bold mb-0 text-dark">
                                                <?= html_escape($title); ?>
                                            </h6>
                                            <?php if ($is_unread): ?>
                                                <span class="badge rounded-pill px-2 py-0 text-xxs unread-indicator" style="background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;font-size:10px;">
                                                    New
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-xs text-muted d-flex align-items-center gap-1" title="<?= date('Y-m-d H:i:s', strtotime($n['created_at'])); ?>">
                                            <i class="material-symbols-rounded text-xs">schedule</i>
                                            <span><?= time_ago_str($n['created_at']); ?></span>
                                        </div>
                                    </div>

                                    <p class="text-sm text-secondary mb-2" style="line-height:1.45;">
                                        <?= nl2br(html_escape($msg)); ?>
                                    </p>

                                    <!-- Bottom Action Links & Row Controls -->
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-1">
                                        <div>
                                            <?php if (!empty($n['link'])): ?>
                                                <a href="<?= html_escape(site_url($n['link'])); ?>" class="btn btn-xs notif-action-btn mb-0 d-inline-flex align-items-center gap-1">
                                                    <span>View Details</span>
                                                    <i class="material-symbols-rounded text-xs">arrow_forward</i>
                                                </a>
                                            <?php endif; ?>
                                        </div>

                                        <div class="d-flex align-items-center gap-2">
                                            <?php if ($is_unread): ?>
                                                <form method="post" action="<?= site_url('notifications/mark_read/'.$n['id']); ?>" class="d-inline mark-read-form" data-id="<?= $n['id']; ?>">
                                                    <input type="hidden" name="<?= $csrf_name; ?>" value="<?= $csrf_hash; ?>">
                                                    <button type="submit" class="btn btn-link notif-markread-btn text-xs mb-0 p-1 d-inline-flex align-items-center gap-1" title="Mark as read">
                                                        <i class="material-symbols-rounded text-sm">done</i>
                                                        <span class="d-none d-sm-inline">Mark Read</span>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <form method="post" action="<?= site_url('notifications/delete/'.$n['id']); ?>" class="d-inline delete-notif-form" data-id="<?= $n['id']; ?>" onsubmit="return confirm('Delete this notification?');">
                                                <input type="hidden" name="<?= $csrf_name; ?>" value="<?= $csrf_hash; ?>">
                                                <button type="submit" class="btn btn-link notif-delete-btn text-xs mb-0 p-1 d-inline-flex align-items-center gap-1" title="Delete notification">
                                                    <i class="material-symbols-rounded text-sm">delete_outline</i>
                                                    <span class="d-none d-sm-inline">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- No Search Results Found Alert (Hidden by default) -->
                <div id="noSearchResults" class="text-center py-5 d-none">
                    <i class="material-symbols-rounded text-muted" style="font-size:48px;">search_off</i>
                    <h6 class="text-dark font-weight-bold mt-2">No matching notifications</h6>
                    <p class="text-xs text-muted mb-0">Try changing your search query or switching tabs.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.stat-filter-card {
    cursor: pointer;
    background: #ffffff;
    border: 1px solid #edf2f7 !important;
    border-radius: 14px;
    transition: all 0.2s ease;
}
.stat-filter-card:hover {
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05) !important;
    transform: translateY(-2px);
}
.stat-filter-card.active-stat-card {
    border-color: #1a685b !important;
    background-color: #fbfdfc !important;
    box-shadow: 0 0 0 1px #1a685b !important;
}
.notif-tab-btn {
    border-radius: 8px;
    background: #ffffff;
    color: #475569;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
    text-decoration: none !important;
}
.notif-tab-btn:hover {
    background: #f8fafc;
    color: #1e293b;
    border-color: #cbd5e1;
}
.notif-tab-btn .count-pill {
    background: #f1f5f9;
    color: #64748b;
    font-size: 0.68rem;
}
.notif-tab-btn.active-notif-tab {
    background: #1a685b !important;
    color: #ffffff !important;
    border-color: #1a685b !important;
    box-shadow: 0 2px 6px rgba(26, 104, 91, 0.2) !important;
}
.notif-tab-btn.active-notif-tab .count-pill {
    background: rgba(255, 255, 255, 0.25) !important;
    color: #ffffff !important;
}
.unread-alert-badge {
    background: #fee2e2 !important;
    color: #b91c1c !important;
}
.notif-unread {
    background-color: #fafcfb;
    border-left: 3.5px solid #1a685b !important;
}
.notif-read {
    background-color: #ffffff;
    border-left: 3.5px solid transparent !important;
}
.notif-item {
    border-bottom: 1px solid #f1f5f9 !important;
}
.notif-item:hover {
    background-color: #f8fafc !important;
}
.notif-action-btn {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    color: #1a685b;
    font-weight: 600;
    border-radius: 6px;
    padding: 0.25rem 0.65rem !important;
    font-size: 0.72rem !important;
    transition: all 0.15s ease;
}
.notif-action-btn:hover {
    background: #1a685b;
    color: #ffffff;
    border-color: #1a685b;
}
.notif-delete-btn {
    color: #94a3b8;
    text-decoration: none !important;
    border-radius: 6px;
    padding: 3px 8px !important;
    transition: all 0.15s ease;
}
.notif-delete-btn:hover {
    color: #dc2626 !important;
    background: #fee2e2;
}
.notif-markread-btn {
    color: #64748b;
    text-decoration: none !important;
    border-radius: 6px;
    padding: 3px 8px !important;
    transition: all 0.15s ease;
}
.notif-markread-btn:hover {
    color: #1a685b !important;
    background: #e6f0ee;
}
.text-xxs {
    font-size: 0.68rem !important;
}
.btn-xs {
    padding: 0.25rem 0.6rem !important;
    font-size: 0.72rem !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Instant client-side search
    var searchInput = document.getElementById('notifSearchInput');
    var items = document.querySelectorAll('.notif-item');
    var noResults = document.getElementById('noSearchResults');

    if (searchInput && items.length > 0) {
        searchInput.addEventListener('input', function() {
            var q = this.value.toLowerCase().trim();
            var visibleCount = 0;

            items.forEach(function(item) {
                var title = item.getAttribute('data-title') || '';
                var message = item.getAttribute('data-message') || '';
                var category = item.getAttribute('data-category') || '';

                if (title.indexOf(q) !== -1 || message.indexOf(q) !== -1 || category.indexOf(q) !== -1) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (noResults) {
                if (visibleCount === 0) {
                    noResults.classList.remove('d-none');
                } else {
                    noResults.classList.add('d-none');
                }
            }
        });
    }

    // AJAX single mark as read
    document.querySelectorAll('.mark-read-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var notifId = this.getAttribute('data-id');
            var formData = new FormData(this);
            var row = document.getElementById('notif-row-' + notifId);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data && data.success) {
                    if (row) {
                        row.classList.remove('notif-unread');
                        row.classList.add('notif-read');
                        var indicator = row.querySelector('.unread-indicator');
                        if (indicator) indicator.remove();
                        var btn = form.querySelector('button');
                        if (btn) btn.remove();
                    }
                    // Decrement unread numbers across the interface
                    var unreadEls = document.querySelectorAll('.unread-count-num, .unread-pill-num, .unread-header-count, .navbar-notif-badge, .notif-badge');
                    unreadEls.forEach(function(el) {
                        var cur = parseInt(el.textContent, 10) || 0;
                        if (cur > 1) {
                            el.textContent = cur - 1;
                        } else {
                            el.textContent = '0';
                            if (el.classList.contains('navbar-notif-badge') || el.classList.contains('notif-badge')) {
                                el.classList.add('d-none');
                            }
                        }
                    });
                } else {
                    form.submit();
                }
            })
            .catch(function() {
                form.submit();
            });
        });
    });

    // AJAX single delete
    document.querySelectorAll('.delete-notif-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!confirm('Delete this notification?')) return;
            var notifId = this.getAttribute('data-id');
            var formData = new FormData(this);
            var row = document.getElementById('notif-row-' + notifId);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data && data.success) {
                    if (row) {
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(20px)';
                        setTimeout(function() { row.remove(); }, 250);
                    }
                } else {
                    form.submit();
                }
            })
            .catch(function() {
                form.submit();
            });
        });
    });
});
</script>
