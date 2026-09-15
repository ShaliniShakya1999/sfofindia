<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid py-4">
    <!-- Breadcrumb & Flash Messages -->
    <div class="row align-items-center mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="<?= site_url('admin'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Admin Profile</li>
                </ol>
            </nav>
            <h3 class="font-weight-bolder mb-0 text-dark">Administrator Profile</h3>
            <p class="text-sm text-muted mb-0">Manage your administrator account credentials, contact email, and security settings.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('cms_success')): ?>
        <div class="alert alert-success alert-dismissible text-white fade show shadow-sm border-0 mb-4" role="alert" style="border-radius:12px;">
            <div class="d-flex align-items-center">
                <i class="material-symbols-rounded me-2">check_circle</i>
                <span class="text-sm font-weight-bold"><?= $this->session->flashdata('cms_success'); ?></span>
            </div>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('cms_error')): ?>
        <div class="alert alert-danger alert-dismissible text-white fade show shadow-sm border-0 mb-4" role="alert" style="border-radius:12px;">
            <div class="d-flex align-items-center">
                <i class="material-symbols-rounded me-2">error</i>
                <span class="text-sm font-weight-bold"><?= $this->session->flashdata('cms_error'); ?></span>
            </div>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Profile Overview Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px; border: 1px solid #edf2f7 !important;">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center font-weight-bolder shadow-sm flex-shrink-0"
                                 style="width: 64px; height: 64px; font-size: 1.5rem; background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%);">
                                <?= strtoupper(substr($admin_user['username'] ?? 'A', 0, 1)); ?>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h4 class="font-weight-bolder mb-0 text-dark"><?= html_escape($admin_user['username'] ?? 'Admin'); ?></h4>
                                    <span class="badge rounded-pill text-xxs font-weight-bold px-2 py-1" style="background: rgba(26, 104, 91, 0.1); color: #1a685b;">
                                        <?= strtoupper(str_replace('_', ' ', $admin_user['role'] ?? 'ADMIN')); ?>
                                    </span>
                                    <span class="badge rounded-pill text-xxs font-weight-bold px-2 py-1" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
                                        ● Active Account
                                    </span>
                                </div>
                                <p class="text-xs text-muted mb-0 d-flex align-items-center gap-3 flex-wrap">
                                    <span><i class="material-symbols-rounded text-xs me-1 align-middle">mail</i><?= html_escape($admin_user['email'] ?? 'No email set'); ?></span>
                                    <?php if (!empty($admin_user['last_login'])): ?>
                                        <span><i class="material-symbols-rounded text-xs me-1 align-middle">schedule</i>Last login: <?= date('d M Y, h:i A', strtotime($admin_user['last_login'])); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="<?= site_url('admin'); ?>" class="btn btn-sm btn-outline-dark mb-0 d-inline-flex align-items-center gap-1" style="border-radius: 8px;">
                                <i class="material-symbols-rounded text-sm">dashboard</i>
                                <span>Dashboard</span>
                            </a>
                            <a href="<?= site_url('admin/logout'); ?>" class="btn btn-sm btn-outline-danger mb-0 d-inline-flex align-items-center gap-1" style="border-radius: 8px;">
                                <i class="material-symbols-rounded text-sm">logout</i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forms Row -->
    <div class="row g-4">
        <!-- 1. Account Information -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; border: 1px solid #edf2f7 !important;">
                <div class="card-header pb-0 bg-transparent border-0 pt-4 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(26, 104, 91, 0.1); color: #1a685b;">
                            <i class="material-symbols-rounded" style="font-size: 20px;">badge</i>
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-0 text-dark">Account Details</h6>
                            <p class="text-xs text-muted mb-0">Your portal administrator identity and contact details</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 py-3">
                    <form method="post" action="<?= site_url('admin/update_admin_profile'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="action" value="update_info">

                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold text-dark text-uppercase">Username</label>
                            <input type="text" class="form-control bg-light" value="<?= html_escape($admin_user['username'] ?? ''); ?>" readonly style="border-radius: 8px; font-size: 0.85rem; cursor: not-allowed;">
                            <span class="text-xxs text-muted">Username is permanently assigned to this administrator account.</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold text-dark text-uppercase">Assigned Role</label>
                            <input type="text" class="form-control bg-light" value="<?= strtoupper(str_replace('_', ' ', $admin_user['role'] ?? 'admin')); ?>" readonly style="border-radius: 8px; font-size: 0.85rem; cursor: not-allowed;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold text-dark text-uppercase">Contact Email</label>
                            <input type="email" name="email" class="form-control" value="<?= html_escape($admin_user['email'] ?? ''); ?>" placeholder="admin@sfofindia.org" required style="border-radius: 8px; font-size: 0.85rem;">
                            <span class="text-xxs text-muted">Used for administrative notices and system recovery.</span>
                        </div>

                        <div class="pt-2 text-end">
                            <button type="submit" class="btn btn-sm btn-primary mb-0 shadow-sm d-inline-flex align-items-center gap-1" style="border-radius: 8px; padding: 0.5rem 1.25rem;">
                                <i class="material-symbols-rounded text-sm">save</i>
                                <span>Save Information</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2. Security & Password Change -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; border: 1px solid #edf2f7 !important;">
                <div class="card-header pb-0 bg-transparent border-0 pt-4 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                            <i class="material-symbols-rounded" style="font-size: 20px;">lock_reset</i>
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-0 text-dark">Security & Password</h6>
                            <p class="text-xs text-muted mb-0">Update your administrator password credentials</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 py-3">
                    <form method="post" action="<?= site_url('admin/update_admin_profile'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="action" value="change_password">

                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold text-dark text-uppercase">Current Password</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Enter your current password" required style="border-radius: 8px; font-size: 0.85rem;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold text-dark text-uppercase">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Minimum 6 characters" minlength="6" required style="border-radius: 8px; font-size: 0.85rem;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold text-dark text-uppercase">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter new password" minlength="6" required style="border-radius: 8px; font-size: 0.85rem;">
                        </div>

                        <div class="pt-2 text-end">
                            <button type="submit" class="btn btn-sm btn-dark mb-0 shadow-sm d-inline-flex align-items-center gap-1" style="border-radius: 8px; padding: 0.5rem 1.25rem;">
                                <i class="material-symbols-rounded text-sm">key</i>
                                <span>Update Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
