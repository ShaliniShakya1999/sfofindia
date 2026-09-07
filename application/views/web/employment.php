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
            <h1 class="display-3 animated slideInDown">Employment & Skill Development</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo web_link('service.php'); ?>">Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Employment & Skill Development</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_employment_html')): ?>

<!-- Employment & Skill Development Section -->
<div class="container py-5" id="employment-support">
    <div class="text-center mb-5">
        <p class="section-title bg-white text-primary px-3">Employment & Skill Development</p>
        <h1 class="display-6">Empowering Families with Skills & Opportunities</h1>
        <p class="mt-3">We provide training, job assistance, and support for self-employment to help families become financially independent.</p>
    </div>

    <div class="row g-4">

        <!-- Job Assistance -->
        <div class="col-md-6 col-lg-4">
            <div class="service-item p-4 border shadow-sm h-100">
                <div class="icon mb-3">
                    <i class="fa-solid fa-briefcase fa-3x text-primary"></i>
                </div>
                <h4 class="mb-3">Job Assistance</h4>
                <p>
                    Helping family members of martyrs secure meaningful employment opportunities in various sectors.
                </p>
                <ul>
                    <li>Resume building & interview preparation</li>
                    <li>Placement support in private & government sectors</li>
                    <li>Career guidance based on skills & interests</li>
                </ul>
            </div>
        </div>

        <!-- Skill Training Programs -->
        <div class="col-md-6 col-lg-4">
            <div class="service-item p-4 border shadow-sm h-100">
                <div class="icon mb-3">
                    <i class="fa-solid fa-chalkboard-user fa-3x text-primary"></i>
                </div>
                <h4 class="mb-3">Skill Training Programs</h4>
                <p>
                    Structured programs to equip beneficiaries with marketable skills for better employment prospects.
                </p>
                <ul>
                    <li>Computer & IT skills training</li>
                    <li>Handicrafts, tailoring & vocational skills</li>
                    <li>Workshops for entrepreneurship and personal development</li>
                </ul>
            </div>
        </div>

        <!-- Self-Employment Support -->
        <div class="col-md-6 col-lg-4">
            <div class="service-item p-4 border shadow-sm h-100">
                <div class="icon mb-3">
                    <i class="fa-solid fa-lightbulb fa-3x text-primary"></i>
                </div>
                <h4 class="mb-3">Self-Employment Support</h4>
                <p>
                    Supporting families to start their own business ventures or home-based income projects.
                </p>
                <ul>
                    <li>Financial aid for small business startups</li>
                    <li>Guidance on business planning & marketing</li>
                    <li>Mentorship for sustainable income generation</li>
                </ul>
            </div>
        </div>

    </div>
</div>


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
















<?php endif; ?>

      <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>