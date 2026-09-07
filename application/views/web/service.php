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
            <h1 class="display-3 animated slideInDown">Service</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>

                    <li class="breadcrumb-item active" aria-current="page">Service</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_service_html')): ?>


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

<?php endif; ?>

    <?php include 'footer.php'; ?>
</body>

</html>