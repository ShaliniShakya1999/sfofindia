<?php
$currentPage = basename($_SERVER['PHP_SELF']);
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
                    <a href="index.php"
                       class="nav-item nav-link <?= ($currentPage=='index.php')?'active':'' ?>">
                        Home
                    </a>

                    <!-- About -->
                    <a href="about.php"
                       class="nav-item nav-link <?= ($currentPage=='about.php')?'active':'' ?>">
                        About
                    </a>

                    <!-- Service Dropdown -->
                    <div class="nav-item dropdown <?= in_array($currentPage, ['service.php','financial.php','education.php','disability.php','employment.php']) ? 'active' : '' ?>">
                        <a href="service.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            Service
                        </a>
                        <div class="dropdown-menu bg-light m-0">
                            <a href="financial.php" class="dropdown-item <?= ($currentPage=='financial.php')?'active':'' ?>">Financial Assistance</a>
                            <a href="education.php" class="dropdown-item <?= ($currentPage=='education.php')?'active':'' ?>">Children’s Education Support</a>
                            <a href="disability.php" class="dropdown-item <?= ($currentPage=='disability.php')?'active':'' ?>">Medical & Health Care</a>
                            <a href="employment.php" class="dropdown-item <?= ($currentPage=='employment.php')?'active':'' ?>">Employment & Skill Development</a>
                        </div>
                    </div>

                    <!-- Donation -->
                    <a href="donation.php"
                       class="nav-item nav-link <?= ($currentPage=='donation.php')?'active':'' ?>">
                        Donation
                    </a>

                    <!-- Pages Dropdown -->
                    <div class="nav-item dropdown <?= in_array($currentPage, ['gallery.php','event.php','feature.php']) ? 'active' : '' ?>">
                        <a href="gallery.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            Pages
                        </a>
                        <div class="dropdown-menu bg-light m-0">
                            <a href="gallery.php" class="dropdown-item <?= ($currentPage=='gallery.php')?'active':'' ?>">Gallery</a>
                            <a href="event.php" class="dropdown-item <?= ($currentPage=='event.php')?'active':'' ?>">Event</a>
                            <a href="feature.php" class="dropdown-item <?= ($currentPage=='feature.php')?'active':'' ?>">Feature</a>
                        </div>
                    </div>

                    <!-- Contact -->
                    <a href="contact.php"
                       class="nav-item nav-link <?= ($currentPage=='contact.php')?'active':'' ?>">
                        Contact
                    </a>

                </div>

                <!-- Social Icons -->
                <div class="d-none d-lg-flex ms-auto">
                    <a class="btn btn-square btn-dark ms-2"target="_blank" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-dark ms-2" target="_blank" href="#"><i class="fab fa-facebook-f" target="_blank"></i></a>
                    <a class="btn btn-square btn-dark ms-2" href="https://youtube.com/@sfofindia?si=SzhqBjwqbZkbisbi" target="_blank"><i class="fab fa-youtube"></i></a>
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
