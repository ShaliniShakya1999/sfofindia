<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$active = $CI->router->method;
$class = strtolower((string) $CI->router->fetch_class());
?>

<div class="container-fluid bg-secondary px-0 navbar-shell">
    <div class="nav-bar">
        <nav class="navbar navbar-expand-lg bg-primary navbar-dark px-3 px-lg-4 py-lg-0" aria-label="Primary navigation">

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
                       class="nav-item nav-link nav-donate <?= ($active === 'donation') ? 'active' : '' ?>">
                        <i class="fas fa-heart me-1" aria-hidden="true"></i> Donate
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
                            <a href="<?php echo site_url('blog'); ?>" class="dropdown-item <?= ($active === 'blog' || $active === 'blog_article') ? 'active' : '' ?>">Blog</a>
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
                    <a href="<?php echo site_url('join-us'); ?>" class="btn btn-secondary rounded-pill px-3 py-2 me-2 font-weight-bold shadow-sm">
                        <i class="fas fa-user-plus me-1"></i> Registration
                    </a>
                    <a href="<?php echo site_url('admin/login'); ?>" class="btn btn-light rounded-pill px-3 py-2 font-weight-bold shadow-sm">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    
                    <div class="navbar-social ms-3 ps-3 d-flex align-items-center" aria-label="Social media links">
                        <a class="social-link social-youtube" href="https://youtube.com/@sfofindia" target="_blank" rel="noopener" aria-label="SFOI on YouTube"><i class="fab fa-youtube"></i></a>
                        <a class="social-link social-facebook" href="#" aria-label="SFOI on Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="social-link social-instagram" href="#" aria-label="SFOI on Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Mobile Auth Links (Optional, shown in collapse) -->
                <div class="d-lg-none mt-3 pt-3 border-top">
                    <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-secondary w-100 mb-2"><i class="fas fa-heart me-1"></i> Donate now</a>
                    <a href="<?php echo site_url('join-us'); ?>" class="btn btn-outline-light w-100 mb-2">Registration</a>
                    <a href="<?php echo site_url('admin/login'); ?>" class="btn btn-light w-100">Login</a>
                </div>

            </div>
        </nav>
    </div>
</div>


<style>
.nav-bar {
    width: 100%;
    padding: 0 !important;
    box-shadow: 0 8px 24px rgba(20, 33, 61, .12);
    position: relative;
    z-index: 1030;
    transform: translate3d(0, 0, 0);
    transition: transform .24s ease, box-shadow .24s ease;
    will-change: transform;
}
.nav-bar.navbar-scrolled {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    top: 0;
}
.nav-bar.navbar-hidden {
    transform: translate3d(0, -110%, 0);
}
.navbar {
    width: 100%;
    min-height: 54px;
}
.navbar .navbar-nav {
    align-items: center;
}
.navbar .nav-link {
    padding: .9rem .62rem;
    font-size: .86rem;
    letter-spacing: .01em;
}
.navbar .nav-donate {
    color: #fff !important;
    background: rgba(255, 255, 255, .14);
    border-radius: 999px;
    padding: .55rem .85rem !important;
    margin: 0 .2rem;
    line-height: 1.2;
    display: inline-flex;
    align-items: center;
}
.navbar .nav-donate:hover,
.navbar .nav-donate.active {
    background: #f3b321;
    color: #182848 !important;
}
.navbar-social {
    border-left: 1px solid rgba(255,255,255,.25);
    gap: .4rem;
}
.social-link {
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    font-size: .85rem;
    transition: transform .2s ease, background-color .2s ease;
}
.social-link:hover {
    color: #fff;
    transform: translateY(-2px);
}
.social-youtube { background: #d32f2f; }
.social-facebook { background: #3568b8; }
.social-instagram { background: linear-gradient(135deg, #f9ce34, #ee2a7b 52%, #6228d7); }
@media (max-width: 991.98px) {
    .navbar .nav-link { padding: .7rem .25rem; }
    .navbar .nav-donate { margin: .2rem 0; display: inline-flex; }
    .navbar-social { border-left: 0; padding-left: 0 !important; margin-left: 0 !important; margin-top: .75rem; }
}
/* REMOVE background from active nav link */
.navbar .nav-link.active {
    background: transparent !important;
    color: #fff !important;
    font-weight: 600;
    position: relative;
}
.navbar .nav-link.nav-donate.active {
    background: #f3b321 !important;
    color: #182848 !important;
}
.navbar .nav-link.nav-donate::after {
    display: none;
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
<script>
(function () {
    var navBar = document.querySelector('.nav-bar');
    if (!navBar) {
        return;
    }
    var shell = navBar.closest('.navbar-shell');
    var topBar = document.querySelector('.top-bar');
    var lastScroll = window.pageYOffset || document.documentElement.scrollTop;
    var pauseTimer;
    function updateNavbar() {
        var currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        var scrollDelta = currentScroll - lastScroll;
        var topBarHeight = topBar ? topBar.getBoundingClientRect().height : 0;
        if (currentScroll > topBarHeight) {
            navBar.classList.add('navbar-scrolled');
            if (shell) {
                shell.style.height = navBar.offsetHeight + 'px';
            }
        } else {
            navBar.classList.remove('navbar-scrolled');
            navBar.classList.remove('navbar-hidden');
            if (shell) {
                shell.style.height = '';
            }
        }
        if (scrollDelta > 2 && currentScroll > 80) {
            navBar.classList.add('navbar-hidden');
        } else if (scrollDelta < -2 || currentScroll <= 80) {
            navBar.classList.remove('navbar-hidden');
        }
        window.clearTimeout(pauseTimer);
        pauseTimer = window.setTimeout(function () {
            navBar.classList.remove('navbar-hidden');
        }, 220);
        lastScroll = currentScroll <= 0 ? 0 : currentScroll;
    }
    updateNavbar();
    window.addEventListener('resize', updateNavbar);
    window.addEventListener('scroll', updateNavbar, { passive: true });
}());
</script>
