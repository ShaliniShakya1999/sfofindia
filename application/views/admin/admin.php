<?php
$CI =& get_instance();
$panel_user_type = (string) $CI->session->userdata('panel_user_type');
if ($panel_user_type === '') {
  $panel_user_type = 'admin';
}
$is_member_panel = ($panel_user_type === 'member');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>assetsA/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?= base_url(); ?>assetsA/img/favicon.png">
  <title><?= $is_member_panel ? 'Member Portal - Shaheed Foundation of India' : 'Admin Panel - Shaheed Foundation of India'; ?></title>
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
        confirmButtonColor: '#1a685b',
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
      /* SFOI Brand Green & Warm Accent Palette */
      --primary-gradient: linear-gradient(135deg, #134e4a 0%, #1a685b 100%);
      --primary-soft: rgba(26, 104, 91, 0.1);
      --glass-bg: rgba(255, 255, 255, 0.82);
      --glass-border: rgba(255, 255, 255, 0.4);
      --admin-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
      --admin-shadow-hover: 0 20px 45px rgba(26, 104, 91, 0.12);
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

    /* --- Clean Entry Animations --- */
    <?php if ($is_member_panel): ?>
    /* Member Panel: Strict Zero Jumping / Cursor Animation Elimination */
    .stagger-item {
      opacity: 1 !important;
      animation: none !important;
      transform: none !important;
    }
    <?php else: ?>
    @keyframes slideInUp {
      from { transform: translateY(6px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .stagger-item {
      opacity: 0;
      animation: slideInUp 0.3s ease-out forwards;
    }
    <?php endif; ?>

    /* --- Sidebar Glass --- */
    #sidenav-main {
      border: 1px solid var(--glass-border) !important;
      background: var(--glass-bg) !important;
      backdrop-filter: blur(14px) saturate(180%);
      box-shadow: var(--admin-shadow) !important;
      transition: all 0.3s ease;
    }

    #sidenav-main .navbar-nav .nav-link {
      transition: background-color 0.15s ease, color 0.15s ease;
      margin: 1px 6px !important;
      min-height: 34px;
      display: flex;
      align-items: center;
      padding: 0.35rem 0.65rem !important;
      border-radius: 6px !important;
      font-family: "Segoe UI", Arial, sans-serif !important;
      font-size: 0.8rem !important;
      font-weight: 500 !important;
      letter-spacing: 0.005em;
      line-height: 1.35 !important;
      color: #334155 !important;
    }

    #sidenav-main .navbar-nav .nav-link .nav-link-text {
      font-size: 0.8rem !important;
      font-weight: 500 !important;
      letter-spacing: inherit;
      white-space: nowrap;
      margin-left: 0 !important;
    }

    #sidenav-main .sidenav-header .navbar-brand {
      font-family: "Segoe UI", Arial, sans-serif !important;
      font-size: 0.82rem !important;
      font-weight: 600 !important;
    }

    #sidenav-main .navbar-nav h6 {
      font-family: "Segoe UI", Arial, sans-serif !important;
      font-size: 0.68rem !important;
      font-weight: 700 !important;
      letter-spacing: 0.07em;
      color: #64748b !important;
      margin-top: 0.75rem !important;
      margin-bottom: 0.25rem !important;
      padding-left: 0.75rem !important;
    }

    #sidenav-main .nav-link.active {
      background: var(--primary-gradient) !important;
      box-shadow: 0 4px 12px rgba(26, 104, 91, 0.2) !important;
    }

    /* --- Cards Grounded & Refined --- */
    .main-content .card {
      border: 1px solid rgba(0,0,0,0.06) !important;
      border-radius: var(--admin-radius) !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
      transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .main-content .card:hover {
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07) !important;
      border-color: rgba(0, 0, 0, 0.1) !important;
    }

    /* --- Form Controls --- */
    .form-control, .form-select {
      border: 1px solid #e2e8f0 !important;
      transition: all 0.2s ease !important;
    }

    .form-control:focus {
      border-color: #1a685b !important;
      box-shadow: 0 0 0 4px rgba(26, 104, 91, 0.12) !important;
      background: #fff !important;
    }

    /* --- Buttons --- */
    .btn-primary {
      background: var(--primary-gradient) !important;
      border: none !important;
      box-shadow: 0 2px 8px rgba(26, 104, 91, 0.22) !important;
    }

    .btn-primary:hover {
      box-shadow: 0 4px 14px rgba(26, 104, 91, 0.3) !important;
      opacity: 0.96;
    }

    /* --- Layout Elements --- */
    #navbarBlur,
    #navbarBlur.navbar-main {
      background: var(--glass-bg) !important;
      backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--glass-border);
      margin-top: 12px !important;
      margin-bottom: 0 !important;
      position: relative !important;
      top: auto !important;
      z-index: 10 !important;
      pointer-events: auto;
    }

    .navbar-brand-img {
      filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
    }

    .admin-profile-pill {
      cursor: pointer;
      transition: all 0.18s ease;
    }
    .admin-profile-pill:hover {
      border-color: #1a685b !important;
      box-shadow: 0 2px 8px rgba(26, 104, 91, 0.15) !important;
      background-color: #f8fafc !important;
    }
    .admin-profile-pill:hover span.text-dark {
      color: #1a685b !important;
    }

    /* --- Scrollbar Customization --- */
    .sidenav,
    #sidenav-main {
      overflow: hidden !important;
      overflow-y: hidden !important;
    }

    #sidenav-collapse-main,
    .navbar-vertical.navbar-expand-xs .navbar-collapse {
      height: calc(100vh - 90px) !important;
      max-height: calc(100vh - 90px) !important;
      overflow-y: auto !important;
      overflow-x: hidden !important;
      scrollbar-width: none !important;
      -ms-overflow-style: none !important;
    }

    #sidenav-collapse-main::-webkit-scrollbar,
    .navbar-vertical.navbar-expand-xs .navbar-collapse::-webkit-scrollbar {
      width: 3px;
      display: none;
    }

    #sidenav-main:hover #sidenav-collapse-main::-webkit-scrollbar,
    #sidenav-collapse-main:hover::-webkit-scrollbar {
      display: block;
    }

    #sidenav-collapse-main::-webkit-scrollbar-track,
    .navbar-vertical.navbar-expand-xs .navbar-collapse::-webkit-scrollbar-track {
      background: transparent;
    }

    #sidenav-collapse-main::-webkit-scrollbar-thumb,
    .navbar-vertical.navbar-expand-xs .navbar-collapse::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.12);
      border-radius: 6px;
    }

    /* Modern slim scrollbar across entire admin panel */
    ::-webkit-scrollbar {
      width: 5px;
      height: 5px;
    }
    ::-webkit-scrollbar-track {
      background: transparent;
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.15);
      border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(0, 0, 0, 0.3);
    }
    body, html {
      scrollbar-width: thin;
      scrollbar-color: rgba(0, 0, 0, 0.15) transparent;
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
      padding: 0.35rem 0.65rem !important;
      margin: 2px 0.45rem !important;
      border-radius: 0.375rem !important;
      font-size: 0.8rem !important; /* ~12.8px */
      font-weight: 500 !important;
      letter-spacing: 0.005em;
      color: #334155 !important;
      user-select: none;
      transition: all 0.15s ease-in-out;
      box-sizing: border-box;
    }

    #sidenav-main .navbar-nav > .nav-item > .nav-link .nav-link-text,
    #sidenav-main .sidebar-toggle .nav-link-text {
      font-size: 0.8rem !important;
      font-weight: 500 !important;
      letter-spacing: 0.005em;
      margin-left: 0 !important;
    }

    #sidenav-main .navbar-nav > .nav-item > .nav-link:hover,
    #sidenav-main .sidebar-toggle:hover {
      background-color: rgba(0, 0, 0, 0.04) !important;
      color: #0f172a !important;
    }

    /* Remove icons from sidebar as requested */
    #sidenav-main .navbar-nav .nav-link i,
    #sidenav-main .navbar-nav .nav-link .material-symbols-rounded,
    #sidenav-main .sidebar-toggle i,
    #sidenav-main .sidebar-toggle .material-symbols-rounded,
    #sidenav-main .sidebar-submenu .nav-link i,
    #sidenav-main .sidebar-submenu .nav-link .material-symbols-rounded {
      display: none !important;
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
      margin: 0.1rem 0.4rem 0.25rem 0.85rem !important;
      padding: 0.1rem 0 0.1rem 0.65rem !important;
      border-left: 1.5px solid rgba(0, 0, 0, 0.08) !important;
    }
    .sidebar-submenu .nav-item {
      width: 100%;
      margin: 1px 0;
    }
    .sidebar-submenu .nav-link {
      display: flex !important;
      align-items: center !important;
      padding: 0.26rem 0.5rem !important;
      font-size: 0.76rem !important; /* ~12px */
      font-weight: 400 !important;
      letter-spacing: 0.005em;
      margin: 0 !important;
      width: 100% !important;
      border-radius: 0.375rem !important;
      color: #475569 !important;
      transition: all 0.15s ease-in-out;
      box-sizing: border-box;
    }
    .sidebar-submenu .nav-link::before {
      content: '';
      display: inline-block;
      width: 4px;
      height: 4px;
      border-radius: 50%;
      background-color: #cbd5e1;
      margin-right: 8px;
      flex-shrink: 0;
      transition: background-color 0.15s ease, transform 0.15s ease;
    }
    .sidebar-submenu .nav-link:hover::before {
      background-color: #1a685b;
      transform: scale(1.3);
    }
    .sidebar-submenu .nav-link.active::before {
      background-color: #1a685b;
      transform: scale(1.4);
    }
    .sidebar-submenu .nav-link .nav-link-text {
      font-size: 0.76rem !important;
      font-weight: 400 !important;
      letter-spacing: 0.005em;
      margin-left: 0 !important;
    }
    .sidebar-submenu .nav-link:hover {
      background-color: rgba(26, 104, 91, 0.06) !important;
      color: #1a685b !important;
    }

    /* Modern active link style */
    #sidenav-main .nav-link.active {
      background: rgba(26, 104, 91, 0.08) !important;
      color: #1a685b !important;
      border-left: 3px solid #1a685b !important;
      box-shadow: none !important;
    }
    #sidenav-main .nav-link.active .nav-link-text {
      color: #1a685b !important;
      font-weight: 600 !important;
    }
    #sidenav-main .nav-link.active .badge {
      background-color: #1a685b !important;
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
      <a class="navbar-brand px-3 py-3 m-0 d-flex align-items-center" href="<?= site_url('admin'); ?>">
        <img src="<?= base_url(); ?>assetsA/img/ngo-logo.png" class="navbar-brand-img rounded-circle me-2" width="34" height="34" alt="NGO Logo">
        <div class="d-flex flex-column text-start">
          <span class="text-xs font-weight-bolder text-dark mb-0 lh-1"><?= $is_member_panel ? 'MEMBER PORTAL' : 'SFOI ADMIN'; ?></span>
          <span class="text-xxs text-muted" style="font-size: 0.65rem; margin-top: 2px;"><?= $is_member_panel ? 'Shaheed Foundation Member' : 'Shaheed Foundation'; ?></span>
        </div>
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
      $navbar_notifications = array();
      if ($is_member_panel) {
          $member_id = (int) $CI->session->userdata('cms_member_id');
          $CI->load->model('Member_model', 'member_m');
          $member_record = $member_id > 0 ? $CI->member_m->find_by_id($member_id) : null;
          if ($member_record) {
              $member_all_notifs = $CI->member_m->get_member_notifications($member_record);
              foreach ($member_all_notifs as $item) {
                  if (!empty($item['is_new'])) {
                      $unread_notifications_count++;
                  }
              }
              $navbar_notifications = array_slice($member_all_notifs, 0, 5);
          }
      } else {
          if ($CI->db->table_exists('ngom_notifications')) {
              $CI->db->where('is_read', 0);
              $unread_notifications_count = (int) $CI->db->count_all_results('ngom_notifications');

              $CI->db->order_by('id', 'DESC');
              $CI->db->limit(5);
              $navbar_notifications = $CI->db->get('ngom_notifications')->result_array();
          }
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
            <a class="nav-link d-flex align-items-center justify-content-center px-3 py-2 rounded-lg"
               href="javascript:void(0)"
               id="member-logout-btn"
               style="border: 1px solid rgba(220,53,69,0.3); background: rgba(220,53,69,0.06); transition: all 0.2s; cursor:pointer;">
              <span class="nav-link-text" style="color:#dc3545; font-size: 0.78rem; font-weight: 500;">Logout</span>
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
            <a class="nav-link d-flex align-items-center justify-content-center py-2 rounded-3"
               href="<?= site_url('admin/logout'); ?>"
               style="border: 1px solid rgba(220,53,69,0.25); background: rgba(220,53,69,0.04); font-size: 0.78rem; font-weight: 500; color: #dc3545 !important; transition: all 0.2s;">
              <span>Logout</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
          <div class="d-inline-flex align-items-center gap-2 px-2 py-1 rounded-pill bg-white border" style="font-size: 0.72rem; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <span style="width: 7px; height: 7px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
            <span class="font-weight-600 text-dark">Portal Live</span>
          </div>
          <span class="text-xs text-muted d-none d-lg-inline">|</span>
          <span class="text-xs text-secondary d-none d-lg-inline"><?= date('l, d M Y'); ?></span>
        </div>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end" id="navbar">
          <ul class="navbar-nav d-flex align-items-center gap-2 ms-auto">
            <li class="nav-item">
              <a class="btn btn-sm btn-outline-secondary mb-0 d-inline-flex align-items-center gap-1 text-xs px-2 px-sm-3" href="<?= base_url(); ?>" target="_blank" rel="noopener" style="border-radius: 8px; height: 34px;">
                <i class="material-symbols-rounded text-sm">open_in_new</i>
                <span class="d-none d-sm-inline">Public Site</span>
              </a>
            </li>
            <li class="nav-item dropdown dropdown-notifications position-relative">
              <a href="javascript:;" class="btn btn-sm btn-outline-secondary mb-0 position-relative d-inline-flex align-items-center justify-content-center p-0 navbar-notif-btn" id="dropdownMenuNotifications" data-bs-toggle="dropdown" aria-expanded="false" title="Notification Center" style="border-radius: 8px; width: 34px; height: 34px;">
                <i class="material-symbols-rounded" style="font-size: 19px;">notifications</i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger navbar-notif-badge <?= ($unread_notifications_count > 0) ? '' : 'd-none'; ?>" style="font-size: 0.58rem; padding: 2px 5px; min-width: 17px;">
                  <?= $unread_notifications_count > 99 ? '99+' : (int)$unread_notifications_count; ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end px-2 py-2 me-sm-n2 border-0 shadow-lg navbar-notif-dropdown" aria-labelledby="dropdownMenuNotifications" style="width: 320px; border-radius: 14px; border: 1px solid #edf2f7 !important; z-index: 1060;">
                <li class="d-flex align-items-center justify-content-between px-2 pt-1 pb-2 border-bottom mb-1">
                  <div class="d-flex align-items-center gap-2">
                    <span class="font-weight-bold text-xs text-uppercase text-dark">Notifications</span>
                    <span class="badge rounded-pill bg-danger text-white navbar-notif-preview-count <?= ($unread_notifications_count > 0) ? '' : 'd-none'; ?>" style="font-size: 0.62rem; padding: 1px 6px;">
                      <?= (int)$unread_notifications_count; ?> new
                    </span>
                  </div>
                  <a href="<?= $is_member_panel ? site_url('admin/notifications') : site_url('notifications'); ?>" class="text-xs font-weight-bold text-decoration-none" style="color: #1a685b;">View Center</a>
                </li>
                <div class="navbar-notif-preview-items" style="max-height: 270px; overflow-y: auto;">
                  <?php if (empty($navbar_notifications)): ?>
                    <li class="text-center py-4 text-muted text-xs">
                      <i class="material-symbols-rounded d-block text-lg mb-1 opacity-5">notifications_paused</i>
                      <span>No notifications yet</span>
                    </li>
                  <?php else: ?>
                    <?php foreach ($navbar_notifications as $nn): 
                      $nn_is_unread = isset($nn['is_new']) ? !empty($nn['is_new']) : empty($nn['is_read']);
                      $nn_title = (string)$nn['title'];
                      $nn_icon = !empty($nn['icon']) ? $nn['icon'] : 'notifications';
                      $nn_color = !empty($nn['color']) ? $nn['color'] : '#1a685b';
                      $nn_msg = !empty($nn['message']) ? $nn['message'] : (!empty($nn['body']) ? $nn['body'] : '');
                      if (empty($nn['icon'])) {
                        if (stripos($nn_title, 'donation') !== false || stripos($nn_msg, 'receipt') !== false) {
                          $nn_icon = 'payments';
                          $nn_color = '#059669';
                        } elseif (stripos($nn_title, 'member') !== false) {
                          $nn_icon = 'person_add';
                          $nn_color = '#0284c7';
                        }
                      }
                      $nn_time = !empty($nn['time']) ? $nn['time'] : (isset($nn['created_at']) ? date('d M, h:i A', strtotime($nn['created_at'])) : 'Recent');
                      if (!empty($nn['created_at']) && empty($nn['time'])) {
                        $diff = time() - strtotime($nn['created_at']);
                        if ($diff < 60) $nn_time = 'Just now';
                        elseif ($diff < 3600) $nn_time = floor($diff / 60) . 'm ago';
                        elseif ($diff < 86400) $nn_time = floor($diff / 3600) . 'h ago';
                        elseif ($diff < 172800) $nn_time = 'Yesterday';
                      }
                      $nn_default_center = $is_member_panel ? 'admin/notifications' : 'notifications';
                      $nn_link = !empty($nn['link']) ? (filter_var($nn['link'], FILTER_VALIDATE_URL) ? $nn['link'] : site_url($nn['link'])) : site_url($nn_default_center);
                    ?>
                      <li class="mb-1">
                        <a class="dropdown-item border-radius-md p-2 d-flex align-items-start gap-2 text-wrap <?= $nn_is_unread ? 'bg-light font-weight-bold' : ''; ?>" href="<?= html_escape($nn_link); ?>" style="border-radius: 8px; transition: background 0.15s ease;">
                          <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 28px; height: 28px; background: <?= $nn_color; ?>18; color: <?= $nn_color; ?>;">
                            <i class="material-symbols-rounded" style="font-size: 16px;"><?= $nn_icon; ?></i>
                          </div>
                          <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center justify-content-between gap-1">
                              <h6 class="text-xs font-weight-bold mb-0 text-dark text-truncate" style="max-width: 160px;">
                                <?= html_escape($nn_title); ?>
                              </h6>
                              <span class="text-xxs text-muted flex-shrink-0"><?= $nn_time; ?></span>
                            </div>
                            <p class="text-xxs text-secondary mb-0 text-truncate" style="max-width: 210px; line-height: 1.3;">
                              <?= html_escape($nn_msg); ?>
                            </p>
                          </div>
                          <?php if ($nn_is_unread): ?>
                            <span class="badge rounded-circle p-1 bg-danger flex-shrink-0 mt-2" style="width: 6px; height: 6px;" title="New"></span>
                          <?php endif; ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
                <li class="pt-2 border-top text-center mt-1">
                  <a href="<?= $is_member_panel ? site_url('admin/notifications') : site_url('notifications'); ?>" class="btn btn-xs btn-outline-dark mb-0 w-100 py-1" style="border-radius: 6px;">
                    <span>Open Notification Center</span>
                    <i class="material-symbols-rounded text-xxs ms-1">arrow_forward</i>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('admin/profile'); ?>" class="d-inline-flex align-items-center gap-2 px-2 py-1 rounded-pill bg-white border text-decoration-none admin-profile-pill" style="height: 34px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);" title="<?= $is_member_panel ? 'View Member Profile' : 'View Administrator Profile'; ?>">
                <span class="rounded-circle text-white d-inline-flex align-items-center justify-content-center font-weight-bold" style="width: 24px; height: 24px; font-size: 0.68rem; background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%);">
                  <?= strtoupper(substr($CI->session->userdata('cms_admin_name') ?: 'A', 0, 1)); ?>
                </span>
                <span class="text-xs font-weight-bold text-dark d-none d-md-inline pe-1">
                  <?= html_escape($CI->session->userdata('cms_admin_name') ?: ($is_member_panel ? 'Member' : 'Administrator')); ?>
                </span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-2 d-flex align-items-center">
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
  (function() {
    // Shared chart formatting and gradient helpers
    function createVerticalGradient(colorTop, colorBottom) {
      return function(context) {
        var chart = context.chart;
        var ctx = chart.ctx;
        var chartArea = chart.chartArea;
        if (!chartArea) {
          return colorTop;
        }
        var gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
        gradient.addColorStop(0, colorTop);
        gradient.addColorStop(1, colorBottom);
        return gradient;
      };
    }

    function createTooltipConfig(labelFormatter) {
      return {
        backgroundColor: "#0f172a",
        titleColor: "#ffffff",
        bodyColor: "#e2e8f0",
        borderColor: "rgba(255, 255, 255, 0.08)",
        borderWidth: 1,
        cornerRadius: 8,
        padding: { top: 8, bottom: 8, left: 12, right: 12 },
        displayColors: false,
        titleFont: {
          size: 11,
          weight: "600",
          family: "'Inter', -apple-system, sans-serif"
        },
        bodyFont: {
          size: 12,
          weight: "500",
          family: "'Inter', -apple-system, sans-serif"
        },
        callbacks: {
          title: function(items) {
            return items && items[0] ? items[0].label : "";
          },
          label: labelFormatter
        }
      };
    }

    function formatCurrencyTick(value) {
      if (value < 0) return "";
      if (value === 0) return "₹0";
      if (value >= 100000) {
        var l = value / 100000;
        return "₹" + (l % 1 === 0 ? l : l.toFixed(1)) + "L";
      }
      if (value >= 1000) {
        var k = value / 1000;
        return "₹" + (k % 1 === 0 ? k : k.toFixed(1)) + "k";
      }
      return "₹" + value;
    }

    // --- 1. Member Registrations Bar Chart ---
    var el1 = document.getElementById("chart-bars");
    if (el1) {
      var ctx1 = el1.getContext("2d");
      var labels1 = ["M", "T", "W", "T", "F", "S", "S"];
      var data1 = [0, 0, 0, 0, 0, 0, 0];
      try {
        if (el1.dataset.labels) labels1 = JSON.parse(el1.dataset.labels);
        if (el1.dataset.values) data1 = JSON.parse(el1.dataset.values);
      } catch(e) {}

      var maxVal1 = Math.max.apply(null, data1);
      var suggestedMax1 = maxVal1 > 5 ? Math.ceil(maxVal1 * 1.25) : 6;

      new Chart(ctx1, {
        type: "bar",
        data: {
          labels: labels1,
          datasets: [{
            label: "Members",
            borderWidth: 0,
            borderRadius: 6,
            borderSkipped: false,
            backgroundColor: createVerticalGradient("rgba(26, 104, 91, 0.95)", "rgba(26, 104, 91, 0.40)"),
            hoverBackgroundColor: "#134e4a",
            data: data1,
            barThickness: 16,
            maxBarThickness: 22
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: createTooltipConfig(function(context) {
              var count = Number(context.raw || 0);
              return count + (count === 1 ? " member registered" : " members registered");
            })
          },
          interaction: {
            intersect: false,
            mode: "index"
          },
          scales: {
            y: {
              min: 0,
              beginAtZero: true,
              suggestedMin: 0,
              suggestedMax: suggestedMax1,
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [4, 4],
                color: "#f1f5f9"
              },
              ticks: {
                precision: 0,
                stepSize: 1,
                padding: 8,
                font: {
                  size: 11,
                  weight: "500",
                  family: "'Inter', -apple-system, sans-serif"
                },
                color: "#94a3b8"
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: true,
                color: "#94a3b8",
                padding: 6,
                font: {
                  size: 11,
                  weight: "500",
                  family: "'Inter', -apple-system, sans-serif"
                }
              }
            }
          }
        }
      });
    }

    // --- 2. Monthly Donations Line Chart ---
    var el2 = document.getElementById("chart-line");
    if (el2) {
      var ctx2 = el2.getContext("2d");
      var labels2 = ["Apr", "May", "Jun", "Jul", "Aug", "Sep"];
      var data2 = [0, 0, 0, 0, 0, 0];
      try {
        if (el2.dataset.labels) labels2 = JSON.parse(el2.dataset.labels);
        if (el2.dataset.values) data2 = JSON.parse(el2.dataset.values);
      } catch(e) {}

      var maxVal2 = Math.max.apply(null, data2);
      var suggestedMax2 = maxVal2 > 500 ? Math.ceil(maxVal2 * 1.2) : 1000;

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: labels2,
          datasets: [{
            label: "Donations (₹)",
            tension: 0.42,
            borderWidth: 2.5,
            borderColor: "#0d9488",
            backgroundColor: function(context) {
              var chart = context.chart;
              var ctx = chart.ctx;
              var chartArea = chart.chartArea;
              if (!chartArea) return "rgba(13, 148, 136, 0.1)";
              var gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
              gradient.addColorStop(0, "rgba(13, 148, 136, 0.30)");
              gradient.addColorStop(0.7, "rgba(13, 148, 136, 0.06)");
              gradient.addColorStop(1, "rgba(13, 148, 136, 0.00)");
              return gradient;
            },
            fill: true,
            pointRadius: 3.5,
            pointHoverRadius: 6.5,
            pointBackgroundColor: "#ffffff",
            pointHoverBackgroundColor: "#0d9488",
            pointBorderColor: "#0d9488",
            pointHoverBorderColor: "#ffffff",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2.5,
            data: data2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: createTooltipConfig(function(context) {
              var val = Number(context.raw || 0);
              return "Donations: ₹" + val.toLocaleString("en-IN");
            })
          },
          interaction: {
            intersect: false,
            mode: "index"
          },
          scales: {
            y: {
              min: 0,
              beginAtZero: true,
              suggestedMin: 0,
              suggestedMax: suggestedMax2,
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [4, 4],
                color: "#f1f5f9"
              },
              ticks: {
                display: true,
                color: "#94a3b8",
                precision: 0,
                padding: 8,
                callback: formatCurrencyTick,
                font: {
                  size: 11,
                  weight: "500",
                  family: "'Inter', -apple-system, sans-serif"
                }
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: true,
                color: "#94a3b8",
                padding: 6,
                font: {
                  size: 11,
                  weight: "500",
                  family: "'Inter', -apple-system, sans-serif"
                }
              }
            }
          }
        }
      });
    }

    // --- 3. Campaign Raised Bar Chart ---
    var el3 = document.getElementById("chart-line-tasks");
    if (el3) {
      var ctx3 = el3.getContext("2d");
      var labels3 = ["Support", "Medical", "Education"];
      var data3 = [0, 0, 0];
      try {
        if (el3.dataset.labels) labels3 = JSON.parse(el3.dataset.labels);
        if (el3.dataset.values) data3 = JSON.parse(el3.dataset.values);
      } catch(e) {}

      var maxVal3 = Math.max.apply(null, data3);
      var suggestedMax3 = maxVal3 > 500 ? Math.ceil(maxVal3 * 1.2) : 1000;

      new Chart(ctx3, {
        type: "bar",
        data: {
          labels: labels3,
          datasets: [{
            label: "Raised (₹)",
            borderWidth: 0,
            borderRadius: 6,
            borderSkipped: false,
            backgroundColor: createVerticalGradient("rgba(245, 158, 11, 0.95)", "rgba(217, 119, 6, 0.45)"),
            hoverBackgroundColor: "#b45309",
            data: data3,
            barThickness: 18,
            maxBarThickness: 24
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: createTooltipConfig(function(context) {
              var val = Number(context.raw || 0);
              return "Raised: ₹" + val.toLocaleString("en-IN");
            })
          },
          interaction: {
            intersect: false,
            mode: "index"
          },
          scales: {
            y: {
              min: 0,
              beginAtZero: true,
              suggestedMin: 0,
              suggestedMax: suggestedMax3,
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [4, 4],
                color: "#f1f5f9"
              },
              ticks: {
                display: true,
                color: "#94a3b8",
                precision: 0,
                padding: 8,
                callback: formatCurrencyTick,
                font: {
                  size: 11,
                  weight: "500",
                  family: "'Inter', -apple-system, sans-serif"
                }
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: true,
                color: "#94a3b8",
                padding: 6,
                font: {
                  size: 11,
                  weight: "500",
                  family: "'Inter', -apple-system, sans-serif"
                }
              }
            }
          }
        }
      });
    }
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
        var notifUrl = <?= $is_member_panel ? "base_url + 'admin/member_unread_count'" : "base_url + 'notifications/unread_count'"; ?>;
        fetch(notifUrl, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (!data || data.status !== 'ok') return;

          var count = parseInt(<?= $is_member_panel ? "data.unread_count" : "data.unread_notifications"; ?>, 10) || 0;

          // Upper Sidebar Notifications badge
          var notifBadge = document.querySelector('.notif-badge');
          if (notifBadge) {
            if (count > 0) {
              notifBadge.textContent = count;
              notifBadge.classList.remove('d-none');
            } else {
              notifBadge.classList.add('d-none');
            }
          }

          // Top Navbar Notifications badge and preview count
          var navbarBadge = document.querySelector('.navbar-notif-badge');
          var navbarPreviewBadge = document.querySelector('.navbar-notif-preview-count');
          if (navbarBadge) {
            if (count > 0) {
              navbarBadge.textContent = count > 99 ? '99+' : count;
              navbarBadge.classList.remove('d-none');
            } else {
              navbarBadge.classList.add('d-none');
            }
          }
          if (navbarPreviewBadge) {
            if (count > 0) {
              navbarPreviewBadge.textContent = count + ' new';
              navbarPreviewBadge.classList.remove('d-none');
            } else {
              navbarPreviewBadge.classList.add('d-none');
            }
          }

          <?php if (!$is_member_panel): ?>
          // People header badge (Admin only)
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
          <?php endif; ?>
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