<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (!isset($cms) || !is_array($cms)) { $cms = array(); }
?>




<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-5 py-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Our Office</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><?php echo html_escape(cms_val($cms, 'contact_address', 'SCO-88 Second Floor, Opp. Sector 12 A Gurgaon')); ?></p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><?php echo html_escape(cms_val($cms, 'contact_phone', '+012 345 67890')); ?></p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i> <?php echo html_escape(cms_val($cms, 'contact_email', 'info@sfofindia.com')); ?></p>
                <div class="d-flex pt-3">
                    <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-x-twitter"></i></a>
                    <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Quick Links</h4>
                <a class="btn btn-link" href="<?php echo web_link('about.php'); ?>">About Us</a>
                <a class="btn btn-link" href="<?php echo web_link('contact.php'); ?>">Contact Us</a>
                <a class="btn btn-link" href="<?php echo web_link('service.php'); ?>">Our Services</a>
                <a class="btn btn-link" href="<?php echo web_link('terms.php'); ?>">Terms & Condition</a>
                <a class="btn btn-link" href="<?php echo web_link('privacy_Policy.php'); ?>">Privacy Policy</a>
                <a class="btn btn-link" href="<?php echo web_link('legal_Compliance.php'); ?>">Legal & Compliance</a>
                <a class="btn btn-link" href="<?php echo web_link('refund_Policy.php'); ?>">Refund Policy</a>
                <hr class="bg-light opacity-25 my-2">
                <a class="btn btn-link text-primary font-weight-bold" href="<?php echo site_url('admin/login'); ?>"><i class="fa fa-lock me-1"></i> Staff / Member Login</a>
                <!-- <a class="btn btn-link" href="#!">Support</a> -->
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Business Hours</h4>
                <p class="mb-1">Monday - Friday</p>
                <h6 class="text-light">09:00 am - 07:00 pm</h6>
                <p class="mb-1">Saturday</p>
                <h6 class="text-light">09:00 am - 12:00 pm</h6>
                <p class="mb-1">Sunday</p>
                <h6 class="text-light">Closed</h6>
            </div>
            <style>
                .gallery-img {
                    width: 100%;
                    height: 90px;
                    /* You can increase this if you want bigger images */
                    object-fit: cover;
                    border-radius: 4px;
                }
            </style>

            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4"><a href="<?php echo web_link('gallery.php'); ?>">Gallery</a></h4>
                <div class="row g-2">

                    <div class="col-4"><a href="<?php echo web_link('gallery.php'); ?>">

                        <img class="gallery-img" src="<?php echo html_escape(web_asset('img/sf/2.jpeg')); ?>" alt="">
                    </a>
                    </div>

                    <div class="col-4">
                        <a href="<?php echo web_link('gallery.php'); ?>">

                            <img class="gallery-img" src="<?php echo html_escape(web_asset('img/sf/19.jpeg')); ?>" alt="">
                        </a>
                    </div>

                    <div class="col-4">
                        <a href="<?php echo web_link('gallery.php'); ?>">
                            
                            <img class="gallery-img" src="<?php echo html_escape(web_asset('img/sf/13.jpeg')); ?>" alt="">
                        </a>
                    </div>

                    <div class="col-4">
                        <a href="<?php echo web_link('gallery.php'); ?>">

                            <img class="gallery-img" src="<?php echo html_escape(web_asset('img/sf/7.jpeg')); ?>" alt="">
                        </a>
                    </div>

                    <div class="col-4"><a href="<?php echo web_link('gallery.php'); ?>">

                        <img class="gallery-img" src="<?php echo html_escape(web_asset('img/sf/15.jpeg')); ?>" alt="">
                    </a>
                    </div>

                    <div class="col-4">
                        <a href="<?php echo web_link('gallery.php'); ?>">

                            <img class="gallery-img" src="<?php echo html_escape(web_asset('img/sf/10.jpeg')); ?>" alt="">
                        </a>
                    </div>

                </div>
            </div>

        </div>
        <div class="copyright pt-5">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="fw-semi-bold" href="<?php echo web_link('index.php'); ?>"><?php echo html_escape(cms_val($cms, 'site_name', 'Shaheed Foundation India')); ?></a>, All Right Reserved.
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo html_escape(web_asset('lib/wow/wow.min.js')); ?>"></script>
<script src="<?php echo html_escape(web_asset('lib/easing/easing.min.js')); ?>"></script>
<script src="<?php echo html_escape(web_asset('lib/waypoints/waypoints.min.js')); ?>"></script>
<script src="<?php echo html_escape(web_asset('lib/owlcarousel/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo html_escape(web_asset('lib/counterup/counterup.min.js')); ?>"></script>

<!-- Template Javascript -->
<script src="<?php echo html_escape(web_asset('js/main.js')); ?>"></script>