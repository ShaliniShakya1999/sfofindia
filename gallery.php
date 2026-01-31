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
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Gallery </li>
                </ol>
            </nav>
        </div>
    </div>

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


            <!-- 1 -->
            <div class="row gallery">
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/1.jpeg">
                        <img src="img/sf/1.jpeg" alt="">
                    </a>
                </div>


                <!-- 2 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/2.jpeg">
                        <img src="img/sf/2.jpeg" alt="">
                    </a>
                </div>

                <!-- 3 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/3.jpeg">
                        <img src="img/sf/3.jpeg" alt="">
                    </a>
                </div>
                
                
                <!-- 4 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/7.jpeg">
                        <img src="img/sf/7.jpeg" alt="">
                    </a>
                </div>
                
                
                <!-- 5 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/5.jpeg">
                        <img src="img/sf/5.jpeg" alt="">
                    </a>
                </div>

                <!-- 6 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/6.jpeg">
                        <img src="img/sf/6.jpeg" alt="">
                    </a>
                </div>
                
                <!-- 7 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/9.jpeg">
                        <img src="img/sf/9.jpeg" alt="">
                    </a>
                </div>
                
                
                <!-- 8 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/4.jpeg">
                        <img src="img/sf/4.jpeg" alt="">
                    </a>
                </div>
                
                <!-- 9 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/8.jpeg">
                        <img src="img/sf/8.jpeg" alt="">
                    </a>
                </div>
                
                <!-- 10 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/10.jpeg">
                        <img src="img/sf/10.jpeg" alt="">
                    </a>
                </div>


                <!-- 11 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/12.jpeg">
                        <img src="img/sf/12.jpeg" alt="">
                    </a>
                </div>
                
                
                <!-- 12 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/13.jpeg">
                        <img src="img/sf/13.jpeg" alt="">
                    </a>
                </div>
                
                <!-- 13 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/11.jpeg">
                        <img src="img/sf/11.jpeg" alt="">
                    </a>
                </div>
                
                <!-- 14 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/14.jpeg">
                        <img src="img/sf/14.jpeg" alt="">
                    </a>
                </div>
                
                <!-- 17 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/17.jpeg">
                        <img src="img/sf/17.jpeg" alt="">
                    </a>
                </div>


                <!-- 18 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/18.jpeg">
                        <img src="img/sf/18.jpeg" alt="">
                    </a>
                </div>

                <!-- 15 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/15.jpeg">
                        <img src="img/sf/15.jpeg" alt="">
                    </a>
                </div>


                <!-- 16 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/16.jpeg">
                        <img src="img/sf/16.jpeg" alt="">
                    </a>
                </div>



                <!-- 19 -->
                <div class="col-sm-3 col-6">
                    <a data-fancybox="gallery" href="img/sf/19.jpeg">
                        <img src="img/sf/19.jpeg" alt="">
                    </a>
                </div>

            </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

</body>

</html>