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
            <h1 class="display-3 animated slideInDown">Contact</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>

                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<?php if (!cms_page_override($cms, 'page_contact_html')): ?>




    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                    <p class="section-title bg-white text-start text-primary pe-3">Contact</p>
                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">If You Have Any Query, Please Contact Us
                    </h1>
                    <iframe class="w-100"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14029.53887907814!2d77.0369008!3d28.4679584!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x51da301450033261!2sJayant%20India%20Nidhi%20limited!5e0!3m2!1sen!2sin!4v1623671222960!5m2!1sen!2sin"
                        frameborder="0" style="height: 425px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">
                    <h3 class="mb-3 fw-bold text-dark">Need a functional contact form?</h3>
                    <p class="mb-4 text-secondary">
                        The contact form is currently active. Send us your details and we will get back to you soon.
                    </p>

                   
                   
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
    </div>
    <!-- Contact End -->

<?php endif; ?>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->
</body>

</html>