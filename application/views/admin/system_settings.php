<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0 font-weight-bolder">Global System Settings</h4>
            <p class="text-sm text-muted mb-0">Configure your NGO's branding, SEO, contact info, and payment integrations.</p>
        </div>
    </div>

    <?php $ci =& get_instance(); ?>
    <?php if ($ci->session->flashdata('cms_success')): ?>
        <div class="alert alert-success text-white border-0 shadow-sm"><i class="material-symbols-rounded align-middle me-2">check_circle</i> <?php echo $ci->session->flashdata('cms_success'); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:15px;">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs nav-tabs-primary p-2 bg-gray-100" id="settingsTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active font-weight-bold py-2" id="branding-tab" data-bs-toggle="tab" data-bs-target="#branding" type="button" role="tab">Branding & SEO</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-weight-bold py-2" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">Contact & Maps</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-weight-bold py-2" id="gateways-tab" data-bs-toggle="tab" data-bs-target="#gateways" type="button" role="tab">Payment Gateways</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-weight-bold py-2" id="smtp-tab" data-bs-toggle="tab" data-bs-target="#smtp" type="button" role="tab">Email (SMTP)</button>
                        </li>
                    </ul>
                </div>
                <form action="<?php echo site_url('system_settings/save'); ?>" method="post">
                    <div class="card-body p-4">
                        <div class="tab-content" id="settingsTabContent">
                            <!-- Branding -->
                            <div class="tab-pane fade show active" id="branding" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Organization Name</label>
                                        <input type="text" name="site_name" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'site_name', '')); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Social Media Title (SEO)</label>
                                        <input type="text" name="meta_title" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'meta_title', '')); ?>">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Meta Description</label>
                                        <textarea name="meta_description" class="form-control px-3 border" rows="3"><?php echo html_escape(cms_val($cms, 'meta_description', '')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="tab-pane fade" id="contact" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Official Phone</label>
                                        <input type="text" name="contact_phone" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'contact_phone', '')); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Official Email</label>
                                        <input type="email" name="contact_email" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'contact_email', '')); ?>">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Office Address</label>
                                        <textarea name="contact_address" class="form-control px-3 border" rows="2"><?php echo html_escape(cms_val($cms, 'contact_address', '')); ?></textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Google Maps Embed (iframe HTML)</label>
                                        <textarea name="google_map_embed" class="form-control px-3 border font-monospace" rows="3"><?php echo html_escape(cms_val($cms, 'google_map_embed', '')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Gateways -->
                            <div class="tab-pane fade" id="gateways" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Razorpay Key ID</label>
                                        <input type="text" name="razorpay_key_id" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'razorpay_key_id', '')); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Razorpay Secret</label>
                                        <input type="password" name="razorpay_key_secret" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'razorpay_key_secret', '')); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Stripe Public Key</label>
                                        <input type="text" name="stripe_public_key" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'stripe_public_key', '')); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Stripe Secret Key</label>
                                        <input type="password" name="stripe_secret_key" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'stripe_secret_key', '')); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- SMTP -->
                            <div class="tab-pane fade" id="smtp" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">SMTP Host</label>
                                        <input type="text" name="smtp_host" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'smtp_host', '')); ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label font-weight-bold text-dark">SMTP Port</label>
                                        <input type="text" name="smtp_port" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'smtp_port', '')); ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Encryption</label>
                                        <select name="smtp_crypto" class="form-select border">
                                            <option value="" <?php echo cms_val($cms, 'smtp_crypto', '') === '' ? 'selected' : ''; ?>>None</option>
                                            <option value="tls" <?php echo cms_val($cms, 'smtp_crypto', '') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                                            <option value="ssl" <?php echo cms_val($cms, 'smtp_crypto', '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">SMTP Username</label>
                                        <input type="text" name="smtp_user" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'smtp_user', '')); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">SMTP Password</label>
                                        <input type="password" name="smtp_pass" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'smtp_pass', '')); ?>">
                                    </div>
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
    </div>
</div>

<style>
.nav-tabs-primary .nav-link {
    border: none;
    border-radius: 8px;
    margin: 4px;
    color: #6c757d;
    transition: all 0.3s ease;
}
.nav-tabs-primary .nav-link.active {
    background: white !important;
    color: #4f46e5 !important;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
.form-control:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
}
</style>
