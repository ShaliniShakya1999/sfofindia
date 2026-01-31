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
      <h1 class="display-3 animated slideInDown">Children’s Education Support</h1>
      <nav aria-label="breadcrumb animated slideInDown">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="service.php">Service</a></li>
          <li class="breadcrumb-item active" aria-current="page">Children’s Education Support</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- Page Header End -->



  <!-- Education Support Page (Shaheed Foundation) -->
  <section class="container-fluid py-5" id="education-support">
    <div class="container">

      <!-- Header -->
      <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width:900px;">
        <p class="section-title bg-white text-center text-primary px-3">Children’s Education Support</p>
        <h1 class="display-5 mb-3">Empowering the Children of Our Brave Martyrs</h1>
        <p class="fs-5 mb-4">
          Shaheed Foundation ensures that every child of a martyr receives proper education, guidance, and support.
          Our goal is to provide a bright future with dignity, knowledge, and confidence.
        </p>
        <div class="d-flex justify-content-center gap-3">
          <a href="#apply-education" class="btn btn-primary px-4 py-2">Apply for Support</a>
          <a href="donation.php" class="btn btn-outline-primary px-4 py-2">Sponsor a Child</a>
        </div>
      </div>

      <hr class="my-5">

      <!-- Summary Cards -->
      <div class="row g-4 mb-5">
        <div class="col-md-4">
          <div class="card h-100 p-3 text-center border-0 shadow-sm">
            <div class="mb-3"><i class="fa-solid fa-school fa-2x text-primary"></i></div>
            <h5 class="mb-2">School & College Fees</h5>
            <p class="mb-0">Full or partial coverage for school and college tuition fees, ensuring uninterrupted learning.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100 p-3 text-center border-0 shadow-sm">
            <div class="mb-3"><i class="fa-solid fa-book-open fa-2x text-primary"></i></div>
            <h5 class="mb-2">Books, Uniforms & Supplies</h5>
            <p class="mb-0">Textbooks, notebooks, stationery, uniforms, and school kits for every child.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100 p-3 text-center border-0 shadow-sm">
            <div class="mb-3"><i class="fa-solid fa-chalkboard-user fa-2x text-primary"></i></div>
            <h5 class="mb-2">Scholarships & Tuition Help</h5>
            <p class="mb-0">Scholarships, tuition classes, and coaching for exams to support academic excellence.</p>
          </div>
        </div>
      </div>

      <!-- Details Section -->
      <div class="row gy-5">

        <!-- Left Column -->
        <div class="col-lg-8">

          <!-- School & College Fees -->
          <div class="mb-5 wow fadeIn" data-wow-delay="0.1s">
            <h2><i class="fa-solid fa-school text-primary me-2"></i> School & College Fees Support</h2>
            <p class="lead">Every child of a martyr deserves uninterrupted education.</p>
            <ul>
              <li>Full/partial tuition fee assistance for school and college</li>
              <li>Support from Nursery to Graduation / Professional courses</li>
              <li>Emergency financial help for fee deadlines</li>
            </ul>
          </div>

          <!-- Books, Uniforms & Supplies -->
          <div class="mb-5 wow fadeIn" data-wow-delay="0.15s">
            <h2><i class="fa-solid fa-book text-primary me-2"></i> Books, Uniforms & Supplies</h2>
            <p class="lead">Providing complete educational kits to remove any obstacles in learning.</p>
            <ul>
              <li>Textbooks, notebooks, stationery, and study material</li>
              <li>School uniforms, shoes, bags, and seasonal clothing support</li>
              <li>Replacement of damaged or lost materials during the academic year</li>
            </ul>
          </div>

          <!-- Scholarships & Tuition Help -->
          <div class="mb-5 wow fadeIn" data-wow-delay="0.2s">
            <h2><i class="fa-solid fa-chalkboard-user text-primary me-2"></i> Scholarships & Tuition Help</h2>
            <p class="lead">Helping students excel academically and achieve their dreams.</p>
            <ul>
              <li>Merit-based scholarships for school, college, and professional studies</li>
              <li>Tuition classes or coaching for weak subjects</li>
              <li>Competitive exam preparation (NDA, NEET, JEE, SSC, Banking etc.)</li>
              <li>Career counselling and mentorship programs</li>
            </ul>
          </div>

          <!-- Success Story -->
          <div class="mb-5 p-4 bg-light rounded shadow-sm wow fadeIn" data-wow-delay="0.3s">
            <h4 class="mb-3"><i class="fa-solid fa-graduation-cap text-primary me-2"></i> Success Story</h4>
            <p class="mb-0">“After my father’s sacrifice, I feared my studies would stop. Shaheed Foundation helped with fees, books, and coaching. Today I am preparing for competitive exams confidently.”</p>
            <p class="text-end mb-0"><small class="text-muted">— Aarav, Class 12 Student</small></p>
          </div>

        </div>

        <!-- Right Column (Impact, CTA) -->
        <div class="col-lg-4">

          <!-- Impact Numbers -->
          <div class="mb-4 p-4 rounded shadow-sm text-center">
            <h5 class="mb-3">Our Education Impact</h5>
            <div class="d-flex flex-column gap-3">
              <div><i class="fa-solid fa-children me-2 text-primary"></i> <strong>150+</strong> Children Educated</div>
              <div><i class="fa-solid fa-book me-2 text-primary"></i> <strong>12,000+</strong> Books & Kits Distributed</div>
              <div><i class="fa-solid fa-school me-2 text-primary"></i> <strong>90+</strong> Schools Connected</div>
              <div><i class="fa-solid fa-user-tie me-2 text-primary"></i> <strong>180+</strong> Mentors/Teachers</div>
            </div>
          </div>

          <!-- You Can Help -->
          <div class="mb-4 p-4 rounded shadow-sm">
            <h6 class="mb-3">How You Can Help</h6>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><i class="fa-solid fa-circle-plus text-primary me-2"></i>Sponsor a child’s education</li>
              <li class="mb-2"><i class="fa-solid fa-circle-plus text-primary me-2"></i>Donate school bags & stationery</li>
              <li class="mb-2"><i class="fa-solid fa-circle-plus text-primary me-2"></i>Fund coaching & tuition</li>
              <li class="mb-2"><i class="fa-solid fa-circle-plus text-primary me-2"></i>Volunteer as mentor/guide</li>
            </ul>
          </div>

          <!-- Sponsor CTA -->
          <div class="mb-4 text-center">
            <a href="donation.php" class="btn btn-primary btn-lg w-100 py-3 mb-2">
              <i class="fa-solid fa-heart-circle-plus me-2"></i> Sponsor a Child
            </a>
            <a href="#contact" class="btn btn-outline-secondary w-100 py-2">
              <i class="fa-solid fa-envelope me-2"></i> Contact Us
            </a>
          </div>

          <!-- Contact Card -->
          <div class="p-3 rounded bg-light text-center">
            <h6 class="mb-2">Need Help or Want to Sponsor?</h6>
            <p class="mb-1"><i class="fa-solid fa-phone me-2 text-primary"></i> +91 9615641564</p>
            <p class="mb-0"><i class="fa-solid fa-envelope me-2 text-primary"></i> info@sfofindia.com</p>
          </div>

        </div>
      </div>

      <hr class="my-5">

      <!-- Apply Form -->
      <div id="apply-education" class="row justify-content-center wow fadeIn" data-wow-delay="0.4s">
        <div class="col-lg-8">
          <div class="p-4 rounded shadow-sm bg-white">
            <h4 class="mb-3">Apply for Education Support</h4>
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

      <div id="sponsor-child" class="my-5 text-center">
        <p class="mb-0"><small class="text-muted">Your contribution can change a martyr child’s future.</small></p>
      </div>

    </div>
  </section>





















  <!-- Footer Start -->
  <?php include 'footer.php'; ?>
  <!-- Footer End -->
</body>

</html>