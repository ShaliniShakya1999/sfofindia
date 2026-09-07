<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$active = $CI->router->method;
$class = strtolower((string) $CI->router->fetch_class());
?>

<div class="container-fluid bg-secondary px-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="nav-bar">
        <nav class="navbar navbar-expand-lg bg-primary navbar-dark px-4 py-lg-0">

            <h4 class="d-lg-none m-0">Menu</h4>

            <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav me-auto">

                    <!-- Home -->
                    <a href="<?php echo web_link('index.php'); ?>"
                       class="nav-item nav-link <?= ($active === 'index') ? 'active' : '' ?>">
                        Home
                    </a>

                    <!-- About -->
                    <a href="<?php echo web_link('about.php'); ?>"
                       class="nav-item nav-link <?= ($active === 'about') ? 'active' : '' ?>">
                        About
                    </a>

                    <!-- Service Dropdown -->
                    <div class="nav-item dropdown <?= in_array($active, array('service','financial','education','disability','employment'), true) ? 'active' : '' ?>">
                        <a href="<?php echo web_link('service.php'); ?>" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            Service
                        </a>
                        <div class="dropdown-menu bg-light m-0">
                            <a href="<?php echo web_link('financial.php'); ?>" class="dropdown-item <?= ($active === 'financial') ? 'active' : '' ?>">Financial Assistance</a>
                            <a href="<?php echo web_link('education.php'); ?>" class="dropdown-item <?= ($active === 'education') ? 'active' : '' ?>">Children’s Education Support</a>
                            <a href="<?php echo web_link('disability.php'); ?>" class="dropdown-item <?= ($active === 'disability') ? 'active' : '' ?>">Medical & Health Care</a>
                            <a href="<?php echo web_link('employment.php'); ?>" class="dropdown-item <?= ($active === 'employment') ? 'active' : '' ?>">Employment & Skill Development</a>
                        </div>
                    </div>

                    <!-- Donation -->
                    <a href="<?php echo web_link('donation.php'); ?>"
                       class="nav-item nav-link <?= ($active === 'donation') ? 'active' : '' ?>">
                        Donation
                    </a>
                    <a href="<?php echo web_link('documents.php'); ?>"
                       class="nav-item nav-link <?= ($active === 'documents') ? 'active' : '' ?>">
                       Our Documents
                    </a>
                    <a href="<?php echo web_link('team.php'); ?>"
                       class="nav-item nav-link <?= ($active === 'team') ? 'active' : '' ?>">
                       Our Team
                    </a>
                    <a href="<?php echo site_url('join-us'); ?>"
                       class="nav-item nav-link <?= ($class === 'member_apply') ? 'active' : ''; ?>">
                       Member Apply
                    </a>
                    <!-- Pages Dropdown -->
                    <div class="nav-item dropdown <?= in_array($active, array('gallery','event','feature','blog','blog_article'), true) ? 'active' : '' ?>">
                        <a href="<?php echo web_link('gallery.php'); ?>" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            Pages
                        </a>
                        <div class="dropdown-menu bg-light m-0">
                            <a href="<?php echo web_link('gallery.php'); ?>" class="dropdown-item <?= ($active === 'gallery') ? 'active' : '' ?>">Gallery</a>
                            <a href="<?php echo web_link('event.php'); ?>" class="dropdown-item <?= ($active === 'event') ? 'active' : '' ?>">Event</a>
                            <a href="<?php echo web_link('feature.php'); ?>" class="dropdown-item <?= ($active === 'feature') ? 'active' : '' ?>">Feature</a>
                            <a href="<?php echo site_url('welcome/blog'); ?>" class="dropdown-item <?= ($active === 'blog' || $active === 'blog_article') ? 'active' : '' ?>">Blog</a>
                        </div>
                    </div>

                    <!-- Contact -->
                    <a href="<?php echo web_link('contact.php'); ?>"
                       class="nav-item nav-link <?= ($active === 'contact') ? 'active' : '' ?>">
                        Contact
                    </a>

                </div>

                <!-- Auth Buttons -->
                <div class="d-none d-lg-flex ms-auto align-items-center">
                    <a href="<?php echo site_url('join-us'); ?>" target="_blank" class="btn btn-secondary rounded-pill px-3 py-2 me-3 font-weight-bold shadow-sm">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                    <a href="<?php echo site_url('admin/login'); ?>" target="_blank" class="btn btn-light rounded-pill px-3 py-2 font-weight-bold shadow-sm">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    
                    <div class="ms-4 border-start ps-3 d-flex">
                        <a class="btn btn-square btn-dark ms-2" target="_blank" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-dark ms-2" target="_blank" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-dark ms-2" href="https://youtube.com/@sfofindia?si=SzhqBjwqbZkbisbi" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Mobile Auth Links (Optional, shown in collapse) -->
                <div class="d-lg-none mt-3 pt-3 border-top">
                    <a href="<?php echo site_url('join-us'); ?>" class="btn btn-secondary w-100 mb-2">Register</a>
                    <a href="<?php echo site_url('admin/login'); ?>" class="btn btn-light w-100">Login</a>
                </div>

            </div>
        </nav>
    </div>
</div>


<style>
/* REMOVE background from active nav link */
.navbar .nav-link.active {
    background: transparent !important;
    color: #fff !important;
    font-weight: 600;
    position: relative;
}

/* Optional: underline effect instead of background */
.navbar .nav-link.active::after {
    content: "";
    position: absolute;
    left: 10%;
    bottom: 6px;
    width: 80%;
    height: 2px;
    background-color: #fff;
    border-radius: 2px;
}

/* Dropdown active item (no bg) */
.dropdown-item.active {
    background-color: transparent !important;
    color: #0d6efd;
    font-weight: 600;
}
</style>
