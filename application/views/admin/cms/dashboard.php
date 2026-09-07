<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_tab = isset($active_tab) ? $active_tab : 'settings';
$cms_role = isset($cms_role) ? $cms_role : 'admin';
$default_tabs = array('settings', 'homepage', 'pages', 'reports', 'events', 'projects', 'campaigns', 'audit', 'users');
$cms_tabs = (isset($cms_tabs) && is_array($cms_tabs)) ? $cms_tabs : $default_tabs;
if (count($cms_tabs) === 0) {
	$cms_tabs = array('settings');
}

$tab_defs = array(
	'settings' => array('label' => 'System / Contact', 'icon' => 'tune'),
	'homepage' => array('label' => 'Homepage content', 'icon' => 'home'),
	'pages' => array('label' => 'Inner pages (HTML)', 'icon' => 'article'),
	'reports' => array('label' => 'Reports & NGO', 'icon' => 'analytics'),
	'events' => array('label' => 'Events', 'icon' => 'event'),
	'projects' => array('label' => 'Projects', 'icon' => 'work'),
	'campaigns' => array('label' => 'Campaigns', 'icon' => 'campaign'),
	'audit' => array('label' => 'Audit reports', 'icon' => 'description'),
	'users' => array('label' => 'CMS users', 'icon' => 'group'),
	'web_update' => array('label' => 'Web update ⚙️', 'icon' => 'settings'),
);

$is_member = ($cms_role === 'member');
$is_super = ($cms_role === 'super_admin');
$pane_id = function ($key) {
	return 'cms-pane-' . str_replace('_', '-', $key);
};
?>
<style>
	/* --- Premium Dashboard UI --- */
	.cms-hub .breadcrumb a { color: #4f46e5; text-decoration: none; font-weight: 500; }
	.cms-hub .breadcrumb a:hover { color: #7c3aed; }
	
	#cmsSideNav .nav-link { 
		border-radius: 12px; 
		padding: 0.75rem 1rem; 
		color: #475569; 
		font-weight: 600; 
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		border-left: 4px solid transparent;
		margin-bottom: 4px;
	}
	
	#cmsSideNav .nav-link:hover { 
		background: rgba(79, 70, 229, 0.05); 
		color: #4f46e5;
		transform: translateX(4px);
	}
	
	#cmsSideNav .nav-link.active { 
		background: #fff !important;
		color: #4f46e5; 
		border-left-color: #4f46e5; 
		box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
		padding-left: 1.1rem;
	}

	/* --- Staggered Tab Animation --- */
	.tab-pane.fade {
		transform: translateY(15px);
		opacity: 0;
		transition: transform 0.4s ease-out, opacity 0.4s ease-out !important;
	}
	
	.tab-pane.show.active {
		transform: translateY(0);
		opacity: 1;
	}

	.cms-hub .card { 
		border: none !important; 
		box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important;
	}
	
	.cms-hub .card-body h5 {
		font-weight: 700;
		color: #1e293b;
	}

	.cms-hub .btn { 
		box-shadow: 0 2px 6px rgba(0,0,0,0.05); 
	}
	
	@media (max-width: 575.98px) {
		.cms-hub h4 { font-size: 1.1rem; }
		.btn-link { text-align: left; padding-left: 0; }
	}
