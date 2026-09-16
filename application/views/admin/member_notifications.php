<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">

    <!-- Top Header Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:16px; background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%);">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; border: 1.5px solid rgba(255,255,255,0.3); flex-shrink: 0;">
                                <i class="material-symbols-rounded text-white" style="font-size:30px;">notifications_active</i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 font-weight-bolder">Notifications & Member Updates</h4>
                                <p class="text-white text-sm mb-0 opacity-9">Stay informed about your membership, foundation causes, upcoming events, and official announcements.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge px-3 py-2 text-xs font-weight-bold" style="background: rgba(255,255,255,0.2); color: #ffffff; border-radius: 30px; border: 1px solid rgba(255,255,255,0.35);">
                                <i class="material-symbols-rounded text-xs me-1 align-middle">campaign</i>
                                <?= count($notifications); ?> Total Updates
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats & Category Filter Cards -->
    <div class="member-stat-grid mb-4">
        <!-- All Updates -->
        <div class="card border-0 shadow-sm h-100 stat-filter-btn active-filter" data-category="all" style="border-radius: 14px; cursor: pointer; border: 2px solid rgba(26,104,91,0.4) !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-xs text-uppercase font-weight-bold text-muted d-block mb-1">All Updates</span>
                        <h4 class="font-weight-bolder text-dark mb-0 count-num"><?= $counts['all'] ?? count($notifications); ?></h4>
                    </div>
                    <div class="stat-icon-badge" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); box-shadow: 0 4px 10px rgba(30,41,59,0.28);">
                        <i class="material-symbols-rounded" style="font-size:22px; color:#fff;">all_inbox</i>
                    </div>
                </div>
            </div>
        </div>
        <!-- My Account -->
        <div class="card border-0 shadow-sm h-100 stat-filter-btn" data-category="account" style="border-radius: 14px; cursor: pointer; border: 2px solid transparent !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-xs text-uppercase font-weight-bold text-muted d-block mb-1">My Account</span>
                        <h4 class="font-weight-bolder mb-0 count-num" style="color: #0f766e !important;"><?= $counts['account'] ?? 0; ?></h4>
                    </div>
                    <div class="stat-icon-badge" style="background: linear-gradient(135deg, #0d9488 0%, #1a685b 100%); box-shadow: 0 4px 10px rgba(26,104,91,0.30);">
                        <i class="material-symbols-rounded" style="font-size:22px; color:#fff;">badge</i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Donations -->
        <div class="card border-0 shadow-sm h-100 stat-filter-btn" data-category="donations" style="border-radius: 14px; cursor: pointer; border: 2px solid transparent !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-xs text-uppercase font-weight-bold text-muted d-block mb-1">Donations</span>
                        <h4 class="font-weight-bolder mb-0 count-num" style="color: #15803d !important;"><?= $counts['donations'] ?? 0; ?></h4>
                    </div>
                    <div class="stat-icon-badge" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); box-shadow: 0 4px 10px rgba(22,163,74,0.30);">
                        <i class="material-symbols-rounded" style="font-size:22px; color:#fff;">payments</i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Campaigns -->
        <div class="card border-0 shadow-sm h-100 stat-filter-btn" data-category="campaigns" style="border-radius: 14px; cursor: pointer; border: 2px solid transparent !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-xs text-uppercase font-weight-bold text-muted d-block mb-1">Campaigns</span>
                        <h4 class="font-weight-bolder mb-0 count-num" style="color: #c2410c !important;"><?= $counts['campaigns'] ?? 0; ?></h4>
                    </div>
                    <div class="stat-icon-badge" style="background: linear-gradient(135deg, #ea580c 0%, #f59e0b 100%); box-shadow: 0 4px 10px rgba(245,158,11,0.30);">
                        <i class="material-symbols-rounded" style="font-size:22px; color:#fff;">volunteer_activism</i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Events & News -->
        <div class="card border-0 shadow-sm h-100 stat-filter-btn" data-category="events" style="border-radius: 14px; cursor: pointer; border: 2px solid transparent !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-xs text-uppercase font-weight-bold text-muted d-block mb-1">Events & News</span>
                        <h4 class="font-weight-bolder mb-0 count-num" style="color: #4338ca !important;"><?= ($counts['events'] ?? 0) + ($counts['updates'] ?? 0); ?></h4>
                    </div>
                    <div class="stat-icon-badge" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); box-shadow: 0 4px 10px rgba(99,102,241,0.30);">
                        <i class="material-symbols-rounded" style="font-size:22px; color:#fff;">event_available</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Tab Filter Toolbar -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-body p-3">
                    <div class="row g-2 align-items-center justify-content-between">
                        <div class="col-md-5 col-12">
                            <div class="member-search-box d-flex align-items-center">
                                <i class="material-symbols-rounded me-2" style="font-size:20px; color:#1a685b; flex-shrink:0;">search</i>
                                <input type="text" id="notifSearch"
                                       class="form-control border-0 bg-transparent p-0"
                                       style="font-size:0.86rem; font-weight:500; color:#1e293b; box-shadow:none;"
                                       placeholder="Search notices, campaigns, events, documents..."
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-7 col-12 text-md-end">
                            <div class="d-inline-flex flex-wrap gap-1" id="filterPills">
                                <button type="button" class="btn btn-xs filter-pill active mb-0" data-category="all" style="border-radius: 8px;">All (<?= count($notifications); ?>)</button>
                                <button type="button" class="btn btn-xs filter-pill mb-0" data-category="account" style="border-radius: 8px;">Account (<?= $counts['account'] ?? 0; ?>)</button>
                                <button type="button" class="btn btn-xs filter-pill mb-0" data-category="donations" style="border-radius: 8px;">Donations (<?= $counts['donations'] ?? 0; ?>)</button>
                                <button type="button" class="btn btn-xs filter-pill mb-0" data-category="campaigns" style="border-radius: 8px;">Campaigns (<?= $counts['campaigns'] ?? 0; ?>)</button>
                                <button type="button" class="btn btn-xs filter-pill mb-0" data-category="events" style="border-radius: 8px;">Events (<?= $counts['events'] ?? 0; ?>)</button>
                                <button type="button" class="btn btn-xs filter-pill mb-0" data-category="updates" style="border-radius: 8px;">Updates (<?= $counts['updates'] ?? 0; ?>)</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Feed Items -->
    <div class="row">
        <div class="col-12" id="notifContainer">
            <?php if (!empty($notifications)): ?>
                <?php foreach ($notifications as $n): ?>
                    <div class="card border-0 shadow-sm mb-3 notif-item"
                         data-category="<?= html_escape($n['category']); ?>"
                         data-title="<?= html_escape(strtolower($n['title'])); ?>"
                         data-body="<?= html_escape(strtolower($n['body'])); ?>"
                         style="border-radius: 14px; border: 1px solid #edf2f6; transition: transform 0.15s ease, box-shadow 0.15s ease;">
                        <div class="card-body p-3 p-md-4">
                            <div class="row align-items-center g-3">
                                <!-- Left Icon -->
                                <div class="col-auto">
                                    <div class="icon-squircle d-flex align-items-center justify-content-center"
                                         style="width: 48px; height: 48px; border-radius: 12px; background: <?= $n['badge_bg'] ?? '#e6f0ee'; ?>; color: <?= $n['color'] ?? '#1a685b'; ?>; flex-shrink: 0;">
                                        <i class="material-symbols-rounded" style="font-size: 24px;"><?= $n['icon']; ?></i>
                                    </div>
                                </div>

                                <!-- Center Content -->
                                <div class="col">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <span class="badge text-xxs px-2 py-1 font-weight-bold"
                                              style="background: <?= $n['badge_bg'] ?? '#e6f0ee'; ?>; color: <?= $n['color'] ?? '#1a685b'; ?>; border-radius: 6px; letter-spacing: 0.03em;">
                                            <?= html_escape($n['category_label'] ?? strtoupper($n['category'])); ?>
                                        </span>
                                        <?php if (!empty($n['is_new'])): ?>
                                            <span class="badge bg-danger text-white text-xxs px-2 py-0" style="border-radius: 4px;">NEW</span>
                                        <?php endif; ?>
                                        <span class="text-xs text-muted ms-auto">
                                            <i class="material-symbols-rounded text-xs align-middle">schedule</i>
                                            <?= html_escape($n['time']); ?>
                                        </span>
                                    </div>
                                    <h6 class="mb-1 font-weight-bolder text-dark" style="font-size: 0.95rem;"><?= html_escape($n['title']); ?></h6>
                                    <p class="text-sm text-secondary mb-0" style="line-height: 1.5;"><?= html_escape($n['body']); ?></p>
                                </div>

                                <!-- Right CTA Action Button -->
                                <?php if (!empty($n['link'])): ?>
                                    <div class="col-12 col-md-auto text-md-end pt-2 pt-md-0 border-top border-top-md-0">
                                        <a href="<?= $n['link']; ?>"
                                           class="btn btn-sm mb-0 d-inline-flex align-items-center gap-1 action-btn"
                                           style="border-radius: 10px; font-weight: 600; font-size: 0.78rem; padding: 0.45rem 1rem; background: #f8fafc; color: #1a685b; border: 1.5px solid #d1e3e0;">
                                            <span><?= html_escape($n['link_text'] ?? 'View Details'); ?></span>
                                            <i class="material-symbols-rounded text-xs">arrow_forward</i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body text-center py-5">
                        <div class="icon-circle mb-3" style="width: 64px; height: 64px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8;">
                            <i class="material-symbols-rounded" style="font-size: 32px;">notifications_off</i>
                        </div>
                        <h5 class="text-dark font-weight-bold">No Notifications Yet</h5>
                        <p class="text-sm text-muted mb-0">You're all caught up! Check back later for foundation activities and updates.</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Empty Search Results Placeholder -->
            <div id="noResults" class="card border-0 shadow-sm d-none" style="border-radius: 16px;">
                <div class="card-body text-center py-5">
                    <div class="icon-circle mb-3" style="width: 64px; height: 64px; border-radius: 50%; background: #f8fafc; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8;">
                        <i class="material-symbols-rounded" style="font-size: 32px;">search_off</i>
                    </div>
                    <h6 class="text-dark font-weight-bold mb-1">No matching notifications found</h6>
                    <p class="text-xs text-muted mb-0">Try clearing your search query or switching to another category tab.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* 5-column equal stat grid */
