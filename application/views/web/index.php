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
        /* --- Fix All Slider Images --- */
        .header-carousel .carousel-img img {
            width: 100% !important;
            height: 420px !important;
            /* Fixed height for all images */
            object-fit: cover !important;
            border-radius: 12px;
        }

        /* Mobile Responsive */
        @media (max-width: 767px) {
            .header-carousel .carousel-img img {
                height: 260px !important;
                border-radius: 10px;
            }
        }
    </style>
    <!-- Carousel Start -->
    <div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="owl-carousel header-carousel py-5">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-1 text-uppercase mb-3"><?php echo html_escape(cms_val($cms, 'slide1_title', 'Honoring Sacrifice. Supporting Families. Building Hope.')); ?></h1>
                            <p class="fs-5 mb-5"><?php echo nl2br(html_escape(cms_val($cms, 'slide1_text', 'At Shaheed Foundation of India, we stand beside the families of our martyrs, offering respect, support, and long-term assistance to help them live with dignity and security.'))); ?></p>
                            <div class="d-flex mt-4">
                                <a class="btn btn-primary py-3 px-4 me-3" href="<?php echo web_link('donation.php'); ?>"><?php echo html_escape(cms_val($cms, 'slide1_btn1', "Support a Martyr's Family")); ?></a>
                                <a class="btn btn-secondary py-3 px-4" href="<?php echo web_link('contact.php'); ?>"><?php echo html_escape(cms_val($cms, 'slide1_btn2', 'Join as a Volunteer')); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-img">
                            <img class="w-100" src="<?php echo html_escape(web_asset(cms_val($cms, 'slide1_img', 'img/soldier1.avif'))); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-1 text-uppercase mb-3"><?php echo html_escape(cms_val($cms, 'slide2_title', 'Standing Strong with the Families of Our Fallen Heroes')); ?></h1>
                            <p class="fs-5 mb-5"><?php echo nl2br(html_escape(cms_val($cms, 'slide2_text', 'Shaheed Foundation of India is committed to honoring the brave souls who laid down their lives for the nation by ensuring care, dignity, and a secure future for their families.'))); ?></p>
                            <div class="d-flex mt-4">
                                <a class="btn btn-primary py-3 px-4 me-3" href="<?php echo web_link('donation.php'); ?>"><?php echo html_escape(cms_val($cms, 'slide2_btn1', 'Support Disabled People')); ?></a>
                                <a class="btn btn-secondary py-3 px-4 me-3" href="<?php echo web_link('contact.php'); ?>"><?php echo html_escape(cms_val($cms, 'slide2_btn2', 'Become a Volunteer')); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-img">
                            <img class="w-100" src="<?php echo html_escape(web_asset(cms_val($cms, 'slide2_img', 'img/army2.jpg'))); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-1 text-uppercase mb-3"><?php echo html_escape(cms_val($cms, 'slide3_title', 'A Strong Support System for the Families of Our Martyrs')); ?></h1>
                            <p class="fs-5 mb-5"><?php echo nl2br(html_escape(cms_val($cms, 'slide3_text', 'Shaheed Foundation of India is dedicated to honoring the supreme sacrifice of our brave martyrs by supporting their families with dignity, care, and long-term security.'))); ?></p>
                            <div class="d-flex">
                                <a class="btn btn-primary py-3 px-4 me-3" href="<?php echo web_link('donation.php'); ?>"><?php echo html_escape(cms_val($cms, 'slide3_btn1', 'Donate Now')); ?></a>
                                <a class="btn btn-secondary py-3 px-4 me-3" href="<?php echo web_link('contact.php'); ?>"><?php echo html_escape(cms_val($cms, 'slide3_btn2', 'Join as a Volunteer')); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-img">
                            <img class="w-100" src="<?php echo html_escape(web_asset(cms_val($cms, 'slide3_img', 'img/Army.jpg'))); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Carousel End -->





    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">

                <!-- Image Section -->
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.2s">
                    <div class="about-img">
                        <img class="img-fluid w-100" src="<?php echo html_escape(web_asset(cms_val($cms, 'about_image', 'img/images.jpg'))); ?>" alt="<?php echo html_escape(cms_val($cms, 'site_name', 'Shaheed Foundation India')); ?>">
                    </div>
                </div>

                <!-- Content Section -->
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-primary pe-3">
                        <?php echo html_escape(cms_val($cms, 'about_label', 'About Shaheed Foundation of India')); ?>
                    </p>

                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">
                        <?php echo html_escape(cms_val($cms, 'about_heading', 'Standing With Those Who Gave Everything')); ?>
                    </h1>

                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">
                        <?php echo nl2br(html_escape(cms_val($cms, 'about_p1', "Shaheed Foundation of India is a non-profit organization dedicated to supporting the families of brave martyrs who sacrificed their lives for the nation. Our mission is to ensure that no martyr's family ever feels alone, forgotten, or helpless."))); ?>
                    </p>

                    <div class="row g-4 pt-2">

                        <!-- What We Do -->
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                            <div class="h-100">
                                <h3 class="mb-3">What We Do</h3>

                                <p class="text-dark">
                                    <i class="fa fa-check text-primary me-2"></i>
                                    <?php echo html_escape(cms_val($cms, 'what_we_do_1', "Financial assistance for martyrs' families")); ?>
                                </p>

                                <p class="text-dark">
                                    <i class="fa fa-check text-primary me-2"></i>
                                    <?php echo html_escape(cms_val($cms, 'what_we_do_2', 'Education and healthcare support')); ?>
                                </p>

                                <p class="text-dark">
                                    <i class="fa fa-check text-primary me-2"></i>
                                    <?php echo html_escape(cms_val($cms, 'what_we_do_3', 'Employment and skill development programs')); ?>
                                </p>

                                <p class="text-dark mb-0">
                                    <i class="fa fa-check text-primary me-2"></i>
                                    <?php echo html_escape(cms_val($cms, 'what_we_do_4', 'Emergency relief and crisis support')); ?>
                                </p>

                                <p class="mt-3 fst-italic">
                                    “<?php echo html_escape(cms_val($cms, 'about_quote', 'A nation that honors its martyrs must stand with their families.')); ?>”
                                </p>
                            </div>
                        </div>

                        <!-- Donation Box -->
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="h-100 bg-primary p-4 text-center rounded">
                                <p class="fs-5 text-white">
                                    <?php echo html_escape(cms_val($cms, 'donation_box_text', 'Your contribution helps us provide dignity, care, and hope to the families of our martyrs.')); ?>
                                </p>
                                <a class="btn btn-secondary py-2 px-4" href="<?php echo web_link('donation.php'); ?>">
                                    Donate Now
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- About End -->



    <!-- Service Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">

                <!-- Title Section -->
                <div class="col-md-12 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="service-title">
                        <h1 class="display-6 mb-4">
                            How We Support Martyrs’ Families
                        </h1>
                        <p class="fs-5 mb-0">
                            We stand beside the families of our brave martyrs by providing financial, educational,
                            medical, and emotional support to help them live with dignity and security.
                        </p>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-md-12 col-lg-8 col-xl-9">
                    <div class="row g-5">

                        <!-- Financial Support -->
                        <div class="col-sm-6 col-md-6 wow fadeIn" data-wow-delay="0.1s">
                            <div class="service-item h-100">
                                <div class="btn-square bg-light mb-4">
                                    <i class="fa-solid fa-hand-holding-heart fa-2x text-secondary"></i>
                                </div>
                                <h3>Financial Assistance</h3>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>Monthly family support</p>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>Emergency financial aid</p>
                                <p class="text-dark mb-0"><i class="fa fa-check text-primary me-2"></i>Household & ration support</p>
                                <a href="<?php echo web_link('financial.php'); ?>">Read More</a>
                            </div>
                        </div>

                        <!-- Education Support -->
                        <div class="col-sm-6 col-md-6 wow fadeIn" data-wow-delay="0.3s">
                            <div class="service-item h-100">
                                <div class="btn-square bg-light mb-4">
                                    <i class="fa-solid fa-graduation-cap fa-2x text-secondary"></i>
                                </div>
                                <h3>Children’s Education Support</h3>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>School & college fees</p>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>Books, uniforms & supplies</p>
                                <p class="text-dark mb-0"><i class="fa fa-check text-primary me-2"></i>Scholarships & tuition help</p>
                                <a href="<?php echo web_link('education.php'); ?>">Read More</a>
                            </div>
                        </div>

                        <!-- Medical Support -->
                        <div class="col-sm-6 col-md-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="service-item h-100">
                                <div class="btn-square bg-light mb-4">
                                    <i class="fa-solid fa-notes-medical fa-2x text-secondary"></i>
                                </div>
                                <h3>Medical & Health Care</h3>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>Medical treatment support</p>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>Hospital & medicine expenses</p>
                                <p class="text-dark mb-0"><i class="fa fa-check text-primary me-2"></i>Mental & emotional care</p>
                                <a href="<?php echo web_link('disability.php'); ?>">Read More</a>
                            </div>
                        </div>

                        <!-- Employment & Skill Support -->
                        <div class="col-sm-6 col-md-6 wow fadeIn" data-wow-delay="0.7s">
                            <div class="service-item h-100">
                                <div class="btn-square bg-light mb-4">
                                    <i class="fa-solid fa-briefcase fa-2x text-secondary"></i>
                                </div>
                                <h3>Employment & Skill Development</h3>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>Job assistance for family members</p>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>Skill training programs</p>
                                <p class="text-dark mb-0"><i class="fa fa-check text-primary me-2"></i>Self-employment support</p>
                                <a href="<?php echo web_link('employment.php'); ?>">Read More</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Service End -->



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



    <!-- Donation Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="section-title bg-white text-center text-primary px-3">Donation</p>
                <h1 class="display-6 mb-3">Your Contribution Brings Hope to Martyrs’ Families</h1>
                <p class="text-muted">
                    Every donation helps us support the families of our brave martyrs with dignity, care, and long-term security.
                </p>
            </div>

            <div class="row g-4 mt-4">

                <!-- Donation Box 1 -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">₹8,00,000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="85"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">85%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>₹10,00,000</span>
                        </div>

                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="<?php echo html_escape(web_asset('img/army2.jpg')); ?>" alt="Martyrs Family Support">
                                <a href="#!" class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">
                                    Family Support
                                </a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Support for Martyrs’ Families</a>
                            <p>
                                Your donation provides monthly ration kits, household essentials, and financial assistance
                                to the families of our brave martyrs, ensuring they are never left alone.
                            </p>
                            <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-primary w-100 py-3">
                                <i class="fa fa-plus me-2"></i>Donate Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Donation Box 2 -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.13s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">₹5,20,000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="95"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">95%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>₹6,00,000</span>
                        </div>

                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="<?php echo html_escape(web_asset('img/sf/15.jpeg')); ?>" alt="Medical Support">
                                <a href="#!" class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">
                                    Medical Care
                                </a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Medical & Health Assistance</a>
                            <p>
                                We provide medical treatment, emergency care, medicines, and hospital support to martyrs’
                                families who need immediate and long-term healthcare assistance.
                            </p>
                            <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-primary w-100 py-3">
                                <i class="fa fa-plus me-2"></i>Donate Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Donation Box 3 -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">₹3,75,000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">75%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>₹5,00,000</span>
                        </div>

                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="<?php echo html_escape(web_asset('img/education-child.webp')); ?>" alt="Education Support">
                                <a href="#!" class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">
                                    Education
                                </a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Education for Martyrs’ Children</a>
                            <p>
                                Your support helps provide school fees, books, uniforms, and quality education to the children
                                of martyrs, helping them build a strong and dignified future.
                            </p>
                            <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-primary w-100 py-3">
                                <i class="fa fa-plus me-2"></i>Donate Now
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Emotional Line -->
            <div class="text-center mt-5">
                <h4 class="text-primary">
                    “A nation that honors its martyrs must also stand with their families.”
                </h4>
            </div>
        </div>
    </div>


    <!-- Donation End -->


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


    <!-- Event Start -->
    <div class="container-fluid py-5">
        <div class="container">

            <!-- Section Heading -->
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 520px;">
                <p class="section-title bg-white text-center text-primary px-3">Our Events</p>
                <h1 class="display-6 mb-4">Programs Dedicated to Honoring Our Martyrs</h1>
                <p class="text-muted">
                    Through remembrance, support, and action, we stand with the families of our brave heroes.
                </p>
            </div>

            <div class="row g-4">

                <!-- Event 1 -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" src="<?php echo html_escape(web_asset('img/puduchery.jpg')); ?>" alt="Martyrs Education Support">
                        <a href="#!" class="h3 d-inline-block">Education Support Drive</a>
                        <p>
                            This program ensures quality education for the children of martyrs by providing
                            school fees, books, uniforms, and academic support—helping them build a secure future
                            with dignity.
                        </p>
                    </div>
                </div>

                <!-- Event 2 -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" src="<?php echo html_escape(web_asset('img/TNIE.avif')); ?>" alt="Martyrs Remembrance Program">
                        <a href="#!" class="h3 d-inline-block">Martyrs Remembrance & Awareness Program</a>
                        <p>
                            Through remembrance ceremonies and awareness campaigns, we honor the supreme sacrifice
                            of our martyrs and remind the nation of its responsibility toward their families.
                        </p>
                    </div>
                </div>

                <!-- Event 3 -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" style="height: 225px;" src="<?php echo html_escape(web_asset('img/sf/16.jpeg')); ?>" alt="Health Care Support for Martyrs Families">
                        <a href="#!" class="h3 d-inline-block">Medical & Health Care Camp</a>
                        <p>
                            We organize medical camps and provide healthcare assistance to martyrs’ families,
                            ensuring access to treatment, medicines, and emergency health support when they need it most.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Event End -->


    <!-- Donate Start -->
    <div class="container-fluid donate py-5">
        <div class="container">
            <div class="row g-0">

                <!-- Left Content Section -->
                <div class="col-lg-7 donate-text bg-light py-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex flex-column justify-content-center h-100 p-5 wow fadeIn" data-wow-delay="0.3s">
                        <h1 class="display-6 mb-4">
                            Stand with the Families of Our Fallen Heroes
                        </h1>
                        <p class="fs-5 mb-3">
                            When a soldier lays down their life for the nation, their family carries the pain forever.
                            It is our collective responsibility to ensure they never feel alone.
                        </p>
                        <p class="fs-5 mb-0">
                            Your donation helps provide education for children, medical care for families,
                            monthly essentials, and long-term financial support to the families of our brave martyrs.
                        </p>
                    </div>
                </div>

                <!-- Right Donation Form -->
                <div class="col-lg-5 donate-form bg-primary py-5 text-center wow fadeIn" data-wow-delay="0.5s">
                    <div class="h-100 p-5">
                        <h3 class="text-white mb-4">
                            Make a Meaningful Contribution
                        </h3>

                        <form>
                            <div class="row g-3">

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name">
                                        <label for="name">Full Name</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Your Email">
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>

                                <!-- Donation Amount -->
                                <div class="col-12">
                                    <p class="text-white mb-2">Choose Donation Amount</p>
                                    <div class="btn-group flex-wrap" role="group">

                                        <input type="radio" class="btn-check" name="donation" id="donate1" checked>
                                        <label class="btn btn-light m-1" for="donate1">₹500</label>

                                        <input type="radio" class="btn-check" name="donation" id="donate2">
                                        <label class="btn btn-light m-1" for="donate2">₹1,000</label>

                                        <input type="radio" class="btn-check" name="donation" id="donate3">
                                        <label class="btn btn-light m-1" for="donate3">₹2,000</label>

                                        <input type="radio" class="btn-check" name="donation" id="donate4">
                                        <label class="btn btn-light m-1" for="donate4">₹5,000</label>

                                        <input type="radio" class="btn-check" name="donation" id="donate5">
                                        <label class="btn btn-light m-1" for="donate5">Custom Amount</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-secondary py-3 w-100" type="submit">
                                        Donate with Respect
                                    </button>
                                </div>

                                <div class="col-12">
                                    <p class="text-white small mt-3">
                                        100% transparency • Secure payment • Direct support to martyrs’ families
                                    </p>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Donate End -->


    <!-- Team Start -->
    <!-- <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Our Team</p>
                <h1 class="display-6 mb-4">Meet Our Dedicated Team Members</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="<?php echo html_escape(web_asset('img/team-1.jpg')); ?>" alt="">
                            <h3>Boris Johnson</h3>
                            <span>Founder & CEO</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="<?php echo html_escape(web_asset('img/team-2.jpg')); ?>" alt="">
                            <h3>Donald Pakura</h3>
                            <span>Project Manager</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="<?php echo html_escape(web_asset('img/team-3.jpg')); ?>" alt="">
                            <h3>Alexander Bell</h3>
                            <span>Volunteer</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Team End -->


    <!-- Testimonial Start -->
    <!-- <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-12 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="testimonial-title">
                        <h1 class="display-6 mb-4">What People Say About Our Activities.</h1>
                        <p class="fs-5 mb-0">We work to bring smiles, hope, and a brighter future to those in need.</p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8 col-xl-9">
                    <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="<?php echo html_escape(web_asset('img/testimonial-1.jpg')); ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <div class="mb-2">
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                        </div>
                                        <p class="fs-5">Education is the foundation of change. By funding schools,
                                            scholarships, and training programs, we can help children and adults unlock
                                            their potential for a better future.</p>
                                        <div class="d-flex align-items-center">
                                            <div class="btn-lg-square bg-light text-secondary flex-shrink-0">
                                                <i class="fa fa-quote-right fa-2x"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0">Alexander Bell</h5>
                                                <span>CEO, Founder</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="<?php echo html_escape(web_asset('img/testimonial-2.jpg')); ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <div class="mb-2">
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                        </div>
                                        <p class="fs-5">Every hand extended in kindness brings us closer to a world free
                                            from suffering. Be part of a global movement dedicated to building a future
                                            where equality and compassion thrive.</p>
                                        <div class="d-flex align-items-center">
                                            <div class="btn-lg-square bg-light text-secondary flex-shrink-0">
                                                <i class="fa fa-quote-right fa-2x"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0">Donald Pakura</h5>
                                                <span>CEO, Founder</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="<?php echo html_escape(web_asset('img/testimonial-3.jpg')); ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <div class="mb-2">
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                        </div>
                                        <p class="fs-5">Love and compassion have the power to heal. Through your
                                            donations and volunteer work, we can spread kindness and support to
                                            children, families, and communities struggling to find stability.</p>
                                        <div class="d-flex align-items-center">
                                            <div class="btn-lg-square bg-light text-secondary flex-shrink-0">
                                                <i class="fa fa-quote-right fa-2x"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0">Boris Johnson</h5>
                                                <span>CEO, Founder</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Testimonial End -->

    <?php include 'footer.php'; ?>

</body>

</html>