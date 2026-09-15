<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($login_title) ? html_escape($login_title) : 'Admin / Member Panel'; ?> — Sign in</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --admin-radius: 16px;
      --admin-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    }
    body {
      background: radial-gradient(1200px 600px at 15% 10%, rgba(13, 110, 253, 0.10), transparent 55%),
                  radial-gradient(1000px 600px at 85% 30%, rgba(32, 201, 151, 0.10), transparent 55%),
                  #f6f7fb;
    }
    .login-card {
      border-radius: var(--admin-radius);
      box-shadow: var(--admin-shadow);
      border: 1px solid rgba(15, 23, 42, 0.06);
      overflow: hidden;
    }
    .login-card .card-body { padding: 1.5rem; }
    .login-title { letter-spacing: -0.02em; }
    .form-control {
      border-radius: 12px;
      padding-top: .6rem;
      padding-bottom: .6rem;
    }
    .btn-brand {
      background: linear-gradient(135deg, #1a685b 0%, #134e4a 100%);
      color: #ffffff;
      border: none;
    }
    .btn-brand:hover {
      background: linear-gradient(135deg, #134e4a 0%, #0f3d3a 100%);
      color: #ffffff;
    }
    .form-control:focus {
      box-shadow: 0 0 0 .2rem rgba(26, 104, 91, 0.20);
      border-color: #1a685b;
    }
    .btn {
      border-radius: 12px;
      font-weight: 600;
    }
  </style>
</head>
<body class="d-flex align-items-center" style="min-height:100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card login-card mt-5">
          <div class="card-body p-4">
            <h1 class="h4 mb-3 login-title"><?php echo isset($login_title) ? html_escape($login_title) : 'Admin / Member Panel'; ?></h1>
            <p class="text-muted small"><?php echo isset($login_subtitle) ? html_escape($login_subtitle) : 'Admins and verified members can sign in here.'; ?></p>
            <?php $ci =& get_instance(); if ($ci->session->flashdata('cms_error')): ?>
              <div class="alert alert-danger"><?php echo $ci->session->flashdata('cms_error'); ?></div>
            <?php endif; ?>
            <?php if ($ci->session->flashdata('cms_success')): ?>
              <div class="alert alert-success"><?php echo $ci->session->flashdata('cms_success'); ?></div>
            <?php endif; ?>
            <form method="post" action="<?php echo isset($form_action) ? html_escape($form_action) : site_url('admin/do_login'); ?>">
              <?php if ($ci->config->item('csrf_protection')): ?>
                <input type="hidden" name="<?php echo $ci->security->get_csrf_token_name(); ?>" value="<?php echo $ci->security->get_csrf_hash(); ?>">
              <?php endif; ?>
              <div class="mb-3">
                <label class="form-label">Username / Email / Member ID / Mobile</label>
                <input type="text" name="username" class="form-control" placeholder="e.g. admin, email, or MBR0001" autocomplete="username" required autofocus>
              </div>
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label class="form-label mb-0">Password</label>
                  <a href="<?php echo site_url('admin/forgot_password'); ?>" class="text-decoration-none small" style="color: #1a685b; font-weight: 600;">Forgot Password?</a>
                </div>
                <input type="password" name="password" class="form-control" placeholder="••••••••" autocomplete="current-password" required>
              </div>
              <button type="submit" class="btn btn-brand w-100 py-2">Sign in</button>
            </form>
            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
              <p class="small text-muted mb-0"><a href="<?php echo site_url(''); ?>" class="text-decoration-none text-muted">← Back to website</a></p>
              <p class="small mb-0"><a href="<?php echo site_url('admin/forgot_password'); ?>" class="text-decoration-none" style="color: #1a685b; font-weight: 500;">Need help logging in?</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
