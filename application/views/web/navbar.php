<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$active = $CI->router->method;
$class = strtolower((string) $CI->router->fetch_class());
?>

<div class="container-fluid px-0 navbar-shell">
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
                        Donate
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
                    <a href="<?php echo site_url('join-us'); ?>" class="btn btn-nav-register me-2">
                        <i class="fas fa-user-plus me-1"></i> Registration
                    </a>
                    <a href="<?php echo site_url('admin/login'); ?>" class="btn btn-nav-login">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    
                    <div class="navbar-social ms-3 ps-3 d-flex align-items-center" aria-label="Social media links">
                        <a class="social-link social-youtube" href="https://youtube.com/@sfofindia" target="_blank" rel="noopener" aria-label="SFOI on YouTube"><i class="fab fa-youtube"></i></a>
                        <a class="social-link social-facebook" href="#" aria-label="SFOI on Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="social-link social-instagram" href="#" aria-label="SFOI on Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Mobile Auth Links (Shown in collapse) -->
                <div class="d-lg-none mt-3 pt-3 border-top">
                    <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-nav-donate-mobile w-100 mb-2">Donate</a>
                    <a href="<?php echo site_url('join-us'); ?>" class="btn btn-nav-register w-100 mb-2">
                        <i class="fas fa-user-plus me-1"></i> Registration
                    </a>
                    <a href="<?php echo site_url('admin/login'); ?>" class="btn btn-nav-login w-100">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </div>

            </div>
        </nav>
    </div>
</div>


<style>
.navbar-shell {
    background: transparent;
    width: 100%;
}
.nav-bar {
    width: 100%;
    padding: 0 !important;
    background: #ffac00 !important;
    box-shadow: 0 4px 14px rgba(20, 33, 61, .1);
    position: relative;
    z-index: 1030;
}
.nav-bar.navbar-scrolled {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    background: #ffac00 !important;
    box-shadow: 0 4px 20px rgba(20, 33, 61, .16);
}
.navbar {
    width: 100%;
    min-height: 54px;
    background: #ffac00 !important;
}
.navbar .navbar-nav {
    align-items: center;
}
.navbar .nav-link {
    padding: .85rem .62rem;
    font-size: .86rem;
    letter-spacing: .01em;
    color: rgba(255, 255, 255, 0.95);
    transition: color 0.15s ease;
}
.navbar .nav-link:hover {
    color: #ffffff;
}

/* Donate button in navigation */
.navbar .nav-donate {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.18);
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 50px;
    padding: .44rem .95rem !important;
    margin: 0 .25rem;
    line-height: 1.2;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
}
.navbar .nav-donate:hover,
.navbar .nav-donate.active {
    background: #1a685b !important;
    border-color: #1a685b !important;
    color: #ffffff !important;
}
.navbar .nav-link.nav-donate::after {
    display: none !important;
}

/* Theme-matched Registration & Login Buttons */
.btn-nav-register {
    background-color: #1a685b;
    color: #ffffff !important;
    border: 1.5px solid #14554a;
    border-radius: 50px;
    padding: 0.44rem 1.05rem;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(26, 104, 91, 0.25);
    transition: background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.btn-nav-register:hover {
    background-color: #134e44;
    border-color: #0f3d35;
    color: #ffffff !important;
    box-shadow: 0 3px 8px rgba(26, 104, 91, 0.35);
}

.btn-nav-login {
    background-color: #ffffff;
    color: #1a685b !important;
    border: 1.5px solid #ffffff;
    border-radius: 50px;
    padding: 0.44rem 1.05rem;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    transition: background-color 0.15s ease, color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.btn-nav-login:hover {
    background-color: #f3fdfa;
    color: #134e44 !important;
    border-color: #e2f4ee;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
}

.btn-nav-donate-mobile {
    background-color: #ffffff;
    color: #1a685b !important;
    border-radius: 50px;
    padding: 0.5rem 1rem;
    border: none;
    font-weight: 700;
    text-decoration: none;
    display: block;
    text-align: center;
    transition: background-color 0.15s ease, color 0.15s ease;
}
.btn-nav-donate-mobile:hover {
    background-color: #1a685b;
    color: #ffffff !important;
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
    transition: opacity 0.15s ease, background-color 0.15s ease;
    opacity: 0.92;
}
.social-link:hover {
    color: #fff;
    opacity: 1;
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

    function updateNavbar() {
        var currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        var topBarHeight = topBar ? topBar.offsetHeight : 0;

        if (currentScroll > topBarHeight) {
            if (!navBar.classList.contains('navbar-scrolled')) {
                if (shell) {
                    shell.style.height = navBar.offsetHeight + 'px';
                }
                navBar.classList.add('navbar-scrolled');
            }
        } else {
            if (navBar.classList.contains('navbar-scrolled')) {
                navBar.classList.remove('navbar-scrolled');
                if (shell) {
                    shell.style.height = '';
                }
            }
        }
    }

    updateNavbar();
    window.addEventListener('resize', function () {
        if (navBar.classList.contains('navbar-scrolled') && shell) {
            shell.style.height = navBar.offsetHeight + 'px';
        }
        updateNavbar();
    });
    window.addEventListener('scroll', updateNavbar, { passive: true });
}());
</script>