.member-stat-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
}
@media (max-width: 991px) {
    .member-stat-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 575px) {
    .member-stat-grid { grid-template-columns: repeat(2, 1fr); }
}

/* Vivid icon squircle badge */
.stat-icon-badge {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* High-contrast search box */
.member-search-box {
    background: #ffffff;
    border: 1.5px solid #94a3b8;
    border-radius: 10px;
    padding: 7px 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.member-search-box:focus-within {
    border-color: #1a685b;
    box-shadow: 0 0 0 3px rgba(26,104,91,0.15);
}
.member-search-box input::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

/* Stat card interactions */
.stat-filter-btn {
    transition: none;
    cursor: pointer;
}
.stat-filter-btn:hover {
    transform: none !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.07) !important;
}
.stat-filter-btn.active-filter {
    border-color: rgba(26,104,91,0.5) !important;
    background: #f0faf8 !important;
}

/* Notification feed cards */
.notif-item:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.07) !important;
    border-color: rgba(26,104,91,0.3) !important;
}
.action-btn:hover {
    background: #1a685b !important;
    color: #ffffff !important;
    border-color: #1a685b !important;
}

/* Filter pills */
.filter-pill {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.3rem 0.75rem;
    transition: background 0.12s ease, color 0.12s ease, border-color 0.12s ease;
}
.filter-pill:hover {
    background: #e2e8f0;
    color: #1e293b;
    border-color: #94a3b8;
}
.filter-pill.active {
    background: #1a685b !important;
    border-color: #1a685b !important;
    color: #ffffff !important;
}
.text-xxs {
    font-size: 0.68rem !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('notifSearch');
    var items = document.querySelectorAll('.notif-item');
    var noResults = document.getElementById('noResults');
    var filterPills = document.querySelectorAll('.filter-pill');
    var statCards = document.querySelectorAll('.stat-filter-btn');
    var activeCategory = 'all';

    function applyFilters() {
        var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        var visibleCount = 0;

        items.forEach(function(item) {
            var cat = item.getAttribute('data-category') || '';
            var title = item.getAttribute('data-title') || '';
            var body = item.getAttribute('data-body') || '';

            var matchesCategory = false;
            if (activeCategory === 'all') {
                matchesCategory = true;
            } else if (activeCategory === 'events') {
                matchesCategory = (cat === 'events' || cat === 'updates');
            } else {
                matchesCategory = (cat === activeCategory);
            }

            var matchesQuery = (query === '' || title.indexOf(query) !== -1 || body.indexOf(query) !== -1);

            if (matchesCategory && matchesQuery) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        if (noResults) {
            if (visibleCount === 0 && items.length > 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
            }
        }
    }

    // Pill click
    filterPills.forEach(function(btn) {
        btn.addEventListener('click', function() {
            activeCategory = this.getAttribute('data-category');
            filterPills.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');

            // Also sync stat cards
            statCards.forEach(function(sc) {
                if (sc.getAttribute('data-category') === activeCategory) {
                    sc.classList.add('active-filter');
                } else {
                    sc.classList.remove('active-filter');
                }
            });

            applyFilters();
        });
    });

    // Stat card click
    statCards.forEach(function(card) {
        card.addEventListener('click', function() {
            var cat = this.getAttribute('data-category');
            var matchingPill = document.querySelector('.filter-pill[data-category="' + cat + '"]');
            if (matchingPill) {
                matchingPill.click();
            }
        });
    });

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
});
</script>