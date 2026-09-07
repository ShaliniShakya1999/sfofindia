<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <?php include 'topbar.php'; ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php include 'navbar.php'; ?>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Legal & Compliance</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Legal & Compliance</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_legal_html')): ?>

    <!-- Legal & Compliance Content Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="rounded-3 shadow-sm border-0 overflow-hidden mb-4 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%); border-left: 4px solid var(--bs-primary);">
                        <div class="p-4 p-md-5">
                            <p class="text-primary fw-semibold small text-uppercase mb-3" style="letter-spacing: 0.05em;"><i class="fas fa-balance-scale me-1"></i> Introduction</p>
                            <p class="text-dark mb-3 lh-lg" style="font-size: 1.05rem;">
                                <strong>SHAHEED FOUNDATION</strong> is a charitable, non-profit organisation incorporated as a <strong class="text-primary">Section 8 Company</strong> under the Companies Act, 2013, Government of India.
                            </p>
                            <p class="text-dark mb-0 lh-lg" style="font-size: 1.05rem;">
                                The Foundation operates strictly on a not-for-profit basis, and all income, donations, and resources are applied solely towards achieving its charitable objectives in accordance with applicable laws.
                            </p>
                        </div>
                    </div>

                    <div class="terms-body text-dark lh-lg">
                        <section class="mb-4 wow fadeIn" data-wow-delay="0.12s">
                            <h5 class="text-primary mb-2">Statutory Registrations & Approvals</h5>
                            <p class="text-muted mb-2">The Foundation holds the following statutory registrations and approvals under Indian law:</p>
                            <ul class="text-muted mb-2 ps-3">
                                <li>Section 8 Registration under the Companies Act, 2013</li>
                                <li>Provisional Registration under Section 12A of the Income Tax Act, 1961</li>
                                <li>Provisional Approval under Section 80G of the Income Tax Act, 1961</li>
                            </ul>
                            <p class="text-muted mb-0">Donations made to the Foundation are eligible for tax benefits under Section 80G, subject to the provisions, conditions, and validity period prescribed under applicable income tax laws.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.18s">
                            <h5 class="text-primary mb-2">Donation Transparency & Utilisation</h5>
                            <p class="text-muted mb-0">All donations received by the Foundation are utilised strictly for its charitable purposes, including but not limited to medical and healthcare assistance, education and scholarships, social welfare and community development, environmental initiatives, and other public welfare programs. Fund allocation may vary based on priority needs and program requirements.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.24s">
                            <h5 class="text-primary mb-2">Online Donations & Payment Security</h5>
                            <p class="text-muted mb-0">Online donations are processed through secure third-party payment gateways. The Foundation does not store or process any credit card, debit card, net banking, or UPI information. Transaction processing is governed by the terms and policies of the respective payment service providers.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.3s">
                            <h5 class="text-primary mb-2">Privacy & Data Protection</h5>
                            <p class="text-muted mb-0">The Foundation respects the privacy of its donors, supporters, and website visitors. Personal information is collected and used solely for lawful purposes such as donation processing, statutory compliance, record-keeping, and communication. Personal data is never sold or misused.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.36s">
                            <h5 class="text-primary mb-2">Donation Refund & Cancellation Policy</h5>
                            <p class="text-muted mb-0">Donations made to the Foundation are voluntary and generally non-refundable. Refunds may be considered only in exceptional cases such as duplicate donations or technical errors, subject to verification and internal approval.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.42s">
                            <h5 class="text-primary mb-2">Website Terms & Conditions</h5>
                            <p class="text-muted mb-0">By accessing and using this website, users agree to comply with the Terms & Conditions, Privacy Policy, and Refund Policy published on the website, as well as applicable laws of India.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.48s">
                            <h5 class="text-primary mb-2">Governing Law & Jurisdiction</h5>
                            <p class="text-muted mb-0">All matters relating to website usage, donations, and policies shall be governed by and interpreted in accordance with the laws of India. Courts of Gurgaon, Haryana shall have exclusive jurisdiction.</p>
                        </section>

                        <section class="mb-0 wow fadeIn" data-wow-delay="0.54s">
                            <h5 class="text-primary mb-2">Contact Information</h5>
                            <p class="text-muted mb-0">For any legal, compliance, or policy-related queries, please contact the Foundation at:<br>
                                <strong>Email:</strong> <a href="mailto:info@sfofindia.com" class="text-primary">info@sfofindia.com</a><br>
                                <strong>Location:</strong> Gurgaon, Haryana, India
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Legal & Compliance Content End -->

<?php endif; ?>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>