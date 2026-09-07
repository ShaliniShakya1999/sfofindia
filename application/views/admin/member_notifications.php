<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:15px; background: linear-gradient(135deg,#4f46e5,#7c3aed);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                            <i class="material-symbols-rounded text-white" style="font-size:32px;">notifications</i>
                        </div>
                        <div>
                            <h4 class="text-white mb-0 font-weight-bolder">Notifications</h4>
                            <p class="text-white opacity-8 mb-0 text-sm"><?php echo count($notifications); ?> notification<?php echo count($notifications) !== 1 ? 's' : ''; ?> for you</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if (!empty($notifications)): ?>
                <?php foreach ($notifications as $n): ?>
                    <div class="card border-0 shadow-sm mb-3 notif-card" style="border-radius:12px; border-left: 4px solid <?php
                        $clr = ['primary'=>'#4f46e5','success'=>'#22c55e','warning'=>'#f59e0b','info'=>'#06b6d4'];
                        echo $clr[$n['color']] ?? '#4f46e5';
                    ?> !important;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon icon-shape bg-gradient-<?php echo $n['color']; ?> shadow-<?php echo $n['color']; ?> text-center border-radius-md flex-shrink-0" style="width:42px;height:42px;">
                                    <i class="material-symbols-rounded opacity-10 text-white" style="font-size:20px;line-height:42px;"><?php echo $n['icon']; ?></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="mb-1 font-weight-bolder text-dark"><?php echo html_escape($n['title']); ?></h6>
                                        <small class="text-muted text-xxs ms-2 flex-shrink-0"><?php echo html_escape($n['time']); ?></small>
                                    </div>
                                    <p class="text-sm text-secondary mb-0"><?php echo html_escape($n['body']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card border-0 shadow-sm" style="border-radius:15px;">
                    <div class="card-body text-center py-6">
                        <i class="material-symbols-rounded text-muted" style="font-size:72px;">notifications_off</i>
                        <h5 class="mt-3 text-secondary">No Notifications Yet</h5>
                        <p class="text-sm text-muted">You're all caught up! Check back later for updates.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.notif-card { transition: transform 0.2s, box-shadow 0.2s; }
.notif-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important; }
.py-6 { padding-top: 4rem; padding-bottom: 4rem; }
</style>
