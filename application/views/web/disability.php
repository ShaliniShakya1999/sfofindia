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
            <h1 class="display-3 animated slideInDown">Medical & Health Care</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo web_link('service.php'); ?>">Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Medical & Health Care</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_disability_html')): ?>

<!-- Disability Support Page (Shaheed Foundation) -->
<section class="container-fluid py-5" id="healthcare-support">
  <div class="container">

    <!-- Header -->
    <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width:900px;">
      <p class="section-title bg-white text-center text-primary px-3">Medical & Health Care</p>
      <h1 class="display-5 mb-3">Supporting Martyrs' Families with Medical Assistance</h1>
      <p class="fs-5 mb-4">
        Shaheed Foundation provides essential medical and healthcare support including treatment, hospital expenses, medicines, and mental health care to ensure the well-being of martyrs’ families.
      </p>
      <div class="d-flex justify-content-center gap-3">
        <a href="#apply-healthcare" class="btn btn-primary px-4 py-2">Apply for Support</a>
        <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-outline-primary px-4 py-2">Donate Now</a>
      </div>
    </div>

    <hr class="my-5">

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="card h-100 p-3 text-center border-0 shadow-sm">
          <div class="mb-3"><i class="fa-solid fa-hospital fa-2x text-primary"></i></div>
          <h5 class="mb-2">Medical Treatment</h5>
          <p class="mb-0">Support for essential medical treatments, surgeries, and specialized care.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 p-3 text-center border-0 shadow-sm">
          <div class="mb-3"><i class="fa-solid fa-pills fa-2x text-primary"></i></div>
          <h5 class="mb-2">Hospital & Medicine Expenses</h5>
          <p class="mb-0">Coverage for hospital bills, medicines, and diagnostic tests for families in need.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 p-3 text-center border-0 shadow-sm">
          <div class="mb-3"><i class="fa-solid fa-brain fa-2x text-primary"></i></div>
          <h5 class="mb-2">Mental & Emotional Care</h5>
          <p class="mb-0">Counseling, therapy, and emotional support to help families cope with loss and trauma.</p>
        </div>
      </div>
    </div>

    <!-- Details Section -->
    <div class="row gy-5">

      <!-- Left Column -->
      <div class="col-lg-8">

        <!-- Medical Treatment -->
        <div class="mb-5 wow fadeIn" data-wow-delay="0.1s">
          <h2><i class="fa-solid fa-hospital text-primary me-2"></i> Medical Treatment Support</h2>
          <p class="lead">Providing necessary medical care so that no family suffers due to lack of treatment.</p>
          <ul>
            <li>Support for surgeries and specialized medical treatments</li>
            <li>Assistance with diagnostic tests and consultations</li>
            <li>Emergency medical aid during critical conditions</li>
          </ul>
        </div>

        <!-- Hospital & Medicine -->
        <div class="mb-5 wow fadeIn" data-wow-delay="0.15s">
          <h2><i class="fa-solid fa-pills text-primary me-2"></i> Hospital & Medicine Support</h2>
          <p class="lead">Helping families cover hospital bills, medicines, and other medical expenses.</p>
          <ul>
            <li>Hospitalization cost coverage for surgeries and treatment</li>
            <li>Medicines and medical consumables for ongoing care</li>
            <li>Home healthcare support for critical patients</li>
          </ul>
        </div>

        <!-- Mental & Emotional Care -->
        <div class="mb-5 wow fadeIn" data-wow-delay="0.2s">
          <h2><i class="fa-solid fa-brain text-primary me-2"></i> Mental & Emotional Care</h2>
          <p class="lead">Providing counseling and therapy for families to heal emotionally.</p>
          <ul>
            <li>Individual and group counseling sessions</li>
            <li>Stress, grief, and trauma management</li>
            <li>Workshops for emotional resilience and mental well-being</li>
          </ul>
        </div>

        <!-- Success Story -->
        <div class="mb-5 p-4 bg-light rounded shadow-sm wow fadeIn" data-wow-delay="0.3s">
          <h4 class="mb-3"><i class="fa-solid fa-heart-pulse text-primary me-2"></i> Success Story</h4>
          <p class="mb-0">“After my father’s sacrifice, I was hospitalized and couldn’t afford treatment. Shaheed Foundation covered my medical expenses and provided counseling. Today I am recovering and more confident to face life challenges.”</p>
          <p class="text-end mb-0"><small class="text-muted">— Sneha, Beneficiary</small></p>
        </div>

      </div>

      <!-- Right Column (Impact, CTA) -->
      <div class="col-lg-4">

        <!-- Impact Numbers -->
        <div class="mb-4 p-4 rounded shadow-sm text-center">
          <h5 class="mb-3">Our Healthcare Impact</h5>
          <div class="d-flex flex-column gap-3">
            <div><i class="fa-solid fa-hospital me-2 text-primary"></i> <strong>200+</strong> Treatments Provided</div>
            <div><i class="fa-solid fa-pills me-2 text-primary"></i> <strong>500+</strong> Medicines Supplied</div>
            <div><i class="fa-solid fa-brain me-2 text-primary"></i> <strong>120+</strong> Counseling Sessions</div>
            <div><i class="fa-solid fa-hand-holding-heart me-2 text-primary"></i> <strong>80+</strong> Families Supported</div>
          </div>
        </div>

        <!-- You Can Help -->
        <div class="mb-4 p-4 rounded shadow-sm">
          <h6 class="mb-3">You Can Contribute</h6>
          <ul class="list-unstyled mb-0">
            <li class="mb-2"><i class="fa-solid fa-circle-plus text-primary me-2"></i>Fund medical treatment</li>
            <li class="mb-2"><i class="fa-solid fa-circle-plus text-primary me-2"></i>Donate medicines & supplies</li>
            <li class="mb-2"><i class="fa-solid fa-circle-plus text-primary me-2"></i>Support mental health programs</li>
            <li class="mb-2"><i class="fa-solid fa-circle-plus text-primary me-2"></i>Volunteer for counseling & care</li>
          </ul>
        </div>

        <!-- CTA Buttons -->
        <div class="mb-4 text-center">
          <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-primary btn-lg w-100 py-3 mb-2">
            <i class="fa-solid fa-heart-circle-plus me-2"></i> Donate for Medical Support
          </a>
          <a href="#contact" class="btn btn-outline-secondary w-100 py-2">
            <i class="fa-solid fa-envelope me-2"></i> Contact Us
          </a>
        </div>

        <!-- Contact -->
        <div class="p-3 rounded bg-light text-center">
          <h6 class="mb-2">Need Assistance?</h6>
          <p class="mb-1"><i class="fa-solid fa-phone me-2 text-primary"></i> +91 9615641564</p>
          <p class="mb-0"><i class="fa-solid fa-envelope me-2 text-primary"></i> info@sfofindia.com</p>
        </div>

      </div>
    </div>

    <hr class="my-5">

    <!-- Apply Form -->
    <div id="apply-healthcare" class="row justify-content-center wow fadeIn" data-wow-delay="0.4s">
      <div class="col-lg-8">
        <div class="p-4 rounded shadow-sm bg-white">
          <h4 class="mb-3">Apply for Medical Support</h4>
         <form method="post" action="send.php" id="contact-form" class="p-4 rounded-4 shadow-sm bg-white">
                        <div class="row clearfix">

                            <!-- Name -->
                            <div class="col-lg-6 form-group mb-3">
                                <label class="text-dark fw-semibold mb-1">Your Name</label>
                                <input type="text" name="username" class="form-control form-control-lg rounded-3" placeholder="Enter your name" required="">
                            </div>

                            <!-- Email -->
                            <div class="col-lg-6 form-group mb-3">
                                <label class="text-dark fw-semibold mb-1">Your Email</label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3" placeholder="Enter your email" required="">
                            </div>

                            <!-- Phone -->
                            <div class="col-lg-6 form-group mb-3">
                                <label class="text-dark fw-semibold mb-1">Phone</label>
                                <input type="text" name="phone" class="form-control form-control-lg rounded-3" placeholder="Enter phone number" required="">
                            </div>

                            <!-- Subject -->
                            <div class="col-lg-6 form-group mb-3">
                                <label class="text-dark fw-semibold mb-1">Subject</label>
                                <input type="text" name="subject" class="form-control form-control-lg rounded-3" placeholder="Enter subject" required="">
                            </div>

                            <!-- Message -->
                            <div class="col-lg-12 form-group mb-3">
                                <label class="text-dark fw-semibold mb-1">Message</label>
                                <textarea name="message" class="form-control form-control-lg rounded-3" placeholder="Write your message..." required="" style="height: 180px"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 text-center mt-2">
                                <button class="btn btn-primary px-5 py-3 rounded-3 fw-semibold shadow-sm"
                                    style="font-size: 18px; letter-spacing: 0.5px;"
                                    type="submit">
                                    Send Message
                                </button>
                            </div>

                        </div>
                    </form>
        </div>
      </div>
    </div>

    <div id="donate-healthcare" class="my-5 text-center">
      <p class="mb-0"><small class="text-muted">Your support helps families stay healthy and strong.</small></p>
    </div>

  </div>
</section>




















<?php endif; ?>

      <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>