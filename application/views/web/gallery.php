<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>

<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

<body>

    <!-- Spinner -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>

    <?php include 'topbar.php'; ?>
    <?php include 'navbar.php'; ?>

    <!-- Page Header -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Gallery </h1>
            <nav>
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo web_link('index.php'); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Gallery </li>
                </ol>
            </nav>
        </div>
    </div>

<?php if (!cms_page_override($cms, 'page_gallery_html')): ?>

    <style>
        :root {
            --orange-color: #da251c;
        }

        .byond-sec1 {
            padding: 80px 0;
        }

        .headline h2 {
            font-size: 2.5rem;
            position: relative;
            margin-bottom: 40px;
        }

        .headline h2 span {
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--orange-color);
        }

        .gallery img {
            width: 100%;
            border-radius: 12px;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .gallery img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(218, 37, 28, 0.4);
        }

        .gallery .col-sm-3 {
            margin-bottom: 25px;
        }
    </style>

    <!-- Gallery Section -->
    <section class="byond-sec1">
        <div class="container">

            <div class="row">
                <div class="col-12 text-center headline">
                    <h2>Gallery <span></span></h2>
                </div>
            </div>


            <!-- Gallery Grid -->
            <div class="row gallery">
                
                <!-- Original Hardcoded Images -->
                <?php 
                $original_images = array(1,2,3,7,5,6,9,4,8,10,12,13,11,14,17,18,15,16,19);
                foreach($original_images as $num): 
                    $path = web_asset("img/sf/$num.jpeg");
                ?>
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="<?php echo html_escape($path); ?>">
                        <img src="<?php echo html_escape($path); ?>" alt="Gallery Image">
                    </a>
                </div>
                <?php endforeach; ?>

                <!-- Dynamic CMS Images -->
                <?php if (!empty($ngom_gallery)): ?>
                    <?php foreach ($ngom_gallery as $item): ?>
                        <div class="col-sm-3 col-6">
                            <a data-fancybox="gallery" href="<?php echo base_url(html_escape($item['image_path'])); ?>" data-caption="<?php echo html_escape($item['title']); ?>">
                                <img src="<?php echo base_url(html_escape($item['image_path'])); ?>" alt="<?php echo html_escape($item['title']); ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
    </section>

<?php endif; ?>

    <?php include 'footer.php'; ?>

    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

</body>

</html>