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
            <h1 class="display-3 animated slideInDown">Financial Assistance</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo web_link('service.php'); ?>">Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Financial Assistance</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_financial_html')): ?>



<section class="container-fluid py-5" id="martyrs-family-support">
  <div class="container">

    <!-- Header / Hero -->
    <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width:900px;">
      <p class="section-title bg-white text-center text-primary px-3">Family Financial Support</p>
      <h1 class="display-5 mb-3">Standing Strong with the Families of Our Martyrs</h1>
      <p class="fs-5 mb-4">
        Shaheed Foundation of India provides continuous financial and household support
        to the families of our brave martyrs — ensuring stability, dignity, and security
        in their daily lives.
      </p>
      <div class="d-flex justify-content-center gap-3">
        <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-primary px-4 py-2">Donate Now</a>
        <a href="<?php echo web_link('contact.php'); ?>" class="btn btn-outline-primary px-4 py-2">Join as Volunteer</a>
      </div>
    </div>

    <hr class="my-5">

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-3 text-center border-0 shadow-sm">
          <i class="fa-solid fa-hand-holding-heart fa-2x text-primary mb-3"></i>
          <h5>Financial Assistance</h5>
          <p>Direct financial help to support families after the loss of their loved one.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-3 text-center border-0 shadow-sm">
          <i class="fa-solid fa-calendar-check fa-2x text-primary mb-3"></i>
          <h5>Monthly Family Support</h5>
          <p>Fixed monthly assistance to manage household expenses with confidence.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-3 text-center border-0 shadow-sm">
          <i class="fa-solid fa-truck-medical fa-2x text-primary mb-3"></i>
          <h5>Emergency Financial Aid</h5>
          <p>Immediate support during medical emergencies or sudden crises.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-3 text-center border-0 shadow-sm">
          <i class="fa-solid fa-box-open fa-2x text-primary mb-3"></i>
          <h5>Household & Ration Support</h5>
          <p>Monthly ration kits and essential household supplies for families.</p>
        </div>
      </div>
    </div>

    <!-- Detailed Sections -->
    <div class="row gy-5">
      <div class="col-lg-8">

        <!-- Financial Assistance -->
        <div class="mb-5">
          <h2><i class="fa-solid fa-rupee-sign text-primary me-2"></i> Financial Assistance</h2>
          <p class="lead">Helping families regain financial stability after sacrifice.</p>
          <ul>
            <li>One-time and recurring financial assistance</li>
            <li>Support for basic needs and essential expenses</li>
            <li>Guidance for pensions and government benefits</li>
          </ul>
        </div>

        <!-- Monthly Support -->
        <div class="mb-5">
          <h2><i class="fa-solid fa-calendar-day text-primary me-2"></i> Monthly Family Support</h2>
          <p class="lead">A steady hand of support every month.</p>
          <ul>
            <li>Monthly financial aid for household expenses</li>
            <li>Support for electricity, rent and daily living costs</li>
            <li>Long-term commitment to family well-being</li>
          </ul>
        </div>

        <!-- Emergency Aid -->
        <div class="mb-5">
          <h2><i class="fa-solid fa-kit-medical text-primary me-2"></i> Emergency Financial Aid</h2>
          <p class="lead">Immediate help when families need it most.</p>
          <ul>
            <li>Medical emergencies and hospital expenses</li>
            <li>Unexpected crises or urgent family needs</li>
            <li>Fast-track support without delays</li>
          </ul>
        </div>

        <!-- Household Support -->
        <div class="mb-5">
          <h2><i class="fa-solid fa-basket-shopping text-primary me-2"></i> Household & Ration Support</h2>
          <p class="lead">Ensuring no family sleeps hungry.</p>
          <ul>
            <li>Monthly ration kits (rice, wheat, pulses, oil)</li>
            <li>Hygiene and household essentials</li>
            <li>Seasonal support during extreme weather</li>
          </ul>
        </div>

      </div>

      <!-- Right Column -->
      <div class="col-lg-4">
        <div class="p-4 rounded shadow-sm text-center mb-4">
          <h5>Our Impact</h5>
          <p><strong>40+</strong> Families Supported</p>
          <p><strong>500+</strong> Monthly Ration Kits Distributed</p>
          <p><strong>100+</strong> Emergency Cases Assisted</p>
        </div>

        <div class="text-center">
          <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-primary btn-lg w-100 py-3">
            Donate for Family Support
          </a>
        </div>
      </div>
    </div>

  </div>
</section>

















<?php endif; ?>

      <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>