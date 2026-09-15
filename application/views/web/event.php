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
                  <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
               
                    <li class="breadcrumb-item active" aria-current="page">Event</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_event_html')): ?>

    <!-- Event Start -->
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
            'image' => 'img/health.jpg',
            'body' => 'We organize medical camps and provide healthcare assistance to martyrs’ families, ensuring access to treatment, medicines, and emergency health support when they need it most.',
            'event_date' => '2026-12-05',
        ),
    );
    $display_events = !empty($ngom_events) ? $ngom_events : $fallback_events;
    ?>
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
                <?php foreach ($display_events as $index => $event): ?>
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
                            <img class="img-fluid w-100 mb-4" style="height: 230px; object-fit: cover;" src="<?php echo html_escape($img_src); ?>" alt="<?php echo html_escape($event['title']); ?>" onerror="this.src='<?php echo base_url('assetsA/img/no-image.png'); ?>';">
                            <a href="#!" class="h3 d-inline-block"><?php echo html_escape($event['title']); ?></a>
                            <p class="mb-0">
                                <?php 
                                    $body = strip_tags((string)$event['body']);
                                    echo (strlen($body) > 160) ? substr($body, 0, 160) . '...' : $body;
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

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>