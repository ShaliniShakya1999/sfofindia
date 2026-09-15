<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($login_title) ? html_escape($login_title) : 'Reset Password'; ?> — Shaheed Foundation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <style>
    :root {
      --admin-radius: 16px;
      --admin-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
      --sfoi-green: #1a685b;
      --sfoi-dark: #134e4a;
    }
    body {
      background: radial-gradient(1200px 600px at 15% 10%, rgba(26, 104, 91, 0.10), transparent 55%),
                  radial-gradient(1000px 600px at 85% 30%, rgba(32, 201, 151, 0.10), transparent 55%),
                  #f6f7fb;
      min-height: 100vh;
    }
    .login-card {
      border-radius: var(--admin-radius);
      box-shadow: var(--admin-shadow);
      border: 1px solid rgba(15, 23, 42, 0.06);
      overflow: hidden;
      background: #ffffff;
    }
    .login-card .card-body { padding: 2rem; }
    .login-title { letter-spacing: -0.02em; font-weight: 700; color: #0f172a; }
    .form-control {
      border-radius: 12px;
      padding-top: .65rem;
      padding-bottom: .65rem;
      border: 1px solid #cbd5e1;
    }
    .form-control:focus {
      box-shadow: 0 0 0 .2rem rgba(26, 104, 91, 0.20);
      border-color: #1a685b;
    }
    .btn-brand {
      background: linear-gradient(135deg, #1a685b 0%, #134e4a 100%);
      color: #ffffff;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      padding: 0.65rem 1.25rem;
      transition: all 0.2s ease;
    }
    .btn-brand:hover {
      background: linear-gradient(135deg, #134e4a 0%, #0f3d3a 100%);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(26, 104, 91, 0.28);
    }
    .icon-circle {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: #e6f0ee;
      color: #1a685b;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body class="d-flex align-items-center">
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-5">
        <div class="card login-card">
          <div class="card-body">
            <div class="text-center">
              <div class="icon-circle">
                <i class="material-symbols-rounded" style="font-size:28px;">lock_reset</i>
              </div>
              <h1 class="h4 login-title mb-2"><?php echo isset($login_title) ? html_escape($login_title) : 'Reset Password & Sign In'; ?></h1>
              <p class="text-muted small mb-4"><?php echo isset($login_subtitle) ? html_escape($login_subtitle) : 'Enter your registered Email, Username, Member ID, or Mobile number to receive a 6-digit OTP code.'; ?></p>
            </div>

            <?php $ci =& get_instance(); ?>
            <?php if ($ci->session->flashdata('forgot_error') || $ci->session->flashdata('cms_error')): ?>
              <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 small border-0 shadow-sm" style="border-radius: 10px;">
                <i class="material-symbols-rounded text-danger" style="font-size:18px;">error</i>
                <div><?php echo $ci->session->flashdata('forgot_error') ?: $ci->session->flashdata('cms_error'); ?></div>
              </div>
            <?php endif; ?>

            <?php if ($ci->session->flashdata('forgot_success') || $ci->session->flashdata('cms_success')): ?>
              <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 small border-0 shadow-sm" style="border-radius: 10px;">
                <i class="material-symbols-rounded text-success" style="font-size:18px;">check_circle</i>
                <div><?php echo $ci->session->flashdata('forgot_success') ?: $ci->session->flashdata('cms_success'); ?></div>
              </div>
            <?php endif; ?>

            <form method="post" action="<?php echo isset($form_action) ? html_escape($form_action) : site_url('admin/send_forgot_otp'); ?>">
              <?php if ($ci->config->item('csrf_protection')): ?>
                <input type="hidden" name="<?php echo $ci->security->get_csrf_token_name(); ?>" value="<?php echo $ci->security->get_csrf_hash(); ?>">
              <?php endif; ?>

              <div class="mb-3">
                <label class="form-label font-weight-bold small text-dark">Email / Username / Member ID / Mobile</label>
                <div class="input-group">
                  <input type="text" name="identifier" class="form-control" placeholder="e.g. member@gmail.com, admin, MBR0001" autocomplete="username" required autofocus>
                </div>
                <div class="form-text text-muted small mt-1">
                  We'll verify your account and send a 6-digit security code to your registered email.
                </div>
              </div>

              <button type="submit" class="btn btn-brand w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                <span>Send Verification Code</span>
                <i class="material-symbols-rounded" style="font-size:18px;">arrow_forward</i>
              </button>
            </form>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
              <a href="<?php echo site_url('admin/login'); ?>" class="text-decoration-none small text-muted d-inline-flex align-items-center gap-1">
                <i class="material-symbols-rounded" style="font-size:16px;">arrow_back</i>
                <span>Back to Sign In</span>
              </a>
              <a href="<?php echo site_url(''); ?>" class="text-decoration-none small text-muted">
                Main Website
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>