</style>
<div class="container-fluid py-4 cms-hub">
	<div class="row">
		<div class="col-12 mb-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-2 bg-transparent p-0 small">
					<li class="breadcrumb-item"><a href="<?php echo site_url('admin'); ?>">Admin</a></li>
					<li class="breadcrumb-item active" aria-current="page">Website CMS</li>
				</ol>
			</nav>
			<div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
				<div>
					<h4 class="mb-1"><?php echo $is_member ? 'Blog (NGO member)' : 'Website CMS hub'; ?></h4>
					<p class="text-sm text-muted mb-0"><?php echo $is_member ? 'Blog add/edit only.' : 'Sections on the left — forms on the right. Manager/coordinator: open Reports first.'; ?></p>
					<p class="text-xs text-muted mb-0 mt-1">Logged in as <strong><?php $x =& get_instance(); echo html_escape($x->session->userdata('cms_admin_name')); ?></strong>
						<span class="badge bg-secondary ms-1"><?php echo html_escape($cms_role); ?></span>
					</p>
				</div>
				<div class="d-flex flex-wrap gap-2 align-items-center">
					<a class="btn btn-sm btn-link" href="<?php echo site_url('admin/logout'); ?>">Logout</a>
				</div>
			</div>
		</div>

		<!-- Automation Status Widget -->
		<div class="row mt-4">
			<div class="col-12">
				<div class="card border-0 shadow-sm" style="border-radius:15px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
					<div class="card-body p-4">
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div>
								<h6 class="mb-0 font-weight-bold text-dark"><i class="material-symbols-rounded align-middle me-2 text-primary">smart_toy</i> System Intelligence & Automation</h6>
								<p class="text-xs text-muted mb-0">Automated background tasks are running to keep your NGO active.</p>
							</div>
							<div class="badge bg-success-soft text-success border border-success-soft px-3 py-2 rounded-pill">
								<span class="d-inline-block bg-success rounded-circle me-1" style="width:8px; height:8px;"></span> Background Active
							</div>
						</div>
						<div class="row g-4">
							<div class="col-md-4">
								<div class="d-flex align-items-center">
									<div class="bg-white rounded-circle p-2 shadow-xs me-3">
										<i class="material-symbols-rounded text-primary">cake</i>
									</div>
									<div>
										<p class="text-xs font-weight-bold text-uppercase text-muted mb-0">Birthday Wishes</p>
										<p class="text-sm font-weight-bolder mb-0">Automated & Daily</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="d-flex align-items-center">
									<div class="bg-white rounded-circle p-2 shadow-xs me-3">
										<i class="material-symbols-rounded text-info">history_toggle_off</i>
									</div>
									<div>
										<p class="text-xs font-weight-bold text-uppercase text-muted mb-0">Renewal Tracking</p>
										<p class="text-sm font-weight-bolder mb-0">7-Day Notifications</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="d-flex align-items-center">
									<div class="bg-white rounded-circle p-2 shadow-xs me-3">
										<i class="material-symbols-rounded text-warning">mark_email_read</i>
									</div>
									<div>
										<p class="text-xs font-weight-bold text-uppercase text-muted mb-0">Document Delivery</p>
										<p class="text-sm font-weight-bolder mb-0">Auto ID Cards Enabled</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php $ci =& get_instance(); if ($ci->session->flashdata('cms_success')): ?>
			<div class="col-12">
				<div class="alert alert-success"><?php echo $ci->session->flashdata('cms_success'); ?></div>
			</div>
		<?php endif; ?>
		<?php if ($ci->session->flashdata('cms_error')): ?>
			<div class="col-12">
				<div class="alert alert-danger"><?php echo $ci->session->flashdata('cms_error'); ?></div>
			</div>
		<?php endif; ?>
		<?php if ($ci->session->flashdata('success')): ?>
			<div class="col-12">
				<div class="alert alert-success"><?php echo $ci->session->flashdata('success'); ?></div>
			</div>
		<?php endif; ?>
		<?php if ($ci->session->flashdata('errors')): ?>
			<div class="col-12">
				<div class="alert alert-danger"><?php echo $ci->session->flashdata('errors'); ?></div>
			</div>
		<?php endif; ?>
		<?php if ($ci->session->flashdata('error')): ?>
			<div class="col-12">
				<div class="alert alert-warning"><?php echo $ci->session->flashdata('error'); ?></div>
			</div>
		<?php endif; ?>

		<div class="col-12">
			<div class="row g-3">
				<div class="col-12 col-lg-3">
					<div class="card border">
						<div class="card-body p-2">
							<div class="text-uppercase text-xs text-muted px-2 pt-1 pb-2">Sections</div>
							<div class="nav flex-column nav-pills gap-1" id="cmsSideNav" role="tablist" aria-orientation="vertical">
								<?php foreach ($tab_defs as $tid => $meta): ?>
									<?php if (!in_array($tid, $cms_tabs, true)) { continue; } ?>
									<?php
									$pid = $pane_id($tid);
									$sel = ($active_tab === $tid) ? 'true' : 'false';
									$active = ($active_tab === $tid);
									?>
									<button class="nav-link text-start <?php echo $active ? 'active' : ''; ?>" id="cms-tab-<?php echo html_escape(str_replace('_', '-', $tid)); ?>" data-bs-toggle="pill" data-bs-target="#<?php echo $pid; ?>" type="button" role="tab" aria-controls="<?php echo $pid; ?>" aria-selected="<?php echo $sel; ?>">
										<span class="me-2"><i class="material-symbols-rounded align-middle" style="font-size:18px;"><?php echo html_escape($meta['icon']); ?></i></span>
										<?php echo html_escape($meta['label']); ?>
									</button>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-9">
					<div class="tab-content" id="cmsMainTabContent">
						<?php if (in_array('settings', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'settings') ? 'show active' : ''; ?>" id="<?php echo $pane_id('settings'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">System settings</h5>
									<p class="text-sm text-muted mb-0">SEO, branding, contact, integrations (Analytics, map, WhatsApp, PWA).</p>
								</div>
							</div>
							<?php $this->load->view('admin/cms/partials/settings_form', array('cms' => $cms, 'embed' => true)); ?>
						</div>
						<?php endif; ?>

						<?php if (in_array('homepage', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'homepage') ? 'show active' : ''; ?>" id="<?php echo $pane_id('homepage'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">Homepage</h5>
									<p class="text-sm text-muted mb-0">Hero slides and about section.</p>
								</div>
							</div>
							<?php $this->load->view('admin/cms/partials/homepage_form', array('cms' => $cms, 'embed' => true)); ?>
						</div>
						<?php endif; ?>

						<?php if (in_array('pages', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'pages') ? 'show active' : ''; ?>" id="<?php echo $pane_id('pages'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">Inner pages (full HTML override)</h5>
									<p class="text-sm text-muted mb-0">Leave empty to use default templates.</p>
								</div>
							</div>
							<div style="max-height:70vh;overflow-y:auto;padding-right:4px;">
								<?php $this->load->view('admin/cms/partials/pages_form', array('cms' => $cms, 'page_fields' => $page_fields, 'embed' => true)); ?>
							</div>
						</div>
						<?php endif; ?>

						<?php if (in_array('reports', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'reports') ? 'show active' : ''; ?>" id="<?php echo $pane_id('reports'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">Reports & overview</h5>
									<p class="text-sm text-muted mb-0">Members, donations, exports, contact messages, activity log.</p>
								</div>
							</div>
							<?php $this->load->view('admin/cms/partials/reports_tab', array(
								'report_stats' => isset($report_stats) ? $report_stats : array(),
								'complaints_recent' => isset($complaints_recent) ? $complaints_recent : array(),
								'cms_role' => $cms_role,
							)); ?>
						</div>
						<?php endif; ?>

						<?php if (in_array('events', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'events') ? 'show active' : ''; ?>" id="<?php echo $pane_id('events'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">Events</h5>
									<p class="text-sm text-muted mb-0">Public events module (stored in <code>ngom_events</code>).</p>
								</div>
							</div>
							<?php $this->load->view('admin/cms/partials/events_tab', array('ngom_events' => isset($ngom_events) ? $ngom_events : array(), 'cms_role' => $cms_role)); ?>
						</div>
						<?php endif; ?>

						<?php if (in_array('projects', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'projects') ? 'show active' : ''; ?>" id="<?php echo $pane_id('projects'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">Projects</h5>
									<p class="text-sm text-muted mb-0">NGO projects listing.</p>
								</div>
							</div>
							<?php $this->load->view('admin/cms/partials/projects_tab', array('ngom_projects' => isset($ngom_projects) ? $ngom_projects : array(), 'cms_role' => $cms_role)); ?>
						</div>
						<?php endif; ?>

						<?php if (in_array('campaigns', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'campaigns') ? 'show active' : ''; ?>" id="<?php echo $pane_id('campaigns'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">Crowdfunding campaigns</h5>
									<p class="text-sm text-muted mb-0">Campaign cards for the public site (link from your pages).</p>
								</div>
							</div>
							<?php $this->load->view('admin/cms/partials/campaigns_tab', array('ngom_campaigns' => isset($ngom_campaigns) ? $ngom_campaigns : array(), 'cms_role' => $cms_role)); ?>
						</div>
						<?php endif; ?>

						<?php if (in_array('audit', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'audit') ? 'show active' : ''; ?>" id="<?php echo $pane_id('audit'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">Audit reports</h5>
									<p class="text-sm text-muted mb-0">PDF or document paths for transparency.</p>
								</div>
							</div>
							<?php $this->load->view('admin/cms/partials/audit_tab', array('ngom_audit' => isset($ngom_audit) ? $ngom_audit : array(), 'cms_role' => $cms_role)); ?>
						</div>
						<?php endif; ?>
						
						<?php if (in_array('web_update', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'web_update') ? 'show active' : ''; ?>" id="<?php echo $pane_id('web_update'); ?>" role="tabpanel">
							<div class="card border-0 shadow-sm mb-4" style="border-radius:15px; overflow:hidden;">
								<div class="card-header p-0">
									<ul class="nav nav-tabs nav-tabs-primary p-2 bg-gray-100" id="webUpdateSubTab" role="tablist">
										<li class="nav-item"><button class="nav-link active py-2" data-bs-toggle="tab" data-bs-target="#wu-branding" type="button" role="tab">Branding & SEO</button></li>
										<li class="nav-item"><button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#wu-contact" type="button" role="tab">Contact & Maps</button></li>
										<li class="nav-item"><button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#wu-gateways" type="button" role="tab">Payment Gateways</button></li>
										<li class="nav-item"><button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#wu-smtp" type="button" role="tab">Email (SMTP)</button></li>
									</ul>
								</div>
								<form action="<?php echo site_url('cms/save_settings'); ?>" method="post">
									<input type="hidden" name="redirect_tab" value="web_update">
									<div class="card-body p-4">
										<div class="tab-content">
											<div class="tab-pane fade show active" id="wu-branding" role="tabpanel">
												<div class="row g-3">
													<div class="col-md-6 mb-3">
														<label class="form-label font-weight-bold">Organization Name</label>
														<input type="text" name="site_name" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'site_name', '')); ?>">
													</div>
													<div class="col-md-6 mb-3">
														<label class="form-label font-weight-bold">Social Media Title (SEO)</label>
														<input type="text" name="meta_title" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'meta_title', '')); ?>">
													</div>
													<div class="col-12 mb-3">
														<label class="form-label font-weight-bold">Meta Description</label>
														<textarea name="meta_description" class="form-control px-3 border" rows="3"><?php echo html_escape(cms_val($cms, 'meta_description', '')); ?></textarea>
													</div>
												</div>
											</div>
											<div class="tab-pane fade" id="wu-contact" role="tabpanel">
												<div class="row g-3">
													<div class="col-md-6 mb-3">
														<label class="form-label font-weight-bold">Phone</label>
														<input type="text" name="contact_phone" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'contact_phone', '')); ?>">
													</div>
													<div class="col-md-6 mb-3">
														<label class="form-label font-weight-bold">Email</label>
														<input type="email" name="contact_email" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'contact_email', '')); ?>">
													</div>
													<div class="col-12 mb-3">
														<label class="form-label font-weight-bold">Address</label>
														<textarea name="contact_address" class="form-control px-3 border" rows="2"><?php echo html_escape(cms_val($cms, 'contact_address', '')); ?></textarea>
													</div>
												</div>
											</div>
											<div class="tab-pane fade" id="wu-gateways" role="tabpanel">
												<div class="row g-3">
													<div class="col-md-6 mb-3"><label class="form-label font-weight-bold">Razorpay Key ID</label><input type="text" name="razorpay_key_id" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'razorpay_key_id', '')); ?>"></div>
													<div class="col-md-6 mb-3"><label class="form-label font-weight-bold">Razorpay Secret</label><input type="password" name="razorpay_key_secret" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'razorpay_key_secret', '')); ?>"></div>
													<div class="col-md-6 mb-3"><label class="form-label font-weight-bold">Stripe Public</label><input type="text" name="stripe_public_key" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'stripe_public_key', '')); ?>"></div>
													<div class="col-md-6 mb-3"><label class="form-label font-weight-bold">Stripe Secret</label><input type="password" name="stripe_secret_key" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'stripe_secret_key', '')); ?>"></div>
												</div>
											</div>
											<div class="tab-pane fade" id="wu-smtp" role="tabpanel">
												<div class="row g-3">
													<div class="col-md-6 mb-3"><label class="form-label font-weight-bold">SMTP Host</label><input type="text" name="smtp_host" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'smtp_host', '')); ?>"></div>
													<div class="col-md-3 mb-3"><label class="form-label font-weight-bold">Port</label><input type="text" name="smtp_port" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'smtp_port', '')); ?>"></div>
													<div class="col-md-3 mb-3"><label class="form-label font-weight-bold">User</label><input type="text" name="smtp_user" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'smtp_user', '')); ?>"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer bg-gray-100 border-top mt-4 px-4 py-3 text-end">
										<button type="submit" class="btn bg-gradient-primary mb-0">Apply Changes</button>
									</div>
								</form>
							</div>
						</div>
						<?php endif; ?>

						<?php if (in_array('users', $cms_tabs, true)): ?>
						<div class="tab-pane fade <?php echo ($active_tab === 'users') ? 'show active' : ''; ?>" id="<?php echo $pane_id('users'); ?>" role="tabpanel">
							<div class="card border mb-3">
								<div class="card-body">
									<h5 class="mb-1">CMS users</h5>
									<p class="text-sm text-muted mb-0">Super admin only — roles include manager & coordinator.</p>
								</div>
							</div>
							<?php $this->load->view('admin/cms/partials/users_manage', array(
								'cms_users' => isset($cms_users) ? $cms_users : array(),
								'cms_role_options' => isset($cms_role_options) ? $cms_role_options : array(),
							)); ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
(function () {
	var map = {
		'cms-pane-settings': 'settings',
		'cms-pane-homepage': 'homepage',
		'cms-pane-pages': 'pages',
		'cms-pane-reports': 'reports',
		'cms-pane-events': 'events',
		'cms-pane-gallery': 'gallery',
		'cms-pane-projects': 'projects',
		'cms-pane-campaigns': 'campaigns',
		'cms-pane-audit': 'audit',
		'cms-pane-blog': 'blog',
		'cms-pane-blog-list': 'blog_list',
		'cms-pane-users': 'users'
	};
	function setTabParam(id) {
		var t = map[id] || 'settings';
		var u = new URL(window.location.href);
		u.searchParams.set('tab', t);
		if (t !== 'blog') {
			u.searchParams.delete('id');
		}
		window.history.replaceState({}, '', u);
	}
	document.querySelectorAll('#cmsSideNav [data-bs-toggle="pill"]').forEach(function (btn) {
		btn.addEventListener('shown.bs.tab', function (e) {
			var target = e.target.getAttribute('data-bs-target');
			if (target && target.charAt(0) === '#') {
				setTabParam(target.slice(1));
			}
		});
	});
})();
</script>
