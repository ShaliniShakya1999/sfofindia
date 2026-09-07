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
            <h1 class="display-3 animated slideInDown">Privacy Policy</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_privacy_html')): ?>

    <!-- Privacy Policy Content Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="rounded-3 shadow-sm border-0 overflow-hidden mb-4 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%); border-left: 4px solid var(--bs-primary);">
                        <div class="p-4 p-md-5">
                            <p class="text-primary fw-semibold small text-uppercase mb-3" style="letter-spacing: 0.05em;"><i class="fas fa-info-circle me-1"></i> Introduction</p>
                            <p class="text-dark mb-3 lh-lg" style="font-size: 1.05rem;">
                                This <strong class="text-primary">Privacy Policy</strong> explains how <strong>SHAHEED FOUNDATION</strong> (“the Foundation”, “we”, “our”, or “us”) collects, uses, stores, processes, and protects personal information obtained from users, donors, volunteers, and visitors of our website.
                            </p>
                            <p class="text-dark mb-0 lh-lg" style="font-size: 1.05rem;">
                                SHAHEED FOUNDATION is a <strong>Section 8</strong> company registered under the Companies Act, 2013, and operates in accordance with applicable laws of India.
                            </p>
                        </div>
                    </div>

                    <div class="terms-body text-dark lh-lg">
                        <section class="mb-4 wow fadeIn" data-wow-delay="0.12s">
                            <h5 class="text-primary mb-2">1. Legal Status & Applicability</h5>
                            <p class="text-muted mb-0">This Privacy Policy applies to all visitors and users of our website and to all individuals who interact with the Foundation digitally or otherwise. By accessing or using our website, or by making a donation, you consent to the collection and use of information in accordance with this Privacy Policy and applicable laws.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.15s">
                            <h5 class="text-primary mb-2">2. Information We Collect</h5>
                            <p class="text-muted mb-0">We may collect personal information including, but not limited to: name, email address, mobile number, postal address, PAN details, donation amount, transaction reference numbers, and any other information voluntarily provided by donors or users. We may also collect non-personal information such as browser type, IP address, device information, and website usage data for analytical and security purposes.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.18s">
                            <h5 class="text-primary mb-2">3. Purpose of Data Collection</h5>
                            <p class="text-muted mb-0">Personal information is collected strictly for legitimate purposes such as donation processing, issuing receipts, statutory and regulatory compliance, maintaining accounting records, donor communication, responding to queries, and internal reporting. Data is never collected for any unlawful or commercial exploitation purpose.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.21s">
                            <h5 class="text-primary mb-2">4. Use of Payment Gateways</h5>
                            <p class="text-muted mb-0">All online donations are processed through secure third-party payment gateways. The Foundation does not store, process, or retain any credit card, debit card, net banking, or UPI details. Payment information is handled entirely by authorised payment service providers in compliance with applicable security standards and regulations.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.24s">
                            <h5 class="text-primary mb-2">5. Sharing and Disclosure of Information</h5>
                            <p class="text-muted mb-0">We do not sell, trade, or rent personal information to any third party. Information may be shared only with authorised service providers such as payment gateways, auditors, legal advisors, or government authorities where required under law, court orders, or regulatory obligations.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.27s">
                            <h5 class="text-primary mb-2">6. Data Retention</h5>
                            <p class="text-muted mb-0">Personal data is retained only for as long as necessary to fulfil the purposes for which it was collected or as required under applicable laws, including tax, accounting, and regulatory requirements. Once data is no longer required, it is securely deleted or anonymised.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.3s">
                            <h5 class="text-primary mb-2">7. Data Security Measures</h5>
                            <p class="text-muted mb-0">We implement reasonable administrative, technical, and organisational security measures to protect personal information against unauthorised access, alteration, disclosure, or destruction. However, no method of electronic transmission or storage is completely secure, and absolute security cannot be guaranteed.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.33s">
                            <h5 class="text-primary mb-2">8. User Rights</h5>
                            <p class="text-muted mb-0">Users have the right to request access, correction, update, or deletion of their personal information, subject to applicable legal and regulatory requirements. Requests may be denied where retention is required by law. All such requests should be submitted in writing.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.36s">
                            <h5 class="text-primary mb-2">9. Children’s Privacy</h5>
                            <p class="text-muted mb-0">The Foundation does not knowingly collect personal data from children below the age of 18 without parental or guardian consent. If such information is inadvertently collected, it will be deleted upon becoming aware of it.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.39s">
                            <h5 class="text-primary mb-2">10. External Links</h5>
                            <p class="text-muted mb-0">Our website may contain links to external websites. We are not responsible for the privacy practices, content, or policies of such third-party websites. Users are encouraged to review their respective privacy policies.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.42s">
                            <h5 class="text-primary mb-2">11. Changes to This Privacy Policy</h5>
                            <p class="text-muted mb-0">The Foundation reserves the right to amend or update this Privacy Policy at any time. Any changes will be posted on this page with a revised effective date. Continued use of the website after changes constitutes acceptance of the updated policy.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.45s">
                            <h5 class="text-primary mb-2">12. Governing Law</h5>
                            <p class="text-muted mb-0">This Privacy Policy shall be governed by and interpreted in accordance with the laws of India. Courts of Gurgaon, Haryana shall have exclusive jurisdiction.</p>
                        </section>

                        <section class="mb-0 wow fadeIn" data-wow-delay="0.48s">
                            <h5 class="text-primary mb-2">13. Contact Information</h5>
                            <p class="text-muted mb-0">For any questions, concerns, or requests relating to this Privacy Policy or personal data, please contact us at:<br>
                                <strong>Email:</strong> <a href="mailto:info@sfofindia.com" class="text-primary">info@sfofindia.com</a><br>
                                <strong>Address:</strong> Gurgaon, Haryana, India
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Privacy Policy Content End -->

<?php endif; ?>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>