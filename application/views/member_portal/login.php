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
                        <?php if ($ci->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?php echo $ci->session->flashdata('error'); ?></div>
                        <?php endif; ?>
                        <form method="post" action="<?php echo site_url('member-login/submit'); ?>">
                            <div class="mb-3">
                                <label class="form-label">User ID</label>
                                <input type="text" name="user_id" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
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
