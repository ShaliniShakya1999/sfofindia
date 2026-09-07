<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Verify OTP - NGO Admin</title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="<?php echo base_url('assets/admin/css/material-dashboard.css?v=3.1.0'); ?>" rel="stylesheet" />
</head>
<body class="bg-gray-200">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-98652d0949f3?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1 text-center">
                  <h4 class="text-white font-weight-bolder mb-0">Two-Step Verification</h4>
                  <p class="text-white text-xs mb-0">Enter the 6-digit code sent to your email</p>
                </div>
              </div>
              <div class="card-body">
                <?php if($this->session->flashdata('cms_success')): ?>
                  <div class="alert alert-success text-white text-sm" role="alert">
                    <?php echo $this->session->flashdata('cms_success'); ?>
                  </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('cms_error')): ?>
                  <div class="alert alert-danger text-white text-sm" role="alert">
                    <?php echo $this->session->flashdata('cms_error'); ?>
                  </div>
                <?php endif; ?>

                <form role="form" method="post" action="<?php echo site_url('admin/verify_otp'); ?>" class="text-start">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">6-Digit OTP</label>
                    <input type="text" name="otp" class="form-control" required maxlength="6" autofocus>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Verify & Login</button>
                  </div>
                  <p class="mt-4 text-sm text-center">
                    Incorrect email? 
                    <a href="<?php echo site_url('admin/logout'); ?>" class="text-dark font-weight-bold">Logout & Retry</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="<?php echo base_url('assets/admin/js/core/bootstrap.min.js'); ?>"></script>
</body>
</html>
