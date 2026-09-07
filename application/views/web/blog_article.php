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
            <h1 class="display-3 animated slideInDown">Blog Detail</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('welcome/blog'); ?>">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Post Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Blog Detail Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <!-- Article Content -->
                    <div class="wow fadeInUp" data-wow-delay="0.1s">
                        <img class="img-fluid w-100 rounded mb-5" src="<?php echo base_url(html_escape($article['image'])); ?>" alt="<?php echo html_escape($article['title']); ?>" onerror="this.src='<?php echo base_url('assetsA/img/no-image.png'); ?>';">
                        <div class="d-flex mb-3">
                            <small class="me-3"><i class="far fa-user text-primary me-2"></i><?php echo html_escape($article['postedBy']); ?></small>
                            <small class="me-3"><i class="far fa-folder text-primary me-2"></i><?php echo html_escape($article['subject']); ?></small>
                            <small><i class="far fa-calendar-alt text-primary me-2"></i><?php echo date('M d, Y', strtotime($article['postedDate'])); ?></small>
                        </div>
                        <h1 class="display-5 mb-4"><?php echo html_escape($article['title']); ?></h1>
                        <div class="blog-content text-dark fs-5">
                            <?php echo (string)$article['description']; ?>
                        </div>
                    </div>

                    <!-- Post Share -->
                    <div class="d-flex align-items-center bg-light rounded p-4 mt-5 wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="mb-0 me-3">Share:</h5>
                        <a class="btn btn-square btn-outline-primary rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-primary rounded-circle me-2" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-primary rounded-circle me-2" href=""><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-square btn-outline-primary rounded-circle me-2" href=""><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Search Form -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" placeholder="Keyword">
                            <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">Recent Posts</h3>
                        </div>
                        <?php if (!empty($recent_blogs)): ?>
                            <?php foreach ($recent_blogs as $rb): ?>
                            <div class="d-flex rounded overflow-hidden mb-3 bg-light p-2">
                                <img class="img-fluid" src="<?php echo base_url(html_escape($rb['image'])); ?>" style="width: 100px; height: 80px; object-fit: cover;" alt="recent" onerror="this.src='<?php echo base_url('assetsA/img/no-image.png'); ?>';">
                                <div class="ps-3">
                                    <a href="<?php echo site_url('welcome/blog_article/' . $rb['slug']); ?>" class="h6 d-block mb-2"><?php echo html_escape($rb['title']); ?></a>
                                    <small class="text-uppercase"><?php echo date('M d, Y', strtotime($rb['postedDate'])); ?></small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No other posts.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Tags -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">Categories</h3>
                        </div>
                        <div class="d-flex flex-wrap m-n1">
                            <a href="" class="btn btn-light m-1">NGO News</a>
                            <a href="" class="btn btn-light m-1">Education</a>
                            <a href="" class="btn btn-light m-1">Healthcare</a>
                            <a href="" class="btn btn-light m-1">Memorials</a>
                        </div>
                    </div>

                    <!-- Donation Sidebar -->
                    <div class="bg-primary text-center rounded p-5 wow zoomIn" data-wow-delay="0.1s">
                        <h3 class="text-white mb-4">Support Our Cause</h3>
                        <p class="text-white mb-4">Your small contribution can make a big difference in the lives of martyrs' families.</p>
                        <a href="<?php echo web_link('donation.php'); ?>" class="btn btn-secondary py-3 px-5">Donate Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Detail End -->


    <?php include 'footer.php'; ?>

    <style>
        .blog-content p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
        .section-title-sm::after {
            position: absolute;
            content: "";
            width: 45px;
            height: 2px;
            bottom: 0;
            left: 0;
            background: var(--primary);
        }
    </style>
</body>

</html>
