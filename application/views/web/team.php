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
        $fallback_team = array(
            array(
                'name' => 'Col. S. K. Verma (Retd.)',
                'role' => 'Advisory Council Head',
                'image' => 'img/team-1.jpg',
            ),
            array(
                'name' => 'Adv. Rajesh Sharma',
                'role' => 'Legal Advisor & Trustee',
                'image' => 'img/team-2.jpg',
            ),
            array(
                'name' => 'Dr. Ananya Mishra',
                'role' => 'Medical & Health Coordinator',
                'image' => 'img/team-3.jpg',
            ),
            array(
                'name' => 'Vikramaditya Singh',
                'role' => 'Youth Volunteer Lead',
                'image' => 'img/team-1.jpg',
            ),
            array(
                'name' => 'Pooja Deshmukh',
                'role' => 'Family Outreach Coordinator',
                'image' => 'img/team-2.jpg',
            ),
            array(
                'name' => 'Sanjay Patel',
                'role' => 'Program & Logistics Director',
                'image' => 'img/team-3.jpg',
            ),
        );

        $team_display = array();
        if (!empty($active_members)) {
            foreach ($active_members as $m) {
                $role_title = !empty($m['authority']) && strtolower(trim($m['authority'])) !== 'mambar' && strtolower(trim($m['authority'])) !== 'member'
                    ? trim($m['authority'])
                    : (!empty($m['profession']) ? trim($m['profession']) : 'Active Foundation Member');
                
                $img_path = '';
                if (!empty($m['photo'])) {
                    $img_path = base_url($m['photo']);
                }

                $team_display[] = array(
                    'name' => $m['name'],
                    'role' => $role_title,
                    'image' => $img_path,
                );
            }
        }
        if (empty($team_display)) {
            $team_display = $fallback_team;
        }

        $fb_url = !empty($cms['social_facebook']) ? $cms['social_facebook'] : '#!';
        $tw_url = !empty($cms['social_twitter']) ? $cms['social_twitter'] : '#!';
        $ig_url = !empty($cms['social_instagram']) ? $cms['social_instagram'] : '#!';
        $yt_url = !empty($cms['social_youtube']) ? $cms['social_youtube'] : '#!';
        ?>
        <div class="container-fluid py-5">
            <div class="container">
                <div class="text-center mx-auto wow fadeIn mb-5" data-wow-delay="0.1s" style="max-width: 600px;">
                    <p class="section-title bg-white text-center text-primary px-3">Our Team</p>
                    <h1 class="display-6 mb-3">Dedicated Members Standing with Our Nation's Heroes</h1>
                    <p class="text-muted mb-4">Together with volunteers, donors, and verified members across India, we work tirelessly for the welfare of martyrs' families.</p>
                    <a href="<?php echo site_url('join-us'); ?>" class="btn btn-primary px-4 py-2"><i class="fa fa-user-plus me-2"></i>Apply For Membership</a>
                </div>
                <div class="row g-4">
                    <?php foreach ($team_display as $index => $member): ?>
                        <?php
                        $delay = ($index % 3 === 0) ? '0.1s' : (($index % 3 === 1) ? '0.3s' : '0.5s');
                        $photo_url = !empty($member['image']) 
                            ? (strpos($member['image'], 'http') === 0 ? $member['image'] : (strpos($member['image'], 'assets') === 0 || strpos($member['image'], 'uploads') === 0 ? base_url($member['image']) : web_asset($member['image'])))
                            : web_asset('img/team-' . (($index % 3) + 1) . '.jpg');
                        ?>
                        <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="<?php echo $delay; ?>">
                            <div class="team-item d-flex h-100 p-4 shadow-sm border-radius-lg">
                                <div class="team-detail pe-4 flex-grow-1">
                                    <img class="img-fluid mb-4 rounded" style="height: 180px; width: 100%; object-fit: cover;" src="<?php echo html_escape($photo_url); ?>" alt="<?php echo html_escape($member['name']); ?>" onerror="this.src='<?php echo web_asset('img/team-' . (($index % 3) + 1) . '.jpg'); ?>';">
                                    <h4 class="mb-1"><?php echo html_escape($member['name']); ?></h4>
                                    <span class="text-primary font-weight-bold text-sm"><?php echo html_escape($member['role']); ?></span>
                                </div>
                                <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-3 rounded">
                                    <a class="btn btn-square btn-primary my-1" href="<?php echo html_escape($fb_url); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary my-1" href="<?php echo html_escape($tw_url); ?>" target="_blank"><i class="fab fa-x-twitter"></i></a>
                                    <a class="btn btn-square btn-primary my-1" href="<?php echo html_escape($ig_url); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square btn-primary my-1" href="<?php echo html_escape($yt_url); ?>" target="_blank"><i class="fab fa-youtube"></i></a>
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