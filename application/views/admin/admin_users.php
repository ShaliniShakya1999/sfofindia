<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Admins</p>
                                <h5 class="font-weight-bolder mb-0"><?php echo $stats['total']; ?></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="material-symbols-rounded text-white opacity-10">groups</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Active Staff</p>
                                <h5 class="font-weight-bolder text-success mb-0"><?php echo $stats['active']; ?></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="material-symbols-rounded text-white opacity-10">check_circle</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Suspended</p>
                                <h5 class="font-weight-bolder text-danger mb-0"><?php echo $stats['inactive']; ?></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="material-symbols-rounded text-white opacity-10">block</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Super Admins</p>
                                <h5 class="font-weight-bolder text-dark mb-0"><?php echo $stats['super']; ?></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-dark shadow-dark text-center rounded-circle">
                                <i class="material-symbols-rounded text-white opacity-10">stars</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius:15px;">
                <div class="card-header pb-0 bg-transparent border-0 d-flex justify-content-between align-items-center px-4 pt-4">
                    <h6 class="mb-0 font-weight-bold text-lg"><i class="material-symbols-rounded align-middle me-2">admin_panel_settings</i> All Administrators</h6>
                    <button class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="material-symbols-rounded align-middle me-1">person_add</i> New Admin
                    </button>
                </div>
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Staff Member</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Login</th>
                                    <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $self_id = (int)$this->session->userdata('cms_admin_id'); ?>
                                <?php foreach($users as $u): 
                                    $initial = strtoupper($u['username'][0]);
                                    $colors = ['primary', 'info', 'success', 'warning', 'danger', 'dark'];
                                    $c = $colors[$u['id'] % count($colors)];
                                    $isActive = ($u['status'] ?? 1) == 1;
                                ?>
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex py-1 align-items-center">
                                            <div class="avatar avatar-sm me-3 bg-gradient-<?php echo $c; ?> border-radius-md d-flex align-items-center justify-content-center">
                                                <span class="text-white font-weight-bold"><?php echo $initial; ?></span>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><?php echo html_escape($u['username']); ?> <?php if((int)$u['id'] === $self_id) echo '<small class="text-primary font-weight-bold">(You)</small>'; ?></h6>
                                                <p class="text-xs text-secondary mb-0"><?php echo html_escape($u['email'] ?: 'No email set'); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm border bg-light text-dark font-weight-bolder">
                                            <?php echo strtoupper(str_replace('_', ' ', $u['role'])); ?>
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <a href="<?php echo site_url('admin_users/toggle_status/'.$u['id']); ?>" 
                                           class="badge badge-sm bg-gradient-<?php echo $isActive ? 'success' : 'secondary'; ?> border-0 text-white cursor-pointer"
                                           onclick="return confirm('Toggle account status for this user?');">
                                            <?php echo $isActive ? 'Active' : 'Suspended'; ?>
                                        </a>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            <?php echo $u['last_login'] ? date('d M, h:i A', strtotime($u['last_login'])) : 'Never logged in'; ?>
                                        </span>
                                    </td>
                                    <td class="align-middle text-end px-4">
                                        <button class="btn btn-link text-primary text-gradient px-3 mb-0" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $u['id']; ?>">
                                            <i class="material-symbols-rounded text-sm me-1">edit</i> Edit
                                        </button>
                                        <?php if((int)$u['id'] !== $self_id): ?>
                                            <a href="javascript:void(0);" onclick="return confirmDelete('<?php echo site_url('admin_users/delete/'.$u['id']); ?>', 'This user will lose all dashboard access.')" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                <i class="material-symbols-rounded text-sm me-1">delete</i> Delete
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?php echo $u['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-radius-lg border-0 shadow-lg">
                                            <div class="modal-header border-bottom">
                                                <h6 class="modal-title font-weight-bold">Modify Admin: <?php echo $u['username']; ?></h6>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close" style="font-size: 1.5rem;">&times;</button>
                                            </div>
                                            <form action="<?php echo site_url('admin_users/update/'.$u['id']); ?>" method="post">
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label text-dark font-weight-bold text-xs text-uppercase">Role Access</label>
                                                        <select name="role" class="form-select border px-3">
                                                            <?php foreach($roles as $r): ?>
                                                                <option value="<?php echo $r; ?>" <?php if($u['role'] === $r) echo 'selected'; ?>><?php echo ucfirst(str_replace('_', ' ', $r)); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-0">
                                                        <label class="form-label text-dark font-weight-bold text-xs text-uppercase">New Password <small class="text-muted text-lowercase">(leave blank to keep current)</small></label>
                                                        <input type="password" name="new_password" class="form-control border px-3" placeholder="Min 6 characters">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top px-4">
                                                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn bg-gradient-primary mb-0">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-radius-lg border-0 shadow-lg">
            <div class="modal-header border-bottom">
                <h6 class="modal-title font-weight-bold">Create System Administrator</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close" style="font-size: 1.5rem;">&times;</button>
            </div>
            <form action="<?php echo site_url('admin_users/save'); ?>" method="post">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-dark font-weight-bold text-xs text-uppercase">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control border px-3" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark font-weight-bold text-xs text-uppercase">Email Address</label>
                        <input type="email" name="email" class="form-control border px-3" autocomplete="off" placeholder="staff@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark font-weight-bold text-xs text-uppercase">Initial Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control border px-3" required minlength="6" autocomplete="new-password">
                    </div>
                    <div class="mb-0">
                        <label class="form-label text-dark font-weight-bold text-xs text-uppercase">Access Role</label>
                        <select name="role" class="form-select border px-3">
                            <option value="admin">Standard Admin (Staff)</option>
                            <option value="super_admin">Super Admin (Full Access)</option>
                            <option value="member">Management (Reports / Blog Only)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top px-4">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Initialize Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.icon-shape {
    width: 48px;
    height: 48px;
    background-position: center;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.icon-shape i { top: 0px !important; }
.avatar-sm { width: 36px; height: 36px; }
.badge { text-transform: none; padding: 0.5em 0.8em; }
.table thead th { border-bottom: 0 !important; }
.table td { border-bottom: 1px solid #f8f9fa !important; }
</style>
