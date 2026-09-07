<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>assetsA/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?= base_url(); ?>assetsA/img/favicon.png">
  <title>Admin</title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="<?= base_url(); ?>assetsA/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?= base_url(); ?>assetsA/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="<?= base_url(); ?>assetsA/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />

  <script>
    // Global SweetAlert deletion confirmation
    function confirmDelete(url, message = 'You will not be able to revert this!') {
      Swal.fire({
        title: 'Are you sure?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        customClass: {
          container: 'swal2-top-layer',
          popup: 'border-radius-15'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
      return false;
    }

    // Modal form confirmation
    function confirmAction(form, title = 'Are you sure?', text = 'Please confirm this action.') {
      Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Confirm'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
      return false;
    }
  </script>

  <style>
    :root {
      --admin-radius: 16px;
      --admin-radius-sm: 12px;
      /* Premium Indigo Palette */
      --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      --primary-soft: rgba(79, 70, 229, 0.1);
      --glass-bg: rgba(255, 255, 255, 0.75);
      --glass-border: rgba(255, 255, 255, 0.4);
      --admin-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
      --admin-shadow-hover: 0 20px 45px rgba(79, 70, 229, 0.12);
      --text-main: #1e293b;
      --text-muted: #64748b;
    }

    body {
      background-color: #f8fafc !important;
      text-rendering: optimizeLegibility;
      -webkit-font-smoothing: antialiased;
      scroll-behavior: smooth;
    }

    /* --- Animations --- */
    @keyframes slideInUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .stagger-item {
      opacity: 0;
      animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    /* --- Sidebar Glass --- */
    #sidenav-main {
      border: 1px solid var(--glass-border) !important;
      background: var(--glass-bg) !important;
      backdrop-filter: blur(14px) saturate(180%);
      box-shadow: var(--admin-shadow) !important;
      transition: all 0.3s ease;
    }

    #sidenav-main .navbar-nav .nav-link {
      transition: all 0.2s ease;
      margin: 4px 12px !important;
      border-radius: 12px !important;
    }

    #sidenav-main .nav-link.active {
      background: var(--primary-gradient) !important;
      box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25) !important;
      transform: scale(1.02);
    }

    /* --- Cards Premium --- */
    .main-content .card {
      border: 1px solid rgba(0,0,0,0.05) !important;
      border-radius: var(--admin-radius) !important;
      box-shadow: var(--admin-shadow) !important;
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
    }

    .main-content .card:hover {
      transform: translateY(-5px);
      box-shadow: var(--admin-shadow-hover) !important;
    }

    /* --- Form Controls --- */
    .form-control, .form-select {
      border: 1px solid #e2e8f0 !important;
      transition: all 0.2s ease !important;
    }

    .form-control:focus {
      border-color: #4f46e5 !important;
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
      background: #fff !important;
    }

    /* --- Buttons --- */
    .btn-primary {
      background: var(--primary-gradient) !important;
      border: none !important;
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2) !important;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3) !important;
    }

    /* --- Layout Elements --- */
    #navbarBlur {
      background: var(--glass-bg) !important;
      backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--glass-border);
      margin-top: 15px !important;
    }

    .navbar-brand-img {
      filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Apply staggered animation to sidebar links
        const navLinks = document.querySelectorAll('#sidenav-main .nav-item');
        navLinks.forEach((link, index) => {
            link.classList.add('stagger-item');
            link.style.animationDelay = (index * 0.04) + 's';
        });
    });
  </script>





  <!-- boootstrap css -->


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="<?= base_url(); ?>assetsA/js/admin-image-upload.js?v=1"></script>
</head>
<script>
  var base_url = "<?= base_url(); ?>";
