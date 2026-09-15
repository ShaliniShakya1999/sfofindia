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
                            <?php 
                                $ev_date = !empty($event['event_date']) ? $event['event_date'] : (!empty($event['date']) ? $event['date'] : 'now');
                                $ev_desc = !empty($event['body']) ? $event['body'] : (!empty($event['description']) ? $event['description'] : '');
                                $ev_img = !empty($event['image']) ? base_url($event['image']) : '';
                            ?>
                            <div class="col-md-4" id="event-<?php echo (int)($event['id'] ?? 0); ?>">
                                <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius:14px; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                                    <?php if ($ev_img !== ''): ?>
                                        <div style="height: 160px; overflow: hidden;">
                                            <img src="<?php echo html_escape($ev_img); ?>" alt="<?php echo html_escape($event['title'] ?? 'Event'); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body p-4 d-flex flex-column">
                                        <?php if ($ev_img === ''): ?>
                                            <div class="bg-gradient-warning border-radius-md p-3 mb-3 d-inline-block align-self-start">
                                                <i class="material-symbols-rounded text-white">event</i>
                                            </div>
                                        <?php endif; ?>
                                        <h6 class="font-weight-bolder mb-1"><?php echo html_escape($event['title'] ?? 'Event'); ?></h6>
                                        <p class="text-xs text-muted mb-2">
                                            <i class="material-symbols-rounded text-xs align-middle">calendar_month</i>
                                            <b><?php echo date('d M Y', strtotime($ev_date)); ?></b>
                                        </p>
                                        <p class="text-xs text-muted mb-3 flex-grow-1" style="line-height: 1.5;"><?php echo html_escape($ev_desc); ?></p>
                                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                            <span class="badge bg-gradient-success rounded-pill px-3 py-1">Open</span>
                                            <a href="<?php echo site_url('contact'); ?>" class="btn btn-sm btn-outline-primary rounded-pill mb-0 px-3">Join / Contact</a>
                                        </div>
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
