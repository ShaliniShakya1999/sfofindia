<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="mb-3 text-center">Member Login</h3>
                        <?php $ci =& get_instance(); ?>
                        <?php $err = $ci->session->flashdata('error') ?: $ci->session->flashdata('cms_error'); if ($err): ?>
                            <div class="alert alert-danger"><?php echo html_escape($err); ?></div>
                        <?php endif; ?>
                        <?php $succ = $ci->session->flashdata('success') ?: $ci->session->flashdata('cms_success'); if ($succ): ?>
                            <div class="alert alert-success"><?php echo html_escape($succ); ?></div>
                        <?php endif; ?>
                        <form method="post" action="<?php echo site_url('member-login/submit'); ?>">
                            <?php if ($ci->config->item('csrf_protection')): ?>
                                <input type="hidden" name="<?php echo $ci->security->get_csrf_token_name(); ?>" value="<?php echo $ci->security->get_csrf_hash(); ?>">
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label">Member ID / Email / Mobile</label>
                                <input type="text" name="username" class="form-control" placeholder="e.g. MBR0001 or email" autocomplete="username" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" autocomplete="current-password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
