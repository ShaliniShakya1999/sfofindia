<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* Desktop Logo Size */
.top-logo {
    height: 75px;
    width: auto;
    object-fit: contain;
}

/* Tablet */
@media (max-width: 992px) {
    .top-logo {
        height: 58px;
    }
}

/* Mobile */
@media (max-width: 576px) {
    .top-logo {
        height: 48px;
    }
}

.top-contact-wrap {
    gap: 2rem;
}
.top-contact-item {
    display: inline-flex;
    align-items: center;
}
.top-icon-badge {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: #ffac00;
    border: 1px solid rgba(255, 255, 255, 0.18);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: background-color 0.15s ease, border-color 0.15s ease;
}
.top-contact-item:hover .top-icon-badge {
    background: rgba(255, 172, 0, 0.2);
    border-color: rgba(255, 172, 0, 0.4);
}
.top-meta-label {
    display: block;
    font-size: 0.67rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #ffac00;
    line-height: 1.15;
    margin-bottom: 2px;
}
.top-meta-val {
    display: block;
    font-size: 0.82rem;
    font-weight: 600;
    color: #ffffff !important;
    text-decoration: none;
    line-height: 1.25;
    transition: color 0.15s ease;
}
.top-meta-val:hover {
    color: #ffac00 !important;
}
.top-address-text {
    max-width: 240px;
    font-size: 0.76rem;
    line-height: 1.2;
    color: rgba(255, 255, 255, 0.92);
}
@media (max-width: 1199.98px) {
    .top-contact-wrap {
        gap: 1.2rem;
    }
    .top-meta-val {
        font-size: 0.76rem;
    }
    .top-address-text {
        max-width: 170px;
        font-size: 0.7rem;
    }
}
</style>

<?php if (!isset($cms) || !is_array($cms)) { $cms = array(); } ?>

<div class="container-fluid bg-secondary top-bar py-1 wow fadeIn" data-wow-delay="0.1s">
    <div class="row align-items-center h-100">

        <!-- Logo Section -->
        <div class="col-lg-3 col-xl-3 text-center text-lg-start">
            <a href="<?php echo web_link('index.php'); ?>" class="d-inline-block py-1">
                <img src="<?php echo html_escape(web_asset('img/logo1.png')); ?>" alt="<?php echo html_escape(cms_val($cms, 'site_name', 'Shaheed Foundation India')); ?>" class="top-logo">
            </a>
        </div>

        <!-- Right Side Contact Section -->
        <div class="col-lg-9 col-xl-9 d-none d-lg-block">
            <div class="d-flex justify-content-end align-items-center top-contact-wrap h-100">

                <!-- Call Us -->
                <div class="top-contact-item">
                    <div class="top-icon-badge me-2">
                        <i class="fa fa-phone-alt"></i>
                    </div>
                    <div>
                        <span class="top-meta-label">Call Us</span>
                        <a href="tel:<?php echo html_escape(cms_val($cms, 'contact_phone', '+91-9615641564')); ?>" class="top-meta-val">
                            <?php echo html_escape(cms_val($cms, 'contact_phone', '+91-9615641564')); ?>
                        </a>
                    </div>
                </div>

                <!-- Mail Us -->
                <div class="top-contact-item">
                    <div class="top-icon-badge me-2">
                        <i class="fa fa-envelope-open"></i>
                    </div>
                    <div>
                        <span class="top-meta-label">Mail Us</span>
                        <a href="mailto:<?php echo html_escape(cms_val($cms, 'contact_email', 'info@sfofindia.com')); ?>" class="top-meta-val">
                            <?php echo html_escape(cms_val($cms, 'contact_email', 'info@sfofindia.com')); ?>
                        </a>
                    </div>
                </div>

                <!-- Address -->
                <div class="top-contact-item">
                    <div class="top-icon-badge me-2">
                        <i class="fa fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <span class="top-meta-label">Address</span>
                        <span class="top-address-text d-block" title="<?php echo html_escape(cms_val($cms, 'contact_address', 'SCO-88 Second Floor, Opp. Sector 12 A Gurgaon')); ?>">
                            <?php echo html_escape(cms_val($cms, 'contact_address', 'SCO-88 Second Floor, Opp. Sector 12 A Gurgaon')); ?>
                        </span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
