<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Set administrator password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f6f7fb; }
    .setup-card { max-width: 520px; margin: 8vh auto; border: 0; border-radius: 16px; box-shadow: 0 18px 40px rgba(15, 23, 42, .12); }
    .form-control { border-radius: 12px; padding: .65rem .8rem; }
    .btn { border-radius: 12px; font-weight: 600; }
  </style>
</head>
<body>
  <main class="container">
    <div class="card setup-card">
      <div class="card-body p-4">
        <h1 class="h4 mb-2">Set administrator password</h1>
        <p class="text-muted small">Create a unique password for the administrator account. The disabled default password will not be restored.</p>
        <?php $ci =& get_instance(); if ($ci->session->flashdata('setup_error')): ?>
          <div class="alert alert-danger"><?php echo html_escape($ci->session->flashdata('setup_error')); ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo html_escape($form_action); ?>">
          <div class="mb-3">
            <label class="form-label" for="email">Administrator email</label>
            <input id="email" type="email" name="email" class="form-control" required autofocus>
            <div class="form-text">Login OTPs will be sent to this address.</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="password">New password</label>
            <input id="password" type="password" name="password" class="form-control" minlength="12" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="password_confirm">Confirm password</label>
            <input id="password_confirm" type="password" name="password_confirm" class="form-control" minlength="12" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Save password</button>
        </form>
        <p class="small text-muted mt-3 mb-0">After saving, remove or rotate the setup token from the server environment.</p>
      </div>
    </div>
  </main>
</body>
</html>
