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
            <h1 class="display-3 animated slideInDown">Our Blog</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Blog Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="section-title bg-white text-center text-primary px-3">Latest News & Stories</p>
                <h1 class="display-6 mb-4">Insights Into Our Mission & Impact</h1>
            </div>
            <div class="row g-4">
                <?php if (!empty($blogs)): ?>
                    <?php foreach ($blogs as $b): ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="blog-item bg-light rounded overflow-hidden">
                            <div class="blog-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?php echo base_url(html_escape($b['image'])); ?>" alt="<?php echo html_escape($b['title']); ?>" onerror="this.src='<?php echo base_url('assetsA/img/no-image.png'); ?>';">
                                <div class="blog-date">
                                    <small class="text-white text-uppercase"><?php echo date('M d, Y', strtotime($b['postedDate'])); ?></small>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex mb-3">
                                    <small class="me-3"><i class="far fa-user text-primary me-2"></i><?php echo html_escape($b['postedBy']); ?></small>
                                    <small><i class="far fa-folder text-primary me-2"></i><?php echo html_escape($b['subject']); ?></small>
                                </div>
                                <h4 class="mb-3"><?php echo html_escape($b['title']); ?></h4>
                                <p><?php echo strip_tags(substr((string)$b['description'], 0, 120)); ?>...</p>
                                <a class="text-uppercase fw-bold" href="<?php echo site_url('welcome/blog_article/' . $b['slug']); ?>">Read More <i class="fa fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No blog posts found at the moment. Please check back later.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Blog End -->


    <?php include 'footer.php'; ?>

    <style>
        .blog-item {
            transition: .5s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog-item:hover {
            margin-top: -10px;
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .08);
        }

        .blog-img img {
            transition: .5s;
        }

        .blog-item:hover .blog-img img {
            transform: scale(1.1);
        }

        .blog-date {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            background: var(--primary);
            border-radius: 5px;
            z-index: 1;
        }

        .blog-item .p-4 {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-item h4 {
            line-height: 1.4;
        }

        .blog-item p {
            flex-grow: 1;
        }
    </style>
</body>

</html>