</script>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="<?= site_url('admin'); ?>">
        <img src="<?= base_url(); ?>assetsA/img/ngo-logo.png" class="navbar-brand-img" width="35" height="35" alt="NGO Logo">
        <span class="ms-1 text-sm text-dark">Website admin</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <?php
      $CI =& get_instance();
      $cc = strtolower((string) $CI->router->fetch_class());
      $current_tab = strtolower((string) $CI->input->get('tab'));
      $current_status = strtolower((string) $CI->input->get('status'));
      $nav = 'nav-link text-dark';
      $act = 'nav-link active bg-gradient-dark text-white';
      $panel_user_type = (string) $CI->session->userdata('panel_user_type');
      if ($panel_user_type === '') {
        $panel_user_type = 'admin';
      }
      $is_member_panel = ($panel_user_type === 'member');
      $admin_method = strtolower((string) $CI->router->fetch_method());
      $c_dashboard = ($cc === 'admin' && $admin_method === 'index') ? $act : $nav;
      $c_member_profile = ($cc === 'admin' && $admin_method === 'profile') ? $act : $nav;
      $current_member_doc = ($cc === 'admin' && $admin_method === 'member_document') ? strtolower((string) $CI->uri->segment(3)) : '';
      $c_member_id_card = ($current_member_doc === 'id-card') ? $act : $nav;
      $c_member_appointment = ($current_member_doc === 'appointment-letter') ? $act : $nav;
      $c_member_certificate = ($current_member_doc === 'certificate') ? $act : $nav;
      $c_cms_settings = ($cc === 'cms') ? $act : $nav;
      $c_members = ($cc === 'members') ? $act : $nav;
      $c_cms_dashboard = ($cc === 'cms' && $admin_method === 'dashboard') ? $act : $nav;
      $c_donations = ($cc === 'donations') ? $act : $nav;
      $c_unverified = ($cc === 'members' && $current_status === 'pending') ? $act : $nav;
      $c_verified = ($cc === 'members' && $current_status === 'active') ? $act : $nav;
      $c_pending_renewals = ($cc === 'members' && $current_status === 'inactive') ? $act : $nav;
      $c_renewal_payment = ($cc === 'donations') ? $act : $nav;
      $c_donation_payment = ($cc === 'donations') ? $act : $nav;
      $c_crowdfunding_payment = ($cc === 'cms' && $current_tab === 'campaigns') ? $act : $nav;
      $c_all_activities = ($cc === 'cms' && $current_tab === 'reports') ? $act : $nav;
      $c_upcoming_event = ($cc === 'cms' && $current_tab === 'events') ? $act : $nav;
      $c_management_team = ($cc === 'cms' && $current_tab === 'pages') ? $act : $nav;
      $c_upload_crowdfunding = ($cc === 'cms' && $current_tab === 'campaigns') ? $act : $nav;
      $c_manager_list = ($cc === 'cms' && $current_tab === 'users') ? $act : $nav;
      $c_coordinator_list = ($cc === 'cms' && $current_tab === 'users') ? $act : $nav;
      $c_coordinator_report = ($cc === 'cms' && $current_tab === 'reports') ? $act : $nav;
      $c_complain = ($cc === 'cms' && $current_tab === 'reports') ? $act : $nav;
      $c_slider_images = ($cc === 'cms' && $current_tab === 'homepage') ? $act : $nav;
      $c_certifications = ($cc === 'cms' && $current_tab === 'pages') ? $act : $nav;
      $c_achievements = ($cc === 'cms' && $current_tab === 'gallery') ? $act : $nav;
      $c_testimonials = ($cc === 'cms' && $current_tab === 'pages') ? $act : $nav;
      $c_audit_report = ($cc === 'cms' && $current_tab === 'audit') ? $act : $nav;
      $c_objective_list = ($cc === 'cms' && $CI->router->fetch_method() === 'objectives') ? $act : $nav;
      $c_projects_list = ($cc === 'cms' && $CI->router->fetch_method() === 'projects_list') ? $act : $nav;
      $c_admin_blog = ($cc === 'blog_manager') ? $act : $nav;
      $c_admin_gallery = ($cc === 'gallery_manager') ? $act : $nav;
      $c_admin_events = ($cc === 'cms' && $current_tab === 'events') ? $act : $nav;
      $c_admin_campaigns = ($cc === 'cms' && $CI->router->fetch_method() === 'campaigns_manage') ? $act : $nav;
      $c_admin_certificates = ($cc === 'certificates') ? $act : $nav;
      $c_admin_reports = ($cc === 'reports') ? $act : $nav;
      $c_admin_notifications = ($cc === 'notifications') ? $act : $nav;
      $c_admin_media = ($cc === 'media_manager') ? $act : $nav;
      $c_admin_support = ($cc === 'support_tickets') ? $act : $nav;
      $c_admin_settings = ($cc === 'system_settings') ? $act : $nav;
      $c_admin_activity = ($cc === 'activity_logs') ? $act : $nav;
      $c_admin_users = ($cc === 'admin_users') ? $act : $nav;
      $c_birthday_list = ($cc === 'members' && $CI->router->fetch_method() === 'birthdays') ? $act : $nav;
      $c_admin_campaigns = ($cc === 'cms' && $CI->router->fetch_method() === 'campaigns_manage') ? $act : $nav;
      $c_admin_events = ($cc === 'cms' && $current_tab === 'events') ? $act : $nav;
      $c_admin_certificates = ($cc === 'certificates') ? $act : $nav;
      $c_admin_reports = ($cc === 'cms' && $current_tab === 'reports') ? $act : $nav;
      $c_admin_notifications = ($cc === 'notifications') ? $act : $nav;
      $c_admin_media = ($cc === 'media_manager') ? $act : $nav;
      $c_admin_support = ($cc === 'support_tickets') ? $act : $nav;
      $c_admin_settings = ($cc === 'cms' && $current_tab === 'settings') ? $act : $nav;
      $c_admin_users = ($cc === 'cms' && $current_tab === 'users') ? $act : $nav;
      $c_admin_activity = ($cc === 'activity_logs') ? $act : $nav;
      ?>
      <ul class="navbar-nav">
        <!-- Dashboard (Shared) -->
        <li class="nav-item">
          <a class="<?= $c_dashboard; ?>" href="<?= site_url('admin'); ?>">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <?php if ($is_member_panel): ?>
          <!-- --- MEMBER PANEL --- -->
          <li class="nav-item">
            <a class="<?= $c_member_profile; ?>" href="<?= site_url('admin/profile'); ?>">
              <i class="material-symbols-rounded opacity-5">person</i>
              <span class="nav-link-text ms-1">My Profile</span>
            </a>
          </li>

          <!-- Documents -->
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">My Documents</h6>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_id_card; ?>" href="<?= site_url('admin/member_document/id-card'); ?>">
              <i class="material-symbols-rounded opacity-5">badge</i>
              <span class="nav-link-text ms-1">ID Card</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_certificate; ?>" href="<?= site_url('admin/member_document/certificate'); ?>">
              <i class="material-symbols-rounded opacity-5">workspace_premium</i>
              <span class="nav-link-text ms-1">Certificate</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_appointment; ?>" href="<?= site_url('admin/member_document/appointment-letter'); ?>">
              <i class="material-symbols-rounded opacity-5">description</i>
              <span class="nav-link-text ms-1">Appointment Letter</span>
            </a>
          </li>

          <!-- Contributions -->
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">NGO Contributions</h6>
          </li>
          <li class="nav-item">
            <a class="<?= $nav; ?>" href="<?= site_url('admin/donation'); ?>">
              <i class="material-symbols-rounded opacity-5">payments</i>
              <span class="nav-link-text ms-1">Donations 💰</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $nav; ?>" href="<?= site_url('admin/campaigns'); ?>">
              <i class="material-symbols-rounded opacity-5">campaign</i>
              <span class="nav-link-text ms-1">Campaigns 🎯</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $nav; ?>" href="<?= site_url('admin/events'); ?>">
              <i class="material-symbols-rounded opacity-5">event</i>
              <span class="nav-link-text ms-1">Events 📅</span>
            </a>
          </li>

          <!-- Account -->
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account</h6>
          </li>
          <li class="nav-item">
            <a class="<?= $nav; ?>" href="<?= site_url('admin/notifications'); ?>">
              <i class="material-symbols-rounded opacity-5">notifications</i>
              <span class="nav-link-text ms-1">Notifications 🔔</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $nav; ?>" href="<?= site_url('admin/activity'); ?>">
              <i class="material-symbols-rounded opacity-5">history</i>
              <span class="nav-link-text ms-1">My Activity 📊</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $nav; ?>" href="<?= site_url('admin/support'); ?>">
              <i class="material-symbols-rounded opacity-5">support_agent</i>
              <span class="nav-link-text ms-1">Support 💬</span>
            </a>
          </li>

          <!-- Logout -->
          <li class="nav-item mt-3">
            <a class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-lg"
               href="javascript:void(0)"
               id="member-logout-btn"
               style="border: 1px solid rgba(220,53,69,0.3); background: rgba(220,53,69,0.06); transition: all 0.3s; cursor:pointer;">
              <i class="material-symbols-rounded" style="font-size:20px; color:#dc3545;">logout</i>
              <span class="nav-link-text ms-1 font-weight-bold" style="color:#dc3545;">Logout</span>
            </a>
          </li>

        <?php else: ?>
          <!-- --- ADMIN PANEL --- -->
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">People</h6>
          </li>
          <li class="nav-item">
            <a class="<?= $c_unverified; ?>" href="<?= site_url('members'); ?>?status=pending">
              <i class="material-symbols-rounded opacity-5">person_add</i>
              <span class="nav-link-text ms-1">Unverified Members</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_verified; ?>" href="<?= site_url('members'); ?>?status=active">
              <i class="material-symbols-rounded opacity-5">verified_user</i>
              <span class="nav-link-text ms-1">Verified Members</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_pending_renewals; ?>" href="<?= site_url('members'); ?>?status=inactive">
              <i class="material-symbols-rounded opacity-5">history_toggle_off</i>
              <span class="nav-link-text ms-1">Renewals</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="<?= $c_cms_dashboard; ?>" href="<?= site_url('cms/dashboard'); ?>">
              <i class="material-symbols-rounded opacity-5">space_dashboard</i>
              <span class="nav-link-text ms-1 text-primary font-weight-bold">CMS Dashboard Hub 🚀</span>
            </a>
          </li>

          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Operations</h6>
          </li>
          <li class="nav-item">
            <a class="<?= $c_donations; ?>" href="<?= site_url('donations'); ?>">
              <i class="material-symbols-rounded opacity-5">payments</i>
              <span class="nav-link-text ms-1">Donations 💰</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_campaigns; ?>" href="<?= site_url('cms/campaigns_manage'); ?>">
              <i class="material-symbols-rounded opacity-5">campaign</i>
              <span class="nav-link-text ms-1">Campaigns 🎯</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_projects_list; ?>" href="<?= site_url('cms/projects_list'); ?>">
              <i class="material-symbols-rounded opacity-5">work</i>
              <span class="nav-link-text ms-1">Projects 🏗️</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_events; ?>" href="<?= site_url('cms/dashboard'); ?>?tab=events">
              <i class="material-symbols-rounded opacity-5">event</i>
              <span class="nav-link-text ms-1">Events 📅</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_blog; ?>" href="<?= site_url('blog_manager'); ?>">
              <i class="material-symbols-rounded opacity-5">edit_note</i>
              <span class="nav-link-text ms-1">Manage Blog 📝</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_gallery; ?>" href="<?= site_url('gallery_manager'); ?>">
              <i class="material-symbols-rounded opacity-5">image</i>
              <span class="nav-link-text ms-1">Photo Gallery 🖼️</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_certificates; ?>" href="<?= site_url('certificates'); ?>">
              <i class="material-symbols-rounded opacity-5">workspace_premium</i>
              <span class="nav-link-text ms-1">Certificates 📜</span>
            </a>
          </li>

          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Analytics & Comms</h6>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_reports; ?>" href="<?= site_url('reports'); ?>">
              <i class="material-symbols-rounded opacity-5">bar_chart</i>
              <span class="nav-link-text ms-1">Reports 📊</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_notifications; ?>" href="<?= site_url('notifications'); ?>">
              <i class="material-symbols-rounded opacity-5">notifications</i>
              <span class="nav-link-text ms-1">Notifications 🔔 <span class="badge bg-danger rounded-pill ms-auto" style="float:right; margin-top:2px; font-size:9px;">3</span></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_media; ?>" href="<?= site_url('media_manager'); ?>">
              <i class="material-symbols-rounded opacity-5">folder</i>
              <span class="nav-link-text ms-1">Media Manager 📁</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_support; ?>" href="<?= site_url('support_tickets'); ?>">
              <i class="material-symbols-rounded opacity-5">forum</i>
              <span class="nav-link-text ms-1">Support 💬</span>
            </a>
          </li>

          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">System</h6>
          </li>
          <li class="nav-item">
            <a class="<?= $c_admin_settings; ?>" href="<?= site_url('system_settings'); ?>">
              <i class="material-symbols-rounded opacity-5">settings</i>
              <span class="nav-link-text ms-1">Website Settings ⚙️</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="<?= $c_admin_activity; ?>" href="<?= site_url('activity_logs'); ?>">
              <i class="material-symbols-rounded opacity-5">history</i>
              <span class="nav-link-text ms-1">Activity Logs 🧠</span>
            </a>
          </li>

          <li class="nav-item mt-3">
            <a class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-lg"
               href="<?= site_url('admin/logout'); ?>"
               style="border: 1px solid rgba(220,53,69,0.3); background: rgba(220,53,69,0.06); transition: all 0.3s; cursor:pointer;">
              <i class="material-symbols-rounded" style="font-size:20px; color:#dc3545;">logout</i>
              <span class="nav-link-text ms-1 font-weight-bold" style="color:#dc3545;">Logout</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <!-- <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
        </nav> -->
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <ul class="navbar-nav ms-md-auto d-flex align-items-center justify-content-end w-100">
            <li class="nav-item me-2">
              <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url(); ?>" target="_blank" rel="noopener">View website</a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <?php $this->load->view($view, $data) ?>


  </main>
  <!--   Core JS Files   -->
  <script src="<?= base_url(); ?>assetsA/js/core/popper.min.js"></script>
  <script src="<?= base_url(); ?>assetsA/js/core/bootstrap.min.js"></script>
  <script src="<?= base_url(); ?>assetsA/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?= base_url(); ?>assetsA/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="<?= base_url(); ?>assetsA/js/plugins/chartjs.min.js"></script>
  <script>
  (function () {
    var el1 = document.getElementById("chart-bars");
    if (!el1) return;
    var ctx = el1.getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["M", "T", "W", "T", "F", "S", "S"],
        datasets: [{
          label: "Views",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#43A047",
          data: [50, 45, 22, 28, 50, 60, 76],
          barThickness: 'flex'
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: '#e5e5e5'
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
              color: "#737373"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  })();

  (function () {
    var el2 = document.getElementById("chart-line");
    if (!el2) return;
    var ctx2 = el2.getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
        datasets: [{
          label: "Sales",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              title: function(context) {
                const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return fullMonths[context[0].dataIndex];
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  })();

  (function () {
    var el3 = document.getElementById("chart-line-tasks");
    if (!el3) return;
    var ctx3 = el3.getContext("2d");

    new Chart(ctx3, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Tasks",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#737373',
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [4, 4]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  })();
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Control Center for Material Dashboard -->
  <script src="<?= base_url(); ?>assetsA/js/material-dashboard.min.js?v=3.2.0"></script>

  <?php if (isset($is_member_panel) && $is_member_panel): ?>
  <!-- Logout Confirmation Modal (no external library needed) -->
  <div id="logoutModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:20px; padding:36px 32px; max-width:380px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3); text-align:center; animation:slideUp 0.3s ease;">
      <div style="width:64px;height:64px;background:#fff3cd;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
        <i class="material-symbols-rounded" style="font-size:36px;color:#f59e0b;">logout</i>
      </div>
      <h5 style="font-weight:700;margin-bottom:8px;color:#1a202c;">Confirm Logout</h5>
      <p style="color:#718096;font-size:14px;margin-bottom:28px;">Are you sure you want to log out of your account?</p>
      <div style="display:flex;gap:12px;justify-content:center;">
        <button onclick="document.getElementById('logoutModal').style.display='none';"
          style="flex:1;padding:10px 20px;border:2px solid #e2e8f0;background:#fff;border-radius:50px;font-weight:600;color:#718096;cursor:pointer;font-size:14px;transition:all 0.2s;">
          Cancel
        </button>
        <a href="<?= site_url('admin/logout'); ?>"
          style="flex:1;padding:10px 20px;background:linear-gradient(135deg,#dc3545,#c82333);border:none;border-radius:50px;font-weight:600;color:#fff;cursor:pointer;font-size:14px;text-decoration:none;display:flex;align-items:center;justify-content:center;transition:all 0.2s;">
          Yes, Logout
        </a>
      </div>
    </div>
  </div>
  <style>
    @keyframes slideUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
  </style>
  <script>
    (function() {
      var btn = document.getElementById('member-logout-btn');
      var modal = document.getElementById('logoutModal');
      if (btn && modal) {
        btn.onclick = function(e) {
          e.preventDefault();
          modal.style.display = 'flex';
        };
        modal.onclick = function(e) {
          if (e.target === modal) {
            modal.style.display = 'none';
          }
        };
      }
    })();
  </script>
  <?php endif; ?>

</body>

</html>