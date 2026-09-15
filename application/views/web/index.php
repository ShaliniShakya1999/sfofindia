<!DOCTYPE html>
<html lang="en">

<?php 
include 'head.php'; 
$razorpay_enabled = false;
if (file_exists(__DIR__ . '/razorpay_config.php')) {
    include_once __DIR__ . '/razorpay_config.php';
    $razorpay_enabled = defined('RAZORPAY_KEY_ID') && RAZORPAY_KEY_ID !== '' && RAZORPAY_KEY_ID !== 'rzp_test_xxxxxxxx' && defined('RAZORPAY_KEY_SECRET') && RAZORPAY_KEY_SECRET !== '';
}
if (!$razorpay_enabled && !empty($cms['razorpay_key_id']) && $cms['razorpay_key_id'] !== 'rzp_test_xxxxxxxx') {
    $razorpay_enabled = true;
    if (!defined('RAZORPAY_KEY_ID')) define('RAZORPAY_KEY_ID', $cms['razorpay_key_id']);
}
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

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



    <style>
        .home-donation-cards .donation-item {
            align-items: stretch;
            min-height: 402px;
        }
        .home-donation-cards .donation-progress {
            flex: 0 0 64px;
            width: 64px;
            min-height: 354px;
        }
        .home-donation-cards .donation-detail {
            min-width: 0;
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
        }
        .home-donation-cards .donation-detail .position-relative {
            flex: 0 0 100px;
            margin-bottom: 1rem !important;
        }
        .home-donation-cards .donation-detail .position-relative img {
            display: block;
            height: 100px;
            object-fit: cover;
        }
        .home-donation-cards .donation-detail > .h3 {
            line-height: 1.2;
            min-height: 58px;
            margin-bottom: .6rem;
        }
        .home-donation-cards .donation-detail > p {
            flex: 1 1 auto;
        }
        .home-donation-cards .donation-detail > .btn {
            margin-top: auto;
        }
        @media (max-width: 767.98px) {
            .home-donation-cards .donation-item {
                min-height: 0;
            }
        }
    </style>
    <!-- Donation Start -->
    <div class="container-fluid py-5 home-donation-cards">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="section-title bg-white text-center text-primary px-3">Donation</p>
                <h1 class="display-6 mb-3">Your Contribution Brings Hope to Martyrs’ Families</h1>
                <p class="text-muted">
                    Every donation helps us support the families of our brave martyrs with dignity, care, and long-term security.
                </p>
            </div>

            <?php 
            $campaign_list = !empty($campaigns) ? $campaigns : array(
                array(
                    'id' => 2,
                    'title' => "Support for Martyrs' Families",
                    'description' => "Your donation provides monthly ration kits, household essentials, and financial assistance to the families of our brave martyrs, ensuring they are never left alone.",
                    'goal_amount' => 1000000,
                    'raised_amount' => 0,
                    'raised_display' => '0',
                    'image' => 'img/army2.jpg',
                ),
                array(
                    'id' => 3,
                    'title' => "Medical & Health Assistance",
                    'description' => "We provide medical treatment, emergency care, medicines, and hospital support to martyrs' families who need immediate and long-term healthcare assistance.",
                    'goal_amount' => 600000,
                    'raised_amount' => 0,
                    'raised_display' => '0',
                    'image' => 'img/sf/15.jpeg',
                ),
                array(
                    'id' => 1,
                    'title' => "Education for Martyrs' Children",
                    'description' => "Your support helps provide school fees, books, uniforms, and quality education to the children of martyrs, helping them build a strong and dignified future.",
                    'goal_amount' => 500000,
                    'raised_amount' => 0,
                    'raised_display' => '0',
                    'image' => 'img/education-child.webp',
                ),
            );
            ?>
            <div class="row g-4 mt-4">
                <?php foreach ($campaign_list as $idx => $camp): 
                    $c_id = (int)($camp['id'] ?? 0);
                    $c_title = (string)($camp['title'] ?? 'Campaign');
                    $c_desc = (string)($camp['description'] ?? '');
                    if (mb_strlen($c_desc) > 150) {
                        $c_desc = mb_substr($c_desc, 0, 147) . '...';
                    }
                    $c_goal = (float)($camp['goal_amount'] ?? 0);
                    $c_raised = (float)($camp['raised_amount'] ?? 0);
                    if ($c_raised <= 0 && !empty($camp['raised_display']) && is_numeric($camp['raised_display'])) {
                        $c_raised = (float)$camp['raised_display'];
                    }
                    $c_percent = ($c_goal > 0) ? min(100, round(($c_raised / $c_goal) * 100)) : 0;
                    
                    $c_img_raw = trim((string)($camp['image'] ?? ''));
                    if ($c_img_raw !== '') {
                        if (preg_match('#^https?://#i', $c_img_raw)) {
                            $c_img = $c_img_raw;
                        } elseif (strpos($c_img_raw, 'img/') === 0) {
                            $c_img = web_asset($c_img_raw);
                        } elseif (file_exists(FCPATH . $c_img_raw)) {
                            $c_img = base_url($c_img_raw);
                        } else {
                            $c_img = web_asset('img/army2.jpg');
                        }
                    } else {
                        $c_img = web_asset('img/army2.jpg');
                    }

                    $c_tag = 'Family Support';
                    $t_lower = strtolower($c_title);
                    if (strpos($t_lower, 'education') !== false || strpos($t_lower, 'child') !== false) {
                        $c_tag = 'Education';
                    } elseif (strpos($t_lower, 'medic') !== false || strpos($t_lower, 'health') !== false) {
                        $c_tag = 'Medical Care';
                    } elseif (strpos($t_lower, 'relief') !== false || strpos($t_lower, 'emergency') !== false) {
                        $c_tag = 'Emergency Relief';
                    }
                    
                    $donate_url = web_link('donation.php') . ($c_id > 0 ? ('?campaign_id=' . $c_id . '#donate-section') : '#donate-section');
                    $delay = number_format(0.1 + ($idx * 0.1), 2);
                ?>
                <!-- Dynamic Campaign Box <?php echo $c_id; ?> -->
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="<?php echo $delay; ?>s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">₹<?php echo number_format($c_raised); ?></span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="<?php echo $c_percent; ?>"
                                    aria-valuemin="0" aria-valuemax="100" style="height: <?php echo max(5, $c_percent); ?>%;">
                                    <span class="fs-4"><?php echo $c_percent; ?>%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>₹<?php echo number_format($c_goal); ?></span>
                        </div>

                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="<?php echo html_escape($c_img); ?>" alt="<?php echo html_escape($c_title); ?>">
                                <a href="<?php echo $donate_url; ?>" class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">
                                    <?php echo html_escape($c_tag); ?>
                                </a>
                            </div>
                            <a href="<?php echo $donate_url; ?>" class="h3 d-inline-block"><?php echo html_escape($c_title); ?></a>
                            <p>
                                <?php echo html_escape($c_desc); ?>
                            </p>
                            <a href="<?php echo $donate_url; ?>" class="btn btn-primary w-100 py-3">
                                <i class="fa fa-heart me-2"></i>Donate Now
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
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
                <?php
                $fallback_events = array(
                    array(
                        'title' => 'Education Support Drive',
                        'image' => 'img/puduchery.jpg',
                        'body' => 'This program ensures quality education for the children of martyrs by providing school fees, books, uniforms, and academic support—helping them build a secure future with dignity.',
                        'event_date' => '2026-10-15',
                    ),
                    array(
                        'title' => 'Martyrs Remembrance & Awareness Program',
                        'image' => 'img/TNIE.avif',
                        'body' => 'Through remembrance ceremonies and awareness campaigns, we honor the supreme sacrifice of our martyrs and remind the nation of its responsibility toward their families.',
                        'event_date' => '2026-11-20',
                    ),
                    array(
                        'title' => 'Medical & Health Care Camp',
                        'image' => 'img/sf/16.jpeg',
                        'body' => 'We organize medical camps and provide healthcare assistance to martyrs’ families, ensuring access to treatment, medicines, and emergency health support when they need it most.',
                        'event_date' => '2026-12-05',
                    ),
                );
                $display_events = !empty($ngom_events) ? $ngom_events : $fallback_events;
                ?>
                <?php foreach (array_slice($display_events, 0, 3) as $index => $event): ?>
                    <?php
                    $delay = ($index % 3 === 0) ? '0.1s' : (($index % 3 === 1) ? '0.3s' : '0.5s');
                    $raw_img = !empty($event['image']) ? $event['image'] : '';
                    if ($raw_img === '') {
                        $img_src = base_url('assetsA/img/no-image.png');
                    } elseif (strpos($raw_img, 'http://') === 0 || strpos($raw_img, 'https://') === 0) {
                        $img_src = $raw_img;
                    } elseif (strpos($raw_img, 'assets') === 0 || strpos($raw_img, 'uploads') === 0) {
                        $img_src = base_url($raw_img);
                    } else {
                        $img_src = web_asset($raw_img);
                    }
                    ?>
                    <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="<?php echo $delay; ?>">
                        <div class="event-item h-100 p-4">
                            <img class="img-fluid w-100 mb-4" style="height: 225px; object-fit: cover;" src="<?php echo html_escape($img_src); ?>" alt="<?php echo html_escape($event['title']); ?>" onerror="this.src='<?php echo base_url('assetsA/img/no-image.png'); ?>';">
                            <a href="<?php echo web_link('event.php'); ?>" class="h3 d-inline-block"><?php echo html_escape($event['title']); ?></a>
                            <p class="mb-0">
                                <?php 
                                    $body = strip_tags((string)$event['body']);
                                    echo (strlen($body) > 150) ? substr($body, 0, 150) . '...' : $body;
                                ?>
                            </p>
                            <?php if (!empty($event['event_date'])): ?>
                                <div class="bg-light p-3 mt-3 border-radius-lg">
                                    <p class="mb-0 text-sm"><i class="fa fa-calendar-alt text-primary me-2"></i><?php echo date('d M, Y', strtotime($event['event_date'])); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
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

                        <form id="quick-donation-form" onsubmit="return false;">
                            <div class="row g-3 text-start">

                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select" id="quick-campaign" aria-label="Select Campaign">
                                            <option value="">General Fund (Martyrs' Families Care)</option>
                                            <?php foreach ($campaign_list as $c_opt): ?>
                                                <option value="<?php echo (int)$c_opt['id']; ?>"><?php echo html_escape($c_opt['title']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="quick-campaign">Choose Cause / Campaign</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="quick-name" placeholder="Your Name" required>
                                        <label for="quick-name">Full Name</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="quick-email" placeholder="Your Email" required>
                                        <label for="quick-email">Email Address</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="quick-mobile" placeholder="Mobile" maxlength="15">
                                        <label for="quick-mobile">Mobile Number (optional)</label>
                                    </div>
                                </div>

                                <!-- Donation Amount -->
                                <div class="col-12">
                                    <p class="text-white mb-2">Choose Donation Amount</p>
                                    <div class="btn-group flex-wrap w-100 justify-content-center" role="group">
                                        <input type="radio" class="btn-check" name="quick_donation" id="quick-donate1" value="500" checked>
                                        <label class="btn btn-light m-1 px-3" for="quick-donate1">₹500</label>

                                        <input type="radio" class="btn-check" name="quick_donation" id="quick-donate2" value="1000">
                                        <label class="btn btn-light m-1 px-3" for="quick-donate2">₹1,000</label>

                                        <input type="radio" class="btn-check" name="quick_donation" id="quick-donate3" value="2000">
                                        <label class="btn btn-light m-1 px-3" for="quick-donate3">₹2,000</label>

                                        <input type="radio" class="btn-check" name="quick_donation" id="quick-donate4" value="5000">
                                        <label class="btn btn-light m-1 px-3" for="quick-donate4">₹5,000</label>

                                        <input type="radio" class="btn-check" name="quick_donation" id="quick-donate5" value="custom">
                                        <label class="btn btn-light m-1 px-3" for="quick-donate5">Custom</label>
                                    </div>
                                    <div id="quick-custom-wrap" class="mt-2 d-none">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">₹</span>
                                            <input type="number" class="form-control" id="quick-custom-amount" placeholder="Enter amount" min="1" step="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="quick-consent" checked>
                                        <label class="form-check-label text-white small" for="quick-consent">
                                            I donate voluntarily to Shaheed Foundation (80G tax benefit applicable).
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12" id="quick-pay-wrap">
                                    <button class="btn btn-secondary py-3 w-100 fw-bold" type="button" id="btn-quick-donate-pay">
                                        <i class="fa fa-credit-card me-2"></i>Donate with Respect
                                    </button>
                                </div>

                                <div class="col-12 d-none" id="quick-donation-success">
                                    <div class="alert alert-success mb-0 text-start">
                                        <i class="fa fa-check-circle me-2"></i><strong>Thank you!</strong> Your donation has been recorded.
                                        <div id="quick-receipt-link" class="mt-2"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <p class="text-white small mt-2 mb-0">
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

    <script>
        (function() {
            var razorpayKeyId = <?php echo $razorpay_enabled ? json_encode(RAZORPAY_KEY_ID) : '""'; ?>;
            var createOrderUrl = <?php echo json_encode(site_url('donations/create_order')); ?>;
            var verifyPaymentUrl = <?php echo json_encode(site_url('donations/verify_payment')); ?>;
            var donationPageUrl = <?php echo json_encode(web_link('donation.php')); ?>;

            document.querySelectorAll('input[name="quick_donation"]').forEach(function(r) {
                r.addEventListener('change', function() {
                    var wrap = document.getElementById('quick-custom-wrap');
                    if (wrap) wrap.classList.toggle('d-none', this.id !== 'quick-donate5');
                });
            });

            var btn = document.getElementById('btn-quick-donate-pay');
            if (btn) {
                btn.addEventListener('click', function() {
                    var name = document.getElementById('quick-name').value.trim();
                    var email = document.getElementById('quick-email').value.trim();
                    var mobile = document.getElementById('quick-mobile') ? document.getElementById('quick-mobile').value.trim() : '';
                    var campaignId = document.getElementById('quick-campaign') ? document.getElementById('quick-campaign').value : '';
                    var amount = 0;
                    if (document.getElementById('quick-donate5') && document.getElementById('quick-donate5').checked) {
                        amount = parseFloat(document.getElementById('quick-custom-amount').value) || 0;
                    } else {
                        var chk = document.querySelector('input[name="quick_donation"]:checked');
                        amount = chk ? (parseFloat(chk.value) || 0) : 0;
                    }

                    if (!name) { alert('Please enter your full name.'); return; }
                    if (!email) { alert('Please enter your email address.'); return; }
                    if (amount < 1) { alert('Please select or enter a valid donation amount (minimum ₹1).'); return; }
                    var consent = document.getElementById('quick-consent');
                    if (consent && !consent.checked) {
                        alert('Please agree to the donation terms before proceeding.');
                        return;
                    }

                    if (!razorpayKeyId) {
                        window.location.href = donationPageUrl + (campaignId ? ('?campaign_id=' + encodeURIComponent(campaignId) + '#bank-details') : '#bank-details');
                        return;
                    }

                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

                    fetch(createOrderUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            amount: amount,
                            name: name,
                            email: email,
                            mobile: mobile,
                            campaign_id: campaignId
                        })
                    }).then(function(r) { return r.json(); }).then(function(res) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-credit-card me-2"></i>Donate with Respect';
                        if (!res.success) {
                            alert(res.error || 'Could not initiate payment. Redirecting to direct bank donation...');
                            window.location.href = donationPageUrl + '#bank-details';
                            return;
                        }

                        var options = {
                            key: razorpayKeyId,
                            amount: res.amount,
                            currency: res.currency,
                            order_id: res.orderId,
                            name: 'Shaheed Foundation',
                            description: 'Donation for Martyrs\' Families',
                            prefill: { name: name, email: email, contact: mobile },
                            theme: { color: '#0d6efd' },
                            modal: { ondismiss: function() {} },
                            handler: function(response) {
                                fetch(verifyPaymentUrl, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_signature: response.razorpay_signature,
                                        name: name,
                                        email: email,
                                        mobile: mobile,
                                        amount: amount,
                                        campaign_id: campaignId
                                    })
                                }).then(function(r) { return r.json(); }).then(function(v) {
                                    if (!v.ok) {
                                        alert(v.error || 'Verification failed. Contact support with your payment ID.');
                                        return;
                                    }
                                    var payWrap = document.getElementById('quick-pay-wrap');
                                    if (payWrap) payWrap.classList.add('d-none');
                                    var successBox = document.getElementById('quick-donation-success');
                                    if (successBox) successBox.classList.remove('d-none');
                                    if (v.receipt_url) {
                                        var rWrap = document.getElementById('quick-receipt-link');
                                        if (rWrap) {
                                            rWrap.innerHTML = '<a href="' + v.receipt_url + '" class="btn btn-sm btn-outline-success mt-1" target="_blank" rel="noopener"><i class="fa fa-download me-1"></i> Download 80G Tax Receipt (PDF)</a>';
                                        }
                                    }
                                    successBox.scrollIntoView({ behavior: 'smooth' });
                                }).catch(function() {
                                    alert('Could not verify payment on server. Please keep your transaction ID safe.');
                                });
                            }
                        };
                        var rzp = new Razorpay(options);
                        rzp.on('payment.failed', function(response) {
                            alert('Payment could not be completed. You may retry or use Bank Transfer.');
                        });
                        rzp.open();
                    }).catch(function() {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-credit-card me-2"></i>Donate with Respect';
                        alert('Connection error. Redirecting to direct bank donation...');
                        window.location.href = donationPageUrl + '#bank-details';
                    });
                });
            }
        })();
    </script>

    <?php include 'footer.php'; ?>

</body>

</html>