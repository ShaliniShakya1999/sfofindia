<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Verification — NGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .verify-card { max-width: 450px; width: 90%; background: white; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); overflow: hidden; }
        .header-bg { height: 120px; background: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%); display: flex; align-items: center; justify-content: center; }
        .photo-container { width: 120px; height: 120px; border-radius: 50%; border: 6px solid white; margin: -60px auto 10px; overflow: hidden; background: #eee; box-shadow: 0 4px 10px rgba(0,0,0,0.1); position: relative; z-index: 10; }
        .photo-container img { width: 100%; height: 100%; object-fit: cover; }
        .content { padding: 30px; text-align: center; }
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 50px; font-weight: 700; font-size: 11px; text-transform: uppercase; margin-bottom: 20px; }
        .status-verified { background: #e8f5e9; color: #2e7d32; }
        .status-invalid { background: #ffebee; color: #c62828; }
        .member-name { font-size: 24px; font-weight: 800; color: #1a237e; margin-bottom: 5px; }
        .member-id { font-size: 14px; font-weight: 600; color: #666; margin-bottom: 25px; }
        .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .info-label { color: #888; font-weight: 500; }
        .info-value { color: #333; font-weight: 700; }
        .footer-note { padding: 20px; background: #fafafa; font-size: 12px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="verify-card">
        <div class="header-bg">
            <h4 class="text-white m-0">Member Verification</h4>
        </div>

        <?php if ($status === 'verified'): ?>
            <div class="photo-container">
                <?php if (!empty($member['photo'])): ?>
                    <img src="<?php echo base_url($member['photo']); ?>" alt="Member Photo">
                <?php else: ?>
                    <img src="https://via.placeholder.com/120?text=Member" alt="Placeholder">
                <?php endif; ?>
            </div>
            <div class="content">
                <div class="status-badge status-verified">
                    <i class="fas fa-check-circle me-1"></i> Officially Verified
                </div>
                <div class="member-name"><?php echo html_escape($member['name']); ?></div>
                <div class="member-id"><?php echo html_escape($member['member_id_code'] ?? $member['public_id']); ?></div>

                <div class="info-row">
                    <span class="info-label">Current Status</span>
                    <span class="info-value text-success"><?php echo strtoupper((string)$member['status']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Valid Until</span>
                    <span class="info-value"><?php echo html_escape($member['validity_end'] ?? '—'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Mobile (Hidden)</span>
                    <span class="info-value">XXXXX - <?php echo substr((string)$member['mobile'], -4); ?></span>
                </div>

                <a href="<?php echo base_url(); ?>" class="btn btn-outline-primary w-100 rounded-pill mt-4 pt-2 pb-2 fw-bold">Back to Home</a>
            </div>
        <?php else: ?>
            <div class="content pt-5">
                <div class="pb-4">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 60px;"></i>
                </div>
                <div class="status-badge status-invalid">Invalid Member ID</div>
                <h3>Verification Failed</h3>
                <p class="text-muted">The Member ID code you scanned does not exist in our official records or has been deactivated.</p>
                <a href="<?php echo base_url(); ?>" class="btn btn-primary w-100 rounded-pill mt-3 py-2 fw-bold shadow">Visit Website</a>
            </div>
        <?php endif; ?>

        <div class="footer-note">
            Shaheed Foundation India — Secured Member Portal
        </div>
    </div>
</body>
</html>
