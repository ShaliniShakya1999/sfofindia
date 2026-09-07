<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    /* Desktop Logo Size */
.top-logo {
    height: 90px;
    width: auto;
}

/* Tablet */
@media (max-width: 992px) {
    .top-logo {
        height: 60px;
    }
}

/* Mobile */
@media (max-width: 576px) {
    .top-logo {
        height: 50px;
    }
}

</style>

<?php if (!isset($cms) || !is_array($cms)) { $cms = array(); } ?>

<div class="container-fluid bg-secondary top-bar wow fadeIn" data-wow-delay="0.1s">
    <div class="row align-items-center h-100">

        <!-- Logo Section -->
        <div class="col-lg-4 text-center text-lg-start">
            <a href="<?php echo web_link('index.php'); ?>">
                <img src="<?php echo html_escape(web_asset('img/logo1.png')); ?>" alt="<?php echo html_escape(cms_val($cms, 'site_name', 'Shaheed Foundation India')); ?>" class="top-logo">
            </a>
        </div>

        <!-- Right Side Contact Section -->
        <div class="col-lg-8 d-none d-lg-block">
            <div class="row">

                <div class="col-lg-3">
                    <div class="d-flex justify-content-end">
                        <div class="flex-shrink-0 btn-square bg-primary">
                            <i class="fa fa-phone-alt text-dark"></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="text-primary mb-0">Call Us</h6>
                            <span class="text-white"><?php echo html_escape(cms_val($cms, 'contact_phone', '+91-9615641564')); ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="d-flex justify-content-end">
                        <div class="flex-shrink-0 btn-square bg-primary">
                            <i class="fa fa-envelope-open text-dark"></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="text-primary mb-0">Mail Us</h6>
                            <span class="text-white"><?php echo html_escape(cms_val($cms, 'contact_email', 'info@sfofindia.com')); ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="d-flex justify-content-end">
                        <div class="flex-shrink-0 btn-square bg-primary">
                            <i class="fa fa-map-marker-alt text-dark"></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="text-primary mb-0">Address</h6>
                            <span class="text-white"><?php echo html_escape(cms_val($cms, 'contact_address', 'SCO-88 Second Floor, Opp. Sector 12 A Gurgaon')); ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
