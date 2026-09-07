<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0 font-weight-bolder">Support & Web Inquiries</h4>
            <p class="text-sm text-muted mb-0">Manage messages and inquiries sent from the public website contact form.</p>
        </div>
    </div>

    <?php $ci =& get_instance(); ?>
    <?php if($ci->session->flashdata('cms_success')): ?>
        <div class="alert alert-success text-white border-0 shadow-sm"><i class="material-symbols-rounded align-middle me-2">check_circle</i> <?php echo $ci->session->flashdata('cms_success'); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <?php if(isset($table_missing) && $table_missing): ?>
                <div class="card border-0 shadow-sm text-center py-6" style="border-radius:15px;">
                    <i class="material-symbols-rounded text-muted opacity-3" style="font-size: 80px;">forum</i>
                    <h5 class="text-muted mt-3">The 'contact' table does not exist yet.</h5>
                    <p class="text-sm text-muted">Web inquiries will appear here once the contact form is used.</p>
                </div>
            <?php elseif(empty($tickets)): ?>
                <div class="card border-0 shadow-sm text-center py-6" style="border-radius:15px;">
                    <i class="material-symbols-rounded text-muted opacity-3" style="font-size: 80px;">inbox</i>
                    <h5 class="text-muted mt-3">Inbox is empty.</h5>
                    <p class="text-sm text-muted">No messages from the contact form yet.</p>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-sm" style="border-radius:15px;">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Date & Sender</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Message Snippet</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end px-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tickets as $t): ?>
                                    <tr class="border-bottom border-light">
                                        <td class="px-4">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm"><?php echo html_escape($t['name'] ?? 'Unknown'); ?></h6>
                                                <p class="text-xxs text-secondary mb-0"><?php echo html_escape($t['email'] ?? ''); ?></p>
                                                <p class="text-xxs text-muted mb-0"><?php echo isset($t['created_at']) ? date('d M, Y', strtotime($t['created_at'])) : ''; ?></p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 text-truncate" style="max-width: 250px;"><?php echo html_escape($t['subject'] ?? 'No Subject'); ?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-muted mb-0 text-truncate" style="max-width: 400px;"><?php echo html_escape($t['message'] ?? ''); ?></p>
                                        </td>
                                        <td class="text-end px-4">
                                            <button class="btn btn-link text-primary px-3 mb-0" data-bs-toggle="modal" data-bs-target="#msgModal<?php echo $t['id']; ?>">
                                                <i class="material-symbols-rounded text-sm me-1">visibility</i> View
                                            </button>
                                            <a href="javascript:void(0);" 
                                               onclick="return confirmDelete('<?php echo site_url('support_tickets/delete/'.$t['id']); ?>', 'Message will be permanently removed.');" 
                                               class="btn btn-link text-danger px-3 mb-0">
                                                <i class="material-symbols-rounded text-sm me-1">delete</i> Delete
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- View Modal -->
                                    <div class="modal fade" id="msgModal<?php echo $t['id']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-radius-lg border-0 shadow-lg">
                                                <div class="modal-header border-bottom">
                                                    <h6 class="modal-title font-weight-bold">Message Details</h6>
                                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close" style="font-size: 1.5rem;">&times;</button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="d-flex justify-content-between mb-4">
                                                        <div>
                                                            <p class="text-xxs text-uppercase text-secondary font-weight-bolder opacity-7 mb-0">From</p>
                                                            <h6 class="font-weight-bold"><?php echo html_escape($t['name'] ?? ''); ?></h6>
                                                            <p class="text-xs text-muted"><?php echo html_escape($t['email'] ?? ''); ?></p>
                                                        </div>
                                                        <div class="text-end">
                                                            <p class="text-xxs text-uppercase text-secondary font-weight-bolder opacity-7 mb-0">Date</p>
                                                            <h6 class="text-xs"><?php echo isset($t['created_at']) ? date('d M Y, h:i A', strtotime($t['created_at'])) : ''; ?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <p class="text-xxs text-uppercase text-secondary font-weight-bolder opacity-7 mb-0">Subject</p>
                                                        <h6 class="text-sm font-weight-bold"><?php echo html_escape($t['subject'] ?? 'N/A'); ?></h6>
                                                    </div>
                                                    <div class="p-3 bg-gray-100 border-radius-lg">
                                                        <p class="text-sm text-dark mb-0" style="white-space: pre-wrap;"><?php echo html_escape($t['message'] ?? ''); ?></p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top">
                                                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Close</button>
                                                    <a href="mailto:<?php echo $t['email']; ?>" class="btn bg-gradient-primary mb-0">Reply via Email</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
