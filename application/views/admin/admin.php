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
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = url;
          const csrf = document.createElement('input');
          csrf.type = 'hidden';
          csrf.name = '<?php echo $this->security->get_csrf_token_name(); ?>';
          csrf.value = '<?php echo $this->security->get_csrf_hash(); ?>';
          form.appendChild(csrf);
          document.body.appendChild(form);
          form.submit();
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
      font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
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
      min-height: 42px;
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 0.65rem 0.85rem !important;
      border-radius: 12px !important;
      font-family: "Segoe UI", Arial, sans-serif !important;
      font-size: 0.95rem !important;
      font-weight: 700 !important;
      letter-spacing: 0;
      line-height: 1.4 !important;
      color: #334155 !important;
    }

    #sidenav-main .navbar-nav .nav-link .nav-link-text {
      font-size: inherit !important;
      font-weight: 700 !important;
      letter-spacing: inherit;
      white-space: nowrap;
    }

    #sidenav-main .sidenav-header .navbar-brand {
      font-family: "Segoe UI", Arial, sans-serif !important;
      font-size: 0.88rem !important;
      font-weight: 600 !important;
    }

    #sidenav-main .navbar-nav h6 {
      font-family: "Segoe UI", Arial, sans-serif !important;
      font-size: 0.74rem !important;
      font-weight: 800 !important;
      letter-spacing: 0.08em;
      color: #334155 !important;
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

    /* --- Scrollbar Customization --- */
    .sidenav,
    #sidenav-main {
      overflow: hidden !important;
      overflow-y: hidden !important;
    }

    #sidenav-collapse-main,
    .navbar-vertical.navbar-expand-xs .navbar-collapse {
      height: calc(100vh - 100px) !important;
      max-height: calc(100vh - 100px) !important;
      overflow-y: auto !important;
      overflow-x: hidden !important;
      scrollbar-width: thin;
      scrollbar-color: rgba(0, 0, 0, 0.15) transparent;
    }

    #sidenav-collapse-main::-webkit-scrollbar,
    .navbar-vertical.navbar-expand-xs .navbar-collapse::-webkit-scrollbar {
      width: 5px;
    }

    #sidenav-collapse-main::-webkit-scrollbar-track,
    .navbar-vertical.navbar-expand-xs .navbar-collapse::-webkit-scrollbar-track {
      background: transparent;
    }

    #sidenav-collapse-main::-webkit-scrollbar-thumb,
    .navbar-vertical.navbar-expand-xs .navbar-collapse::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.12);
      border-radius: 10px;
      transition: background 0.2s ease;
    }

    #sidenav-main:hover #sidenav-collapse-main::-webkit-scrollbar-thumb,
    #sidenav-collapse-main:hover::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.28);
    }

    #sidenav-collapse-main::-webkit-scrollbar-thumb:hover {
      background: rgba(0, 0, 0, 0.45);
    }

    /* Floating PerfectScrollbar rail overrides if PS active */
    .ps__rail-y {
      width: 6px !important;
      background: transparent !important;
      opacity: 0;
      transition: opacity 0.2s linear;
      right: 2px !important;
    }
    .ps:hover > .ps__rail-y,
    .ps--scrolling-y > .ps__rail-y {
      opacity: 0.8 !important;
    }
    .ps__thumb-y {
      width: 5px !important;
      background-color: rgba(0, 0, 0, 0.2) !important;
      border-radius: 10px !important;
      right: 0 !important;
    }
    .ps__rail-y:hover > .ps__thumb-y {
      background-color: rgba(0, 0, 0, 0.4) !important;
    }

    /* Global sleek scrollbars for the rest of admin tables & page */
    * {
      scrollbar-width: thin;
      scrollbar-color: rgba(0, 0, 0, 0.18) transparent;
    }

    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: transparent;
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.16);
      border-radius: 8px;
    }
    /* Refined, uncluttered sidebar dimensions for all desktop & laptop screens */
    #sidenav-main.navbar-vertical {
      max-width: 17rem !important; /* 272px width */
      width: 17rem !important;
    }
    @media (min-width: 992px) {
      .g-sidenav-show .sidenav.fixed-start + .main-content {
        margin-left: 17.75rem !important; /* 284px margin */
      }
    }

    /* Refined typography and spacing for primary nav links and accordion toggles */
    #sidenav-main .navbar-nav > .nav-item > .nav-link,
    #sidenav-main .sidebar-toggle {
      display: flex !important;
      align-items: center !important;
      padding: 0.42rem 0.7rem !important;
      margin: 2px 0.5rem !important;
      border-radius: 0.45rem !important;
      font-size: 0.8125rem !important; /* 13px */
      font-weight: 500 !important;
      letter-spacing: 0.005em;
      color: #334155 !important;
      user-select: none;
      transition: all 0.15s ease-in-out;
      box-sizing: border-box;
    }

    #sidenav-main .navbar-nav > .nav-item > .nav-link .nav-link-text,
    #sidenav-main .sidebar-toggle .nav-link-text {
      font-size: 0.8125rem !important;
      font-weight: 500 !important;
      letter-spacing: 0.005em;
    }

    #sidenav-main .navbar-nav > .nav-item > .nav-link:hover,
    #sidenav-main .sidebar-toggle:hover {
      background-color: rgba(0, 0, 0, 0.04) !important;
      color: #0f172a !important;
    }

    /* Svelte, proportionate primary icon sizing */
    #sidenav-main .navbar-nav > .nav-item > .nav-link i,
    #sidenav-main .navbar-nav > .nav-item > .nav-link .material-symbols-rounded,
    #sidenav-main .sidebar-toggle i,
    #sidenav-main .sidebar-toggle .material-symbols-rounded {
      font-size: 1.15rem !important;
      width: 20px !important;
      min-width: 20px !important;
      height: 20px !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      margin-right: 0.65rem !important;
      color: #64748b !important;
      flex-shrink: 0;
    }

    /* Chevron arrow styling */
    .sidebar-arrow {
      width: 13px;
      height: 13px;
      transition: transform 0.22s cubic-bezier(0.4, 0, 0.2, 1);
      opacity: 0.45;
      flex-shrink: 0;
    }
    .sidebar-toggle[aria-expanded="true"] .sidebar-arrow {
      transform: rotate(180deg);
      opacity: 0.8;
    }

    /* Submenu tree indentation and layout */
    .sidebar-submenu {
      list-style: none;
      margin: 0.15rem 0.5rem 0.35rem 1.35rem !important;
      padding: 0.12rem 0 0.12rem 0.6rem !important;
      border-left: 1.5px solid rgba(0, 0, 0, 0.08) !important;
    }
    .sidebar-submenu .nav-item {
      width: 100%;
      margin: 1px 0;
    }
    .sidebar-submenu .nav-link {
      display: flex !important;
      align-items: center !important;
      padding: 0.34rem 0.55rem !important;
      font-size: 0.775rem !important; /* 12.4px */
      font-weight: 400 !important;
      letter-spacing: 0.005em;
      margin: 0 !important;
      width: 100% !important;
      border-radius: 0.375rem !important;
      color: #475569 !important;
      transition: all 0.15s ease-in-out;
      box-sizing: border-box;
    }
    .sidebar-submenu .nav-link .nav-link-text {
      font-size: 0.775rem !important;
      font-weight: 400 !important;
      letter-spacing: 0.005em;
    }
    .sidebar-submenu .nav-link:hover {
      background-color: rgba(0, 0, 0, 0.035) !important;
      color: #0f172a !important;
    }

    /* Submenu icons */
    .sidebar-submenu .nav-link i,
    .sidebar-submenu .nav-link .material-symbols-rounded {
      font-size: 1.05rem !important;
      width: 18px !important;
      min-width: 18px !important;
      height: 18px !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      margin-right: 0.55rem !important;
      color: #64748b !important;
      flex-shrink: 0;
    }

    /* Modern active link style */
    #sidenav-main .nav-link.active {
      background-image: linear-gradient(195deg, #374151 0%, #111827 100%) !important;
      color: #ffffff !important;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.18) !important;
    }
    #sidenav-main .nav-link.active .nav-link-text,
    #sidenav-main .nav-link.active i,
    #sidenav-main .nav-link.active .material-symbols-rounded {
      color: #ffffff !important;
      opacity: 1 !important;
      font-weight: 500 !important;
    }
    #sidenav-main .nav-link.active .badge {
      background-color: rgba(255, 255, 255, 0.22) !important;
      color: #ffffff !important;
      border: none !important;
      box-shadow: none !important;
    }

    /* Prevent rogue bold utility classes inside sidebar */
    #sidenav-main .font-weight-bold,
    #sidenav-main .fw-bold {
      font-weight: 500 !important;
    }

    /* Dainty, refined badge pills */
    #sidenav-main .badge {
      font-size: 0.625rem !important;
      font-weight: 500 !important;
      padding: 1.5px 6px !important;
      border-radius: 50rem !important;
      line-height: 1.2 !important;
      letter-spacing: 0.02em;
      flex-shrink: 0;
    }
    #sidenav-main .sidebar-submenu .nav-link .badge,
    #sidenav-main .navbar-nav > .nav-item > .nav-link .badge {
      margin-left: auto !important;
    }

    /* Suppress Material Dashboard default ::after chevron */
    .navbar-vertical .navbar-nav .nav-link.sidebar-toggle:after,
    .navbar-vertical .navbar-nav .nav-link[data-sidebar-toggle]:after,
    .navbar-vertical .navbar-nav .nav-link[data-bs-toggle=collapse]:after {
      display: none !important;
      content: none !important;
    }

    /* Strict collapse show/hide display enforcement */
    #sidenav-collapse-main .collapse {
      transition: none !important;
    }
    #sidenav-collapse-main .collapse:not(.show) {
      display: none !important;
      height: 0 !important;
    }
    #sidenav-collapse-main .collapse.show {
      display: block !important;
      height: auto !important;
      opacity: 1 !important;
    }
    #sidenav-main .sidebar-submenu,
    #sidenav-main .sidebar-submenu .nav-item,
    #sidenav-main .sidebar-submenu .nav-link {
      opacity: 1 !important;
      animation: none !important;
      transform: none !important;
    }
  </style>





  <!-- boootstrap css -->


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

      $CI->load->database();

      // Dynamic real-time metrics for navigation badges
      $unread_notifications_count = 0;
      if ($CI->db->table_exists('ngom_notifications')) {
          $CI->db->where('is_read', 0);
          $unread_notifications_count = (int) $CI->db->count_all_results('ngom_notifications');
      }

      $pending_members_count = 0;
      $active_members_count = 0;
      $inactive_members_count = 0;
      if ($CI->db->table_exists('members')) {
          $pending_members_count = (int) $CI->db->where('status', 'pending')->count_all_results('members');
          $active_members_count = (int) $CI->db->where('status', 'active')->count_all_results('members');
          $inactive_members_count = (int) $CI->db->where('status', 'inactive')->count_all_results('members');
      }
      $people_pending_total = $pending_members_count + $inactive_members_count;

      $donations_count = 0;
      if ($CI->db->table_exists('donations')) {
          $donations_count = (int) $CI->db->count_all_results('donations');
      }

      $campaigns_count = 0;
      if ($CI->db->table_exists('ngom_campaigns')) {
          $campaigns_count = (int) $CI->db->where('status', 'active')->count_all_results('ngom_campaigns');
      }

      $support_count = 0;
      if ($CI->db->table_exists('contact')) {
          $support_count = (int) $CI->db->count_all_results('contact');
      }

      $activity_count = 0;
      if ($CI->db->table_exists('ngom_admin_activity')) {
          $activity_count = (int) $CI->db->count_all_results('ngom_admin_activity');
      }

      $admin_users_count = 0;
      if ($CI->db->table_exists('admin_users')) {
          $admin_users_count = (int) $CI->db->count_all_results('admin_users');
      }

      $admin_role = (string) $CI->session->userdata('cms_admin_role');
      $is_super_admin = ($admin_role === 'super_admin');
      $admin_method = strtolower((string) $CI->router->fetch_method());
      $c_dashboard = ($cc === 'admin' && $admin_method === 'index') ? $act : $nav;
      $c_member_profile = ($cc === 'admin' && $admin_method === 'profile') ? $act : $nav;
      $c_member_renew = ($cc === 'admin' && $admin_method === 'renew') ? $act : $nav;
      $member_renew_status = '';
      if ($is_member_panel) {
          $mid = (int) $CI->session->userdata('cms_member_id');
          if ($mid > 0 && $CI->db->table_exists('members')) {
              $row = $CI->db->get_where('members', array('id' => $mid), 1)->row_array();
              $member_renew_status = $row['status'] ?? '';
          }
      }
      $current_member_doc = ($cc === 'admin' && $admin_method === 'member_document') ? strtolower((string) $CI->uri->segment(3)) : '';
      $c_member_id_card = ($current_member_doc === 'id-card') ? $act : $nav;
      $c_member_appointment = ($current_member_doc === 'appointment-letter') ? $act : $nav;
      $c_member_certificate = ($current_member_doc === 'certificate') ? $act : $nav;
      $c_member_donation = ($cc === 'admin' && in_array($admin_method, array('donation', 'donation_history'))) ? $act : $nav;
      $c_member_campaigns = ($cc === 'admin' && $admin_method === 'campaigns') ? $act : $nav;
      $c_member_events = ($cc === 'admin' && $admin_method === 'events') ? $act : $nav;
      $c_member_notifications = ($cc === 'admin' && $admin_method === 'notifications') ? $act : $nav;
      $c_member_activity = ($cc === 'admin' && $admin_method === 'activity') ? $act : $nav;
      $c_member_support = ($cc === 'admin' && $admin_method === 'support') ? $act : $nav;
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
      $c_admin_blog = ($cc === 'blog_manager') ? $act : $nav;
      $c_admin_gallery = ($cc === 'gallery_manager') ? $act : $nav;
      $c_admin_campaigns = ($cc === 'cms' && $CI->router->fetch_method() === 'campaigns_manage') ? $act : $nav;
      $c_admin_certificates = ($cc === 'certificates') ? $act : $nav;
      $c_admin_notifications = ($cc === 'notifications') ? $act : $nav;
      $c_admin_media = ($cc === 'media_manager') ? $act : $nav;
      $c_admin_support = ($cc === 'support_tickets') ? $act : $nav;
      $c_admin_activity = ($cc === 'activity_logs') ? $act : $nav;
      $c_admin_users = ($cc === 'admin_users') ? $act : $nav;
      $c_birthday_list = ($cc === 'members' && $CI->router->fetch_method() === 'birthdays') ? $act : $nav;

      // Group active indicators for auto-expanding toggles:
      $is_people_active = ($c_unverified === $act || $c_verified === $act || $c_pending_renewals === $act || $c_cms_dashboard === $act || $cc === 'members');
      $is_operations_active = ($c_donations === $act || $c_admin_campaigns === $act || $c_admin_blog === $act || $c_admin_gallery === $act || $c_admin_certificates === $act);
      $is_analytics_active = ($c_admin_media === $act || $c_admin_support === $act);
      $is_system_active = ($c_admin_activity === $act || ($is_super_admin && $c_admin_users === $act));
      ?>
      <ul class="navbar-nav">
        <!-- Dashboard (Shared) -->
        <li class="nav-item">
          <a class="<?= $c_dashboard; ?>" href="<?= site_url('admin'); ?>">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <?php if (!$is_member_panel): ?>
        <!-- Notifications (Promoted Upper Element) -->
        <li class="nav-item">
          <a class="<?= $c_admin_notifications; ?>" href="<?= site_url('notifications'); ?>">
            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">Notifications</span>
            <span class="badge rounded-pill ms-auto notif-badge <?= ($unread_notifications_count > 0) ? '' : 'd-none'; ?>" style="font-size:0.625rem; font-weight:600; padding:1.5px 6px; background:#fee2e2; color:#b91c1c; border:1px solid rgba(185,28,28,0.2);">
              <?= (int) $unread_notifications_count; ?>
            </span>
          </a>
        </li>
        <?php endif; ?>

        <?php if ($is_member_panel): ?>
          <!-- --- MEMBER PANEL --- -->
          <li class="nav-item">
            <a class="<?= $c_member_profile; ?>" href="<?= site_url('admin/profile'); ?>">
              <i class="material-symbols-rounded opacity-5">person</i>
              <span class="nav-link-text ms-1">My Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_renew; ?>" href="<?= site_url('admin/renew'); ?>">
              <i class="material-symbols-rounded opacity-5">autorenew</i>
              <span class="nav-link-text ms-1">Renew Membership</span>
              <?php if ($member_renew_status === 'inactive'): ?>
                <span class="badge badge-sm bg-gradient-danger ms-1">Expired</span>
              <?php endif; ?>
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
            <a class="<?= $c_member_donation; ?>" href="<?= site_url('admin/donation_history'); ?>">
              <i class="material-symbols-rounded opacity-5">payments</i>
              <span class="nav-link-text ms-1">Donations</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_campaigns; ?>" href="<?= site_url('admin/campaigns'); ?>">
              <i class="material-symbols-rounded opacity-5">campaign</i>
              <span class="nav-link-text ms-1">Campaigns</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_events; ?>" href="<?= site_url('admin/events'); ?>">
              <i class="material-symbols-rounded opacity-5">event</i>
              <span class="nav-link-text ms-1">Events</span>
            </a>
          </li>

          <!-- Account -->
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account</h6>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_notifications; ?>" href="<?= site_url('admin/notifications'); ?>">
              <i class="material-symbols-rounded opacity-5">notifications</i>
              <span class="nav-link-text ms-1">Notifications</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_activity; ?>" href="<?= site_url('admin/activity'); ?>">
              <i class="material-symbols-rounded opacity-5">history</i>
              <span class="nav-link-text ms-1">My Activity</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="<?= $c_member_support; ?>" href="<?= site_url('admin/support'); ?>">
              <i class="material-symbols-rounded opacity-5">support_agent</i>
              <span class="nav-link-text ms-1">Support</span>
            </a>
          </li>

          <!-- Logout -->
          <li class="nav-item mt-3">
            <a class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-lg"
               href="javascript:void(0)"
               id="member-logout-btn"
               style="border: 1px solid rgba(220,53,69,0.3); background: rgba(220,53,69,0.06); transition: all 0.3s; cursor:pointer;">
              <i class="material-symbols-rounded" style="font-size:20px; color:#dc3545;">logout</i>
              <span class="nav-link-text ms-1" style="color:#dc3545; font-size: 0.8rem; font-weight: 500;">Logout</span>
            </a>
          </li>

        <?php else: ?>
          <!-- --- ADMIN PANEL COLLAPSIBLE MODULES --- -->

          <!-- 1. PEOPLE MODULE -->
          <li class="nav-item mt-2">
            <a class="nav-link text-dark d-flex align-items-center justify-content-between sidebar-toggle <?= $is_people_active ? 'active-parent' : ''; ?>"
               data-sidebar-toggle="collapse"
               data-target="#collapseSectionPeople"
               href="#collapseSectionPeople"
               role="button"
               aria-expanded="<?= $is_people_active ? 'true' : 'false'; ?>">
              <div class="d-flex align-items-center">
                <i class="material-symbols-rounded opacity-5">group</i>
                <span class="nav-link-text ms-2">People</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill people-toggle-badge <?= ($people_pending_total > 0 && !$is_people_active) ? '' : 'd-none'; ?>" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#fee2e2; color:#b91c1c; border:1px solid rgba(185,28,28,0.2);">
                  <?= (int) $people_pending_total; ?>
                </span>
                <svg class="sidebar-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>
            </a>
            <div class="collapse <?= $is_people_active ? 'show' : ''; ?>" id="collapseSectionPeople">
              <ul class="nav flex-column sidebar-submenu">
                <li class="nav-item">
                  <a class="<?= $c_unverified; ?>" href="<?= site_url('members'); ?>?status=pending">
                    <i class="material-symbols-rounded opacity-5">person_add</i>
                    <span class="nav-link-text ms-1">Unverified Members</span>
                    <?php if ($pending_members_count > 0): ?>
                      <span class="badge rounded-pill ms-auto" style="font-size:0.625rem; font-weight:600; padding:1.5px 6px; background:#fee2e2; color:#b91c1c; border:1px solid rgba(185,28,28,0.2);">
                        <?= (int) $pending_members_count; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="<?= $c_verified; ?>" href="<?= site_url('members'); ?>?status=active">
                    <i class="material-symbols-rounded opacity-5">verified_user</i>
                    <span class="nav-link-text ms-1">Verified Members</span>
                    <?php if ($active_members_count > 0): ?>
                      <span class="badge rounded-pill ms-auto" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1;">
                        <?= (int) $active_members_count; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="<?= $c_pending_renewals; ?>" href="<?= site_url('members'); ?>?status=inactive">
                    <i class="material-symbols-rounded opacity-5">history_toggle_off</i>
                    <span class="nav-link-text ms-1">Renewals</span>
                    <?php if ($inactive_members_count > 0): ?>
                      <span class="badge rounded-pill ms-auto" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#fef3c7; color:#92400e; border:1px solid rgba(146,64,14,0.2);">
                        <?= (int) $inactive_members_count; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="<?= $c_cms_dashboard; ?>" href="<?= site_url('cms/dashboard'); ?>">
                    <i class="material-symbols-rounded opacity-5">space_dashboard</i>
                    <span class="nav-link-text ms-1">CMS Dashboard Hub</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <!-- 2. OPERATIONS MODULE -->
          <li class="nav-item mt-1">
            <a class="nav-link text-dark d-flex align-items-center justify-content-between sidebar-toggle <?= $is_operations_active ? 'active-parent' : ''; ?>"
               data-sidebar-toggle="collapse"
               data-target="#collapseSectionOperations"
               href="#collapseSectionOperations"
               role="button"
               aria-expanded="<?= $is_operations_active ? 'true' : 'false'; ?>">
              <div class="d-flex align-items-center">
                <i class="material-symbols-rounded opacity-5">hub</i>
                <span class="nav-link-text ms-2">Operations</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <?php if ($campaigns_count > 0 && !$is_operations_active): ?>
                  <span class="badge rounded-pill" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#ecfdf5; color:#047857; border:1px solid rgba(4,120,87,0.2);">
                    <?= (int) $campaigns_count; ?> active
                  </span>
                <?php endif; ?>
                <svg class="sidebar-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>
            </a>
            <div class="collapse <?= $is_operations_active ? 'show' : ''; ?>" id="collapseSectionOperations">
              <ul class="nav flex-column sidebar-submenu">
                <li class="nav-item">
                  <a class="<?= $c_donations; ?>" href="<?= site_url('donations'); ?>">
                    <i class="material-symbols-rounded opacity-5">payments</i>
                    <span class="nav-link-text ms-1">Donations</span>
                    <?php if ($donations_count > 0): ?>
                      <span class="badge rounded-pill ms-auto" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1;">
                        <?= (int) $donations_count; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="<?= $c_admin_campaigns; ?>" href="<?= site_url('cms/campaigns_manage'); ?>">
                    <i class="material-symbols-rounded opacity-5">campaign</i>
                    <span class="nav-link-text ms-1">Campaigns</span>
                    <?php if ($campaigns_count > 0): ?>
                      <span class="badge rounded-pill ms-auto" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#ecfdf5; color:#047857; border:1px solid rgba(4,120,87,0.2);">
                        <?= (int) $campaigns_count; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="<?= $c_admin_blog; ?>" href="<?= site_url('blog_manager'); ?>">
                    <i class="material-symbols-rounded opacity-5">edit_note</i>
                    <span class="nav-link-text ms-1">Manage Blog</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="<?= $c_admin_gallery; ?>" href="<?= site_url('gallery_manager'); ?>">
                    <i class="material-symbols-rounded opacity-5">image</i>
                    <span class="nav-link-text ms-1">Photo Gallery</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="<?= $c_admin_certificates; ?>" href="<?= site_url('certificates'); ?>">
                    <i class="material-symbols-rounded opacity-5">workspace_premium</i>
                    <span class="nav-link-text ms-1">Certificates</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <!-- 3. ANALYTICS & COMMS MODULE -->
          <li class="nav-item mt-1">
            <a class="nav-link text-dark d-flex align-items-center justify-content-between sidebar-toggle <?= $is_analytics_active ? 'active-parent' : ''; ?>"
               data-sidebar-toggle="collapse"
               data-target="#collapseSectionAnalytics"
               href="#collapseSectionAnalytics"
               role="button"
               aria-expanded="<?= $is_analytics_active ? 'true' : 'false'; ?>">
              <div class="d-flex align-items-center">
                <i class="material-symbols-rounded opacity-5">analytics</i>
                <span class="nav-link-text ms-2">Analytics & Comms</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <?php if ($support_count > 0 && !$is_analytics_active): ?>
                  <span class="badge rounded-pill" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#e0f2fe; color:#0369a1; border:1px solid rgba(3,105,161,0.2);">
                    <?= (int) $support_count; ?>
                  </span>
                <?php endif; ?>
                <svg class="sidebar-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>
            </a>
            <div class="collapse <?= $is_analytics_active ? 'show' : ''; ?>" id="collapseSectionAnalytics">
              <ul class="nav flex-column sidebar-submenu">
                <li class="nav-item">
                  <a class="<?= $c_admin_media; ?>" href="<?= site_url('media_manager'); ?>">
                    <i class="material-symbols-rounded opacity-5">folder</i>
                    <span class="nav-link-text ms-1">Media Manager</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="<?= $c_admin_support; ?>" href="<?= site_url('support_tickets'); ?>">
                    <i class="material-symbols-rounded opacity-5">forum</i>
                    <span class="nav-link-text ms-1">Support</span>
                    <?php if ($support_count > 0): ?>
                      <span class="badge rounded-pill ms-auto" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#e0f2fe; color:#0369a1; border:1px solid rgba(3,105,161,0.2);">
                        <?= (int) $support_count; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <!-- 4. SYSTEM MODULE -->
          <li class="nav-item mt-1">
            <a class="nav-link text-dark d-flex align-items-center justify-content-between sidebar-toggle <?= $is_system_active ? 'active-parent' : ''; ?>"
               data-sidebar-toggle="collapse"
               data-target="#collapseSectionSystem"
               href="#collapseSectionSystem"
               role="button"
               aria-expanded="<?= $is_system_active ? 'true' : 'false'; ?>">
              <div class="d-flex align-items-center">
                <i class="material-symbols-rounded opacity-5">settings</i>
                <span class="nav-link-text ms-2">System</span>
              </div>
              <svg class="sidebar-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </a>
            <div class="collapse <?= $is_system_active ? 'show' : ''; ?>" id="collapseSectionSystem">
              <ul class="nav flex-column sidebar-submenu">
                <?php if ($is_super_admin): ?>
                <li class="nav-item">
                  <a class="<?= $c_admin_users; ?>" href="<?= site_url('admin_users'); ?>">
                    <i class="material-symbols-rounded opacity-5">manage_accounts</i>
                    <span class="nav-link-text ms-1">Staff / Admins</span>
                    <?php if ($admin_users_count > 0): ?>
                      <span class="badge rounded-pill ms-auto" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1;">
                        <?= (int) $admin_users_count; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                  <a class="<?= $c_admin_activity; ?>" href="<?= site_url('activity_logs'); ?>">
                    <i class="material-symbols-rounded opacity-5">history</i>
                    <span class="nav-link-text ms-1">Activity Logs</span>
                    <?php if ($activity_count > 0): ?>
                      <span class="badge rounded-pill ms-auto" style="font-size:0.625rem; font-weight:500; padding:1.5px 6px; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1;">
                        <?= (int) $activity_count; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <!-- Logout -->
          <li class="nav-item mt-3 mb-2 px-2">
            <a class="nav-link d-flex align-items-center justify-content-center gap-2 py-2 rounded-3"
               href="<?= site_url('admin/logout'); ?>"
               style="border: 1px solid rgba(220,53,69,0.25); background: rgba(220,53,69,0.04); font-size: 0.8rem; font-weight: 500; color: #dc3545 !important; transition: all 0.2s;">
              <i class="material-symbols-rounded" style="font-size: 1.1rem; color: #dc3545; margin: 0 !important; width: auto !important;">logout</i>
              <span>Logout</span>
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
    var labels1 = ["M", "T", "W", "T", "F", "S", "S"];
    var data1 = [0, 0, 0, 0, 0, 0, 0];
    try {
      if (el1.dataset.labels) labels1 = JSON.parse(el1.dataset.labels);
      if (el1.dataset.values) data1 = JSON.parse(el1.dataset.values);
    } catch(e) {}

    var maxVal = Math.max.apply(null, data1);
    var suggestedMax = maxVal > 10 ? Math.ceil(maxVal * 1.25) : 10;

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels1,
        datasets: [{
          label: "Members",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#43A047",
          data: data1,
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
              suggestedMax: suggestedMax,
              beginAtZero: true,
              stepSize: 1,
              padding: 10,
              font: {
                size: 13,
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
    var el2 = document.getElementById("chart-line");
    if (!el2) return;
    var ctx2 = el2.getContext("2d");
    var labels2 = ["Apr", "May", "Jun", "Jul", "Aug", "Sep"];
    var data2 = [0, 0, 0, 0, 0, 0];
    try {
      if (el2.dataset.labels) labels2 = JSON.parse(el2.dataset.labels);
      if (el2.dataset.values) data2 = JSON.parse(el2.dataset.values);
    } catch(e) {}

    var maxVal2 = Math.max.apply(null, data2);
    var suggestedMax2 = maxVal2 > 1000 ? Math.ceil(maxVal2 * 1.2) : 5000;

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: labels2,
        datasets: [{
          label: "Donations (₹)",
          tension: 0.3,
          borderWidth: 2,
          pointRadius: 4,
          pointBackgroundColor: "#0d6efd",
          pointBorderColor: "#ffffff",
          borderColor: "#0d6efd",
          backgroundColor: "rgba(13, 110, 253, 0.08)",
          fill: true,
          data: data2,
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
              label: function(context) {
                return "Donations: ₹" + Number(context.raw).toLocaleString('en-IN');
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
              suggestedMin: 0,
              suggestedMax: suggestedMax2,
              padding: 10,
              callback: function(value) {
                return '₹' + (value >= 1000 ? (value / 1000) + 'k' : value);
              },
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
    var labels3 = ["Support", "Medical", "Education"];
    var data3 = [0, 0, 0];
    try {
      if (el3.dataset.labels) labels3 = JSON.parse(el3.dataset.labels);
      if (el3.dataset.values) data3 = JSON.parse(el3.dataset.values);
    } catch(e) {}

    var maxVal3 = Math.max.apply(null, data3);
    var suggestedMax3 = maxVal3 > 1000 ? Math.ceil(maxVal3 * 1.2) : 10000;

    new Chart(ctx3, {
      type: "bar",
      data: {
        labels: labels3,
        datasets: [{
          label: "Raised (₹)",
          tension: 0,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#e91e63",
          data: data3,
          barThickness: 'flex'
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
              label: function(context) {
                return "Raised: ₹" + Number(context.raw).toLocaleString('en-IN');
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
              suggestedMin: 0,
              suggestedMax: suggestedMax3,
              padding: 10,
              callback: function(value) {
                return '₹' + (value >= 1000 ? (value / 1000) + 'k' : value);
              },
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
                size: 11,
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
    document.addEventListener('DOMContentLoaded', function() {
      var sideNavCollapse = document.querySelector('#sidenav-collapse-main');
      var ps = null;
      if (sideNavCollapse && typeof PerfectScrollbar !== 'undefined') {
        try {
          ps = new PerfectScrollbar(sideNavCollapse, {
            wheelSpeed: 1,
            wheelPropagation: true,
            suppressScrollX: true
          });
        } catch(e) {}
      }

      // Dynamic sidebar accordion state persistence with localStorage
      var STORAGE_KEY = 'sf_admin_sidebar_state_v1';
      var savedStates = {};
      try {
        var raw = localStorage.getItem(STORAGE_KEY);
        if (raw) savedStates = JSON.parse(raw);
      } catch(e) {}

      // Step 1: Initialize states on page load
      document.querySelectorAll('.sidebar-toggle').forEach(function(btn) {
        var targetSelector = btn.getAttribute('data-target') || btn.getAttribute('href');
        if (!targetSelector || !targetSelector.startsWith('#')) return;

        var target = document.querySelector(targetSelector);
        if (!target) return;

        var hasActiveChild = target.querySelector('.nav-link.active') !== null;
        var toggleBadge = btn.querySelector('.people-toggle-badge');

        if (hasActiveChild) {
          // Rule: Currently active route module must ALWAYS remain open
          target.classList.add('show');
          btn.setAttribute('aria-expanded', 'true');
          btn.classList.add('active-parent');
          if (toggleBadge) toggleBadge.classList.add('d-none');
        } else if (savedStates[targetSelector] !== undefined) {
          // Restore user's previous preference for non-active modules
          if (savedStates[targetSelector] === true) {
            target.classList.add('show');
            btn.setAttribute('aria-expanded', 'true');
            btn.classList.add('active-parent');
            if (toggleBadge) toggleBadge.classList.add('d-none');
          } else {
            target.classList.remove('show');
            btn.setAttribute('aria-expanded', 'false');
            btn.classList.remove('active-parent');
            if (toggleBadge && toggleBadge.textContent.trim() !== '0' && toggleBadge.textContent.trim() !== '') {
              toggleBadge.classList.remove('d-none');
            }
          }
        }
      });

      // Step 2: Instant click handler that persists state
      document.querySelectorAll('.sidebar-toggle').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          var targetSelector = btn.getAttribute('data-target') || btn.getAttribute('href');
          if (!targetSelector || !targetSelector.startsWith('#')) return;

          var target = document.querySelector(targetSelector);
          if (!target) return;

          var isCurrentlyShown = target.classList.contains('show');
          var toggleBadge = btn.querySelector('.people-toggle-badge');

          if (isCurrentlyShown) {
            // Hide / Collapse
            target.classList.remove('show');
            btn.setAttribute('aria-expanded', 'false');
            btn.classList.remove('active-parent');
            if (toggleBadge && toggleBadge.textContent.trim() !== '0' && toggleBadge.textContent.trim() !== '') {
              toggleBadge.classList.remove('d-none');
            }
            savedStates[targetSelector] = false;
          } else {
            // Show / Expand
            target.classList.add('show');
            btn.setAttribute('aria-expanded', 'true');
            btn.classList.add('active-parent');
            if (toggleBadge) {
              toggleBadge.classList.add('d-none');
            }
            savedStates[targetSelector] = true;
          }

          try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(savedStates));
          } catch(err) {}

          // Update scrollbar height dynamically
          if (ps) {
            try { ps.update(); } catch(err) {}
          }
        });
      });

      // Step 3: Background live unread poller (updates badges dynamically)
      function syncLiveSidebarBadges() {
        if (typeof base_url === 'undefined') return;
        fetch(base_url + 'notifications/unread_count', {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (!data || data.status !== 'ok') return;

          // Upper Notifications badge
          var notifBadge = document.querySelector('.notif-badge');
          if (notifBadge) {
            var count = parseInt(data.unread_notifications, 10) || 0;
            if (count > 0) {
              notifBadge.textContent = count;
              notifBadge.classList.remove('d-none');
            } else {
              notifBadge.classList.add('d-none');
            }
          }

          // People header badge
          var peopleBadge = document.querySelector('.people-toggle-badge');
          var peopleCollapse = document.querySelector('#collapseSectionPeople');
          if (peopleBadge) {
            var pCount = parseInt(data.people_pending_total, 10) || 0;
            peopleBadge.textContent = pCount;
            if (pCount > 0 && (!peopleCollapse || !peopleCollapse.classList.contains('show'))) {
              peopleBadge.classList.remove('d-none');
            } else {
              peopleBadge.classList.add('d-none');
            }
          }
        })
        .catch(function() {});
      }

      // Check after 8s, then poll every 30s
      setTimeout(syncLiveSidebarBadges, 8000);
      setInterval(syncLiveSidebarBadges, 30000);

      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar') && typeof Scrollbar !== 'undefined') {
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
      }
    });
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