<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="mb-0 font-weight-bolder">Upcoming Events</h5>
                    <p class="text-xs text-muted mb-0">Register and participate in NGO events.</p>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($events)): ?>
                        <div class="row g-4">
                        <?php foreach($events as $event): ?>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                                    <div class="card-body p-4">
                                        <div class="bg-gradient-warning border-radius-md p-3 mb-3 d-inline-block">
                                            <i class="material-symbols-rounded text-white">event</i>
                                        </div>
                                        <h6 class="font-weight-bolder mb-1"><?php echo html_escape($event['title'] ?? 'Event'); ?></h6>
                                        <p class="text-xs text-muted mb-1">
                                            <i class="material-symbols-rounded text-xs align-middle">calendar_month</i>
                                            <?php echo !empty($event['date']) ? date('d M Y', strtotime($event['date'])) : 'TBD'; ?>
                                        </p>
                                        <p class="text-xs text-muted mb-3"><?php echo html_escape($event['description'] ?? ''); ?></p>
                                        <span class="badge bg-gradient-success rounded-pill px-3">Open for Registration</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="material-symbols-rounded text-muted" style="font-size:60px;">event_busy</i>
                            <h6 class="mt-3 text-secondary">No upcoming events scheduled.</h6>
                            <p class="text-sm text-muted">Stay tuned — new events will be announced here!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
