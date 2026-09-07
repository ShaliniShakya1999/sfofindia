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
            <h1 class="display-3 animated slideInDown">Our Team</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>

                    <li class="breadcrumb-item active" aria-current="page">Our Team</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <?php if (!cms_page_override($cms, 'page_team_html')): ?>
        <!-- Team Start -->
        <?php
        $team_members = array(
            array(
                'name' => 'Boris Johnson',
                'role' => 'Founder & CEO',
                'image' => 'img/team-1.jpg',
            ),
            array(
                'name' => 'Donald Pakura',
                'role' => 'Project Manager',
                'image' => 'img/team-2.jpg',
            ),
            array(
                'name' => 'Alexander Bell',
                'role' => 'Volunteer',
                'image' => 'img/team-3.jpg',
            ),
            array(
                'name' => 'Boris Johnson',
                'role' => 'Founder & CEO',
                'image' => 'img/team-1.jpg',
            ),
            array(
                'name' => 'Donald Pakura',
                'role' => 'Project Manager',
                'image' => 'img/team-2.jpg',
            ),
            array(
                'name' => 'Alexander Bell',
                'role' => 'Volunteer',
                'image' => 'img/team-3.jpg',
            ),
        );
        ?>
        <div class="container-fluid py-5">
            <div class="container">
                <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                    <p class="section-title bg-white text-center text-primary px-3">Our Team</p>
                    <h1 class="display-6 mb-4">Meet Our Dedicated Team Members</h1>
                    <a href="<?php echo site_url('join-us'); ?>" class="btn btn-primary px-4 py-2">Apply For Membership</a>
                </div>
                <div class="row g-4">
                    <?php foreach ($team_members as $index => $member): ?>
                        <?php
                        $delay = ($index % 3 === 0) ? '0.1s' : (($index % 3 === 1) ? '0.3s' : '0.5s');
                        ?>
                        <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="<?php echo $delay; ?>">
                            <div class="team-item d-flex h-100 p-4">
                                <div class="team-detail pe-4">
                                    <img class="img-fluid mb-4" src="<?php echo html_escape(web_asset($member['image'])); ?>" alt="<?php echo html_escape($member['name']); ?>">
                                    <h3><?php echo html_escape($member['name']); ?></h3>
                                    <span><?php echo html_escape($member['role']); ?></span>
                                </div>
                                <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                                    <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-x-twitter"></i></a>
                                    <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Team End -->
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</body>

</html>