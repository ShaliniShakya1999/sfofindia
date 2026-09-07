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
            <h1 class="display-3 animated slideInDown">Terms & Conditions</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_terms_html')): ?>

    <!-- Terms Content Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="rounded-3 shadow-sm border-0 overflow-hidden mb-4 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%); border-left: 4px solid var(--bs-primary);">
                        <div class="p-4 p-md-5">
                            <p class="text-primary fw-semibold small text-uppercase mb-3" style="letter-spacing: 0.05em;"><i class="fas fa-info-circle me-1"></i> Introduction</p>
                            <p class="text-dark mb-3 lh-lg" style="font-size: 1.05rem;">
                                <strong class="text-primary">Terms & Conditions</strong> govern the access to and use of the website operated by <strong>SHAHEED FOUNDATION</strong> (“the Foundation”, “we”, “our”, or “us”).
                            </p>
                            <p class="text-dark mb-3 lh-lg" style="font-size: 1.05rem;">
                                SHAHEED FOUNDATION is a <strong>Section 8</strong> company registered under the Companies Act, 2013.
                            </p>
                            <p class="text-dark mb-0 lh-lg" style="font-size: 1.05rem;">
                                By accessing, browsing, or using this website, you acknowledge that you have read, understood, and agreed to be legally bound by these Terms & Conditions and all applicable laws of India.
                            </p>
                        </div>
                    </div>

                    <div class="terms-body text-dark lh-lg">
                        <section class="mb-4 wow fadeIn" data-wow-delay="0.15s">
                            <h5 class="text-primary mb-2">1. Legal Status & Scope</h5>
                            <p class="text-muted mb-0">SHAHEED FOUNDATION is incorporated as a non-profit organisation under Section 8 of the Companies Act, 2013. The website is intended to provide general information regarding the Foundation’s charitable activities, objectives, initiatives, and donation facilities. These Terms apply to all visitors, donors, users, and any other persons accessing the website.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.2s">
                            <h5 class="text-primary mb-2">2. Acceptance of Terms</h5>
                            <p class="text-muted mb-0">By accessing or using this website in any manner, including but not limited to viewing content, making donations, or submitting information, you expressly agree to comply with these Terms & Conditions. If you do not agree with any part of these Terms, you must discontinue use of the website immediately.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.25s">
                            <h5 class="text-primary mb-2">3. Permitted Use of Website</h5>
                            <p class="text-muted mb-0">You agree to use the website solely for lawful purposes and in a manner that does not infringe upon the rights of the Foundation or any third party. You shall not use the website to engage in unlawful, fraudulent, misleading, or harmful activities, or in any manner that could damage, disable, overburden, or impair the website or its functionality.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.3s">
                            <h5 class="text-primary mb-2">4. Prohibited Activities</h5>
                            <p class="text-muted mb-0">Users are strictly prohibited from attempting to gain unauthorised access to any portion of the website, servers, databases, or systems connected to the website. Any attempt to introduce malicious code, viruses, or conduct cyber-attacks, data scraping, or misuse of content shall result in immediate legal action under applicable laws.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.35s">
                            <h5 class="text-primary mb-2">5. Website Content & Accuracy</h5>
                            <p class="text-muted mb-0">All content available on this website is provided for informational purposes only. While we endeavour to keep information accurate and up to date, the Foundation does not make any warranties or representations regarding the completeness, reliability, or accuracy of the content. Any reliance placed on such information is strictly at the user’s own risk.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.4s">
                            <h5 class="text-primary mb-2">6. Intellectual Property Rights</h5>
                            <p class="text-muted mb-0">All content on this website, including text, graphics, logos, images, and design elements, is the property of SHAHEED FOUNDATION unless otherwise stated. Unauthorised copying, reproduction, distribution, or commercial use of any content without prior written consent is strictly prohibited and may result in legal action.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.45s">
                            <h5 class="text-primary mb-2">7. Donations & Voluntary Contributions</h5>
                            <p class="text-muted mb-0">All donations made through this website are voluntary. The Foundation does not guarantee any specific benefit, outcome, or service in exchange for donations. Donations are accepted to support the charitable objectives of the Foundation and are subject to the Donation Refund Policy as published on the website.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.5s">
                            <h5 class="text-primary mb-2">8. Payment Gateway Disclaimer</h5>
                            <p class="text-muted mb-0">Online donations are processed through third-party payment gateways. The Foundation does not store or process credit card, debit card, net banking, or UPI details. Any transaction failures, delays, or disputes arising from payment processing shall be governed by the terms of the respective payment service provider.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.55s">
                            <h5 class="text-primary mb-2">9. Limitation of Liability</h5>
                            <p class="text-muted mb-0">To the maximum extent permitted by law, the Foundation shall not be liable for any direct, indirect, incidental, consequential, or special damages arising out of or in connection with the use or inability to use the website, including but not limited to data loss, system failure, or unauthorised access.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.6s">
                            <h5 class="text-primary mb-2">10. External Links</h5>
                            <p class="text-muted mb-0">The website may contain links to third-party websites for convenience or reference. The Foundation does not control or endorse the content, policies, or practices of such websites and shall not be responsible for any loss or damage arising from their use.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.65s">
                            <h5 class="text-primary mb-2">11. Modification of Terms</h5>
                            <p class="text-muted mb-0">The Foundation reserves the right to modify, update, or revise these Terms & Conditions at any time without prior notice. Any changes shall become effective immediately upon being posted on the website. Continued use of the website constitutes acceptance of the revised Terms.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.7s">
                            <h5 class="text-primary mb-2">12. Termination of Access</h5>
                            <p class="text-muted mb-0">The Foundation reserves the right to restrict, suspend, or terminate access to the website for any user who violates these Terms or engages in activities that may harm the Foundation or its stakeholders, without prior notice.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.75s">
                            <h5 class="text-primary mb-2">13. Governing Law & Jurisdiction</h5>
                            <p class="text-muted mb-0">These Terms & Conditions shall be governed by and interpreted in accordance with the laws of India. Courts of Gurgaon, Haryana shall have exclusive jurisdiction over any disputes arising out of or in connection with the use of this website.</p>
                        </section>

                        <section class="mb-0 wow fadeIn" data-wow-delay="0.8s">
                            <h5 class="text-primary mb-2">14. Contact Information</h5>
                            <p class="text-muted mb-0">For any questions, clarifications, or concerns regarding these Terms & Conditions, you may contact us at:<br>
                                <strong>Email:</strong> <a href="mailto:info@sfofindia.com" class="text-primary">info@sfofindia.com</a><br>
                                <strong>Address:</strong> Gurgaon, Haryana, India
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Terms Content End -->

<?php endif; ?>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>