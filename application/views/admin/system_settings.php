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
                            <button class="nav-link font-weight-bold py-2" id="banking-tab" data-bs-toggle="tab" data-bs-target="#banking" type="button" role="tab">Banking & UPI</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-weight-bold py-2" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">Social Profiles</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-weight-bold py-2" id="gateways-tab" data-bs-toggle="tab" data-bs-target="#gateways" type="button" role="tab">Payment Gateways</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-weight-bold py-2" id="smtp-tab" data-bs-toggle="tab" data-bs-target="#smtp" type="button" role="tab">Email (SMTP)</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-weight-bold py-2" id="whatsapp-tab" data-bs-toggle="tab" data-bs-target="#whatsapp" type="button" role="tab">WhatsApp API</button>
                        </li>
                    </ul>
                </div>
                <form action="<?php echo site_url('system_settings/save'); ?>" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
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

                            <!-- Banking & UPI -->
                            <div class="tab-pane fade" id="banking" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'bank_name', 'AXIS BANK')); ?>" placeholder="e.g. AXIS BANK">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Account Holder Name</label>
                                        <input type="text" name="bank_account_name" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'bank_account_name', 'SHAHEED FOUNDATION')); ?>" placeholder="e.g. SHAHEED FOUNDATION">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Account Number</label>
                                        <input type="text" name="bank_account_no" class="form-control px-3 border font-monospace" value="<?php echo html_escape(cms_val($cms, 'bank_account_no', '925010034361992')); ?>" placeholder="e.g. 925010034361992">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">IFSC Code</label>
                                        <input type="text" name="bank_ifsc" class="form-control px-3 border font-monospace" value="<?php echo html_escape(cms_val($cms, 'bank_ifsc', 'UTIB0001970')); ?>" placeholder="e.g. UTIB0001970">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Branch Address</label>
                                        <input type="text" name="bank_branch" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'bank_branch', 'Sector 29, Gurgaon, Haryana 122001')); ?>" placeholder="e.g. Sector 29, Gurgaon, Haryana 122001">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">UPI ID / VPA</label>
                                        <input type="text" name="bank_upi_id" class="form-control px-3 border font-monospace" value="<?php echo html_escape(cms_val($cms, 'bank_upi_id', 'shaheedfoundation@axisbank')); ?>" placeholder="e.g. shaheedfoundation@axisbank">
                                    </div>
                                </div>
                            </div>

                            <!-- Social Profiles -->
                            <div class="tab-pane fade" id="social" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark"><i class="fab fa-facebook me-1 text-primary"></i> Facebook Page URL</label>
                                        <input type="url" name="social_facebook" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'social_facebook', '')); ?>" placeholder="https://facebook.com/...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark"><i class="fab fa-instagram me-1 text-danger"></i> Instagram Profile URL</label>
                                        <input type="url" name="social_instagram" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'social_instagram', '')); ?>" placeholder="https://instagram.com/...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark"><i class="fab fa-youtube me-1 text-danger"></i> YouTube Channel URL</label>
                                        <input type="url" name="social_youtube" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'social_youtube', 'https://youtube.com/@sfofindia')); ?>" placeholder="https://youtube.com/@...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark"><i class="fab fa-linkedin me-1 text-info"></i> LinkedIn Page URL</label>
                                        <input type="url" name="social_linkedin" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'social_linkedin', '')); ?>" placeholder="https://linkedin.com/company/...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark"><i class="fab fa-twitter me-1 text-dark"></i> Twitter / X URL</label>
                                        <input type="url" name="social_twitter" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'social_twitter', '')); ?>" placeholder="https://x.com/...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark"><i class="material-symbols-rounded me-1 align-middle text-sm">schedule</i> Office Hours / Timings</label>
                                        <input type="text" name="office_hours" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'office_hours', 'Mon - Sat: 9:00 AM - 6:00 PM')); ?>" placeholder="Mon - Sat: 9:00 AM - 6:00 PM">
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
                                        <input type="password" name="smtp_pass" class="form-control px-3 border" value="" placeholder="Leave blank to keep current password">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label font-weight-bold text-dark">From Email Address <small class="text-muted fw-normal">(Optional sender email override, e.g. for SendGrid / Amazon SES)</small></label>
                                        <input type="email" name="smtp_from_email" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'smtp_from_email', '')); ?>" placeholder="e.g. contact@sfofindia.org">
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp API -->
                            <div class="tab-pane fade" id="whatsapp" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="alert alert-light border d-flex align-items-center mb-3 p-3" style="border-radius: 10px;">
                                            <i class="material-symbols-rounded text-success fs-3 me-3">verified</i>
                                            <div>
                                                <strong class="d-block text-dark">WhatsApp Business / Cloud API Integration Ready</strong>
                                                <span class="text-xs text-muted">The system is pre-wired to dispatch WhatsApp notifications for Donation Receipts, Member Welcome & Verification, Renewal Reminders, and Birthday Greetings. When disabled, it runs safely in standby mode without erroring.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Enable WhatsApp Notifications</label>
                                        <select name="whatsapp_enabled" class="form-select border">
                                            <option value="0" <?php echo cms_val($cms, 'whatsapp_enabled', '0') !== '1' ? 'selected' : ''; ?>>Disabled (Standby Mode)</option>
                                            <option value="1" <?php echo cms_val($cms, 'whatsapp_enabled', '0') === '1' ? 'selected' : ''; ?>>Enabled (Active Delivery)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label font-weight-bold text-dark">API Provider</label>
                                        <select name="whatsapp_provider" class="form-select border">
                                            <option value="meta_cloud" <?php echo cms_val($cms, 'whatsapp_provider', 'meta_cloud') === 'meta_cloud' ? 'selected' : ''; ?>>Meta WhatsApp Cloud API (Official)</option>
                                            <option value="twilio" <?php echo cms_val($cms, 'whatsapp_provider', '') === 'twilio' ? 'selected' : ''; ?>>Twilio WhatsApp API</option>
                                            <option value="generic_webhook" <?php echo cms_val($cms, 'whatsapp_provider', '') === 'generic_webhook' ? 'selected' : ''; ?>>Generic Webhook / Custom Gateway (WATI / Aisensy / Fast2SMS / UltraMsg)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Sender Phone Number ID / Channel</label>
                                        <input type="text" name="whatsapp_phone_number_id" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'whatsapp_phone_number_id', '')); ?>" placeholder="e.g. 104829104829104 or whatsapp:+14155238886">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">API Endpoint URL</label>
                                        <input type="url" name="whatsapp_api_url" class="form-control px-3 border font-monospace" value="<?php echo html_escape(cms_val($cms, 'whatsapp_api_url', '')); ?>" placeholder="e.g. https://graph.facebook.com/v18.0/{phone_number_id}/messages or your webhook URL">
                                        <small class="text-xs text-muted">For Meta Cloud API, leave blank or enter your Graph API messages endpoint.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">API Access Token / Bearer Key</label>
                                        <input type="password" name="whatsapp_api_key" class="form-control px-3 border font-monospace" value="" placeholder="Leave blank to keep existing key">
                                        <small class="text-xs text-muted">Permanent system user token or gateway API key.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Donation Template Name <small class="text-muted fw-normal">(Optional for Meta Cloud API)</small></label>
                                        <input type="text" name="whatsapp_template_donation" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'whatsapp_template_donation', 'donation_receipt')); ?>" placeholder="donation_receipt">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold text-dark">Welcome/Verification Template Name <small class="text-muted fw-normal">(Optional for Meta Cloud API)</small></label>
                                        <input type="text" name="whatsapp_template_welcome" class="form-control px-3 border" value="<?php echo html_escape(cms_val($cms, 'whatsapp_template_welcome', 'member_welcome')); ?>" placeholder="member_welcome">
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
