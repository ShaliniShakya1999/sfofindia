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
    <style>
        .doc-card:hover { transform: translateY(-4px); box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important; }
        .doc-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .doc-img-wrap { border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: 0.3s; }
        .doc-img-wrap:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.12); transform: translateY(-2px); }
        .doc-img-wrap img { width: 100%; height: 200px; object-fit: cover; }
    </style>
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Our Documents</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Our Documents</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_documents_html')): ?>

    <!-- Documents Content Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 640px;">
                <p class="section-title bg-white text-center text-primary px-3">Transparency</p>
                <h2 class="display-6 mb-3">Official Documents & Certificates</h2>
                <p class="text-muted mb-0">
                    SHAHEED FOUNDATION is a registered Section 8 company. Below are our key registration documents, licences, and approvals for your reference.
                </p>
            </div>

            <!-- PAN Card / Identity -->
            <div class="row mb-5">
                <div class="col-md-6 col-lg-4 mx-auto wow fadeIn" data-wow-delay="0.1s">
                    <div class="doc-img-wrap">
                        <a href="<?php echo html_escape(web_asset('img/sf/PAN CARD.jpeg')); ?>" target="_blank" class="d-block">
                            <img src="<?php echo html_escape(web_asset('img/sf/PAN CARD.jpeg')); ?>" alt="SHAHEED FOUNDATION PAN Card">
                            <div class="bg-light text-center py-2 border-top">
                                <span class="text-primary small fw-medium"><i class="fas fa-external-link-alt me-1"></i> PAN Card</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Document cards grid -->
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <a href="<?php echo html_escape(web_asset('img/sf/NGO Darpan.pdf')); ?>" target="_blank" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden doc-card">
                            <div class="card-body d-flex align-items-center p-4">
                                <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center rounded-circle border border-2 border-primary bg-white" style="width:56px; height:56px;">
                                    <i class="fas fa-file-pdf fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title text-dark mb-1">NGO Darpan Registration</h5>
                                    <p class="card-text text-muted small mb-0">NITI Aayog NGO Darpan – voluntary sector registration</p>
                                </div>
                                <i class="fas fa-download text-primary flex-shrink-0"></i>
                            </div>
                            <div class="card-footer bg-light border-0 py-2 text-center">
                                <span class="text-primary small fw-medium">Open / Download PDF</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.15s">
                    <a href="<?php echo html_escape(web_asset('img/sf/s 8 to new company.pdf')); ?>" target="_blank" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden doc-card">
                            <div class="card-body d-flex align-items-center p-4">
                                <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center rounded-circle border border-2 border-primary bg-white" style="width:56px; height:56px;">
                                    <i class="fas fa-file-pdf fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title text-dark mb-1">Section 8 Company Licence</h5>
                                    <p class="card-text text-muted small mb-0">Licence under Section 8(1) of the Companies Act, 2013</p>
                                </div>
                                <i class="fas fa-download text-primary flex-shrink-0"></i>
                            </div>
                            <div class="card-footer bg-light border-0 py-2 text-center">
                                <span class="text-primary small fw-medium">Open / Download PDF</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.2s">
                    <a href="<?php echo html_escape(web_asset('img/sf/CERTIFICATE OF INCORPORATION')); ?>" target="_blank" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden doc-card">
                            <div class="card-body d-flex align-items-center p-4">
                                <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center rounded-circle border border-2 border-primary bg-white" style="width:56px; height:56px;">
                                    <i class="fas fa-file-pdf fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title text-dark mb-1">Certificate of Incorporation</h5>
                                    <p class="card-text text-muted small mb-0">Registrar of Companies – company incorporation certificate</p>
                                </div>
                                <i class="fas fa-download text-primary flex-shrink-0"></i>
                            </div>
                            <div class="card-footer bg-light border-0 py-2 text-center">
                                <span class="text-primary small fw-medium">Open / Download PDF</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.25s">
                    <a href="<?php echo html_escape(web_asset('img/sf/AAXCS2334MF20241_signed.pdf')); ?>" target="_blank" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden doc-card">
                            <div class="card-body d-flex align-items-center p-4">
                                <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center rounded-circle border border-2 border-primary bg-white" style="width:56px; height:56px;">
                                    <i class="fas fa-file-pdf fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title text-dark mb-1">12A Provisional Approval</h5>
                                    <p class="card-text text-muted small mb-0">Income Tax 12A – provisional approval for tax exemption on donations</p>
                                </div>
                                <i class="fas fa-download text-primary flex-shrink-0"></i>
                            </div>
                            <div class="card-footer bg-light border-0 py-2 text-center">
                                <span class="text-primary small fw-medium">Open / Download PDF</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <a href="<?php echo html_escape(web_asset('img/sf/AAXCS2334ME20241_signed.pdf')); ?>" target="_blank" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden doc-card">
                            <div class="card-body d-flex align-items-center p-4">
                                <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center rounded-circle border border-2 border-primary bg-white" style="width:56px; height:56px;">
                                    <i class="fas fa-file-pdf fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title text-dark mb-1">80G Order (Signed)</h5>
                                    <p class="card-text text-muted small mb-0">Income Tax 80G – signed order for donation tax exemption</p>
                                </div>
                                <i class="fas fa-download text-primary flex-shrink-0"></i>
                            </div>
                            <div class="card-footer bg-light border-0 py-2 text-center">
                                <span class="text-primary small fw-medium">Open / Download PDF</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Documents Content End -->

<?php endif; ?>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>