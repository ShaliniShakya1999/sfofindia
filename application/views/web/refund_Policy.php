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
            <h1 class="display-3 animated slideInDown">Refund Policy</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Refund Policy</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_refund_html')): ?>

    <!-- Refund Policy Content Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="rounded-3 shadow-sm border-0 overflow-hidden mb-4 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%); border-left: 4px solid var(--bs-primary);">
                        <div class="p-4 p-md-5">
                            <p class="text-primary fw-semibold small text-uppercase mb-3" style="letter-spacing: 0.05em;"><i class="fas fa-info-circle me-1"></i> Introduction</p>
                            <p class="text-dark mb-3 lh-lg" style="font-size: 1.05rem;">
                                This <strong class="text-primary">Donation Refund & Cancellation Policy</strong> governs all donations made to <strong>SHAHEED FOUNDATION</strong> (“the Foundation”, “we”, “our”, or “us”). SHAHEED FOUNDATION is a Section 8 company registered under the Companies Act, 2013.
                            </p>
                            <p class="text-dark mb-0 lh-lg" style="font-size: 1.05rem;">
                                This policy is designed to ensure transparency, donor clarity, and compliance with applicable laws of India.
                            </p>
                        </div>
                    </div>

                    <div class="terms-body text-dark lh-lg">
                        <section class="mb-4 wow fadeIn" data-wow-delay="0.12s">
                            <h5 class="text-primary mb-2">1. Nature of Donations</h5>
                            <p class="text-muted mb-0">All donations made to the Foundation are voluntary in nature and are intended to support the charitable objects and activities of the Foundation. Donations are not made in exchange for any goods, services, benefits, or contractual obligations.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.15s">
                            <h5 class="text-primary mb-2">2. General No-Refund Policy</h5>
                            <p class="text-muted mb-0">As a general rule, donations once made are non-refundable. Donors are requested to carefully review all details, including the donation amount and payment information, before completing any transaction.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.18s">
                            <h5 class="text-primary mb-2">3. Exceptional Circumstances for Refund</h5>
                            <p class="text-muted mb-2">Refunds may be considered only under exceptional circumstances such as:</p>
                            <ul class="text-muted mb-0 ps-3">
                                <li>Duplicate or multiple donations made unintentionally for the same purpose;</li>
                                <li>Technical errors during payment processing resulting in excess debit;</li>
                                <li>Erroneous transaction caused by system malfunction.</li>
                            </ul>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.21s">
                            <h5 class="text-primary mb-2">4. Refund Request Process</h5>
                            <p class="text-muted mb-0">Any request for a refund must be made in writing within seven (7) days from the date of the donation transaction. The request must include transaction reference details, donor identification information, and the reason for the refund request. Requests submitted after this period may not be entertained.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.24s">
                            <h5 class="text-primary mb-2">5. Verification & Approval</h5>
                            <p class="text-muted mb-0">All refund requests shall be subject to internal verification and approval by the authorised personnel of the Foundation. The Foundation reserves the right to accept or reject any refund request at its sole discretion, based on verification results and compliance requirements.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.27s">
                            <h5 class="text-primary mb-2">6. Mode & Timeline of Refund</h5>
                            <p class="text-muted mb-0">Approved refunds shall be processed only through the original payment mode used for the donation. The processing time may vary depending on the payment gateway or banking partner and typically ranges from seven (7) to ten (10) working days.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.3s">
                            <h5 class="text-primary mb-2">7. Payment Gateway Charges</h5>
                            <p class="text-muted mb-0">Any payment gateway charges, bank fees, or transaction costs incurred at the time of donation are non-recoverable and may be deducted from the refunded amount, subject to applicable policies of the payment service provider.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.33s">
                            <h5 class="text-primary mb-2">8. Cancellation of Recurring Donations</h5>
                            <p class="text-muted mb-0">For recurring or subscription-based donations, donors may request cancellation of future donations by providing prior written notice. Donations already processed before cancellation shall remain non-refundable.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.36s">
                            <h5 class="text-primary mb-2">9. Tax Implications</h5>
                            <p class="text-muted mb-0">In the event of a refund of a donation for which a tax receipt has been issued, such receipt shall be deemed null and void. The donor shall not be entitled to claim any tax benefit in respect of the refunded amount under applicable income tax laws.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.39s">
                            <h5 class="text-primary mb-2">10. Misuse or Fraudulent Activity</h5>
                            <p class="text-muted mb-0">The Foundation reserves the right to refuse refunds where donations are suspected to be fraudulent, unlawful, or in violation of these policies or applicable laws, and may report such activities to relevant authorities.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.42s">
                            <h5 class="text-primary mb-2">11. Policy Amendments</h5>
                            <p class="text-muted mb-0">The Foundation reserves the right to amend or modify this Donation Refund & Cancellation Policy at any time without prior notice. Any changes shall be effective immediately upon publication on the website.</p>
                        </section>

                        <section class="mb-4 wow fadeIn" data-wow-delay="0.45s">
                            <h5 class="text-primary mb-2">12. Governing Law & Jurisdiction</h5>
                            <p class="text-muted mb-0">This Policy shall be governed by and interpreted in accordance with the laws of India. Courts of Gurgaon, Haryana shall have exclusive jurisdiction over any disputes arising in relation to this Policy.</p>
                        </section>

                        <section class="mb-0 wow fadeIn" data-wow-delay="0.48s">
                            <h5 class="text-primary mb-2">13. Contact Information</h5>
                            <p class="text-muted mb-0">For refund-related queries or requests, donors may contact the Foundation at:<br>
                                <strong>Email:</strong> <a href="mailto:info@sfofindia.com" class="text-primary">info@sfofindia.com</a><br>
                                <strong>Address:</strong> Gurgaon, Haryana, India
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Refund Policy Content End -->

<?php endif; ?>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>