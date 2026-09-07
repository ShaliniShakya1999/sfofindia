<?php defined('BASEPATH') OR exit('No direct script access allowed');
$rows = isset($cms_users) && is_array($cms_users) ? $cms_users : array();
$self_id = (int) get_instance()->session->userdata('cms_admin_id');
$roles = isset($cms_role_options) && is_array($cms_role_options) ? $cms_role_options : array('super_admin', 'admin', 'member');
?>
<div class="card border mb-3">
	<div class="card-body">
		<h5 class="mb-1">Add NGO CMS user</h5>
		<p class="text-sm text-muted mb-3">Roles: <strong>super_admin</strong> (Full control + user management), <strong>admin</strong> (Manage members, content, donations), <strong>member</strong> (Limited access to profile and blog).</p>
		<form method="post" action="<?php echo site_url('cms/save_user'); ?>" class="row g-2 align-items-end">
			<div class="col-md-3">
				<label class="form-label">Username</label>
				<input type="text" name="username" class="form-control" required maxlength="64" autocomplete="username">
			</div>
			<div class="col-md-3">
				<label class="form-label">Password</label>
				<input type="password" name="password" class="form-control" required minlength="6" autocomplete="new-password">
			</div>
			<div class="col-md-3">
				<label class="form-label">Role</label>
				<select name="role" class="form-select">
					<?php foreach ($roles as $r): ?>
						<option value="<?php echo html_escape($r); ?>"<?php echo $r === 'member' ? ' selected' : ''; ?>><?php echo html_escape($r); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-3">
				<button type="submit" class="btn btn-primary w-100">Create user</button>
			</div>
		</form>
	</div>
</div>

<div class="card border">
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table align-items-center mb-0">
				<thead>
					<tr>
						<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
						<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
						<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
						<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($rows as $u): ?>
						<tr>
							<td><?php echo (int) $u['id']; ?></td>
							<td><?php echo html_escape($u['username']); ?><?php echo ((int) $u['id'] === $self_id) ? ' <span class="text-muted small">(you)</span>' : ''; ?></td>
							<td>
								<form method="post" action="<?php echo site_url('cms/update_user'); ?>" class="d-flex flex-wrap gap-2 align-items-center">
									<input type="hidden" name="user_id" value="<?php echo (int) $u['id']; ?>">
									<select name="role" class="form-select form-select-sm" style="max-width:160px;">
										<?php foreach ($roles as $r): ?>
											<option value="<?php echo html_escape($r); ?>"<?php echo ($u['role'] === $r) ? ' selected' : ''; ?>><?php echo html_escape($r); ?></option>
										<?php endforeach; ?>
									</select>
									<input type="password" name="new_password" class="form-control form-control-sm" style="max-width:160px;" placeholder="New password" autocomplete="new-password">
									<button type="submit" class="btn btn-sm btn-outline-primary mb-0">Save</button>
								</form>
							</td>
							<td class="text-end">
								<?php if ((int) $u['id'] !== $self_id): ?>
									<a class="btn btn-sm btn-outline-danger mb-0" href="<?php echo site_url('cms/delete_user'); ?>?id=<?php echo (int) $u['id']; ?>" onclick="return confirm('Delete this user?');">Delete</a>
								<?php else: ?>
									<span class="text-muted small">—</span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
