<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:15px; background: linear-gradient(135deg,#10b981,#0ea5e9);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                            <i class="material-symbols-rounded text-white" style="font-size:32px;">support_agent</i>
                        </div>
                        <div>
                            <h4 class="text-white mb-0 font-weight-bolder">Support Center</h4>
                            <p class="text-white opacity-8 mb-0 text-sm">We're here to help you. Reach out anytime.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- Contact Info Cards -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius:15px;">
                <div class="icon icon-shape bg-gradient-primary shadow-primary border-radius-md mx-auto mb-3">
                    <i class="material-symbols-rounded opacity-10">phone</i>
                </div>
                <h6 class="font-weight-bolder mb-1">Call Us</h6>
                <p class="text-sm text-muted mb-0">Available Mon–Sat, 9AM – 6PM</p>
                <a href="tel:+919876543210" class="btn btn-sm btn-outline-primary rounded-pill mt-3">+91 98765 43210</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius:15px;">
                <div class="icon icon-shape bg-gradient-success shadow-success border-radius-md mx-auto mb-3">
                    <i class="material-symbols-rounded opacity-10">email</i>
                </div>
                <h6 class="font-weight-bolder mb-1">Email Us</h6>
                <p class="text-sm text-muted mb-0">We reply within 24 working hours</p>
                <a href="mailto:support@shaheedfoundation.org" class="btn btn-sm btn-outline-success rounded-pill mt-3">support@shaheedfoundation.org</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius:15px;">
                <div class="icon icon-shape bg-gradient-warning shadow-warning border-radius-md mx-auto mb-3">
                    <i class="material-symbols-rounded opacity-10">location_on</i>
                </div>
                <h6 class="font-weight-bolder mb-1">Visit Us</h6>
                <p class="text-sm text-muted mb-0">Shaheed Foundation Office, India</p>
                <a href="https://maps.google.com" target="_blank" class="btn btn-sm btn-outline-warning rounded-pill mt-3">Get Directions</a>
            </div>
        </div>

        <!-- Support Form -->
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="font-weight-bolder mb-0">Send Us a Message</h5>
                    <p class="text-xs text-muted mb-0">Fill the form below and our team will get back to you shortly.</p>
                </div>
                <div class="card-body p-4">
                    <?php if ($this->session->flashdata('support_success')): ?>
                        <div class="alert alert-success text-white text-sm mb-3">
                            ✅ <?php echo html_escape($this->session->flashdata('support_success')); ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo site_url('admin/support_submit'); ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label form-control-label">Your Name</label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" value="<?php echo html_escape($member['name']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label form-control-label">Your Email</label>
                                <div class="input-group input-group-outline">
                                    <input type="email" class="form-control" value="<?php echo html_escape($member['email']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label form-control-label">Subject / Topic</label>
                                <select name="subject" class="form-select border px-2 py-2">
                                    <option value="">Select a topic</option>
                                    <option value="Document Issue">Document Issue (ID Card / Certificate)</option>
                                    <option value="Donation Issue">Donation / Payment Issue</option>
                                    <option value="Profile Update">Profile Update Request</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label form-control-label">Your Message</label>
                                <div class="input-group input-group-outline">
                                    <textarea name="message" class="form-control" rows="5" placeholder="Describe your issue or question in detail..."></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn bg-gradient-primary rounded-pill px-5">
                                    <i class="material-symbols-rounded text-sm align-middle me-1">send</i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:15px;">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="font-weight-bolder mb-0">Frequently Asked Questions</h6>
                </div>
                <div class="card-body p-4">
                    <div class="accordion" id="faqAccordion">
                        <?php
                        $faqs = [
                            ['How do I download my ID Card?', 'Go to <b>My Documents → ID Card</b> from the sidebar and click "Download PDF". Your card includes a QR code for verification.'],
                            ['How do I change my password?', 'Go to <b>My Profile → Security & KYC</b> tab. Enter your new password, confirm it, and click "Save Security Settings".'],
                            ['My donation receipt is missing. What do I do?', 'Go to <b>Donations → My Activity</b>. If the status shows "paid", your receipt PDF will be available there. Otherwise, contact us.'],
                            ['How do I update my profile photo?', 'Go to <b>My Profile → Edit Info</b> tab. Click the camera icon on your avatar and select a new photo.'],
                        ];
                        foreach ($faqs as $i => $faq): ?>
                        <div class="accordion-item border-0 mb-2 rounded shadow-sm overflow-hidden">
                            <h2 class="accordion-header" id="faq<?php echo $i; ?>">
                                <button class="accordion-button collapsed bg-gray-100 text-dark font-weight-bold text-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?php echo $i; ?>">
                                    <?php echo $faq[0]; ?>
                                </button>
                            </h2>
                            <div id="faqCollapse<?php echo $i; ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-sm text-secondary">
                                    <?php echo $faq[1]; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.form-control-label { font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px; color: #7b809a; }
.accordion-button:not(.collapsed) { background: #ede9fe !important; color: #4f46e5 !important; box-shadow: none; }
</style>
