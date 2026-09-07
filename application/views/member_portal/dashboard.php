<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Welcome, <?php echo html_escape($member['name']); ?></h2>
                <p class="text-muted mb-0">User ID: <?php echo html_escape(isset($member['member_user_id']) ? $member['member_user_id'] : ''); ?></p>
            </div>
            <a href="<?php echo site_url('member-panel/logout'); ?>" class="btn btn-outline-secondary">Logout</a>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5>ID Card</h5>
                        <p class="text-muted">Download your member ID card.</p>
                        <a target="_blank" href="<?php echo site_url('member-panel/document/id-card'); ?>" class="btn btn-primary">Open ID Card</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5>Appointment Letter</h5>
                        <p class="text-muted">Open your appointment / joining letter.</p>
                        <a target="_blank" href="<?php echo site_url('member-panel/document/appointment-letter'); ?>" class="btn btn-primary">Open Letter</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5>Certificate</h5>
                        <p class="text-muted">Open your generated certificate.</p>
                        <a target="_blank" href="<?php echo site_url('member-panel/document/certificate'); ?>" class="btn btn-primary">Open Certificate</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-3">Member Details</h5>
                <div class="row g-3">
                    <div class="col-md-4"><strong>Authority:</strong> <?php echo html_escape(isset($member['authority']) ? $member['authority'] : ''); ?></div>
                    <div class="col-md-4"><strong>Validity Start:</strong> <?php echo html_escape(isset($member['validity_start']) ? $member['validity_start'] : ''); ?></div>
                    <div class="col-md-4"><strong>Validity End:</strong> <?php echo html_escape(isset($member['validity_end']) ? $member['validity_end'] : ''); ?></div>
                    <div class="col-md-4"><strong>Status:</strong> <?php echo html_escape(isset($member['status']) ? $member['status'] : ''); ?></div>
                    <div class="col-md-4"><strong>Mobile:</strong> <?php echo html_escape(isset($member['mobile']) ? $member['mobile'] : ''); ?></div>
                    <div class="col-md-4"><strong>Email:</strong> <?php echo html_escape(isset($member['email']) ? $member['email'] : ''); ?></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
