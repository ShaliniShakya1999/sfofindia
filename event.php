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
            <h1 class="display-3 animated slideInDown">Event</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
               
                    <li class="breadcrumb-item active" aria-current="page">Event</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    


    <!-- Event Start -->
    <!-- <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Events</p>
                <h1 class="display-6 mb-4">Be a Part of a Global Movement</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" src="img/event-1.jpg" alt="">
                        <a href="#!" class="h3 d-inline-block">Education Program</a>
                        <p>Through your donations and volunteer work, we spread kindness and support to children.</p>
                        <div class="bg-light p-4">
                            <p class="mb-1"><i class="fa fa-clock text-primary me-2"></i>10:00 AM - 18:00 PM</p>
                            <p class="mb-1"><i class="fa fa-calendar-alt text-primary me-2"></i>Jan 01 - Jan 10</p>
                            <p class="mb-0"><i class="fa fa-map-marker-alt text-primary me-2"></i>123 Street, New York,
                                USA</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" src="img/event-2.jpg" alt="">
                        <a href="#!" class="h3 d-inline-block">Awareness Program</a>
                        <p>Through your donations and volunteer work, we spread kindness and support to children.</p>
                        <div class="bg-light p-4">
                            <p class="mb-1"><i class="fa fa-clock text-primary me-2"></i>10:00 AM - 18:00 PM</p>
                            <p class="mb-1"><i class="fa fa-calendar-alt text-primary me-2"></i>Jan 01 - Jan 10</p>
                            <p class="mb-0"><i class="fa fa-map-marker-alt text-primary me-2"></i>123 Street, New York,
                                USA</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" src="img/event-3.jpg" alt="">
                        <a href="#!" class="h3 d-inline-block">Health Care Program</a>
                        <p>Through your donations and volunteer work, we spread kindness and support to children.</p>
                        <div class="bg-light p-4">
                            <p class="mb-1"><i class="fa fa-clock text-primary me-2"></i>10:00 AM - 18:00 PM</p>
                            <p class="mb-1"><i class="fa fa-calendar-alt text-primary me-2"></i>Jan 01 - Jan 10</p>
                            <p class="mb-0"><i class="fa fa-map-marker-alt text-primary me-2"></i>123 Street, New York,
                                USA</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" src="img/event-1.jpg" alt="">
                        <a href="#!" class="h3 d-inline-block">Education Program</a>
                        <p>Through your donations and volunteer work, we spread kindness and support to children.</p>
                        <div class="bg-light p-4">
                            <p class="mb-1"><i class="fa fa-clock text-primary me-2"></i>10:00 AM - 18:00 PM</p>
                            <p class="mb-1"><i class="fa fa-calendar-alt text-primary me-2"></i>Jan 01 - Jan 10</p>
                            <p class="mb-0"><i class="fa fa-map-marker-alt text-primary me-2"></i>123 Street, New York,
                                USA</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" src="img/event-2.jpg" alt="">
                        <a href="#!" class="h3 d-inline-block">Awareness Program</a>
                        <p>Through your donations and volunteer work, we spread kindness and support to children.</p>
                        <div class="bg-light p-4">
                            <p class="mb-1"><i class="fa fa-clock text-primary me-2"></i>10:00 AM - 18:00 PM</p>
                            <p class="mb-1"><i class="fa fa-calendar-alt text-primary me-2"></i>Jan 01 - Jan 10</p>
                            <p class="mb-0"><i class="fa fa-map-marker-alt text-primary me-2"></i>123 Street, New York,
                                USA</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="event-item h-100 p-4">
                        <img class="img-fluid w-100 mb-4" src="img/event-3.jpg" alt="">
                        <a href="#!" class="h3 d-inline-block">Health Care Program</a>
                        <p>Through your donations and volunteer work, we spread kindness and support to children.</p>
                        <div class="bg-light p-4">
                            <p class="mb-1"><i class="fa fa-clock text-primary me-2"></i>10:00 AM - 18:00 PM</p>
                            <p class="mb-1"><i class="fa fa-calendar-alt text-primary me-2"></i>Jan 01 - Jan 10</p>
                            <p class="mb-0"><i class="fa fa-map-marker-alt text-primary me-2"></i>123 Street, New York,
                                USA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Event End -->



   
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
                        <img class="img-fluid w-100 mb-4" src="img/puduchery.jpg" alt="Martyrs Education Support">
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
                        <img class="img-fluid w-100 mb-4" src="img/TNIE.avif" alt="Martyrs Remembrance Program">
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
                        <img class="img-fluid w-100 mb-4" src="img/health.jpg" alt="Health Care Support for Martyrs Families">
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
                            <a class="btn btn-primary py-3 px-4 me-3" href="donation.php">
                                Donate Now
                            </a>
                            <a class="btn btn-secondary py-3 px-4" href="contact.php">
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

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>