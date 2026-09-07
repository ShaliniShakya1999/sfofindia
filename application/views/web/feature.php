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
            <h1 class="display-3 animated slideInDown">Feature</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
               
                    <li class="breadcrumb-item active" aria-current="page">Feature</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_feature_html')): ?>


    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">

                <!-- Stats Section -->
                <div class="col-lg-6">
                    <div class="rounded overflow-hidden">
                        <div class="row g-0">

                            <!-- Martyr Families Supported -->
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="text-center bg-primary py-5 px-4 h-100">
                                    <i class="fa-solid fa-people-group fa-3x text-secondary mb-3"></i>
                                    <h1 class="display-5 mb-0" data-toggle="counter-up">40</h1>
                                    <span class="text-dark">Martyrs’ Families Supported</span>
                                </div>
                            </div>

                            <!-- Children of Martyrs Educated -->
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa-solid fa-child-reaching fa-3x text-primary mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">120</h1>
                                    <span class="text-white">Martyrs’ Children Educated</span>
                                </div>
                            </div>

                            <!-- Financial Assistance Cases -->
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa-solid fa-hand-holding-dollar fa-3x text-primary mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">85</h1>
                                    <span class="text-white">Families Given Financial Support</span>
                                </div>
                            </div>

                            <!-- Welfare & Relief Programs -->
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="text-center bg-primary py-5 px-4 h-100">
                                    <i class="fa-solid fa-handshake-angle fa-3x text-secondary mb-3"></i>
                                    <h1 class="display-5 mb-0" data-toggle="counter-up">300</h1>
                                    <span class="text-dark">Relief & Welfare Interventions</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Content Section -->
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-primary pe-3">
                        Why Support Shaheed Families
                    </p>

                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">
                        Because Their Sacrifice Deserves Our Support
                    </h1>

                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">
                        While we sleep safely in our homes, a soldier stands guard at the borders of our nation.
                        When a family loses a son, husband, or father in the service of the country, it becomes our
                        collective responsibility to stand by them with compassion, respect, and support.
                    </p>

                    <blockquote class="fst-italic text-dark wow fadeIn" data-wow-delay="0.4s">
                        “The sacrifice of our martyrs is eternal; their families are our responsibility.” 🇮🇳
                    </blockquote>

                    <p class="text-dark wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-check text-primary me-2"></i>
                        Transparent and trusted non-profit initiatives
                    </p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.6s">
                        <i class="fa fa-check text-primary me-2"></i>
                        Direct financial and emotional support to martyrs’ families
                    </p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.7s">
                        <i class="fa fa-check text-primary me-2"></i>
                        Education and care for children of martyrs
                    </p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.8s">
                        <i class="fa fa-check text-primary me-2"></i>
                        Long-term rehabilitation and community support
                    </p>

                    <div class="d-flex mt-4 wow fadeIn" data-wow-delay="0.9s">
                        <a class="btn btn-primary py-3 px-4 me-3" href="<?php echo web_link('donation.php'); ?>">
                            Donate Now
                        </a>
                        <a class="btn btn-secondary py-3 px-4" href="#!">
                            Join Us Now
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Features End -->


    <!-- Banner Start -->
  <div class="container-fluid banner py-5">
        <div class="container">
            <div class="banner-inner bg-light p-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="row justify-content-center">
                    <div class="col-lg-9 py-5 text-center">

                        <!-- Tagline -->
                        <p class="text-primary fw-semibold mb-2">
                            Shaheed Foundation of India
                        </p>

                        <!-- Main Heading -->
                        <h1 class="display-6 wow fadeIn mb-3" data-wow-delay="0.3s">
                            Honoring Sacrifice. Supporting Families. Building Hope.
                        </h1>

                        <!-- Subheading / Description -->
                        <p class="fs-5 mb-4 wow fadeIn text-muted" data-wow-delay="0.5s">
                            Shaheed Foundation of India stands beside the families of our brave martyrs,
                            ensuring dignity, care, education, medical support, and long-term security.
                            Your support helps us fulfill the nation’s responsibility towards those
                            who gave everything for our freedom.
                        </p>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-center wow fadeIn" data-wow-delay="0.7s">
                            <a class="btn btn-primary py-3 px-4 me-3" href="<?php echo web_link('donation.php'); ?>">
                                Donate Now
                            </a>
                            <a class="btn btn-secondary py-3 px-4" href="<?php echo web_link('contact.php'); ?>">
                                Join as a Volunteer
                            </a>
                        </div>

                        <!-- Emotional Line -->
                        <!-- <div class="mt-4">
                        <p class="fw-semibold text-dark">
                            “A nation that honors its martyrs must stand with their families.”
                        </p>
                    </div> -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner End -->

<?php endif; ?>

    <?php include 'footer.php'; ?>

</body>

</html>